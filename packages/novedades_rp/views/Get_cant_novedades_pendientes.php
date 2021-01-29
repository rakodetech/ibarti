<?php

require "../modelo/novedades_modelo.php";
$perfil = $_POST['perfil'];
$usuario = $_POST['usuario'];
$estatus = $_POST['estatus'];
$region = $_POST['region'];
$notif      = new novedades_reporte;
$cant = $notif->obtener_cantidad_novedades_pendientes($perfil, $usuario, $estatus, $region);

echo json_encode($cant);
