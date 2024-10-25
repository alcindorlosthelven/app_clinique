<?php

use app\DefaultApp\Models\Entreprise;
use app\DefaultApp\Models\Panier;
use app\DefaultApp\Models\Utilisateur;

require_once "../../../vendor/autoload.php";
$userId =  \systeme\Model\Utilisateur::session_valeur();

if (isset($_GET['liste'])) {
    $input = $_GET['liste'];
    $ima=new \app\DefaultApp\Models\Imagerie();
    $Listproduits = $ima->findAll();
    $resultat = array();
    $data = "";
    foreach ($Listproduits as $pr1) {
        $data .= '<div class="product-custom-card" data-id="' . $pr1->getId() . '" data-prix="' . $pr1->getPrix() . '" data-nom="' . $pr1->getNom() . '" data-description="' . $pr1->getNomAlternatif() . '">
                                            <div class="position-relative h-100 card">
                                                <img class="card-img-top" src="public/pos/free_image.jpg" alt="">
                                                <div class="px-2 pt-2 pb-1 custom-card-body card-body">
                                                    <h6 class="product-title mb-0 text-gray-900">' . $pr1->getNom() . '</h6>
                                                    <span class="fs-small text-gray-700">' . $pr1->getNomAlternatif() . '</span>
                                                  
                                                    <p class="m-1 item-badge">
                                                        <span class="product-custom-card__card-badge badge text-white bg-primary"> ' . $pr1->getDevise() . ' ' . $pr1->getPrix() . ' </span>
                                                    </p>
                                                    </div>
                                            </div>
                                        </div>';
    }
    $data .= '<script type="text/javascript">
    $("document").ready(function () {
      $(".product-custom-card").on("click", (function (e) {
        var produit = $(this).data("id");
        var prix = $(this).data("prix");
        var nom = $(this).data("nom");
        var descrition= $(this).data("description");
        $("#ajax-loading").show();
        e.preventDefault();
         $.ajax({
            url: "app/DefaultApp/traitements/produits.php?ajouter_produit="+produit+"&prix="+prix+"&nom="+nom+"&description="+descrition,
            type: "GET",
            data: "",
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                $("#ajax-loading").hide();
               var r = $.parseJSON(data);
               if(r.status==="ok"){
                $("#panier_produit").empty();
                $("#panier_montant").empty();
                $("#panier_produit").html(r.data);
                $("#panier_montant").html(r.footer);
                toastr.info(r.message);
                }else{
                     toastr.warning(r.message);
                }
            }
        });
      }));
    });</script>';
    $resultat['data'] = $data;
    echo json_encode($resultat);
}

