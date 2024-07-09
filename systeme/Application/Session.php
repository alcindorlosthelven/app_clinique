<?php
/**
 * Created by PhpStorm.
 * User: ALCINDOR LOSTHELVEN
 * Date: 18/08/2018
 * Time: 15:40
 */

namespace systeme\Application;

session_start();
date_default_timezone_set("America/Port-au-Prince");

class Session
{
    private static $serveurId;

    public function __construct()
    {
        /*ob_start();
        system("ipconfig /all");
        $mycom = ob_get_clean();
        // ob_clean();
        $findme = "Physical Address";
        $pmac = strpos($mycom, $findme);
        $mac = substr($mycom, ($pmac + 36), 17);
        self::$serveurId = $mac;

        if (isset($_GET['alck'])) {
            $dossier = Application::$dossierProjet;
            $fichier = $_SERVER['DOCUMENT_ROOT'] . "/$dossier/systeme/Routeur/route_routeur.ap.sys.ap";
            if (file_exists($fichier)) {
                $file = fopen($fichier, "w");
                fwrite($file, "");
                fclose($file);
            }

        }*/
        self::$serveurId="";
    }

    protected function getServeurId()
    {
        return self::$serveurId;
    }
}
