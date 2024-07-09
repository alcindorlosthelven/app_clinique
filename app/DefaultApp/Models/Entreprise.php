<?php

namespace app\DefaultApp\Models;

use systeme\Model\Model;

class Entreprise extends Model
{
    protected $table="entreprise";
    public $id,$nom,$logo;

    public static function listeActif(){
        $date=date("Y-m-d");
        $con=self::connection();
        $req="select *from entreprise where date_expiration >= '{$date}' and lot_auto='oui'";
        $stmt=$con->prepare($req);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS,__CLASS__);
    }

    public static function lister(){
        $con=self::connection();
        $req="select *from entreprise order by nom asc";
        $stmt=$con->prepare($req);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS,__CLASS__);
    }

    public static function getDateExpiration($id){
        $con=self::connection();
        $req="select date_expiration from entreprise where id=:id";
        $stmt=$con->prepare($req);
        $stmt->execute(array(":id"=>$id));
        $data=$stmt->fetchObject();
        return $data->date_expiration;
    }
}
