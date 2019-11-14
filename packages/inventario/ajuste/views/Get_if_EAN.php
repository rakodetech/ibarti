<?php
require "../modelo/ajuste_modelo.php";
require "../../../../".Leng;

$item   = $_POST['codigo'];
$prod      = new Ajuste;
$result = $prod->get_if_ean($item);
echo json_encode($result);
?>
