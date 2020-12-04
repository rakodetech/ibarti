<?php
require "../modelo/stock_ubic_alcance_modelo.php";
require "../../../../".Leng;

$cod_stock_ubic_alcance   = $_POST['codigo'];
$prod      = new stock_ubic_alcance;
$result = $prod->get_cantidad_mayor_a_stock_actual($cod_stock_ubic_alcance);
echo json_encode($result);
?>
