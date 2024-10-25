<div class="card">
    <div class="card-header">
        Demmande Imagerie
    </div>

    <div class="card-body">
        <?php
        if (!isset($patient)) {
            return;
        }

        //verification ou creation compte client ou patient
        if (\app\DefaultApp\Models\ComptePatient::existe($patient->id)) {
            $cp = new \app\DefaultApp\Models\ComptePatient();
            $id_compte = \app\DefaultApp\Models\ComptePatient::id($patient->id);
            $comptePatient = $cp->findById($id_compte);
        } else {
            $comptePatient = new \app\DefaultApp\Models\ComptePatient();
            $comptePatient->setIdPatient($patient->id);
            $comptePatient->setDette(0);
            $comptePatient->enregistrer();
            $id_compte = \app\DefaultApp\Models\ComptePatient::id($patient->id);
        }

        if (isset($_GET['id_admision'])) {
            $id_admision = $_GET['id_admision'];
            $admision = new \app\DefaultApp\Models\Admision();
            $admision = $admision->findById($id_admision);
            $id_medecin = $admision->getIdMedecin();
            $medecin = new \app\DefaultApp\Models\PersonelMedical();
            $medecin = $medecin->findById($id_medecin);
        }

        ?>
        <div class="message"></div>
        <div class="col-md-12">
            <h4><strong>Patient : </strong><?= ucfirst($patient->getNom() . " " . $patient->getPrenom()); ?>
            </h4>
        </div>
        <?php
        if (isset($_GET['suivant'])) {
            $ligne = "";
            $ligne1 = "";
            $id_demmande = $_GET['suivant'];
            $gdimagerie=new \app\DefaultApp\Models\GdemmandeImagerie();
            $gdimagerie=$gdimagerie->findById($id_demmande);
            $demmandes=json_decode($gdimagerie->demmande);
            /*$demmande = new \app\DefaultApp\Models\DemmandeImagerie();
            $demmande = $demmande->findById($id_demmande);*/

            $listeExaments=array();
            foreach ($demmandes as $d){
                $le=\app\DefaultApp\Models\DemmandeImagerie::listerExamens($d->id);
                foreach ($le as $e){
                    $listeExaments[]=$e;
                }
            }
            $sousTotal = 0;
            $deduction = 0;
            $total = 0;
            foreach ($listeExaments as $ex) {
                $quantite = 1;
                $devise = new \app\DefaultApp\Models\Devise();
                $devise = $devise->findById($ex->devise);
                if($devise!=null) {
                    if ($devise->devise == "usd") {
                        $prix = \app\DefaultApp\Models\Taux::dollardToGds($ex->prix);
                    } else {
                        $prix = $ex->prix;
                    }
                }else{
                    $prix=$ex->prix;
                }
                $prix=str_replace(",","",$prix);
                $tt = $prix * $quantite;
                $sousTotal += $tt;
                $tt = \app\DefaultApp\DefaultApp::formatComptable($tt);
                $ligne .= "<tr><td style=' font-family: sans-serif;
        text-align: left;
        background-color: #ffffff;'>{$ex->nom}</td><td style='font-family: sans-serif;
     
        text-align: left;
        background-color: #ffffff;'>{$quantite}</td><td style=' font-family: sans-serif;
  
        text-align: left;
        background-color: #ffffff;'>{$prix}</td><td style=' font-family: sans-serif;
        text-align: left;
        background-color: #ffffff;'>{$tt}</td></tr>";

                $ligne1 .= "<tr><td style=' font-family: sans-serif;
        text-align: left;
        background-color: #ffffff;'>{$ex->nom}</td></tr>";

            }
            $total = $sousTotal - $deduction;

        if ($gdimagerie->payer == "oui") {
            ?>
            <div class="impression" style="width: 115mm;margin: auto">
                <page>
                    <div style="width: auto;font-size:12px">
                        <div style="text-align:center">
                            <strong>CHSM GROUP S.A</strong><br>
                            # 43,45 Ave John Brown (Lalue)<br>
                            Port-au-Prince, Haiti<br>
                        </div>
                        <br>
                        <strong>Client : <?= ucfirst($patient->getNom() . " " . $patient->getPrenom()) ?></strong><br>
                        <strong>Agent : <?= \app\DefaultApp\Models\Utilisateur::pseudo() ?></strong>
                        <br>
                        <br>
                        <strong>Demmande Imagerie</strong><br>
                        <strong>No Demmande : <?= $gdimagerie->id ?></strong><br>
                        <strong>Payer : OUI </strong>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-bordered" id="t" style="
        border-collapse: collapse;
        width: 100%;
        font-size: 12px;">
                                <thead>
                                <tr>
                                    <th style="font-family: sans-serif;
        text-align: left;
        background-color: #ffffff;">Item
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <?= $ligne1; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                </page>
            </div>
            <script>
                function imprimer(titre) {
                    let zone = $(".impression").html();
                    let fen = window.open("", "", "height=800, width=1200,toolbar=0, menubar=0, scrollbars=1, resizable=1,status=0, location=0, left=10, top=10");
                    fen.document.body.style.color = '#000000';
                    fen.document.body.style.backgroundColor = '#FFFFFF';
                    fen.document.body.style.padding = "5px";
                    fen.document.title = titre;
                    fen.document.body.innerHTML += " " + zone + " ";
                    fen.window.print();
                    fen.window.close();
                    return true;
                }
            </script>
            <div class="col-12">
                <a onclick="imprimer('')" href="#" class="btn btn-primary btn-block"><i class="fas fa-print"></i>
                    Imprimer</a>
            </div>
        <?php
        }else{
        ?>
            <a href="demande-imagerie-<?= $patient->id ?>?suivant=<?= $gdimagerie->id ?>&normal"
               class="btn btn-outline-dark">Paiement Cash</a>
            <a href="demande-imagerie-<?= $patient->id ?>?suivant=<?= $gdimagerie->id ?>&a-credit"
               class="btn btn-outline-success">Paiement a credit</a>
        <hr>
            <?php
        if (isset($_GET['normal'])) {
            ab:
            ?>
            <div class="card">
                <div class="card-header"></div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>Item</th>
                            <th>Quantité</th>
                            <th>Prix</th>
                            <th>Prix Total</th>
                        </tr>

                        <?php
                        echo $ligne;
                        ?>
                        <tr>
                            <td></td>
                            <td></td>
                            <th>Sous total</th>
                            <th><?= \app\DefaultApp\DefaultApp::formatComptable($total) ?></th>
                        </tr>
                    </table>

                    <hr>
                    <form method="post" class="form_versement_imagerie">
                        <input type="hidden" name="id_patient" value="<?= $patient->id; ?>">
                        <input type="hidden" name="id_demmande" value="<?= $id_demmande; ?>">
                        <div class="row">
                            <div class="form-group col-12">
                                <label>Assurance</label>
                                <select class="form-control" name="assurance">
                                    <option value="n/a">n/a</option>
                                    <?php
                                    $listeAssurance=\app\DefaultApp\Models\AssurancePatient::lister($patient->id);
                                    foreach ($listeAssurance as $as){
                                        $assurance=new \app\DefaultApp\Models\Assurance();
                                        $assurance=$assurance->findById($as->id_assurance);
                                        ?>
                                        <option value="<?= $assurance->getId()?>"><?= strtoupper($assurance->getNom()) ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-md-6" style="display: none">
                                <label>Date</label>
                                <input readonly type="date" name="date" class="form-control"
                                       value="<?= date("Y-m-d") ?>">
                            </div>
                            <div class="form-group col-md-6" style="display: none">
                                <label>Heure</label>
                                <input type="time" name="heure" class="form-control"
                                       value="<?= date("H:i:s") ?>">
                            </div>

                            <div class="form-group col-6">
                                <label>Déduction</label>
                                <div class="row">
                                    <div class="col-6">
                                        <label>%</label>
                                        <input step="any" type="number" min="0" max="100" value="0" required class="form-control deduction_normal" name="deduction_normal">
                                    </div>
                                    <div class="col-6">
                                        <label>Fixe</label>
                                        <input step="any" type="number" min="0" value="0" required class="form-control deduction_normal_fixe" name="deduction_normal_fixe">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-6">
                                <label>Déduction Assurance</label>
                                <div class="row">
                                    <div class="col-6">
                                        <label>%</label>
                                        <input step="any" type="number" min="0" max="100" value="0" required class="form-control deduction_assurance" name="deduction_assurance">
                                    </div>
                                    <div class="col-6">
                                        <label>Fixe</label>
                                        <input step="any" type="number" min="0" max="100" value="0" required class="form-control deduction_assurance_fixe" name="deduction_assurance_fixe">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Methode paiement</label>
                                <select class="form-control mpaiement" name="methode_paiement">
                                    <option value="cash">Cash</option>
                                    <option value="debit">Carte debit</option>
                                    <option value="credit">Carte credit</option>
                                    <option value="cheque">Cheque</option>
                                    <option value="virement">Virement</option>
                                </select>
                            </div>

                            <div class="form-group col-md-6 div_cheque" style="display: none">
                                <label>Banque</label>
                                <input type="text" class="form-control ccheque" name="banque">
                            </div>

                            <div class="form-group col-md-6 div_cheque" style="display: none">
                                <label>No Banque</label>
                                <input type="text" class="form-control ccheque" name="no_cheque">
                            </div>

                            <div class="form-group col-md-6 div_virement" style="display: none">
                                <label>Infos virement</label>
                                <textarea class="form-control" name="infos_virement"></textarea>
                            </div>

                            <div class="form-group col-md-6" style="display: none">
                                <label>Montant Facture</label>
                                <input type="number" name="montant_facture" class="form-control"
                                       value="<?= $total ?>"
                                       min="<?= $total ?>"
                                       required
                                       step="any" readonly>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Montant donnée par client</label>
                                <input type="number" name="montant_donner" class="form-control montant_donner"
                                       value="<?= $total ?>"
                                       required
                                       step="any">
                            </div>
                        </div>

                        <div class="form-group">
                            <input type="hidden" class="sous_total" name="total_facture" value="<?= $total ?>">
                            <input type="hidden" name="vente_externe_imagerie"/>
                            <input type="submit" value="Validé" class="btn btn-primary btn-block">
                        </div>
                    </form>
                </div>
            </div>
            <?php
        }

        elseif (isset($_GET['a-credit'])) {
            ?>
            <div class="card">
                <div class="card-header"></div>
                <div class="card-body">
                    <form method="post" class="form_versement_imagerie">
                        <input type="hidden" name="id_demmande" value="<?= $id_demmande; ?>">
                        <h4>Paiement A crédit</h4>
                        <div class="form-group col-12">
                            <label>Assurance</label>
                            <select class="form-control" name="assurance">
                                <option value="n/a">n/a</option>
                                <?php
                                $listeAssurance=\app\DefaultApp\Models\AssurancePatient::lister($patient->id);
                                foreach ($listeAssurance as $as){
                                    $assurance=new \app\DefaultApp\Models\Assurance();
                                    $assurance=$assurance->findById($as->id_assurance);
                                    ?>
                                    <option value="<?= $assurance->getId()?>"><?= strtoupper($assurance->getNom()) ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <table class="">
                            <tr>
                                <th>Total Facture :</th>
                                <td>
                                    <?= \app\DefaultApp\DefaultApp::formatComptable($total) ?>
                                    <?php $t = str_replace(",", "", $total) ?>
                                </td>
                            </tr>

                            <tr>
                                <th>Dette Anterieur :</th>
                                <td><?= \app\DefaultApp\DefaultApp::formatComptable($comptePatient->getDette()) ?></td>
                            </tr>

                            <tr>
                                <th>Nouvelle Dette :</th>
                                <td><?= \app\DefaultApp\DefaultApp::formatComptable($comptePatient->getDette() + $t) ?></td>
                            </tr>
                        </table>
                        <input type="hidden" name="id_compte" value="<?= $id_compte ?>">
                        <input type="hidden" name="id_patient" value="<?= $patient->id ?>">
                        <input type="hidden" name="total_facture" value="<?= $t ?>">
                        <input type="hidden" name="dette_anterieur" value="<?= $comptePatient->getDette() ?>">
                        <input type="hidden" name="nouvelle_dette"
                               value="<?= floatval($comptePatient->getDette() + $t) ?>">
                        <input type="hidden" name="a-credit-imagerie">
                        <input type="submit" value="Valider paiement" class="btn btn-block btn-success">
                    </form>
                </div>
            </div>
            <?php
        } else {
            goto ab;
        }
            ?>
            <div class="impression" style="width: 115mm;display: none">
                <page>
                    <div style="width: auto;font-size:12px">
                        <div style="text-align:center">
                            <strong>CHSM GROUP S.A</strong><br>
                            # 43,45 Ave John Brown (Lalue)<br>
                            Port-au-Prince, Haiti<br>
                        </div>
                        <br>
                        <strong>Client : <?= ucfirst($patient->getNom() . " " . $patient->getPrenom()) ?></strong><br>
                        <strong>Date : <?= date("Y-m-d") ?></strong><br>
                        <strong>No reçu : <span class="no_recu"></span></strong><br>

                        <strong>Order ID : <span class="order_id"></span></strong><br>

                        <strong>Agent : <?= \app\DefaultApp\Models\Utilisateur::pseudo() ?></strong>
                        <br>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-bordered" id="t" style="
        border-collapse: collapse;
        width: 100%;
        font-size: 12px;">
                                <thead>
                                <tr>
                                    <th style="font-family: sans-serif;
        text-align: left;
        background-color: #ffffff;">Produit
                                    </th>
                                    <th style="font-family: sans-serif;

        text-align: left;
        background-color: #ffffff;">Qte
                                    </th>
                                    <th style="font-family: sans-serif;

        text-align: left;
        background-color: #ffffff;">Prix
                                    </th>
                                    <th style="font-family: sans-serif;

        text-align: left;
        background-color: #ffffff;">Total
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <?= $ligne; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-3"></div>
                        <div class="col-9">
                            <div class="table-responsive">
                                <br>
                                <table class="table table-bordered" style="
        border-collapse: collapse;
        width: 100%;
        font-size: 12px;">
                                    <tr>
                                        <th style="font-family: sans-serif;
        text-align: left;
        background-color: #ffffff;" colspan="3">Sous total:
                                        </th>
                                        <td style=" font-family: sans-serif;
        text-align: left;
        background-color: #ffffff;">
                                            <span id="sous_total"><?= \app\DefaultApp\DefaultApp::formatComptable($sousTotal) ?></span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th style=" font-family: sans-serif;
        text-align: left;
        background-color: #ffffff;" colspan="3">Deduction
                                        </th>
                                        <td style=" font-family: sans-serif;
        text-align: left;
        background-color: #ffffff;">
                                            <span class="deduction"><?= \app\DefaultApp\DefaultApp::formatComptable($deduction) ?></span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th style=" font-family: sans-serif;
        text-align: left;
        background-color: #ffffff;" colspan="3">Total:
                                        </th>
                                        <td style=" font-family: sans-serif;
        text-align: left;
        background-color: #ffffff;"><span class="total"><?= \app\DefaultApp\DefaultApp::formatComptable($total) ?></span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th style=" font-family: sans-serif;
        text-align: left;
        background-color: #ffffff;" colspan="3">Versement :
                                        </th>
                                        <td style=" font-family: sans-serif;

        text-align: left;
        background-color: #ffffff;">
                                            <span class="versement"></span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th style=" font-family: sans-serif;

        text-align: left;
        background-color: #ffffff;" colspan="3">Balance :
                                        </th>
                                        <td style=" font-family: sans-serif;

        text-align: left;
        background-color: #ffffff;">
                                            <span class="balance">

                                            </span>
                                        </td>
                                    </tr>


                                    <tr>
                                        <th style=" font-family: sans-serif;

        text-align: left;
        background-color: #ffffff;" colspan="3">Monnaie :
                                        </th>
                                        <td style=" font-family: sans-serif;

        text-align: left;
        background-color: #ffffff;">
                                            <span class="monnaie"></span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <p style="font-size: 12px">Dette :
                            HTG <span class="dette"></span>
                            <br><br>
                            <span class="text-dette" style="display: none">
                            Signature : ..........................................................................<br>
                            I agree to pay above amount according to card issuer agreement (merchant agreement if credit
                            voucher).
                            </span>
                            <br>
                            <br>
                        <center><span style="margin=auto;text-align: center;font-size: 12px">Au service du patient avant tout...</span>
                        </center>
                        <br><br><br><br><br>
                        </p>
                    </div>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                </page>
            </div>
        <?php
        }
        } else {
        ?>
            <div class="form-group col-md-12">
                <label>Nom Imagerie</label>
                <input type="text" name="nom_imagerie" class="form-control auto_imagerie">
                <br>
                <button class="btn btn-outline-success btn-block add-imagerie">Ajouter</button>
            </div>

            <form action="" method="post" id="forme_demande_imagerie">
                <?php
                if (isset($admision)) {
                    ?>
                    <input type="hidden" name="id_admision" value="<?= $admision->getId(); ?>">
                    <?php
                }
                if(isset($_GET['chl'])){
                    ?>
                    <input type="hidden" name="type" value="chl" class="type">
                    <input type="hidden" name="id_categorie" value="<?= $_GET['id_categorie'] ?>" class="id_categorie">
                    <?php
                }else{
                    ?>
                    <input type="hidden" name="type" value="" class="type">
                    <?php
                }
                ?>
                <input type="hidden" name="demmande_imagerie">
                <fieldset class="col-md-12">
                    <div class="form-group" style="display: none">
                        <label>Medecin </label>
                        <select name="medecin" class="form-control">
                            <?php
                            if (isset($medecin)) {
                                ?>
                                <option value="<?= $medecin->getId() ?>"><?= strtoupper($medecin->getNom() . " " . $medecin->getPrenom()); ?></option>
                                <?php
                            } else {
                                ?>
                                <option value="n/a">n/a</option>
                                <?php
                                if (isset($listeMedecin)) {
                                    foreach ($listeMedecin as $med) {
                                        ?>
                                        <option value="<?= $med->getId(); ?>"><?= $med->getNom() . " " . $med->getPrenom() ?></option>
                                        <?php
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="element">

                        </div>
                    </div>
                </fieldset>

                <div class="form-group">
                    <input type="hidden" id="code_patient" class="code_patient" name="id_patient" value="<?= $patient->getId(); ?>"/>
                    <input type="submit" class="btn btn-primary btn-block" value="Enregistrer"/>
                    <a href="" class="btn btn-danger btn-block">Annuler</a>
                </div>
            </form>
            <?php
        }
        ?>
    </div>
</div>
