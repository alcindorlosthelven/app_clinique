<?php
/**
 * hopital - acces.php
 * Create by ALCINDOR LOSTHELVEN
 * Created on: 9/22/2020
 */
require_once "../../../vendor/autoload.php";
if(isset($_POST['acces'])){
    $id_user=$_POST['id_user'];
    if(isset($_POST['id_acces'])) {
        $id_acces = $_POST['id_acces'];
        if (\app\DefaultApp\Models\AccesUser::supprimerAcces($id_user)) {
            foreach ($id_acces as $ac) {
                $a = new \app\DefaultApp\Models\AccesUser();
                $a->setAcces($ac);
                $a->setIdUser($id_user);
                try {
                    $m = $a->add();
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
            }
            echo $m;
        } else {
            echo "ok";
        }
        $t = new \app\DefaultApp\Models\Tracabilite();
        $t->action = "Access utilisateur";
        $t->add();
    }else{
        echo "Aucun access est selectionnée";
    }
}
