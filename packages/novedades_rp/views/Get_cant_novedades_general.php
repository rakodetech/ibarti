<?php

require "../modelo/novedades_modelo.php";
$perfil = $_POST['perfil'];
$fecha_desde = conversion($_POST['fecha_desde']);
$fecha_hasta = conversion($_POST['fecha_hasta']);
$usuario = $_POST['usuario'];
$estatus = $_POST['estatus'];
$notif      = new novedades_reporte;
$cant = $notif-> obtener_cantidad_novedades_general($fecha_desde,$fecha_hasta,$perfil,$usuario,$estatus);

echo json_encode($cant);
?>
