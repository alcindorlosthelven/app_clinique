<?php

use app\DefaultApp\Models\AccesUser;
$role=\systeme\Model\Utilisateur::role();
$idu=\systeme\Model\Utilisateur::session_valeur();
$id_user = "";
if (isset($_GET['supprimer'])) {
    $id = $_GET['supprimer'];
    $de = new \app\DefaultApp\Models\DemmandeImagerie();
    $de->deleteById($id);
    ?>
    <script>
        alert("supprimer avec success");
        location.href = "liste-demande-imagerie?examens&idcategorie=<?= $_GET['idcategorie'] ?>";
    </script>
    <?php
}

if (isset($_GET['archive'])) {
    $id = $_GET['archive'];
    $de = new \app\DefaultApp\Models\DemmandeImagerie();
    $de = $de->findById($id);
    $de->statut = "archive";
    $de->update();
    ?>
    <script>
        alert("archiver avec success");
        location.href = "liste-demande-imagerie?examens&idcategorie=<?= $_GET['idcategorie'] ?>";
    </script>
    <?php
}

if (\systeme\Model\Utilisateur::role() == "medecin") {
    $id_user = \systeme\Model\Utilisateur::session_valeur();
    $u = \systeme\Model\Utilisateur::Rechercher($id_user);
    $id_user = $u->getIdMedecin();
}

function getListeExamens($id)
{
    $nom_examens = "";
    $examens = \app\DefaultApp\Models\ExamensDemandeImagerie::listerParDemmande($id);
    foreach ($examens as $exam) {
        $id_exam = $exam->id_imagerie;
        $imagerie = new \app\DefaultApp\Models\Imagerie();
        $imagerie = $imagerie->findById($id_exam);
        $nom_examens .= $imagerie->nom . "<br>";
    }
    return $nom_examens;
}


$cache = "display:none";
$aficher = "display:inline";

