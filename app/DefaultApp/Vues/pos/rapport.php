<?php
$date1 = date("Y-m-d");
$date2 = $date1;
$methode="tout";
if(isset($_POST['rapport'])){
    $date1=$_POST['date1'];
    $date2=$_POST['date2'];
    $methode=$_POST['methode'];
}

$f=new \app\DefaultApp\Models\Facture();
$liste=$f->listeParDateRapport($date1,$date2,$methode);
$totalTransaction=count($liste);
$montant_total=0;
foreach ($liste as $l){
    $montant_total+=$l->montant_apres_rabais;
}
?>
<form method="post">
    <input type="hidden" name="rapport">
    <div class="row">
        <div class="form-group col-3">
            <label>Debut</label>
            <input value="<?= $date1 ?>" type="date" name="date1" class="form-control dp1" required>
        </div>

        <div class="form-group col-3">
            <label>Fin</label>
            <input value="<?= $date2 ?>" type="date" name="date2" class="form-control dp1" required>
        </div>

        <div class="form-group col-3">
            <label>Methode paiement</label>
            <select class="form-control" name="methode" required>
                <option value="tout">Tout</option>
                <option value="cash">Cash</option>
                <option value="cheque">Cheque</option>
                <option value="credit">Credit</option>
            </select>
        </div>

        <div class="col-3">
            <label>.</label><br>
            <input type="submit" value="Valider" class="btn btn-primary">
        </div>

    </div>
</form>
<br><br>
<div style="text-align: center;">
    <h3>Rapport</h3>
    <?= $date1 ?> / <?= $date2 ?><br>
    <?= $methode ?>
</div>

<table class="table">
    <tr>
        <th>Methode Paiement</th>
        <td> <?= $methode ?></td>
    </tr>
    <tr>
        <th>Total transactions</th>
        <td> <?= $totalTransaction ?></td>
    </tr>
    <tr>
        <th>Montant</th>
        <td><?= \app\DefaultApp\DefaultApp::formatComptable($montant_total) ?></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
    </tr>

</table>
