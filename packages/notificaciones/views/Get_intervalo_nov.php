

<?php

require "../modelo/notificaciones_modelo.php";

$notif      = new notificaciones;
$cantidad = $notif->get_intervalo();

echo json_encode($cantidad);
?>
