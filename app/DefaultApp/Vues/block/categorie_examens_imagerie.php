<?php
$role=\systeme\Model\Utilisateur::role();
if($role=="admin"){
    ?>
    <a href="imagerie?administration&categorie&ajouter" class="btn btn-primary btn-xs">Ajouter</a>
    <a href="imagerie?administration&categorie" class="btn btn-warning btn-xs">Lister</a>
    <hr>
<?php
}
use app\DefaultApp\Models\CategorieExamensImagerie;
if(isset($_GET['ajouter'])){
    if(isset($_POST['ajouter'])){
        $obj=new CategorieExamensImagerie();
        $obj->categorie=trim(addslashes($_POST['categorie']));
        $m=$obj->add();
        if($m=="ok"){
            ?>
            <div class="alert alert-success">Enregistrer avec success</div>
            <script>
                alert("Fait avec success");
                location.href = 'imagerie?administration&categorie';
            </script>
            <?php
        }else{
            ?>
            <div class="alert alert-warning"><?= $m ?></div>
            <?php
        }
    }
    ?>
    <form method="post">
        <fieldset>
            <div class="form-group">
                <label>Catégorie</label>
                <input type="text" name="categorie" required placeholder="Catégorie" class="form-control" required >
            </div>

            <br>
            <div class="form-group">
                <input type="hidden" name="ajouter">
                <input type="submit" value="Enregistrer" class="btn btn-primary btn-xs">
            </div>
        </fieldset>
    </form>
    <?php
}elseif(isset($_GET['modifier'])){
    $ca=new CategorieExamensImagerie();
    $ca=$ca->findById($_GET['modifier']);
    if(isset($_POST['modifier'])){
        $ca->categorie=$_POST['categorie'];
        $m=$ca->update();
        if($m=="ok"){
            ?>
            <div class="alert alert-success">Modifier avec success</div>
            <script>
                alert("Fait avec success");
                location.href = 'imagerie?administration&categorie';
            </script>
            <?php
        }else{
            ?>
            <div class="alert alert-warning"><?= $m ?></div>
            <?php
        }
    }
  ?>
    <h4>Modifier categorie imagerie</h4>
    <form method="post">
        <fieldset>
            <div class="form-group">
                <label>Catégorie</label>
                <input value="<?= $ca->categorie ?>" type="text" name="categorie" required placeholder="Catégorie" class="form-control" required >
            </div>
            <br>
            <div class="form-group">
                <input type="hidden" name="modifier">
                <input type="hidden" name="id" value="<?= $_GET['modifier'] ?>">
                <input type="submit" value="Modifier" class="btn btn-primary btn-xs">
            </div>
        </fieldset>
    </form>
    <?php
} else{
    $c=new CategorieExamensImagerie();
    if(isset($_GET['delete'])){
        $c->deleteById($_GET['delete']);
    }
    $listeCategorieExamen=$c->findAll();
    ?>
    <table class="table table-bordered datatable">
        <thead>
        <tr>
            <th>Id</th>
            <th>Categorie</th>

            <th></th>
        </tr>
        </thead>

        <tbody>
        <?php
        if (isset($listeCategorieExamen)){
            foreach ($listeCategorieExamen as $catE) {
                ?>
                <tr>
                    <td><?= $catE->getId() ?></td>
                    <td><?= $catE->getCategorie(); ?></td>
                    <th>
                        <?php
                        if($role=="admin"){
                            ?>
                            <a class="btn btn-xs btn-success" href="imagerie?administration&categorie&modifier=<?= $catE->id ?>">Modifier</a>
                            <a class="btn btn-xs btn-warning" href="imagerie?administration&categorie&delete=<?= $catE->id ?>">Supprimer</a>
                            <?php
                        }
                        ?>
                    </th>
                </tr>
                <?php
            }
        }
        ?>
        </tbody>
    </table>
<?php
}
?>

