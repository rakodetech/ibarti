<?php
require "../modelo/g_novedades_modelo.php";
require "../../../../".Leng;
$gNov = new gNovedades;

$fec_desde = $_POST['fec_desde'];
$fec_hasta = $_POST['fec_hasta'];
$status = $_POST['status']; 
echo json_encode($gNov -> getNovStatusDet($fec_desde,$fec_hasta,$status));

?>