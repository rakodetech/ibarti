<?php

require "../model/dotacion_modelo.php";

$listado      = new dotaciones;
$obmitir       = isset($_POST['omitir']) ? $_POST['omitir'] : array();
$fecha_d = $_POST['fecha_d'];
$fecha_h = $_POST['fecha_h'];
$vista = $_POST['tipo'];

if($vista=="almacen"){
    $cantidad = $listado->get_listado_dotacion($obmitir, $fecha_d, $fecha_h);
}
if($vista=="operaciones"){  
    $cantidad = $listado->get_listado_recepcion($obmitir, $fecha_d, $fecha_h);
}


echo json_encode($cantidad);
?>
