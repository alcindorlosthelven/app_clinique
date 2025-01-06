<?php
require "../vendor/autoload.php";

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

?>
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
    echo "Demande introuvable";
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
//$logo = \app\DefaultApp\DefaultApp::protocolApp() . $_SERVER['HTTP_HOST'] . "/hopital/" . \app\DefaultApp\Models\Configuration::getValueOfConfiguraton("logo");
$logo = \app\DefaultApp\DefaultApp::autre("logo.png");
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
$lien = "https://app.integra-sante.com/image-imagerie?id=" . $demande->id;
$result = Builder::create()
    ->writer(new PngWriter())
    ->data($lien)  // Remplacez par le texte ou l'URL que vous souhaitez encoder
    ->size(100)
    ->margin(4)
    ->build();

$anne_naisance = explode("-", $patient->date_naissance)[0];
$age = date("Y") - $anne_naisance;
?>

<div class="row">
    <div class="col-md-12">
        <div class="no-print">
            <?php \systeme\Application\Application::block("menu_imagerie") ?>
        </div>
        <?php
        if (isset($_GET['approuver'])) {
            if (isset($_POST['app'])) {
                $doc=$_POST['docteur'];
                if($doc=="deverson"){
                    $demande->deverson="oui";
                }
                if($doc=="exantus"){
                    $demande->exantus="oui";
                }
                $m=$demande->update();
                if($m=="ok"){
                    ?>
                    <script>
                        alert("Fait avec success");
                        location.href="afficher-resultat-imagerie-<?= $id ?>";
                    </script>
                    <?php
                }
            }
            ?>
            <form method="post">
                <input type="hidden" name="app">
                <fieldset>
                    <legend>Approuver par</legend>
                    <div class="form-group">
                        <select class="form-control" name="docteur">
                            <?php
                            if ($demande->deverson != "oui") {
                                ?>
                                <option value="deverson">Deverson</option>
                                <?php
                            }
                            if ($demande->exantus != "oui") {
                                ?>
                                <option value="exantus">Exantus</option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </fieldset>

                <input type="submit" class="btn btn-primary btn-block btn-xs" value="Valider">
            </form>
            <hr>
            <?php
        }
        ?>
        <div class="card" style="margin:0px;padding: 0px;">
            <div class="card-header no-print">
                Resultat # <?= $id; ?>
                <a target="_blank" href="image-imagerie?id=<?= $id ?>" class="btn btn-primary btn-xs">Voir image</a>

                <?php
                if($demande->deverson=="oui" and $demande->exantus=="oui"){

                }else{
                    ?>
                    <a class="btn btn-success no-print btn-xs" href="afficher-resultat-imagerie-<?= $id ?>?approuver">Approuver
                        par</a>
                <?php
                }
                ?>
                <a target="_blank" class="btn btn-primary no-print btn-xs"
                   href="print-imagerie?id=<?= $id ?>">Imprimer</a>
            </div>
            <div class="card-body">
                <center class="no-print" style="display: none">
                    <a target="_blank" href="<?= $datax->resultat ?>">Afficher Image</a>
                </center>
                <div class="entete" style="">
                    <p style="text-align: center;"><img alt="" style="height: 70px;text-align: center"
                                                        src="<?= $logo ?>">
                    <h3 style="text-align: center;font-weight: bold;color: rgb(1,71,105)">INTEGRA SANTÉ</h3>
                    <h4 style="text-align: center;color: rgb(1,71,105)">Radiodiagnostic</h4>
                    </p>

                    <hr>
                    <p>
                        <strong>Nom : </strong><?= ucfirst($patient->nom) ?><br>
                        <strong>Prénom : </strong><?= ucfirst($patient->prenom) ?><br>
                        <strong>Sexe : </strong><?= ucfirst($patient->sexe) ?><br>
                        <strong>Date de Naissance : </strong><?= $patient->date_naissance ?><br>
                        <strong>Age : </strong><?= $age ?> ans<br>
                        <strong>Examen : </strong> <?= $nomImg ?><br>
                        <strong>Date : </strong><?= $demande->date_prelevement ?><br>
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
                        <!--<br>
                        <p style="font-weight: bold">Impression</p>
                        <p><?php /*= stripslashes($datax->conclusion) */ ?></p>-->
                        <?php
                    }
                    ?>
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
                    <div style="text-align: center">
                        <img src="<?= $result->getDataUri(); ?>">
                    </div>
                    <br><br>
                    <div style="float: right;border-top: 3px solid black"></div>
                </div>
            </div>
        </div>
    </div>
</div>
