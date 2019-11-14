<?php

require "../modelo/resp_modelo.php";
$ensamblador      = new novedades_promedio;
$f_d = $_POST['f_d'];
$f_h = $_POST['f_h'];
$cantidad = $ensamblador-> obtener_dias_perfil($f_d,$f_h);

echo json_encode($cantidad);
?>
