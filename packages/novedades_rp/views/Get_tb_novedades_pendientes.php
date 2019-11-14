<?php


require "../modelo/novedades_modelo.php";
$departamentos = $_POST['departamentos'];
$estatus = $_POST['estatus'];
$notif      = new novedades_reporte;
$novedades = $notif->llenar_tabla_novedades_pendientes($departamentos,$estatus);

echo json_encode($novedades);
?>
