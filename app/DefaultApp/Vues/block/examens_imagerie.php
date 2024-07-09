<?php
use app\DefaultApp\Models\AccesUser;
$id_user="";
if(isset($_GET['supprimer'])){
    $id=$_GET['supprimer'];
    $de=new \app\DefaultApp\Models\DemmandeImagerie();
    $de->deleteById($id);
    ?>
    <script>
        alert("supprimer avec success");
        location.href="liste-demande-imagerie?examens&idcategorie=<?= $_GET['idcategorie'] ?>";
    </script>
    <?php
}

if(isset($_GET['archive'])){
    $id=$_GET['archive'];
    $de=new \app\DefaultApp\Models\DemmandeImagerie();
    $de=$de->findById($id);
    $de->statut="archive";
    $de->update();
    ?>
    <script>
        alert("archiver avec success");
        location.href="liste-demande-imagerie?examens&idcategorie=<?= $_GET['idcategorie'] ?>";
    </script>
    <?php
}

if(\systeme\Model\Utilisateur::role()=="medecin"){
    $id_user=\systeme\Model\Utilisateur::session_valeur();
    $u=\systeme\Model\Utilisateur::Rechercher($id_user);
    $id_user=$u->getIdMedecin();
}

$cache = "display:none";
$aficher = "display:inline";

