<div class="row">
    <div class="col-md-12">
        <?php
        if(!isset($id)){
            return;
        }
        $de=new \app\DefaultApp\Models\DemmandeImagerie();
        $de=$de->findById($id);
        $id_patient = $de->getIdPatient();
        $patient = new \app\DefaultApp\Models\Patient();
        $patient = $patient->findById($id_patient);
        if ($patient == null) {
            echo "patient introuvable";
            return;
        }
        \systeme\Application\Application::block("menu_imagerie") ?>
        <div class="card">
            <div class="card-header"><h4>Technique</h4></div>
            <div class="card-body">
                <p>
                    <strong>Nom : </strong><?= ucfirst($patient->nom) ?><br>
                    <strong>Prénom : </strong><?= ucfirst($patient->prenom) ?><br>
                    <strong>Date de Naissance : </strong><?= $patient->date_naissance ?><br>
                </p>
                <hr>
                <div class="message"></div>
                <?php
                if(isset($_GET['nf'])){
                    $u=new \app\DefaultApp\Models\Utilisateur();
                    $u=$u->findById($de->technicien);
                    ?>
                    <div class="card">
                        <div class="card-body">
                            <p>
                                Date : <strong><?= $de->date_prelevement ?></strong><br>
                                Technicien : <strong><?php if($u!=null) echo ucfirst($u->getNom()." ".$u->getPrenom()); ?></strong><br>
                                <br><strong>Remarque :</strong> <br><?= stripslashes($de->remarque) ?><br>
                                <strong>Indication :</strong> <br> <?= stripslashes($de->indication) ?>
                            </p>
                        </div>
                    </div>
                    <?php
                }else{
                    ?>
                    <form class="form-signin specimen_imagerie" method="post">
                        <input type="hidden" name="specimen">
                        <div class="form-group">
                            <label>Date</label>
                            <input name="date" type="text" value="<?= date('Y-m-d') ?>" class="form-control dp1" required>
                        </div>
                        <table class="table table-bordered" style="">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Examen</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if (isset($listeExamens)) {
                                if (count($listeExamens) > 0) {
                                    foreach ($listeExamens as $labo) {
                                        $exdl=\app\DefaultApp\Models\ExamensDemandeImagerie::rechercher($id,$labo->getId());
                                        $statut=$exdl->getStatut();
                                        ?>
                                        <tr>
                                            <td>
                                                <?php
                                                if($statut==1){?>
                                                    <input <?php if($statut==1){echo "checked readonly";} ?> value="" type="checkbox" class="form-control">

                                                    <?php
                                                }else{
                                                    ?>
                                                    <input <?php if($statut==1){echo "checked readonly";} ?> value="" type="checkbox" class="form-control" name="ex-<?= $labo->getId(); ?>">
                                                    <?php
                                                }
                                                ?>
                                            </td>
                                            <td><?= stripslashes($labo->getNom()); ?></td>

                                        </tr>

                                        <?php
                                    }
                                }
                            }
                            ?>
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="form-group col-6">
                                <label>Remarque</label>
                                <input type="text" class="editeur" name="remarque">
                            </div>

                            <div class="form-group col-6">
                                <label>Indication</label>
                                <input type="text" class="editeur" name="indication">
                            </div>

                            <div class="form-group col-12">
                                <input type="hidden" name="id_demande" value="<?= $id ?>"/>
                                <button class="pull-right btn btn-success btn_valider btn-block" id="enregistrer_note">Valider</button>
                            </div>

                        </div>
                    </form>
                <?php
                }
                ?>
                <div class="message"></div>
            </div>
        </div>
    </div>


</div>
</div>