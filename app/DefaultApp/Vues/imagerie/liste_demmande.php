<?php

use app\DefaultApp\Models\AccesUser;
$cache = "display:none";
$aficher = "display:inline";
function getListeExamens($id)
{
    $nom_examens = "";
    $examens = \app\DefaultApp\Models\ExamensDemandeImagerie::listerParDemmande($id);
    foreach ($examens as $exam) {
        $id_exam = $exam->id_imagerie;
        $imagerie = new \app\DefaultApp\Models\Imagerie();
        $imagerie = $imagerie->findById($id_exam);
        $nom_examens .= $imagerie->nom . "<br>";
    }
    return $nom_examens;
}
?>

<div class="row">
    <div class="col-md-12">
        <?php \systeme\Application\Application::block("menu_imagerie") ?>
        <div class="card">
            <div class="card-body">
                <?php
                if(isset($_GET['admin'])){
                    \app\DefaultApp\DefaultApp::block("admin_imagerie");
                }elseif(isset($_GET['examens'])){
                    abc:
                    \app\DefaultApp\DefaultApp::block("examens_imagerie");
                }else{
                    goto abc;
                }
                ?>
            </div>
        </div>
    </div>
</div>
