<style>
    h4 {
        text-decoration: underline;
        font-weight: bold;
    }
</style>

<?php

use app\DefaultApp\Models\AccesUser;

if (isset($_POST['numero'])) {
    $id_examen = $_POST['numero'];
}

if (!isset($demmande)) {
    echo "demmande introuvable";
    return;
}
$imagerie = new \app\DefaultApp\Models\Imagerie();
$id_demande = $demmande->getId();
$demandeImg = new \app\DefaultApp\Models\DemmandeImagerie();
$demandeImg = $demandeImg->findById($id_demande);
if ($demandeImg == null) {
    echo "Demmande introuvable";
    return;

}
$statut = $demandeImg->getStatut();
$req = \app\DefaultApp\Models\ExamensDemandeImagerie::listerParDemmande($id_demande);
$id_patient = $demandeImg->getIdPatient();
$patient = new \app\DefaultApp\Models\Patient();
$patient = $patient->findById($id_patient);
if ($patient == null) {
    echo "patient introuvable";
    return;
}
$anne_naisance=explode("-",$patient->date_naissance)[0];
$age=date("Y")-$anne_naisance;
?>
<div class="row">
    <div class="col-md-12">
        <?php \systeme\Application\Application::block("menu_imagerie") ?>
        <div class="card">
            <div class="card-header">
                Ecrire Resultat # <?= $id_demande ?>
            </div>

            <div class="card-body">
                <p>
                    <strong>Nom : </strong><?= ucfirst($patient->nom) ?><br>
                    <strong>Prénom : </strong><?= ucfirst($patient->prenom) ?><br>
                    <strong>Date : </strong><?= $demandeImg->date_prelevement ?><br>
                    <strong>Date de Naissance : </strong><?= $patient->date_naissance ?><br>
                    <strong>Age : </strong><?= $age ?> ans<br>
                </p>
                <div class="message"></div>
                <div class="row">
                    <div class="col-md-12">
                        <?php
                        if ($statut != "pret") {
                            ?>
                            <div style="text-align: center;">
                                <a href="ecrire-resultat-imagerie-<?php echo $id_demande ?>&terminer&id=<?= $id_demande ?>"
                                   class="btn btn-success" style="z-index: 1">Finaliser demmande</a>
                            </div>
                            <br>
                            <br>
                            <?php
                        }
                        if (isset($_GET['terminer'])) {
                            $id = $_GET['id'];
                            $demandeImg = new \app\DefaultApp\Models\DemmandeImagerie();
                            $demandeImg = $demandeImg->findById($id);
                            $demandeImg->setStatut("pret");
                            $demandeImg->update();
                            echo "
                                <script>
                                alert('Processus terminer');
                                document.location.href='ecrire-resultat-imagerie-$id'; 
                                </script>
                                ";
                        }
                        ?>
                        <h3>Indication</h3>
                        <p><?= stripslashes($demandeImg->indication) ?></p>
                        <?php
                        if ($statut == "pret") {
                            if (AccesUser::haveAcces("2.6.3.5.6")) {
                            } else {
                                ?>
                                <script>
                                    document.location.href = "afficher-resultat-imagerie-<?= $demandeImg->getId(); ?>";
                                </script>
                                <?php
                            }
                        }
                        foreach ($req as $datax) {
                            if ($datax->getStatut() != "n/a") {
                                $ima = new \app\DefaultApp\Models\Imagerie();
                                $ima = $ima->findById($datax->getIdImagerie());
                                ?>
                                <div class="col-md-12">
                                    <form class="fait_imagerie col-md-12" method="post" enctype="multipart/form-data">
                                        <?php
                                        $id_examen = $ima->getId();
                                        $nomImg = $ima->getNom();
                                        ?>
                                        <input type="hidden" name="btnfait">
                                        <input type="hidden" name="id_demande" value="<?php echo $id_demande; ?>"/>
                                        <input type="hidden" name="id_examens" value="<?= $id_examen ?>">
                                        <div class="form-group">
                                            <h4><?= strtoupper($nomImg) ?></h4>
                                            <?php
                                            if (\app\DefaultApp\Models\DemmandeImagerie::imagerieDejaFait($id_demande, $id_examen)) {
                                                $images=json_decode($datax->resultat);
                                                ?>
                                                <center>
                                                    <?php
                                                    if(count($images)>0){
                                                        foreach ($images as $img){
                                                            ?>
                                                            <a target="_blank" href="<?= $img ?>"><img src="<?= $img ?>" style="height: 100px"></a>

                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </center>
                                                <?php
                                            }
                                            ?>
                                            <label>Fichier</label>
                                            <input accept="image/*" multiple type="file" name="fichier[]" class="form-control" required>
                                        </div>

                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea name="description" class="editeur">
                                            <?= stripslashes($datax->remarque) ?>
                                        </textarea>
                                        </div>

                                        <div class="form-group">
                                            <label>Impression</label>
                                            <textarea name="conclusion" class="editeur">
                                            <?= stripslashes($datax->conclusion) ?>
                                        </textarea>
                                        </div>

                                        <div class="form-group">
                                            <?php
                                            if (\app\DefaultApp\Models\DemmandeImagerie::imagerieDejaFait($id_demande, $id_examen)) {
                                                $result = \app\DefaultApp\Models\DemmandeImagerie::resultatExamenImagerie($id_demande, $id_examen);
                                                ?>
                                                <div style="text-align: center">
                                                    <input type="submit" value="Modifier" class="btn btn-primary">
                                                </div>
                                                <?php
                                            } else {
                                                ?>
                                                <div style="text-align: center">
                                                    <input type="submit" value="Enregistrer" class="btn btn-primary">
                                                </div>
                                                <?php
                                            }
                                            ?>

                                        </div>

                                    </form>
                                </div>
                                <br><br>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="message"></div>
            </div>
        </div>
    </div>
</div>

