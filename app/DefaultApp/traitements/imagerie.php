<?php

use app\sge\Models\Fichier;

date_default_timezone_set("America/Port-au-Prince");
require_once "../../../vendor/autoload.php";

if (isset($_POST['demmande_imagerie'])) {
    $imagerie=new \app\DefaultApp\Models\Imagerie();
    $con = \systeme\Application\Application::connection();
    $con->beginTransaction();
    try {
        $listeImagerie = $imagerie->findAll();
        $exc=false;
        foreach ($listeImagerie as $img) {
            $id = $img->getId();
            if (isset($_POST[$id])) {
                $exc=true;
            }
        }
        if(!$exc){
            $con->rollBack();
            $resultat['statut']="no";
            $resultat['message']="Choix vide pour l'examen";
            echo json_encode($resultat);
            return ;
        }
        $date = date("Y-m-d");
        $id_patient = $_POST['id_patient'];
        $id_medecin = $_POST['medecin'];

        if ($id_patient == "") {
            $con->rollBack();
            $resultat['statut']="no";
            $resultat['message']="Patient introuvable";
            echo json_encode($resultat);
            return;
        }

        $m="no";
        $ldexames=array();
        $type=$_POST['type'];

        foreach ($listeImagerie as $img) {
            $id = $img->getId();
            if (isset($_POST[$id])) {
                $demmande = new \app\DefaultApp\Models\DemmandeImagerie();
                $lep1 = array();

                if($type=='chl') {
                    $demmande->payer = "oui";
                    $demmande->institution='chl';
                }else{
                    $demmande->payer = "non";
                }

                $demmande->setDate($date);
                $demmande->setIdMedecin($id_medecin);
                $demmande->setStatut("n/a");
                $demmande->setIdPatient($id_patient);
                $demmande->id_imagerie=$_POST[$id];
                $img=new \app\DefaultApp\Models\Imagerie();
                $img=$img->findById($_POST[$id]);
                if(isset($_POST['id_admision'])){
                    $demmande->setIdAdmision($_POST['id_admision']);
                    $admision=new \app\DefaultApp\Models\Admision();
                    $admision=$admision->findById($_POST['id_admision']);
                    if($admision->type_admision=="consultation"){
                        $demmande->payer = "non";
                    }else{
                        $demmande->payer = "oui";
                    }
                }else{
                    $demmande->setIdAdmision("n/a");
                }
                $demmande->id_imagerie=$img->id;
                $demmande->id_categorie=$img->id_categorie;
                $m = $demmande->add();
                if ($m == "ok") {
                    $id_demande = \app\DefaultApp\Models\DemmandeImagerie::dernierId();
                    $demmande->id=$id_demande;
                    $ldexames[]=$demmande;
                    $id_examen = $_POST[$id];
                    $examensImg = new \app\DefaultApp\Models\ExamensDemandeImagerie();
                    $examensImg->setIdDemande($id_demande);
                    $examensImg->setIdImagerie($id_examen);
                    $examensImg->setStatut("n/a");
                    $examensImg->setResultat("n/a");
                    $examensImg->setRemarque("n/a");
                    $examensImg->prix = str_replace(",", "", $img->prix);
                    $mm = $examensImg->add();

                    if (isset($_POST['id_admision'])) {
                        $fact=\app\DefaultApp\Models\Facture::rechercherParAdmision($_POST['id_admision']);
                        $ad=new \app\DefaultApp\Models\Admision();
                        $ad=$ad->findById($_POST['id_admision']);
                        $serA=new \app\DefaultApp\Models\Service();
                        $serA=$serA->findById($ad->service_actuel);
                        if($fact!=null) {
                                    $itmF = new \app\DefaultApp\Models\FactureItemDirect();
                                    $itmF->id_facture = $fact->id;
                                    $itmF->id_item = $img->id;
                                    $itmF->categorie_item = "imagerie";
                                    $itmF->quantite = 1;
                                    $itmF->prix=$img->prix;
                                    $itmF->jour=date("Y-m-d");
                                    $itmF->couvert="oui";
                                    if(strtolower($serA->sigle)=="ssc"){
                                        $itmF->qt_ssc=1;
                                        $itmF->qt_ssh=0;
                                        $itmF->qt_ssu=0;
                                    }
                                    if(strtolower($serA->sigle)=="ssh"){
                                        $itmF->qt_ssc=0;
                                        $itmF->qt_ssh=1;
                                        $itmF->qt_ssu=0;
                                    }
                                    if(strtolower($serA->sigle)=="ssu"){
                                        $itmF->qt_ssc=0;
                                        $itmF->qt_ssh=0;
                                        $itmF->qt_ssu=1;
                                    }

                                    $itmF->add();
                        }
                    }

                }
            }
        }

        $resultat=array();
        if($m=="ok"){
            $gdi=new \app\DefaultApp\Models\GdemmandeImagerie();
            $gdi->id_demmande=$ldexames[0]->id;
            $gdi->demmande=json_encode($ldexames);
            if($type=='chl') {
                $gdi->payer='oui';
                $gdi->institution='chl';
            }else{
                $gdi->payer='non';
            }
            $mgdi=$gdi->add();
            if($mgdi=="ok"){
                $id_deumande=\app\DefaultApp\Models\GdemmandeImagerie::dernierId();
                if(isset($_POST['id_admision'])){
                    $resultat['id_admision']=$_POST['id_admision'];
                    $admision=new \app\DefaultApp\Models\Admision();
                    $admision=$admision->findById($_POST['id_admision']);
                    if($admision->type_admision=="consultation"){
                        $demmande->payer = "non";
                        $resultat['statut']=$m;
                    }else{
                        $resultat['statut']="post_payer";
                        $demmande->payer = "oui";
                    }
                }else{
                    $resultat['statut']=$m;
                }
                $resultat['message']=$mm;
                $resultat['id_demmande']=$id_deumande;
                $resultat['id_patient']=$id_patient;
                $access=\app\DefaultApp\Models\Caisse::hasAccess();
                if($access){
                    $id_caisse = \app\DefaultApp\Models\Caisse::id(\systeme\Model\Utilisateur::session_valeur());
                    $caisse = new \app\DefaultApp\Models\Caisse();
                    $caisse = $caisse->findById($id_caisse);
                    if($caisse==null){
                        $access=false;
                    }else{
                        if ($caisse->statut == "fermer") {
                            $access=false;
                        }else{
                            $access=true;
                        }
                    }
                }else{
                    $access=false;
                }
                $con->commit();
                $resultat['acces']=$access;
            }else{
                $con->rollBack();
                $resultat['statut']="no";
                $resultat['message']=$mgdi;
            }
            echo json_encode($resultat);
        }else{
            $con->rollBack();
            $resultat['statut']="no";
            $resultat['message']=$m;
            echo json_encode($resultat);
        }
    }catch (Exception $ex){
        $con->rollBack();
        $resultat['statut']="no";
        $resultat['message']=$ex->getMessage();
        echo json_encode($resultat);
    }
}

