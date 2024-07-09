<?php
/**
 * Created by PhpStorm.
 * User: alcin
 * Date: 3/22/2020
 * Time: 5:06 PM
 */

namespace app\DefaultApp\Controlleurs;


use systeme\Controlleur\Controlleur;

class InstallControlleur extends Controlleur
{
  public function index(){
      $variable['titre']="Instalation";

      $this->render("install/install",$variable);
  }
}