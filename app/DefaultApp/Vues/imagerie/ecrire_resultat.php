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
                </p>
                <div class="message"></div>
                <div class="row">
                    <div class="col-md-12">
                        <?php
                        if ($statut != "pret") {
                            ?>
                            <a href="ecrire-resultat-imagerie-<?php echo $id_demande ?>&terminer&id=<?= $id_demande ?>"
                               class="btn btn-success btn-block" style="z-index: 1">Finaliser demmande</a>
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
                                <div class="col-md-12"
                                     style="border: 1px solid #ba8b00;margin-bottom: 2px;margin-top:2px">
                                    <form class="fait_imagerie col-md-12" method="post" enctype="multipart/form-data">
                                        <?php
                                        $id_examen = $ima->getId();
                                        $nomImg = $ima->getNom();
                                        ?>
                                        <input type="hidden" name="id_demande" value="<?php echo $id_demande; ?>"/>
                                        <input type="hidden" name="id_examens" value="<?= $id_examen ?>">
                                        <div class="form-group">
                                            <h4><?= strtoupper($nomImg) ?></h4>
                                            <?php
                                            if (\app\DefaultApp\Models\DemmandeImagerie::imagerieDejaFait($id_demande, $id_examen)) {
                                                ?>
                                                <center><a target="_blank" href="<?= $datax->resultat ?>"><img
                                                                src="<?= $datax->resultat ?>" style="height: 100px"></a>
                                                </center>

                                                <?php
                                            }
                                            ?>
                                            <label>Fichier</label>
                                            <input type="file" name="fichier" class="form-control">
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
                                            <input type="hidden" name="btnfait">
                                            <?php
                                            if (\app\DefaultApp\Models\DemmandeImagerie::imagerieDejaFait($id_demande, $id_examen)) {
                                                $result = \app\DefaultApp\Models\DemmandeImagerie::resultatExamenImagerie($id_demande, $id_examen);
                                                ?>
                                                <input type="submit" value="Modifier"
                                                       class="btn btn-primary btn-block">
                                                <?php
                                            } else {
                                                ?>
                                                <input type="submit" value="Enregistrer" class="btn btn-primary btn-block">
                                                <?php
                                            }
                                            ?>

                                        </div>

                                    </form>
                                </div>
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

