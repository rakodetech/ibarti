<?php


require "../modelo/novedades_modelo.php";
$departamentos = $_POST['departamentos'];
$region = $_POST['region'];
$estado = $_POST['estado'];
$ciudad = $_POST['ciudad'];
$estatus = $_POST['estatus'];
$notif      = new novedades_reporte;
$novedades = $notif->llenar_tabla_novedades_pendientes($departamentos, $estatus, $region, $estado, $ciudad);
echo json_encode($novedades);
