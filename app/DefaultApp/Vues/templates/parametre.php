<?php

use systeme\Application\Application as App;

if (!\systeme\Model\Utilisateur::session()) {
    app::redirection("logout");
}
$en = \app\DefaultApp\Models\Utilisateur::getEntreprise();
if ($en == null) {
    return;
}

$logo = \app\DefaultApp\Models\InfoAppMobile::getValue('logo', $en->id);
$background = \app\DefaultApp\Models\InfoAppMobile::getValue('background', $en->id);
setcookie("logo", $logo, time() + (31104000 * 30), "/");
setcookie("background", $background, time() + (31104000 * 30), "/");

$cm = \app\DefaultApp\Models\CompteEntreprise::getByEntreprise($en->id);
if ($cm == null) {
    $c = new \app\DefaultApp\Models\CompteEntreprise();
    $c->id_entreprise = $en->id;
    $c->balance = 0;
    $c->add();
    $balance = 0;
} else {
    $balance = $cm->balance;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGL-PARIAGE - <?php if (isset($titre)) echo $titre ?></title>
    <link rel="icon" href="<?= app::autre("assets2/img/logo/favicon.png") ?>">
    <link rel="stylesheet" href="<?= app::autre("assets2/css/bootstrap.min.css") ?>">
    <link rel="stylesheet" href="<?= app::autre("assets2/css/magnific-popup.css") ?>">
    <link rel="stylesheet" href="<?= app::autre("assets2/css/owl.carousel.min.css") ?>">
    <link rel="stylesheet" href="<?= app::autre("assets2/css/owl.theme.default.css") ?>">
    <link rel="stylesheet" href="<?= app::autre("assets2/css/nice-select.css") ?>">
    <link rel="stylesheet" href="<?= app::autre("assets2/glyphter-font/css/Glyphter.css") ?>">
    <link rel="stylesheet" href="<?= app::autre("assets2/css/animate.css") ?>">
    <link rel="stylesheet" href="<?= app::autre("assets2/css/all.min.css") ?>">
    <link rel="stylesheet" href="<?= app::autre("assets2/css/main.css") ?>">
    <link rel="stylesheet" href="<?= app::autre("assets2/css/custom.css") ?>">
    <style>
        #ajax-loading {
            position: absolute;
            z-index: 10000;
            background: url("<?= app::autre("assets2/img/svg/three-dots.svg") ?>") 50% 50% no-repeat;
            top: 0px;
            left: 0px;
            height: 100%;
            width: 100%;
            cursor: wait;
        }
    </style>
</head>
<body>
<div id="ajax-loading"></div>

<header class="header-section dashboard__header">
    <div class="container p-0">
        <div class="header-wrapper">
            <div class="menu__left__wrap">
                <div class="logo-menu px-2">
                    <a  href="javascript:void(0)" class="logo">
                        <img style="width: 50px" src="<?php if (isset($logo)) echo $logo ?>" alt="logo">
                    </a>
                </div>
                <ul class="main-menu">
                    <li>
                        <a href="bank">
                            <span>Entreprise</span>
                        </a>
                    </li>

                    <li style="display: none">
                        <a href="lister-pos">
                            <span>Agent</span>
                        </a>
                    </li>

                    <li>
                        <a href="utilisateur">
                            <span>Utilisateur</span>
                        </a>
                    </li>

                    <li>
                        <a href="mes-paris">
                            <span>Mes paris</span>
                        </a>
                    </li>

                    <li class="cmn-grp">
                            <span class="cmn--btn" data-bs-toggle="modal" data-bs-target="#signup">
                                <span class="rela">Sign In</span>
                            </span>
                        <span class="cmn--btn2" data-bs-toggle="modal" data-bs-target="#signup">
                                <span class="rela">Sign Up</span>
                            </span>
                    </li>


                </ul>
            </div>
            <div class="dashboar__wrap">
                <div class="items d__text">
                    <span class="small">Balance</span>
                    <h6><?= $balance ?>&nbsp;HTG</h6>
                </div>
                <div class="items d__cmn">
                    <a href="<?= \app\DefaultApp\DefaultApp::genererUrl('depots') ?>" class="cmn--btn">
                        <span>Depôts</span>
                    </a>
                </div>
                <div class="items dashboar__social">
                    <a href="#0" class="icons" style="display: none">
                        <i class="icon-gift"></i>
                        <span class="count">
                                2
                            </span>
                    </a>
                    <a href="#0" class="icons" style="display: none">
                        <i class="icon-message"></i>
                        <span class="count">
                                2
                            </span>
                    </a>
                    <a href="logout" class="cmn--btn2">
                        <span class="rela">LOGOUT</span>
                    </a>
                </div>
                <div class="lang d-flex align-items-center px-2">
                    <div class="header-bar d-lg-none">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<?php App::block("sport/menu_secondaire") ?>

