<?php
/**
 * pos.php
 * clinic
 * @author : fater04
 * @created :  11:10 - 2024-07-09
 **/
?>
<!doctype html>
<html lang="fr" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Point de Vente</title>
    <link rel="stylesheet" href="public/pos/fontawesome-pro-6.5.1/css/all.min.css">
    <link rel="stylesheet" href="public/pos/pv/css1.css">
    <link rel="stylesheet" href="public/pos/pv/css3.css">
    <link rel="stylesheet" href="public/pos/pv/css4.css">
    <link rel="stylesheet" type="text/css" href="public/pos/toastr.min.css">
    <style>
        #ajax-loading {
            position: fixed;
            z-index: 9999;
            background: url("public/pos/load.svg") 50% 50% no-repeat;
            top: 0px;
            left: 0px;
            height: 100%;
            width: 100%;
            cursor: wait;
        }
    </style>
</head>
<body class="antialiased">
<div id="ajax-loading"></div>
<?php

if (isset($contenue)) {
    echo $contenue;
}
?>
<script src="public/pos/libs.min.js"></script>
<script src="public/pos/toastr.min.js"></script>
<script src="public/pos/fontawesome-pro-6.5.1/js/all.min.js"></script>
<script type="application/javascript">

    $(document).ready(function () {
        $("#ajax-loading").show();
        $.ajax({
            url: "app/DefaultApp/traitements/produits.php?liste",
            type: "GET",
            data: "",
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                $("#ajax-loading").hide();
                var r = $.parseJSON(data);
                $("#liste_produits").empty();
                $("#liste_produits").html(r.data);
            }
        });
        window.setTimeout(function () {
            $(".alert").fadeTo(500, 0).slideUp(500, function () {
                $(this).remove();
            });
        }, 4000);
        $("#btn-fullscreen").click(function () {
            var doc = document;

            if (!doc.fullscreenElement && !doc.mozFullScreenElement && !doc.webkitFullscreenElement && !doc.msFullscreenElement) {

                var elem = document.documentElement;
                if (elem.requestFullscreen) {
                    elem.requestFullscreen();
                } else if (elem.mozRequestFullScreen) {
                    elem.mozRequestFullScreen();
                } else if (elem.webkitRequestFullscreen) {
                    elem.webkitRequestFullscreen();
                } else if (elem.msRequestFullscreen) {
                    elem.msRequestFullscreen();
                }
            } else {
                if (doc.exitFullscreen) {
                    doc.exitFullscreen();
                } else if (doc.mozCancelFullScreen) {
                    doc.mozCancelFullScreen();
                } else if (doc.webkitExitFullscreen) {
                    doc.webkitExitFullscreen();
                } else if (doc.msExitFullscreen) {
                    doc.msExitFullscreen();
                }
            }
        });
        toastr.options = {
            'closeButton': true,
            'debug': false,
            'newestOnTop': true,
            'progressBar': false,
            'positionClass': 'toast-bottom-right',
            'preventDuplicates': false,
            'showDuration': '1000',
            'hideDuration': '1000',
            'timeOut': '5000',
            'extendedTimeOut': '1000',
            'showEasing': 'swing',
            'hideEasing': 'linear',
            'showMethod': 'fadeIn',
            'hideMethod': 'fadeOut',
        }
    });

    $(".categorie_produits").on("click", (function (e) {
        $("#ajax-loading").show();
        var id = $(this).data("id");
        var nom = $(this).data("nom");
        $(".button-list__item a").removeClass("button-list__item-active text-white");
        $(this).addClass("button-list__item-active text-white");
        e.preventDefault();
        $.ajax({
            url: "app/DefaultApp/traitements/produits.php?category=" + id,
            type: "GET",
            data: "",
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                $("#ajax-loading").hide();
                var r = $.parseJSON(data);
                $("#liste_produits").empty();
                $("#liste_produits").html(r.data);
            }
        });
    }));

    $("#rechercher_produit").on("keyup change", function (e) {
        $("#ajax-loading").show();
        var id = $(this).val();
        e.preventDefault();
        $.ajax({
            url: "app/DefaultApp/traitements/produits.php?rechercher=" + id,
            type: "GET",
            data: "",
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                $("#ajax-loading").hide();
                var r = $.parseJSON(data);
                $("#liste_produits").empty();
                $("#liste_produits").html(r.data);

            }
        });
    });

    $(".remove-to-cart").on("click", (function (e) {
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

    // $("#btn_payer").on("click", (function (e) {
    //     var rabais = $("#rabais").val();
    //     var livraison = $("#livraison").val();
    //     var taxe = $("#taxe").val();
    //     if ($.trim(rabais) === "") {
    //         rabais = 0;
    //     }
    //     if ($.trim(livraison) === "") {
    //         livraison = 0;
    //     }
    //     if ($.trim(taxe) === "") {
    //         taxe = 0;
    //     }
    //     e.preventDefault();
    //     $.ajax({
    //         url: "app/DefaultApp/traitements/produits.php?modal&rabais=" + rabais + "&livraison=" + livraison + "&taxe=" + taxe,
    //         type: "GET",
    //         data: "",
    //         contentType: false,
    //         cache: false,
    //         processData: false,
    //         success: function (data) {
    //             $("#space_show_modal").empty().html(data);
    //         }
    //     });
    // }));

    $("#btn-reset-panier").on("click", (function (e) {
        $("#ajax-loading").show();
        e.preventDefault();
        $.ajax({
            url: "app/DefaultApp/traitements/produits.php?reset",
            type: "GET",
            data: "",
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                $("#ajax-loading").hide();
                var r = $.parseJSON(data);
                $("#liste_produits").empty();
                $("#panier_produit").html(r.data);
                $("#panier_montant").html(r.footer);
                $("#liste_produits").html(r.produit);
                toastr.info("panier vide");
            }
        });
    }));

</script>
</body>
</html>

