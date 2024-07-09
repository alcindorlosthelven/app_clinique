<?php
/**
 * Created by PhpStorm.
 * User: ALCINDOR LOSTHELVEN
 * Date: 12/03/2018
 * Time: 21:34
 */

namespace systeme\Model;

use app\sge\Models\TempConnexion;

class Utilisateur extends Model
{
    private $id;
    private $pseudo;
    private $email;
    private $nom;
    private $prenom;
    private $role;
    private $active;
    private $motdepasse;
    private $statut;
    private $telephone;
    private $photo;
    private $id_classe;

    /**
     * @return mixed
     */
    public function getIdClasse()
    {
        return $this->id_classe;
    }

    /**
     * @param mixed $id_classe
     */
    public function setIdClasse($id_classe)
    {
        $this->id_classe = $id_classe;
    }


    /**
     * @return mixed
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * @param mixed $telephone
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    }

    /**
     * @return mixed
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param mixed $photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
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
    public function getPseudo()
    {
        return strtolower($this->pseudo);
    }

    /**
     * @param mixed $pseudo
     */
    public function setPseudo($pseudo)
    {
        $this->pseudo = htmlspecialchars(trim(addslashes(strtolower($pseudo))), ENT_QUOTES, 'UTF-8');
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return strtolower($this->email);
    }

    /**
     * @param mixed $email
     * @throws \Exception
     */
    public function setEmail($email)
    {

        if (!$email == "") {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->email = htmlspecialchars(trim(addslashes(strtolower($email))), ENT_QUOTES, "UTF-8");
            } else {
                throw new \Exception("Email invalide");
            }
        } else {
            $this->email = "";
        }

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
    public function setNom($nom)
    {
        $this->nom = trim(addslashes(strtolower($nom)));
    }

    /**
     * @return mixed
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param mixed $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = trim(addslashes(strtolower($prenom)));
    }

    /**
     * @return mixed
     */
    public function getMotdepasse()
    {
        return $this->motdepasse;
    }

    /**
     * @param mixed $motdepasse
     */
    public function setMotdepasse($motdepasse)
    {
        $this->motdepasse = sha1($motdepasse);
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role)
    {
        $this->role = strtolower($role);
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return strtolower($this->active);
    }

    /**
     * @param mixed $active
     */
    public function setActive($active)
    {
        $this->active = strtolower($active);
    }


    /**
     * verifier s'il existe deja un pseudo
     * @param $pseudo
     * @return bool
     */
    private static function SiPseudoExiste($pseudo)
    {
        $req = "SELECT *FROM utilisateur WHERE pseudo='" . $pseudo . "'";
        $rs = self::connection()->query($req);
        if ($rs->fetch()) {
            $con = null;
            return true;
        } else {
            $con = null;
            return false;
        }
    }

    /**
     * verifier s'il existe deja un email
     * @param $email
     * @return bool
     */
    public static function SiEmailExiste($email)
    {
        $req = "SELECT *FROM utilisateur WHERE email='" . $email . "'";
        $rs = self::connection()->query($req);
        if ($rs->fetch()) {
            $con = null;
            return true;
        } else {
            $con = null;
            return false;
        }
    }

    private static function SiTelephoneExiste($telephone)
    {
        $req = "SELECT *FROM utilisateur WHERE telephone='" . $telephone . "'";
        $rs = self::connection()->query($req);
        if ($rs->fetch()) {
            $con = null;
            return true;
        } else {
            $con = null;
            return false;
        }
    }

    /**
     * verifier si l'utilisateur est deja connecter sur le systeme
     * prend en parametre l'id de l'utilisatur
     * @param $id
     * @return bool
     */
    public static function SiUtilisateurConnecter($id)
    {
        $req = "SELECT *FROM utilisateur WHERE id='" . $id . "' AND statut='1'";
        $rs = self::connection()->query($req);
        if ($rs->fetch()) {
            $con = null;
            return true;
        } else {
            $con = null;
            return false;
        }

    }

    public static function dejaConnecter($id)
    {
        $req = "SELECT *FROM utilisateur WHERE id='" . $id . "' AND statut='1'";
        $rs = self::connection()->query($req);
        if ($data = $rs->fetch()) {
            if ($_SESSION['id_session'] == $data['id_session']) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }

    }


    /**
     * verifier si l'utilisateur a le droit de se connecter sur le systeme
     * @param $id
     * @return bool
     */
    private static function SiUtilisateurActive($id)
    {
        $req = "SELECT *FROM utilisateur WHERE id='" . $id . "' AND active='oui'";
        $rs = self::connection()->query($req);
        if ($rs->fetch()) {
            $con = null;
            return true;
        } else {
            $con = null;
            return false;
        }

    }


