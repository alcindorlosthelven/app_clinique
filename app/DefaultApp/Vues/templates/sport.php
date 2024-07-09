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

        thead tr {
            font-weight: bold;
            color: orangered;
            font-size: 20px;
        }
    </style>

</head>
<body>
<div id="ajax-loading"></div>
<?php
App::block("sport/menu_principale", ['logo' => $logo, 'balance' => $balance]);
App::block("sport/menu_secondaire");
$p = "";
if (isset($page)) {
    $p = $page;
}

?>
<section class="main__body__area">
    <div class="container-fluid p-0">
        <div class="row g-0">
            <?php
            if ($p !== "kenno"){
            ?>
            <div class="col-xxl-9 col-xl-9 col-lg-9">
                <?php
                }else{
                ?>
                <div class="col-xxl-12 col-xl-12 col-lg-12">
                    <?php
                    }
                    ?>
                    <div class="left__site__section">
                        <div class="tab-content" id="myTabContentmain">
                            <div class="popular__events__body">
                                <div class="container-fluid p-0">
                                    <div class="row g-0">
                                        <?php
                                        if ($p !== "kenno") {
                                        App::block("sport/menu_gauche");
                                        ?>
                                        <div class="col-xxl-10 col-xl-9 col-lg-9">
                                            <?php
                                            }else{
                                            ?>
                                            <div class="col-xxl-12 col-xl-12 col-lg-12">
                                                <?php
                                                }
                                                ?>
                                                <?php
                                                if (isset($contenue)) echo $contenue;
                                                App::block("sport/pied_page");
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <?php
                    if ($p !== "kenno") {
                        App::block("sport/menu_droite");
                    }
                    ?>
                </div>
            </div>

            <div class="card" style="display: none">
                <div class="card-body">
                    <div class="impression" style="width: 115mm;padding: 0px;font-weight: bold">
                        <page>
                            <div style="width: auto;font-size:15px;font-weight: bold">
                                <div style="text-align: center">
                                    <img src="<?= $logo ?>" style="height: 60px"/><br>
                                    <span style="font-weight: bold;font-size: 20px"><?= $en->nom ?></span><br>
                                    <?= $en->addresse ?><br>
                                    <?= $en->telephone ?><br>
                                    <br>
                                </div>
                                <span style="font-weight: bold">
                    #ticket : <span class="no_ticket"></span><br>
                    Date : <span class="date_creation"></span><br>
                  </span>
                                <br>
                            </div>
                            <table class="table table-bordered"
                                   style="width: 100%;border: 0px solid black;border-collapse: collapse">
                                <thead>
                                <tr>
                                    <td style="font-weight: bold;font-size: 15px">Match</td>
                                    <td style="font-weight: bold;font-size: 15px">Choix</td>
                                    <td style="font-weight: bold;font-size: 15px">Quote</td>
                                </tr>
                                </thead>

                                <tbody class="contenue_paris_simple"></tbody>

                                <tfoot>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>

                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>

                                <tr style="font-weight: bold">
                                    <td></td>
                                    <td>Total quote</td>
                                    <td class="total_kot"></td>
                                </tr>

                                <tr style="font-weight: bold">
                                    <td></td>
                                    <td>Total Mise</td>
                                    <td class="total_mise"></td>
                                </tr>

                                <tr style="font-weight: bold">
                                    <td></td>
                                    <td>Gain potentiel</td>
                                    <td class="gain_potentiel"></td>
                                </tr>
                                </tfoot>
                            </table>
                            <div style="text-align: center">message</div>
                        </page>
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
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>

<script src="<?= app::autre("assets2/js/jquery-3.6.0.min.js") ?>"></script>
<script src="<?= app::autre("assets2/js/bootstrap.bundle.min.js") ?>"></script>
<script src="<?= app::autre("assets2/js/jquery.magnific-popup.min.js") ?>"></script>
<script src="<?= app::autre("assets2/js/owl.carousel.min.js") ?>"></script>
<script src="<?= app::autre("assets2/js/jquery.nice-select.min.js") ?>"></script>
<script src="<?= app::autre("assets2/js/wow.min.js") ?>"></script>
<script src="<?= app::autre("assets2/js/jquery-ui.min.js") ?>"></script>
<script src="<?= app::autre("assets2/js/api.js") ?>"></script>
<script src="<?= app::autre("assets2/js/main.js") ?>"></script>
<script src="<?= app::autre("assets2/js/traitements.js") ?>"></script>

