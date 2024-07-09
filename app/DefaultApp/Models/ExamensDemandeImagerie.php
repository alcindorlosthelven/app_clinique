<?php
/**
 * Created by PhpStorm.
 * User: alcin
 * Date: 4/8/2020
 * Time: 2:22 PM
 */

namespace app\DefaultApp\Models;


use systeme\Model\Model;

class ExamensDemandeImagerie extends Model
{
    protected $table = "examens_demande_imagerie";
    public $id, $id_demande, $id_imagerie, $statut, $resultat, $remarque,$prix,$conclusion;

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
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getIdDemande()
    {
        return $this->id_demande;
    }

    /**
     * @param mixed $id_demande
     */
    public function setIdDemande($id_demande)
    {
        $this->id_demande = $id_demande;
    }

    /**
     * @return mixed
     */
    public function getIdImagerie()
    {
        return $this->id_imagerie;
    }

    /**
     * @param mixed $id_imagerie
     */
    public function setIdImagerie($id_imagerie)
    {
        $this->id_imagerie = $id_imagerie;
    }



    /**
     * @return mixed
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * @param mixed $statut
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;
    }

    /**
     * @return mixed
     */
    public function getResultat()
    {
        return $this->resultat;
    }

    /**
     * @param mixed $resultat
     */
    public function setResultat($resultat)
    {
        $this->resultat = $resultat;
    }

    /**
     * @return mixed
     */
    public function getRemarque()
    {
        return $this->remarque;
    }

    /**
     * @param mixed $remarque
     */
    public function setRemarque($remarque)
    {
        $this->remarque = $remarque;
    }

    public static function rechercher($id_demande, $id_examens)
    {
        try {
            $con = self::connection();
            $req = "select *from examens_demande_imagerie Where id_demande=:id_demmande and id_imagerie=:id_examens";
            $stmt = $con->prepare($req);
            $stmt->execute(array(
                ":id_demmande" => $id_demande,
                ":id_examens" => $id_examens
            ));
            $data = $stmt->fetchAll(\PDO::FETCH_CLASS, "app\DefaultApp\Models\ExamensDemandeImagerie");
            if (count($data) > 0) {
                return $data[0];
            }
            return null;

        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    public static function statut($id_demande,$id_examens)
    {
        try {
            $con=self::connection();
            $req = "select statut from examens_demande_imagerie Where id_demande='".$id_demande."' and id_imagerie='".$id_examens."'";
            $rs = $con->query($req);
            if ($d = $rs->fetch()) {
                return $d['statut'];
            } else {
                return null;
            }

        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function listerParDemmande($id_demande)
    {
        try {
            $con = self::connection();
            $req = "select *from examens_demande_imagerie Where id_demande=:id_demmande";
            $stmt = $con->prepare($req);
            $stmt->execute(array(
                ":id_demmande" => $id_demande
            ));
            return $stmt->fetchAll(\PDO::FETCH_CLASS, "app\DefaultApp\Models\ExamensDemandeImagerie");


        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }


}
