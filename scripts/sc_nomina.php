<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase();

$codigo         = $_POST['codigo']; 
			  
$href     = $_POST['href'];
$usuario  = $_POST['usuario']; 
$proced   = $_POST['proced'];
$metodo   = $_POST['metodo'];

$href     = $_POST['href'];

 $sql    = "SELECT COUNT( asistencia_cierre.`status`) AS cerrada
		     FROM asistencia_apertura, asistencia_cierre
		    WHERE asistencia_apertura.cod_contracto = '$codigo'
		      AND asistencia_apertura.`status` = 'T'
		      AND asistencia_apertura.codigo = asistencia_cierre.cod_as_apertura
		      AND asistencia_apertura.cod_contracto = asistencia_cierre.cod_contracto
		      AND asistencia_cierre.`status` = 'T'";						  

 $query = $bd->consultar($sql);
 $row01 = $bd->obtener_fila($query,0);

if(isset($_POST['proced'])){
	 $valor = $row01[0];
	if ($valor == 0){	 
  	 $sql   = "$SELECT $proced('$metodo', '$codigo', '$usuario')";						  
	 $query = $bd->consultar($sql);	 

	 $mensaje = "SE CERRO CORRECTAMENTE LA NOMINA";	
	}else{
	$mensaje = "HAY ASISTENCIAS ABIERTAS PARA ESTA NOMINA";	
	}
}
     echo '<script language="javascript">
	      alert("'.$mensaje.'");
	       </script>';
	require_once('../funciones/sc_direccionar.php');  	
?>