<?php

use app\DefaultApp\Models\Entreprise;
use app\DefaultApp\Models\Panier;
use app\DefaultApp\Models\Utilisateur;

require_once "../../../vendor/autoload.php";
$userId = \systeme\Model\Utilisateur::session_valeur();

if (isset($_GET['liste'])) {
    $input = $_GET['liste'];
    $ima = new \app\DefaultApp\Models\Imagerie();
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
    if (count(Panier::lister($userId)) >= 0) {
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
                                    <td class="text-nowrap">' . $p2->getPrix() . '</td>
                                    <td class="text-nowrap">' . $p2->getQuantite() * $p2->getPrix() . '</td>
                                    <td class="text-end remove-button pe-0">
                                            <a href="javascript:void(0)" data-id="' . $p2->getProduit() . '"
                                               class="p-0 bg-transparent border-0 btn btn-primary remove-to-cart">
                                                <i class="fa fa-trash text-danger"></i>
                                            </a>
                                        </td>
                                </tr>';
        }
        $resultat['status'] = 'ok';
        $resultat['message'] = 'Produit ajouté au panier';
        $resultat['sousTotal'] = $total;
        $resultat['data'] = $data;
        echo json_encode($resultat);
    } else {
        $resultat['message'] = '....';
        echo json_encode($resultat);
    }
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
    $resultat['sousTotal'] = $total;
    $resultat['data'] = $data;
    echo json_encode($resultat);
}