if (isset($_GET['voire_demande'])) {
    ?>
    <?php
    if (isset($_POST['numero'])) {
        $con = \app\DefaultApp\DefaultApp::connection();
        $id_demande = $_POST['numero'];
        $req = "SELECT *FROM lep WHERE id_demande='" . $id_demande . "'";
        $rs = $con->query($req);
        ?>
        <table class="table">
            <tr>
                <th>Nom Examen</th>
            </tr>

            <?php
            while ($data = $rs->fetch()) {
                if (substr($data['id_exament'], "0", "1") == "g") {
                    $id_groupe = substr($data['id_exament'], "2", "2");
                    $gr = \app\DefaultApp\Models\GroupeExament::rechercher($id_groupe);
                    $nom_ex = $gr->getNomGroupe();

                } else {
                    $ex = new \app\DefaultApp\Models\Exament();
                    $ex = \app\DefaultApp\Models\Exament::rechercher($data['id_exament']);
                    $nom_ex = $ex->getNom();
                }
                echo "<tr><td>$nom_ex</td></tr>";
            } ?>

        </table>
        <?php
    }
    ?>
    <?php
}

if (isset($_POST['btnfait'])) {
    $imagerie= new \app\DefaultApp\Models\Imagerie();
    $id_demande = $_POST['id_demande'];
    $id_examens=$_POST['id_examens'];
    $description=trim(addslashes($_POST['description']));
    if($description==""){
        echo "Entrer une description";
        return;
    }
    $conclusion=trim(addslashes($_POST['conclusion']));
    if($conclusion==""){
        echo "Entrer une impression";
        return;
    }

    $examensDemandeImagerie=\app\DefaultApp\Models\ExamensDemandeImagerie::rechercher($id_demande,$id_examens);
    $examensDemandeImagerie->setRemarque($description);
    $examensDemandeImagerie->conclusion=$conclusion;

    $images=array();

    $total = count($_FILES['fichier']['name']);
    if($total>0) {
        for ($i = 0; $i < $total; $i++) {
            if (isset($_FILES['fichier']['name'][$i])) {
                $fichier=new \app\DefaultApp\Models\Fichier($_FILES['fichier']['name'][$i],"img_$id_demande$i");
                if($fichier->Upload($i)){
                    $images[]=$fichier->getSrc();
                }
            }
        }
    }
    $examensDemandeImagerie->setResultat(json_encode($images));
    $m=$examensDemandeImagerie->update();
    echo $m;
}