<section class="dashboard__body mt__30 pb-60">
    <div class="container">
        <div class="row g-4">
            <div class="col-xxl-3 col-xl-3 col-lg-4">
                <div class="dashboard__side__bar">
                    <ul class="account__menu">
                        <li style="display: none">
                            <a <?php if (isset($active4)) echo $active4 ?> href="bank">
                                    <span class="icons">
                                        <i class="icon-user"></i>
                                    </span>
                                <span>
                                       Entreprise
                                    </span>
                            </a>
                        </li>
                        <li>
                            <a <?php if (isset($active5)) echo $active5 ?> href="<?= \app\DefaultApp\DefaultApp::genererUrl('mes_paris') ?>">
                                    <span class="icons">
                                        <i class="icon-user"></i>
                                    </span>
                                <span>
                                      Mes paris
                                    </span>
                            </a>
                        </li>

                        <li style="display:none;">
                            <a <?php if (isset($active1)) echo $active1 ?> href="<?= \app\DefaultApp\DefaultApp::genererUrl('depots') ?>">
                                <span class="icons"><i class="icon-deposit"></i></span>
                                <span>Depôts</span>
                            </a>
                        </li>
                        <li  style="display:none;">
                            <a <?php if (isset($active2)) echo $active2 ?> href="<?= \app\DefaultApp\DefaultApp::genererUrl('retrait') ?>">
                                <span class="icons"><i class="icon-withdraw"></i> </span>
                                <span>Retraits</span>
                            </a>
                        </li>
                        <li  style="display:none;">
                            <a <?php if (isset($active3)) echo $active3 ?> href="<?= \app\DefaultApp\DefaultApp::genererUrl('utilisateur') ?>">
                                    <span class="icons">
                                        <i class="icon-user"></i>
                                    </span>
                                <span>
                                      Utilisateur
                                    </span>
                            </a>
                        </li>

                        <li>
                            <a href="#">
                                    <span class="icons">
                                        <i class="icon-history"></i>
                                    </span>
                                <span>
                                       Transction History
                                    </span>
                            </a>
                        </li>


                    </ul>
                </div>
            </div>
            <div class="col-xxl-9 col-xl-9 col-lg-8">
                <div class="dashboard__body__wrap">

                    <?php if (isset($contenue)) echo $contenue; ?>

                </div>
            </div>
        </div>
    </div>
    <!--footer Bottom Menu-->
    <ul class="footer__menu d-lg-none">
        <li>
            <a href="sportsbetting.html" class="d-grid justify-content-center">
                <span><i class="fas fa-table-tennis"></i></span>
                <span class="texta">Sports</span>
            </a>
        </li>
        <li>
            <a href="#0" class="d-grid justify-content-center" data-bs-toggle="modal" data-bs-target="#eventsp">
                <span><i class="fa-solid fa-gift"></i></span>
                <span class="texta">Events</span>
            </a>
        </li>
        <li class="header-bartwo d-lg-none">
            <span class="bars"><i class="fas fa-bars"></i></span>
            <span class="cros"> <i class="fa-solid fa-xmark"></i></span>
        </li>
        <li>
            <a href="#0" class="d-grid justify-content-center" data-bs-toggle="modal" data-bs-target="#betsp">
                <span> <i class="fas fa-ticket-alt"></i></span>
                <span class="texta">My Bet</span>
            </a>
        </li>
        <li>
            <a href="dashboard.html" class="d-grid justify-content-center">
                <span> <i class="far fa-user-circle"></i></span>
                <span class="texta"> Account</span>
            </a>
        </li>
    </ul>
    <!--footer Bottom Menu-->
</section>

