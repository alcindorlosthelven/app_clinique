<?php

/**
 * Created by PhpStorm.
 * User: alcin
 * Date: 4/8/2020
 * Time: 1:43 PM
 */

namespace app\DefaultApp\Models;

use systeme\Model\Model;

class DemmandeImagerie extends Model
{
    protected $table = "demmande_imagerie";
    public $id, $id_patient, $date, $date_prelevement, $id_medecin, $statut, $payer, $indication, $remarque, $technicien, $facture, $exantus_date, $deverson_date;
    public $deverson, $exantus, $raison_suppression;

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
    public function getIdPatient()
    {
        return $this->id_patient;
    }

    /**
     * @param mixed $id_patient
     */
    public function setIdPatient($id_patient): void
    {
        $this->id_patient = $id_patient;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date): void
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getDatePrelevement()
    {
        return $this->date_prelevement;
    }

    /**
     * @param mixed $date_prelevement
     */
    public function setDatePrelevement($date_prelevement): void
    {
        $this->date_prelevement = $date_prelevement;
    }

    /**
     * @return mixed
     */
    public function getIdMedecin()
    {
        return $this->id_medecin;
    }

    /**
     * @param mixed $id_medecin
     */
    public function setIdMedecin($id_medecin): void
    {
        $this->id_medecin = $id_medecin;
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
    public function setStatut($statut): void
    {
        $this->statut = $statut;
    }

    /**
     * @return mixed
     */
    public function getPayer()
    {
        return $this->payer;
    }

    /**
     * @param mixed $payer
     */
    public function setPayer($payer): void
    {
        $this->payer = $payer;
    }



    public static function dernierId()
    {
        $con = self::connection();
        $req = "select id from demmande_imagerie order by id desc LIMIT 1";
        $rs = $con->query($req);
        $data = $rs->fetch();
        return $data['id'];
    }


    public static function listeNa($id_user = "", $institution = "")
    {
        $con = self::connection();
        $where = ["statut='n/a'", "payer='oui'"];
        $params = [];
    
        if (!empty($institution)) {
            $where[] = "institution = ?";
            $params[] = $institution;
        }
    
        if (!empty(trim($id_user))) {
            $ids = array_filter(array_map('trim', explode(",", $id_user)), fn($id) => $id !== '');
            if (!empty($ids)) {
                $regexParts = [];
                foreach ($ids as $id) {
                    $regexParts[] = "(^|,)$id($|,)";
                }
                $regexPattern = implode("|", $regexParts);
                $where[] = "id_medecin REGEXP ?";
                $params[] = $regexPattern;
            }
        }
    
        $sql = "SELECT * FROM demmande_imagerie WHERE " . implode(" AND ", $where);
        $stmt = $con->prepare($sql);
        $stmt->execute($params);
        
        return $stmt->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }

    public static function listeNaPatient($id_user)
    {
        $req = "select *from demmande_imagerie WHERE statut='n/a' and payer='oui'  and id_patient='{$id_user}'";
        $con = self::connection();
        $stmt = $con->prepare($req);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }

    public static function listeEncourPatient($id_user)
    {
        $req = "select *from demmande_imagerie WHERE statut='encour' and payer='oui' and id_patient='{$id_user}'";
        $con = self::connection();
        $stmt = $con->prepare($req);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }


    public static function listeEncour($id_user = "", $institution = "")
    {
        $con = self::connection();
        $where = [];
        $params = [];

        if (empty($institution)) {
            // Always apply this condition
            $where[] = "(deverson = '0' OR exantus = '0')";

            if (!empty(trim($id_user))) {
                $ids = array_filter(array_map('trim', explode(",", $id_user)), fn($id) => $id !== '');
                if (!empty($ids)) {
                    // Create a regex pattern to match any of the IDs in the comma-separated list
                    $regexParts = [];
                    foreach ($ids as $id) {
                        $regexParts[] = "(^|,)$id($|,)";
                    }
                    $regexPattern = implode("|", $regexParts);
                    $where[] = "id_medecin REGEXP ?";
                    $params[] = $regexPattern;
                }
            }
        } else {
            $where[] = "statut = 'encour'";
            $where[] = "institution = ?";
            $params[] = $institution;
            $where[] = "payer = 'oui'";

            if (!empty(trim($id_user))) {
                $ids = array_filter(array_map('trim', explode(",", $id_user)), fn($id) => $id !== '');
                if (!empty($ids)) {
                    // Create a regex pattern to match any of the IDs in the comma-separated list
                    $regexParts = [];
                    foreach ($ids as $id) {
                        $regexParts[] = "(^|,)$id($|,)";
                    }
                    $regexPattern = implode("|", $regexParts);
                    $where[] = "id_medecin REGEXP ?";
                    $params[] = $regexPattern;
                }
            }
        }

        $sql = "SELECT * FROM demmande_imagerie";
        if (!empty($where)) {
            $sql .= " WHERE " . implode(" AND ", $where);
        }
        $sql .= " ORDER BY id DESC";

        $stmt = $con->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }



    public static function listeEncour2()
    {
        $con = self::connection();
        $req = "select *from demmande_imagerie WHERE statut='encours' ordr by -id";
        $stmt = $con->prepare($req);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public static function listePret($id_user = "", $institution = "")
    {
        $con = self::connection();
        $where = [];
        $params = [];

        if ($institution == "") {
            $where[] = "deverson = 'oui'";
            $where[] = "exantus = 'oui'";

            if (!empty(trim($id_user))) {
                $ids = array_filter(array_map('trim', explode(",", $id_user)), fn($id) => $id !== '');
                if (!empty($ids)) {
                    // Create a regex pattern to match any of the IDs in the comma-separated list
                    $regexParts = [];
                    foreach ($ids as $id) {
                        $regexParts[] = "(^|,)$id($|,)";
                    }
                    $regexPattern = implode("|", $regexParts);
                    $where[] = "id_medecin REGEXP ?";
                    $params[] = $regexPattern;
                }
            }
        } else {
            $where[] = "statut = 'pret'";
            $where[] = "institution = ?";
            $params[] = $institution;
            $where[] = "payer = 'oui'";

            if (!empty(trim($id_user))) {
                $ids = array_filter(array_map('trim', explode(",", $id_user)), fn($id) => $id !== '');
                if (!empty($ids)) {
                    // Create a regex pattern to match any of the IDs in the comma-separated list
                    $regexParts = [];
                    foreach ($ids as $id) {
                        $regexParts[] = "(^|,)$id($|,)";
                    }
                    $regexPattern = implode("|", $regexParts);
                    $where[] = "id_medecin REGEXP ?";
                    $params[] = $regexPattern;
                }
            }
        }

        $sql = "SELECT * FROM demmande_imagerie";
        if (!empty($where)) {
            $sql .= " WHERE " . implode(" AND ", $where);
        }
        $sql .= " ORDER BY id DESC";

        $stmt = $con->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }

    public static function listePretPatient($id_user)
    {
        $con = self::connection();
        $req = "select *from demmande_imagerie WHERE statut='pret' and payer='oui'  and id_patient='{$id_user}'";
        $stmt = $con->prepare($req);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }

    public static function all($id_user = "", $institution = "")
    {
        $con = self::connection();
        $where = ["payer='oui'"];
        $params = [];

        if (!empty($institution)) {
            $where[] = "institution = ?";
            $params[] = $institution;
        }

        if (!empty(trim($id_user))) {
            $ids = array_filter(array_map('trim', explode(",", $id_user)), fn($id) => $id !== '');
            if (!empty($ids)) {
                $regexParts = [];
                foreach ($ids as $id) {
                    $regexParts[] = "(^|,)$id($|,)";
                }
                $regexPattern = implode("|", $regexParts);
                $where[] = "id_medecin REGEXP ?";
                $params[] = $regexPattern;
            }
        }

        $sql = "SELECT * FROM demmande_imagerie WHERE " . implode(" AND ", $where) . " ORDER BY id DESC";
        $stmt = $con->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }
    public static function listeSupprimer($id_user = "", $institution = "")
    {
        $con = self::connection();
        $where = ["statut='supprimer'"];
        $params = [];

        if (!empty($institution)) {
            $where[] = "institution = ?";
            $params[] = $institution;
        }

        if (!empty(trim($id_user))) {
            $ids = array_filter(array_map('trim', explode(",", $id_user)), fn($id) => $id !== '');
            if (!empty($ids)) {
                $regexParts = [];
                foreach ($ids as $id) {
                    $regexParts[] = "(^|,)$id($|,)";
                }
                $regexPattern = implode("|", $regexParts);
                $where[] = "id_medecin REGEXP ?";
                $params[] = $regexPattern;
            }
        }

        $sql = "SELECT * FROM demmande_imagerie WHERE " . implode(" AND ", $where);
        $stmt = $con->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }

    public static function listeArchive($id_user = "", $institution = "")
    {
        $con = self::connection();
        $where = ["statut='archive'"];
        $params = [];

        if (!empty($institution)) {
            $where[] = "institution = ?";
            $params[] = $institution;
        }

        if (!empty(trim($id_user))) {
            $ids = array_filter(array_map('trim', explode(",", $id_user)), fn($id) => $id !== '');
            if (!empty($ids)) {
                $regexParts = [];
                foreach ($ids as $id) {
                    $regexParts[] = "(^|,)$id($|,)";
                }
                $regexPattern = implode("|", $regexParts);
                $where[] = "id_medecin REGEXP ?";
                $params[] = $regexPattern;
            }
        }

        $sql = "SELECT * FROM demmande_imagerie WHERE " . implode(" AND ", $where);
        $stmt = $con->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }
    public static function allPatient($id_user)
    {
        $con = self::connection();
        $req = "select *from demmande_imagerie where payer='oui' and id_patient='{$id_user}' order by id desc ";
        $stmt = $con->prepare($req);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }

    public static function imagerieDejaFait($demande, $examen)
    {
        $con = self::connection();
        $req = "select *from examens_demande_imagerie where id_demande='" . $demande . "' and id_imagerie='" . $examen . "' and resultat <> 'n/a' ";
        $rs = $con->query($req);
        if ($rs->fetch()) {
            return true;
        } else {
            return false;
        }
    }

    public static function resultatExamenImagerie($demande, $examen)
    {
        $con = self::connection();
        $req = "select *from examens_demande_imagerie where id_demande='" . $demande . "' and id_imagerie='" . $examen . "' ";
        $stmt = $con->prepare($req);
        $stmt->execute();
        $data = $stmt->fetchAll(\PDO::FETCH_CLASS, "app\DefaultApp\Models\ExamensDemandeImagerie");
        if (count($data) > 0) {
            return $data[0];
        } else {
            return null;
        }
    }

    public static function listerExamens($id_demande)
    {
        $resultat = array();
        $lep = ExamensDemandeImagerie::listerParDemmande($id_demande);
        foreach ($lep as $img) {
            $imagerie = new Imagerie();
            $imagerie = $imagerie->findById($img->getIdImagerie());
            $resultat[] = $imagerie;
        }
        return $resultat;
    }

    public static function listerExamensApres($id_demande)
    {
        $resultat = array();
        $lep = ExamensDemandeImagerie::listerParDemmande($id_demande);
        foreach ($lep as $img) {
            $imagerie = new Imagerie();
            $imagerie = $imagerie->findById($img->getIdImagerie());
            $imagerie->prix = $img->prix;
            $resultat[] = $imagerie;
        }
        return $resultat;
    }

    public static function totalParAdmision($id_adm)
    {
        $bdd = self::connection();
        $total = $bdd->query("SELECT * FROM demmande_imagerie WHERE id_admision='" . $id_adm . "'");
        return $total->rowCount();
    }

    public function ListerParDossier($no_dossier)
    {
        try {
            $con = self::connection();
            $req = "select *from demmande_imagerie where no_dossier='{$no_dossier}' order by id desc ";
            $stmt = $con->prepare($req);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_CLASS, "app\DefaultApp\Models\DemmandeImagerie");
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function ListerParInstitution($instition)
    {
        try {
            $con = self::connection();
            $req = "select *from demmande_imagerie where institution='{$instition}' order by id desc ";
            $stmt = $con->prepare($req);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_CLASS, "app\DefaultApp\Models\DemmandeImagerie");
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function lie($id, $idPatient)
    {
        try {
            $con = self::connection();
            $req = "UPDATE demmande_imagerie SET id_patient='{$idPatient}' WHERE id='{$id}'";
            if ($con->query($req)) {
                return "ok";
            } else {
                return "no";
            }
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function siLie($id)
    {
        $con = self::connection();
        $req = "select id_patient from demmande_imagerie where id='" . $id . "'";
        $rs = $con->query($req);
        $data = $rs->fetch();
        if ($data['id_patient'] === "") {
            return false;
        } else {
            return true;
        }
    }

    public static function listeNonPayer()
    {
        try {
            $con = self::connection();
            $req = "select *from demmande_imagerie where payer='non' order by id desc ";
            $stmt = $con->prepare($req);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function listerParPatient($id_patient)
    {
        $con = self::connection();
        $req = "select *from demmande_imagerie where id_patient=:id_patient order by id desc ";
        $stmt = $con->prepare($req);
        $stmt->execute(array(":id_patient" => $id_patient));
        return $stmt->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }

    public static function listerParDate($date1, $date2, $institution = "")
    {
        $con = self::connection();
        if ($institution == "") {
            $req = "select *from demmande_imagerie where date between '{$date1}' and '{$date2}' and payer='oui'";
        } else {
            $req = "select *from demmande_imagerie where date between '{$date1}' and '{$date2}' and institution = '{$institution}' and payer='oui'";
        }
        $stmt = $con->prepare($req);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }
    public static function findByIdDemmande($id)
    {
        $con = self::connection();
        $req = "select *from demmande_imagerie where id='{$id}'";
        $stmt = $con->prepare($req);
        $stmt->execute();
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($data) {
            return $data;
        }
    }
}
