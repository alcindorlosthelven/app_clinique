<?php
$idF = $_GET['print'];
$f = new \app\DefaultApp\Models\Facture();
$fiche1 = $f->findById($idF);
if ($fiche1 !== null) {
    $paris = json_decode($fiche1->contenue);
    $id_vendeur = $fiche1->user;
    $vendeur = new \app\DefaultApp\Models\Utilisateur();
    $vendeur = $vendeur->findById($id_vendeur);
    $patient=new \app\DefaultApp\Models\Patient();
    $patient=$patient->findById($fiche1->id_patient);
    if($patient==null){
        return;
    }
    ?>
    <center>
        <div class="impression" style="width: 115mm;padding: 0px;font-weight: bold">
            <page>
                <div style="text-align: center">
                    <span style="font-weight: bold;font-size: 20px">Integra Santé RadioDiagnostic</span><br>
                    Phone : +509 47147474<br>
                    Integraradiodiagnostic@gmail.com
                    <br><br>
                </div>
                <span style="font-weight: bold">
                    #Facture : <?= $fiche1->id ?><br>
                    Vendeur : <?= ucfirst($vendeur->nom) . " " . ucfirst($vendeur->prenom) ?><br>
                    Patient : <?= ucfirst($patient->nom) . " " . ucfirst($patient->prenom) ?><br>
                    Date : <?= $fiche1->date . " a " . $fiche1->heure ?><br>
                  </span>
                <br>
                <table class="table table-bordered"
                       style="width: 100%;border: 0px solid black;border-collapse: collapse">
                    <tbody>
                    <tr>
                        <td style="font-weight: bold;font-size: 15px">Item</td>
                        <td style="font-weight: bold;font-size: 15px">Prix</td>
                    </tr>

                    <?php
                    foreach ($paris as $p) {
                        $id_item = $p->id_imagerie;
                        $img=new \app\DefaultApp\Models\Imagerie();
                        $img=$img->findById($id_item);
                        ?>
                        <tr>
                            <td><?= $img->nom ?></td>
                            <td><?= \app\DefaultApp\DefaultApp::formatComptable($p->prix) ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                    <tr>
                        <th>Sous total</th>
                        <th><?= \app\DefaultApp\DefaultApp::formatComptable($fiche1->montant) ?></th>
                    </tr>
                    <tr>
                        <th>Rabais</th>
                        <th><?= \app\DefaultApp\DefaultApp::formatComptable($fiche1->rabais) ?></th>
                    </tr>

                    <tr>
                        <th>Total</th>
                        <th><?= \app\DefaultApp\DefaultApp::formatComptable($fiche1->montant_apres_rabais) ?></th>
                    </tr>

                    <tr>
                        <th>Verseemnt</th>
                        <th><?= \app\DefaultApp\DefaultApp::formatComptable($fiche1->montant_apres_rabais+$fiche1->monnaie) ?></th>
                    </tr>

                    <tr>
                        <th>Monnaie</th>
                        <th><?= \app\DefaultApp\DefaultApp::formatComptable(+$fiche1->monnaie) ?></th>
                    </tr>
                    </tbody>
                </table>
                <div style="text-align: center">
                    <?= $fiche1->note ?><br>
                    lien images  <br>
                    https://app.integra-sante.com/image-imagerie
                </div>
            </page>
        </div>
    </center>
    <script>
        function imprimer(titre) {
            let zone=document.getElementsByClassName("impression")[0].innerHTML
            //console.log(zone)
            //let zone = $(".impression").html();
            let fen = window.open("", "", "height=800, width=1200,toolbar=0, menubar=0, scrollbars=1, resizable=1,status=0, location=0, left=0, top=0");
            fen.document.body.style.color = '#000000';
            fen.document.body.style.backgroundColor = '#FFFFFF';
            fen.document.body.style.padding = "0px";
            fen.document.body.style.fontWeight = 'bold';
            fen.document.body.style.fontSize = "15px";
            fen.document.body.style.margin = "0px";
            fen.document.title = titre;
            fen.document.body.innerHTML += " " + zone + " ";
            fen.window.print();
            fen.window.close();
            return true;
        }
        imprimer("Print facture")
    </script>
    <a class="no-print btn btn-primary" onclick="imprimer('')">Imprimer</a>
    <?php
}
?>


