<?php

use app\DefaultApp\Models\AccesUser;

$cache = "display:none";
$aficher = "display:inline";
?>

<div class="row">
    <div class="col-md-12">
        <?php \systeme\Application\Application::block("menu_utilisateur") ?>
        <div class="card">
            <div class="card-header"><h4>Liste des Utilisateurs</h4></div>

            <div class="card-body">
                <table class="table table-bordered  datatable">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Pseudo</th>
                        <th>Role</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    if (isset($listeUtilisateur)) {
                        foreach ($listeUtilisateur as $utilisateur) {
                            if ($utilisateur->getPseudo() != "admin") {
                                if ($utilisateur->getPseudo() != "ljeff44") {
                                    ?>
                                    <tr>
                                        <th><a style="<?php if (AccesUser::haveAcces("6.3")) {
                                                echo $aficher;
                                            } else {
                                                echo $cache;
                                            } ?>" href="acces-utilisateur-<?= $utilisateur->getId() ?>">Liste Accès</a>
                                        </th>
                                        <td><?= strtoupper($utilisateur->getNom()); ?></td>
                                        <td><?= $utilisateur->getPrenom() ?></td>
                                        <td><?= $utilisateur->getPseudo(); ?></td>
                                        <td><?= $utilisateur->role ?></td>
                                        <td><a style="<?php if (AccesUser::haveAcces("6.4")) {
                                                echo $aficher;
                                            } else {
                                                echo $cache;
                                            } ?>" href="modifier-utilisateur-<?= $utilisateur->getId() ?>"><i
                                                        class="fa fa-edit"></i></a></td>
                                        <td>
                                            <?php
                                            if (\app\DefaultApp\Models\Utilisateur::hasAllAcces()) {
                                                ?>
                                                <a href="supprimer-utilisateur-<?= $utilisateur->getId() ?>"
                                                   class="delete">Supprimer</a>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                        }
                    } else {
                        echo "Variabl listeEleve existe pas";
                    }
                    ?>

                    </tbody>
                </table>
            </div>
        </div>


    </div>
</div>
