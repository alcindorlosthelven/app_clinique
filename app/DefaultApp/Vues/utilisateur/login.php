<div class="card" style="border-radius: 50px;box-shadow: 5px 5px 5px 5px darkblue">
    <div class="card-header">
        <center>
            <?php
            if(isset($_COOKIE['logo'])){
                ?>
                <img src="<?=$_COOKIE['logo']?>" style="height: 120px;border-radius: 15px">
            <?php
            }else{
                ?>
                <img src="<?=\app\DefaultApp\Models\Configuration::getValueOfConfiguraton('logo')?>" style="height: 120px;border-radius: 15px">
            <?php
            }
            ?>
        </center>
    </div>
    <div class="card-body">
        <form class="form-signin con was-validated" method="post" id="login-form">
            <input type="hidden" name="login">
            <div class="message">
                <?php
                if (isset($message)) {
                    echo "<div class='alert alert-warning'>$message</div>";
                } ?>
            </div>
            <p class="text-muted"></p>
            <div class="input-group mb-3">
                <span class="input-group-addon"><i class="icon-user"></i></span>
                <input style="border-radius: 15px" value="<?php if (isset($pseudo)) echo $pseudo ?>" type="text" class="form-control"
                       placeholder="Identifiant"
                       name="user_email" id="user_email" required>
            </div>
            <div class="input-group mb-4">
                <span class="input-group-addon"><i class="icon-lock"></i></span>
                <input style="border-radius: 15px" value="<?php if (isset($password)) echo $password ?>" type="password" class="form-control"
                       placeholder="Mot de passe" name="password" id="password" required>
            </div>
            <div class="row">
                <div class="form-group col-md-12" style="text-align: center;">
                    <button style="border-radius: 15px" type="submit" class="btn btn-primary px-4" name="btn-login" id="btn-login">
                        <span class="icon-login"></span> S'IDENTIFIER
                    </button>
                </div>
            </div>
        </form>
    </div>
    <div class="card-footer">
        <div class="" style="text-align: center">
            <a href="app/DefaultApp/app-release.apk" style="color: blue;font-weight: bold">Télécharger Application vendeur</a><br>
        </div>
        <!--<br>
        <div class="" style="text-align: center">
            <a target="_blank" href="https://youtube.com/playlist?list=PL0u9m9CEgrRgn9JZmmtiawouzFM_qPBOL" style="color: orange;font-weight: bold">Tutoriel panel admin</a><br>
        </div>
        <br>
        <div class="" style="text-align: center">
            <a target="_blank" href="https://youtube.com/playlist?list=PL0u9m9CEgrRg9MAZYHZm21zBtEovbOoJZ" style="color: green;font-weight: bold">Tutoriel app vendeur</a><br>
        </div>
        <br>-->
        <center style="display:none">
            <a  target="_blank" href="https://play.google.com/store/apps/details?id=alcindor.losthelven.sgl60"><img src="app/DefaultApp/public/image/play_app_store.png" style="height: 110px;width: 200px"></a>
        </center>
        <div style="text-align: right;display:none">
            Powered by : <a href="https://alcindorlos.bioshaiti.com" target="_blank">LOS</a>
        </div>
    </div>
</div>
