<?php
/**
 * Created by PhpStorm.
 * User: ALCINDOR LOSTHELVEN
 * Date: 31/03/2018
 * Time: 19:39
 */

namespace app\DefaultApp;

use app\DefaultApp\Models\Configuration;
use app\DefaultApp\Models\Entreprise;
use app\DefaultApp\Models\LotGagnant;
use app\DefaultApp\Models\Tirage;
use app\DefaultApp\Models\Vendeur;
use app\DefaultApp\Models\Vente;
use Exception;
use systeme\Application\Application;

class DefaultApp extends Application
{

    public static function databaseSize()
    {
        $con=self::connection();
        $databaseName=$_SESSION['database']['nom_base'];
        $req="SELECT 
        TABLE_SCHEMA AS DB_Name, 
        count(TABLE_SCHEMA) AS Total_Tables, 
        SUM(TABLE_ROWS) AS Total_Tables_Row, 
        ROUND(sum(data_length + index_length)/1024/1024) AS 'DBSizeMB',
        ROUND(sum( data_free )/ 1024 / 1024) AS 'FreeSpaceMB'
        FROM information_schema.TABLES 
        WHERE TABLE_SCHEMA = '$databaseName'
        GROUP BY TABLE_SCHEMA";
        $stmt=$con->prepare($req);
        $stmt->execute();
        return $stmt->fetchObject();
    }

    public static function findIndexInTableau($el, $tableau)
    {
        foreach ($tableau as $index => $valeur) {
            if ($el == $valeur) {
                return $index;
            }
        }
        return -1;
    }

    //---
    public static function isValide($date_expiration)
    {
        $datejour = date('Y-m-d');
        $datefin = $date_expiration;
        $dfin = explode("-", $datefin);
        $djour = explode("-", $datejour);
        $finab = $dfin[0] . $dfin[1] . $dfin[2];
        $auj = $djour[0] . $djour[1] . $djour[2];
        if ($auj > $finab) {
            //------Abonnement expiré;-------
            //echo "abonnement expiré";
            return false;
        } else {
            //-------Abonnement en cours-----
            //echo "abonnement valide";
            return true;
        }
    }

    public static function difDate2($date1, $date2)
    {
        $date1 = strtotime($date1);
        $date2 = strtotime($date2);
        $diff = ($date1 - $date2); // abs pour avoir la valeur absolute, ainsi éviter d'avoir une différence négative
        $retour = array();

        $tmp = $diff;
        $retour['second'] = $tmp % 60;

        $tmp = floor(($tmp - $retour['second']) / 60);
        $retour['minute'] = $tmp % 60;

        $tmp = floor(($tmp - $retour['minute']) / 60);
        $retour['hour'] = $tmp % 24;

        $tmp = floor(($tmp - $retour['hour']) / 24);
        $retour['day'] = $tmp;

        $dif = $retour['day'];

        return $dif;
    }

    public static function diff_time($t1, $t2)
    {
        $tab = explode(":", $t1);
        $tab2 = explode(":", $t2);
        $h = $tab[0];
        $m = $tab[1];
        $s = $tab[2];
        $h2 = $tab2[0];
        $m2 = $tab2[1];
        $s2 = $tab2[2];

        if ($h2 > $h) {
            $h = $h + 24;
        }
        if ($m2 > $m) {
            $m = $m + 60;
            $h2++;
        }
        if ($s2 > $s) {
            $s = $s + 60;
            $m2++;
        }

        $ht = $h - $h2;
        $mt = $m - $m2;
        $st = $s - $s2;
        if (strlen($ht) == 1) {
            $ht = "0" . $ht;
        }
        if (strlen($mt) == 1) {
            $mt = "0" . $mt;
        }
        if (strlen($st) == 1) {
            $st = "0" . $st;
        }
        return $ht . ":" . $mt . ":" . $st;
    }

    public static function diff_minut($t1, $t2)
    {
        $tab = explode(":", $t1);
        $tab2 = explode(":", $t2);
        $h = $tab[0];
        $m = $tab[1];
        $s = $tab[2];
        $h2 = $tab2[0];
        $m2 = $tab2[1];
        $s2 = $tab2[2];

        if ($h2 > $h) {
            $h = $h + 24;
        }
        if ($m2 > $m) {
            $m = $m + 60;
            $h2++;
        }
        if ($s2 > $s) {
            $s = $s + 60;
            $m2++;
        }

        $ht = $h - $h2;
        $mt = $m - $m2;
        $st = $s - $s2;
        if (strlen($ht) == 1) {
            $ht = "0" . $ht;
        }
        if (strlen($mt) == 1) {
            $mt = "0" . $mt;
        }
        if (strlen($st) == 1) {
            $st = "0" . $st;
        }
        return $mt;
    }

    public static function difDate($date1, $date2)
    {
        $dd1 = explode("/", $date1);
        $dd2 = explode("/", $date2);
        $d1 = mktime(0, 0, 0, $dd1[1], $dd1[0], $dd1[2]);
        $d2 = mktime(0, 0, 0, $dd2[1], $dd2[0], $dd2[2]);
        $dif = abs($d1 - $d2);
        $jour = $dif / 86400;
        return $jour;
    }

