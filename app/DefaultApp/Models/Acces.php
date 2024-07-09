<?php
/**
 * hopital - Acces.php
 * Create by ALCINDOR LOSTHELVEN
 * Created on: 9/22/2020
 */
//44836974
namespace app\DefaultApp\Models;


use systeme\Model\Model;

class Acces extends Model
{
    private $acces,$titre;


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
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * @param mixed $titre
     */
    public function setTitre($titre): void
    {
        $this->titre = $titre;
    }

    public function findAll()
    {
        $con=self::connection();
        $req="select *from acces";
        $stmt=$con->prepare($req);
        $stmt->execute();
        return  $stmt->fetchAll(\PDO::FETCH_CLASS,__CLASS__);
    }

}
