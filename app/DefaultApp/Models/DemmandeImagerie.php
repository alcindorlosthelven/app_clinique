<?php
/**
 * Created by PhpStorm.
 * User: alcin
 * Date: 4/8/2020
 * Time: 1:43 PM
 */

namespace app\DefaultApp\Models;

use systeme\Model\Model;

class DemmandeImagerie extends Model
{
    protected $table = "demmande_imagerie";
    public $id, $id_patient, $date, $date_prelevement;
    public $id_medecin, $statut;
    public $id_admision;
    public $no_dossier, $institution;
    public $payer;
    public $id_categorie, $id_imagerie, $id_medecin2, $remarque;
    public $indication,$technicien,$id_assurance;

    /**
     * @return mixed
     */
    public function getNoDossier()
    {
        return $this->no_dossier;
    }

    /**
     * @param mixed $no_dossier
     */
    public function setNoDossier($no_dossier)
    {
        $this->no_dossier = $no_dossier;
    }

    /**
     * @return mixed
     */
    public function getInstitution()
    {
        return $this->institution;
    }

    /**
     * @param mixed $institution
     */
    public function setInstitution($institution)
    {
        $this->institution = $institution;
    }


    /**
     * @return mixed
     */
    public function getIdAdmision()
    {
        return $this->id_admision;
    }

    /**
     * @param mixed $id_admision
     */
    public function setIdAdmision($id_admision)
    {
        $this->id_admision = $id_admision;
    }


    /**
     * @return mixed
     */
    public function getIdMedecin()
    {
        return $this->id_medecin;
    }

    /**
     * @param mixed $id_medecin
     */
    public function setIdMedecin($id_medecin)
    {
        $this->id_medecin = $id_medecin;
    }

