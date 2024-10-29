<div class="card-body">
    <h4>Examens imagerie disponible</h4>
    <?php
    $role=\systeme\Model\Utilisateur::role();
    if($role=="admin"){
        ?>
        <a href="imagerie?administration&examens&ajouter" class="btn btn-primary btn-xs">Ajouter</a>
        <a href="imagerie?administration&examens" class="btn btn-warning btn-xs">Lister</a>
    <?php
    }
    ?>

    <hr>
    <?php
    if (isset($_GET['ajouter'])) {
        require_once "ajouter_imagerie.php";
    } elseif (isset($_GET['modifier'])) {
        require_once "modifier_imagerie.php";
    } else {
        ?>
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
                $ex = new \app\DefaultApp\Models\Imagerie();
                if(isset($_GET['supprimer'])){
                    $ex->deleteById($_GET['supprimer']);
                }

                $liste = $ex->findAll();
                if (isset($liste)) {
                    foreach ($liste as $img) {
                        $cate = new \app\DefaultApp\Models\CategorieExamensImagerie();
                        $cate = $cate->findById($img->getIdCategorie());
                        ?>
                        <tr>
                            <td><?= $img->getNom(); ?></td>
                            <td><?php
                                if ($cate != null) {
                                    echo $cate->getCategorie();
                                }
                                ?>
                            </td>
                            <td><?= $img->getCout() ?></td>
                            <td><?= $img->getPrix() ?></td>
                            <th>
                                <?php
                                if($role=="admin"){
                                    ?>
                                    <a class="btn btn-primary btn-xs"
                                       href="imagerie?administration&examens&modifier=<?= $img->id ?>">Modifier</a>
                                    <a class="btn btn-danger btn-xs"
                                       href="imagerie?administration&examens&supprimer=<?= $img->id ?>">Supprimer</a>
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
        </div>
        <?php
    }
    ?>
</div>
