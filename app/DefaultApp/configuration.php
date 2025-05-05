<?php
//LES CONSTANTS
define('ENVIRONMENT', 'development');
if (isset($_SERVER['HTTP_ORIGIN'])) {
    // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
    // you want to allow, and if so:
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        // may also be using PUT, PATCH, HEAD etc
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}



if (defined('ENVIRONMENT'))
{
    switch (ENVIRONMENT)
    {
        case 'development':
            error_reporting(E_ALL);
            break;

        case 'testing':
        case 'production':
            error_reporting(0);
            break;

        default:
            exit('The application environment is not set correctly.');
    }
}else{
    exit('The application environment is not set correctly.');
}

//configuration base de donnee
$database = array(
    "serveur"=>"localhost",
    "nom_base"=>"clinic",
    "utilisateur"=>"root",
    "motdepasse"=>"A123ricardo#m"
);

//configuration email
$from=array(
    "email"=>"",
    "nom"=>""
);

$configurationEmail = array(
    "host" =>"",
    "utilisateur" =>"",
    "motdepasse" =>"",
    "port"=>465,
    "from"=>$from
);
//fin configuration email

$configuration = array(
    "defaultRoot"=>"Routing",
    "url" => $_GET['url'],
    "database" => $database,
    "configurationEmail"=>$configurationEmail,
    "dossierProjet" => "appClinic/app_clinique",
    "nomApp" => "DefaultApp"
);
\systeme\Application\Configuration::addConfiguration($configuration,"DefaultApp");