if (isset($_GET['ajouter_produit'])) {
    $resultat = array();
    $produit = $_GET['ajouter_produit'];
    $prix = $_GET['prix'];
    $nom = $_GET['nom'];
    $description = $_GET['description'];
    $quantite = '1';
    $option = '';
    $footer = '';
    $data = '';



        $r = \app\DefaultApp\Models\Panier::updatePanier($produit, $prix, $userId, $nom, $description, $option);
        $taxe = 0;
        $stotal = 0.00;
        $total = 0.00;
        $Qt = 0;
        foreach (\app\DefaultApp\Models\Panier::lister($userId) as $p2) {
            $total += ($p2->getQuantite() * $p2->getPrix());
            $Qt += $p2->getQuantite();
            $data .= ' <tr class="align-middle">
                                    <td class="text-nowrap text-nowrap ps-0"><h4
                                                class="product-name text-gray-900 mb-1 text-capitalize text-truncate">
                                            ' . $p2->getNom() . '</h4><span class="product-sku"><span
                                                    class="badge bg-light-info sku-badge">' . $p2->getDescription() . '</span>
                                                  </span>
                                    </td>
                                    <td>
                                        <div class="counter d-flex align-items-center pos-custom-qty">
                                            <button type="button"
                                                    class="counter__down d-flex align-items-center justify-content-center btn btn-primary">
                                                -
                                            </button>
                                            <input type="text" class="hide-arrow" value="' . $p2->getQuantite() . '">
                                            <button type="button"
                                                    class="counter__up d-flex align-items-center justify-content-center btn btn-primary">
                                                +
                                            </button>
                                        </div>
                                    </td>
                                    <td class="text-nowrap">$ ' . $p2->getPrix() . '</td>
                                    <td class="text-nowrap">$ ' . $p2->getQuantite() * $p2->getPrix() . '</td>
                                    <td class="text-end remove-button pe-0">
                                            <a href="javascript:void(0)" data-id="' . $p2->getProduit() . '"
                                               class="p-0 bg-transparent border-0 btn btn-primary remove-to-cart">
                                                <i class="fa fa-trash text-danger"></i>
                                            </a>
                                        </td>
                                </tr>';
        }
        $data .= '<script>$(".remove-to-cart").on("click", (function (e) {
    $("#ajax-loading").show();
        var id = $(this).data("id");
        e.preventDefault();
        $.ajax({
            url: "app/DefaultApp/traitements/produits.php?remove_panier=" + id,
            type: "GET",
            data: "",
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                $("#ajax-loading").hide();
                var r = $.parseJSON(data);
                    $("#panier_produit").empty();
                    $("#panier_montant").empty();
                    $("#panier_produit").html(r.data);
                    $("#panier_montant").html(r.footer);
                    toastr.info("produit retirer du panier");
            }
        });
    }));
    </script>';
        $footer = '<div class="total-price row">
                                <div class="col-6 mb-2">
                                    <div class="calculation__filed-grp mb-2">
                                        <div class="input-group">
                                            <input name="taxe" id="taxe" min="0" step=".01" placeholder="Taxe"
                                                   type="text" class="rounded-1 pe-8 form-control" value="">
                                            <span class="position-absolute top-0 bottom-0 end-0 bg-transparent border-0 input-group-text">%</span>
                                        </div>
                                    </div>
                                    <div class="calculation__filed-grp mb-2">
                                        <div class="input-group">
                                            <input name="rabais" id="rabais" min="0" step=".01" placeholder="Rabais"
                                                   type="text" class="rounded-1 pe-8 form-control" value="">
                                            <span class="position-absolute top-0 bottom-0 end-0 bg-transparent border-0 input-group-text">Gdes</span>
                                        </div>
                                    </div>
                                    <div class="calculation__filed-grp mb-2">
                                        <div class="input-group">
                                            <input name="livraison" id="livraison" min="0" step=".01"
                                                   placeholder="Livraison" type="text"
                                                   class="rounded-1 pe-8 form-control" value="">
                                            <span class="position-absolute top-0 bottom-0 end-0 bg-transparent border-0 input-group-text">Gdes</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 d-flex flex-column justify-content-center text-end align-items-end mb-2">
                                    <h4 class="fs-3 mb-2 custom-big-content text-gray-600">Total QTY : ' . $Qt . '</h4>
                                    <h2 class="fs-1 mb-2 text-gray-800">Total : Gdes ' . $total . '</h2></div>
                            </div>';
        $resultat['status'] = 'ok';
        $resultat['message'] = 'Produit ajouté au panier';
        $resultat['data'] = $data;
        $resultat['footer'] = $footer;


    echo json_encode($resultat);
}

