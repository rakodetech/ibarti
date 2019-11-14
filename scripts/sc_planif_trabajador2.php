<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase(); 

$codigo     = $_POST['codigo'];
$fecha_D    = conversion($_POST['fecha_desde']);
$fecha_H    = conversion($_POST['fecha_hasta']);
$ubicacion  = $_POST['ubicacion'];
$turno      = $_POST['turno'];

$trabajador = $_POST['trabajador'];
   
$href       = $_POST['href'];
$usuario    = $_POST['usuario']; 
$proced     = $_POST['proced'];
$proced2    = $_POST['proced2'];
$metodo     = $_POST['metodo'];
$i = $_POST['metodo'];

//  PROBLEMAS CON LA FECHA EN APERTURA DE FECHA

if (isset($_POST['metodo'])) {

	$sql    = "$SELECT $proced('$metodo', '$codigo', '$fecha_D', '$fecha_H', '$turno',
	                           '$usuario')";						  		
							   			  
	$query = $bd->consultar($sql);	  			   		
	$mensaje = "";		

	$sql    = "SELECT pl_trabajador.codigo FROM pl_trabajador
                WHERE pl_trabajador.fecha BETWEEN \"$fecha_D\" AND \"$fecha_H\"
				  AND pl_trabajador.cod_turno = '$turno' ";		
		$where2   = "";		  	
			  			  	
	$query = $bd->consultar($sql);
      	while($datos=$bd->obtener_fila($query,0)){	
		$codigo   = $datos[0];	
		$where = "WHERE pl_trabajador_det.cod_pl_trabajador = '$codigo'
		            AND pl_trabajador_det.cod_ficha = '$trabajador' ";		
		
		$sql02    = "DELETE FROM pl_trabajador_det $where ";						  
		$query02 = $bd->consultar($sql02);	  		
		 }
		if($metodo <> "borrar"){
	$sql    = "$SELECT $proced2('$metodo', '$fecha_D', '$fecha_H', '$turno',
	                           '$trabajador', '$ubicacion', '$usuario')";						  
					$query = $bd->consultar($sql);			 
		}
	}
require_once('../funciones/sc_direccionar.php');	 				
?>