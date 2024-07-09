<?php
use app\DefaultApp\Models\AccesUser;
?>
<style>
    .tree {
        min-height: 20px;
        padding: 19px;
        margin-bottom: 20px;
        background-color: #fbfbfb;
        border: 1px solid #999;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
        -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
        -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05)
    }

    .tree li {
        list-style-type: none;
        margin: 0;
        padding: 10px 5px 0 5px;
        position: relative
    }

    .tree li::before, .tree li::after {
        content: '';
        left: -20px;
        position: absolute;
        right: auto
    }

    .tree li::before {
        border-left: 1px solid #999;
        bottom: 50px;
        height: 100%;
        top: 0;
        width: 1px
    }

    .tree li::after {
        border-top: 1px solid #999;
        height: 20px;
        top: 25px;
        width: 25px
    }

    .tree li span:not(.glyphicon) {
        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;
        border-radius: 5px;
        display: inline-block;
        padding: 4px 9px;
        text-decoration: none
    }

    .tree li.parent_li > span:not(.glyphicon) {
        cursor: pointer
    }

    .tree > ul > li::before, .tree > ul > li::after {
        border: 0
    }

    .tree li:last-child::before {
        height: 30px
    }

    .tree li.parent_li > span:not(.glyphicon):hover, .tree li.parent_li > span:not(.glyphicon):hover + ul li span:not(.glyphicon) {
        background: #eee;
        border: 1px solid #999;
        padding: 3px 8px;
        color: #000
    }
</style>
<div class="row">
    <div class="col-md-12">
        <?php
        \systeme\Application\Application::block("menu_utilisateur");
        if (!isset($utilisateur)) {
            return;
        }
        $u=new \app\DefaultApp\Models\Utilisateur();
        $acces = new \app\DefaultApp\Models\Acces();
        $listeAcces = $acces->findAll();
        $id_user = $utilisateur->getId();
        $user=$u->findById($id_user);
        ?>
        <div class="card">
            <div class="card-header">
                <h4>Acces : <?= ucfirst($user->getNom()." ".$user->getPrenom()) ?></h4>
            </div>

            <div id="test" class="card-body">
                <div class="message"></div>
                <form method="post" class="form-acces">
                    <input type="hidden" name="acces">
                    <input type="hidden" name="id_user" value="<?= $utilisateur->getId(); ?>">
                    <div class="tree">
                        <fieldset>
                            <legend>Fonctionalité</legend>
                        <ul class="firstUl">
                            <?php
                            $ls = array(0,1, 2, 3, 4,5,6,7,8,9);
                            $lenfant = array();
                            $is=0;
                            $fin=20;
                            foreach ($listeAcces as $a) {
                                if (in_array($a->getAcces(), $ls)) {
                                    $ac = $a->getAcces();
                                    $lacs = array();
                                    for ($i = 1; $i < $fin; $i++) {
                                        $lacs[] = "$ac." . $i;
                                    }
                                    ?>
                                    <li class="liFirstUl">
                                        <input class="" name="id_acces[]" type="checkbox"
                                               value="<?= $a->getAcces() ?>" <?php if (AccesUser::haveAcces($a->getAcces(), $id_user)) {
                                            echo "checked";
                                        } ?>
                                        >
                                        <span title="Verkleinern"> <strong><?= $a->getAcces() ?> - <?= strtoupper($a->getTitre()) ?></strong></span>

                                        <ul class="ulListeAcces">
                                            <?php
                                            foreach ($listeAcces as $aa) {
                                                if (in_array($aa->getAcces(), $lacs)) {
                                                    $ac1 = $aa->getAcces();
                                                    $lacs1 = array();
                                                    for ($i = 1; $i < $fin; $i++) {
                                                        $lacs1[] = "$ac1." . $i;
                                                    }
                                                    ?>
                                                    <li class="parent_li "><input name="id_acces[]" type="checkbox"
                                                                                 value="<?= $aa->getAcces() ?>" <?php if (AccesUser::haveAcces($aa->getAcces(), $id_user)) {
                                                            echo "checked";
                                                        } ?>> <?= $aa->getAcces() ?> - <?= ucfirst($aa->getTitre()) ?>
                                                        <ul>
                                                            <?php
                                                            foreach ($listeAcces as $aaa) {
                                                                if (in_array($aaa->getAcces(), $lacs1)) {
                                                                    $ac2 = $aaa->getAcces();
                                                                    $lacs2 = array();
                                                                    for ($i = 1; $i < $fin; $i++) {
                                                                        $lacs2[] = "$ac2." . $i;
                                                                    }
                                                                    ?>
                                                                    <li class="parent_li"><input name="id_acces[]"
                                                                                                 value="<?= $aaa->getAcces() ?>"
                                                                                                 type="checkbox" <?php if (AccesUser::haveAcces($aaa->getAcces(), $id_user)) {
                                                                            echo "checked";
                                                                        } ?>> <?= $aaa->getAcces() ?>
                                                                        - <?= ucfirst($aaa->getTitre()) ?>
                                                                        <ul>
                                                                            <?php
                                                                            foreach ($listeAcces as $aaaa) {
                                                                                if (in_array($aaaa->getAcces(), $lacs2)) {
                                                                                    $ac3 = $aaaa->getAcces();
                                                                                    $lacs3 = array();
                                                                                    for ($i = 1; $i < $fin; $i++) {
                                                                                        $lacs3[] = "$ac3." . $i;
                                                                                    }

                                                                                    ?>
                                                                                    <li class="parent_li">
                                                                                        <input <?php if (AccesUser::haveAcces($aaaa->getAcces(), $id_user)) {
                                                                                            echo "checked";
                                                                                        } ?> name="id_acces[]"
                                                                                             value="<?= $aaaa->getAcces() ?>"
                                                                                             type="checkbox"> <?= $aaaa->getAcces() ?>
                                                                                        - <?= ucfirst($aaaa->getTitre()) ?>
                                                                                        <ul>
                                                                                            <?php
                                                                                            foreach ($listeAcces as $aaaaa) {
                                                                                                if (in_array($aaaaa->getAcces(), $lacs3)) {
                                                                                                    ?>
                                                                                                    <li class="">
                                                                                                        <input <?php if (AccesUser::haveAcces($aaaaa->getAcces(), $id_user)) {
                                                                                                            echo "checked";
                                                                                                        } ?> name="id_acces[]"
                                                                                                             value="<?= $aaaaa->getAcces() ?>"
                                                                                                             type="checkbox"> <?= $aaaaa->getAcces() ?>
                                                                                                        - <?= ucfirst($aaaaa->getTitre()) ?>
                                                                                                    </li>
                                                                                                    <?php
                                                                                                }
                                                                                            }
                                                                                            ?>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <?php
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </ul>
                                                                    </li>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </ul>
                                                    </li>
                                                    <?php
                                                }

                                            }
                                            ?>
                                        </ul>
                                    </li>

                                    <?php
                                }

                                $is++;
                            }
                            ?>
                        </ul>
                        </fieldset>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Valider" class="btn btn-success btn-lg float-right">
                    </div>
                </form>
                <div class="message"></div>
            </div>
        </div>
    </div>
</div>
