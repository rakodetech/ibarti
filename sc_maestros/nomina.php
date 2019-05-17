<?php
require_once('../autentificacion/aut_config.inc.php'); 
include_once('../funciones/funciones.php');
include_once('../funciones/mensaje_error.php');
mysql_select_db($bd_cnn, $cnn);

$tabla       = "nomina";
$tabla_id    = "nomina.co_cont";
$codigo      = $_POST['codigo'];
$descripcion = strtoupper($_POST['descripcion']);
$cestaticket = $_POST['cestaticket'];
$status      = $_POST['status'];
$href        = $_POST['href']; 

$Nmenu       = $_POST['Nmenu'];
if (isset($_POST['metodo'])) {
   $i=$_POST['metodo'];
 
	switch ($i){
    case Agregar:	 
	 		 $sql=mysql_query("INSERT INTO $tabla ($tabla_id, nomina.des_cont, nomina.cestaticket)			
					  VALUES ( null, '$descripcion', '$ces')",$cnn);         	

    break;				 
	case Modificar:  
	           mysql_query("UPDATE $tabla SET			                      
								   cestaticket    = '$cestaticket'	                      
			                 WHERE $tabla_id      = '$codigo'", $cnn);
														  
	break;
	case Eliminar:

	          mysql_query("UPDATE $tabla SET
			                      status = 2
			                      WHERE $tabla_id = '".$campo_id."'", $cnn);													  
	break;		 
	}        
}

	require_once('../funciones/sc_direccionar.php');  	 				
?>