    public static function traitementAutomatiqueLotGagnantModifier($id_entreprise, $data, $traiter = "oui")
    {
        $loTG = new LotGagnant();
        $md=$loTG->deleteParDateTirage($data->date, $data->tirage, $id_entreprise);
        if($md=="ok") {
            if ($loTG->existe($data->date, $data->tirage, $id_entreprise) !== "ok") {
                $con = \app\DefaultApp\DefaultApp::connection();
                $t = new Tirage();
                $lt = $t->listerParEntreprise2($id_entreprise, ucfirst($data->tirage));
                if ($lt != null) {
                    if ($lt->automatique == 'oui') {
                        $data->tirage = $lt->tirage;
                        $con->beginTransaction();
                        try {
                            $v = new \app\DefaultApp\Models\LotGagnant();
                            $v->remplire((array)$data);
                            $date = date("Y-m-d");
                            $demEli = Vente::listeDemmandeElimination2($id_entreprise);
                            if (count($demEli) > 0) {
                                //eliminer les fiche en demmande elimination
                                foreach ($demEli as $dme) {
                                    Vente::eliminerFiche($dme->id);
                                }
                            }
                            $heure = date("H:i");
                            $ti = Tirage::rechercherParNom($data->tirage, $id_entreprise);
                            if ($data->date == $date) {
                                if (Tirage::isTirageEncour($data->tirage, $id_entreprise)) {
                                    echo "\r\nSG : Imposible d'ajouter le lot gagnant, le tirage choisie est en cours\r\n";
                                    return;
                                }
                                if ($heure < $ti->heure_fermeture) {
                                    echo "\r\nSG : Imposible d'ajouter le lot gagnant heure inccorect\r\n";
                                    return;
                                }
                            }
                            $lot1 = intval($data->lot1);
                            $lot2 = intval($data->lot2);
                            $lot3 = intval($data->lot3);
                            $loto3 = intval($data->loto3);

                            if ($lot1 > 99 || $lot1 < 0) {
                                echo "1er lot incorrect";
                                return;
                            }

                            if (strlen($lot1) == 1) {
                                $lot1 = "0" . $lot1;
                            }

                            if ($lot2 > 99 || $lot2 < 0) {
                                echo "2em lot incorrect";
                                return;
                            }

                            if (strlen($lot2) == 1) {
                                $lot2 = "0" . $lot2;
                            }

                            if ($lot3 > 99 || $lot3 < 0) {
                                echo "3em lot incorrect";
                                return;
                            }

                            if (strlen($lot3) == 1) {
                                $lot3 = "0" . $lot3;
                            }

                            if ($loto3 > 9 || $loto3 < 0) {
                                echo "3em lot incorrect";
                                return;
                            }

                            $v->lot1 = $lot1;
                            $v->lot2 = $lot2;
                            $v->lot3 = $lot3;
                            $v->loto3 = $loto3;

                            $borlette = array(
                                "lot1" => $lot1,
                                "lot2" => $lot2,
                                "lot3" => $lot3
                            );

                            $loto4 = array(
                                "option1" => $lot2 . "" . $lot3,
                                "option1_inverse" => $lot3 . "" . $lot2,

                                "option2" => $lot1 . "" . $lot2,
                                "option2_inverse" => $lot2 . "" . $lot1,

                                "option3" => $lot1 . "" . $lot3,
                                "option3_inverse" => $lot3 . "" . $lot1,
                            );

                            $loto5 = array(
                                "option1" => $loto3 . $lot1 . "" . $lot2,
                                "option2" => $loto3 . $lot1 . "" . $lot3,
                                "option3" => substr($lot1, 1, 1) . "" . $lot2 . "" . $lot3
                            );

                            $mariaj = array(
                                $lot1 . "*" . $lot2,
                                $lot2 . "*" . $lot1,

                                $lot1 . "*" . $lot3,
                                $lot3 . "*" . $lot1,

                                $lot2 . "*" . $lot3,
                                $lot3 . "*" . $lot2,
                            );

                            $v->borlette = json_encode($borlette);
                            $v->loto4 = json_encode($loto4);
                            $v->loto5 = json_encode($loto5);
                            $v->mariaj = json_encode($mariaj);
                            $v->loto3 = $v->loto3 . "" . $v->lot1;
                            if ($traiter == "oui") {
                                $v->traiter = "oui";
                            } else {
                                $v->traiter = "non";
                            }

                            $m = $v->add1($id_entreprise);
                            if ($m == "ok") {
                                Vente::updateBilletForLotGagnantModifier($data->date, $data->tirage, $id_entreprise);
                                Vente::updateCommisionAndBalanceVendeur123($id_entreprise, $data->date, $data->tirage);
                                $en = new \app\DefaultApp\Models\Entreprise();
                                $en = $en->findById($id_entreprise);
                                if ($en->cash == 'oui') {
                                    Vente::updateBalanceClient($id_entreprise, $data->date, $data->tirage);
                                }
                                $con->commit();
                            } else {
                                $con->rollBack();
                                echo $m;
                            }
                        } catch (Exception $ex) {
                            $con->rollBack();
                            echo $ex->getMessage();
                        }
                    }
                }
            }
        }
    }

