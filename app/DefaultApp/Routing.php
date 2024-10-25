<?php
use app\DefaultApp\DefaultApp as App;

App::get("/logout",function(){
   session_destroy();
   App::redirection("connexion");
},'logout');

App::get("/login", "login.login", "connexion");
App::get("/dashboard", "default.index",'dashboard');
App::get("/", "default.index", "index");
App::post("/", "default.index","index_post");
App::get("/imagerie", "default.imagerie","imagerie");
App::post("/imagerie", "default.imagerie","imagerie");
App::get("/lister-categorie-examens-imagerie", "default.listerCategorieExamensImagerie","lister_categorie_examens_imagerie");
App::get("/lister-imagerie", "default.listerImagerie","lister_imagerie");
App::get("/pos", "pos.pointdevente","pos");
App::post("/pos", "pos.pointdevente","pos");
App::get("/medecin", "default.docteur","docteur");
App::get("/patient", "default.patient","patient");
App::get("/prise-specimen-imagerie-:id", "default.priseSpecimen", "prise_specimen_imagerie")->avec("id", "[0-9]+");
App::get("/ecrire-resultat-imagerie-:id", "default.ecrireResultat", "ecrire_resultat_imagerie")->avec("id", "[0-9]+");
App::get("/afficher-resultat-imagerie-:id", "default.afficherResultat", "afficher_resultat_imagerie")->avec("id", "[0-9]+");
App::get("/inbox", "default.inbox","inbox");
App::get("/profil", "default.profil","profi");


App::get("/acces-utilisateur-:id", "utilisateur.acces", "acces_utilisateur")->avec("id",'[0-9]+');
App::get("/utilisateur", "utilisateur.lister","utilisateur");
App::get("/ajouter-utilisateur", "utilisateur.ajouter", "ajouter_utilisateur");
App::post("/ajouter-utilisateur", "utilisateur.ajouter","ajouter_utilisateur");
App::get("/lister-utilisateur", "utilisateur.lister", "lister_utilisateur");
App::get("/blocker-utilisateur-:id", "utilisateur.blocker", "blocker_utilisateur")->avec("id", "['0-9']+");
App::get("/deblocker-utilisateur-:id", "utilisateur.deblocker", "deblocker_utilisateur")->avec("id", "['0-9']+");
App::get("/supprimer-utilisateur-:id", "utilisateur.supprimer", "supprimer_utilisateur")->avec("id", "['0-9']+");
App::get("/modifier-utilisateur-:id", "utilisateur.modifier", "modifier_utilisateur")->avec("id", "['0-9']+");
App::post("/modifier-utilisateur-:id", "utilisateur.modifier")->avec("id", "['0-9']+");
App::get("/groupe-acces-utilisateur", "utilisateur.groupeAcces", "groupe_acces_utilisateur");
App::get("/configuration-systeme", "utilisateur.configuration", "configuration_systeme");
App::get("/compte-vendeur", "vendeur.compte", "compte_vendeur");
App::get("/demmande-elimination", "default.demmandeElimination", "demmande_elimination");

