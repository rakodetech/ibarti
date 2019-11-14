<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase();

$fecha_D    = $_POST['fecha_desde'];
$fecha_H    = $_POST['fecha_hasta'];

$codigo    = $_POST['codigo'];
$trabajador = $_POST['trabajador'];
$cliente    = $_POST['cliente'];
$ubicacion  = $_POST['ubicacion'];
$rotacion   = $_POST['rotacion'];
$rotacion_n = $_POST['rotacion_n'];
$excepcion  = $_POST['excepcion'];

$usuario    = $_POST['usuario'];
$proced     = $_POST['proced'];
$metodo     = $_POST['metodo'];


if (isset($_POST['metodo'])) {

$sql    = "$SELECT $proced('$metodo', '$codigo', '$fecha_D', '$fecha_H',
                         '$trabajador', '$cliente','$ubicacion',  '$excepcion',
												 '$rotacion', '$rotacion_n', '$usuario')";
	$query = $bd->consultar($sql);

	$row=$bd->obtener_fila($query,0);

	echo " Mensaje: $row[1]";

}
?>