    public static function traitementAutomatiqueLotGagnant($id_entreprise, $data, $traiter = "oui")
    {
        $loTG = new LotGagnant();
        if ($loTG->existe($data->date, $data->tirage, $id_entreprise) !== "ok") {
            $con = \app\DefaultApp\DefaultApp::connection();
            $t = new Tirage();
            $lt = $t->listerParEntreprise2($id_entreprise, ucfirst($data->tirage));
            if ($lt != null) {
                if ($lt->automatique == 'oui') {
                    $data->tirage = $lt->tirage;
                    $con->beginTransaction();
                    try {
                        $v = new \app\DefaultApp\Models\LotGagnant();
                        $v->remplire((array)$data);
                        $date = date("Y-m-d");
                        $demEli = Vente::listeDemmandeElimination2($id_entreprise);
                        if (count($demEli) > 0) {
                            //eliminer les fiche en demmande elimination
                            foreach ($demEli as $dme) {
                                Vente::eliminerFiche($dme->id);
                            }
                        }
                        $heure = date("H:i");
                        $ti = Tirage::rechercherParNom($data->tirage, $id_entreprise);
                        if ($data->date == $date) {
                            if (Tirage::isTirageEncour($data->tirage, $id_entreprise)) {
                                echo "\r\nSG : Imposible d'ajouter le lot gagnant, le tirage choisie est en cours\r\n";
                                return;
                            }
                            if ($heure < $ti->heure_fermeture) {
                                echo "\r\nSG : Imposible d'ajouter le lot gagnant heure inccorect\r\n";
                                return;
                            }
                        }
                        $lot1 = intval($data->lot1);
                        $lot2 = intval($data->lot2);
                        $lot3 = intval($data->lot3);
                        $loto3 = intval($data->loto3);

                        if ($lot1 > 99 || $lot1 < 0) {
                            echo "1er lot incorrect";
                            return;
                        }

                        if (strlen($lot1) == 1) {
                            $lot1 = "0" . $lot1;
                        }

                        if ($lot2 > 99 || $lot2 < 0) {
                            echo "2em lot incorrect";
                            return;
                        }

                        if (strlen($lot2) == 1) {
                            $lot2 = "0" . $lot2;
                        }

                        if ($lot3 > 99 || $lot3 < 0) {
                            echo "3em lot incorrect";
                            return;
                        }

                        if (strlen($lot3) == 1) {
                            $lot3 = "0" . $lot3;
                        }

                        if ($loto3 > 9 || $loto3 < 0) {
                            echo "3em lot incorrect";
                            return;
                        }

                        $v->lot1 = $lot1;
                        $v->lot2 = $lot2;
                        $v->lot3 = $lot3;
                        $v->loto3 = $loto3;

                        $borlette = array(
                            "lot1" => $lot1,
                            "lot2" => $lot2,
                            "lot3" => $lot3
                        );

                        $loto4 = array(
                            "option1" => $lot2 . "" . $lot3,
                            "option1_inverse" => $lot3 . "" . $lot2,

                            "option2" => $lot1 . "" . $lot2,
                            "option2_inverse" => $lot2 . "" . $lot1,

                            "option3" => $lot1 . "" . $lot3,
                            "option3_inverse" => $lot3 . "" . $lot1,
                        );

                        $loto5 = array(
                            "option1" => $loto3 . $lot1 . "" . $lot2,
                            "option2" => $loto3 . $lot1 . "" . $lot3,
                            "option3" => substr($lot1, 1, 1) . "" . $lot2 . "" . $lot3
                        );

                        $mariaj = array(
                            $lot1 . "*" . $lot2,
                            $lot2 . "*" . $lot1,

                            $lot1 . "*" . $lot3,
                            $lot3 . "*" . $lot1,

                            $lot2 . "*" . $lot3,
                            $lot3 . "*" . $lot2,
                        );

                        $v->borlette = json_encode($borlette);
                        $v->loto4 = json_encode($loto4);
                        $v->loto5 = json_encode($loto5);
                        $v->mariaj = json_encode($mariaj);
                        $v->loto3 = $v->loto3 . "" . $v->lot1;
                        if ($traiter == "oui") {
                            $v->traiter = "oui";
                        } else {
                            $v->traiter = "non";
                        }
                        $m = $v->add1($id_entreprise);
                        if ($m == "ok") {
                            Vente::updateBilletForLotGagnant($data->date, $data->tirage, $id_entreprise);
                            Vente::updateCommisionAndBalanceVendeur123($id_entreprise, $data->date, $data->tirage);
                            $en = new \app\DefaultApp\Models\Entreprise();
                            $en = $en->findById($id_entreprise);
                            if ($en->cash == 'oui') {
                                Vente::updateBalanceClient($id_entreprise, $data->date, $data->tirage);
                            }
                            $con->commit();
                        } else {
                            $con->rollBack();
                            echo $m;
                        }
                    } catch (Exception $ex) {
                        $con->rollBack();
                        echo $ex->getMessage();
                    }
                }
            }
        }
    }

