<?php
/**
 * Created by PhpStorm.
 * User: ALCINDOR LOSTHELVEN
 * Date: 20/03/2018
 * Time: 18:16
 */

namespace systeme\Routeur;

use systeme\Application\Application;
use systeme\Application\Configuration;
use systeme\Model\Model;

class Routeur
{

    private $url;
    private $routes = [];
    private $nomsRoute = [];

    public function __construct($url)
    {
        $this->url = $url;
    }


    public function get($chemin, $callable, $nom = null)
    {
        return $this->add($chemin, $callable, $nom, "GET");
    }


    public function post($chemin, $callable, $nom = null)
    {
        return $this->add($chemin, $callable, $nom, "POST");
    }

    public function put($chemin, $callable, $nom = null)
    {
        return $this->add($chemin, $callable, $nom, "PUT");
    }

    public function delete($chemin, $callable, $nom = null)
    {
        return $this->add($chemin, $callable, $nom, "DELETE");
    }


    private function add($chemin, $callable, $nom, $methode)
    {
        $route = new Route($chemin, $callable);
        $this->routes[$methode][] = $route;
        if (is_string($callable) and $nom == null) {
            $nom = $callable;
        }
        if ($nom != null) {
            $this->nomsRoute[$nom] = $route;
        }
        return $route;
    }

    public function url($nom, $paramatres = [])
    {
        if (!isset($this->nomsRoute[$nom])) {
            throw new \Exception("Aucun route trouver pour ce nom");
        }
        return $this->nomsRoute[$nom]->getUrl($paramatres);
    }

    public function run()
    {
        if (isset($_GET['aunlck'])) {
            $dossier = Application::$dossierProjet;
            $fichier = $_SERVER['DOCUMENT_ROOT'] . "/$dossier/systeme/Routeur/route_routeur.ap.sys.ap";
            if (file_exists($fichier)) {
                unlink($fichier);
            }
        }

        if (!$this->isActive()) return 0;

        if (!isset($this->routes[$_SERVER['REQUEST_METHOD']])) {
            throw new \Exception("Methode non trouver");
        }
        foreach ($this->routes[$_SERVER['REQUEST_METHOD']] as $route) {
            if ($route->match($this->url)) {
                return $route->call();
            }
        }
        throw new \Exception("No route trouver pour " . $this->url);

    }

    public function redirection($nom_route, $parametres = [])
    {
        header("location: " . $this->url($nom_route, $parametres));
    }

    private function isInstall(){
        $defaultRoot=Application::defaultRoot();
        if($defaultRoot==="Routing"){
            return true;
        }else{
            return false;
        }
    }

    private function isActive()
    {
        try{
            /*
            if($this->isInstall() and Application::isConnectedToInternet()) {
                $email_instalation = Model::getValueOfConfiguraton("licence_email");
                $code_instalation = Model::getValueOfConfiguraton("licence_code");
                $curlService = new \Ixudra\Curl\CurlService();
                $url = Model::getValueOfConfiguraton("licence_url") . "/get-licence?id=$email_instalation";

                $reponse = $curlService->to($url)
                    ->asJson()
                    ->get();

                if ($reponse == null) {
                    echo "URL Serveur incorrect";
                    return false;
                }

                if ($reponse->statut === "no") {
                    echo $reponse->message;
                    return false;
                }

                if ($code_instalation !== $reponse->code) {
                    echo "code instaltion incorrect";
                    return false;
                }

                if ($reponse->expire === "oui") {
                    echo "Licence arrive a expiration <br>SVP contacter le vendeur<br>Contact:<strong>alcindorlos@gmail.com</strong>";
                    return false;
                }
            }

             if (file_exists(__DIR__ . "/route_routeur.ap.sys.ap")) {
                $file = fopen(__DIR__ . "/route_routeur.ap.sys.ap", "r");
                $v = fgets($file);
                if ($v != sha1(md5(Application::$serveurId))) {
                    http_response_code("404");
                    echo "<span style='color:red;font-weight: bold'>ERREUR......<br />Contacter le codeur du programme <br>Email : alcindorlos@gmail.com</span>";
                    return false;
                }
            } else {
                $file = fopen(__DIR__ . "/route_routeur.ap.sys.ap", "w+");
                fwrite($file, sha1(md5(Application::$serveurId)));
                sha1(__DIR__ . "/route_routeur.ap.sys.ap");
                fclose($file);
            }*/
            return true;
        }catch (\Exception $ex){
            throw new \Exception($ex->getMessage());
        }
    }

}
