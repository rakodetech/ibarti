<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase(); 

$tabla          = 'asistencia';

$codigo         = $_POST['codigo'];
$observacion    = $_POST['observacion']; 
$nov_status     = $_POST['nov_status']; 
$fecha          = $_POST['fecha']; 
$hora           = $_POST['hora']; 

		  
$href     = $_POST['href'];
$usuario  = $_POST['usuario']; 
$proced   = $_POST['proced'];
$metodo   = $_POST['metodo'];

$i = $_POST['metodo'];

//  PROBLEMAS CON LA FECHA EN APERTURA DE FECHA

if (isset($_POST['metodo'])) {
	switch ($i) {
    case 'agregar':
	case 'modificar':
	case 'borrar':   
	//	 begin();	

	$sql    = "$SELECT $proced('$metodo', '$codigo', '$nov_status',  '$observacion',
                               '$fecha', '$hora', '$usuario')";						  
	 $query = $bd->consultar($sql);	  			   		
/*
						  
   	 $sql = "SELECT nov_status.descripcion, nov_procesos_det.observacion
               FROM nov_procesos_det , nov_status
              WHERE nov_procesos_det.cod_nov_proc = '$codigo' 
			    AND nov_procesos_det.cod_nov_status = nov_status.codigo 
			    AND nov_procesos_det.cod_nov_status  = '$nov_status'
				AND nov_procesos_det.hora  = '$hora' ";

   	$query = $bd->consultar($sql);		
    $row = $bd->obtener_fila($query,0);	
	echo	$mensaje = 'Se Actualizo: &nbsp; '.$row[0].',  Observacion:  '.$row[1].'';
*/		
	break; 	
	}        
}
require_once('../funciones/sc_direccionar.php');	 				
?>