$catEx = new \app\DefaultApp\Models\CategorieExamensImagerie();
$listeCatEx = $catEx->findAll();
$med=new \app\DefaultApp\Models\PersonelMedical();
$listeMed=$med->findAll();
foreach ($listeCatEx as $ce) {
    ?>
    <a style="margin-right: 3px;" href="imagerie?gestion&idcategorie=<?= $ce->id ?>" class="btn btn-success btn-xs"><?= $ce->categorie ?></a>
    <?php
}
?>
<br><br>
<div class="card">
    <div class="card-body">
        <?php
        if (isset($_GET['idcategorie'])) {
            $id_categorie = $_GET['idcategorie'];
            $catEx = $catEx->findById($id_categorie);
            ?>
            <h3><?= $catEx->categorie ?></h3>
            <a href="imagerie?gestion&idcategorie=<?= $id_categorie ?>&demmande" class="btn btn-outline-primary btn-xs">Demmande</a>
            <a href="imagerie?gestion&idcategorie=<?= $id_categorie ?>&encour" class="btn btn-outline-primary btn-xs">En cours</a>
            <a href="imagerie?gestion&idcategorie=<?= $id_categorie ?>&pret" class="btn btn-outline-primary btn-xs">Prêt</a>
            <a href="imagerie?gestion&idcategorie=<?= $id_categorie ?>&tous" class="btn btn-outline-primary btn-xs">Tous</a>
            <a href="imagerie?gestion&idcategorie=<?= $id_categorie ?>&archives" class="btn btn-outline-primary btn-xs">Archive</a>
            <a href="imagerie?gestion&idcategorie=<?= $id_categorie ?>&rapport" class="btn btn-outline-primary btn-xs">Rapport</a>
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
                    if(isset($_GET['an'])){
                        $id_d=$_GET['an'];
                        $dl=new \app\DefaultApp\Models\DemmandeImagerie();
                        $exde=\app\DefaultApp\Models\ExamensDemandeImagerie::listerParDemmande($id_d);
                        $dl=$dl->findById($id_d);
                        $dl->statut="n/a";
                        $m=$dl->update();
                        $m="ok";
                        if($m=="ok"){
                            foreach ($exde as $ex){
                                $ex->statut="n/a";
                                $ex->update();
                            }
                        }
                    }
                    $liste = \app\DefaultApp\Models\DemmandeImagerie::listeEncour($id_categorie,$id_user);
                    if (count($liste) > 0) {
                        foreach ($liste as $ex) {
                            $statut = $ex->getStatut();
                            if ($statut === "n/a") {
                                $statut = "encour";
                            }
                            $id_patient = $ex->getIdPatient();
                            if ($id_patient != "") {
                                $patient = $patient->findById($id_patient);
                                $nomPatient = $patient->getNom() . " " . $patient->getPrenom();
                            } else {
                                $nomPatient = "";
                            }

                            $idmedecin = $ex->id_medecin2;
                            if (intval($idmedecin)==0) {
                                $nomMedecin = $idmedecin;
                            } else {
                                $med = $medecin->findById($idmedecin);
                                $nomMedecin = $med->getNom() . " " . $med->getPrenom();
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
                                    <a href="liste-demande-imagerie?examens&idcategorie=<?= $_GET['idcategorie'] ?>&encour&an=<?= $ex->getId() ?>" class="btn btn-primary btn-xs delete">Annuler</a>
                                </td>
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
                                                   href='<?= \app\DefaultApp\DefaultApp::genererUrl("prise_specimen_imagerie", ['id' => $ex->getId()]) ?>?nf'>Technique</a>
                                            </li>

                                            <li style="<?php if (AccesUser::haveAcces("2.6.3.5.7")) {
                                                echo $aficher;
                                            } else {
                                                echo $cache;
                                            } ?>">
                                                <button type="button" class="btn btn-primary dropdown-item" data-toggle="modal" data-target="#ass<?= $ex->id ?>">
                                                    Médecin
                                                </button>
                                            </li>

                                            <li  style="<?php if (AccesUser::haveAcces("2.6.3.5.9")) {
                                                echo $aficher;
                                            } else {
                                                echo $cache;
                                            } ?>"><a class="dropdown-item"
                                                     href='<?= \app\DefaultApp\DefaultApp::genererUrl("ecrire_resultat_imagerie", ['id' => $ex->getId()]) ?>'>
                                                    Resultat</a></li>

                                            <li  style="<?php if (AccesUser::haveAcces("2.6.3.5.10")) {
                                                echo $aficher;
                                            } else {
                                                echo $cache;
                                            } ?>"><a class="dropdown-item"
                                                     href='<?= \app\DefaultApp\DefaultApp::genererUrl("afficher_resultat_imagerie", ['id' => $ex->getId()]) ?>'>Voire
                                                </a></li>

                                            <li style="<?php if(AccesUser::haveAcces("2.6.3.5.9")){echo $aficher;}else{echo $cache;} ?>"><a class="dropdown-item delete" href='liste-demande-imagerie?examens&idcategorie=<?= $_GET['idcategorie']?>&archive=<?= $ex->id ?>'>Archive</a></li>

                                            <li style="<?php if(AccesUser::haveAcces("2.6.3.5.9")){echo $aficher;}else{echo $cache;} ?>"><a class="dropdown-item delete" href='liste-demande-imagerie?examens&idcategorie=<?= $_GET['idcategorie']?>&supprimer=<?= $ex->id ?>'>Supprimer</a></li>

                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <!-- Modal -->
                            <div class="modal fade" id="ass<?= $ex->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                <input type="hidden" name="id_demmande" value="<?=$ex->id?>">
                                                <div class="form-group">
                                                    <label>Médecin</label>
                                                    <select class="form-control" name="id_medecin">
                                                        <?php
                                                        foreach ($listeMed as $med){
                                                            ?>
                                                            <option value="<?= $med->id ?>"><?= ucfirst($med->nom). " ". ucfirst($med->prenom) ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <input type="submit" value="Modifier" class="btn btn-primary btn-block">
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
            }

            elseif (isset($_GET['demmande'])) {
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
                    $liste = \app\DefaultApp\Models\DemmandeImagerie::listeNa($id_categorie,$id_user);
                    if (count($liste) > 0) {
                        foreach ($liste as $ex) {
                            $statut = $ex->getStatut();
                            $id_patient = $ex->getIdPatient();
                            if ($id_patient != "") {
                                $patient = $patient->findById($id_patient);
                                $nomPatient = $patient->getNom() . " " . $patient->getPrenom();
                            } else {
                                $nomPatient = "";
                            }

                            $idmedecin = $ex->id_medecin2;
                            if (intval($idmedecin)==0) {
                                $nomMedecin = $idmedecin;
                            } else {
                                $med = $medecin->findById($idmedecin);
                                $nomMedecin = $med->getNom() . " " . $med->getPrenom();
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
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary">Action</button>
                                        <button type="button" class="btn btn-primary dropdown-toggle"
                                                data-toggle="dropdown">
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li style="<?php if (AccesUser::haveAcces("2.6.3.5.7")) {
                                                echo $aficher;
                                            } else {
                                                echo $cache;
                                            } ?>">
                                                <button type="button" class="btn btn-primary dropdown-item" data-toggle="modal" data-target="#ass<?= $ex->id ?>">
                                                    Médecin
                                                </button>
                                            </li>
                                            <li style="<?php if (AccesUser::haveAcces("2.6.3.5.8")) {
                                                echo $aficher;
                                            } else {
                                                echo $cache;
                                            } ?>">
                                                <a class="dropdown-item"
                                                   href='<?= \app\DefaultApp\DefaultApp::genererUrl("prise_specimen_imagerie", ['id' => $ex->getId()]) ?>'>Technique</a>
                                            </li>

                                            <li style="<?php if(AccesUser::haveAcces("2.6.3.5.9")){echo $aficher;}else{echo $cache;} ?>"><a class="dropdown-item delete" href='liste-demande-imagerie?examens&idcategorie=<?= $_GET['idcategorie']?>&archive=<?= $ex->id ?>'>Archive</a></li>


                                            <li style="<?php if(AccesUser::haveAcces("2.6.3.5.9")){echo $aficher;}else{echo $cache;} ?>"><a class="dropdown-item delete" href='liste-demande-imagerie?examens&idcategorie=<?= $_GET['idcategorie']?>&supprimer=<?= $ex->id ?>'>Supprimer</a></li>

                                        </ul>
                                    </div>
                                </td>

                            </tr>
                            <!-- Modal -->
                            <div class="modal fade" id="ass<?= $ex->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                <input type="hidden" name="id_demmande" value="<?=$ex->id?>">
                                                <div class="form-group">
                                                    <label>Médecin</label>
                                                    <select class="form-control" name="id_medecin">
                                                        <?php
                                                        foreach ($listeMed as $med){
                                                            ?>
                                                            <option value="<?= $med->id ?>"><?= ucfirst($med->nom). " ". ucfirst($med->prenom) ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <input type="submit" value="Modifier" class="btn btn-primary btn-block">
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
            }

            else if (isset($_GET['pret'])) {
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
                    $liste = \app\DefaultApp\Models\DemmandeImagerie::listePret($id_categorie,$id_user);
                    if (count($liste) > 0) {
                        foreach ($liste as $ex) {
                            $statut = $ex->getStatut();
                            if ($statut === "n/a") {
                                $statut = "encour";
                            }
                            $id_patient = $ex->getIdPatient();
                            if ($id_patient != "") {
                                $patient = $patient->findById($id_patient);
                                $nomPatient = $patient->getNom() . " " . $patient->getPrenom();
                            } else {
                                $nomPatient = "";
                            }

                            $idmedecin = $ex->id_medecin2;
                            if (intval($idmedecin)==0) {
                                $nomMedecin = $idmedecin;
                            } else {
                                $med = $medecin->findById($idmedecin);
                                $nomMedecin = $med->getNom() . " " . $med->getPrenom();
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
                                                   href='<?= \app\DefaultApp\DefaultApp::genererUrl("prise_specimen_imagerie", ['id' => $ex->getId()]) ?>?nf'>Technique</a>
                                            </li>

                                            <li>
                                                <button type="button" class="btn btn-primary dropdown-item" data-toggle="modal" data-target="#ass<?= $ex->id ?>">
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
                            <div class="modal fade" id="ass<?= $ex->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                <input type="hidden" name="id_demmande" value="<?=$ex->id?>">
                                                <div class="form-group">
                                                    <label>Médecin</label>
                                                    <select class="form-control" name="id_medecin">
                                                        <?php
                                                        foreach ($listeMed as $med){
                                                            ?>
                                                            <option value="<?= $med->id ?>"><?= ucfirst($med->nom). " ". ucfirst($med->prenom) ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <input type="submit" value="Modifier" class="btn btn-primary btn-block">
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
            }

            else if (isset($_GET['tous'])) {
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
                    $liste = \app\DefaultApp\Models\DemmandeImagerie::all($id_categorie,$id_user);
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
                                $nomPatient = $patient->getNom() . " " . $patient->getPrenom();
                            } else {
                                $nomPatient = "";
                            }

                            $idmedecin = $ex->id_medecin2;
                            if (intval($idmedecin)==0) {
                                $nomMedecin = $idmedecin;
                            } else {
                                $med = $medecin->findById($idmedecin);
                                $nomMedecin = $med->getNom() . " " . $med->getPrenom();
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
                                                   href='<?= \app\DefaultApp\DefaultApp::genererUrl("prise_specimen_imagerie", ['id' => $ex->getId()]) ?>?nf'>Technique</a>
                                            </li>

                                            <li><a class="dropdown-item"
                                                   href='<?= \app\DefaultApp\DefaultApp::genererUrl("afficher_resultat_imagerie", ['id' => $ex->getId()]) ?>'>Voire</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                    </tbody>
                </table>
                <?php
            }

            else if (isset($_GET['archives'])) {
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
                    $liste = \app\DefaultApp\Models\DemmandeImagerie::listeArchive($id_categorie,$id_user);
                    if (count($liste) > 0) {
                        foreach ($liste as $ex) {
                            $statut = $ex->getStatut();
                            if ($statut === "n/a") {
                                $statut = "encour";
                            }
                            $id_patient = $ex->getIdPatient();
                            if ($id_patient != "") {
                                $patient = $patient->findById($id_patient);
                                $nomPatient = $patient->getNom() . " " . $patient->getPrenom();
                            } else {
                                $nomPatient = "";
                            }

                            $idmedecin = $ex->id_medecin2;
                            if (intval($idmedecin)==0) {
                                $nomMedecin = $idmedecin;
                            } else {
                                $med = $medecin->findById($idmedecin);
                                $nomMedecin = $med->getNom() . " " . $med->getPrenom();
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
                                                <button type="button" class="btn btn-primary dropdown-item" data-toggle="modal" data-target="#ass<?= $ex->id ?>">
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
                            <div class="modal fade" id="ass<?= $ex->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                <input type="hidden" name="id_demmande" value="<?=$ex->id?>">
                                                <div class="form-group">
                                                    <label>Médecin</label>
                                                    <select class="form-control" name="id_medecin">
                                                        <?php
                                                        foreach ($listeMed as $med){
                                                            ?>
                                                            <option value="<?= $med->id ?>"><?= ucfirst($med->nom). " ". ucfirst($med->prenom) ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <input type="submit" value="Modifier" class="btn btn-primary btn-block">
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
            }

            elseif (isset($_GET['rapport'])) {
                \app\DefaultApp\DefaultApp::block("rapport_imagerie");
            } else {
                goto ab;
            }
        }
        ?>
    </div>
</div>