    public static function traitementAutomatiqueLotGagnantMega($id_entreprise, $boules, $tirage, $date1)
    {
        try {
            $con = \app\DefaultApp\DefaultApp::connection();
            $con->beginTransaction();
            set_time_limit(10000);
            $date = date("Y-m-d");
            if ($date1 > $date) {
                return "Date incorrect, la date doit etre aujourd'hui ou hier";
            }
            $v = new LotGagnant();
            $v->id_entreprise = $id_entreprise;
            $v->date = $date1;
            $v->lot1 = $boules[0] . "," . $boules[1] . "," . $boules[2];
            $v->loto3 = $v->lot1;
            $v->lot2 = $boules[3] . "," . $boules[4];
            $v->lot3 = $boules[5];
            $v->tirage = $tirage;
            $mv = $v->add1($id_entreprise);
            if ($mv == "ok") {
                $lotGagnant = new LotGagnant();
                $lg = $lotGagnant->rechercherParDateTirage($date1, $tirage, $id_entreprise);
                if ($lg != null) {
                    $listeVente = Vente::listeParTirageDateMegaMilion($id_entreprise, $date1, $tirage);
                    foreach ($listeVente as $index => $v) {
                        if ($v->tirage == "Mega Millions NYC") {
                            $gain = "non";
                            $totalGain = 0;
                            $paris = json_decode($v->paris);
                            //parcourir list des paris pour voir les gagnant
                            foreach ($paris as $i => $p) {
                                if ($p->tirage == "Mega Millions NYC" && $p->codeJeux == "100:MegaM") {
                                    $boules1 = $boules;
                                    array_pop($boules1);
                                    $bBonus = end($boules);

                                    $mise = intval($p->mise);
                                    $pboules = explode(",", $p->pari);
                                    $b1 = $pboules[0];
                                    $b2 = $pboules[1];
                                    $b3 = $pboules[2];
                                    $b4 = $pboules[3];
                                    $b5 = $pboules[4];
                                    $bonus = $pboules[5];

                                    if ($mise == 200) {
                                        $prime1 = 3000000;
                                        $prime2 = 4000;
                                        $prime3 = 500;
                                        $prime4 = 200;
                                        $prime5 = 25;
                                    } else {
                                        $prime1 = (3000000 * $mise) / 200;
                                        $prime2 = (4000 * $mise) / 200;
                                        $prime3 = (500 * $mise) / 200;
                                        $prime4 = (200 * $mise) / 200;
                                        $prime5 = (25 * $mise) / 200;
                                    }

                                    $index1 = DefaultApp::findIndexInTableau($b1, $boules1);
                                    if ($index1 !== -1) {
                                        unset($boules1[$index1]);
                                    }

                                    $index2 = DefaultApp::findIndexInTableau($b2, $boules1);
                                    if ($index2 !== -1) {
                                        unset($boules1[$index2]);
                                    }

                                    $index3 = DefaultApp::findIndexInTableau($b3, $boules1);
                                    if ($index3 !== -1) {
                                        unset($boules1[$index3]);
                                    }

                                    $index4 = DefaultApp::findIndexInTableau($b4, $boules1);
                                    if ($index4 !== -1) {
                                        unset($boules1[$index4]);
                                    }

                                    $index5 = DefaultApp::findIndexInTableau($b5, $boules1);
                                    if ($index5 !== -1) {
                                        unset($boules1[$index5]);
                                    }

                                    //si gain dans 5 boules
                                    if (count($boules1) == 0) {
                                        $gain = 'oui';
                                        $paris[$i]->lot = "gain dans 5 boule";
                                        $paris[$i]->montant = $prime1;
                                        $totalGain += $prime1;
                                        $paris[$i]->gain = $gain;
                                    } elseif (count($boules1) == 1 && $bBonus == $bonus) {
                                        $gain = 'oui';
                                        $paris[$i]->lot = "gain dans 4 boules + bonus";
                                        $paris[$i]->montant = $prime2;
                                        $totalGain += $prime2;
                                        $paris[$i]->gain = $gain;
                                    } elseif (count($boules1) == 1) {
                                        goto pagain;
                                    } elseif (count($boules1) == 2) {
                                        $gain = 'oui';
                                        $paris[$i]->lot = "gain dans 3 boules";
                                        $paris[$i]->montant = $prime3;
                                        $totalGain += $prime3;
                                        $paris[$i]->gain = $gain;
                                    } elseif (count($boules1) == 3) {
                                        $gain = 'oui';
                                        $paris[$i]->lot = "gain dans 2 boules";
                                        $paris[$i]->montant = $prime4;
                                        $totalGain += $prime4;
                                        $paris[$i]->gain = $gain;
                                    } elseif (count($boules1) == 4 && $bBonus == $bonus) {
                                        $gain = 'oui';
                                        $paris[$i]->lot = "gain dans 1 boules + bonus";
                                        $paris[$i]->montant = $prime5;
                                        $totalGain += $prime5;
                                        $paris[$i]->gain = $gain;
                                    } elseif (count($boules1) == 4) {
                                        goto  pagain;
                                    } else {
                                        pagain:
                                        $paris[$i]->lot = "";
                                        $paris[$i]->montant = 0;
                                        $paris[$i]->gain = "non";
                                    }

                                }
                            }
                            if ($gain == "oui") {
                                $listeVente[$index]->paris = json_encode($paris);
                                $listeVente[$index]->total_gain = $totalGain;
                                $listeVente[$index]->gain = $gain;
                                $listeVente[$index]->payer = 'non';
                                $listeVente[$index]->tire = "oui";
                            } else {
                                $listeVente[$index]->paris = json_encode($paris);
                                $listeVente[$index]->total_gain = "0";
                                $listeVente[$index]->gain = "non";
                                $listeVente[$index]->payer = 'non';
                                $listeVente[$index]->tire = "oui";
                            }
                            $listeVente[$index]->update();
                        }
                    }
                    Vente::updateCommisionAndBalanceVendeur1($id_entreprise);
                    $en = new \app\DefaultApp\Models\Entreprise();
                    $en = $en->findById($id_entreprise);
                    if ($en->cash == 'oui') {
                        Vente::updateBalanceClientMega($id_entreprise, $date1, $tirage);
                    }
                    $con->commit();
                    return $mv;
                } else {
                    $con->rollBack();
                    return "tirage non trouvé sur le système";
                }
            } else {
                $con->rollBack();
                return $mv;
            }
        } catch (Exception $ex) {
            $con->rollBack();
            return $ex->getMessage();
        }
    }

