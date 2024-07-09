<?php
/**
 * hopital - AccesUser.php
 * Create by ALCINDOR LOSTHELVEN
 * Created on: 9/22/2020
 */

namespace app\DefaultApp\Models;

use systeme\Model\Model;

class AccesUser extends Model
{

    protected $table="acces_user";
    public $id_user,$acces,$id;

    /**
     * @return mixed
     */
    public function getIdUser()
    {
        return $this->id_user;
    }

    /**
     * @param mixed $id_user
     */
    public function setIdUser($id_user): void
    {
        $this->id_user = $id_user;
    }

    /**
     * @return mixed
     */
    public function getAcces()
    {
        return $this->acces;
    }

    /**
     * @param mixed $acces
     */
    public function setAcces($acces): void
    {
        $this->acces = $acces;
    }



    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    public static function haveAcces($acces,$id_user=""){
        $role=\systeme\Model\Utilisateur::role();
        if ($id_user == "") {
            $id_user = \systeme\Model\Utilisateur::session_valeur();
        }
        /*if($role!=="administrateur"){
            return CategorieServiceAcces::haveAcces($acces,$role);
        }else {*/
            $con = self::connection();
            $req = "select *from acces_user where id_user=:id_user and acces=:acces";
            $stmt = $con->prepare($req);
            $stmt->execute(array(
                ":id_user" => $id_user,
                ":acces" => $acces
            ));
            $res = $stmt->fetchAll();
            if (count($res) > 0) {
                return true;
            } else {
                return false;
            }
        //}
    }

    public static function supprimerAcces($id_user){
        $con=self::connection();
        $req="delete from acces_user where id_user=:id_user";
        $stmt=$con->prepare($req);
        if($stmt->execute(array(":id_user"=>$id_user))){
            return true;
        }
        return false;
    }

}
