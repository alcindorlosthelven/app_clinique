<?php
$role=$_SESSION['role'];
?>

<div class="deznav">
    <div class="deznav-scroll">
        <?php
        if($role=="admin"){
            require_once "menu_admin.php";
        }elseif($role=="technicien"){
            require_once "menu_technicien.php";
        }elseif($role=="comptabilité"){
            require_once "menu_kontab.php";
        }elseif($role=="réceptionniste"){
            require_once "menu_receptionis.php";
        }elseif($role=="medecin radiologue"){
            require_once "menu_m.php";
        }elseif($role=="médecin"){
            require_once "menu_mr.php";
        }elseif($role=="patient"){
            require_once "menu_pt.php";
        }
        ?>

        <div class="plus-box" style="display: none">
            <a href="javascript:void(0);" class="text-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">Create new appointment</a>
        </div>

        <div class="copyright" style="display: none">
            <p><strong>Mediqu Hospital Admin Dashboard</strong> © 2023 All Rights Reserved</p>
            <p>Made with <span class="heart"></span> by DexignZone</p>
        </div>
    </div>
</div>
