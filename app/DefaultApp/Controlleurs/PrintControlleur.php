<?php

namespace app\DefaultApp\Controlleurs;

use systeme\Controlleur\Controlleur;

class PrintControlleur extends Controlleur
{
    protected $nom_template="print";

    public function imagerie()
    {
        return $this->render("print/imagerie");
    }

    public function imagesImagerie()
    {
        return $this->render("print/images_imageries");
    }
}
