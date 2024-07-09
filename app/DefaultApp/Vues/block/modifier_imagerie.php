<?php
$ca = new \app\DefaultApp\Models\CategorieExamensImagerie();
$listeCategorie = $ca->findAll();

$id=$_GET['modifier'];
$obj=new \app\DefaultApp\Models\Imagerie();
$obj=$obj->findById($id);

$cat=$ca->findById($obj->id_categorie);

if (isset($_POST['modifier'])) {
    $ex = new \app\DefaultApp\Models\Imagerie();
    $ex=$ex->findById($_POST['id']);
    $ex->nom = trim(addslashes($_POST['nom']));
    $ex->nom_alternatif = trim(addslashes($_POST['nom']));
    $ex->id_categorie = $_POST['categorie'];
    $ex->devise = $_POST['devise'];
    $ex->cout = $_POST['cout'];
    $ex->prix = $_POST['prix'];
    $m = $ex->update();
    if ($m == "ok") {
        ?>
        <div class="alert alert-warning">Fait avec success</div>
        <script>
            alert("Fait avec success");
            location.href = 'imagerie?administration&examens&modifier=<?= $ex->id ?>';
        </script>
        <?php
    } else {
        ?>
        <div class="alert alert-warning"><?= $m ?></div>
        <?php
    }
}
?>
<form action='' method='post'>

    <div class="row">
        <div class="form-group col-md-6">
            <label>Nom</label>
            <input value="<?= $obj->nom ?>" type="text" name="nom" placeholder="Nom" class="form-control" required/>
        </div>

        <div class="form-group col-md-6">
            <label>Catégorie</label>
            <select name='categorie' class='form-control' required>
                <option value="<?= $obj->id_categorie ?>"><?= $cat->categorie ?></option>
                <?php
                if (isset($listeCategorie)) {
                    foreach ($listeCategorie as $cat) {
                        ?>
                        <option value="<?= $cat->getId() ?>"><?= $cat->getCategorie() ?></option>
                        <?php
                    }
                }
                ?>
            </select>
        </div>

        <div class='form-group col-md-6'>
            <label>Dévise</label>
            <select name='devise' class='form-control'>
                <option value="<?= $obj->devise ?>"><?= $obj->devise ?></option>
                <option value="htg">HTG</option>
                <option value="usd">USD</option>
            </select>
        </div>

        <div class='form-group col-md-6'>
            <label>Cout</label>
            <input value="<?= $obj->cout ?>" type='number' step="any"
                   required name='cout' class='form-control' placeholder='100.45'/>
        </div>

        <div class='form-group col-md-6'>
            <label>Prix</label>
            <input value="<?= $obj->prix ?>" type='number' step="any"
                   required name='prix' class='form-control' placeholder='100.54'/>
        </div>


        <div class="form-group pull-right col-md-12">
            <label>.</label>
            <input type='hidden' name='modifier'/>
            <input type='hidden' name='id' value="<?= $obj->id ?>" />
            <input type="submit" value="Modifier" class="btn btn-primary form-control">
        </div>
    </div>
</form>