<?php

namespace app\DefaultApp\Controlleurs;

use app\DefaultApp\Models\DemmandeImagerie;
use systeme\Controlleur\Controlleur;

class DefaultControlleur extends Controlleur
{

    public function index()
    {
        $vars=array();
        $this->render("default/index",$vars);
    }

    public function inbox()
    {
        $vars=array();
        $this->render("default/inbox",$vars);
    }

    public function profil()
    {
        $vars=array();
        $this->render("default/profil",$vars);
    }

    public function imagerie()
    {
        $vars = array();
        $this->render("default/imagerie", $vars);
    }

    public function pos()
    {
        $vars=array();
        $this->render("default/pos",$vars);
    }

    public function docteur()
    {
        $vars=array();
        $this->render("default/docteur",$vars);
    }

    public function patient()
    {
        $vars=array();
        $this->render("default/patient",$vars);
    }

    public function ecrireResultat($id)
    {
        $variable = array();
        $variable['titre'] = "Laboratoire | EcrireResultat";
        $demande=new DemmandeImagerie();
        $demande=$demande->findById($id);
        if($demande!==null){
            $variable['demmande']=$demande;
        }

        $this->render("imagerie/ecrire_resultat", $variable);
    }

    public function afficherResultat($id)
    {
        $variable = array();
        $variable['titre'] = "Resultat Imagerie";
        $variable['id'] = $id;
        $this->render("imagerie/afficher_resultat", $variable);
    }

    public function priseSpecimen($id){
        $variable['titre']="Prise Spécimen Imagerie";
        $variable['listeExamens']=DemmandeImagerie::listerExamens($id);
        $variable['id']=$id;
        $this->render("imagerie/prise_specimen", $variable);
    }

}