<br>
<?php
$host = "http://" . $_SERVER['HTTP_HOST'] . "/sge/data"
?>
<div class="card">
    <div class="card-header">Backup et Restauration</div>

    <div class="card-body">
        <a href="?backup" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Backup</a>
        <a href="?restaurer" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Restaurer</a>

        <?php
        if (isset($_GET['backup'])) {
            ?>
            <h3>Backup</h3>
            <form method="post" class="forme_synchronisation">
                <div class="row">
                    <div class="form-group col-md-8">
                        <input readonly value="<?= $host ?>" type="url" name="urlHost" placeholder="URL HOST"
                               class="form-control" required>
                    </div>

                    <div class="col-md-4 form-group">
                        <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Backup</button>
                    </div>

                    <input type="hidden" name="backup">

                    <div class="col-md-12">
                        <div class="message"></div>
                    </div>
                </div>
            </form>
            <?php
        } elseif (isset($_GET['restaurer'])) {
            $chemin = $_SERVER['DOCUMENT_ROOT'] . "/sge/app/sge/public/backup/";
            $listeFichier = array_slice(scandir($chemin), 2);
            $listeFichier=array_reverse($listeFichier);
            ?>
            <h3>Restaurer</h3>
            <form method="post" class="forme_synchronisation">
                <div class="row">
                    <div class="form-group col-md-8">

                        <select class="form-control" style="height: 40px" required name="fichier">
                            <?php

                            foreach ($listeFichier as $fichier) {
                                $size=filesize($chemin."/".$fichier);
                                ?>
                                <option value="<?= $fichier ?>"><?= $fichier ." ==> ".$size ." bytes" ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-4 form-group">
                        <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Restaurer</button>
                    </div>

                    <input type="hidden" name="synchronisation">

                    <div class="col-md-12">
                        <div class="message"></div>
                    </div>
                </div>
            </form>
            <?php
        }
        ?>

    </div>
</div>