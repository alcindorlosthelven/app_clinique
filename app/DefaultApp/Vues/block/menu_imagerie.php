<?php
use systeme\Application\Application as  App;
use app\DefaultApp\Models\AccesUser;
$cache = "display:none";
$aficher = "display:inline";
?>
<a style="margin-right: 3px;<?php if(AccesUser::haveAcces("2.6.3.1")){echo $aficher;}else{echo $cache;}?>" href="liste-demande-imagerie?admin" class="btn btn-primary">ADMIN</a>
<a style="margin-right: 3px;<?php if(AccesUser::haveAcces("2.6.3.5")){echo $aficher;}else{echo $cache;}?>" href="liste-demande-imagerie?examens" class="btn btn-success">EXAMENS</a>
<hr>
