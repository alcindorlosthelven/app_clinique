<?php


namespace app\DefaultApp\Controlleurs;


use app\DefaultApp\DefaultApp;
use app\DefaultApp\Models\Utilisateur;
use systeme\Controlleur\Controlleur;

class UtilisateurControlleur extends Controlleur
{

    public function ajouter()
    {
        try{
            $variable = array();
            $variable['titre'] = "Utilisateur / Ajouter";
            if ($_SERVER['REQUEST_METHOD'] === "POST") {
                $utlisateur = new Utilisateur();
                $utlisateur->setNom($_POST['nom']);
                $utlisateur->setPrenom($_POST['prenom']);
                $utlisateur->setPseudo($_POST['pseudo']);
                $utlisateur->setRole($_POST['role']);
                $utlisateur->id_entreprise=Utilisateur::getEntreprise()->id;
                $motdepasse = $_POST['motdepasse'];
                $confirmer = $_POST['confirmermotdepasse'];
                if ($motdepasse != $confirmer) {
                    $variable['erreur'] = "Verifier les mot de passe";
                } else {
                    $utlisateur->setPassword(md5($motdepasse));
                    $message = $utlisateur->add();
                    if ($message === 'ok') {
                        $variable['success'] = "Fait avec sucess";
                    } else {
                        $variable['erreur'] = $message;
                    }
                }
            }
            $this->render("utilisateur/ajouter", $variable);
        }catch (\Exception $ex){
            echo $ex->getMessage();
        }
    }

    public function modifier($id)
    {
        $variable = array();
        $variable['titre'] = "Utilisateur / modifier";

        $utilisateur=new Utilisateur();
        $utilisateur=$utilisateur->findById($id);
        $variable['user']=$utilisateur;
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $utilisateur->setNom($_POST['nom']);
            $utilisateur->setPrenom($_POST['prenom']);
            $utilisateur->setRole($_POST['role']);
            $motdepasse = $_POST['motdepasse'];
            $confirmer = $_POST['confirmermotdepasse'];
            if ($motdepasse != $confirmer) {
                $variable['erreur'] = "Verifier les mot de passe";
            } else {
                if($motdepasse!="xxxx") {
                    $utilisateur->setPassword(md5($motdepasse));
                }
                $message = $utilisateur->update();
                if ($message == 'ok') {
                    $t = new \app\DefaultApp\Models\Tracabilite();
                    $t->action = "modifier utilisateur";
                    $t->add();
                    $variable['success'] = "Modifier avec succes";
                } else {
                    $variable['erreur'] = $message;
                }
            }

        }
        $this->render("utilisateur/modifier", $variable);
    }

    public function lister()
    {
        $u=new Utilisateur();
        $listeUtilisateur=$u->findAll();
        $variable = array("titre" => "Utilisateur / Lister", "listeUtilisateur" => $listeUtilisateur);
        $this->render("utilisateur/lister", $variable);
    }

    public function acces($id){
        $variable = array();
        $variable['titre'] = "acces utilisateur";
        $u=new Utilisateur();
        $u=$u->findById($id);
        if($u!==null){
            $variable['utilisateur']=$u;
        }
        $this->render("utilisateur/acces",$variable);
    }

    public function configuration(){
        $variable = array();
        $variable['titre'] = "Configuration système";
        $this->render("utilisateur/configuration",$variable);
    }

    public function supprimer($id){
        $u=new Utilisateur();
        $u->deleteById($id);
        DefaultApp::redirection("lister_utilisateur");
    }

}
