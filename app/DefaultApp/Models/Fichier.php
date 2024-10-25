<?php
/**
 * Created by PhpStorm.
 * User: ALCINDOR LOSTHELVEN
 * Date: 16/03/2018
 * Time: 21:42
 */
namespace app\DefaultApp\Models;
use systeme\Model\Model;

class Fichier extends Model
{

    private $id;
    private $src;
    private $alt;
    private $location;
    private $locatioWeb="app/DefaultApp/public/fichier/";
    private $typeImage;
    private $dossier_destination;

    /**
     * @return string
     */
    public function getLocatioWeb()
    {
        return $this->locatioWeb;
    }

    /**
     * @param string $locatioWeb
     */
    public function setLocatioWeb($locatioWeb)
    {
        $this->locatioWeb = $locatioWeb;
    }



    const TYPE_ACCEPTER=array(
        "pdf",
        "jpg",
        "png",
        "JPG",
        "PNG",
        "jpeg",
        "JPEG",
        "mp4",
        "avi",
    );

    public function dossierDestination(){
       return str_replace("\\","/",dirname(__DIR__))."/public/fichier/";
    }

    /**
     * Image constructor.
     * @param $src
     * @param $alt
     */
    public function __construct($lien="",$autre_nom="")
    {
        $this->location=$this->dossierDestination().basename($lien);
        $extention=pathinfo($this->location,PATHINFO_EXTENSION);
        $this->alt=basename($lien);
        if($autre_nom!=""){
            $this->location=$this->dossierDestination().$autre_nom.".$extention";
            $this->locatioWeb.=$autre_nom.".$extention";
        }else{
            $this->location=$this->dossierDestination().basename($lien);
            $this->locatioWeb.=basename($lien);
        }


        $this->location=str_replace("'","",$this->location);
        $this->locatioWeb=str_replace("'","",$this->locatioWeb);

        $this->typeImage= pathinfo($this->location,PATHINFO_EXTENSION);

    }

    public function upload($indice="")
    {
        try{
            if($indice==="") {
                if (move_uploaded_file($_FILES["fichier"]["tmp_name"], $this->location)) {
                    $this->src=$this->locatioWeb;
                    $this->location=$this->locatioWeb;
                    return true;
                }else{
                    return false;
                }
            }else{
                if (move_uploaded_file($_FILES["fichier"]["tmp_name"][$indice], $this->location)) {
                    $this->src = $this->locatioWeb;
                    $this->location = $this->locatioWeb;
                    return true;
                } else {
                    return false;
                }
            }
        }catch (\Exception $ex){
            throw new \Exception($ex->getMessage());
        }

    }


    public function Convert64bite()
    {
         if($this->Upload())
         {
             $type = pathinfo($this->src,PATHINFO_EXTENSION);
             $data = file_get_contents($this->src);
             unlink($this->src);
             $this->src='data:image/' . $type . ';base64,' . base64_encode($data);
             return true;
         }else
         {
             return false;
         }
    }



    /**
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param string $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * @return mixed
     */
    public function getTypeImage()
    {
        return $this->typeImage;
    }

    /**
     * @param mixed $typeImage
     */
    public function setTypeImage($typeImage)
    {
        $this->typeImage = $typeImage;
    }

    /**
     * @return string
     */
    public function getDossierDestination()
    {
        return $this->dossier_destination;
    }

    /**
     * @param string $dossier_destination
     */
    public function setDossierDestination($dossier_destination)
    {
        $this->dossier_destination = $dossier_destination;
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
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getSrc()
    {
        return $this->src;
    }

    /**
     * @param mixed $src
     */
    public function setSrc($src)
    {
        $this->src = $src;
    }

    /**
     * @return mixed
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * @param mixed $alt
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;
    }


}