    /**
     * d'ajouter un nouvel utilisateur
     * @return bool|string
     */
    public function Enregistrer()
    {
        try {
            if (self::SiPseudoExiste($this->getPseudo())) {
                return "pseudo existe";
            }
            $con=self::connection();
            $req="insert into utilisateur(pseudo,email,role,nom,prenom,motdepasse,active,photo,telephone,id_classe) value
            (:pseudo,:email,:role,:nom,:prenom,:motdepasse,:active,:photo,:telephone,:id_classe)";

            $stmt=$con->prepare($req);
            $param=array(
              ":pseudo"=>$this->pseudo,
              ":email"=>$this->email,
              ":role"=>$this->role,
              ":nom"=>$this->nom,
              ":prenom"=>$this->prenom,
              ":motdepasse"=>$this->motdepasse,
              ":active"=>$this->active,
              ":photo"=>$this->photo,
              ":telephone"=>$this->telephone,
              ":id_classe"=>$this->id_classe
            );

            if($stmt->execute($param)){
                return "ok";
            }

            return "no";
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }

    }


    /**
     * rechercher utilisateur
     * @param $critere
     * @return Utilisateur|null
     */
    public static function Rechercher($critere)
    {

        try {
            $con = self::connection();
            $req = "SELECT *FROM utilisateur WHERE id='" . $critere . "' OR pseudo='" . $critere . "' OR email='" . $critere . "' OR telephone='" . $critere . "'";
            $stmt = $con->prepare($req);
            $stmt->execute();
            $data = $stmt->fetchAll(\PDO::FETCH_CLASS, "systeme\\Model\\Utilisateur");
            if (count($data) > 0) {
                return $data[0];
            } else {
                return null;
            }
        } catch (Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

    }


    /**
     * connection
     * @param $critere
     * @param $motdepasse
     * @return string
     */
    public static function Connecter($critere, $motdepasse)
    {
        try {
            date_default_timezone_set("America/Port-au-Prince");
            $con = self::connection();
            $motdepasse = sha1($motdepasse);
            $req = "SELECT *FROM utilisateur WHERE (pseudo=:critere OR email=:critere OR telephone=:critere) AND motdepasse=:motdepasse";
            $stmt = $con->prepare($req);
            $param = array(
                ":critere" => $critere,
                ":motdepasse" => $motdepasse
            );
            $stmt->execute($param);
            if ($data = $stmt->fetch()) {
                if (isset($_SESSION['utilisateur'])) {
                    return "session encour";
                }

                if (!self::SiUtilisateurActive($data['id'])) {
                    return "votre compte est inactif, contacter l'administrateur";
                }
                $id_session = md5(sha1(uniqid('', true)));

                $re = "UPDATE utilisateur SET statut='1',id_session='" . $id_session . "' WHERE id='" . $data['id'] . "'";
                self::connection()->query($re);
                $_SESSION['utilisateur'] = $data['id'];
                $_SESSION['pseudo'] = $data['pseudo'];
                $_SESSION['role'] = $data['role'];
                $_SESSION['id_session'] = $id_session;
                $cookie_name = "conn";
                $cookie_value = 'oui';
                setcookie($cookie_name, $cookie_value, time() + (86400 * 365), "/", "", true, true); // 86400 = 1 day

                $tmpc = new TempConnexion();
                $tmpc->setTypeUser('utilisateur');
                $tmpc->setIdUser($data['id']);
                $tmpc->setDate(date("Y-m-d"));
                $tmpc->setHeure(date("H:i:s"));
                $tmpc->setType("connexion");
                $tmpc->setTemp(date("U"));
                $tmpc->setTempReel(0);
                $tmpc->add();

                return "ok";

            } else {
                return "pseudo ou motdepasse incorect";
            }
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

    }

    /**
     * deconnection
     * @return bool
     */
    public static function Deconnecter()
    {
        if (isset($_SESSION['utilisateur'])) {
            $id = $_SESSION['utilisateur'];
            $re = "UPDATE utilisateur SET statut='0' WHERE id='" . $id . "'";
            self::connection()->query($re);
            $tmpc = new TempConnexion();
            $tmpc->setTypeUser('utilisateur');
            $tmpc->setIdUser($id);
            $tmpc->setDate(date("Y-m-d"));
            $tmpc->setHeure(date("H:i:s"));
            $tmpc->setType("deconnexion");
            $tmpc->setTemp(date("U"));
            $tmpc->add();
            setcookie("conn", "", time() - 3600);
            session_destroy();
            return true;
        } else {
            return false;
        }
    }


    /**
     * verifier si la session utilisateur existe
     * @return bool
     */
    public
    static function session()
    {
        if (isset($_SESSION['utilisateur'])) {
            return true;
        } else {
            return false;
        }

    }

    /**
     * retourner la valeur de la sessio en cour
     * @return null
     */
    public
    static function session_valeur()
    {
        if (isset($_SESSION['utilisateur'])) {

            return $_SESSION['utilisateur'];
        } else {
            return null;
        }

    }


    /**
     * @return bool
     */
    public
    function modifier()
    {

        $req = "UPDATE utilisateur SET nom='" . $this->nom . "', prenom='" . $this->prenom . "'
        ,motdepasse='" . $this->motdepasse . "',telephone='" . $this->telephone . "',photo='" . $this->photo . "' WHERE id='" . $this->id . "'";
        if (self::connection()->query($req)) {
            $con = null;
            return true;
        } else {
            $con = null;
            return false;
        }
    }

    /**
     * Lister tout les utilisateur
     * @return array
     */
    public
    function Lister()
    {
        try {
            $con = self::connection();
            $req = "SELECT *FROM utilisateur";
            $stmt = $con->prepare($req);
            $stmt->execute();
            $data = $stmt->fetchAll(\PDO::FETCH_CLASS, "systeme\\Model\\Utilisateur");
            return $data;
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }


    /**
     * @return array|string
     */
    public
    static function listeOnline()
    {
        try {
            $u = self::session_valeur();
            $con = self::connection();
            $req = "SELECT *FROM utilisateur WHERE statut='1' AND id <> '" . $u . "' ";
            $stmt = $con->prepare($req);
            $stmt->execute();
            $data = $stmt->fetchAll(\PDO::FETCH_CLASS, "systeme\\Model\\Utilisateur");
            return $data;
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }

    public
    static function all()
    {
        try {
            $u = self::session_valeur();
            $con = self::connection();
            $req = "SELECT *FROM utilisateur WHERE statut='1'";
            $stmt = $con->prepare($req);
            $stmt->execute();
            $data = $stmt->fetchAll(\PDO::FETCH_CLASS, "systeme\\Model\\Utilisateur");
            return $data;
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }

    /**
     * @return array|string
     */
    public
    static function listeOffline()
    {
        try {
            $con = self::connection();
            $req = "SELECT *FROM utilisateur WHERE statut='0'";
            $stmt = $con->prepare($req);
            $stmt->execute();
            $data = $stmt->fetchAll(\PDO::FETCH_CLASS, "systeme\\Model\\Utilisateur");
            return $data;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    /**
     * @param $id
     */
    public
    static function Supprimer($id)
    {
        $req = "DELETE FROM utilisateur WHERE id='" . $id . "'";
        self::connection()->query($req);
        $con = null;
    }

    /**
     * @param $id
     */
    public
    static function blocker($id)
    {
        $req = "UPDATE utilisateur SET active='non' WHERE id='" . $id . "'";
        self::connection()->query($req);
        $con = null;
    }

    /**
     * @param $id
     */
    public
    static function deblocker($id)
    {
        $req = "UPDATE utilisateur SET active='oui' WHERE id='" . $id . "'";
        self::connection()->query($req);
        $con = null;
    }

    /**
     * @return mixed
     */
    public
    static function pseudo()
    {
        if (isset($_SESSION['pseudo'])) {
            return $_SESSION['pseudo'];
        }
    }

    /**
     * @return mixed
     */
    public
    static function role()
    {
        if (isset($_SESSION['role'])) {
            return $_SESSION['role'];
        }
    }

    /**
     * @return mixed
     */
    public
    static function password()
    {
        $req = "SELECT motdepasse FROM utilisateur WHERE id='" . self::session_valeur() . "'";
        $con = self::connection();
        $res = $con->query($req);
        $data = $res->fetch();
        return $data['motdepasse'];
    }

    /**
     * @param $id
     * @param $password
     * @return string
     */
    public
    static function changePassword($id, $password)
    {
        try {
            $password = sha1($password);
            $req = "UPDATE utilisateur SET motdepasse='" . $password . "' WHERE id='" . $id . "'";
            $con = self::connection();
            if ($con->query($req)) {
                return "ok";
            } else {
                return "no";
            }
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    /**
     * @return mixed
     */
    public
    static function dernierId()
    {
        //include("fonction.php");
        $con = self::connection();
        $req = "SELECT *FROM utilisateur ORDER BY id DESC LIMIT 1";
        $rps = $con->query($req);
        $data = $rps->fetch();
        $id = $data['id'];
        $con = null;
        return $id;
    }


}