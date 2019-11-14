<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase();

$codigo      = $_POST['codigo'];
$cliente     = $_POST['cliente'];
$ubicacion   = $_POST['ubicacion'];
$cargo       = $_POST['cargo'];
$turno       = $_POST['turno'];
$cantidad    = $_POST['cantidad'];

$href        = $_POST['href'];
$usuario     = $_POST['usuario']; 
$proced      = $_POST['proced'];
$metodo      = $_POST['metodo'];

$href        = $_POST['href'];

if(isset($_POST['proced'])){

   $sql    = "$SELECT $proced('$metodo', '$codigo', '$cliente', '$ubicacion',
                              '$cargo', '$turno', '$cantidad',
							  '$usuario')";						  
	 $query = $bd->consultar($sql);	 
	}
 require_once('../funciones/sc_direccionar.php');  	 
?>