    public static function traitementAutomatiqueLotGagnantLotoMax($id_entreprise, $boules, $tirage, $date1)
    {
        try {
            $con = \app\DefaultApp\DefaultApp::connection();
            $con->beginTransaction();
            set_time_limit(10000);
            $date = date("Y-m-d");
            if ($date1 > $date) {
                return "Date incorrect, la date doit etre aujourd'hui ou hier";
            }
            $v = new LotGagnant();
            $v->id_entreprise = $id_entreprise;
            $v->date = $date1;
            $v->lot1 = $boules[0] . "," . $boules[1] . "," . $boules[2];
            $v->loto3 = $v->lot1;
            $v->lot2 = $boules[3] . "," . $boules[4] . "," . $boules[5];
            $v->lot3 = $boules[6] . "," . $boules[7];
            $v->tirage = $tirage;
            $mv = $v->add1($id_entreprise);
            if ($mv == "ok") {
                $lotGagnant = new LotGagnant();
                $lg = $lotGagnant->rechercherParDateTirage($date1, $tirage, $id_entreprise);
                if ($lg != null) {
                    $listeVente = Vente::listeParTirageDateMegaMilion($id_entreprise, $date1, $tirage);
                    foreach ($listeVente as $index => $v) {
                        if ($v->tirage == "Lotto Max") {
                            $gain = "non";
                            $totalGain = 0;
                            $paris = json_decode($v->paris);
                            //parcourir list des paris pour voir les gagnant
                            foreach ($paris as $i => $p) {
                                if ($p->tirage == "Lotto Max" && $p->codeJeux == "102:Lotomax") {
                                    $boules1 = $boules;
                                    array_pop($boules1);
                                    $bBonus = end($boules);

                                    $mise = intval($p->mise);
                                    $pboules = explode(",", $p->pari);
                                    $b1 = $pboules[0];
                                    $b2 = $pboules[1];
                                    $b3 = $pboules[2];
                                    $b4 = $pboules[3];
                                    $b5 = $pboules[4];
                                    $b6 = $pboules[5];
                                    $b7 = $pboules[6];
                                    $bonus = $pboules[7];

                                    //if ($mise == 200) {
                                    $prime1 = 5000000;
                                    $prime2 = 12331;
                                    $prime3 = 1200;
                                    $prime4 = 500;
                                    $prime5 = 10;
                                    /*} else {
                                        $prime1 = (3000000 * $mise) / 200;
                                        $prime2 = (4000 * $mise) / 200;
                                        $prime3 = (500 * $mise) / 200;
                                        $prime4 = (200 * $mise) / 200;
                                        $prime5 = (25 * $mise) / 200;
                                    }*/

                                    $index1 = DefaultApp::findIndexInTableau($b1, $boules1);
                                    if ($index1 !== -1) {
                                        unset($boules1[$index1]);
                                    }

                                    $index2 = DefaultApp::findIndexInTableau($b2, $boules1);
                                    if ($index2 !== -1) {
                                        unset($boules1[$index2]);
                                    }

                                    $index3 = DefaultApp::findIndexInTableau($b3, $boules1);
                                    if ($index3 !== -1) {
                                        unset($boules1[$index3]);
                                    }

                                    $index4 = DefaultApp::findIndexInTableau($b4, $boules1);
                                    if ($index4 !== -1) {
                                        unset($boules1[$index4]);
                                    }

                                    $index5 = DefaultApp::findIndexInTableau($b5, $boules1);
                                    if ($index5 !== -1) {
                                        unset($boules1[$index5]);
                                    }

                                    $index6 = DefaultApp::findIndexInTableau($b6, $boules1);
                                    if ($index6 !== -1) {
                                        unset($boules1[$index6]);
                                    }

                                    $index7 = DefaultApp::findIndexInTableau($b7, $boules1);
                                    if ($index7 !== -1) {
                                        unset($boules1[$index7]);
                                    }

                                    //si gain dans 7 boules
                                    if (count($boules1) == 0) {
                                        $gain = 'oui';
                                        $paris[$i]->lot = "gain dans 7 boule";
                                        $paris[$i]->montant = $prime1;
                                        $totalGain += $prime1;
                                        $paris[$i]->gain = $gain;
                                    } elseif (count($boules1) == 1 && $bBonus == $bonus) {
                                        $gain = 'oui';
                                        $paris[$i]->lot = "gain dans 6 boules + bonus";
                                        $paris[$i]->montant = $prime2;
                                        $totalGain += $prime2;
                                        $paris[$i]->gain = $gain;
                                    } elseif (count($boules1) == 1) {
                                        goto pagain;
                                    } elseif (count($boules1) == 2) {
                                        $gain = 'oui';
                                        $paris[$i]->lot = "gain dans 5 boules";
                                        $paris[$i]->montant = $prime3;
                                        $totalGain += $prime3;
                                        $paris[$i]->gain = $gain;
                                    } elseif (count($boules1) == 3) {
                                        $gain = 'oui';
                                        $paris[$i]->lot = "gain dans 4 boules";
                                        $paris[$i]->montant = $prime4;
                                        $totalGain += $prime4;
                                        $paris[$i]->gain = $gain;
                                    } elseif (count($boules1) == 4) {
                                        $gain = 'oui';
                                        $paris[$i]->lot = "gain dans 3 boules + bonus";
                                        $paris[$i]->montant = $prime5;
                                        $totalGain += $prime5;
                                        $paris[$i]->gain = $gain;
                                    } else {
                                        pagain:
                                        $paris[$i]->lot = "";
                                        $paris[$i]->montant = 0;
                                        $paris[$i]->gain = "non";
                                    }

                                }
                            }
                            if ($gain == "oui") {
                                $listeVente[$index]->paris = json_encode($paris);
                                $listeVente[$index]->total_gain = $totalGain;
                                $listeVente[$index]->gain = $gain;
                                $listeVente[$index]->payer = 'non';
                                $listeVente[$index]->tire = "oui";
                            } else {
                                $listeVente[$index]->paris = json_encode($paris);
                                $listeVente[$index]->total_gain = "0";
                                $listeVente[$index]->gain = "non";
                                $listeVente[$index]->payer = 'non';
                                $listeVente[$index]->tire = "oui";
                            }
                            $listeVente[$index]->update();
                        }
                    }
                    Vente::updateCommisionAndBalanceVendeur1($id_entreprise);
                    $en = new \app\DefaultApp\Models\Entreprise();
                    $en = $en->findById($id_entreprise);
                    if ($en->cash == 'oui') {
                        Vente::updateBalanceClientMega($id_entreprise, $date1, $tirage);
                    }
                    $con->commit();
                    return $mv;
                } else {
                    $con->rollBack();
                    return "tirage non trouvé sur le système";
                }
            } else {
                $con->rollBack();
                return $mv;
            }
        } catch (Exception $ex) {
            $con->rollBack();
            return $ex->getMessage();
        }
    }

