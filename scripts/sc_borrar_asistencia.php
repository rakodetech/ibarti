<?php
require_once('../autentificacion/aut_config.inc.php'); 
include_once('../funciones/funciones.php');
include_once('../funciones/mensaje_error.php');
mysql_select_db($bd_cnn, $cnn);

$tabla    = 'asistencia';
$tabla_id = 'cedula';

$fecha          = Rconversion($_POST['fecha']);
$codigo     = $_POST['codigo'];

$status         = $_POST['status'];			  
$href           = $_POST['href'];
$i = $_POST['metodo'];

	$fecha_N = explode("-", $fecha);
	$year1   = $fecha_N[0]; 
	$mes1    = $fecha_N[1]; 
	$dia1    = $fecha_N[2];			

	$fecha_Borrar = mktime(0,0,0,$mes1,$dia1,$year1);
	$dia_rest = 40;	
   $fecha_Max = date("Y-m-d", strtotime("$date -$dia_rest day")); 

	$fecha_N = explode("-", $fecha_Max);
	$year1   = $fecha_N[0]; 
	$mes1    = $fecha_N[1]; 
	$dia1    = $fecha_N[2];			

	 $fecha_Max_Comp = mktime(0,0,0,$mes1,$dia1,$year1);
	 
	//  LIMITE DE FECHA EN APERTURA DE FECHA
	
		if( $fecha_Max_Comp >= $fecha_Borrar){
			mensajeria("La Fecha No Puede Ser Menor(".$fecha_Max.")");			
			$href ="../inicio.php?area=formularios/index";
			$i = "Null";
		}	

if (isset($_POST['metodo'])) {

	switch ($i) {

	case Eliminar: 

	     mysql_query("DELETE FROM $tabla 
		  			   WHERE asistencia.cod_emp = '$codigo' 
					     AND asistencia.fecha >= '$fecha'",$cnn)  or die
					('<br><h3>Error Consulta # 3:</h3> '.mysql_error().'<br>');      	

	break;	 	
	}        
}
	require_once('../funciones/sc_direccionar.php');  	 				
?>