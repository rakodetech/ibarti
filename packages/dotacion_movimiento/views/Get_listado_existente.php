<?php

require "../model/dotacion_modelo.php";

$listado        = new dotaciones;
$cod            = $_POST['cod'];
$us             = $_POST['us'];
$existencia     = $listado->get_listado_existente($cod,$us);

echo json_encode($existencia);
?>
