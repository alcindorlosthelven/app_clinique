<?php

namespace app\DefaultApp\Controlleurs;

use systeme\Controlleur\Controlleur;

class DefaultControlleur extends Controlleur
{

    public function index()
    {
        $vars=array();

        $this->render("default/index",$vars);

    }

    public function imagerie()
    {
        $vars=array();

        $this->render("default/imagerie",$vars);

    }

    public function pos()
    {
        $vars=array();

        $this->render("default/pos",$vars);

    }

}