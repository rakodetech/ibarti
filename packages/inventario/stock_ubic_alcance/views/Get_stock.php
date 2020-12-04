<?php
require "../modelo/stock_ubic_alcance_modelo.php";
require "../../../../" . Leng;

$producto   = $_POST['producto'];
$almacen    = $_POST['almacen'];
$prod      = new stock_ubic_alcance;
$result = $prod->get_stock_actual($producto, $almacen);
echo json_encode($result);