if (isset($_GET['remove_panier'])) {
    $resultat = array();
    $produit = $_GET['remove_panier'];
    $r = \app\DefaultApp\Models\Panier::delete($produit, $userId);


    $data = '';
    $taxe = 0;
    $stotal = 0.00;
    $total = 0.00;
    $Qt = 0;
    $footer = '';

    foreach (\app\DefaultApp\Models\Panier::lister($userId) as $p2) {
        $total += ($p2->getQuantite() * $p2->getPrix());
        $Qt += $p2->getQuantite();
        $data .= ' <tr class="align-middle">
                                    <td class="text-nowrap text-nowrap ps-0"><h4
                                                class="product-name text-gray-900 mb-1 text-capitalize text-truncate">
                                            ' . $p2->getNom() . '</h4><span class="product-sku"><span
                                                    class="badge bg-light-info sku-badge">' . $p2->getDescription() . '</span>
                                                  </span>
                                    </td>
                                    <td>
                                        <div class="counter d-flex align-items-center pos-custom-qty">
                                            <button type="button"
                                                    class="counter__down d-flex align-items-center justify-content-center btn btn-primary">
                                                -
                                            </button>
                                            <input type="text" class="hide-arrow" value="' . $p2->getQuantite() . '">
                                            <button type="button"
                                                    class="counter__up d-flex align-items-center justify-content-center btn btn-primary">
                                                +
                                            </button>
                                        </div>
                                    </td>
                                    <td class="text-nowrap">$ ' . $p2->getPrix() . '</td>
                                    <td class="text-nowrap">$ ' . $p2->getQuantite() * $p2->getPrix() . '</td>
                                     <td class="text-end remove-button pe-0">
                                            <a href="javascript:void(0)" data-id="' . $p2->getProduit() . '"
                                               class="p-0 bg-transparent border-0 btn btn-primary remove-to-cart">
                                                <i class="fa fa-trash text-danger"></i>
                                            </a>
                                        </td>
                                </tr>';
    }
    $data .= '<script>$(".remove-to-cart").on("click", (function (e) {
    $("#ajax-loading").show();
        var id = $(this).data("id");
        e.preventDefault();
        $.ajax({
            url: "app/DefaultApp/traitements/produits.php?remove_panier=" + id,
            type: "GET",
            data: "",
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                $("#ajax-loading").hide();
                var r = $.parseJSON(data);
                    $("#panier_produit").empty();
                    $("#panier_montant").empty();
                    $("#panier_produit").html(r.data);
                    $("#panier_montant").html(r.footer);
                    toastr.info("produit retirer du panier");
            }
        });
    }));</script>';
    $footer = '<div class="total-price row">
                                <div class="col-6 mb-2">
                                    <div class="calculation__filed-grp mb-2">
                                        <div class="input-group">
                                            <input name="taxe" id="taxe" min="0" step=".01" placeholder="Taxe"
                                                   type="text" class="rounded-1 pe-8 form-control" value="">
                                            <span class="position-absolute top-0 bottom-0 end-0 bg-transparent border-0 input-group-text">%</span>
                                        </div>
                                    </div>
                                    <div class="calculation__filed-grp mb-2">
                                        <div class="input-group">
                                            <input name="rabais" id="rabais" min="0" step=".01" placeholder="Rabais"
                                                   type="text" class="rounded-1 pe-8 form-control" value="">
                                            <span class="position-absolute top-0 bottom-0 end-0 bg-transparent border-0 input-group-text">Gdes</span>
                                        </div>
                                    </div>
                                    <div class="calculation__filed-grp mb-2">
                                        <div class="input-group">
                                            <input name="livraison" id="livraison" min="0" step=".01"
                                                   placeholder="Livraison" type="text"
                                                   class="rounded-1 pe-8 form-control" value="">
                                            <span class="position-absolute top-0 bottom-0 end-0 bg-transparent border-0 input-group-text">Gdes</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 d-flex flex-column justify-content-center text-end align-items-end mb-2">
                                    <h4 class="fs-3 mb-2 custom-big-content text-gray-600">Total QTY : ' . $Qt . '</h4>
                                    <h2 class="fs-1 mb-2 text-gray-800">Total : Gdes ' . $total . '</h2></div>
                            </div>';

    $resultat['data'] = $data;
    $resultat['footer'] = $footer;
    echo json_encode($resultat);
}

