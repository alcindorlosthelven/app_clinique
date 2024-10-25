<?php
$role = \systeme\Model\Utilisateur::role();
if ($role == "admin") {
    require_once "dash_admin.php";
} elseif ($role == "patient") {
    require_once "dash_patient.php";
} elseif ($role == "médecin") {
    require_once "dash_medecin.php";
} elseif ($role == "médecin radiologue") {
    require_once "dash_medecin.php";
}
?>
