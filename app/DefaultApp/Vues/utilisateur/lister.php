<?php

use app\DefaultApp\Models\AccesUser;

$role = \systeme\Model\Utilisateur::role();
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
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Pseudo</th>
                        <th>Role</th>
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
                                        <td><?= strtoupper($utilisateur->getNom()); ?></td>
                                        <td><?= $utilisateur->getPrenom() ?></td>
                                        <td><?= $utilisateur->getPseudo(); ?></td>
                                        <td><?= $utilisateur->role ?></td>
                                        <td>
                                            <?php
                                            if ($role == "admin") {
                                                ?>
                                                <a href="modifier-utilisateur-<?= $utilisateur->getId() ?>"><i
                                                            class="fa fa-edit"></i></a>
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
