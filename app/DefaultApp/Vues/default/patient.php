<?php

use app\DefaultApp\Models\AccesUser;

$role = \systeme\Model\Utilisateur::role();
$p = new \app\DefaultApp\Models\Patient();
$listePatient = $p->findAll();
?>

<div class="row">
    <div class="col-md-12">
        <?php \systeme\Application\Application::block("menu_patient") ?>
        <div class="card shadow">
            <div class="card-header bg-success text-white" style="height: 25px;">
                <h7 class="mb-0">Gestion des Patients</h7>
            </div>
            <div class="card-body">
                <?php
                if (isset($_GET['ajouter'])) {
                    require_once "ajouter_patient.php";
                } elseif (isset($_GET['modifier'])) {
                    require_once "modifier_patient.php";
                } elseif(isset($_GET['afficher'])){
                    require_once "afficher_patient.php";
                } else{
                ?>
                    <div class="mb-3">
                        <input type="text" id="searchInput" class="form-control" onkeyup="filterTable()" placeholder="🔍 Rechercher un patient...">
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover" id="table">
                            <thead class="bg-success" style="background-color:rgb(35, 148, 58);">
                                <tr>
                                    <th>Code</th>
                                    <th>No identité</th>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Sexe</th>
                                    <th>Date naissance</th>
                                    <th>Téléphone</th>
                                    <th>Email</th>
                                    <th>Balance</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php foreach ($listePatient as $p) { ?>
                                    <tr>
                                        <td><?= $p->code ?></td>
                                        <td><?= $p->no_identite ?></td>
                                        <td><?= strtoupper($p->nom); ?></td>
                                        <td><?= strtoupper($p->prenom); ?></td>
                                        <td><?= strtoupper($p->sexe) ?></td>
                                        <td><?= $p->date_naissance ?></td>
                                        <td><?= $p->telephone ?></td>
                                        <td><?= $p->email ?></td>
                                        <td><?= \app\DefaultApp\DefaultApp::formatComptable($p->balance) ?></td>
                                        <td>
                                            <!-- Dropdown for Actions -->
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton<?= $p->id ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-v"></i> <!-- Three dots icon -->
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton<?= $p->id ?>">
                                                    <li>
                                                        <a class="dropdown-item" href="patient?modifier&id=<?= $p->id ?>">
                                                            <i class="fa fa-edit"></i> Modifier
                                                        </a>
                                                    </li>

                                                    <?php if ($role == "admin") { ?>
                                                        <li>
                                                            <a class="dropdown-item" href="patient?del=<?= $p->id ?>">
                                                                <i class="fa fa-trash"></i> Supprimer
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="patient?afficher&id=<?= $p->id ?>">
                                                                <i class="fa fa-list"></i> Afficher
                                                            </a>
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Modal Modification -->
                                    <div class="modal fade" id="mx-<?= $p->id ?>" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header bg-warning text-dark">
                                                    <h5 class="modal-title">Modifier Patient</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form method="post">
                                                    <input type="hidden" name="update_patient">
                                                    <input type="hidden" name="id" value="<?= $p->id ?>">
                                                    <div class="modal-body">
                                                        <div class="row g-3">
                                                            <div class="col-md-6">
                                                                <label for="no_identite" class="form-label">No identité</label>
                                                                <input type="text" class="form-control" name="no_identite" value="<?= $p->no_identite ?>" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="nom" class="form-label">Nom</label>
                                                                <input type="text" class="form-control" name="nom" value="<?= $p->nom ?>" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="prenom" class="form-label">Prénom</label>
                                                                <input type="text" class="form-control" name="prenom" value="<?= $p->prenom ?>" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="sexe" class="form-label">Sexe</label>
                                                                <select class="form-control" name="sexe">
                                                                    <option value="m" <?= $p->sexe == 'm' ? 'selected' : '' ?>>Masculin</option>
                                                                    <option value="f" <?= $p->sexe == 'f' ? 'selected' : '' ?>>Féminin</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="date_naissance" class="form-label">Date naissance</label>
                                                                <input type="date" class="form-control" name="date_naissance" value="<?= $p->date_naissance ?>" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="telephone" class="form-label">Téléphone</label>
                                                                <input type="text" class="form-control" name="telephone" value="<?= $p->telephone ?>" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="email" class="form-label">Email</label>
                                                                <input type="email" class="form-control" name="email" value="<?= $p->email ?>" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-success">Modifier</button>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                <?php } ?>

                            </tbody>
                        </table>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<script>
    function filterTable() {
        const input = document.getElementById("searchInput");
        const filter = input.value.toLowerCase();
        const table = document.getElementById("table");
        const rows = table.querySelectorAll("tbody tr");

        rows.forEach((row) => {
            const cells = row.querySelectorAll("td");
            const rowText = Array.from(cells)
                .map((cell) => cell.textContent.toLowerCase())
                .join(" ");

            if (rowText.includes(filter)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    }
</script>