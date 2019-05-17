<?php
require "../modelo/producto_modelo.php";
$serial   = $_POST['codigo'];
$almacen   = $_POST['almacen'];
$modelo      = new Producto;
$costo_prom = $modelo->get_costo_prom($serial,$almacen);

print_r(json_encode($costo_prom));
return json_encode($costo_prom);
?>
