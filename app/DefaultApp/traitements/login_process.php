<?php

use Ixudra\Curl\CurlService;

require "../../../vendor/autoload.php";
if (isset($_POST['login'])) {
    $pseudo = htmlspecialchars(trim($_POST['email']), ENT_QUOTES, "UTF-8");
    $user_password = htmlspecialchars(trim($_POST['password']), ENT_QUOTES, "UTF-8");

    if (empty($pseudo)) {
        $variables['message'] = "Entrer Nom utilisateur";
        echo json_encode($variables);
        return;
    }

    if (empty($user_password)) {
        $variables['message'] = "Entrer Mot de passe";
        echo json_encode($variables);
        return;
    }

    $variables['pseudo'] = $pseudo;
    $variables['password'] = $user_password;
    try {
        $m=\app\DefaultApp\Models\Utilisateur::connecter($pseudo,$user_password);
        if($m!="ok"){
            $mp=\app\DefaultApp\Models\Patient::connecter($pseudo,$user_password);
            if($mp!="ok"){
                $mm=\app\DefaultApp\Models\PersonelMedical::connecter($pseudo,$user_password);
                $variables['message']=$mm;
            }else{
                $variables['message']=$mp;
            }
        }else{
            $variables['message']=$m;
        }
        echo json_encode($variables);
    } catch (PDOException $e) {
        $variables['message'] = $e->getMessage();
        echo json_encode($variables);
    }
}
