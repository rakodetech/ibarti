<?php
require "../modelo/g_novedades_modelo.php";
require "../../../../".Leng;
$gNov = new gNovedades;

$fec_desde = $_POST['fec_desde'];
$fec_hasta = $_POST['fec_hasta'];
echo json_encode($gNov -> get_agrupado($fec_desde,$fec_hasta));

?>