<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase(); 

$codigo      = $_POST['codigo'];
$fecha_D     = conversion($_POST['fec_inicio']);
$fecha_H     = conversion($_POST['fec_fin']);

$cliente     = $_POST['cliente'];
$ubicacion   = $_POST['ubicacion'];
$trabajador  = $_POST['trabajador'];
$horario     = $_POST['horario'];
$observacion = $_POST['observacion'];
   
$href       = $_POST['href'];
$usuario    = $_POST['usuario']; 
$proced     = $_POST['proced'];
$metodo     = $_POST['metodo'];

//  PROBLEMAS CON LA FECHA EN APERTURA DE FECHA
if (isset($_POST['metodo'])) {   
	$sql    = "$SELECT $proced('$metodo', '$codigo', '$fecha_D', '$fecha_H', 
	                           '$cliente', '$ubicacion', '$trabajador', '$horario', 
							   '$observacion', '$usuario')";						  
	$query = $bd->consultar($sql);	  			   		
	$mensaje = "";	
}
require_once('../funciones/sc_direccionar.php');	 				
?>