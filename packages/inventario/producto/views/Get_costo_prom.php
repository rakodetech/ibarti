<?php
require "../modelo/producto_modelo.php";
$serial   = $_POST['codigo'];
$modelo      = new Producto;
$costo_prom = $modelo->get_costo_prom($serial);

print_r(json_encode($costo_prom));
return json_encode($costo_prom);
?>
