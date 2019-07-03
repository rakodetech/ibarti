<?php

require "../model/dotacion_modelo.php";

$listado        = new dotaciones;
$cod            = $_POST['cod'];
$vista             = $_POST['vista'];
$existencia     = $listado->get_listado_existente($cod,$vista);

echo json_encode($existencia);
?>