if (isset($_GET['category'])) {
    $input = $_GET['category'];
    $resultat = array();
    $data = "";
    foreach (\app\DefaultApp\Models\Imagerie::listerByCategory($input) as $pr1) {
        $data .= '<div class="product-custom-card" data-id="' . $pr1->getId() . '" data-prix="' . $pr1->getPrix() . '" data-nom="' . $pr1->getNom() . '" data-description="' . $pr1->getNomAlternatif() . '">
                                            <div class="position-relative h-100 card">
                                                <img class="card-img-top" src="public/pos/free_image.jpg" alt="">
                                                <div class="px-2 pt-2 pb-1 custom-card-body card-body">
                                                    <h6 class="product-title mb-0 text-gray-900">' . $pr1->getNom() . '</h6>
                                                    <span class="fs-small text-gray-700">' . $pr1->getNomAlternatif() . '</span>
                                                  
                                                    <p class="m-1 item-badge">
                                                        <span class="product-custom-card__card-badge badge text-white bg-primary"> ' . $pr1->getDevise() . ' ' . $pr1->getPrix() . ' </span>
                                                    </p>
                                                    </div>
                                            </div>
                                        </div>';
    }
    $data .= '<script type="text/javascript">
    $("document").ready(function () {
      $(".product-custom-card").on("click", (function (e) {
          $("#ajax-loading").show();
        var produit = $(this).data("id");
        var prix = $(this).data("prix");
        var nom = $(this).data("nom");
        var descrition= $(this).data("description");
        e.preventDefault();
         $.ajax({
            url: "app/DefaultApp/traitements/produits.php?ajouter_produit="+produit+"&prix="+prix+"&nom="+nom+"&description="+descrition,
            type: "GET",
            data: "",
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                $("#ajax-loading").hide();
               var r = $.parseJSON(data);
                $("#panier_produit").empty();
                $("#panier_montant").empty();
                $("#panier_produit").html(r.data);
                $("#panier_montant").html(r.footer);
            }
        });
      }));
    });</script>';
    $resultat['data'] = $data;
    echo json_encode($resultat);
}

if (isset($_GET['rechercher'])) {
    $input = $_GET['rechercher'];
    $resultat = array();
    $data = "";
    foreach (\app\DefaultApp\Models\Imagerie::RechercherBy($input) as $pr1) {
        $data .= '<div class="product-custom-card" data-id="' . $pr1->getId() . '" data-prix="' . $pr1->getPrix() . '" data-nom="' . $pr1->getNom() . '" data-description="' . $pr1->getNomAlternatif() . '">
                                            <div class="position-relative h-100 card">
                                                <img class="card-img-top" src="public/pos/free_image.jpg" alt="">
                                                <div class="px-2 pt-2 pb-1 custom-card-body card-body">
                                                    <h6 class="product-title mb-0 text-gray-900">' . $pr1->getNom() . '</h6>
                                                    <span class="fs-small text-gray-700">' . $pr1->getNomAlternatif() . '</span>
                                                  
                                                    <p class="m-1 item-badge">
                                                        <span class="product-custom-card__card-badge badge text-white bg-primary"> ' . $pr1->getDevise() . ' ' . $pr1->getPrix() . ' </span>
                                                    </p>
                                                    </div>
                                            </div>
                                        </div>';
    }

    $data .= '<script type="text/javascript">
    $("document").ready(function () {
      $(".product-custom-card").on("click", (function (e) {
          $("#ajax-loading").show();
        var produit = $(this).data("id");
        var prix = $(this).data("prix");
        var nom = $(this).data("nom");
        var descrition= $(this).data("description");
        e.preventDefault();
         $.ajax({
            url: "app/DefaultApp/traitements/produits.php?ajouter_produit="+produit+"&prix="+prix+"&nom="+nom+"&description="+descrition,
            type: "GET",
            data: "",
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
               $("#ajax-loading").hide();
               var r = $.parseJSON(data);
                $("#panier_produit").empty();
                $("#panier_montant").empty();
                $("#panier_produit").html(r.data);
                $("#panier_montant").html(r.footer);
            }
        });
      }));
    });</script>';
    $resultat['data'] = $data;
    echo json_encode($resultat);
}

