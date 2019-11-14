<?php
require "../modelo/ajuste_modelo.php";
require "../../../../".Leng;

$cod_ajuste   = $_POST['codigo'];
$prod      = new Ajuste;
$result = $prod->get_cantidad_mayor_a_stock_actual($cod_ajuste);
echo json_encode($result);
?>
