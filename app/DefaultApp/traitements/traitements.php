<?php
require "../../../vendor/autoload.php";

if(isset($_POST['add_docteur'])){
    $docteur=new \app\DefaultApp\Models\PersonelMedical();
    $docteur->nom=trim(addslashes($_POST['nom']));
    $docteur->prenom=trim(addslashes($_POST['prenom']));
    $docteur->telephone=trim(addslashes($_POST['telephone']));
    $docteur->email=trim(addslashes($_POST['email']));
    $docteur->specialiter=trim(addslashes($_POST['specialiter']));
    $docteur->password=md5("1234");
    $docteur->type=$_POST['type'];
    $m=$docteur->add();
    echo $m;
}

if(isset($_POST['update_docteur'])){
    $docteur=new \app\DefaultApp\Models\PersonelMedical();
    $docteur=$docteur->findById($_POST['id']);
    $docteur->nom=trim(addslashes($_POST['nom']));
    $docteur->prenom=trim(addslashes($_POST['prenom']));
    $docteur->telephone=trim(addslashes($_POST['telephone']));
    $docteur->email=trim(addslashes($_POST['email']));
    $docteur->specialiter=trim(addslashes($_POST['specialiter']));
    $docteur->type=$_POST['type'];
    if($_POST['password']!=="xxxx"){
        $docteur->password=md5($_POST['password']);
    }
    $m=$docteur->update();
    echo $m;
}

if(isset($_POST['ajouter_patient'])){
    $p=new \app\DefaultApp\Models\Patient();
    $p->code=$_POST['code'];
    $p->no_identite=$_POST['no_identite'];
    $p->nom=trim(addslashes($_POST['nom']));
    $p->prenom=trim(addslashes($_POST['prenom']));
    $p->date_naissance=$_POST['date_naissance'];
    $p->telephone=$_POST['telephone'];
    $p->email=$_POST['email'];
    $p->sexe="m";
    $p->password=md5("1234");
    $m=$p->add();
    echo $m;
}

if(isset($_POST['update_patient'])){
    $id=$_POST['id'];
    $p=new \app\DefaultApp\Models\Patient();
    $p=$p->findById($id);
    $p->code=$_POST['code'];
    $p->no_identite=$_POST['no_identite'];
    $p->nom=trim(addslashes($_POST['nom']));
    $p->prenom=trim(addslashes($_POST['prenom']));
    $p->date_naissance=$_POST['date_naissance'];
    $p->telephone=$_POST['telephone'];
    $p->email=$_POST['email'];
    $p->sexe="m";
    $m=$p->update();
    echo $m;
}
