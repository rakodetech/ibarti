<?php
require_once('../autentificacion/aut_config.inc.php'); 
include_once('../funciones/funciones.php');
include_once('../funciones/mensaje_error.php');
require_once("../".class_bd);
$bd = new DataBase();

$tabla       = "novedades";
$tabla_id    = "codigo";

$codigo      = strtoupper($_POST['codigo']);
$campo_id    = $_POST['campo_id'];

$descripcion = htmlentities(strtoupper($_POST['descripcion']));
$clasif      = $_POST['clasif'];

$usuario     = $_POST['usuario'];
$status      = $_POST['status'];
$href        = $_POST['href']; 

if (isset($_POST['metodo'])) {
   $i=$_POST['metodo'];
   
	switch ($i) {
    case 'Agregar':		 
			
	$sql    = "INSERT INTO $tabla SET 			 
								   $tabla_id       = '$codigo',       descripcion  = '$descripcion', 
								   cod_nov_clasif  = '$clasif',     
								   cod_us_ing      = '$usuario',      fec_us_ing  = '$date',
								   cod_us_mod      = '$usuario',      fec_us_mod  = '$date',
								   `status`        = '$status'";						  
	 $query = $bd->consultar($sql);	
							             	
    break;				 
	case 'Modificar':  
	
	$sql    = "UPDATE $tabla SET
								   descripcion  = '$descripcion', cod_nov_clasif  = '$clasif',       
								   cod_us_mod  = '$usuario',      fec_us_mod  = '$date',
								   `status`    = '$status'
						     WHERE $tabla_id   = '$codigo'";						  
	 $query = $bd->consultar($sql);	
	 
	break;
	case 'Eliminar':
	$sql    = "UPDATE $tabla SET
			                      status = 2
			                      WHERE $tabla_id = '".$campo_id."'";						  
	 $query = $bd->consultar($sql);	
	break;		 
	}        
}
	require_once('../funciones/sc_direccionar.php');  	 				
?>