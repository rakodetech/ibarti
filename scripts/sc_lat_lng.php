<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../" . class_bd);
$bd = new DataBase();

try {
	$lat         = $_POST['lat'];
	$lng      = $_POST['lng'];
	$address      = $_POST['address'];

	if (isset($_POST['tabla'])) {
		$tabla = $_POST['tabla'];
		$codigo = $_POST['codigo'];
		$sql    = "UPDATE $tabla SET latitud=$lat, longitud =$lng, direccion_google='$address' WHERE codigo = '$codigo'";
	} else {
		$ficha      = $_POST['ficha'];
		$sql    = "UPDATE ficha SET campo03=$lat, campo04 =$lng, direccion_google='$address' WHERE cod_ficha = '$ficha'";
	}

	$query = $bd->consultar($sql);
	echo $sql;
} catch (Exception $e) {
	echo ($e->getMessage());
}
