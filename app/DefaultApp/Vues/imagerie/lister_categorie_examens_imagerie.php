<?php
use systeme\Application\Application as  App;
use app\DefaultApp\Models\AccesUser;
$cache = "display:none";
$aficher = "display:inline";
?>


<div class="row">
    <div class="col-md-12">
        <?php \systeme\Application\Application::block("menu_imagerie") ?>
        <div class="card">
            <div class="card-header"><h4>Liste Catégorie Examens Imagerie</h4></div>
            <div class="card-body">
                <a style="<?php if(AccesUser::haveAcces("2.6.3.3")){echo $aficher;}else{echo $cache;} ?>" href="<?= App::genererUrl("ajouter_categorie_examens_imagerie");?>" class="btn btn-primary">Ajouter</a>
                <hr>
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
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary">Action</button>
                                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a class="dropdown-item" href="modifier-categorie-examens-imagerie-<?= $catE->getId() ?>">Modifier</a></li>
                                            <li><a class="dropdown-item" href="?supprimer=<?= $catE->getId() ?>">Supprimer</a></li>
                                        </ul>
                                    </div>

                                </th>
                            </tr>

                            <?php
                        }
                    }

                    ?>

                    </tbody>
                </table>
            </div>
        </div>


    </div>
</div>
