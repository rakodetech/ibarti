<?php

require "../modelo/novedades_modelo.php";

$notif      = new novedades_reporte;
$status = $notif->llenar_regiones();

echo json_encode($status);
