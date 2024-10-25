<?php
use systeme\Application\Application as  App;
use app\DefaultApp\Models\AccesUser;
$cache = "display:none";
$aficher = "display:inline";
?>
<a style="margin-right: 3px;<?php if(AccesUser::haveAcces("2.6.3.1")){echo $aficher;}else{echo $cache;}?>" href="liste-demande-imagerie?admin" class="btn btn-primary">ADMIN</a>
<a style="margin-right: 3px;<?php if(AccesUser::haveAcces("2.6.3.5")){echo $aficher;}else{echo $cache;}?>" href="liste-demande-imagerie?examens" class="btn btn-success">EXAMENS</a>
<hr>
<!--<a style="margin-right: 3px;<?php /*if(AccesUser::haveAcces("2.6.3.1")){echo $aficher;}else{echo $cache;} */?>" href="<?/*= App::genererUrl("ajouter_imagerie"); */?>" class="btn btn-primary">Ajouter</a>
<a style="margin-right: 3px;<?php /*if(AccesUser::haveAcces("2.6.3.2")){echo $aficher;}else{echo $cache;} */?>" href="<?/*= App::genererUrl("lister_imagerie"); */?>" class="btn btn-primary">Lister</a>
<a style="margin-right: 3px;<?php /*if(AccesUser::haveAcces("2.6.3.3")){echo $aficher;}else{echo $cache;} */?>" href="<?/*= App::genererUrl("ajouter_categorie_examens_imagerie"); */?>" class="btn btn-primary">Ajouter Catégorie Examens Imagerie</a>
<a style="margin-right: 3px;<?php /*if(AccesUser::haveAcces("2.6.3.4")){echo $aficher;}else{echo $cache;} */?>" href="<?/*= App::genererUrl("lister_categorie_examens_imagerie"); */?>" class="btn btn-primary">Lister Catégorie Examens Imagerie</a>
<a style="margin-right: 3px;<?php /*if(AccesUser::haveAcces("2.6.3.5")){echo $aficher;}else{echo $cache;} */?>" href="<?/*= App::genererUrl("liste_demande_imagerie"); */?>" class="btn btn-primary">Liste des demmandes</a>
<br>
<br>-->
