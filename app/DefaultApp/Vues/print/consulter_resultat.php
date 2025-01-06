<?php
require "../vendor/autoload.php";

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

$code_recu = "";
$nom_famille = "";
$date_naissance = "";
if (isset($_POST['search'])) {
    $code_recu = $_POST['code_recu'];
    $nom_famille = $_POST['nom_famille'];
    $date_naissance = $_POST['date_naissance'];
}

?>
<div class="container-fluid no-print">
    <br><bR>
    <h4 style="text-align: center">Consultation resultat</h4>
    <form method="post">
        <input type="hidden" name="search">
        <div class="row">
            <div class="form-group">
                <label>No facture</label>
                <input value="<?= $code_recu ?>" type="text" name="code_recu" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Nom de famille</label>
                <input value="<?= $nom_famille ?>" type="text" name="nom_famille" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Date naissance</label>
                <input value="<?= $date_naissance ?>" type="date" name="date_naissance" class="form-control" required>
            </div>

            <br><br><br>
            <div class="form-group" style="text-align: center">
                <input type="submit" value="Valider" class="btn btn-primary btn-block">
            </div>

        </div>
    </form>
</div>
<?php

if (isset($_POST['search'])) {
    $patient = \app\DefaultApp\Models\Patient::rechercherParNomFamilleDateNaissance($nom_famille, $date_naissance);
    if ($patient == null) {
        echo "<div class='alert alert-warning'>Nom famille ou date naissance incorrect</div>";
        return;
    }

    $demande = new \app\DefaultApp\Models\DemmandeImagerie();
    $demande = $demande->findById($code_recu);
    if ($demande == null) {
        echo "Demmande introuvable";
        return;
    }

    $req = \app\DefaultApp\Models\ExamensDemandeImagerie::listerParDemmande($demande->getId());
    if (count($req) > 0) {
        $datax = $req[0];
    }
    if (!isset($datax)) {
        return;
    }
    $images = json_decode($datax->resultat);
    $ima = new \app\DefaultApp\Models\Imagerie();
    $ima = $ima->findById($datax->getIdImagerie());
    $id_examen = $ima->getId();
    $nomImg = $ima->getNom();
    $lien = "https://app.integra-sante.com/image-imagerie?id=" . $demande->id;
    $result = Builder::create()
        ->writer(new PngWriter())
        ->data($lien)  // Remplacez par le texte ou l'URL que vous souhaitez encoder
        ->size(100)
        ->margin(4)
        ->build();

    $anne_naisance = explode("-", $patient->date_naissance)[0];
    $age = date("Y") - $anne_naisance;
    $logo = \app\DefaultApp\DefaultApp::autre("logo.png");

    ?>
    <div class="container-fluid" style="height: 1055px;font-size: 11px">
        <div class="col-12">
            <div class="entete">
                <img style="float:right;margin-top: 25px" src="<?= $result->getDataUri(); ?>">
                <img alt="" style="height: 100px;text-align: center" src="<?= $logo ?>">
                <p style="font-weight: bold;margin-left: 20px">
                    No 3 Rue Gabart, Pétion Ville Haiti<br>
                    Téléphone : +509 47147474
                </p>
            </div>
            <br>
            <div style="border-bottom: 1px solid black;margin-top: -30px"></div>
            <div class="milieu">
                <br>
                <p style="float: right;margin-right: 150px">
                    <strong>Date de Naissance : </strong><?= $patient->date_naissance ?><br>
                    <strong>Age : </strong><?= $age ?> ans<br>
                    <strong>Date : </strong><?= $demande->date_prelevement ?><br>
                </p>
                <p>
                    <strong>Nom : </strong><?= ucfirst($patient->nom) ?><br>
                    <strong>Prénom : </strong><?= ucfirst($patient->prenom) ?><br>
                    <strong>Sexe : </strong><?= ucfirst($patient->sexe) ?><br>
                    <strong>Examen : </strong> <?= $nomImg ?><br>
                </p>
            </div>
            <div style="border-bottom: 1px solid black"></div>
            <div class="">
                <?php
                if ($datax->getStatut() != "n/a") {
                    ?>
                    <br>
                    <p style="font-weight: bold">Technique : </p>
                    <p></p>
                    <br>

                    <p style="font-weight: bold">Indication : </p>
                    <p><?= stripslashes($demande->indication) ?></p>
                    <br>

                    <p style="font-weight: bold">Trouvailles : </p>
                    <p><?= stripslashes($datax->remarque) ?></p>
                    <?php
                }
                ?>
                <div style="float: right;border-top: 3px solid black"></div>
            </div>
        </div>


        <br>
        <div class="col-12" style="display: block;">
            <div class="entete" style="font-weight: bold">
                <?php
                if ($demande->deverson == "oui") {
                    ?>
                    <p>Signé électroniquement par : Dr. Valerie Deverson</p>
                    <?php
                }

                if ($demande->exantus == "oui") {
                    ?>
                    <p>Signé électroniquement par : Dr. Lerby Exantus</p>
                    <?php
                }
                ?>
            </div>
            <br>
        </div>

    </div>

    <div class="container-fluid" style="padding: 20px">
        <div class="row">
            <div class="col-12">
                <?php
                foreach ($images as $i) {
                    ?>
                    <div class="col-md-4">
                        <div class="thumbnail" style="padding: 10px">
                            <a href="<?= $i ?>">
                                <img src="<?= $i ?>" alt="Lights" style="width:100%">
                            </a>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
    <?php
}
?>


