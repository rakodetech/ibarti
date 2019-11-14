<?php

require "../model/dotacion_modelo.php";

$listado      = new dotaciones;
    $cantidad = $listado->llenar_status_proceso('O');
echo json_encode($cantidad);
?>
