<?php
function generateRandomCode($length = 6) {
    $code = '';
    for ($i = 0; $i <= $length; $i++) {
        $code .= rand(0, 9);
    }
    return $code;
}
$code=generateRandomCode(5)
?>

<h3>Ajouter patient</h3>
<div class="message"></div>
<form method="post" action="" class="form_submit">
    <input type="hidden" name="ajouter_patient">
    <div class="row">
        <div class="form-group col-6" style="display: none">
            <label for="company">Code</label>
            <input readonly  value="<?= $code ?>" required type="text" class="form-control nom" id="code" name="code" placeholder="Code">
        </div>

        <div class="form-group col-6">
            <label for="company">No identité</label>
            <input required type="text" class="form-control no_identite"  name="no_identite"
                   placeholder="No identité">
        </div>

        <div class="form-group col-6">
            <label for="company">Nom</label>
            <input required type="text" class="form-control nom" id="nom" name="nom"
                   placeholder="Nom">
        </div>

        <div class="form-group col-6">
            <label for="company">Prénom</label>
            <input required type="text" class="form-control  prenom" name="prenom"
                   placeholder="Prénom">
        </div>


        <div class="form-group col-6">
            <label for="company">Date naissance</label>
            <input required type="date" class="form-control"  name="date_naissance"
                   placeholder="date naissance">
        </div>

        <div class="form-group col-6">
            <label for="company">Telephone</label>
            <input type="text" class="form-control" name="telephone"
                   placeholder="Telephone">
        </div>

        <div class="form-group col-6">
            <label for="company">Email</label>
            <input type="text" class="form-control" name="email"
                   placeholder="Email">
        </div>

        <div class="form-group col-12">
            <input type="submit" value="Enregistrer" class="btn btn-success btn-lg btn-block"/>
        </div>

    </div>

</form>
