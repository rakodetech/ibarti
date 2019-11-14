<?php
require_once('../autentificacion/aut_config.inc.php'); 
include_once('../funciones/funciones.php');
include_once('../funciones/mensaje_error.php');
mysql_select_db($bd_cnn, $cnn);


$tabla       = "dpt_1";
$tabla_id    = "entienti";
$id          = $_POST['id'];
$campo_id    = $_POST['campo_id'];
$codigo      = strtoupper($_POST['codigo']);
$descripcion = strtoupper($_POST['descripcion']);
$status      = $_POST['status'];
$href        = $_POST['href']; 
$Nmenu       = $_POST['Nmenu'];
if (isset($_POST['metodo'])) {
   $i=$_POST['metodo'];
   
	switch ($i) {
    case Agregar:	
	 

	 		 $sql=mysql_query("INSERT INTO $tabla
						     ($tabla_id, entidescri)			
					  VALUES ( null, '$descripcion')",$cnn);         	

    break;				 
	case Modificar:  

	           mysql_query("UPDATE $tabla SET			                      
								  entidescri  = '$descripcion'			                      
			                WHERE $tabla_id   = '$campo_id'", $cnn);
														  
	break;
	case Eliminar:

	          mysql_query("UPDATE $tabla SET
			                      status = 2
			                      WHERE $tabla_id = '$campo_id'", $cnn);													  
	break;		 
	}        
}

	require_once('../funciones/sc_direccionar.php');  	 				 

?>