<script>
    $('document').ready(function () {
        $('#ajax-loading').hide();
        $('.show_sport').hide();
        $(".open_sport").on('click', function () {
            $('#ajax-loading').show();
            var sport = $(this).data("id");
            var code = $(this).data("alea");
            var test = $('#' + code).data("test");
            $('#' + code).toggle('slow', function () {
                if (test === 0) {
                    $.ajax({
                        url: "app/DefaultApp/traitements/sport.php?type=" + sport,
                        type: "GET",
                        data: "",
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function (data) {
                            $('#' + code).data("test", code);
                            $('#' + code).html(data);
                            $('#ajax-loading').hide();
                        }
                    });
                } else {
                    $('#ajax-loading').hide();
                }
            });
        });


        $(".montant_mise").on("keyup", function () {
            let val = parseInt($(".montant_mise").val());
            //fonction check si compte client gen montant desire
            let cote = parseFloat($(".totalOdds").text());
            let totalMise = val * cote;
            $(".paiement_possible").html(totalMise)
        });

        $(".cros").on("click", function () {
            $('#ajax-loading').show();
            let id = $(this).data("id");
            $.ajax({
                type: 'POST',
                url: 'app/DefaultApp/traitements/pannier_sport.php?delete&id=' + id,
                data: "",
                contentType: false,
                cache: false,
                processData: false,
                success: function (datas) {
                    $('#ajax-loading').hide();
                    let resultat = $.parseJSON(datas);
                    if (resultat.statut === "ok") {
                        let totalKot = parseFloat(resultat.totalKot);
                        $(".totalOdds").html(totalKot)
                        let val = parseInt($(".montant_mise").val());
                        let totalMise = val * totalKot;
                        $(".paiement_possible").html(totalMise)
                        $("#" + id).remove()
                    }
                }
            });
        });

        $(".un").on("click", function () {
            $('#ajax-loading').show();
            let id = $(this).data("id");
            let position = $(this).data("position");
            let homeTeam = $(this).data("hometeam");
            let awayTeam = $(this).data("awayteam");
            let sportKey = $(this).data("sport_key");
            let eventId = $(this).data("event_id");
            let dateTime = $(this).data("date_time");
            let kot = $(this).data("kot");
            let choix = "";
            if (position === "un") {
                choix = homeTeam;
            } else if (position === "deux") {
                choix = awayTeam;
            } else if (position === "trois") {
                choix = "double chance"
            }

            let montantMise = parseFloat($(".montant_mise").val())

            $.ajax({
                type: 'POST',
                url: 'app/DefaultApp/traitements/pannier_sport.php?ajouter&awayTeam=' + awayTeam + '&homeTeam=' + homeTeam + '&kot=' + kot + '&choix=' + choix + "&sport_key=" + sportKey + "&event_id=" + eventId + "&date=" + dateTime,
                data: "",
                contentType: false,
                cache: false,
                processData: false,
                success: function (datas) {
                    console.log(datas)
                    $('#ajax-loading').hide();
                    let resultat = $.parseJSON(datas);
                    if (resultat.status === "ok") {
                        let obj = resultat.objet;
                        let totalOdds = resultat.total
                        let payout = parseFloat(totalOdds) * parseFloat(montantMise);
                        $(".totalOdds").html(totalOdds)
                        $(".paiement_possible").html(payout);
                        let v = "<div class='multiple__items'><div class='multiple__head'><div class='multiple__left'><span class='icons'><i class='icon-football'></i></span><span>" + obj.home_team + " vs " + obj.away_team + "</span> </div><a href='javascript:void(0)' class='cros' data-id='" + id + "'><i class='icon-cross'></i></a></i></a></div><div class='multiple__point'><span class='pbox'>" + obj.kot + "</span> <span class='rightname'><span class='fc'>" + obj.choix + "</span></span> </div></div>";
                        $(".mlt").append(v)
                    }
                }
            });
        });


        function imprimer(titre) {
            let zone = $(".impression").html();
            let fen = window.open("", "", "height=800, width=1200,toolbar=0, menubar=0, scrollbars=1, resizable=1,status=0, location=0, left=0, top=0");
            fen.document.body.style.color = '#000000';
            fen.document.body.style.backgroundColor = '#FFFFFF';
            fen.document.body.style.padding = "0px";
            fen.document.body.style.fontWeight = 'bold';
            fen.document.body.style.fontSize = "15px";
            fen.document.body.style.margin = "0px";
            fen.document.title = titre;
            fen.document.body.innerHTML += " " + zone + " ";
            fen.window.print();
            fen.window.close();
            return true;
        }

        $(".place_paris_simple").on("click", function () {
            $('#ajax-loading').show();
            let mise = parseInt($(".montant_mise").val());
            $('#ajax-loading').hide();
            $.ajax({
                type: 'POST',
                url: 'app/DefaultApp/traitements/pannier_sport.php?placer_paris_simple&mise=' + mise,
                data: "",
                contentType: false,
                cache: false,
                processData: false,
                success: function (datas) {
                    $('#ajax-loading').hide();
                    let resultat = $.parseJSON(datas);
                    if (resultat.statut === "ok") {
                        $(".balance").text(resultat.balance);
                        let obj = resultat.objet
                        let contenue = resultat.contenue;
                        $(".date_creation").html(obj.date_creation + " " + obj.heure_creation)
                        $(".no_ticket").html(obj.id)
                        let lc = "";
                        for (let i = 0; i < contenue.length; i++) {
                            let home_team = contenue[i].home_team
                            let away_team = contenue[i].away_team
                            let choix = contenue[i].choix
                            let kot = contenue[i].kot
                            lc += "<tr><td>" + home_team + " vs " + away_team + "</td><td>" + choix + "</td><td>" + kot + "</td></tr>"
                        }
                        $(".contenue_paris_simple").append(lc);
                        $(".total_kot").html(obj.total_kot)
                        $(".total_mise").html(obj.total_mise)
                        $(".gain_potentiel").html(obj.gain_potentiel)
                        $(".mlt").empty()
                        $(".totalOdds").html("0")
                        $(".paiement_possible").html("0");
                        $(".montant_mise").val('0');
                        imprimer("Print paris simple")
                    } else {
                        alert(resultat.message)
                    }
                }
            });

        });
    });
</script>
</body>
</html>



