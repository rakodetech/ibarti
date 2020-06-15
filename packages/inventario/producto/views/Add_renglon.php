<?php
require "../modelo/ajuste_modelo.php";
require "../../../../".Leng;
$ajuste = new Ajuste;
$codigo = $_POST['codigo'];
$reng   = $ajuste->get_aj_reng($codigo);
print_r(json_encode($reng));
return json_encode($reng);
?>
