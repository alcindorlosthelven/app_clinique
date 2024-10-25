<?php
/**
 * pos.php
 * clinic
 * @author : fater04
 * @created :  11:10 - 2024-07-09
 **/

use Illuminate\Support\Facades\App;

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

    $(".tyr").on("change", (function (e) {
        var val_stotal = parseFloat($("#val_stotal").html())
        var val_rabais = parseFloat($("#rabais").val());
        var val_rabais_assurance = parseFloat($("#rabais_assurance").val());

        let tyr=$(".tyr").val();
        let tyra=$(".tyra").val();
        let r=0;

        if(tyr==="pourcentage") {
            r = (val_stotal * val_rabais) / 100;
        }else{
            r=val_rabais;
        }

        let ra=0;

        if(tyra==="pourcentage"){
            ra = (val_stotal * val_rabais_assurance) / 100
        }else{
            ra=val_rabais_assurance
        }


        if (isNaN(r)) {
            r = 0;
        }

        if (isNaN(ra)) {
            ra = 0
        }

        let totalRab = r + ra;

        let valTotal = val_stotal - totalRab;

        $("#val_rabais_assurance").html(ra)
        $("#val_rabais").html(r)
        $("#val_total").html(valTotal);

    }))

    $(".tyra").on("change", (function (e) {
        var val_stotal = parseFloat($("#val_stotal").html())
        var val_rabais = parseFloat($("#rabais").val());
        var val_rabais_assurance = parseFloat($("#rabais_assurance").val());

        let tyr=$(".tyr").val();
        let tyra=$(".tyra").val();
        let r=0;

        if(tyr==="pourcentage") {
            r = (val_stotal * val_rabais) / 100;
        }else{
            r=val_rabais;
        }

        let ra=0;

        if(tyra==="pourcentage"){
            ra = (val_stotal * val_rabais_assurance) / 100
        }else{
            ra=val_rabais_assurance
        }


        if (isNaN(r)) {
            r = 0;
        }

        if (isNaN(ra)) {
            ra = 0
        }

        let totalRab = r + ra;

        let valTotal = val_stotal - totalRab;

        $("#val_rabais_assurance").html(ra)
        $("#val_rabais").html(r)
        $("#val_total").html(valTotal);

    }))

    $("#rabais").on("change", (function (e) {
        var val_stotal = parseFloat($("#val_stotal").html())
        var val_rabais = parseFloat($("#rabais").val());
        var val_rabais_assurance = parseFloat($("#rabais_assurance").val());

        let tyr=$(".tyr").val();
        let tyra=$(".tyra").val();
        let r=0;

        if(tyr==="pourcentage") {
            r = (val_stotal * val_rabais) / 100;
        }else{
            r=val_rabais;
        }

        let ra=0;

        if(tyra==="pourcentage"){
            ra = (val_stotal * val_rabais_assurance) / 100
        }else{
            ra=val_rabais_assurance
        }


        if (isNaN(r)) {
            r = 0;
        }

        if (isNaN(ra)) {
            ra = 0
        }

        let totalRab = r + ra;

        let valTotal = val_stotal - totalRab;

        $("#val_rabais_assurance").html(ra)
        $("#val_rabais").html(r)
        $("#val_total").html(valTotal);

    }))

    $("#rabais_assurance").on("change", (function (e) {
        var val_stotal = parseFloat($("#val_stotal").html())
        var val_rabais = parseFloat($("#rabais").val());
        var val_rabais_assurance = parseFloat($("#rabais_assurance").val());

        let tyr=$(".tyr").val();
        let tyra=$(".tyra").val();
        let r=0;

        if(tyr==="pourcentage") {
            r = (val_stotal * val_rabais) / 100;
        }else{
            r=val_rabais;
        }

        let ra=0;

        if(tyra==="pourcentage"){
            ra = (val_stotal * val_rabais_assurance) / 100
        }else{
            ra=val_rabais_assurance
        }

        if (isNaN(r)) {
            r = 0;
        }

        if (isNaN(ra)) {
            ra = 0
        }

        let totalRab = r + ra;

        let valTotal = val_stotal - totalRab;

        $("#val_rabais_assurance").html(ra)
        $("#val_rabais").html(r)
        $("#val_total").html(valTotal);
    }))

    $(document).on('click', '.product-custom-card', function (e) {
        var produit = $(this).data("id");
        var prix = $(this).data("prix");
        var nom = $(this).data("nom");
        var descrition = $(this).data("description");
        $("#ajax-loading").show();
        e.preventDefault();
        $.ajax({
            url: "app/DefaultApp/traitements/produits.php?ajouter_produit=" + produit + "&prix=" + prix + "&nom=" + nom + "&description=" + descrition,
            type: "GET",
            data: "",
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                console.log(data)
                $("#ajax-loading").hide();
                var r = $.parseJSON(data);
                if (r.status === "ok") {
                    $("#panier_produit").empty();
                    $("#panier_montant").empty();
                    $("#panier_produit").html(r.data);

                    var val_stotal = r.sousTotal
                    var val_rabais = parseFloat($("#rabais").val());
                    if (isNaN(val_rabais)) {
                        val_rabais = 0;
                    }
                    var val_rabais_assurance = parseFloat($("#rabais_assurance").val());
                    if (isNaN(val_rabais_assurance)) {
                        val_rabais_assurance = 0;
                    }

                    let rr = (val_stotal * val_rabais) / 100;
                    let ra = (val_stotal * val_rabais_assurance) / 100

                    if (isNaN(rr)) {
                        r = 0;
                    }

                    if (isNaN(ra)) {
                        ra = 0
                    }

                    let totalRab = rr + ra;

                    let valTotal = val_stotal - totalRab;

                    $("#val_stotal").html(val_stotal)
                    $("#val_rabais_assurance").html(ra)
                    $("#val_rabais").html(rr)
                    $("#val_total").html(valTotal);

                    toastr.info(r.message);
                } else {
                    toastr.warning(r.message);
                }
            }
        });
    });

    $(document).on('click', '.remove-to-cart', function (e) {
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
                var val_stotal = r.sousTotal
                var val_rabais = parseFloat($("#rabais").val());
                if (isNaN(val_rabais)) {
                    val_rabais = 0;
                }
                var val_rabais_assurance = parseFloat($("#rabais_assurance").val());
                if (isNaN(val_rabais_assurance)) {
                    val_rabais_assurance = 0;
                }

                let rr = (val_stotal * val_rabais) / 100;
                let ra = (val_stotal * val_rabais_assurance) / 100

                if (isNaN(rr)) {
                    r = 0;
                }

                if (isNaN(ra)) {
                    ra = 0
                }

                let totalRab = rr + ra;

                let valTotal = val_stotal - totalRab;

                $("#val_stotal").html(val_stotal)
                $("#val_rabais_assurance").html(ra)
                $("#val_rabais").html(rr)
                $("#val_total").html(valTotal);
                toastr.info("produit retirer du panier");
            }
        });
    });


    $("#btn_payer").on("click", (function (e) {
        var val_rabais = parseFloat($("#rabais").val());
        var val_rabais_assurance = parseFloat($("#rabais_assurance").val());
        var id_patient=$("#id_patient").val();
        var id_medecin=$("#id_medecin").val()

        let tyr=$(".tyr").val();
        let tyra=$(".tyra").val();


        if (isNaN(val_rabais)) {
            val_rabais = 0;
        }

        if (isNaN(val_rabais_assurance)) {
            val_rabais_assurance = 0
        }

        e.preventDefault();
        $.ajax({
            url: "app/DefaultApp/traitements/produits.php?modal&rabais=" + val_rabais + "&rabais_assurance=" + val_rabais_assurance+
            "&id_patient="+id_patient+"&id_medecin="+id_medecin+"&tyr="+tyr+"&tyra="+tyra,
            type: "GET",
            data: "",
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                $("#space_show_modal").empty().html(data);
            }
        });
    }));

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
                $("#liste_produits").html(r.produit);
                $("#val_stotal").html(0)
                $("#val_rabais").html(0)
                $("#val_rabais_assurance").html(0)
                $("#val_total").html(0)
                toastr.info("panier vide");
            }
        });
    }));

</script>
</body>
</html>

