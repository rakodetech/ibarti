<?php


require "../modelo/novedades_modelo.php";
$departamentos = $_POST['departamentos'];
$fecha_desde = conversion($_POST['fecha_desde']);
$fecha_hasta = conversion($_POST['fecha_hasta']);
$estatus = $_POST['estatus'];
$notif      = new novedades_reporte;
$novedades = $notif->llenar_tabla_novedades_generales($fecha_desde,$fecha_hasta,$departamentos,$estatus);

echo json_encode($novedades);
?>
