<style>
    .btn-outline-primary.active {
        background-color: #007bff;
        color: white;
        border-color: #007bff;
    }
</style>
<?php
if(isset($_SESSION['type']) == 'medecin' || isset($_SESSION['type']) == 'medecin radiologue' || isset($_SESSION['type']) == 'medecin externe'){
    $id_user = $_SESSION['utilisateur'];
}else{
    $id_user = '';
}
use app\DefaultApp\Models\AccesUser;

$role = \systeme\Model\Utilisateur::role();
$idu = \systeme\Model\Utilisateur::session_valeur();


if (isset($_POST['delete_demmande'])) {
    $id = $_POST['id'];
    $raison = $_POST['raison'];
    $de = new \app\DefaultApp\Models\DemmandeImagerie();
    $de = $de->findById($id);
    $de->statut = "supprimer";
    $de->raison_suppression = $raison;
    $de->update();
?>
    <script>
        alert("supprimer avec success");
        location.href = "imagerie?gestion&demmande";
    </script>
<?php
}

if (isset($_POST['ajouter_medecin'])) {
    $id = $_POST['id'];
    $de = new \app\DefaultApp\Models\DemmandeImagerie();
    $de = $de->findById($id);
    $id_medecin = $de->id_medecin;
    $id_medecin .= "," . $_POST['medecin'];
    $de->id_medecin = $id_medecin;
    $de->update();
?>
    <script>
        alert("medecin ajouter avec success");
        location.href = "imagerie?gestion&demmande";
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
   // $id_user = \systeme\Model\Utilisateur::session_valeur();
    $u = \systeme\Model\Utilisateur::Rechercher($id_user);
   // $id_user = $u->getIdMedecin();
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
        if (\systeme\Model\Utilisateur::role() == "comptabilité") {
        ?>

        <?php
        } else {
        ?>
            <a href="imagerie?gestion&demmande" class="btn btn-outline-primary btn-xs <?= isset($_GET['demmande']) ? 'active' : '' ?>">Demmande</a>
            <a href="imagerie?gestion&encour" class="btn btn-outline-primary btn-xs <?= isset($_GET['encour']) ? 'active' : '' ?>">En cours</a>
            <a href="imagerie?gestion&pret" class="btn btn-outline-primary btn-xs <?= isset($_GET['pret']) ? 'active' : '' ?>">Prêt</a>
            <a href="imagerie?gestion&tous" class="btn btn-outline-primary btn-xs <?= isset($_GET['tous']) ? 'active' : '' ?>">Tous</a>
            <a href="imagerie?gestion&archives" class="btn btn-outline-primary btn-xs <?= isset($_GET['archives']) ? 'active' : '' ?>">Archive</a>
            <a href="imagerie?gestion&supprimer_x" class="btn btn-outline-primary btn-xs <?= isset($_GET['supprimer_x']) ? 'active' : '' ?>">Supprimer</a>
            <?php 
               if($id_user == ""){
            ?>
            <a href="imagerie?gestion&rapport" class="btn btn-outline-primary btn-xs <?= isset($_GET['rapport']) ? 'active' : '' ?>">Rapport</a>
             <?php  } ?>
            <input type="text" class="btn btn-outline-primary btn-xs" id="searchInput" onkeyup="filterTable()" placeholder="Rechercher ici ...">
        <?php
        }
        ?>
        <hr>
        <?php
        if (isset($_GET['supprimer'])) {
        ?>
            <form method="post">
                <input type="hidden" name="delete_demmande">
                <input type="hidden" name="id" value="<?= $_GET['supprimer'] ?>">
                <div class="form-group">
                    <label>Raison de suppression</label>
                    <select class="form-control" name="raison">
                        <option value="raison 1">Raison 1</option>
                        <option value="raison 2">Raison 2</option>
                        <option value="raison 3">Raison 3</option>
                        <option value="raison 4">Raison 4</option>
                    </select>
                </div>
                <input type="submit" value="Valider" class="btn btn-primary btn-xs btn-block">
            </form>

        <?php
            return;
        }

        if (isset($_GET['lyezon'])) {
            $med = new \app\DefaultApp\Models\PersonelMedical();
            $listeMed = $med->findAll();
        ?>
            <h4>Ajouter médecin</h4>
            <form method="post">
                <input type="hidden" name="ajouter_medecin">
                <input type="hidden" name="id" value="<?= $_GET['lyezon'] ?>">
                <div class="form-group">
                    <label>Médecin</label>
                    <select class="form-control" name="medecin">
                        <?php
                        foreach ($listeMed as $me) {
                        ?>
                            <option value="<?= $me->id ?>"><?= $me->nom . " " . $me->prenom ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <input type="submit" value="Valider" class="btn btn-primary btn-xs btn-block">
            </form>

        <?php
            return;
        }


        $patient = new \app\DefaultApp\Models\Patient();
        $medecin = new \app\DefaultApp\Models\PersonelMedical();
        if (isset($_GET['encour'])) {
        ?>
            <h4>En cours</h4>
            <div class="table-responsive">

                <table id='table' class='table table-bordered datatable'
                    style='font-size:13px'>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>#facture</th>
                            <th>Patient</th>
                            <th>Examens</th>
                            <th>Médecin</th>
                            <th>Date demande</th>
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
                        if (\systeme\Model\Utilisateur::role() == "patient") {
                            $liste = \app\DefaultApp\Models\DemmandeImagerie::listeEncourPatient($idu);
                        } else {
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
                                    if ($patient != null) {
                                        $nomPatient = $patient->getNom() . " " . $patient->getPrenom();
                                    } else {
                                        $nomPatient = "";
                                    }
                                } else {
                                    $nomPatient = "";
                                }

                                $nomMedecin = "";
                                $mta = explode(",", $ex->id_medecin);
                                if (is_array($mta)) {
                                    foreach ($mta as $mt) {
                                        $p = new \app\DefaultApp\Models\PersonelMedical();
                                        $p = $p->findById($mt);
                                        if ($p != null) {
                                            $nomMedecin .= $p->nom . " " . $p->prenom . "<br>";
                                        }
                                    }
                                }
                        ?>
                                <tr>
                                    <td><?= $ex->id ?></td>
                                    <td><?= $ex->facture ?></td>
                                    <td><?= ucfirst($nomPatient) ?></td>
                                    <td><?= getListeExamens($ex->id) ?></td>
                                    <td><?= $nomMedecin ?></td>
                                    <td><?= $ex->getDate(); ?></td>
                                    <td><?= $ex->date_prelevement ?></td>
                                    <td>
                                        <?php
                                        if ($ex->deverson == 'oui' || $ex->exantus == 'oui') {
                                            echo '<span style="color:red;">Encours</span>';
                                        } else {
                                            echo 'Encours';
                                        }
                                        ?>
                                        <br>
                                        <?php
                                        if ($role != "patient") {
                                        ?>
                                            <a href="imagerie?gestion&encour&an=<?= $ex->id ?>"
                                                class="btn btn-primary btn-xs delete">Annuler</a>
                                        <?php
                                        }
                                        ?>
                                    </td>
                                    <!--
                                    <td>
                                        <a class="dropdown-item delete"
                                            href='imagerie?gestion&demmande&lyezon=<?= $ex->id ?>'>Ajouter médecin</a>
                                        <?php
                                        if (\systeme\Model\Utilisateur::role() == "medecin radiologue" || $role == "admin") {
                                        ?>
                                            <a class="btn btn-warning btn-xs"
                                                href='<?= \app\DefaultApp\DefaultApp::genererUrl("ecrire_resultat_imagerie", ['id' => $ex->id]) ?>'>Resultat</a>
                                        <?php
                                        }
                                        ?>
                                    </td>
                                    -->
                                    <td>
                                    <?php
                                    if ($role == "patient") {
                                    ?>
                                        <a class="btn btn-success"
                                            href='<?= \app\DefaultApp\DefaultApp::genererUrl("afficher_resultat_imagerie", ['id' => $ex->id]) ?>'>Voire</a>
                                    <?php
                                    } else {
                                    ?>
                                        <div class="basic-dropdown">
                                            <div class="dropdown">
                                                <button type="button" class="btn btn-primary dropdown-toggle"
                                                    data-bs-toggle="dropdown">
                                                    ACTION
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item delete"
                                                        href='imagerie?gestion&demmande&lyezon=<?= $ex->id ?>'>Ajouter
                                                        médecin</a>

                                                    <a class="dropdown-item"
                                                        href='<?= \app\DefaultApp\DefaultApp::genererUrl("prise_specimen_imagerie", ['id' => $ex->id]) ?>?nf'>Technique</a>
                                                    <button type="button" class="btn btn-primary dropdown-item"
                                                        data-toggle="modal" data-target="#ass<?= $ex->id ?>">Médecin
                                                    </button>
                                                    <a class="dropdown-item"
                                                        href='<?= \app\DefaultApp\DefaultApp::genererUrl("ecrire_resultat_imagerie", ['id' => $ex->id]) ?>'>Modifier</a>
                                                    <a class="dropdown-item"
                                                        href='<?= \app\DefaultApp\DefaultApp::genererUrl("afficher_resultat_imagerie", ['id' => $ex->id]) ?>'>Voire</a>
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
            </div>
        <?php
        } elseif (isset($_GET['demmande'])) {
            ab:
        ?>
            <h4>Demmande</h4>
            <table id='table' class='table table-bordered datatable'
                style='font-size:13px'>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>#facture</th>
                        <th>Patient</th>
                        <th>Examens</th>
                        <th>Médecin</th>
                        <th>Date Demande</th>
                        <th>Statut</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($role == "patient") {
                        $liste = \app\DefaultApp\Models\DemmandeImagerie::listeNaPatient($idu);
                    } else {
                        $liste = \app\DefaultApp\Models\DemmandeImagerie::listeNa($id_user);
                    }
                    if (count($liste) > 0) {
                        foreach ($liste as $ex) {
                            $statut = $ex->getStatut();
                            $id_patient = $ex->getIdPatient();
                            if ($id_patient != "") {
                                $patient = $patient->findById($id_patient);
                                if ($patient != null) {
                                    $nomPatient = $patient->getNom() . " " . $patient->getPrenom();
                                } else {
                                    $nomPatient = "";
                                }
                            } else {
                                $nomPatient = "";
                            }

                            $nomMedecin = "";
                            $mta = explode(",", $ex->id_medecin);
                            if (is_array($mta)) {
                                foreach ($mta as $mt) {
                                    $p = new \app\DefaultApp\Models\PersonelMedical();
                                    $p = $p->findById($mt);
                                    if ($p != null) {
                                        $nomMedecin .= $p->nom . " " . $p->prenom . "<br>";
                                    }
                                }
                            }

                    ?>

                            <tr>
                                <td><?= $ex->id ?></td>
                                <td><?= $ex->facture ?></td>
                                <td><?= ucfirst($nomPatient) ?></td>
                                <td><?= getListeExamens($ex->id) ?></td>
                                <td>
                                    <?= ucfirst($nomMedecin) ?>
                                </td>
                                <td><?= $ex->getDate(); ?></td>
                                <td><?= $statut ?></td>
                                <td>
                                    <?php
                                    if ($role !== "patient") {
                                    ?>
                                        <div class="basic-dropdown">
                                            <div class="dropdown">
                                                <button type="button" class="btn btn-primary dropdown-toggle"
                                                    data-bs-toggle="dropdown">
                                                    ACTION
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item"
                                                        href='<?= \app\DefaultApp\DefaultApp::genererUrl("prise_specimen_imagerie", ['id' => $ex->getId()]) ?>'>Technique</a>

                                                    <a class="dropdown-item delete"
                                                        href='imagerie?gestion&demmande&lyezon=<?= $ex->id ?>'>Ajouter
                                                        médecin</a>
                                                    <?php if($_SESSION['role'] =='admin'){?>
                                                    <a class="dropdown-item delete"
                                                        href='imagerie?gestion&demmande&supprimer=<?= $ex->id ?>'>Supprimer</a>
                                                     <?php } ?>
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
            <table id='table' class='table table-bordered datatable'
                style='font-size:13px'>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Facture</th>
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
                    if ($role == "patient") {
                        $liste = \app\DefaultApp\Models\DemmandeImagerie::listePretPatient($idu);
                    } else {
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
                                if ($patient != null) {
                                    $nomPatient = $patient->getNom() . " " . $patient->getPrenom();
                                } else {
                                    $nomPatient = "";
                                }
                            } else {
                                $nomPatient = "";
                            }

                            $nomMedecin = "";
                            $mta = explode(",", $ex->id_medecin);
                            if (is_array($mta)) {
                                foreach ($mta as $mt) {
                                    $p = new \app\DefaultApp\Models\PersonelMedical();
                                    $p = $p->findById($mt);
                                    if ($p != null) {
                                        $nomMedecin .= $p->nom . " " . $p->prenom . "<br>";
                                    }
                                }
                            }
                    ?>

                            <tr>
                                <td><?= $ex->id ?></td>
                                <td><?= $ex->facture ?></td>
                                <td><?= getListeExamens($ex->id) ?></td>
                                <td><?= ucfirst($nomPatient) ?></td>
                                <td><?= $nomMedecin ?></td>
                                <td><?= $ex->getDate(); ?></td>
                                <td><?= $statut ?></td>
                                <td>
                                    <?php
                                    if ($role == "patient") {
                                    ?>
                                        <a class="btn btn-success"
                                            href='<?= \app\DefaultApp\DefaultApp::genererUrl("afficher_resultat_imagerie", ['id' => $ex->id]) ?>'>Voire</a>
                                    <?php
                                    } else {
                                    ?>
                                        <div class="basic-dropdown">
                                            <div class="dropdown">
                                                <button type="button" class="btn btn-primary dropdown-toggle"
                                                    data-bs-toggle="dropdown">
                                                    ACTION
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item delete"
                                                        href='imagerie?gestion&demmande&lyezon=<?= $ex->id ?>'>Ajouter
                                                        médecin</a>

                                                    <a class="dropdown-item"
                                                        href='<?= \app\DefaultApp\DefaultApp::genererUrl("prise_specimen_imagerie", ['id' => $ex->id]) ?>?nf'>Technique</a>
                                                    <button type="button" class="btn btn-primary dropdown-item"
                                                        data-toggle="modal" data-target="#ass<?= $ex->id ?>">Médecin
                                                    </button>
                                                    <a class="dropdown-item"
                                                        href='<?= \app\DefaultApp\DefaultApp::genererUrl("ecrire_resultat_imagerie", ['id' => $ex->id]) ?>'>Modifier</a>
                                                    <a class="dropdown-item"
                                                        href='<?= \app\DefaultApp\DefaultApp::genererUrl("afficher_resultat_imagerie", ['id' => $ex->id]) ?>'>Voire</a>
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
            <h4>Tout les demandes</h4>
            <table id='table' class='table table-bordered datatable'
                style='font-size:13px'>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Facture</th>
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
                    if ($role == "patient") {
                        $liste = \app\DefaultApp\Models\DemmandeImagerie::allPatient($idu);
                    } else {
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
                                if ($patient != null) {
                                    $nomPatient = $patient->getNom() . " " . $patient->getPrenom();
                                } else {
                                    $nomPatient = "";
                                }
                            } else {
                                $nomPatient = "";
                            }

                            $nomMedecin = "";
                            $mta = explode(",", $ex->id_medecin);
                            if (is_array($mta)) {
                                foreach ($mta as $mt) {
                                    $p = new \app\DefaultApp\Models\PersonelMedical();
                                    $p = $p->findById($mt);
                                    if ($p != null) {
                                        $nomMedecin .= $p->nom . " " . $p->prenom . "<br>";
                                    }
                                }
                            }
                    ?>

                            <tr>
                                <td><?= $ex->id ?></td>
                                <td><? $ex->facture ?></td>
                                <td><?= $nom_examens ?></td>
                                <td><?= ucfirst($nomPatient) ?></td>
                                <td><?= $nomMedecin ?></td>
                                <td><?= $ex->getDate(); ?></td>
                                <td><?= $statut ?></td>
                                <td>
                                    <?php
                                    if ($role == "patient") {
                                    ?>
                                        <a class="btn btn-success"
                                            href='<?= \app\DefaultApp\DefaultApp::genererUrl("afficher_resultat_imagerie", ['id' => $ex->id]) ?>'>Voire</a>
                                    <?php
                                    } else {
                                    ?>
                                        <div class="basic-dropdown">
                                            <div class="dropdown">
                                                <button type="button" class="btn btn-primary dropdown-toggle"
                                                    data-bs-toggle="dropdown">
                                                    ACTION
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item"
                                                        href='<?= \app\DefaultApp\DefaultApp::genererUrl("afficher_resultat_imagerie", ['id' => $ex->id]) ?>'>Voire</a>
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
            <table id='table' class='table table-bordered datatable'
                style='font-size:13px'>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Facture</th>
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
                                if ($patient != null) {
                                    $nomPatient = $patient->getNom() . " " . $patient->getPrenom();
                                } else {
                                    $nomPatient = "";
                                }
                            } else {
                                $nomPatient = "";
                            }

                            $nomMedecin = "";
                            $mta = explode(",", $ex->id_medecin);
                            if (is_array($mta)) {
                                foreach ($mta as $mt) {
                                    $p = new \app\DefaultApp\Models\PersonelMedical();
                                    $p = $p->findById($mt);
                                    if ($p != null) {
                                        $nomMedecin .= $p->nom . " " . $p->prenom . "<br>";
                                    }
                                }
                            }
                    ?>

                            <tr>
                                <td><?= $ex->id ?></td>
                                <td><? $ex->facture ?></td>
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
        } else if (isset($_GET['supprimer_x'])) {
        ?>
            <h4>Supprimer</h4>
            <table id='' class='table table-bordered datatable'
                style='font-size:13px'>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Facture</th>
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
                    $liste = \app\DefaultApp\Models\DemmandeImagerie::listeSupprimer($id_user);
                    if (count($liste) > 0) {
                        foreach ($liste as $ex) {
                            $statut = $ex->getStatut();
                            if ($statut === "n/a") {
                                $statut = "encour";
                            }
                            $id_patient = $ex->getIdPatient();
                            if ($id_patient != "") {
                                $patient = $patient->findById($id_patient);
                                if ($patient != null) {
                                    $nomPatient = $patient->getNom() . " " . $patient->getPrenom();
                                } else {
                                    $nomPatient = "";
                                }
                            } else {
                                $nomPatient = "";
                            }

                            $nomMedecin = "";
                            $mta = explode(",", $ex->id_medecin);
                            if (is_array($mta)) {
                                foreach ($mta as $mt) {
                                    $p = new \app\DefaultApp\Models\PersonelMedical();
                                    $p = $p->findById($mt);
                                    if ($p != null) {
                                        $nomMedecin .= $p->nom . " " . $p->prenom . "<br>";
                                    }
                                }
                            }
                    ?>

                            <tr>
                                <td><?= $ex->id ?></td>
                                <td><?= $ex->facture ?></td>
                                <td><?= getListeExamens($ex->id) ?></td>
                                <td><?= ucfirst($nomPatient) ?></td>
                                <td><?= $nomMedecin ?></td>
                                <td><?= $ex->getDate(); ?></td>
                                <td><?= $statut ?></td>
                            </tr>
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

<script>
    function filterTable() {
        const input = document.getElementById("searchInput");
        const filter = input.value.toLowerCase();
        const table = document.getElementById("table");
        const rows = table.querySelectorAll("tbody tr");

        rows.forEach((row) => {
            const cells = row.querySelectorAll("td");
            const rowText = Array.from(cells)
                .map((cell) => cell.textContent.toLowerCase())
                .join(" ");

            if (rowText.includes(filter)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    }
    // Handle button active states
    $('.nav-buttons a').click(function(e) {
        // Remove active class from all buttons
        $('.nav-buttons a').removeClass('active');
        // Add active class to clicked button
        $(this).addClass('active');
    });

    // Alternative: Highlight based on current URL
    function setActiveButton() {
        const currentUrl = window.location.href;
        $('.nav-buttons a').each(function() {
            if (currentUrl.includes($(this).attr('href'))) {
                $(this).addClass('active');
            } else {
                $(this).removeClass('active');
            }
        });
    }

    // Call on page load
    setActiveButton();
</script>