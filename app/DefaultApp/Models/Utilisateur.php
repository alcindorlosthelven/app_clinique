<?php


namespace app\DefaultApp\Models;


use app\DefaultApp\DefaultApp;
use systeme\Model\Model;

class Utilisateur extends Model
{

    public $id, $nom, $prenom, $pseudo, $password, $role, $objet, $connect, $id_entreprise,$all_access;


    /**
     * @return mixed|string
     */
    public function getConnect()
    {
        return $this->connect;
    }

    /**
     * @param mixed|string $connect
     */
    public function setConnect($connect)
    {
        $this->connect = $connect;
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
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param mixed $prenom
     */
    public function setPrenom($prenom): void
    {
        $this->prenom = $prenom;
    }

    /**
     * @return mixed
     */
    public function getPseudo()
    {
        return $this->pseudo;
    }

    /**
     * @param mixed $pseudo
     */
    public function setPseudo($pseudo): void
    {
        $this->pseudo = $pseudo;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
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
    public function setRole($role): void
    {
        $this->role = $role;
    }

    /**
     * @return mixed
     */
    public function getObjet()
    {
        return $this->objet;
    }

    /**
     * @param mixed $objet
     */
    public function setObjet($objet): void
    {
        $this->objet = $objet;
    }
    public function __construct($objet = "utilisateur", $connect = "non")
    {
        $this->objet = $objet;
        $this->connect = $connect;
    }

    public static function setConnection($id)
    {
        try {
            $id_session = md5(sha1(uniqid('', true)));
            $con = self::connection();
            $req = "UPDATE utilisateur SET connect=:connect WHERE id=:id";
            $stmt = $con->prepare($req);
            if ($stmt->execute(array(
                ":connect" => "oui",
                ":id" => $id
            ))
            ) {
                $_SESSION['id_session'] = $id_session;
                return "ok";
            } else {
                return "no";
            }
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    public static function login($user_name, $password)
    {
        $password = md5($password);
        try {
            $con = self::connection();
            $req = "SELECT *FROM utilisateur WHERE pseudo=:pseudo AND password=:password";
            $stmt = $con->prepare($req);
            $stmt->execute(array(
                ":pseudo" => $user_name,
                ":password" => $password
            ));
            $data = $stmt->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
            if (count($data) > 0) {
                self::setConnection($data[0]->getId());
                $data[0]->setConnect("oui");
                $data[0]->statut = "ok";
                return $data[0];
            } else {
                return "no";
            }
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

    }

    public static function total($id_entreprise)
    {
        $con = self::connection();
        $req = "select *from utilisateur where id_entreprise='{$id_entreprise}'";
        $stmt = $con->prepare($req);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public static function lastSup($id_entreprise)
    {
        $con=self::connection();
        $req="select *from utilisateur where role='superviseur' and id_entreprise='{$id_entreprise}' order by id desc limit 1";
        $stmt=$con->prepare($req);
        $stmt->execute();
        $data=$stmt->fetchAll(\PDO::FETCH_OBJ);
        if(count($data)>0){
            return $data[0];
        }
        return null;
    }

    public static function listeSuperviseur($id_entreprise)
    {
        $con = self::connection();
        $req = "select *from utilisateur where role='superviseur' and id_entreprise='{$id_entreprise}' order by id desc";
        $stmt = $con->prepare($req);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }

    public static function listeSuperviseurParId($id_entreprise,$id)
    {
        $con = self::connection();
        $req = "select *from utilisateur where role='superviseur' and id_entreprise='{$id_entreprise}' and id='{$id}' order by id desc";
        $stmt = $con->prepare($req);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }

    public static function connecter($user_name, $password)
    {
        $password = md5($password);
        try {
            $con = self::connection();
            $req = "SELECT *FROM utilisateur WHERE pseudo=:pseudo AND password=:password";
            $stmt = $con->prepare($req);
            $stmt->execute(array(
                ":pseudo" => $user_name,
                ":password" => $password
            ));
            $data = $stmt->fetchAll(\PDO::FETCH_OBJ);
            if (count($data) > 0) {
                if($data[0]->all_access=='oui') {
                    self::setConnection($data[0]->id);
                    $data[0]->statut = "ok";
                    $_SESSION['utilisateur'] = $data[0]->id;
                    $_SESSION['pseudo'] = $data[0]->pseudo;
                    $_SESSION['role'] = $data[0]->role;
                    return "ok";
                }else{
                    $id_entreprise=$data[0]->id_entreprise;
                    $en=new Entreprise();
                    $en=$en->findById($id_entreprise);
                    if($en!=null){
                        if(!\app\DefaultApp\DefaultApp::isValide($en->date_expiration)){
                            return "imposible de se connecter,compte inactif";
                        }else{
                            self::setConnection($data[0]->id);
                            $data[0]->statut = "ok";
                            $_SESSION['utilisateur'] = $data[0]->id;
                            $_SESSION['pseudo'] = $data[0]->pseudo;
                            $_SESSION['role'] = $data[0]->role;
                            return "ok";
                        }
                    }else{
                        return "imposible de se connecter , bank introuvable";
                    }
                }
            } else {
                return "pseudo ou motdepasse incorect";
            }
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    public static function getEntreprise()
    {
        $u=new Entreprise();
        $id_user=\systeme\Model\Utilisateur::session_valeur();
        $u=new Utilisateur();
        $u=$u->findById($id_user);
        if($u==null){
            session_destroy();
            return "";
        }
        $en = new Entreprise();
        $en = $en->findById($u->id_entreprise);
        return $en;
    }

    public static function hasAllAcces()
    {
        $id_user = \systeme\Model\Utilisateur::session_valeur();
        $con = self::connection();
        $req = "select *from utilisateur where id='{$id_user}' and all_access='oui'";
        $stmt = $con->prepare($req);
        $stmt->execute();
        $data = $stmt->fetchAll();
        if (count($data) > 0) {
            return true;
        }
        return false;
    }

    public static function switchEntreprise($user, $entreprise)
    {
        $con = self::connection();
        $req = "update utilisateur set id_entreprise=:id_entreprise where id=:id";
        $stmt = $con->prepare($req);
        $stmt->execute(array(":id_entreprise" => $entreprise, ":id" => $user));
        if ($stmt->rowCount() > 0) {
            return "ok";
        }
        return "no";
    }

    public function findAll()
    {
        $id_entreprise = Utilisateur::getEntreprise()->id;
        $con = self::connection();
        $req = "select *from utilisateur where id_entreprise='{$id_entreprise}' order by id desc";
        $stmt = $con->prepare($req);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }


    public function rechercherSup($id)
    {
        $con = self::connection();
        $req = "select *from utilisateur where id=:id and role='superviseur'";
        $stmt = $con->prepare($req);
        $stmt->execute(array(":id"=>$id));
        $data=$stmt->fetchAll(\PDO::FETCH_CLASS,__CLASS__);

        if(count($data)>0){
            return $data[0];
        }

        return null;
    }

    public static function getMainUser()
    {
        $con = self::connection();
        $req = "select *from utilisateur where nom='admin' and prenom='admin' and pseudo='admin'";
        $stmt = $con->prepare($req);
        $stmt->execute();
        $data = $stmt->fetchObject();
        return $data->id;
    }

    public static function checkPassword($id,$password){
        $password=md5($password);
        $con=self::connection();
        $req="select *from client where password=:password and id=:id";
        $stmt=$con->prepare($req);
        $stmt->execute(array(":password"=>$password,":id"=>$id));
        $data=$stmt->fetchAll();
        if(count($data)>0){
            return true;
        }else{
            return false;
        }
    }

    public static function checkPasswordVendeur($id,$password){
        $password=md5($password);
        $con=self::connection();
        $req="select *from vendeur where password=:password and id=:id";
        $stmt=$con->prepare($req);
        $stmt->execute(array(":password"=>$password,":id"=>$id));
        $data=$stmt->fetchAll();
        if(count($data)>0){
            return true;
        }else{
            return false;
        }
    }


}
