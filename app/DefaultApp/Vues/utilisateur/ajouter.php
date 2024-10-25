<?php

use app\DefaultApp\Models\AccesUser;

?>
<div class="row">
    <div class="col-md-12">
        <?= \systeme\Application\Application::block("menu_utilisateur") ?>
        <div class="card">
            <div class="card-header"><h4>Ajouter Utilisateur</h4></div>

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
                    <div class="alert alert-success">
                        <?= $success ?>
                    </div>
                    <script>
                        alert('<?=$success?>');
                        document.location.href = 'ajouter-utilisateur';
                    </script>
                    <?php
                }
                ?>


                <form method="post" action="">
                    <div class="row">

                        <div class="form-group col-6">
                            <label for="company">Nom</label>
                            <input required type="text" class="form-control nom" id="nom" name="nom"
                                   placeholder="Nom Utilisateur">
                        </div>

                        <div class="form-group col-6">
                            <label for="company">Prénom</label>
                            <input required type="text" class="form-control  prenom" name="prenom"
                                   placeholder="Prénom Utilisateur">
                        </div>

                        <div class="form-group col-6">
                            <label for="company">Pseudo</label>
                            <input required type="text" class="form-control identifiant" name="pseudo"
                                   placeholder="Pseudo" readonly>
                        </div>

                        <div class="form-group col-6">
                            <label for="company">Role</label>
                            <select class="form-control" name="role">
                                <option value="admin">Admin</option>
                                <option value="technicien">Technicien</option>
                                <option value="réceptionniste">Réceptionniste</option>
                                <option value="compatabilité">Comptabilité</option>
                            </select>
                        </div>

                        <div class="form-group col-6">
                            <label for="company">Motdepasse</label>
                            <input required type="password" class="form-control" id="prenom" name="motdepasse"
                                   placeholder="Motdepasse">
                        </div>

                        <div class="form-group col-6">
                            <label for="company">Confirmer Motdepasse</label>
                            <input required type="password" class="form-control" id="prenom"
                                   name="confirmermotdepasse"
                                   placeholder="Confirmer motdepasse">
                        </div>

                        <div class="form-group col-12">
                            <input type="submit" value="Enregistrer" class="btn btn-primary btn-lg btn-block"/>
                        </div>

                    </div>

                </form>


            </div>
        </div>


    </div>
</div>
