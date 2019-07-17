<?php

require "../model/dotacion_modelo.php";

$listado      = new dotaciones;
$f_d = $_POST['fecha_desde'];
$f_h = $_POST['fecha_hasta'];
    $cantidad = $listado->llenar_dotaciones_procesadas($f_d,$f_h);
echo json_encode($cantidad);
?>
