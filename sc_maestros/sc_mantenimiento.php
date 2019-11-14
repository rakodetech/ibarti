<?php
require_once('../autentificacion/aut_config.inc.php'); 
include_once('../funciones/funciones.php');
include_once('../funciones/mensaje_error.php');
mysql_select_db($bd_cnn, $cnn);


$tabla       = $_POST['tabla'];
$archivo     = $_POST['archivo'];
$tabla_id    = 'id';

$id          = $_POST['id'];
$codigo      = strtoupper($_POST['codigo']);
$descripcion = strtoupper($_POST['descripcion']); //strtoupper(htmlentities(
$status      = $_POST['status'];
$Nmenu       = $_POST['Nmenu'];
if (isset($_POST['metodo'])) {
   $i=$_POST['metodo'];


	switch ($i) {
    case Agregar:
	 	begin();
	
              mysql_query("INSERT INTO $tabla
		                 ($tabla_id, descripcion, status) 
                  VALUES (null, '$descripcion' ,$status)",$cnn);
    break;				 
    case AgregarCodigo:
		 begin();
              mysql_query("INSERT INTO $tabla
		                 ($tabla_id, descripcion, status) 
                  VALUES ('$codigo', '$descripcion' ,$status)",$cnn);

     break;		
	 case Modificar:  
	 	  begin();
       					
	           mysql_query("UPDATE $tabla SET
			                      descripcion = '$descripcion',
			                      status      = '$status'								  
			                WHERE $tabla_id = '".$id."'", $cnn);
														  
	break;
	case Eliminar:  
		 begin();  	 
			 $id          = $_POST['id'];
	          mysql_query("UPDATE $tabla SET
			                      status = 2
			                      WHERE $tabla_id = '".$id."'", $cnn);													  
	break;		 
	}        
}
require_once('../funciones/sc_direccionar.php');  
?> 