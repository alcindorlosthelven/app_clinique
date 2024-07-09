<?php
/**
 * Created by PhpStorm.
 * User: ALCINDOR LOSTHELVEN
 * Date: 13/01/2019
 * Time: 10:53
 */
require_once "../../../vendor/autoload.php";
try{
    if (isset($_POST['add_configuration'])) {
        try {
            $nom = trim(addslashes($_POST['nom']));
            $valeur = trim(addslashes($_POST['valeur']));
            $configuration = new \app\DefaultApp\Models\Configuration();
            $configuration->setNom($nom);
            $configuration->setValeur($valeur);
            $m = $configuration->add();
            if ($m == "ok") {
                echo "Ajouter avec success";
            } else {
                echo $m;
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    if (isset($_POST['update_configuration'])) {
        $id_configuration = $_POST['id_configuration'];
        $configuration = new \app\DefaultApp\Models\Configuration();
        $configuration = $configuration->findById($id_configuration);
        if (isset($_FILES['image']['name'])) {
            $image=new \app\DefaultApp\Models\Image($_FILES['image']['name']);
            $image->Upload();
            $src = $image->getSrc();
            $configuration->setValeur($src);
        }else{
            $valeur=trim(addslashes($_POST['valeur']));
            $configuration->setValeur($valeur);
        }
        $m=$configuration->update();
        if($m=="ok"){
            echo "modifier avec success";
        }else{
            echo $m;
        }
    }

    if (isset($_POST['update_configuration_mobile'])) {
        $id_configuration = $_POST['id_configuration'];
        $configuration = new \app\DefaultApp\Models\InfoAppMobile();
        if (isset($_FILES['image']['name'])) {
            $image=new \app\DefaultApp\Models\Image($_FILES['image']['name']);
            $image->Upload();
            $src = $image->getSrc();
            $value=$src;
        }else{
            $valeur=trim(addslashes($_POST['valeur']));
            $value=$valeur;
        }
        $m=$configuration->modifier($id_configuration,$value);
        if($m=="ok"){
            echo "modifier avec success";
        }else{
            echo $m;
        }
    }
}catch (Exception $ex){
    echo $ex->getMessage();
}

