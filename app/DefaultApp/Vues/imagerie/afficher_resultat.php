<style>
    table {
        border: medium solid #6495ed;
        border-collapse: collapse;
        width: 100%;
    }

    td {
        font-family: sans-serif;
        border: thin solid #6495ed;
        text-align: left;
        background-color: #ffffff;
    }

    th {
        font-family: monospace;
        border: thin solid #6495ed;
        background-color: #D0E3FA;
    }

    .a {
        text-align: center;
    }

    caption {
        font-family: sans-serif;
    }
</style>
<?php
if (!isset($id)) {
    return;
}
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
$logo = \app\DefaultApp\DefaultApp::protocolApp() . $_SERVER['HTTP_HOST'] . "/hopital/" . \app\DefaultApp\Models\Configuration::getValueOfConfiguraton("logo");
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
?>
<div class="row">
    <div class="col-md-12">
        <div class="no-print">
            <?php \systeme\Application\Application::block("menu_imagerie") ?>

        </div>
        <div class="card" style="margin:0px;padding: 0px;">
            <div class="card-header no-print">
                Resultat # <?= $id; ?>
            </div>
            <div class="card-body">
                <center class="no-print">
                    <a target="_blank" href="<?= $datax->resultat ?>">Afficher Image</a>
                </center>
                <div class="entete" style="">
                    <img style="height: 70px" src="<?= $logo ?>">
                    <p>
                    <h3 style="text-align: center;font-weight: bold;color: rgb(1,71,105)">CENTRE HOSPITALIER SAINTE
                        MARIE</h3>
                    <h4 style="text-align: center;color: rgb(1,71,105)">Service de Radiologie et d'Imagerie
                        Médicale</h4>
                    </p>

                    <hr>
                    <p>
                        <strong>Nom : </strong><?= ucfirst($patient->nom) ?><br>
                        <strong>Prénom : </strong><?= ucfirst($patient->prenom) ?><br>
                        <strong>Date : </strong><?= $demande->date_prelevement ?><br>
                        <strong>Date de Naissance : </strong><?= $patient->date_naissance ?><br>
                        <strong>Examen : </strong> <?= $nomImg ?><br>
                    </p>
                </div>
                <div class="">
                    <?php
                    if ($datax->getStatut() != "n/a") {
                        ?>
                        <br>
                        <h4 style="text-align: center;font-weight: bold">COMPTE RENDU</h4>
                        <br>
                        <p><?= stripslashes($datax->remarque) ?></p>
                        <br>
                        <p style="font-weight: bold">Impression</p>
                        <p><?= stripslashes($datax->conclusion) ?></p>
                        <?php
                    }
                    ?>
                    <br><br>
                    <div style="float: right;border-top: 3px solid black">Médecin Radiologue</div>
                </div>
            </div>
            <button onclick="window.print()" class="btn btn-primary btn-block no-print">Imprimer</button>
        </div>
    </div>
</div>
