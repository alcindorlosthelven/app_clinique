<?php
if (\systeme\Model\Utilisateur::session()) {
    \app\DefaultApp\DefaultApp::redirection("dashboard");
}
use app\DefaultApp\DefaultApp as app;
if (isset($_COOKIE['logo'])) {
    $logo = $_COOKIE['logo'];
} else {
    $logo = \app\DefaultApp\Models\Configuration::getValueOfConfiguraton('logo');
}
?>
<!DOCTYPE html>
<html lang="en" class="h-100">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
    <!-- Title -->
    <title>CLinique</title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="keywords" content="Mediqu, PHP Hospital Admin Dashboard, Bootstrap Template, Hospital Admin Template, PHP Dashboard Template, PHP Payment Admin Template, Payment System UI, Responsive SaaS Dashboard, SSL Encryption, Mobile Optimization, UX/UI, Bootstrap 5, Admin Panel, HTML5, CSS3, Dark Layout, PWA, App Development, Customizable, Modern Design">
    <meta name="author" content="DexignZone">
    <meta name="robots" content="index, follow">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, minimal-ui, viewport-fit=cover">
    <meta name="description" content="Enhance hospital management with Mediqu, a powerful PHP hospital admin dashboard template built with Bootstrap. Mediqu offers a comprehensive solution for healthcare facilities with its intuitive interface and customizable features. Discover Mediqu at DexignZone for streamlined hospital administration.">
    <meta name="og:title" content="Mediqu - PHP Hospital Admin Dashboard Bootstrap Template | DexignZone">
    <meta name="og:description" content="Mediqu - PHP Hospital Admin Dashboard Bootstrap Template | DexignZone">
    <meta property="og:description" content="Enhance hospital management with Mediqu, a powerful PHP hospital admin dashboard template built with Bootstrap. Mediqu offers a comprehensive solution for healthcare facilities with its intuitive interface and customizable features. Discover Mediqu at DexignZone for streamlined hospital administration.">
    <meta name="og:image" content="../social-image.png">
    <meta name="format-detection" content="telephone=no">
    <meta name="twitter:title" content="Mediqu - PHP Hospital Admin Dashboard Bootstrap Template | DexignZone">
    <meta name="twitter:description" content="Enhance hospital management with Mediqu, a powerful PHP hospital admin dashboard template built with Bootstrap. Mediqu offers a comprehensive solution for healthcare facilities with its intuitive interface and customizable features. Discover Mediqu at DexignZone for streamlined hospital administration.">
    <meta name="twitter:image" content="../social-image.png">
    <meta name="twitter:card" content="summary_large_image">
    <!-- Favicon icon -->
    <link rel="shortcut icon" type="image/png" href="<?= \app\DefaultApp\DefaultApp::autre("assets/images/favicon.png") ?>">
    <link href="<?=\app\DefaultApp\DefaultApp::autre("assets/vendor/bootstrap-select/dist/css/bootstrap-select.min.css")?>"  rel="stylesheet" type="text/css"/>
    <link href="<?= \app\DefaultApp\DefaultApp::autre("assets/css/style.css") ?>" class="main-css" rel="stylesheet" type="text/css"/>
</head>

<body class="vh-100">
<div class="authincation h-100">
    <div class="container h-100">
        <div class="row justify-content-center h-100 align-items-center">
            <div class="col-md-6">
                <div class="authincation-content">
                    <div class="row no-gutters">
                        <div class="col-xl-12">
                            <div class="auth-form">
                                <!--
                                logo
                                <div class="text-center mb-3">
                                    <a href="index.html"><img src="<?php /*= \app\DefaultApp\DefaultApp::autre("assets/images/logo-full.png") */?>" alt=""></a>
                                </div>-->
                                <h4 class="text-center mb-4">Sign in your account</h4>
                                <div class="message"></div>
                                <form action="" class="form-login">
                                    <input type="hidden" name="login">
                                    <div class="form-group">
                                        <label class="mb-1 form-label">Email</label>
                                        <input name="email" type="text" class="form-control" value="admin@gmail.com">
                                    </div>
                                    <div class="mb-4 position-relative">
                                        <label class="mb-1 form-label">Password</label>
                                        <input name="password" type="password" id="dz-password" class="form-control" value="admin">
                                        <span class="show-pass eye">

												<i class="fa fa-eye-slash"></i>
												<i class="fa fa-eye"></i>

											</span>
                                    </div>
                                    <div class="form-row d-flex flex-wrap justify-content-between mt-4 mb-2">
                                        <div class="form-group">
                                            <div class="form-check custom-checkbox ms-1">
                                                <input type="checkbox" class="form-check-input" id="basic_checkbox_1">
                                                <label class="form-check-label" for="basic_checkbox_1">Remember my preference</label>
                                            </div>
                                        </div>
                                        <div class="form-group ms-2">
                                            <a href="page-forgot-password.html">Forgot Password?</a>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary btn-block">Sign Me In</button>
                                    </div>
                                </form>
                                <div class="new-account mt-3">
                                    <p>Don't have an account? <a class="text-primary" href="page-register.html">Sign up</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script> var enableSupportButton = '1'</script>

<script src="assets/vendor/global/global.min.js" type="text/javascript"></script>
<script src="assets/vendor/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript"></script>
<script src="assets/js/custom.js" type="text/javascript"></script>
<script src="assets/js/deznav-init.js" type="text/javascript"></script>
<script src="assets/js/demo.js" type="text/javascript"></script>
<script src="assets/js/styleSwitcher.js" type="text/javascript"></script>

<script>
    $('document').ready(function () {
        $('#load').hide();
        $(".form-login").on("submit", function (e) {
            $("#btn-login").css("display", "none");
            e.preventDefault();
            $('#ajax-loading').show();
            $.ajax({
                type: 'POST',
                url: "app/DefaultApp/traitements/login_process.php",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function () {
                    $(".message").html("<div class='alert alert-info'>Patienter un instant.........</div>")
                },
                success: function (reponse) {
                    $('#load').hide();
                    $(".message").html(reponse);
                    var data = $.parseJSON(reponse);
                    if (data.message === "ok") {
                        //$(".message").html("<div class='alert alert-info' style='text-align: center'>Success</div>");
                        document.location.href = "dashboard";
                        //location.reload(true);
                    } else {
                        $(".message").html("<div class='alert alert-info' style='text-align: center'>" + data.message + "</div>");
                        setTimeout(function () {
                            $(".message").html("");
                        }, 6000)
                        $("#btn-login").css("display", "inline-block");
                    }
                    $('#load').hide();
                }
            });

        });

        $("form").addClass("was-validated");
    });
</script>


</body>
</html>

