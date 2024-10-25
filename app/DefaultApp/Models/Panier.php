<?php
/**
 * Panier.php
 * sol
 * @author : fater04
 * @created :  20:40 - 2024-06-13
 **/


namespace app\DefaultApp\Models;

use systeme\Model\Model;

class Panier extends Model
{
    private $id;
    private $user;
    private $produit;
    private $quantite;
    private $description;
    private $prix;
    private $nom;
    private $options;

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

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getProduit()
    {
        return $this->produit;
    }

    /**
     * @param mixed $produit
     */
    public function setProduit($produit): void
    {
        $this->produit = $produit;
    }

    /**
     * @return mixed
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * @param mixed $quantite
     */
    public function setQuantite($quantite): void
    {
        $this->quantite = $quantite;
    }

    /**
     * @return mixed
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * @param mixed $prix
     */
    public function setPrix($prix): void
    {
        $this->prix = $prix;
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom): void
    {
        $this->nom = $nom;
    }

    /**
     * @return mixed
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param mixed $options
     */
    public function setOptions($options): void
    {
        $this->options = $options;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }
    public static function produitExiste($produit, $user)
    {
        $con = self::connection();
        $req = "SELECT * FROM panier WHERE produit='" . $produit . "' and user='" . $user . "' ";
        $rs = $con->query($req);
        if ($data = $rs->fetch()) {
            return true;
        } else {
            return false;
        }
    }
    public static function lister($user)
    {
        try {
            $con = self::connection();
            $req = "select *from panier where user=:user ";
            $param = array(
                ":user" => $user
            );
            $stmt = $con->prepare($req);
            $stmt->execute($param);
            $res = $stmt->fetchAll(\PDO::FETCH_CLASS, "app\\DefaultApp\\Models\\Panier");
            return $res;
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }
    public static function deletePanier($user)
    {
        $con = self::connection();
        $req = "delete from panier where user=:user ";
        $param = array(
            ":user" => $user
        );
        $stmt = $con->prepare($req);
        $stmt->execute($param);
        if ($stmt->execute()) {
            return "ok";
        }
        else {
            return "no";
        }
    }
    public static function delete($produit, $user)
    {
        $con = self::connection();
        if (self::returnQuantite($produit, $user) > 1) {
            $req = "update  panier set quantite= quantite - 1  where produit='" . $produit . "' and user='" . $user . "'";
        } else {
            $req = "delete from panier  where produit='" . $produit . "' and user='" . $user . "' ";
        }
        $stmt = $con->prepare($req);
        if ($stmt->execute()) {
            return "ok";
        } else {
            return "no";
        }
    }
    public static function updatePanier($produit, $prix, $user, $nom, $description, $options)
    {
        $con = self::connection();
        try {
            if (self::produitExiste($produit, $user)) {
//                $req = "update  panier set quantite= quantite + 1  where produit=:produit ";
                $req = "update  panier set quantite= 1  where produit=:produit ";
                $stmt = $con->prepare($req);
                $param = array(
                    ":produit" => $produit
                );
                if ($stmt->execute($param)) {
                    return "ok";
                } else {
                    return "no";
                }
            } else {
                $req = "INSERT INTO panier(produit,user,quantite,prix,nom,description,options)VALUES (:produit,:user,:quantite,:prix,:nom,:description,:options) ";
                $stmt = $con->prepare($req);
                $param = array(
                    ":produit" => $produit,
                    ":user" => $user,
                    ":prix" => $prix,
                    ":nom" => $nom,
                    ":options" => $options,
                    ":description" => $description,
                    ":quantite" => '1'
                );
                if ($stmt->execute($param)) {
                    return "ok";
                } else {
                    return "no";
                }
            }

        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }
    public static function ajouterPanierProduitQuantite($produit, $quantite, $prix, $user, $nom, $description, $options)
    {
        $con = self::connection();
        try {
            $req = "INSERT INTO panier(produit,user,quantite,prix,nom,description,options)VALUES (:produit,:user,:quantite,:prix,:nom,:description,:options) ";
            $stmt = $con->prepare($req);
            $param = array(
                ":produit" => $produit,
                ":user" => $user,
                ":prix" => $prix,
                ":quantite" => $quantite,
                ":nom" => $nom,
                ":description" => $description,
                ":options" => $options
            );
            if ($stmt->execute($param)) {
                return "ok";
            } else {
                return "no";
            }

        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }
    public static function returnQuantite($produit, $user)
    {
        $con = self::connection();
        $req = "select quantite from panier where produit='" . $produit . "' and user='" . $user . "' ";
        $rs = $con->query($req);
        if ($data = $rs->fetch()) {
            return $data['quantite'];
        }
    }

}