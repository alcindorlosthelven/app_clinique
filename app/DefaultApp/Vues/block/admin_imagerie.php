
<?php
use systeme\Application\Application as  App;
use app\DefaultApp\Models\AccesUser;
$cache = "display:none";
$aficher = "display:inline";
?>
<a  href="imagerie?administration&categorie" class="btn btn-warning">Catégories</a>
<a  href="imagerie?administration&examens" class="btn btn-success">Examens</a>
<br><br>
<div class="card">
    <div class="card-body">
        <?php
        if(isset($_GET['categorie'])){
            require_once "categorie_examens_imagerie.php";
        }elseif(isset($_GET['examens'])){
            ab:
            require_once "liste_imagerie.php";
        }else{
            goto ab;
        }
        ?>
    </div>
</div>