    public static function traitementAutomatiqueLotGagnant649($id_entreprise, $boules, $tirage, $date1)
    {
        try {
            $con = \app\DefaultApp\DefaultApp::connection();
            $con->beginTransaction();
            set_time_limit(10000);
            $date = date("Y-m-d");
            if ($date1 > $date) {
                return "Date incorrect, la date doit etre aujourd'hui ou hier";
            }
            $v = new LotGagnant();
            $v->id_entreprise = $id_entreprise;
            $v->date = $date1;
            $v->lot1 = $boules[0] . "," . $boules[1] . "," . $boules[2];
            $v->loto3 = $v->lot1;
            $v->lot2 = $boules[3] . "," . $boules[4];
            $v->lot3 = $boules[5] . "," . $boules[6];
            $v->tirage = $tirage;
            $mv = $v->add1($id_entreprise);
            if ($mv == "ok") {
                $lotGagnant = new LotGagnant();
                $lg = $lotGagnant->rechercherParDateTirage($date1, $tirage, $id_entreprise);
                if ($lg != null) {
                    $listeVente = Vente::listeParTirageDateMegaMilion($id_entreprise, $date1, $tirage);
                    foreach ($listeVente as $index => $v) {
                        if ($v->tirage == "Lotto 6/49") {
                            $gain = "non";
                            $totalGain = 0;
                            $paris = json_decode($v->paris);
                            //parcourir list des paris pour voir les gagnant
                            foreach ($paris as $i => $p) {
                                if ($p->tirage == "Lotto 6/49" && $p->codeJeux == "103:Loto649") {
                                    $boules1 = $boules;
                                    array_pop($boules1);
                                    $bBonus = end($boules);

                                    $mise = intval($p->mise);
                                    $pboules = explode(",", $p->pari);

                                    $b1 = $pboules[0];
                                    $b2 = $pboules[1];
                                    $b3 = $pboules[2];
                                    $b4 = $pboules[3];
                                    $b5 = $pboules[4];
                                    $b6 = $pboules[5];
                                    $bonus = $pboules[6];

                                    //if ($mise == 200) {
                                    $prime1 = 2500000;
                                    $prime2 = 12331;
                                    $prime3 = 1000;
                                    $prime4 = 400;
                                    $prime5 = 10;
                                    /*} else {
                                        $prime1 = (3000000 * $mise) / 200;
                                        $prime2 = (4000 * $mise) / 200;
                                        $prime3 = (500 * $mise) / 200;
                                        $prime4 = (200 * $mise) / 200;
                                        $prime5 = (25 * $mise) / 200;
                                    }*/

                                    $index1 = DefaultApp::findIndexInTableau($b1, $boules1);
                                    if ($index1 !== -1) {
                                        unset($boules1[$index1]);
                                    }

                                    $index2 = DefaultApp::findIndexInTableau($b2, $boules1);
                                    if ($index2 !== -1) {
                                        unset($boules1[$index2]);
                                    }

                                    $index3 = DefaultApp::findIndexInTableau($b3, $boules1);
                                    if ($index3 !== -1) {
                                        unset($boules1[$index3]);
                                    }

                                    $index4 = DefaultApp::findIndexInTableau($b4, $boules1);
                                    if ($index4 !== -1) {
                                        unset($boules1[$index4]);
                                    }

                                    $index5 = DefaultApp::findIndexInTableau($b5, $boules1);
                                    if ($index5 !== -1) {
                                        unset($boules1[$index5]);
                                    }

                                    $index6 = DefaultApp::findIndexInTableau($b6, $boules1);
                                    if ($index6 !== -1) {
                                        unset($boules1[$index6]);
                                    }

                                    //si gain dans 6 boules
                                    if (count($boules1) == 0) {
                                        $gain = 'oui';
                                        $paris[$i]->lot = "gain dans 6 boule";
                                        $paris[$i]->montant = $prime1;
                                        $totalGain += $prime1;
                                        $paris[$i]->gain = $gain;
                                    } elseif (count($boules1) == 1 && $bBonus == $bonus) {
                                        $gain = 'oui';
                                        $paris[$i]->lot = "gain dans 5 boules + bonus";
                                        $paris[$i]->montant = $prime2;
                                        $totalGain += $prime2;
                                        $paris[$i]->gain = $gain;
                                    } elseif (count($boules1) == 1) {
                                        goto pagain;
                                    } elseif (count($boules1) == 2) {
                                        $gain = 'oui';
                                        $paris[$i]->lot = "gain dans 4 boules";
                                        $paris[$i]->montant = $prime3;
                                        $totalGain += $prime3;
                                        $paris[$i]->gain = $gain;
                                    } elseif (count($boules1) == 3) {
                                        $gain = 'oui';
                                        $paris[$i]->lot = "gain dans 3 boules";
                                        $paris[$i]->montant = $prime4;
                                        $totalGain += $prime4;
                                        $paris[$i]->gain = $gain;
                                    } elseif (count($boules1) == 4) {
                                        $gain = 'oui';
                                        $paris[$i]->lot = "gain dans 2 boules";
                                        $paris[$i]->montant = $prime5;
                                        $totalGain += $prime5;
                                        $paris[$i]->gain = $gain;
                                    } else {
                                        pagain:
                                        $paris[$i]->lot = "";
                                        $paris[$i]->montant = 0;
                                        $paris[$i]->gain = "non";
                                    }

                                }
                            }
                            if ($gain == "oui") {
                                $listeVente[$index]->paris = json_encode($paris);
                                $listeVente[$index]->total_gain = $totalGain;
                                $listeVente[$index]->gain = $gain;
                                $listeVente[$index]->payer = 'non';
                                $listeVente[$index]->tire = "oui";
                            } else {
                                $listeVente[$index]->paris = json_encode($paris);
                                $listeVente[$index]->total_gain = "0";
                                $listeVente[$index]->gain = "non";
                                $listeVente[$index]->payer = 'non';
                                $listeVente[$index]->tire = "oui";
                            }
                            $listeVente[$index]->update();
                        }
                    }
                    Vente::updateCommisionAndBalanceVendeur1($id_entreprise);
                    $en = new \app\DefaultApp\Models\Entreprise();
                    $en = $en->findById($id_entreprise);
                    if ($en->cash == 'oui') {
                        Vente::updateBalanceClientMega($id_entreprise, $date1, $tirage);
                    }
                    $con->commit();
                    return $mv;
                } else {
                    $con->rollBack();
                    return "tirage non trouvé sur le système";
                }
            } else {
                $con->rollBack();
                return $mv;
            }
        } catch (Exception $ex) {
            $con->rollBack();
            return $ex->getMessage();
        }
    }

