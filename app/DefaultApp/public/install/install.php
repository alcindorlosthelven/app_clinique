<?php
/**
 * Created by PhpStorm.
 * User: alcin
 * Date: 3/22/2020
 * Time: 6:20 PM
 */
require "../../../../vendor/autoload.php";
$url_serveur=trim(addslashes($_POST['url_serveur']));
if($url_serveur===""){echo "Entrer l'Url du serveur";return;}
if(strripos($url_serveur,"localhost") or strripos($url_serveur,"127.0.0.1") ){}else {
    if (!\systeme\Application\Application::isConnectedToInternet()) {
        echo "Imposible de continuer l'instalation, vous n'ete pas connecter a internet";
        return;
    }
}

$email_instalation=trim(addslashes($_POST['email_instalation']));
if($email_instalation===""){echo "Entrer Email instalation";return;}

$code_instalation=trim(addslashes($_POST['code_instalation']));
if($code_instalation===""){echo "Entrer code instalation";return;}

//verifier code instalation
/*$curlService = new \Ixudra\Curl\CurlService();
$url = $url_serveur."/get-licence?id=$email_instalation";
$reponse = $curlService->to($url)
    ->asJson()
    ->get();

if($reponse==null){
    echo "URL Serveur incorrect";
    return;
}


if($reponse->statut==="no"){
    echo $reponse->message;
    return;
}

if($code_instalation!==$reponse->code){
    echo "code instaltion incorrect";
    return;
}

if($reponse->expire==="oui"){
    echo "Licence arrive a expiration <br>SVP contacter le vendeur<br>Contact:<strong>alcindorlos@gmail.com</strong>";
    return;
}
*/

$db_name = trim(addslashes($_POST['db_name']));
if($db_name===""){echo "nom base de donnée vide";return;}

$user = trim(addslashes($_POST['db_uname']));
if($user===""){echo "nom utilisateur vide";return;}

$password = trim(addslashes($_POST['db_password']));

$host = trim(addslashes($_POST['db_hname']));
if($host===""){echo "nom d'hote vide";return;}


$fichierConfiguration=trim(addslashes($_POST['fichierConfiguration']));
$fichierSchema=trim(addslashes($_POST['fichierSchema']));


if(!file_exists($fichierSchema)){
    echo "fichier base donnée manquant <br>place le fichier dans app/DefaultApp/public/install/database.sql";
    return;
}

if ($db_name == "" or $user == "" or $host == "") {
    echo "Verifier les informations de la base de donner";
    return;
}

$verifier_db = \systeme\Application\Application::check_db_connection($db_name, $user, $password, $host);
if ($verifier_db) {

    if(!file_exists($fichierConfiguration)){
        echo "fichier de configuration n'existe pas";
        return;
    }

    if(!file_exists($fichierSchema)){
        echo "fichier de base donnée n'existe pas";
        return;
    }


    $passwordUser=sha1("admin");
    $reqq="insert into configuration (nom,valeur,categorie) VALUE ('licence_email','".$email_instalation."','non_modifiable');";
    $reqq.="insert into configuration (nom,valeur,categorie) VALUE ('licence_code','".$code_instalation."','non_modifiable');";
    $reqq.="insert into configuration (nom,valeur,categorie) VALUE ('licence_url','".$url_serveur."','text');";
    $reqq.="insert into utilisateur (pseudo,email,role,motdepasse,active,statut) VALUE ('admin','admin@gmail.com','admin','".$passwordUser."','oui','0');";


    $data = file_get_contents($fichierConfiguration);
    $data = str_replace('db_name', $db_name, $data);
    $data = str_replace('db_user', $user, $data);
    $data = str_replace('db_password', $password, $data);
    $data = str_replace('db_host', $host, $data);
    $data = str_replace("RoutingInstall", "Routing", $data);

    if (file_exists($fichierSchema)) {
        $schema = file_get_contents($fichierSchema);
        $query = rtrim(trim($schema), "\n;");
        $query_list = explode(";", $query);
        $query_list2 = explode(";", $reqq);
        $con=\systeme\Application\Application::getConnexion($db_name, $user, $password, $host);

        foreach ($query_list as $req){
            if($req!=="") {
                $con->exec($req);
            }
        }

        foreach ($query_list2 as $req){
            if($req!=="") {
                $con->exec($req);
            }
        }

        if(\systeme\Application\Application::write_file($fichierConfiguration,$data,"wb")){
            echo "ok";
        }else{
            echo "echek de modification de l'une des fichier <br>intalation echouer";
        }
    }

    return;
} else {
    echo "Verifier les informations de la base de donner";
}