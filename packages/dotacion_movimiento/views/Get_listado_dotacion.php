<?php

require "../model/dotacion_modelo.php";

$listado      = new dotaciones;
$obmitir       = isset($_POST['omitir']) ? $_POST['omitir'] : array();
$fecha_d = $_POST['fecha_d'];
$fecha_h = $_POST['fecha_h'];
$cantidad = $listado->get_listado_dotacion($obmitir, $fecha_d, $fecha_h);

echo json_encode($cantidad);
?>
