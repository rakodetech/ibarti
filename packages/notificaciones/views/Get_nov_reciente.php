

<?php
session_start();
require "../modelo/notificaciones_modelo.php";

$perfil    = $_SESSION['cod_perfil'];
$usuario	=$_SESSION['usuario_cod'];
$notif      = new notificaciones;
$novedades = $notif-> get_nov_reciente($perfil,$usuario);

echo json_encode($novedades);
?>