if (isset($_GET['modal'])) {
    $rabais = $_GET['rabais'];
    $livraison = $_GET['livraison'];
    $taxe = $_GET['taxe'];
    $var = array();
    $total = 0;
    $produit = "0";
    $qt = 0;
    foreach (Panier::lister($userId) as $p1) {
        $variable = array();
        $total = $total + ($p1->getQuantite() * $p1->getPrix());
        $qt = $qt + $p1->getQuantite();
        $variable['id'] = $p1->getProduit();
        $variable['quantite'] = $p1->getQuantite();
        $variable['prix'] = $p1->getPrix();
        $variable['nom'] = $p1->getNom();
        $variable['description'] = $p1->getNom();
        $variable['opt'] = $p1->getOptions();
        $var[] = $variable;
    }
    $taxeP = $total * ($taxe / 100);
    $totalG = $total + $taxeP - $rabais + $livraison;

    ?>
    <div class="fade modal-backdrop show"></div>
    <div role="dialog" aria-modal="true" style="display: block;" class="fade pos-modal modal show"
         tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content p-0">
                <div class="modal-header pb-3 pt-3">
                    <div class="modal-title h3">Make Payment</div>
                    <button type="button" class="btn-close btn-close-modal-custom" aria-label="Close"></button>
                </div>
                <div class="modal-body ">
                    <form method="post" id="order_submit">
                        <div class="row">
                            <div class="col-lg-7 col-12">
                                <div class="row">
                                    <div class="mb-3 col-6"><label class="form-label" for="formBasicReceived_amount">Received
                                            Amount: </label><input min="0" name="received_amount" autocomplete="off"
                                                                   required
                                                                   type="number" id="Received_amount"
                                                                   class="form-control-solid form-control"
                                                                   placeholder="<?= $totalG ?>">
                                    </div>
                                    <div class="mb-3 col-6">
                                        <label class="form-label">Paying Amount: </label>
                                        <input name="paying_amount" id="paying_amount" autocomplete="off" type="text"
                                               readonly=""
                                               class="form-control-solid form-control" value="<?= $totalG ?>">
                                    </div>
                                    <div class="mb-3 col-6">
                                        <label class="form-label">Change Return : </label>
                                        <input autocomplete="off" type="number" readonly="" id="change_return"
                                               class="form-control-solid form-control" placeholder="0.00">
                                    </div>
                                    <div class="mb-3 col-6">
                                        <label class="form-label" for="formBasicType">Payment Type:</label>
                                        <div class="form-group w-100">
                                            <select class="form-control" name="paiment" id="paiment_type" required>
                                                <option value="cash" aria-selected="true" aria-hidden="true">Cash
                                                </option>
                                                <option value="cash">Cash</option>
                                                <option value="credit">Credit</option>
                                                <option value="moncash">Mon Cash</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 col-12">
                                        <label class="form-label" for="formBasicNotes">Note: </label>
                                        <textarea name="notes" rows="2" placeholder="Enter Note" id="basic_notes"
                                                  class="form-control-solid form-control"></textarea>
                                    </div>
                                    <div class="mb-3 col-12 modal-footer">
                                        <input type="hidden" id="rabais_v" value="<?= $rabais ?>">
                                        <input type="hidden" id="taxe_v" value="<?= $taxeP ?>">
                                        <input type="hidden" id="livraison_v" value="<?= $livraison ?>">
                                        <button type="submit" class="btn btn-primary" id="submit_form">Submit</button>
                                        <button type="button" class="btn btn-secondary me-0 btn-close-modal-custom">
                                            Cancel
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 col-12">
                                <div class="card custom-cash-card">
                                    <div class="card-body p-6">
                                        <table class="mb-0 text-nowrap table table-striped table-bordered table-hover">
                                            <tbody>
                                            <tr>
                                                <td scope="row" class="ps-3">Total Products</td>
                                                <td class="px-3"><span
                                                            class="btn btn-primary cursor-default rounded-circle total-qty-text d-flex align-items-center justify-content-center p-2"><?= $qt ?></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td scope="row" class="ps-3">Total</td>
                                                <td class="px-3"><?= $e1->getDevise() ?> <?= number_format($total, 2, '.', ',') ?></td>
                                            </tr>
                                            <tr>
                                                <td scope="row" class="ps-3">Taxe</td>
                                                <td class="px-3"><?= $e1->getDevise() ?> <?= number_format($taxeP, 2, '.', ',') ?>
                                                    (<?= number_format($taxe, 2, '.', ',') ?> %)
                                                </td>
                                            </tr>
                                            <tr>
                                                <td scope="row" class="ps-3">Rabais</td>
                                                <td class="px-3"><?= $e1->getDevise() ?> <?= number_format($rabais, 2, '.', ',') ?></td>
                                            </tr>
                                            <tr>
                                                <td scope="row" class="ps-3">Livraison</td>
                                                <td class="px-3"><?= $e1->getDevise() ?> <?= number_format($livraison, 2, '.', ',') ?></td>
                                            </tr>
                                            <tr>
                                                <td scope="row" class="ps-3">Grand Total</td>
                                                <td class="px-3"><?= $e1->getDevise() ?> <?= number_format($totalG, 2, '.', ',') ?></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $("document").ready(function () {
            $('#order_submit').submit(function (e) {

                var elements = {
                    paiment: $("#paiment_type").val(),
                    note: $("#basic_notes").val(),
                    livraison: $("#livraison_v").val(),
                    taxe: $("#taxe_v").val(),
                    rabais: $("#rabais_v").val()
                };
                e.preventDefault();
                $.ajax({
                    url: "app/DefaultApp/traitements/produits.php?commande&elements=" + JSON.stringify(elements),
                    type: "GET",
                    data: "",
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data) {
                        toastr.info(data);
                        $("#space_show_modal").empty();
                        $.ajax({
                            url: "app/DefaultApp/traitements/produits.php?reset",
                            type: "GET",
                            data: "",
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function (data) {
                                var r = $.parseJSON(data);
                                $("#panier_produit").html(r.data);
                                $("#panier_montant").html(r.footer);
                            }
                        });
                    }
                });
            });
            $("#Received_amount").on("keyup", function () {
                var montant = $(this).val();
                var prix = $("#paying_amount").val();
                $("#change_return").val(montant - prix);
            });
            $(".btn-close-modal-custom").on("click", (function (e) {
                $("#space_show_modal").empty();
            }));
        });

    </script>
    <?php
}

