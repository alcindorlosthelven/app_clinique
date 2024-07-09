<?php
/**
 * Created by PhpStorm.
 * User: ALCINDOR LOSTHELVEN
 * Date: 26/03/2018
 * Time: 14:39
 */

namespace systeme\Controlleur;
use mysql_xdevapi\Exception;
use systeme\Application\Application;

class Controlleur
{
    private $cheminVues="Vues/";
    private $template="Vues/templates/";
    protected $nom_template="principale";

    protected function render($vue,$variables=array(),$resources=array())
    {
        try{
            $var=explode("/",$vue);
            $vue=$this->cheminVues.$vue;
            ob_start();
            extract($resources,EXTR_SKIP);
            extract($variables,EXTR_SKIP);
            require \systeme\Application\Application::ROOT()."app/".\systeme\Application\Application::nomApp()."/".$vue.".php";
            //$contenue=ob_get_clean();
            $contenue=ob_get_contents();
            ob_get_clean();
            if($var[1]=="login" || $var[1]=="lock" || $var[1]=="reset" || $var[1]=="inscription"){
                require \systeme\Application\Application::ROOT()."app/".\systeme\Application\Application::nomApp()."/".$this->template."login".".php";
            }elseif($var[1]==="install"){
                require \systeme\Application\Application::ROOT()."app/".\systeme\Application\Application::nomApp()."/".$this->template."install".".php";
            } else{
                require \systeme\Application\Application::ROOT()."app/".\systeme\Application\Application::nomApp()."/".$this->template.$this->nom_template.".php";
            }
        }catch (\Exception $ex){
            throw new \Exception($ex->getMessage());
        }

    }

    protected function getModel($model)
    {
        try{
            $model="app\\".Application::nomApp()."\\Models\\".ucfirst($model);
            $model=new $model();
            return $model;
        }catch (\Exception $ex){
            throw new \Exception($ex->getMessage());
        }

    }

    protected function textControle($text)
    {
        return trim(addslashes(htmlentities($text,ENT_QUOTES)));
    }

}
