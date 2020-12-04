<?php
require "../modelo/stock_ubic_alcance_modelo.php";
require "../../../../".Leng;

$item   = $_POST['codigo'];
$prod      = new stock_ubic_alcance;
$result = $prod->get_if_ean($item);
echo json_encode($result);
?>