$catEx = new \app\DefaultApp\Models\CategorieExamensImagerie();
$listeCatEx = $catEx->findAll();
$med = new \app\DefaultApp\Models\PersonelMedical();
$listeMed = $med->findAll();
?>
<div class="card">
    <div class="card-body">
        <?php
        if(\systeme\Model\Utilisateur::role()=="comptabilité"){
            ?>

            <?php
        }else{
            ?>
            <a href="imagerie?gestion&demmande" class="btn btn-outline-primary btn-xs">Demmande</a>
            <a href="imagerie?gestion&encour" class="btn btn-outline-primary btn-xs">En cours</a>
            <a href="imagerie?gestion&pret" class="btn btn-outline-primary btn-xs">Prêt</a>
            <a href="imagerie?gestion&tous" class="btn btn-outline-primary btn-xs">Tous</a>
            <a href="imagerie?gestion&archives" class="btn btn-outline-primary btn-xs">Archive</a>
            <a href="imagerie?gestion&rapport" class="btn btn-outline-primary btn-xs">Rapport</a>
        <?php
        }
        ?>

        <hr>
        <?php
        $patient = new \app\DefaultApp\Models\Patient();
        $medecin = new \app\DefaultApp\Models\PersonelMedical();
        if (isset($_GET['encour'])) {
            ?>
            <h4>En cours</h4>
            <table id='' class='table table-bordered datatable'
                   style='font-size:13px'>
                <thead>
                <tr>
                    <th>No</th>
                    <th>Patient</th>
                    <th>Examens</th>
                    <th>Médecin</th>
                    <th>Date demmande</th>
                    <th>Date technique</th>
                    <th>Statut</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (isset($_GET['an'])) {
                    $id_d = $_GET['an'];
                    $dl = new \app\DefaultApp\Models\DemmandeImagerie();
                    $exde = \app\DefaultApp\Models\ExamensDemandeImagerie::listerParDemmande($id_d);
                    $dl = $dl->findById($id_d);
                    $dl->statut = "n/a";
                    $m = $dl->update();
                    $m = "ok";
                    if ($m == "ok") {
                        foreach ($exde as $ex) {
                            $ex->statut = "n/a";
                            $ex->update();
                        }
                    }
                }
                if(\systeme\Model\Utilisateur::role()=="patient"){
                    $liste = \app\DefaultApp\Models\DemmandeImagerie::listeEncourPatient($idu);
                }else{
                    $liste = \app\DefaultApp\Models\DemmandeImagerie::listeEncour($id_user);
                }
                if (count($liste) > 0) {
                    foreach ($liste as $ex) {
                        $statut = $ex->getStatut();
                        if ($statut === "n/a") {
                            $statut = "encour";
                        }
                        $id_patient = $ex->getIdPatient();
                        if ($id_patient != "") {
                            $patient = $patient->findById($id_patient);
                            if($patient!=null){
                                $nomPatient = $patient->getNom() . " " . $patient->getPrenom();
                            }else{
                                $nomPatient="";
                            }
                        } else {
                            $nomPatient = "";
                        }

                        $idmedecin = $ex->id_medecin;
                        if (intval($idmedecin) == 0) {
                            $nomMedecin = $idmedecin;
                        } else {
                            $med = $medecin->findById($idmedecin);
                            if($med!=null) {
                                $nomMedecin = $med->getNom() . " " . $med->getPrenom();
                            }else{
                                $nomMedecin="";
                            }
                        }
                        ?>
                        <tr>
                            <td><?= $ex->id ?></td>
                            <td><?= ucfirst($nomPatient) ?></td>
                            <td><?= getListeExamens($ex->id) ?></td>
                            <td><?= $nomMedecin ?></td>
                            <td><?= $ex->getDate(); ?></td>
                            <td><?= $ex->date_prelevement ?></td>
                            <td>
                                <?= $statut ?>
                                <br>
                                <?php
                                if($role!="patient"){
                                    ?>
                                    <a href="imagerie?gestion&encour&an=<?= $ex->id ?>" class="btn btn-primary btn-xs delete">Annuler</a>
                                    <?php
                                }
                                ?>
                            </td>
                            <td>
                                <a style="display: none" class="btn btn-warning btn-xs" href='<?= \app\DefaultApp\DefaultApp::genererUrl("ecrire_resultat_imagerie", ['id' => $ex->id]) ?>'>Resultat</a>
                                <?php
                                if(\systeme\Model\Utilisateur::role()=="médecin radiologue" || $role=="admin"){
                                    ?>
                                    <a class="btn btn-warning btn-xs" href='<?= \app\DefaultApp\DefaultApp::genererUrl("ecrire_resultat_imagerie", ['id' => $ex->id]) ?>'>Resultat</a>
                                    <?php
                                }
                                ?>
                            </td>
                        </tr>
                        <!-- Modal -->
                        <div class="modal fade" id="ass<?= $ex->id ?>" tabindex="-1" role="dialog"
                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Associé médecin</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="message"></div>
                                        <form method="post" class="f_associer_medecin">
                                            <input type="hidden" name="associer_demmande_imagerie">
                                            <input type="hidden" name="id_demmande" value="<?= $ex->id ?>">
                                            <div class="form-group">
                                                <label>Médecin</label>
                                                <select class="form-control" name="id_medecin">
                                                    <?php
                                                    foreach ($listeMed as $med) {
                                                        ?>
                                                        <option value="<?= $med->id ?>"><?= ucfirst($med->nom) . " " . ucfirst($med->prenom) ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <input type="submit" value="Modifier"
                                                       class="btn btn-primary btn-block">
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
                </tbody>
            </table>
            <?php
        } elseif (isset($_GET['demmande'])) {
            ab:
            ?>
            <h4>Demmande</h4>
            <table id='' class='table table-bordered datatable'
                   style='font-size:13px'>
                <thead>
                <tr>
                    <th>No</th>
                    <th>Patient</th>
                    <th>Examens</th>
                    <th>Médecin</th>
                    <th>Date Demmande</th>
                    <th>Statut</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php
                if($role=="patient"){
                    $liste = \app\DefaultApp\Models\DemmandeImagerie::listeNaPatient($idu);
                }else{
                    $liste = \app\DefaultApp\Models\DemmandeImagerie::listeNa($id_user);
                }
                if (count($liste) > 0) {
                    foreach ($liste as $ex) {
                        $statut = $ex->getStatut();
                        $id_patient = $ex->getIdPatient();
                        if ($id_patient != "") {
                            $patient = $patient->findById($id_patient);
                            if($patient!=null){
                                $nomPatient = $patient->getNom() . " " . $patient->getPrenom();
                            }else{
                                $nomPatient="";
                            }
                        } else {
                            $nomPatient = "";
                        }

                        $idmedecin = $ex->id_medecin;
                        if (intval($idmedecin) == 0) {
                            $nomMedecin = $idmedecin;
                        } else {
                            $med = $medecin->findById($idmedecin);
                            if($med!=null) {
                                $nomMedecin = $med->getNom() . " " . $med->getPrenom();
                            }else{
                                $nomMedecin="";
                            }
                        }
                        ?>

                        <tr>
                            <td><?= $ex->id ?></td>
                            <td><?= ucfirst($nomPatient) ?></td>
                            <td><?= getListeExamens($ex->id) ?></td>
                            <td>
                                <?= ucfirst($nomMedecin) ?>
                            </td>
                            <td><?= $ex->getDate(); ?></td>
                            <td><?= $statut ?></td>
                            <td>
                                <?php
                                if($role!=="patient"){
                                    ?>
                                    <div class="basic-dropdown">
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
                                                ACTION
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href='<?= \app\DefaultApp\DefaultApp::genererUrl("prise_specimen_imagerie", ['id' => $ex->getId()]) ?>'>Technique</a>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </td>
                        </tr>
                        <!-- Modal -->
                        <div class="modal fade" id="ass<?= $ex->id ?>" tabindex="-1" role="dialog"
                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Médecin</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="message"></div>
                                        <form method="post" class="f_associer_medecin">
                                            <input type="hidden" name="associer_demmande_imagerie">
                                            <input type="hidden" name="id_demmande" value="<?= $ex->id ?>">
                                            <div class="form-group">
                                                <label>Médecin</label>
                                                <select class="form-control" name="id_medecin">
                                                    <?php
                                                    foreach ($listeMed as $med) {
                                                        ?>
                                                        <option value="<?= $med->id ?>"><?= ucfirst($med->nom) . " " . ucfirst($med->prenom) ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <input type="submit" value="Modifier"
                                                       class="btn btn-primary btn-block">
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
                </tbody>
            </table>
            <?php
        } else if (isset($_GET['pret'])) {
            ?>
            <h4>Finaliser</h4>
            <table id='' class='table table-bordered datatable'
                   style='font-size:13px'>
                <thead>
                <tr>
                    <th>No</th>
                    <th>Examens</th>
                    <th>Patient</th>
                    <th>Médecin</th>
                    <th>Date</th>
                    <th>Statut</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php
                if($role=="patient"){
                    $liste = \app\DefaultApp\Models\DemmandeImagerie::listePretPatient($idu);
                }else{
                    $liste = \app\DefaultApp\Models\DemmandeImagerie::listePret($id_user);
                }

                if (count($liste) > 0) {
                    foreach ($liste as $ex) {
                        $statut = $ex->getStatut();
                        if ($statut === "n/a") {
                            $statut = "encour";
                        }
                        $id_patient = $ex->getIdPatient();
                        if ($id_patient != "") {
                            $patient = $patient->findById($id_patient);
                            if($patient!=null){
                                $nomPatient = $patient->getNom() . " " . $patient->getPrenom();
                            }else{
                                $nomPatient="";
                            }
                        } else {
                            $nomPatient = "";
                        }

                        $idmedecin = $ex->id_medecin;
                        if (intval($idmedecin) == 0) {
                            $nomMedecin = $idmedecin;
                        } else {
                            $med = $medecin->findById($idmedecin);
                            if($med!=null) {
                                $nomMedecin = $med->getNom() . " " . $med->getPrenom();
                            }else{
                                $nomMedecin="";
                            }
                        }
                        ?>

                        <tr>
                            <td><?= $ex->id ?></td>
                            <td><?= getListeExamens($ex->id) ?></td>
                            <td><?= ucfirst($nomPatient) ?></td>
                            <td><?= $nomMedecin ?></td>
                            <td><?= $ex->getDate(); ?></td>
                            <td><?= $statut ?></td>
                            <td>
                                <?php
                                if($role=="patient"){
                                    ?>
                                    <a class="btn btn-success" href='<?= \app\DefaultApp\DefaultApp::genererUrl("afficher_resultat_imagerie", ['id' => $ex->id]) ?>'>Voire</a>
                                    <?php
                                }else{
                                    ?>
                                    <div class="basic-dropdown">
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
                                                ACTION
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href='<?= \app\DefaultApp\DefaultApp::genererUrl("prise_specimen_imagerie", ['id' => $ex->id]) ?>?nf'>Technique</a>
                                                <button type="button" class="btn btn-primary dropdown-item" data-toggle="modal" data-target="#ass<?= $ex->id ?>">Médecin</button>
                                                <a class="dropdown-item" href='<?= \app\DefaultApp\DefaultApp::genererUrl("ecrire_resultat_imagerie", ['id' => $ex->id]) ?>'>Modifier</a>
                                                <a class="dropdown-item" href='<?= \app\DefaultApp\DefaultApp::genererUrl("afficher_resultat_imagerie", ['id' => $ex->id]) ?>'>Voire</a>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </td>
                        </tr>
                        <!-- Modal -->
                        <div class="modal fade" id="ass<?= $ex->id ?>" tabindex="-1" role="dialog"
                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Associé médecin</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="message"></div>
                                        <form method="post" class="f_associer_medecin">
                                            <input type="hidden" name="associer_demmande_imagerie">
                                            <input type="hidden" name="id_demmande" value="<?= $ex->id ?>">
                                            <div class="form-group">
                                                <label>Médecin</label>
                                                <select class="form-control" name="id_medecin">
                                                    <?php
                                                    foreach ($listeMed as $med) {
                                                        ?>
                                                        <option value="<?= $med->id ?>"><?= ucfirst($med->nom) . " " . ucfirst($med->prenom) ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <input type="submit" value="Modifier"
                                                       class="btn btn-primary btn-block">
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
                    }
                }
                ?>
                </tbody>
            </table>
            <?php
        } else if (isset($_GET['tous'])) {
            ?>
            <h4>Tout les demmandes</h4>
            <table id='' class='table table-bordered datatable'
                   style='font-size:13px'>
                <thead>
                <tr>
                    <th>No</th>
                    <th>Examens</th>
                    <th>Patient</th>
                    <th>Medecin</th>
                    <th>Date</th>
                    <th>Statut</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php
                if($role=="patient"){
                    $liste = \app\DefaultApp\Models\DemmandeImagerie::allPatient($idu);
                }else{
                    $liste = \app\DefaultApp\Models\DemmandeImagerie::all($id_user);
                }
                if (count($liste) > 0) {
                    foreach ($liste as $ex) {
                        $nom_examens = getListeExamens($ex->id);
                        $statut = $ex->getStatut();
                        if ($statut === "n/a") {
                            $statut = "encour";
                        }
                        $id_patient = $ex->getIdPatient();
                        if ($id_patient != "") {
                            $patient = $patient->findById($id_patient);
                            if($patient!=null){
                                $nomPatient = $patient->getNom() . " " . $patient->getPrenom();
                            }else{
                                $nomPatient="";
                            }
                        } else {
                            $nomPatient = "";
                        }

                        $idmedecin = $ex->id_medecin;
                        if (intval($idmedecin) == 0) {
                            $nomMedecin = $idmedecin;
                        } else {
                            $med = $medecin->findById($idmedecin);
                            if($med!=null) {
                                $nomMedecin = $med->getNom() . " " . $med->getPrenom();
                            }else{
                                $nomMedecin="";
                            }
                        }
                        ?>

                        <tr>
                            <td><?= $ex->id ?></td>
                            <td><?= $nom_examens ?></td>
                            <td><?= ucfirst($nomPatient) ?></td>
                            <td><?= $nomMedecin ?></td>
                            <td><?= $ex->getDate(); ?></td>
                            <td><?= $statut ?></td>
                            <td>
                                <?php
                                if($role=="patient"){
                                    ?>
                                    <a class="btn btn-success" href='<?= \app\DefaultApp\DefaultApp::genererUrl("afficher_resultat_imagerie", ['id' => $ex->id]) ?>'>Voire</a>
                                    <?php
                                }else{
                                    ?>
                                    <div class="basic-dropdown">
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
                                                ACTION
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href='<?= \app\DefaultApp\DefaultApp::genererUrl("afficher_resultat_imagerie", ['id' => $ex->id]) ?>'>Voire</a>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>
                </tbody>
            </table>
            <?php
        } else if (isset($_GET['archives'])) {
            ?>
            <h4>Archive</h4>
            <table id='' class='table table-bordered datatable'
                   style='font-size:13px'>
                <thead>
                <tr>
                    <th>No</th>
                    <th>Examens</th>
                    <th>Patient</th>
                    <th>Médecin</th>
                    <th>Date</th>
                    <th>Statut</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php
                $liste = \app\DefaultApp\Models\DemmandeImagerie::listeArchive($id_user);
                if (count($liste) > 0) {
                    foreach ($liste as $ex) {
                        $statut = $ex->getStatut();
                        if ($statut === "n/a") {
                            $statut = "encour";
                        }
                        $id_patient = $ex->getIdPatient();
                        if ($id_patient != "") {
                            $patient = $patient->findById($id_patient);
                            if($patient!=null){
                                $nomPatient = $patient->getNom() . " " . $patient->getPrenom();
                            }else{
                                $nomPatient="";
                            }
                        } else {
                            $nomPatient = "";
                        }

                        $idmedecin = $ex->id_medecin;
                        if (intval($idmedecin) == 0) {
                            $nomMedecin = $idmedecin;
                        } else {
                            $med = $medecin->findById($idmedecin);
                            if($med!=null) {
                                $nomMedecin = $med->getNom() . " " . $med->getPrenom();
                            }else{
                                $nomMedecin="";
                            }
                        }
                        ?>

                        <tr>
                            <td><?= $ex->id ?></td>
                            <td><?= getListeExamens($ex->id) ?></td>
                            <td><?= ucfirst($nomPatient) ?></td>
                            <td><?= $nomMedecin ?></td>
                            <td><?= $ex->getDate(); ?></td>
                            <td><?= $statut ?></td>
                            <td>

                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary">Action</button>
                                    <button type="button" class="btn btn-primary dropdown-toggle"
                                            data-toggle="dropdown">
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li style="<?php if (AccesUser::haveAcces("2.6.3.5.8")) {
                                            echo $aficher;
                                        } else {
                                            echo $cache;
                                        } ?>">
                                            <a class="dropdown-item"
                                               href='<?= \app\DefaultApp\DefaultApp::genererUrl("prise_specimen_imagerie", ['id' => $ex->getId()]) ?>'>Technique</a>
                                        </li>

                                        <li>
                                            <button type="button" class="btn btn-primary dropdown-item"
                                                    data-toggle="modal" data-target="#ass<?= $ex->id ?>">
                                                Médecin
                                            </button>
                                        </li>

                                        <?php
                                        if (AccesUser::haveAcces("2.6.3.5.6")) {
                                            ?>
                                            <li><a class="dropdown-item"
                                                   href='<?= \app\DefaultApp\DefaultApp::genererUrl("ecrire_resultat_imagerie", ['id' => $ex->getId()]) ?>'>Modifier
                                                </a></li>
                                            <?php
                                        }
                                        ?>
                                        <li><a class="dropdown-item"
                                               href='<?= \app\DefaultApp\DefaultApp::genererUrl("afficher_resultat_imagerie", ['id' => $ex->getId()]) ?>'>Voire</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <!-- Modal -->
                        <div class="modal fade" id="ass<?= $ex->id ?>" tabindex="-1" role="dialog"
                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Associé médecin</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="message"></div>
                                        <form method="post" class="f_associer_medecin">
                                            <input type="hidden" name="associer_demmande_imagerie">
                                            <input type="hidden" name="id_demmande" value="<?= $ex->id ?>">
                                            <div class="form-group">
                                                <label>Médecin</label>
                                                <select class="form-control" name="id_medecin">
                                                    <?php
                                                    foreach ($listeMed as $med) {
                                                        ?>
                                                        <option value="<?= $med->id ?>"><?= ucfirst($med->nom) . " " . ucfirst($med->prenom) ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <input type="submit" value="Modifier"
                                                       class="btn btn-primary btn-block">
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
                    }
                }
                ?>
                </tbody>
            </table>
            <?php
        } elseif (isset($_GET['rapport'])) {
            \app\DefaultApp\DefaultApp::block("rapport_imagerie");
        } else {
            goto ab;
        }
        ?>
    </div>
</div>

