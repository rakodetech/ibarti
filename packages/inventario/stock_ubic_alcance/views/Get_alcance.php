<?php
require "../modelo/stock_ubic_alcance_modelo.php";
require "../../../../".Leng;

$producto   = $_POST['codigo'];
$ubic   = $_POST['ubic'];
$prod      = new stock_ubic_alcance;
$result = $prod->get_alcance($producto, $ubic);
echo json_encode($result);
