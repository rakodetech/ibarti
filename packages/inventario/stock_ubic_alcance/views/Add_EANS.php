<?php
require "../modelo/stock_ubic_alcance_modelo.php";
$ajuste = new stock_ubic_alcance;
$codigo = $_POST['codigo'];
$salida = $_POST['salida'];
$almacen = $_POST['almacen'];
$reng   = $ajuste->get_eans($codigo, $almacen, $salida);
print_r(json_encode($reng));
return json_encode($reng);
