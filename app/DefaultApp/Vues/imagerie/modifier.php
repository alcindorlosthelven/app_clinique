<div class="row">
    <div class="col-md-12">
        <?= \systeme\Application\Application::block("menu_imagerie") ?>
        <div class="card">
            <div class="card-header"><h4>Modifier Examens Imagerie</h4></div>

            <div class="card-body">
                <?php

                if (isset($imagerie)) {
                    $id_categorie = $imagerie->getIdCategorie();
                    $id_devise = $imagerie->getDevise();
                    $categorie = new \app\DefaultApp\Models\CategorieExamensImagerie();
                    $categorie = $categorie->findById($id_categorie);
                    $devise = new \app\DefaultApp\Models\Devise();
                    $devise = $devise->findById($id_devise);
                }

                if (isset($erreur)) {
                    ?>
                    <div class="alert alert-warning"><?= $erreur ?></div>
                    <?php
                }

                if (isset($success)) {
                    ?>
                    <div class="alert alert-warning"><?= $success ?></div>
                    <script>
                        alert("<?= $success ?>");
                        location.href = 'lister-imagerie';
                    </script>
                    <?php
                }

                ?>
                <form action='' method='post'>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Nom</label>
                            <input value="<?php if (isset($imagerie)) echo $imagerie->getNom() ?>" type="text"
                                   name="nom" placeholder="Nom" class="form-control" required/>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Catégorie</label>
                            <select name='categorie' class='form-control'>
                                <?php
                                if (isset($categorie)) {
                                    ?>
                                    <option value="<?= $categorie->getId() ?>"><?= $categorie->getCategorie() ?></option>
                                    <?php
                                }
                                if (isset($listeCategorie)) {
                                    foreach ($listeCategorie as $cat) {
                                        ?>
                                        <option value="<?= $cat->getId() ?>"><?= $cat->getCategorie() ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class='form-group col-md-6'>
                            <label>Dévise</label>
                            <select name='devise' class='form-control'>
                                <?php
                                if (isset($devise)) {
                                    ?>
                                    <option value="<?= $devise->getId() ?>"><?= $devise->getDevise() ?></option>
                                    <?php
                                }
                                if (isset($listeDevise)) {
                                    foreach ($listeDevise as $devise) {
                                        ?>
                                        <option value="<?= $devise->getId() ?>"><?= strtoupper($devise->getDevise()) ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class='form-group col-md-6'>
                            <label>Cout</label>
                            <input value="<?php if (isset($imagerie)) echo $imagerie->getCout() ?>" type='number'
                                   step="any" required name='cout' class='form-control' placeholder='100.45'/>
                        </div>

                        <div class='form-group col-md-6'>
                            <label>Prix</label>
                            <input value="<?php if (isset($imagerie)) echo $imagerie->getPrix() ?>" type='number'
                                   step="any" required name='prix' class='form-control' placeholder='100.54'/>
                        </div>


                        <div class="form-group pull-right col-md-12">
                            <label>.</label>
                            <input type='hidden' name='modifier'/>
                            <input type="submit" value="Enregistrer" class="btn btn-primary form-control">
                        </div>
                    </div>
                </form>

            </div>
        </div>


    </div>
</div>