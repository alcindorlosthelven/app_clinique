<?php

/**
 * pv.php
 * clinic
 * @author : fater04
 * @created :  12:38 - 2024-07-09
 **/
//if (!\systeme\Model\Utilisateur::session()) {
//systeme\Application\Application::redirection('login');
//}
$catIm = new \app\DefaultApp\Models\CategorieExamensImagerie();
$u1 = \systeme\Model\Utilisateur::session_valeur();

$med = new \app\DefaultApp\Models\PersonelMedical();
$listeMed = $med->listerMedecin();

$pat = new \app\DefaultApp\Models\Patient();
$listePatient = $pat->findAll();
if (isset($_GET['liste-commande'])) {
    require_once "liste_facture.php";
    return;
}
?>

<div class="d-flex flex-column flex-root">
    <div class="pos-screen px-3 container-fluid">
        <div class="row">
            <!--------------------------pay---------------------------->
            <div class="pos-left-scs col-xxl-4 col-lg-5 col-6">
                <div class="top-nav my-3">
                    <div class="align-items-center justify-content-between grp-select h-100 row">
                        <div class="select-box col-6 pe-sm-1 position-relative">
                            <div class="flex-nowrap  input-group">
                                <div class=" css-b62m3t-container">
                                    <div class=" css-1s2u09g-control">
                                        <label>Patient</label><span id="add_patient" style="cursor: pointer; color: white;float: right;font-size: 18px; font-weight: bold; border: 2px solidrgb(55, 201, 77);background-color:rgb(39, 206, 75);border-radius: 5px;"> + </span>
                                        <select class="form-control" data-live-search="true" id="id_patient">
                                            <?php
                                            foreach ($listePatient as $p) {
                                            ?>
                                                <option value="<?= $p->id ?>"><?= ucfirst($p->nom . " " . $p->prenom) ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="select-box col-6 ps-sm-2 position-relative">
                            <div class="input-group">
                                <div class=" css-b62m3t-container">
                                    <div class=" css-1s2u09g-control">
                                        <label>Médecin</label>
                                        <select class="form-control" id="id_medecin">
                                            <option value=""></option>
                                            <?php
                                            foreach ($listeMed as $med) {
                                            ?>
                                                <option value="<?= $med->id ?>"><?= ucfirst($med->nom . " " . $med->prenom) ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="left-content custom-card mb-3 p-3">
                    <div class="main-table overflow-auto " style="padding-right: 18px">
                        <table class="mb-0 table">
                            <thead class="position-sticky top-0">
                                <tr>
                                    <th>PRODUIT</th>
                                    <th class="">QTE</th>
                                    <th>PRIX</th>
                                    <th colspan="2">SOUS-TOTAL</th>
                                </tr>
                            </thead>
                            <tbody class="border-0" id="panier_produit">
                                <?php
                                $total = 0;
                                $Qt = 0;
                                foreach (\app\DefaultApp\Models\Panier::lister($u1) as $p2) {
                                    $total += ($p2->getQuantite() * $p2->getPrix());
                                    $Qt += $p2->getQuantite();
                                ?>
                                    <tr class="align-middle">
                                        <td class="text-nowrap text-nowrap ps-0">
                                            <h4
                                                class="product-name text-gray-900 mb-1 text-capitalize text-truncate">
                                                <?= $p2->getNom() ?></h4>
                                            <span class="product-sku"><span
                                                    class="badge bg-light-info sku-badge"><?= $p2->getNom() ?></span></span>
                                        </td>
                                        <td>
                                            <div class="counter d-flex align-items-center pos-custom-qty">
                                                <button type="button"
                                                    class="counter__down d-flex align-items-center justify-content-center btn btn-primary">
                                                    -
                                                </button>
                                                <input type="text" class="hide-arrow" value="<?= $p2->getQuantite() ?>">
                                                <button type="button"
                                                    class="counter__up d-flex align-items-center justify-content-center btn btn-primary">
                                                    +
                                                </button>
                                            </div>
                                        </td>
                                        <td class="text-nowrap"><?= $p2->getPrix() ?></td>
                                        <td class="text-nowrap"><?= $p2->getPrix() * $p2->getQuantite() ?></td>
                                        <td class="text-end remove-button pe-0">
                                            <a href="javascript:void(0)" data-id="<?= $p2->getProduit() ?>"
                                                class="p-0 bg-transparent border-0 btn btn-primary remove-to-cart">
                                                <i class="fa fa-trash text-danger"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="calculation mt-5" id="panier_montantccc">
                        <div class="total-price row ">
                            <div class="col-6 mb-2">

                                <div class="calculation__filed-grp mb-2">
                                    <div class="input-group">
                                        <input name="rabais" id="rabais" min="0" step="1" placeholder="Rabais"
                                            type="number" class="rounded-1 pe-13 form-control" value="">
                                        <span class="position-absolute top-0 bottom-0 end-0 bg-transparent border-0 input-group-text">
                                            <select class="tyr" style="margin-right: -10px">
                                                <option value="pourcentage">%</option>
                                                <option value="fixe">fixe</option>
                                            </select>
                                        </span>
                                    </div>
                                </div>


                                <div class="calculation__filed-grp mb-2">
                                    <div class="input-group">
                                        <input name="rabais_assurance" id="rabais_assurance" min="0" step="1"
                                            placeholder="Assurance" type="number"
                                            class="rounded-1 pe-8 form-control" value="">
                                        <span class="position-absolute top-0 bottom-0 end-0 bg-transparent border-0 input-group-text">
                                            <select class="tyra" style="margin-right: -10px">
                                                <option value="pourcentage">%</option>
                                                <option value="fixe">fixe</option>
                                            </select>
                                        </span>
                                    </div>
                                </div>

                            </div>
                            <div class="col-6 d-flex flex-column justify-content-center text-end align-items-end mb-2">
                                <h5 class="fs-5 mb-2  text-gray-600">Sous total : <span
                                        id="val_stotal"><?= $total ?></span></h5>
                                <h5 class="fs-5 mb-2  text-gray-600">Rabais : <span id="val_rabais">0</span></h5>
                                <h5 class="fs-5 mb-2  text-gray-600">Rabais assurance : <span id="val_rabais_assurance">0</span>
                                </h5>
                                <h3 class="fs-1 mb-2 text-gray-800">Total : HTG <span id="val_total"> <?= $total ?></span></h3>
                            </div>

                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <button style="display: none" type="button" id="btn_refresh"
                            class="text-white btn-info btn-rounded btn-block me-2 w-100 py-3 rounded-10 px-3 btn btn-anger">
                            Hold
                            <i class="fas fa-hand"></i>
                        </button>
                        <button type="button" id="btn-reset-panier"
                            class="text-white btn-danger btn-rounded btn-block me-2 w-100 py-3 rounded-10 px-3 btn btn-anger">
                            Reset
                            <i class="fas fa-refresh"></i>
                        </button>
                        <button type="button" id="btn_payer"
                            class="text-white w-100 py-3 rounded-10 px-3 pos-pay-btn btn btn-success">Payer
                            <i class="fa fa-money-bill"></i></button>
                    </div>
                </div>
            </div>

            <!---------------end section------------------------------->
            <div class="ps-lg-0 pos-right-scs col-xxl-8 col-lg-7 col-6">
                <div class="right-content mb-3">
                    <div class="d-sm-flex align-items-center flex-xxl-nowrap flex-wrap">
                        <div class="position-relative my-3 search-bar col-xxl-7 col-lg-7 col-7 col">
                            <div class="sc-dPyBCJ dzwQAX">
                                <div class="wrapper">
                                    <div class="sc-jOrMOR kzVpxy">
                                        <input name="rechercher" id="rechercher_produit"
                                            placeholder="rechercher produit" type="text">
                                    </div>
                                </div>
                            </div>
                            <i class="fa fa-search fa-2x react-search-icon position-absolute mt-2  d-flex align-items-center ms-2"></i>
                        </div>
                        <div class="col-xxl-5 col-lg-5 col-5 col align-items-center header-btn-grp justify-xxl-content-end justify-lg-content-center justify-content-start flex-nowrap pb-xxl-0 pb-lg-2 pb-2  nav">

                            <div class="d-flex align-items-center position-relative justify-content-center ms-3 nav-pink nav-item">
                                <a href="pos?liste-commande" class="pe-0 ps-1 text-white nav-link" role="button">
                                    <i class="fa fa-list fa-2x"></i>
                                </a>
                            </div>


                            <a href="javascript:void(0)" id="btn-fullscreen"
                                class="ms-3 d-flex align-items-center justify-content-center nav-item">
                                <i class="fa fa-presentation-screen cursor-pointer text-white fa-2x "></i>
                            </a>
                            <a href="<?= \app\DefaultApp\DefaultApp::genererUrl('dashboard') ?>"
                                class="ms-3 d-flex align-items-center justify-content-center nav-item">
                                <i class="fa fa-dashboard  fa-2x ursor-pointer text-white"></i>
                            </a>


                        </div>
                    </div>

                    <div class="custom-card h-100">
                        <div class="p-3">
                            <div class="button-list mb-2 d-flex flex-wrap nav">
                                <div class="button-list__item me-2  nav-item ">
                                    <a href="javascript:void(0)" style="font-size:  12px"
                                        class="categorie_produits btn btn-light btn-sm mb-2 button-list__item-active text-white"
                                        data-id="0" data-nom="all">
                                        Tous les categories
                                    </a>
                                    <?php foreach ($catIm->findAll() as $ca1) { ?>
                                        <a href="javascript:void(0)" data-id="<?= $ca1->getId() ?>"
                                            style="font-size:  12px"
                                            data-nom="<?= $ca1->getCategorie() ?>"
                                            class="categorie_produits btn-sm mb-2  btn btn-light  button-list__item">
                                            <?= strtolower($ca1->getCategorie()) ?>
                                        </a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class=" product-list-block pt-1">
                            <div class="d-flex flex-wrap product-list-block__product-block" id="liste_produits"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div></div>
</div>
<div id="space_show_modal">
</div>
<!-- Modal -->
<div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="productModalLabel">
                    <i class="fas fa-user-plus"></i> Ajouter un Patient
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <div class="message"></div>
                <form method="post" action="" class="form_submit">
                    <input type="hidden" name="ajouter_patient">

                    <div class="row g-3">
                        <!-- No Identité -->
                        <div class="col-md-6">
                            <label for="no_identite" class="form-label"><i class="fas fa-id-card"></i> No Identité</label>
                            <input required type="text" class="form-control" name="no_identite" placeholder="Ex: 12345678">
                        </div>

                        <!-- Nom -->
                        <div class="col-md-6">
                            <label for="nom" class="form-label"><i class="fas fa-user"></i> Nom</label>
                            <input required type="text" class="form-control" id="nom" name="nom" placeholder="Ex: Dupont">
                        </div>

                        <!-- Prénom -->
                        <div class="col-md-6">
                            <label for="prenom" class="form-label"><i class="fas fa-user"></i> Prénom</label>
                            <input required type="text" class="form-control" name="prenom" placeholder="Ex: Jean">
                        </div>

                        <!-- Sexe -->
                        <div class="col-md-6">
                            <label for="sexe" class="form-label"><i class="fas fa-venus-mars"></i> Sexe</label>
                            <select class="form-select" name="sexe">
                                <option value="m">Masculin</option>
                                <option value="f">Féminin</option>
                            </select>
                        </div>

                        <!-- Date de naissance -->
                        <div class="col-md-6">
                            <label for="date_naissance" class="form-label"><i class="fas fa-calendar"></i> Date de naissance</label>
                            <input required type="date" class="form-control" name="date_naissance">
                        </div>

                        <!-- Téléphone -->
                        <div class="col-md-6">
                            <label for="telephone" class="form-label"><i class="fas fa-phone"></i> Téléphone</label>
                            <input type="text" class="form-control" name="telephone" placeholder="Ex: +33 6 12 34 56 78">
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <label for="email" class="form-label"><i class="fas fa-envelope"></i> Email</label>
                            <input type="email" class="form-control" name="email" placeholder="Ex: exemple@mail.com">
                        </div>

                        <!-- Submit Button -->
                        <div class="col-12 text-center mt-4">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-save"></i> Enregistrer
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Ajout de FontAwesome pour les icônes -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js'">
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('add_patient').addEventListener('click', function() {
            console.log('pop up show');
            // Use Bootstrap's modal method to show the modal
            const modal = new bootstrap.Modal(document.getElementById('productModal'));
            modal.show();
        });
    });
    document.querySelector(".form_submit").addEventListener("submit", function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        fetch("app/DefaultApp/traitements/traitements.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                if (data.trim() === "ok") {
                    alert("Fait avec succès");
                    location.reload();
                } else {
                    document.querySelector(".message").innerHTML =
                        "<div class='alert alert-warning'>" + data + "</div>";
                }
            })
            .catch(error => console.error("Erreur :", error));
    });
   
</script>