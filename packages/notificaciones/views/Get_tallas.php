

<?php

require "../modelo/notificaciones_modelo.php";
$ficha = $_POST['cod_ficha'];
$notif      = new notificaciones;
$tallas = $notif->get_tallas($ficha);

echo json_encode($tallas);
?>
