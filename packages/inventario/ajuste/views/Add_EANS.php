<?php
require "../modelo/ajuste_modelo.php";
$ajuste = new Ajuste;
$codigo = $_POST['codigo'];
$salida = $_POST['salida'];
$almacen = $_POST['almacen'];
$reng   = $ajuste->get_eans($codigo,$salida,$almacen);
print_r(json_encode($reng));
return json_encode($reng);
?>
