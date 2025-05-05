<?php
function generateRandomCode($length = 6) {
    $code = '';
    for ($i = 0; $i <= $length; $i++) {
        $code .= rand(0, 9);
    }
    return $code;
}
$code=generateRandomCode(5);

if(!isset($_GET['id'])){
    return;
}

$p=new \app\DefaultApp\Models\Patient();
$p=$p->findById($_GET['id']);

if($p==null){
    return;
}

?>

<h5>Patient</h5>
<div class="message"></div>
<form method="post" action="" class="form_add_docteur">
    <input type="hidden" name="update_balance_patient">
    <input type="hidden" name="id" value="<?= $p->id ?>">
    <div class="row">
        <div class="form-group col-6" style="display: none">
            <label for="company">Code</label>
            <input readonly  value="<?= $p->code ?>" type="text" class="form-control nom" id="code" name="code" placeholder="Code">
        </div>

        <div class="form-group col-6">
            <label for="company">No identité</label>
            <input value="<?= $p->no_identite ?>" readonly type="text" class="form-control no_identite"  name="no_identite"
                   placeholder="No identité">
        </div>

        <div class="form-group col-6">
            <label for="company">Nom</label>
            <input value="<?= $p->nom ?>" readonly type="text" class="form-control nom" id="nom" name="nom"
                   placeholder="Nom">
        </div>

        <div class="form-group col-6">
            <label for="company">Prénom</label>
            <input value="<?= $p->prenom ?>" readonly type="text" class="form-control  prenom" name="prenom"
                   placeholder="Prénom">
        </div>

        <div class="form-group col-6">
            <label for="company">Sexe</label>
            <select class="form-control" name="sexe" readonly>
                <option value="<?= $p->sexe ?>">
                    <?php
                    if($p->sexe=="m"){
                        echo "Masculin";
                    }else{
                        echo "Feminin";
                    }
                    ?>
                </option>
               
            </select>
        </div>

        <div class="form-group col-6">
            <label for="company">Balance</label>
            <input value="<?= $p->balance ?>" readonly class="form-control"  name="balance"
                   placeholder="date naissance">

        </div>

       

      

        <div class="row" style="height: 10px">
            <input type="submit" value="Payer" class="btn btn-success col-6"/>
            <input type="submit" value="Payer" class="btn btn-success col-6"/>


        </div>

    </div>

</form>
