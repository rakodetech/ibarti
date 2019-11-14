<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase(); 

$tabla    = 'asistencia';

$codigo      = $_POST['codigo'];
$trabajador = $_POST['trabajador'];
   
$href       = $_POST['href'];
$usuario    = $_POST['usuario']; 
$proced     = $_POST['proced'];
$metodo     = $_POST['metodo'];

$i = $_POST['metodo'];
//  PROBLEMAS CON LA FECHA EN APERTURA DE FECHA

if (isset($_POST['metodo'])) {

	 foreach($trabajador as $valorX){
		 
		 $cliente_x   = $_POST['cliente_'.$valorX.''];
		 $ubicacion_x = $_POST['ubicacion_'.$valorX.''];	
		 $rotacion_x     = $_POST['rotacion_'.$valorX.''];
 		 $posicion_x     = $_POST['posicion_'.$valorX.''];		 
		 
		$sql    = "$SELECT $proced('$metodo', '$valorX', '$cliente_x', '$ubicacion_x',
		                           '$rotacion_x', '$posicion_x', '$usuario')";						  
		$query = $bd->consultar($sql);			 
	}	
}
require_once('../funciones/sc_direccionar.php');	 				
?>