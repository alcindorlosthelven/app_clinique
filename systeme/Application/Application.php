<?php
/**
 * Created by PhpStorm.
 * User: ALCINDOR LOSTHELVEN
 * Date: 30/03/2018
 * Time: 12:35
 */
/*NB: il est important de ne pas modifier cette classe 
,pour le bon fonctionnement du framework ,sauf si vous savez ce que vous faite.
Alcindor Losthelven Ing Informatique..
*/

namespace systeme\Application;

use systeme\Assette\Assette;
use systeme\Database\DbConnection;
use systeme\Model\Mail;
use systeme\Routeur\Routeur;

class Application extends Session
{


    public static $app = "";
    public static $defaultApp;

    public static $config;

    private static $routeur;

    private static $connection = null;

    public static $dossierProjet;

    private static $assette;

    private static $nomApp;

    private static $configuration = array();

    public static $serveurId;

    private static $defaultRoot;

    public function __construct($configuration)
    {
        $seesion = new Session();
        $_SESSION['database'] = $configuration['database'];
        $_SESSION['configurationEmail'] = $configuration['configurationEmail'];
        self::$configuration = $configuration;
        self::$routeur = new Routeur($configuration['url']);
        self::$dossierProjet = $configuration['dossierProjet'];
        self::$nomApp = $configuration['nomApp'];
        self::$defaultRoot=$configuration['defaultRoot'];
        self::$assette = new Assette();
        self::$config = $configuration;
        self::$serveurId = $seesion->getServeurId();

    }

    public static function get($chemin, $fonction, $nom = "")
    {
        return self::$routeur->get($chemin, $fonction, $nom);
    }

    public static function post($chemin, $fonction, $nom = "")
    {
        return self::$routeur->post($chemin, $fonction, $nom);
    }

    public static function put($chemin, $fonction, $nom = "")
    {
        return self::$routeur->put($chemin, $fonction, $nom);
    }

    public static function delete($chemin, $fonction, $nom = "")
    {
        return self::$routeur->delete($chemin, $fonction, $nom);
    }

    public static function genererUrl($nom_route, $parametres = [])
    {
        return self::$routeur->url($nom_route, $parametres);
    }

    public static function redirection($nom_route, $parametres = [])
    {

        self::$routeur->redirection($nom_route, $parametres);
    }

