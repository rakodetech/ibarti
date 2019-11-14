<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase();

//$fecha_D    = conversion($_POST['fecha_desde']);
//$fecha_H    = conversion($_POST['fecha_hasta']);

$fecha_D    = $_POST['fecha_desde'];
$fecha_H    = $_POST['fecha_hasta'];

$codigo    = $_POST['codigo'];
$cliente    = $_POST['cliente'];
$ubicacion  = $_POST['ubicacion'];
$cargo      = $_POST['cargo'];
$turno      = $_POST['turno'];
$cantidad   = $_POST['cantidad'];
$excepcion  = $_POST['excepcion'];

$usuario    = $_POST['usuario'];
$proced     = $_POST['proced'];
$metodo     = $_POST['metodo'];


if (isset($_POST['metodo'])) {

 	$sql    = "$SELECT $proced('$metodo', '$codigo', '$fecha_D', '$fecha_H',
	                           '$excepcion', '$cliente','$ubicacion', '$cargo',
														 '$turno', '$cantidad', '$usuario')";
	$query = $bd->consultar($sql);

	$row=$bd->obtener_fila($query,0);

	echo " Mensaje: $row[1]";

}




?>
