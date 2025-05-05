<?php

namespace app\DefaultApp\Models;

use systeme\Model\Model;

class Facture extends Model
{
    protected $table="facture";
    public $id,$date,$heure,$type,$montant,$rabais,$montant_apres_rabais,$contenue,$user;
    public $methode_paiement,$note,$id_patient, $id_demande,$monnaie,$versement,$balance;

    public function listeParDate($date1,$date2)
    {
        $con=self::connection();
        $req="select *from facture where date between '{$date1}' and '{$date2}'";
        $stmt=$con->prepare($req);
        $stmt->execute();
        $data=$stmt->fetchAll(\PDO::FETCH_OBJ);
        return $data;
    }

    public function listeParDateRapport($date1,$date2,$methode)
    {
        $con=self::connection();
        if($methode=="tout"){
            $req="select *from facture where date between '{$date1}' and '{$date2}'";
        }else{
            $req="select *from facture where date between '{$date1}' and '{$date2}' and methode_paiement='{$methode}'";
        }

        $stmt=$con->prepare($req);
        $stmt->execute();
        $data=$stmt->fetchAll(\PDO::FETCH_OBJ);
        return $data;
    }
}
