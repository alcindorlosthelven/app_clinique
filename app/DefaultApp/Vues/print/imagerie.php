<?php
if(!isset($_GET['id'])){
    return;
}

$id=$_GET['id'];

require "../vendor/autoload.php";
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

$demande = new \app\DefaultApp\Models\DemmandeImagerie();
$demande = $demande->findById($id);
if ($demande == null) {
    echo "Demmande introuvable";
    return;
}

$id_patient = $demande->getIdPatient();
$patient = new \app\DefaultApp\Models\Patient();
$patient = $patient->findById($id_patient);
if ($patient == null) {
    echo "patient introuvable";
    return;
}


$req = \app\DefaultApp\Models\ExamensDemandeImagerie::listerParDemmande($demande->getId());
$logo=\app\DefaultApp\DefaultApp::autre("logo.png");
if (count($req) > 0) {
    $datax = $req[0];
}
if (!isset($datax)) {
    return;
}
$ima = new \app\DefaultApp\Models\Imagerie();
$ima = $ima->findById($datax->getIdImagerie());
$id_examen = $ima->getId();
$nomImg = $ima->getNom();
$lien="https://app.integra-sante.com/image-imagerie?id=".$demande->id;
$result = Builder::create()
    ->writer(new PngWriter())
    ->data($lien)  // Remplacez par le texte ou l'URL que vous souhaitez encoder
    ->size(100)
    ->margin(4)
    ->build();

$anne_naisance=explode("-",$patient->date_naissance)[0];
$age=date("Y")-$anne_naisance;
?>


<div class="container-fluid" style="border: 1px solid black;height: 1055px;font-size: 11px">
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
                <!--<br>
                <p style="font-weight: bold">Impression : </p>
                <p><?php /*= stripslashes($datax->conclusion) */?></p>-->
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

<script>
    window.print();
</script>
