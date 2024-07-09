<?php

use app\DefaultApp\Models\AccesUser;
if (!isset($user)) {
    return;
}
$id_entreprise=\app\DefaultApp\Models\Utilisateur::getEntreprise()->id;

if(!\app\DefaultApp\Models\Utilisateur::hasAllAcces()) {

    if ($user->id_entreprise !== $id_entreprise) {
        echo "Access non autorisé...";
        return;
    }

    if ($user->nom = "admin" and $user->prenom == "admin" and $user->pseudo == "admin") {
        echo "Access non autorisé...";
        return;
    }

}


?>
<div class="row">
    <div class="col-md-12">
        <?php \systeme\Application\Application::block("menu_utilisateur") ?>
        <div class="card">
            <div class="card-header">
                <h4>Modifier Utilisateur</h4>
            </div>
            <div class="card-body">
                <?php


                if (isset($erreur)) {
                    ?>
                    <div class="alert alert-danger">
                        <?= $erreur ?>
                    </div>
                    <?php
                }
                ?>

                <?php
                if (isset($success)) {
                    ?>
                    <script>
                        alert(<?=$success?>);
                    </script>
                    <div class="alert alert-success">
                        <?= $success ?>
                    </div>
                    <?php
                }
                ?>


                <form method="post" action="" enctype="multipart/form-data">
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="company">Nom</label>
                            <input value="<?= $user->getNom() ?>" required type="text" class="form-control" id="nom"
                                   name="nom"
                                   placeholder="Nom Utilisateur">
                        </div>

                        <div class="form-group col-6">
                            <label for="company">Prenom</label>
                            <input value="<?= $user->getPrenom() ?>" required type="text" class="form-control"
                                   id="prenom" name="prenom"
                                   placeholder="Prenom Utilisateur">
                        </div>

                        <div class="form-group col-6">
                            <label for="company">Pseudo</label>
                            <input value="<?= $user->getPseudo() ?>" readonly required type="text" class="form-control"
                                   id="prenom" name="pseudo" placeholder="Pseudo">
                        </div>

                        <div class="form-group col-6">
                            <label for="company">Role</label>
                            <select class="form-control" name="role">
                                <option value="<?= $user->role ?>"><?= ucfirst($user->role) ?></option>
                                <option value="admin">Admin</option>
                                <?php
                                if(AccesUser::haveAcces("0.5",\systeme\Model\Utilisateur::session_valeur())){
                                    ?>
                                    <option value="superviseur">Superviseur</option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group col-6">
                            <label for="company">Motdepasse</label>
                            <input value="xxxx" required type="password" class="form-control" id="prenom"
                                   name="motdepasse"
                                   placeholder="Motdepasse">
                        </div>

                        <div class="form-group col-6">
                            <label for="company">Confirmer Motdepasse</label>
                            <input value="xxxx" required type="password" class="form-control" id="prenom"
                                   name="confirmermotdepasse"
                                   placeholder="Confirmer motdepasse">
                        </div>
                    </div>

                    <div class="form-group col-12">
                        <input type="submit" value="Modifier" class="btn btn-primary btn-block"/>
                    </div>

                </form>

            </div>
        </div>