if (isset($_GET['reset'])) {
    $r = \app\DefaultApp\Models\Panier::deletePanier($userId);
    $produit = "";
    $ima=new \app\DefaultApp\Models\Imagerie();
    $Listproduits = $ima->findAll();
    foreach ($Listproduits as $pr1) {
        $produit .= '<div class="product-custom-card" data-id="' . $pr1->getId() . '" data-prix="' . $pr1->getPrix() . '" data-nom="' . $pr1->getNom() . '" data-description="' . $pr1->getNomAlternatif() . '">
                                            <div class="position-relative h-100 card">
                                                <img class="card-img-top" src="public/pos/free_image.jpg" alt="">
                                                <div class="px-2 pt-2 pb-1 custom-card-body card-body">
                                                    <h6 class="product-title mb-0 text-gray-900">' . $pr1->getNom() . '</h6>
                                                    <span class="fs-small text-gray-700">' . $pr1->getNomAlternatif() . '</span>
                                                  
                                                    <p class="m-1 item-badge">
                                                        <span class="product-custom-card__card-badge badge text-white bg-primary"> ' . $pr1->getDevise() . ' ' . $pr1->getPrix() . ' </span>
                                                    </p>
                                                    </div>
                                            </div>
                                        </div>';
    }
    $produit .= '<script type="text/javascript">
    $("document").ready(function () {
      $(".product-custom-card").on("click", (function (e) {
        var produit = $(this).data("id");
        var prix = $(this).data("prix");
        var nom = $(this).data("nom");
        var descrition= $(this).data("description");
        $("#ajax-loading").show();
        e.preventDefault();
         $.ajax({
            url: "app/DefaultApp/traitements/produits.php?ajouter_produit="+produit+"&prix="+prix+"&nom="+nom+"&description="+descrition,
            type: "GET",
            data: "",
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                $("#ajax-loading").hide();
               var r = $.parseJSON(data);
               if(r.status==="ok"){
                $("#panier_produit").empty();
                $("#panier_montant").empty();
                $("#panier_produit").html(r.data);
                $("#panier_montant").html(r.footer);
                toastr.info(r.message);
                }else{
                     toastr.warning(r.message);
                }
            }
        });
      }));
    });</script>';
    if ($r == 'ok') {
        $data = ' <tr><td colspan="4" class="custom-text-center text-gray-900 fw-bold py-5">No Data Available</td></tr>';
        $footer = '<div class="total-price row">
                                <div class="col-6 mb-2">
                                    <div class="calculation__filed-grp mb-2">
                                        <div class="input-group">
                                            <input name="taxe" id="taxe" min="0" step=".01" placeholder="Taxe"
                                                   type="text" class="rounded-1 pe-8 form-control" value="">
                                            <span class="position-absolute top-0 bottom-0 end-0 bg-transparent border-0 input-group-text">%</span>
                                        </div>
                                    </div>
                                    <div class="calculation__filed-grp mb-2">
                                        <div class="input-group">
                                            <input name="rabais" id="rabais" min="0" step=".01" placeholder="Rabais"
                                                   type="text" class="rounded-1 pe-8 form-control" value="">
                                            <span class="position-absolute top-0 bottom-0 end-0 bg-transparent border-0 input-group-text">Gdes</span>
                                        </div>
                                    </div>
                                    <div class="calculation__filed-grp mb-2">
                                        <div class="input-group">
                                            <input name="livraison" id="livraison" min="0" step=".01"
                                                   placeholder="Livraison" type="text"
                                                   class="rounded-1 pe-8 form-control" value="">
                                            <span class="position-absolute top-0 bottom-0 end-0 bg-transparent border-0 input-group-text">Gdes</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 d-flex flex-column justify-content-center text-end align-items-end mb-2">
                                    <h4 class="fs-3 mb-2 custom-big-content text-gray-600">Total QTY : 0</h4><h4
                                            class="fs-3 mb-2 text-gray-600">Sub Total : Gdes 0</h4>
                                    <h2 class="fs-1 mb-2 text-gray-800">Total : Gdes 0</h2></div>
                            </div>';
        $resultat['data'] = $data;
        $resultat['produit'] = $produit;
        $resultat['footer'] = $footer;
        echo json_encode($resultat);
    }
}

