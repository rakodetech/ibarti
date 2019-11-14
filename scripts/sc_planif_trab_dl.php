<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase(); 

$tabla    = 'asistencia';

$fecha_D   = conversion($_POST['fecha_desde']);
$fecha_H   = conversion($_POST['fecha_hasta']);

$rol        = $_POST['rol'];
$region     = $_POST['region'];
$estado     = $_POST['estado'];
$contrato   = $_POST['contrato'];
$cargo      = $_POST['cargo'];
$cliente    = $_POST['cliente'];
$ubicacion  = $_POST['ubicacion'];
$trabajador = $_POST['trabajador'];
$ficha      = $_POST['ficha'];

$href       = $_POST['href'];
$usuario    = $_POST['usuario']; 
$proced     = $_POST['proced'];

$metodo     = $_POST['metodo'];

$i = $_POST['metodo'];
//  PROBLEMAS CON LA FECHA EN APERTURA DE FECHA

if (isset($_POST['metodo'])) {

	$where = "WHERE pl_trab_dl.fecha BETWEEN \"$fecha_D\" AND \"$fecha_H\"";		
	
		if($rol    != "TODOS"){		
			$where .= " AND pl_trab_dl.cod_rol = '$rol' ";
		}		

		if($region != "TODOS"){		
			$where .= " AND pl_trab_dl.cod_region = '$region' ";
		}		
		if($estado != "TODOS"){		
			$where .= " AND pl_trab_dl.cod_estado = '$estado' "; 
		}	
		
		if($contrato != "TODOS"){		
			$where .= " AND pl_trab_dl.cod_contrato = '$contrato' ";
		}		
		
		if($cargo != "TODOS"){		
			$where .= " AND pl_trab_dl.cod_cargo = '$cargo' ";
		}		

		if($cliente != "TODOS"){		
			$where .= " AND pl_trab_dl.cod_cliente = '$cliente' ";
		}		

		if($ubicacion != "TODOS"){		
			$where .= " AND pl_trab_dl.cod_ubicacion = '$ubicacion' ";
		}		

		if($trabajador != "TODOS"){		
			$where .= " AND pl_trab_dl.cod_ficha = '$trabajador' ";
		}		
			
	$sql    = "DELETE FROM pl_trab_dl $where ";						  
	$query  = $bd->consultar($sql);	  	
	
		
	 foreach($ficha as $valorX){
		 $ficha    = $valorX;

		 $cliente_x = $_POST['cliente_'.$valorX.''];
		 $ubicacion_x = $_POST['ubicacion_'.$valorX.''];
	
		$sql    = "$SELECT $proced('$metodo', '$fecha_D', '$fecha_H', '$ficha', 
	                           '$cliente_x', '$ubicacion_x', '$usuario')";						  
		$query  = $bd->consultar($sql);			 
	 }	
}
 require_once('../funciones/sc_direccionar.php');	 				
?>