if(isset($_POST['specimen'])){
    $id_demande=$_POST['id_demande'];
    $lep=\app\DefaultApp\Models\ExamensDemandeImagerie::listerParDemmande($id_demande);
    $demmande = new \app\DefaultApp\Models\DemmandeImagerie();
    $demmande = $demmande->findById($id_demande);
    $demmande->date_prelevement=$_POST['date'];
    $demmande->remarque=trim(addslashes($_POST['remarque']));
    $demmande->indication=trim(addslashes($_POST['indication']));
    $demmande->statut="encour";
    $demmande->technicien=\systeme\Model\Utilisateur::session_valeur();
    foreach ($lep as $l){
        if(isset($_POST['ex-'.$l->getIdImagerie()])){
            $id_examen=$l->getIdImagerie();
            $exdl=\app\DefaultApp\Models\ExamensDemandeImagerie::rechercher($id_demande,$id_examen);
            $exdl->setStatut(1);
            $m=$exdl->update();
            /*if($m=="ok"){
                $id_admision = $demmande->getIdAdmision();
                $labo=new \app\DefaultApp\Models\Imagerie();
                $labo=$labo->findById($id_examen);
                if ($id_admision != "n/a") {
                    $admision=new \app\DefaultApp\Models\Admision();
                    $admision=$admision->findById($id_admision);
                    $service=$admision->getServiceActuel();
                    $facture=\app\DefaultApp\Models\Facture::rechercherParAdmision($id_admision);
                    $item_facture = new \app\DefaultApp\Models\FactureItemDirect();
                    $item_facture->setIdFacture($facture->getId());
                    $item_facture->setIdItem($id_examen);
                    $item_facture->setCategorieItem("imagerie");
                    $item_facture->setQuantite(1);
                    $item_facture->setPrix($labo->getPrix());
                    $item_facture->setIdBdc("n/a");
                    $item_facture->setJour(date("Y-m-d"));
                    $item_facture->setCouvert("oui");
                    $ser = new \app\DefaultApp\Models\Service();
                    $ser = $ser->findById($service);
                    $nom_service = $ser->getSigle();

                    if ($nom_service == "SSH") {
                        $item_facture->setQtSsh(1);
                        $item_facture->setQtSsc(0);
                        $item_facture->setQtSsu(0);
                    }
                    if ($nom_service == "SSU") {
                        $item_facture->setQtSsh(0);
                        $item_facture->setQtSsc(0);
                        $item_facture->setQtSsu(1);
                    }
                    if ($nom_service == "SSC") {
                        $item_facture->setQtSsh(0);
                        $item_facture->setQtSsc(1);
                        $item_facture->setQtSsu(0);
                    }
                    $m=$item_facture->add();
                }
            }*/
        }
    }
    if(isset($m)){
        if($m=="ok"){
            $demmande->update();
            echo "ok";
        }else{
            echo $m;
        }
    }else{
        $demmande->update();
        echo "ok";
        //echo "choisir au moins une examens";
    }
}

if(isset($_GET['getPrix'])){
    $nomLabo=$_GET['nom'];
    $labo=new \app\DefaultApp\Models\Imagerie();
    $labo=$labo->findByNom($nomLabo);
    if($labo==null){
        echo 0;
        return;
    }
    echo $labo->prix;
}

if(isset($_GET['getPrixService'])){
    $nomLabo=$_GET['nom'];
    $labo=new \app\DefaultApp\Models\Stock();
    $labo=$labo->rechercherParNom($nomLabo);
    if($labo==null){
        echo 0;
        return;
    }
    echo $labo->prix;
}

if(isset($_GET['getPrixMedicament'])){
    $nomLabo=$_GET['nom'];
    $labo=new \app\DefaultApp\Models\Stock();
    $labo=$labo->rechercherParNom($nomLabo);
    if($labo==null){
        echo 0;
        return;
    }
    echo $labo->prix;
}
