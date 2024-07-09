
        <?php
        if(isset($_GET['administration'])){
            \app\DefaultApp\DefaultApp::block("admin_imagerie");
        }elseif(isset($_GET['gestion'])){
            abc:
            \app\DefaultApp\DefaultApp::block("examens_imagerie");
        }else{
            goto abc;
        }
        ?>

