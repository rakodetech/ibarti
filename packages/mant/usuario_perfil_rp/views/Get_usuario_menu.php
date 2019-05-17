<?php

require "../modelo/usuario_menu_modelo.php";
$perfil = $_POST['perfil'];
$modulo = $_POST['modulo'];
$seccion = $_POST['seccion'];
$modelo      = new reporte_usuario_menu;
$result = $modelo->generar($perfil,$modulo,$seccion);

echo json_encode($result);
?>
