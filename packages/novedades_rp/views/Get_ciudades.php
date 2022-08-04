<?php

require "../modelo/novedades_modelo.php";
$estado = null;
if (isset($_GET['estado'])) $estado = $_GET['estado'];
$notif      = new novedades_reporte;
$ciudades = $notif->llenar_ciudades($estado);
echo json_encode($ciudades);
