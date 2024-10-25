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
$catIm=new \app\DefaultApp\Models\CategorieExamensImagerie();
$u1 = \systeme\Model\Utilisateur::session_valeur() ?>
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
                                        <select class="form-control">
                                            <option>CLIENT</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="select-box col-6 ps-sm-2 position-relative">
                            <div class="input-group">
                                <div class=" css-b62m3t-container">
                                    <div class=" css-1s2u09g-control">
                                        <select class="form-control">
                                            <option>LAKAY</option>
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
                                    <td class="text-nowrap text-nowrap ps-0"><h4
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
                                    <td class="text-nowrap">$ <?= $p2->getPrix() ?></td>
                                    <td class="text-nowrap">$ <?= $p2->getPrix() * $p2->getQuantite() ?></td>
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
                    <div class="calculation mt-5" id="panier_montant">
                        <div class="total-price row ">
                            <div class="col-6 mb-2">
                                <div class="calculation__filed-grp mb-2">
                                    <div class="input-group">
                                        <input name="taxe" id="taxe" min="0" step=".01" placeholder="Taxe"
                                               type="number" class="rounded-1 pe-8 form-control" value="">
                                        <span class="position-absolute top-0 bottom-0 end-0 bg-transparent border-0 input-group-text">%</span>
                                    </div>
                                </div>
                                <div class="calculation__filed-grp mb-2">
                                    <div class="input-group">
                                        <input name="rabais" id="rabais" min="0" step="5" placeholder="Rabais"
                                               type="number" class="rounded-1 pe-13 form-control" value="">
                                        <span class="position-absolute top-0 bottom-0 end-0 bg-transparent border-0 input-group-text">Gdes</span>
                                    </div>
                                </div>
                                <div class="calculation__filed-grp mb-2">
                                    <div class="input-group">
                                        <input name="livraison" id="livraison" min="0" step="10"
                                               placeholder="Livraison" type="number"
                                               class="rounded-1 pe-13 form-control" value="">
                                        <span class="position-absolute top-0 bottom-0 end-0 bg-transparent border-0 input-group-text">Gdes</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 d-flex flex-column justify-content-center text-end align-items-end mb-2">
                                <h4 class="fs-3 mb-2 custom-big-content text-gray-600">Total QTY : <?= $Qt ?></h4>
                                <h2 class="fs-1 mb-2 text-gray-800">Total : Gdes <?= $total ?></h2></div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <button type="button" id="btn_refresh"
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
                                               placeholder="rechercher produit"
                                               type="text">
                                    </div>
                                </div>
                            </div>
                            <i class="fa fa-search fa-2x react-search-icon position-absolute mt-2  d-flex align-items-center ms-2"></i>
                        </div>
                        <div class="col-xxl-5 col-lg-5 col-5 col align-items-center header-btn-grp justify-xxl-content-end justify-lg-content-center justify-content-start flex-nowrap pb-xxl-0 pb-lg-2 pb-2  nav">
                            <div class="d-flex align-items-center position-relative justify-content-center ms-3 nav-pink nav-item">
                                <a href="#" class="pe-0 ps-1 text-white nav-link" role="button">
                                    <i class="fa fa-list fa-2x"></i>
                                </a>
                                <div class="hold-list-badge">0</div>
                            </div>
                            <a href="javascript:void(0)"
                               class="ms-3 d-flex align-items-center justify-content-center nav-item nav-green">
                                <i class="fa fa-bag-shopping cursor-pointer text-white fa-2x"></i>
                            </a>
                            <a href="javascript:void(0)"  id="btn-fullscreen"
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
                                    <?php  foreach ($catIm->findAll() as $ca1) { ?>
                                        <a href="javascript:void(0)" data-id="<?= $ca1->getId() ?>"
                                           style="font-size:  12px"
                                           data-nom="<?= $ca1->getCategorie() ?>"
                                           class="categorie_produits btn-sm mb-2  btn btn-light  button-list__item"
                                        >
                                            <?= strtolower($ca1->getCategorie()) ?>
                                        </a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>

                        <div class=" product-list-block pt-1">
                            <div class="d-flex flex-wrap product-list-block__product-block" id="liste_produits">
                            </div>
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


