<?php
require "../modelo/ajuste_modelo.php";
require "../../../../".Leng;

$producto   = $_POST['producto'];
$almacen    = $_POST['almacen'];
$prod      = new Ajuste;
$result = $prod->get_stock_actual($producto,$almacen);
echo json_encode($result);
?>
