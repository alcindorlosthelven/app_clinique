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

<h3>Modifier Patient</h3>
<div class="message"></div>
<form method="post" action="" class="form_add_docteur">
    <input type="hidden" name="update_patient">
    <input type="hidden" name="id" value="<?= $p->id ?>">
    <div class="row">
        <div class="form-group col-6" style="display: none">
            <label for="company">Code</label>
            <input readonly  value="<?= $p->code ?>" required type="text" class="form-control nom" id="code" name="code" placeholder="Code">
        </div>

        <div class="form-group col-6">
            <label for="company">No identité</label>
            <input value="<?= $p->no_identite ?>" required type="text" class="form-control no_identite"  name="no_identite"
                   placeholder="No identité">
        </div>

        <div class="form-group col-6">
            <label for="company">Nom</label>
            <input value="<?= $p->nom ?>" required type="text" class="form-control nom" id="nom" name="nom"
                   placeholder="Nom">
        </div>

        <div class="form-group col-6">
            <label for="company">Prénom</label>
            <input value="<?= $p->prenom ?>" required type="text" class="form-control  prenom" name="prenom"
                   placeholder="Prénom">
        </div>

        <div class="form-group col-6">
            <label for="company">Sexe</label>
            <select class="form-control" name="sexe">
                <option value="<?= $p->sexe ?>">
                    <?php
                    if($p->sexe=="m"){
                        echo "Masculin";
                    }else{
                        echo "Feminin";
                    }
                    ?>
                </option>
                <option value="m">Masculin</option>
                <option value="f">Feminin</option>
            </select>
        </div>

        <div class="form-group col-6">
            <label for="company">Date naissance</label>
            <input value="<?= $p->date_naissance ?>" required type="date" class="form-control"  name="date_naissance"
                   placeholder="date naissance">
        </div>

        <div class="form-group col-6">
            <label for="company">Telephone</label>
            <input value="<?= $p->telephone ?>" type="text" class="form-control" name="telephone"
                   placeholder="Telephone">
        </div>

        <div class="form-group col-6">
            <label for="company">Email</label>
            <input value="<?= $p->email ?>" type="text" class="form-control" name="email"
                   placeholder="Email">
        </div>

        <div class="form-group col-12">
            <input type="submit" value="Modifier" class="btn btn-success btn-lg btn-block"/>
        </div>

    </div>

</form>