    public static function run()
    {
        try {
            return self::$routeur->run();
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

    }

    public static function connection()
    {
        $con = new DbConnection($_SESSION['database']);
        $con = $con->Connection();
        if (self::$connection == null) {
            self::$connection = $con;
            return self::$connection;
        } else {
            return self::$connection;
        }
    }


    public static function envoyerEmail($a, $sujet, $contenue, $attachement = "", $reply = "")
    {
        $mail = new Mail($_SESSION['configurationEmail']);
        return $mail->envoyer($a, $sujet, $contenue, $attachement, $reply);
    }

    public static function ROOT()
    {
        return $_SERVER['DOCUMENT_ROOT'] . "/" . self::$dossierProjet . "/";
    }

    public static function css($css)
    {
        return self::$assette->css($css);
    }

    public static function js($js)
    {
        return self::$assette->js($js);
    }

    public static function image($image)
    {
        return self::$assette->image($image);
    }

    public static function autre($autre)
    {
        return self::$assette->autre($autre);
    }

    public static function fichier($fichier){
        if(Application::$dossierProjet==""){
            return Application::$dossierProjet."/app/".Application::nomApp()."/".$fichier;
        }else{
            return "/".Application::$dossierProjet."/app/".Application::nomApp()."/".$fichier;
        }
    }

    public static function configuration()
    {
        require self::ROOT() . "app/Configuration.php";
    }

    public static function nomApp()
    {
        return self::$nomApp;
    }

    public static function cheminModels()
    {
        return "/app/" . self::$nomApp . "/Models";
    }

    public static function block($bloc,$variable=array())
    {
        self::$assette->bloc($bloc,$variable);
    }

    public static function defaultRoot(){
        return self::$defaultRoot;
    }

    public static function routing()
    {
        $root=self::defaultRoot();
        require self::ROOT() . "app/" . self::nomApp() . "/$root.php";
    }


    public static function imageLocation()
    {
        return self::$assette->imageLocation();
    }

    public static function formatComptable($p)
    {
        if($p=='null' or $p==null){
            $p=0;
        }
        if(stristr($p,"-")){
            $a=true;
            $p=str_replace("-","",$p);
        }
        if ($p == "") {
            $p = 0;
        }
        $p = str_replace(",", "", $p);
        $r = "#^[0-9]*.?[0-9]+$#";
        if (preg_match($r, $p)) {
            $p = number_format($p, 2, '.', ',');
            if(isset($a)){
                return "-".$p;
            }else {
                return $p;
            }
        } else {
            throw new \Exception("Format incorrect pour prix ou cout");
        }
    }

    public static function validerDate($date, $format = 'Y-m-d H:i:s')
    {
        $d = \DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }


    public static function calculAge($anne)
    {
        $anneeAjourdhui = date("Y");
        $age = $anneeAjourdhui - $anne;
        return $age;
    }


    public static function serveurId()
    {
        ob_start();
        system("ipconfig /all");
        $mycom = ob_get_contents();
        ob_clean();
        $findme = "Physical Address";
        $pmac = strpos($mycom, $findme);
        $mac = substr($mycom, ($pmac + 36), 17);
        return $mac;

    }

    public static function CallAPI($method, $url, $data, $headers)
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        switch ($method) {
            case "GET":
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
                break;
            case "POST":
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                break;
            case "DELETE":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
                break;
        }

        $response = curl_exec($curl);
        $data = json_decode($response,true);

        /* Check for 404 (file not found). */
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        // Check the HTTP Status code
        switch ($httpCode) {
            case 200:
                $error_status = "200: Success";
                return ($data);
                break;
            case 404:
                $error_status = "404: API Not found";

                break;
            case 500:
                $error_status = "500: servers replied with an error.";
                break;
            case 502:
                $error_status = "502: servers may be down or being upgraded. Hopefully they'll be OK soon!";
                break;
            case 503:
                $error_status = $data;
                return $error_status;
                break;
            default:
                $error_status = "Undocumented error: " . $httpCode . " : " . curl_error($curl);
                break;
        }
        curl_close($curl);
        echo $error_status;
        die;
    }

    //URL Actuel
    public static function urlActuel()
    {
        $protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') === FALSE ? 'http' : 'https';
        $url = $protocol.'://'.'' . $_SERVER['HTTP_HOST'] . '/' . $_SERVER['REQUEST_URI'] . '';
        return $url;
    }

    public static function check_db_connection($nom, $user, $password, $host)
    {
        try {
            $con = new \PDO("mysql:host={$host};dbname={$nom}", $user, $password);
        } catch (\PDOException $e) {
            return false;
        }
        return true;
    }

    public static function getConnexion($nom, $user, $password, $host)
    {
        try {
            $con = new \PDO("mysql:host={$host};dbname={$nom}", $user, $password);
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
        return $con;
    }

    public static function write_file($path, $data, $mode)
    {
        if (!$fp = @fopen($path, $mode)) {
            return FALSE;
        }
        flock($fp, LOCK_EX);
        fwrite($fp, $data);
        flock($fp, LOCK_UN);
        fclose($fp);
        return TRUE;
    }

    public static function isConnectedToInternet()
    {
        $connected = @fsockopen("www.google.com", 80);
        //website, port  (try 80 or 443)
        if ($connected){
            $is_conn = true; //action when connected
            fclose($connected);
        }else{
            $is_conn = false; //action in connection failure
        }
        return $is_conn;

    }

}
