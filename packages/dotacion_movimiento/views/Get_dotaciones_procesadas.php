<?php

require "../model/dotacion_modelo.php";

$listado      = new dotaciones;
    $cantidad = $listado->llenar_dotaciones_procesadas();
echo json_encode($cantidad);
?>
