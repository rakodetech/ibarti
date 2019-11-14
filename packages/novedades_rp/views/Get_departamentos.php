<?php

require "../modelo/novedades_modelo.php";

$notif      = new novedades_reporte;
$status = $notif->llenar_departamentos();

echo json_encode($status);
?>
