<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase(); 

$codigo      = $_POST['codigo'];
$rol        = $_POST['rol'];
$region     = $_POST['region'];
$estado     = $_POST['estado'];
$contrato   = $_POST['contrato'];
$cargo      = $_POST['cargo'];
$cliente    = $_POST['cliente'];
$ubicacion  = $_POST['ubicacion'];
$trabajador = $_POST['trabajador'];
   
$href       = $_POST['href'];
$usuario    = $_POST['usuario']; 
$proced     = $_POST['proced'];
$metodo     = $_POST['metodo'];

$i = $_POST['metodo'];

if (isset($_POST['metodo'])) {

	$where = "WHERE v_ficha.cod_ficha = v_ficha.cod_ficha ";		
	
		if($rol    != "TODOS"){		
			$where .= " AND v_ficha.cod_rol = '$rol' ";
		}		

		if($region != "TODOS"){		
			$where .= " AND v_ficha.cod_region = '$region' ";
		}		
		if($estado != "TODOS"){		
			$where .= " AND v_ficha.cod_estado = '$estado' "; 
		}	
		
		if($contrato != "TODOS"){		
			$where .= " AND v_ficha.cod_contracto = '$contrato' ";
		}		
		
		if($cargo != "TODOS"){		
			$where .= " AND v_ficha.cod_cargo = '$cargo' ";
		}		

	if($cliente != "TODOS"){
		$where  .= " AND v_ficha.cod_cliente = '$cliente' ";
	}	

	if($ubicacion != "TODOS"){
		   $where .= " AND v_ficha.cod_ubicacion = '$ubicacion' ";
	}	

	$sql01    = "SELECT v_ficha.cod_ficha FROM v_ficha $where ";						  
	$query01 = $bd->consultar($sql01);		

	while($row01=$bd->obtener_fila($query01,0)){							   							
		$codigo = $row01[0];
		$sql    = " DELETE FROM ficha_dl WHERE ficha_dl.cod_ficha = '$codigo' ";						  
		$query = $bd->consultar($sql);	  				
	  }	
	  
	 foreach($trabajador as $valorX){
		 $campos = explode("-", $valorX);
		 $dia     = $campos[0]; 
         $ficha   = $campos[1]; 		 
		 
		 $cliente_x   = $_POST['cliente_'.$ficha.''];
	 $ubicacion_x = $_POST['ubicacion_'.$ficha.''];		 
		 
   	    $sql    = "$SELECT $proced('$metodo', '$ficha', '$dia', '$cliente_x',
	                               '$ubicacion_x', '$usuario')";						  
		$query = $bd->consultar($sql);			 
	}	
}
require_once('../funciones/sc_direccionar.php');	 				
?>