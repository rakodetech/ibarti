<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase(); 
						
$fecha     = $_POST['codigo'];
 
$cliente    = $_POST['cliente'];
$ubicacion  = $_POST['ubicacion'];
$horario    = $_POST['horario'];
$nivel      = $_POST['nivel'];
$trabajador = $_POST['trabajador'];
   
$usuario    = $_POST['usuario']; 
$proced     = $_POST['proced'];
$metodo     = $_POST['metodo'];


if (isset($_POST['metodo'])) {
														   
	$sql    = "$SELECT $proced('$metodo', '$fecha', '$trabajador', '$horario',
	                           '$cliente', '$ubicacion', '$nivel' , '$usuario')";						  		
							   			  
	$query = $bd->consultar($sql);	  			   		
	$mensaje = "";		

	
	}
// require_once('../funciones/sc_direccionar.php');	 				
?>