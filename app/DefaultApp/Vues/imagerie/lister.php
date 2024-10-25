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
            <div class="card-header"><h4>Liste des Imageries</h4></div>

            <div class="card-body">
                <a style="<?php if(AccesUser::haveAcces("2.6.3.1")){echo $aficher;}else{echo $cache;}?>" href="<?= App::genererUrl("ajouter_imagerie");?>" class="btn btn-primary">Ajouter</a>
                <hr>
                <div class="table-responsive">
                    <table class="table table-bordered datatable">
                        <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Catégorie</th>
                            <th>Cout</th>
                            <th>Prix</th>
                            <th></th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php
                        if (isset($liste)) {
                            foreach ($liste as $img) {
                                $cate=new \app\DefaultApp\Models\CategorieExamensImagerie();
                                $cate=$cate->findById($img->getIdCategorie());
                                ?>
                                <tr>
                                    <td><?= $img->getNom();?></td>
                                    <td><?php
                                    if($cate!=null){
                                        echo $cate->getCategorie();
                                    }
                                        ?>
                                    </td>
                                    <td><?= $img->getCout() ?></td>
                                    <td><?= $img->getPrix() ?></td>
                                    <th>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-primary">Action</button>
                                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a class="dropdown-item" href="modifier-imagerie-<?= $img->getId() ?>">Modifier</a></li>
                                                <li><a class="dropdown-item" href="lister-imagerie?supprimer=<?= $img->getId() ?>">Supprimer</a></li>
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
</div>
