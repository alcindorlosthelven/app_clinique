<?php
$configuration=new \app\DefaultApp\Models\Configuration();
$liste=$configuration->findAll();
?>
<div class="">
    <br/>
    <div class="card">
        <div class="card-header">
            <i class="fa fa-align-justify"></i> Configuration du système
        </div>
        <div class="card-body">
            <div class="col-md-12">
                <div class="clearfix"></div>
                <div class="message"></div>
                <table class="table table-bordered col-md-12" style="width: 100%">
                    <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Valeur</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($liste as $conf) {
                        ?>
                        <tr>
                            <td><?= $conf->getNom(); ?></td>
                            <td><?= $conf->getValeur(); ?></td>
                            <td>
                                <?php
                                if ($conf->getCategorie() == "image") {
                                    ?>
                                    <img style="height: 55px;width: 55px" src="<?= $conf->getValeur() ?>">
                                    <?php
                                }
                                ?>
                            </td>
                            <td>
                                <form class="form-configuration" method="post"
                                      enctype="multipart/form-data">
                                    <?php
                                    if ($conf->getCategorie() == "text") {
                                            ?>
                                            <input required
                                                   value="<?= $conf->getValeur(); ?>"
                                                   type="text" name="valeur"
                                                   class="form-control">
                                            <?php
                                    } elseif ($conf->getCategorie() == "non_modifiable") {

                                    } else {
                                        ?>
                                        <input type="file" name="image" required
                                               class="form-control">
                                        <?php
                                    }
                                    if ($conf->getCategorie() !== "non_modifiable") {
                                        ?>
                                        <input type="hidden" name="id_configuration"
                                               value="<?= $conf->getId(); ?>">
                                        <input type="hidden" name="update_configuration"
                                               value="">
                                        <hr>
                                        <input class="btn btn-primary col-md-3"
                                               type="submit" value="Modifier">
                                        <?php
                                    }
                                    ?>
                                </form>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
                <div class="clearfix"></div>
                <div class="message"></div>
            </div>
        </div>
    </div>
</div>