if (isset($_GET['reset'])) {
    $r = \app\DefaultApp\Models\Panier::deletePanier($userId);
    $produit = "";
    $ima = new \app\DefaultApp\Models\Imagerie();
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

    if ($r == 'ok') {
        $data = ' <tr><td colspan="4" class="custom-text-center text-gray-900 fw-bold py-5">No Data Available</td></tr>';
        $resultat['data'] = $data;
        $resultat['produit'] = $produit;
        $resultat['sousTotal'] = 0;
        echo json_encode($resultat);
    }
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
    $rabais_assurance = $_GET['rabais_assurance'];
    $id_patient = $_GET['id_patient'];
    $id_medecin = $_GET['id_medecin'];
    $tyr = $_GET['tyr'];
    $tyra = $_GET['tyra'];


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
    if ($tyr == "pourcentage") {
        $rabais = ($total * $rabais) / 100;
    }
    if ($tyra == "pourcentage") {
        $rabais_assurance = ($total * $rabais_assurance) / 100;
    }

    $valRabais = $rabais + $rabais_assurance;
    $total_rabais = $valRabais;

    //$valRabais = ($total * $total_rabais) / 100;
    $totalG = $total - $valRabais;

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
                        <input type="hidden" name="id_patient" value="<?= $id_patient ?>">
                        <input type="hidden" name="id_medecin" value="<?= $id_medecin ?>">
                        <div class="row">
                            <div class="col-lg-7 col-12">
                                <div class="row">
                                    <div class="mb-3 col-6"><label class="form-label" for="formBasicReceived_amount">Received
                                            Amount: </label><input min="<?=$totalG?>" name="received_amount" autocomplete="off"
                                                                   required
                                                                   type="text" id="Received_amount"
                                                                   class="form-control-solid form-control"
                                                                   placeholder="<?= $totalG ?>"
                                                                   value="<?= $totalG ?>"
                                        >
                                    </div>
                                    <div class="mb-3 col-6">
                                        <label class="form-label">Paying Amount: </label>
                                        <input name="paying_amount" id="paying_amount" autocomplete="off" type="text"
                                               readonly=""
                                               class="form-control-solid form-control" value="<?= $totalG ?>">
                                    </div>
                                    <div class="mb-3 col-6">
                                        <label class="form-label">Change Return : </label>
                                        <input value="0" autocomplete="off" type="number" readonly="" id="change_return"
                                               class="form-control-solid form-control" placeholder="0.00">
                                    </div>
                                    <div class="mb-3 col-6">
                                        <label class="form-label" for="formBasicType">Payment Type:</label>
                                        <div class="form-group w-100">
                                            <select class="form-control" name="paiment" id="paiment_type" required>
                                                <option value="cash" aria-selected="true" aria-hidden="true">Cash</option>
                                                <option value="cash">Cash</option>
                                                <option value="cheque">Cheque</option>
                                                <option value="carte credit">Carte credit</option>
                                                <option value="credit">Credit</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 col-12">
                                        <label class="form-label" for="formBasicNotes">Note: </label>
                                        <textarea name="notes" rows="2" placeholder="Enter Note" id="basic_notes"
                                                  class="form-control-solid form-control">n/a</textarea>
                                    </div>
                                    <div class="mb-3 col-12 modal-footer">
                                        <input type="hidden" id="rabais_v" value="<?= $valRabais ?>">
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
                                                <td class="px-3"><?= number_format($total, 2, '.', ',') ?></td>
                                            </tr>
                                            <tr>
                                                <td scope="row" class="ps-3">Rabais</td>
                                                <td class="px-3"><?= number_format($valRabais, 2, '.', ',') ?></td>
                                            </tr>

                                            <tr>
                                                <td scope="row" class="ps-3">Grand Total</td>
                                                <td class="px-3"><?= number_format($totalG, 2, '.', ',') ?></td>
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
                e.preventDefault();
                let change=parseFloat($("#change_return").val());

                if(change<0){
                    alert("Montant incorrect..");
                    return;
                }

                var elements = {
                    paiment: $("#paiment_type").val(),
                    note: $("#basic_notes").val(),
                    rabais: $("#rabais_v").val(),
                    id_patient: $("#id_patient").val(),
                    id_medecin: $("#id_medecin").val(),
                    change:change,
                    type_paiement:$("#paiment_type").val()
                };

                console.log(elements)

                $.ajax({
                    url: "app/DefaultApp/traitements/produits.php?commande&elements=" + JSON.stringify(elements),
                    type: "GET",
                    data: "",
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data) {
                        console.log(data)
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

if (isset($_GET['commande'])) {
    $con = \app\DefaultApp\DefaultApp::connection();
    $con->beginTransaction();
    $elememts = json_decode($_GET['elements'], true);

    $var = array();
    $ran = rand(000, 999);
    $paiment = $elememts['paiment'];
    $note = $elememts['note'];
    $methodePaiement = $elememts['paiment'];
    $rabais = $elememts['rabais'];
    $id_medecin = $elememts['id_medecin'];
    $id_patient = $elememts['id_patient'];
    $change=$elememts['change'];
    $total = 0;
    $produit = "0";
    $qt = 0;
    $fac=$id_patient."-".$ran;
    $listeExames = array();

    $type_facture = "";
    foreach (Panier::lister($userId) as $p1) {
        $img = new \app\DefaultApp\Models\Imagerie();
        $img = $img->findById($p1->produit);
        if ($img != null) {
            $ca = new \app\DefaultApp\Models\CategorieExamensImagerie();
            $ca = $ca->findById($img->id_categorie);
            if ($ca != null) {
                $type_facture = $ca->categorie;
            }
        }
        $variable = array();
        $total = $total + ($p1->getQuantite() * $p1->getPrix());
        $qt = $qt + $p1->getQuantite();
        $ex = new \app\DefaultApp\Models\ExamensDemandeImagerie();
        $ex->id_imagerie = $p1->produit;
        $ex->prix = $p1->prix;
        $ex->statut = "n/a";
        $ex->resultat = "n/a";
        $ex->remarque = "n/a";
        $ex->conclusion = "n/a";
        $listeExames[] = $ex;
    }

    $totalApresRabis = $total - $rabais;
    foreach($listeExames as $index => $x){
        $order = new \app\DefaultApp\Models\DemmandeImagerie();
        $order->date = date("Y-m-d H:i:s");
        $order->date_prelevement = "n/a";
        $order->id_medecin = $id_medecin;
        $order->id_patient = $id_patient;
        $order->facture = $fac;
        $order->payer = "oui";
        $order->statut = "n/a";
        $r = $order->add();
        if ($r === 'ok') {
            $id_demmande = $order->lastId();
            $demande = $id_demmande;
            $listeExames[$index]->id_demande = $id_demmande;
            $mxa = $listeExames[$index]->add();
        }
    }
    if ($r === 'ok') {
        $mxa = "ok";
        if ($mxa == "ok") {
            $f = new \app\DefaultApp\Models\Facture();
            $f->date = date("Y-m-d");
            $f->heure = date("H:i:s");
            $f->montant = $total;
            $f->rabais = $rabais;
            $f->montant_apres_rabais = $totalApresRabis;
            $f->type = $type_facture;
            $f->user = \systeme\Model\Utilisateur::session_valeur();
            $f->contenue = json_encode($listeExames);
            $f->methode_paiement = $paiment;
            $f->note = $note;
            $f->id_patient = $id_patient;
            $f->id_demande = $fac;
            $f->monnaie=$change;
            $mx = $f->add();
            if ($mx == "ok") {
                if (strtolower($paiment) == "credit") {
                    $pat = new \app\DefaultApp\Models\Patient();
                    $pat = $pat->findById($id_patient);
                    if ($pat != null) {
                        $balAvant = floatval($pat->balance);
                        $balApres = $balAvant - floatval($totalApresRabis);
                        $pat->balance=$balApres;
                        $m=$pat->update();
                        if($m=="ok"){
                            goto abc;
                        }else{
                            $con->rollBack();
                            echo $m;
                        }
                    }else{
                        $con->rollBack();
                        echo "Patient introuvable";
                    }
                } else {
                    abc:
                    $con->commit();
                    $id = $f->lastId();
                    ?>
                    <script>
                        window.open("pos?liste-commande&print=<?= $id ?>", '_blank');
                    </script>
                    <?php
                    echo "effectuer avec success";
                }
            } else {
                $con->rollBack();
                echo $mx;
            }
        } else {
            $con->rollBack();
            echo $mxa;
        }
    } else {
        $con->rollBack();
        echo $r;
    }

    die();
}



