<?php
require "../modelo/ficha_dotacion_modelo.php";
$linea   = $_POST['linea'];
$sub_linea   = $_POST['sub_linea'];
$modelo      = new FichaDotacion;
$valid = $modelo->validar_sub_linea($linea,$sub_linea);

echo json_encode($valid);
?>
