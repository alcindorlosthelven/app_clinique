<?php

namespace app\DefaultApp\Controlleurs;

use systeme\Controlleur\Controlleur;

class LoginControlleur extends Controlleur
{

    public function login()
    {

        $vars=array();

        $this->render("utilisateur/login",$vars);

    }

}