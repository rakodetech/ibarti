<?php
require_once('../autentificacion/aut_config.inc.php'); 
include_once('../funciones/funciones.php');
include_once('../funciones/mensaje_error.php');
mysql_select_db($bd_cnn, $cnn);


$tabla       = "clientes_ubicacion";
$tabla_id    = "id";

$id          = $_POST['id'];
$campo_id    = $_POST['campo_id'];
$codigo      = strtoupper($_POST['codigo']);
$descripcion = strtoupper($_POST['descripcion']);
$municipio   = $_POST['municipios'];
$ubicacion   = strtoupper($_POST['ubicacion']);
$region      = $_POST['region'];
$status      = $_POST['status'];
$contacto    = $_POST['contacto'];
$telefono    = $_POST['telefono'];
$telefono2   = $_POST['telefono2'];
$correo      = $_POST['correo'];
$otro        = $_POST['otro'];
$href        = $_POST['href']; 
$codigo2     = $codigo.'/'.$region; 

if (isset($_POST['metodo'])) {
   $i=$_POST['metodo'];
   
	switch ($i) {
    case Agregar:	
	 
	 		 $sql=mysql_query("INSERT INTO $tabla
						     ($tabla_id, codigo, co_cli, descripcion,  id_dpt_2, id_region, ubicacion,  status, contacto,
							 telefono, telefono2, correo, otro)			
					  VALUES (null, '$codigo2', '$codigo', '$descripcion', '$municipio',  '$region', '$ubicacion', 1, '$contacto',
					          '$telefono', '$telefono2', '$correo', '$otro')",$cnn);         	

    break;				 
	case Modificar:  
	
	           mysql_query("UPDATE $tabla SET
			                      codigo      = '$codigo2',   		  id_dpt_2    = '$municipio',
								  descripcion = '$descripcion',		  ubicacion   = '$ubicacion',
			                      id_region   = '$region',			  status      = $status,
								  contacto    = '$contacto',          telefono    = '$telefono',
								  telefono2   = '$telefono2',         correo      = '$correo',
								  otro        = '$otro' 
			                WHERE $tabla_id   = '".$campo_id."'", $cnn); 
														  
	break;
	case Eliminar:
echo '';
	          mysql_query("UPDATE $tabla SET
			                      status = 2
			                      WHERE $tabla_id = '".$campo_id."'", $cnn);													  
	break;		 
	}        
}

	require_once('../funciones/sc_direccionar.php');  	 				
?>