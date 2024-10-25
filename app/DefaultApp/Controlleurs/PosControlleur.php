<?php
/**
 * PosControlleur.php
 * clinic
 * @author : fater04
 * @created :  12:36 - 2024-07-09
 **/

namespace app\DefaultApp\Controlleurs;
use systeme\Controlleur\Controlleur;

class PosControlleur extends Controlleur
{
    protected $nom_template = "pos";
    public function pointdevente()
    {
        $variable['titre'] = "Point de vente";
        return $this->render("pos/pv", $variable);
    }

}