<footer class="footer__section pt-60">
    <div class="container">
        <div class="footer__top pb-60">
            <div class="row g-5">
                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6 wow fadeInUp" data-wow-delay="0.9s">
                    <div class="widget__items">
                        <div class="footer-head">
                            <a href="#0" class="footer-logo">
                                <img src="assets2/img/logo/footerlogo.png" alt="f-logo">
                            </a>
                        </div>
                        <div class="content-area">
                            <p>
                                Lorem ipsum dolor sit of the cart amet, consectetur adipiscing elit. I talk out of the
                                moon.
                            </p>
                            <h6>
                                Follow Us
                            </h6>
                            <ul class="social">
                                <li>
                                    <a href="#0" class="icon">
                                        <i class="fa-brands fa-facebook-f"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#0" class="icon">
                                        <i class="fa-brands fa-instagram"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#0" class="icon">
                                        <i class="fa-brands fa-linkedin-in"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#0" class="icon">
                                        <i class="fa-brands fa-twitter"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-2 col-lg-3 col-md-6 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="widget__items">
                        <div class="footer-head">
                            <h3 class="title">
                                Company
                            </h3>
                        </div>
                        <div class="content-area">
                            <ul class="quick-link">
                                <li>
                                    <a href="index.html">
                                        <img src="assets2/img/footer/rightarrow.png" alt="angle"> Home
                                    </a>
                                </li>
                                <li>
                                    <a href="#0">
                                        <img src="assets2/img/footer/rightarrow.png" alt="angle"> Slots
                                    </a>
                                </li>
                                <li>
                                    <a href="#0">
                                        <img src="assets2/img/footer/rightarrow.png" alt="angle"> Tournament
                                    </a>
                                </li>
                                <li>
                                    <a href="#0">
                                        <img src="assets2/img/footer/rightarrow.png" alt="angle"> Jackpots
                                    </a>
                                </li>
                                <li>
                                    <a href="livecasino.html">
                                        <img src="assets2/img/footer/rightarrow.png" alt="angle"> Live Games
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-6 col-sm-3 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="widget__items">
                        <div class="footer-head">
                            <h3 class="title">
                                Support
                            </h3>
                        </div>
                        <div class="content-area">
                            <ul class="quick-link">
                                <li>
                                    <a href="#0">
                                        <img src="assets2/img/footer/rightarrow.png" alt="angle"> Faqs
                                    </a>
                                </li>
                                <li>
                                    <a href="#0">
                                        <img src="assets2/img/footer/rightarrow.png" alt="angle"> Support
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-xl-5 col-lg-4 col-md-6 col-sm-9 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="widget__items">
                        <div class="footer-head">
                            <h3 class="title">
                                Subscribe Our Newslatter
                            </h3>
                        </div>

                        <p>
                            Proin mauris ligula, pretium eu est ut, imperdiet imperdiet massa. Nullam sodales ut orci
                            vehicula aliquam. Suspendisse.
                        </p>
                        <div class="content-area">
                            <form action="#0">
                                <input type="text" placeholder="Enter Your Email address">
                                <button class="cmn--btn" type="submit">
                                    <span>Subscribe</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer__bottom">
            <p class="text-white">
                Copyright &copy; 2023, <a href="#0" class="text--base">SportOdds</a> - All Right Reserved
            </p>
            <ul class="bottom__ling">
                <li>
                    <a href="#0" class="text-white">
                        Affiliate program
                    </a>
                </li>
                <li>
                    <a href="#0" class="text-white">
                        Terms & conditions
                    </a>
                </li>
                <li>
                    <a href="#0" class="text-white">
                        Bonus terms & conditions
                    </a>
                </li>
            </ul>
        </div>
    </div>
</footer>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>

<script src="<?= app::autre("assets2/js/jquery-3.6.0.min.js") ?>"></script>
<script src="<?= app::autre("assets2/js/bootstrap.bundle.min.js") ?>"></script>
<script src="<?= app::autre("assets2/js/jquery.magnific-popup.min.js") ?>"></script>
<script src="<?= app::autre("assets2/js/owl.carousel.min.js") ?>"></script>
<script src="<?= app::autre("assets2/js/jquery.nice-select.min.js") ?>"></script>
<script src="<?= app::autre("assets2/js/wow.min.js") ?>"></script>
<script src="<?= app::autre("assets2/js/jquery-ui.min.js") ?>"></script>
<script src="<?= app::autre("assets2/js/api.js") ?>"></script>
<script src="<?= app::autre("assets2/js/main.js") ?>"></script>
<script>
    $('document').ready(function () {
        $('#ajax-loading').hide();
    });
</script>
</body>
</html>
