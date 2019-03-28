<?php

require "../modelo/usuario_menu_modelo.php";

$check = $_POST['checklist'];
$perfil = $_POST['departamentos'];
$tipo = $_POST['tipo'];
$notif      = new reporte_usuario_menu;
$cant = $notif-> llenar_usuario_novedad($check,$perfil,$tipo);


echo json_encode($cant);
?>
