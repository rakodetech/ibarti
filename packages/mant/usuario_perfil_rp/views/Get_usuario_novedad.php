<?php

require "../modelo/usuario_menu_modelo.php";

$check = $_POST['checklist'];
$perfil = $_POST['departamentos'];
$clasif = $_POST['clasif'];
$notif      = new reporte_usuario_menu;
$cant = $notif-> llenar_usuario_novedad($check,$perfil,$clasif);


echo json_encode($cant);
?>
