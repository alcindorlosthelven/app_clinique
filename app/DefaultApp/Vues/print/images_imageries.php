<?php
require "../vendor/autoload.php";
if(!isset($_GET['id'])){
    return;
}
$id=$_GET['id'];

$demande = new \app\DefaultApp\Models\DemmandeImagerie();
$demande = $demande->findById($id);
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
$images=json_decode($datax->resultat);
?>
<div class="container-fluid">
        <div class="row">
            <?php
            foreach ($images as $i){
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
