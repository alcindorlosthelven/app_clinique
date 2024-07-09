<?php

use app\DefaultApp\Models\AccesUser;
use systeme\Application\Application as  App;
$cache="display:none";
$aficher="display:inline";
?>
<a  href="<?= App::genererUrl("ajouter_utilisateur"); ?>" class="btn btn-outline-primary">Ajouter</a>
<a  href="<?= App::genererUrl("lister_utilisateur"); ?>" class="btn btn-outline-success">Lister</a>

<br>
<br>
