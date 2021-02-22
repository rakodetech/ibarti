<?php

require "../modelo/novedades_modelo.php";
$region = null;
if (isset($_GET['region'])) $region = $_GET['region'];
$notif      = new novedades_reporte;
$estados = $notif->llenar_estados($region);

echo json_encode($estados);