if (isset($_GET['commande'])) {
    $elememts = json_decode($_GET['elements'], true);;
    $var = array();
    $ran = rand(000, 999);
    $paiment = $elememts['paiment'];
    $note = $elememts['note'];
    $rabais = $elememts['rabais'];
    $livraison = $elememts['livraison'];
    $taxe = $elememts['taxe'];
    $total = 0;
    $produit = "0";
    $qt = 0;
    foreach (Panier::lister($userId) as $p1) {
        $variable = array();
        $total = $total + ($p1->getQuantite() * $p1->getPrix());
        $qt = $qt + $p1->getQuantite();
        $variable['id'] = $p1->getProduit();
        $variable['quantite'] = $p1->getQuantite();
        $variable['prix'] = $p1->getPrix();
        $variable['nom'] = $p1->getNom();
        $variable['description'] = $p1->getNom();
        $variable['opt'] = $p1->getOptions();
        $var[] = $variable;

    }
    $total = $total + $taxe - $rabais + $livraison;

    $order = new \app\DefaultApp\Models\Commande();
    $order->setCode($ran . "-" . date('ymdh'));
    $order->setDate(date('d-m-Y H:i:s'));
    $order->setEntreprise($e1->getId());
    $order->setUser($userId);
    $order->setProduits(serialize($var));
    $order->setMontant($total);

    $order->setStatus('n/a');
    $order->setClient('n/a');
    $order->setAdresse('n/a');
    $order->setLivreur('n/a');

    $order->setPaiment($paiment);
    $order->setRabais($rabais);
    $order->setFraisl($livraison);
    $order->setTaxe($taxe);
    $order->setNote($note);

    $r = $order->add();
    if ($r === 'ok') {
        echo 'Commande effectue !';
    }

}



