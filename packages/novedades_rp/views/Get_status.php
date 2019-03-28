
<?php

require "../modelo/novedades_modelo.php";
$mod = $_POST['vista'];
$notif      = new novedades_reporte;
$status = $notif->llenar_estatus_pendiente($mod);

echo json_encode($status);
?>
