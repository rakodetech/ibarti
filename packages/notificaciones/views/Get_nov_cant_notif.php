

<?php
session_start();
require "../modelo/notificaciones_modelo.php";

$perfil    = $_SESSION['cod_perfil'];
$usuario    = $_SESSION['usuario_cod'];
$notif      = new notificaciones;
$cantidad = 0; //$notif->get_cant_nov_notif($perfil,$usuario);

echo json_encode($cantidad);
?>
