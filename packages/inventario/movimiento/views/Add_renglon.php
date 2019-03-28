<?php
require "../modelo/ajuste_modelo.php";
require "../../../../".Leng;
$modelo = new Movimiento;
$codigo = $_POST['codigo'];
$reng   = $modelo->get_aj_reng($codigo);
print_r(json_encode($reng));
return json_encode($reng);
?>