    public static function traitementAutomatiqueLotGagnantPick10($id_entreprise, $boules, $tirage, $date1)
    {
        $con = \app\DefaultApp\DefaultApp::connection();
        $con->beginTransaction();
        set_time_limit(10000);
        $date = date("Y-m-d");
        if ($date1 > $date) {
            echo "Date incorrect, la date doit etre aujourd'hui ou hier";
            return;
        }
        $v = new LotGagnant();
        $v->id_entreprise = $id_entreprise;
        $v->tirage = $tirage;
        $v->date = $date;
        $v->lot1 = $boules[0] . "," . $boules[1] . "," . $boules[2] . "," . $boules[3] . "," . $boules[4] . "," . $boules[5] . "," .
            $boules[6] . "," . $boules[7] . "," . $boules[8] . "," . $boules[9];
        $v->loto3 = $v->lot1;
        $v->lot2 = $boules[10] . "," . $boules[11] . "," . $boules[12] . "," . $boules[13] . "," . $boules[14];
        $v->lot3 = $boules[15] . "," . $boules[16] . "," . $boules[17] . "," . $boules[18] . "," . $boules[19];

        $mv = $v->add1($id_entreprise);
        if ($mv == "ok") {
            $lotGagnant = new LotGagnant();
            $lg = $lotGagnant->rechercherParDateTirage($date1, $tirage, $id_entreprise);
            if ($lg != null) {
                $listeVente = Vente::listeParTirageDate($id_entreprise, $date1, $tirage);
                foreach ($listeVente as $index => $v) {
                    if ($v->tirage == "Pick10 NYC") {
                        $gain = "non";
                        $totalGain = 0;
                        $paris = json_decode($v->paris);
                        //parcourir list des paris pour voir les gagnant
                        foreach ($paris as $i => $p) {
                            if ($p->tirage == "Pick10 NYC" && $p->codeJeux == "101:Pick10") {
                                $boules1 = $boules;
                                $mise = intval($p->mise);
                                $pboules = explode(",", $p->pari);
                                $b1 = $pboules[0];
                                $b2 = $pboules[1];
                                $b3 = $pboules[2];
                                $b4 = $pboules[3];
                                $b5 = $pboules[4];
                                $b6 = $pboules[5];
                                $b7 = $pboules[6];
                                $b8 = $pboules[7];
                                $b9 = $pboules[8];
                                $b10 = $pboules[9];

                                if ($mise == 100) {
                                    $prime1 = 500000;
                                    $prime2 = 6000;
                                    $prime3 = 300;
                                    $prime4 = 40;
                                    $prime5 = 10;
                                } else {
                                    $prime1 = (500000 * $mise) / 100;
                                    $prime2 = (6000 * $mise) / 100;
                                    $prime3 = (300 * $mise) / 100;
                                    $prime4 = (40 * $mise) / 100;
                                    $prime5 = (10 * $mise) / 100;
                                }


                                $index1 = DefaultApp::findIndexInTableau($b1, $boules1);
                                if ($index1 !== -1) {
                                    unset($boules1[$index1]);
                                }

                                $index2 = DefaultApp::findIndexInTableau($b2, $boules1);
                                if ($index2 !== -1) {
                                    unset($boules1[$index2]);
                                }

                                $index3 = DefaultApp::findIndexInTableau($b3, $boules1);
                                if ($index3 !== -1) {
                                    unset($boules1[$index3]);
                                }

                                $index4 = DefaultApp::findIndexInTableau($b4, $boules1);
                                if ($index4 !== -1) {
                                    unset($boules1[$index4]);
                                }

                                $index5 = DefaultApp::findIndexInTableau($b5, $boules1);
                                if ($index5 !== -1) {
                                    unset($boules1[$index5]);
                                }

                                $index6 = DefaultApp::findIndexInTableau($b6, $boules1);
                                if ($index6 !== -1) {
                                    unset($boules1[$index6]);
                                }

                                $index7 = DefaultApp::findIndexInTableau($b7, $boules1);
                                if ($index7 !== -1) {
                                    unset($boules1[$index7]);
                                }

                                $index8 = DefaultApp::findIndexInTableau($b8, $boules1);
                                if ($index8 !== -1) {
                                    unset($boules1[$index8]);
                                }

                                $index9 = DefaultApp::findIndexInTableau($b9, $boules1);
                                if ($index9 !== -1) {
                                    unset($boules1[$index9]);
                                }

                                $index10 = DefaultApp::findIndexInTableau($b10, $boules1);
                                if ($index10 !== -1) {
                                    unset($boules1[$index10]);
                                }

                                //si gain dans 10 boules
                                if (count($boules1) == 10) {
                                    $gain = 'oui';
                                    $paris[$i]->lot = "gain dans 10 boules";
                                    $paris[$i]->montant = $prime1;
                                    $totalGain += $prime1;
                                    $paris[$i]->gain = $gain;
                                } elseif (count($boules1) == 11) {
                                    $gain = 'oui';
                                    $paris[$i]->lot = "gain dans 9 boules";
                                    $paris[$i]->montant = $prime2;
                                    $totalGain += $prime2;
                                    $paris[$i]->gain = $gain;
                                } elseif (count($boules1) == 12) {
                                    $gain = 'oui';
                                    $paris[$i]->lot = "gain dans 8 boules";
                                    $paris[$i]->montant = $prime3;
                                    $totalGain += $prime3;
                                    $paris[$i]->gain = $gain;
                                } elseif (count($boules1) == 13) {
                                    $gain = 'oui';
                                    $paris[$i]->lot = "gain dans 7 boules";
                                    $paris[$i]->montant = $prime4;
                                    $totalGain += $prime4;
                                    $paris[$i]->gain = $gain;
                                } elseif (count($boules1) == 14) {
                                    $gain = 'oui';
                                    $paris[$i]->lot = "gain dans 6 boules";
                                    $paris[$i]->montant = $prime5;
                                    $totalGain += $prime5;
                                    $paris[$i]->gain = $gain;
                                } else {
                                    $paris[$i]->lot = "";
                                    $paris[$i]->montant = 0;
                                    $paris[$i]->gain = "non";
                                }
                            }
                        }

                        if ($gain == "oui") {
                            $listeVente[$index]->paris = json_encode($paris);
                            $listeVente[$index]->total_gain = $totalGain;
                            $listeVente[$index]->gain = $gain;
                            $listeVente[$index]->payer = 'non';
                            $listeVente[$index]->tire = "oui";
                        } else {
                            $listeVente[$index]->paris = json_encode($paris);
                            $listeVente[$index]->total_gain = "0";
                            $listeVente[$index]->gain = "non";
                            $listeVente[$index]->payer = 'non';
                            $listeVente[$index]->tire = "oui";
                        }
                        $listeVente[$index]->update();
                    }
                }
                Vente::updateCommisionAndBalanceVendeur1($v->id_entreprise);
                $en = new \app\DefaultApp\Models\Entreprise();
                $en = $en->findById($id_entreprise);
                if ($en->cash == 'oui') {
                    Vente::updateBalanceClient($id_entreprise, $date, $tirage);
                }
                echo $mv;
                $con->commit();
            } else {
                $con->rollBack();
                echo "tirage non trouvé sur le système";
            }

        } else {
            $con->rollBack();
            echo $mv;
        }
    }

    public static function getJour()
    {
        $date = date("Y-m-d");
        if (setlocale(LC_TIME, 'fr_FR') == '') {
            setlocale(LC_TIME, 'FRA');  //correction problème pour windows
            $format_jour = '%#d';
        } else {
            $format_jour = '%e';
        }
        return strtolower(strftime("%A", strtotime($date)));
    }
}
