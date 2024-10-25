<?php

use app\DefaultApp\Models\AccesUser;

$cache = "display:none";
$aficher = "display:inline";

$p = new \app\DefaultApp\Models\Patient();
$listePatient = $p->findAll();
?>

<div class="row">
    <div class="col-md-12">
        <?php \systeme\Application\Application::block("menu_patient") ?>
        <div class="card">
            <div class="card-body">
                <?php
                if (isset($_GET['ajouter'])) {
                    require_once "ajouter_patient.php";
                } else {
                    ?>
                    <div class="table-responsive" style="font-size: 12px">
                        <table class="table table-bordered  datatable">
                            <thead>
                            <tr>
                                <th>Code</th>
                                <th>No identité</th>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Date naissance</th>
                                <th>Téléphone</th>
                                <th>Email</th>
                                <th>Balance</th>
                                <td></td>
                            </tr>
                            </thead>
                            <tbody>

                            <?php
                            foreach ($listePatient as $p) {
                                ?>
                                <tr>
                                    <td><?= $p->code ?></td>
                                    <td><?= $p->no_identite ?></td>
                                    <td><?= strtoupper($p->nom); ?></td>
                                    <td><?= strtoupper($p->prenom); ?></td>
                                    <td><?= $p->date_naissance ?></td>
                                    <td><?= $p->telephone ?></td>
                                    <td><?= $p->email ?></td>
                                    <td><?= \app\DefaultApp\DefaultApp::formatComptable($p->balance) ?></td>
                                    <td>
                                        <a data-bs-toggle="modal" data-bs-target="#mx-<?= $p->id ?>"
                                           href="javascript:void(0);"
                                           class="btn btn-outline-primary btn-rounded btn-sm"><i class="fa fa-edit"></i></a>
                                        <a href="medecin?del=<?= $p->id ?>"
                                           class="btn btn-outline-danger btn-rounded btn-sm"><i
                                                    class="fa fa-remove"></i></a>
                                    </td>
                                </tr>

                                <div class="modal fade" id="mx-<?= $p->id ?>" tabindex="-1" aria-labelledby="exampleModalLabel-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel-1">Update Doctor</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="message"></div>
                                            <form method="post" class="form_add_docteur">
                                                <input type="hidden" name="update_patient">
                                                <input type="hidden" name="id" value="<?= $p->id ?>">
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="form-group col-6" style="display: none">
                                                            <label for="company">Code</label>
                                                            <input readonly  value="<?= $p->code ?>" required type="text" class="form-control nom" id="code" name="code" placeholder="Code">
                                                        </div>

                                                        <div class="form-group col-6">
                                                            <label for="company">No identité</label>
                                                            <input value="<?= $p->no_identite ?>" required type="text" class="form-control" name="no_identite">
                                                        </div>

                                                        <div class="form-group col-6">
                                                            <label for="company">Nom</label>
                                                            <input value="<?= $p->nom ?>" required type="text" class="form-control nom" id="nom" name="nom"
                                                                   placeholder="Nom">
                                                        </div>

                                                        <div class="form-group col-6">
                                                            <label for="company">Prénom</label>
                                                            <input value="<?= $p->prenom ?>" required type="text" class="form-control  prenom" name="prenom"
                                                                   placeholder="Prénom">
                                                        </div>


                                                        <div class="form-group col-6">
                                                            <label for="company">Date naissance</label>
                                                            <input value="<?= $p->date_naissance ?>" required type="date" class="form-control"  name="date_naissance"
                                                                   placeholder="date naissance">
                                                        </div>

                                                        <div class="form-group col-6">
                                                            <label for="company">Téléphone</label>
                                                            <input value="<?=$p->telephone  ?>" required type="text" class="form-control" name="telephone"
                                                                   placeholder="Telephone">
                                                        </div>

                                                        <div class="form-group col-6">
                                                            <label for="company">Email</label>
                                                            <input readonly value="<?= $p->email ?>" required type="text" class="form-control" name="email"
                                                                   placeholder="Email">
                                                        </div>

                                                        <div class="form-group col-12">
                                                            <input type="submit" value="Modifier" class="btn btn-success btn-lg btn-block"/>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-warning light" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <?php
                            }

                            ?>
                            </tbody>
                        </table>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>


    </div>
</div>
