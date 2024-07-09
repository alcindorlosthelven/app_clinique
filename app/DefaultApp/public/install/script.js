$("document").ready(function () {

    $(".finstall").on("submit", function (e) {
        e.preventDefault();
        $('#ajax-loading').show();
        $.ajax({
            type: 'POST',
            url: "app/DefaultApp/public/install/install.php",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $(".message").html("<div class='alert alert-success'>Instalation en cour patienter SVP</div>");
            },
            success: function (reponse) {
               if (reponse.trim() === "ok") {
                    alert("Instalation reussie");
                    $(".message").html("<div class='alert alert-success'>Instalation reussie</div>");
                    setTimeout(function () {
                        location.reload(true);
                    },1000);
                } else {
                    $(".message").html("<div class='alert alert-danger'>" + reponse + "</div>");
                }
               $('#ajax-loading').hide();
            }
        });

    });
    $('#ajax-loading').hide();
});