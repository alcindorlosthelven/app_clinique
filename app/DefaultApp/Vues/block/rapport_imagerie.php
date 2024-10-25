<h3>Rapport</h3>
<form method="post" class="no-print">
    <div class="row">
        <div class="form-group col-6">
            <label>DE</label>
            <input value="<?php if (isset($_POST['de'])) {
                echo $_POST['de'];
            } else {
                echo date("Y-m-d");
            } ?>" type="text" class="form-control date1 dp1"
                   name="de"
                   placeholder="De">
        </div>

        <div class="form-group col-6">
            <label>A</label>
            <input value="<?php if (isset($_POST['a'])) {
                echo $_POST['a'];
            } else {
                echo date("Y-m-d");
            } ?>" type="text" class="form-control date1 dp1"
                   name="a"
                   placeholder="A">
        </div>
        <input type="submit" value="Generer Rapport" class="btn btn-block btn-primary">
    </div>
</form>

<?php
if (isset($_POST['de'])) {
    $de = $_POST['de'];
    $a = $_POST['a'];
    if (isset($_GET['idcategorie'])) {
        $liste = \app\DefaultApp\Models\DemmandeImagerie::listerParDate($de, $a, $_GET['idcategorie']);
    }
    ?>
    <hr>
    <table id='' class='table table-bordered datatable'
           style='font-size:13px'>
        <thead>
        <tr>
            <th>Assurance</th>
            <th>Code</th>
            <th>Patient</th>
            <th>Date</th>
            <th>Examens</th>
            <th>Medecin</th>
            <th>Rabais</th>
            <th>%Assurance</th>
            <th>Montant</th>
            <th>Mode paiement</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $patient = new \app\DefaultApp\Models\Patient();
        $medecin = new \app\DefaultApp\Models\PersonelMedical();
        if (count($liste) > 0) {
            foreach ($liste as $ex) {
                $gimg = new \app\DefaultApp\Models\GdemmandeImagerie();
                $gimg = $gimg->findByIdDemmande($ex->id);
                if ($gimg != null) {
                    $transaction = new \app\DefaultApp\Models\Transaction();
                    $transaction = $transaction->findByReference("img-" . $gimg->id);
                    $v = new \app\DefaultApp\Models\Vente();
                    if($transaction!==null){
                    $v = $v->findById($transaction->id_vente);
                    $a = false;
                    $nom_examens = getListeExamens($ex->id);
                    $statut = $ex->getStatut();
                    if ($statut === "n/a") {
                        $statut = "encour";
                    }
                    $id_patient = $ex->getIdPatient();
                    if ($id_patient != "") {
                        $patient = $patient->findById($id_patient);
                        $nomPatient = $patient->getNom() . " " . $patient->getPrenom();
                        $codePatient=$patient->code;
                    } else {
                        $nomPatient = "";
                        $codePatient="";
                    }
                    $idmedecin = $ex->id_medecin2;
                    if ($idmedecin === "n/a") {
                        $nomMedecin = $idmedecin;
                    } else {
                        $med = $medecin->findById($idmedecin);
                        if ($med != null) {
                            $nomMedecin = $med->getNom() . " " . $med->getPrenom();
                            $a = true;
                        } else {
                            $nomMedecin = "";
                            $a = false;
                        }
                    }
                    if ($a) {
                        $id_assurance=$ex->id_assurance;
                        if($id_assurance=="n/a" or $id_assurance==null){
                            $nom_assurance="";
                        }else{
                            $ass=new \app\DefaultApp\Models\Assurance();
                            $ass=$ass->findById($id_assurance);
                            $nom_assurance=$ass->getNom();
                        }
                        ?>
                        <tr>
                            <td><?= $nom_assurance ?></td>
                            <td><?= $codePatient ?></td>
                            <td><?= ucfirst($nomPatient) ?></td>
                            <td><?= $ex->getDate(); ?></td>
                            <td><?= $nom_examens ?></td>
                            <td><?= $nomMedecin ?></td>
                            <td><?= $v->deduction ?></td>
                            <td><?= $v->deduction_assurance ?></td>
                            <td><?= \app\DefaultApp\DefaultApp::formatComptable($transaction->montant) ?></td>
                            <td><?= $transaction->mode_paiement ?></td>
                        </tr>
                        <?php
                    }
                }
                }
            }
        }
        ?>
        </tbody>
    </table>
    <?php
}
