<?php
if(isset($_GET['print'])){
    require_once "print.php";
    return;
}

$date1=date("Y-m-d");
$date2=$date1;
if(isset($_POST['date1'])){
    $date1=$_POST['date1'];
    $date2=$_POST['date2'];
}

$f=new \app\DefaultApp\Models\Facture();
$liste=$f->listeParDate($date1,$date2);
?>
<div class="right-content mb-3">
    <div class="d-sm-flex align-items-center flex-xxl-nowrap flex-wrap">
        <br><br><br>
        <br><br><br>
        <div  class="col-xxl-12 col-lg-12 col-12 col align-items-center header-btn-grp justify-xxl-content-end justify-lg-content-center justify-content-start flex-nowrap pb-xxl-0 pb-lg-2 pb-2  nav">
            <a href="pos" class="ms-3 d-flex align-items-center justify-content-center nav-item nav-green"><i class="fa fa-bag-shopping cursor-pointer text-white fa-2x"></i></a>
            <a href="javascript:void(0)"  id="btn-fullscreen"
               class="ms-3 d-flex align-items-center justify-content-center nav-item">
                <i class="fa fa-presentation-screen cursor-pointer text-white fa-2x "></i>
            </a>
            <a href="<?= \app\DefaultApp\DefaultApp::genererUrl('dashboard') ?>"
               class="ms-3 d-flex align-items-center justify-content-center nav-item">
                <i class="fa fa-dashboard  fa-2x ursor-pointer text-white"></i>
            </a>
        </div>
    </div>
</div>
<div class="card" style="height: 1000px;margin: 10px">
    <div class="card-header">
        <?php
        if(isset($_GET['rapport'])){
            ?>
            <h2>Rapport</h2>
            <?php
        }else{
            ?>
            <h2>Liste des Factures</h2>
        <?php
        }
        ?>
    </div>
    <div class="card-body">
        <a class="btn btn-primary" href="pos?liste-commande">Liste des factures</a>
        <a class="btn btn-success" href="pos?liste-commande&rapport">Rapport</a><br><br>
        <?php
        if(isset($_GET['rapport'])){
            require_once "rapport.php";
        }else{
            ?>
            <form method="post">
                <div class="row">
                    <div class="form-group col-4">
                        <label>Debut</label>
                        <input value="<?= $date1 ?>" type="date" name="date1" class="form-control dp1" required>
                    </div>

                    <div class="form-group col-4">
                        <label>Fin</label>
                        <input value="<?= $date2 ?>" type="date" name="date2" class="form-control dp1" required>
                    </div>

                    <div class="col-4">
                        <label>.</label><br>
                        <input type="submit" value="Valider" class="btn btn-primary">
                    </div>

                </div>
            </form>
            <br><br>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Id</th>
                        <th>Type</th>
                        <th>Date / Heure</th>
                        <th>Methode Paiement</th>
                        <th>Sous total</th>
                        <th>Rabais</th>
                        <th>Total</th>
                        <th>Versement</th>
                        <th>Monnaie</th>
                        <th>Note</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php
                    foreach ($liste as $l){
                        ?>
                        <tr>
                            <td><a target="_blank" href="pos?liste-commande&print=<?= $l->id ?>">Print</a></td>
                            <td><?= $l->id ?></td>
                            <td><?= $l->type ?></td>
                            <td><?=$l->date?>/ <?= $l->heure ?></td>
                            <td><?= $l->methode_paiement ?></td>
                            <td><?= \app\DefaultApp\DefaultApp::formatComptable($l->montant) ?></td>
                            <td><?= \app\DefaultApp\DefaultApp::formatComptable($l->rabais) ?></td>
                            <td><?= \app\DefaultApp\DefaultApp::formatComptable($l->montant_apres_rabais) ?></td>
                            <td><?= \app\DefaultApp\DefaultApp::formatComptable($l->montant_apres_rabais+$l->monnaie) ?></td>
                            <td><?= $l->monnaie ?></td>
                            <td><?= $l->note ?></td>

                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        <?php
        }
        ?>
    </div>
</div>