    /**
     * @return mixed
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * @param mixed $statut
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getIdPatient()
    {
        return $this->id_patient;
    }

    /**
     * @param mixed $id_patient
     */
    public function setIdPatient($id_patient)
    {
        $this->id_patient = $id_patient;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    public static function dernierId()
    {
        $con = self::connection();
        $req = "select id from demmande_imagerie order by id desc LIMIT 1";
        $rs = $con->query($req);
        $data = $rs->fetch();
        return $data['id'];
    }


    public static function listeNa($id_categorie, $id_user = "", $institution = "")
    {
        $con = self::connection();
        if ($institution == "") {
            if ($id_user == "") {
                $req = "select *from demmande_imagerie WHERE statut='n/a' and payer='oui' and id_categorie='{$id_categorie}'";
            } else {
                $req = "select *from demmande_imagerie WHERE statut='n/a' and payer='oui' and id_categorie='{$id_categorie}' and id_medecin2='{$id_user}'";
            }
        } else {
            if ($id_user == "") {
                $req = "select *from demmande_imagerie WHERE statut='n/a' and institution='{$institution}' and payer='oui' and id_categorie='{$id_categorie}'";
            } else {
                $req = "select *from demmande_imagerie WHERE statut='n/a' and institution='{$institution}' and payer='oui' and id_categorie='{$id_categorie}' and id_medecin2='{$id_user}'";
            }
        }
        $stmt = $con->prepare($req);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }

    public static function listeEncour($id_categorie, $id_user = "", $institution = "")
    {
        $con = self::connection();
        if ($institution == "") {
            if ($id_user == "") {
                $req = "select *from demmande_imagerie WHERE statut='encour'  and payer='oui' and id_categorie='{$id_categorie}' ";
            } else {
                $req = "select *from demmande_imagerie WHERE statut='encour' and payer='oui' and id_categorie='{$id_categorie}' and id_medecin2='{$id_user}'";
            }
        } else {
            if ($id_user == "") {
                $req = "select *from demmande_imagerie WHERE statut='encour' and institution = '{$institution}' and payer='oui' and id_categorie='{$id_categorie}' ";
            } else {
                $req = "select *from demmande_imagerie WHERE statut='encour' and institution = '{$institution}' and payer='oui' and id_categorie='{$id_categorie}' and id_medecin2='{$id_user}'";
            }
        }
        $stmt = $con->prepare($req);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }

    public static function listePret($id_categorie, $id_user = "", $institution = "")
    {
        $con = self::connection();
        if ($institution == "") {
            if ($id_user == "") {
                $req = "select *from demmande_imagerie WHERE statut='pret' and payer='oui' and id_categorie='{$id_categorie}'";
            } else {
                $req = "select *from demmande_imagerie WHERE statut='pret' and payer='oui' and id_categorie='{$id_categorie}' and id_medecin2='{$id_user}'";
            }
        } else {
            if ($id_user == "") {
                $req = "select *from demmande_imagerie WHERE statut='pret' and institution = '{$institution}' and payer='oui' and id_categorie='{$id_categorie}'";
            } else {
                $req = "select *from demmande_imagerie WHERE statut='pret' and institution = '{$institution}' and payer='oui' and id_categorie='{$id_categorie}' and id_medecin2='{$id_user}'";
            }
        }
        $stmt = $con->prepare($req);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }

    public static function listeArchive($id_categorie, $id_user = "", $institution = "")
    {
        $con = self::connection();
        if ($institution == "") {
            if ($id_user == "") {
                $req = "select *from demmande_imagerie WHERE statut='archive' and id_categorie='{$id_categorie}'";
            } else {
                $req = "select *from demmande_imagerie WHERE statut='archive' and id_categorie='{$id_categorie}' and id_medecin2='{$id_user}'";
            }
        } else {
            if ($id_user == "") {
                $req = "select *from demmande_imagerie WHERE statut='archive' and institution = '{$institution}' and id_categorie='{$id_categorie}'";
            } else {
                $req = "select *from demmande_imagerie WHERE statut='archive' and institution = '{$institution}' and id_categorie='{$id_categorie}' and id_medecin2='{$id_user}'";
            }
        }
        $stmt = $con->prepare($req);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }

    public static function all($id_categorie, $id_user = "", $institution = "")
    {
        $con = self::connection();
        if ($institution == "") {
            if ($id_user == "") {
                $req = "select *from demmande_imagerie where payer='oui'  and id_categorie='{$id_categorie}' order by id desc ";
            } else {
                $req = "select *from demmande_imagerie where payer='oui'  and id_categorie='{$id_categorie}' and id_medecin2='{$id_user}' order by id desc ";
            }
        } else {
            if ($id_user == "") {
                $req = "select *from demmande_imagerie where payer='oui' and institution = '{$institution}' and id_categorie='{$id_categorie}' order by id desc ";
            } else {
                $req = "select *from demmande_imagerie where payer='oui' and institution = '{$institution}' and id_categorie='{$id_categorie}' and id_medecin2='{$id_user}' order by id desc ";
            }
        }
        $stmt = $con->prepare($req);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }

    public static function imagerieDejaFait($demande, $examen)
    {
        $con = self::connection();
        $req = "select *from examens_demande_imagerie where id_demande='" . $demande . "' and id_imagerie='" . $examen . "' and resultat <> 'n/a' ";
        $rs = $con->query($req);
        if ($rs->fetch()) {
            return true;
        } else {
            return false;
        }
    }

    public static function resultatExamenImagerie($demande, $examen)
    {
        $con = self::connection();
        $req = "select *from examens_demande_imagerie where id_demande='" . $demande . "' and id_imagerie='" . $examen . "' ";
        $stmt = $con->prepare($req);
        $stmt->execute();
        $data = $stmt->fetchAll(\PDO::FETCH_CLASS, "app\DefaultApp\Models\ExamensDemandeImagerie");
        if (count($data) > 0) {
            return $data[0];
        } else {
            return null;
        }

    }

    public static function listerExamens($id_demande)
    {
        $resultat = array();
        $lep = ExamensDemandeImagerie::listerParDemmande($id_demande);
        foreach ($lep as $img) {
            $imagerie = new Imagerie();
            $imagerie = $imagerie->findById($img->getIdImagerie());
            $resultat[] = $imagerie;
        }
        return $resultat;
    }

    public static function listerExamensApres($id_demande)
    {
        $resultat = array();
        $lep = ExamensDemandeImagerie::listerParDemmande($id_demande);
        foreach ($lep as $img) {
            $imagerie = new Imagerie();
            $imagerie = $imagerie->findById($img->getIdImagerie());
            $imagerie->prix = $img->prix;
            $resultat[] = $imagerie;
        }
        return $resultat;
    }

    public static function totalParAdmision($id_adm)
    {
        $bdd = self::connection();
        $total = $bdd->query("SELECT * FROM demmande_imagerie WHERE id_admision='" . $id_adm . "'");
        return $total->rowCount();
    }

    public function ListerParDossier($no_dossier)
    {
        try {
            $con = self::connection();
            $req = "select *from demmande_imagerie where no_dossier='{$no_dossier}' order by id desc ";
            $stmt = $con->prepare($req);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_CLASS, "app\DefaultApp\Models\DemmandeImagerie");
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function ListerParInstitution($instition)
    {
        try {
            $con = self::connection();
            $req = "select *from demmande_imagerie where institution='{$instition}' order by id desc ";
            $stmt = $con->prepare($req);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_CLASS, "app\DefaultApp\Models\DemmandeImagerie");
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function lie($id, $idPatient)
    {
        try {
            $con = self::connection();
            $req = "UPDATE demmande_imagerie SET id_patient='{$idPatient}' WHERE id='{$id}'";
            if ($con->query($req)) {
                return "ok";
            } else {
                return "no";
            }
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function siLie($id)
    {
        $con = self::connection();
        $req = "select id_patient from demmande_imagerie where id='" . $id . "'";
        $rs = $con->query($req);
        $data = $rs->fetch();
        if ($data['id_patient'] === "") {
            return false;
        } else {
            return true;
        }
    }

    public static function listeNonPayer()
    {
        try {
            $con = self::connection();
            $req = "select *from demmande_imagerie where payer='non' order by id desc ";
            $stmt = $con->prepare($req);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function listerParPatient($id_patient)
    {
        $con = self::connection();
        $req = "select *from demmande_imagerie where id_patient=:id_patient order by id desc ";
        $stmt = $con->prepare($req);
        $stmt->execute(array(":id_patient" => $id_patient));
        return $stmt->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }

    public static function listerParDate($date1, $date2, $id_categorie, $institution = "")
    {
        $con = self::connection();
        if ($institution == "") {
            $req = "select *from demmande_imagerie where date between '{$date1}' and '{$date2}' and payer='oui' and id_categorie='{$id_categorie}'";
        } else {
            $req = "select *from demmande_imagerie where date between '{$date1}' and '{$date2}' and institution = '{$institution}' and payer='oui' and id_categorie='{$id_categorie}'";
        }
        $stmt = $con->prepare($req);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }

}
