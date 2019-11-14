<?php
define("SPECIALCONSTANT", true);

include_once('../../../funciones/funciones.php');
require("../../../autentificacion/aut_config.inc.php");
require_once("../../../".class_bdI);
$bd = new DataBase();
$result = array();
//include_once('../funciones/mensaje_error.php');
$tabla    = $_POST['tabla'];
$tabla_id = 'codigo';

$codigo      = $_POST['codigo'];
$descripcion = $_POST['descripcion'];	
$campo01 = $_POST['campo01'];	
$campo02 = $_POST['campo02'];	
$campo03 = $_POST['campo03'];	
$campo04 = $_POST['campo04'];	

$activo      = statusbd($_POST['activo']);

$usuario  = $_POST['usuario']; 

if (isset($_POST['metodo'])){

	$i = $_POST['metodo'];	
	switch ($i) {
		case 'agregar':

		try {

			$sql = "INSERT INTO $tabla (codigo, descripcion, campo01, campo02, campo03, campo04,
			cod_us_ing, fec_us_ing, cod_us_mod, fec_us_mod, status) 
			VALUES ('$codigo', '$descripcion',
			'$campo01', '$campo02', '$campo03', '$campo04', 
			'$usuario', '$date', '$usuario','$date' , '$activo')";	

			$query   = $bd->consultar($sql);
			$result['sql'] = $sql;

		}catch (Exception $e) {
			$error =  $e->getMessage();
			$result['error'] = true;
			$result['mensaje'] = $error;

			$bd->log_error("Aplicacion", "sc_linea.php",  "$usuario", "$error", "$sql");
		}

		break;					
		case 'modificar':		


		try {

			$sql ="UPDATE $tabla SET   
			codigo          = '$codigo',     descripcion    = '$descripcion',
			campo01     = '$campo01',    campo02        = '$campo02',
			campo03     = '$campo03',    campo04        = '$campo04', 
			cod_us_mod  = '$usuario',    fec_us_mod     = '$date',
			status      = '$activo'
			WHERE codigo = '$codigo'";
			$query = $bd->consultar($sql);	
			$result['sql'] = $sql;

		}catch (Exception $e) {
			$error =  $e->getMessage();
			$result['error'] = true;
			$result['mensaje'] = $error;

			$bd->log_error("Aplicacion", "sc_linea.php",  "$usuario", "$error", "$sql");
		}	
		
		break;
		case 'borrar':			


		try {

			$sql ="DELETE FROM $tabla WHERE  $tabla_id = '$codigo'";
			$query = $bd->consultar($sql);	
			$result['sql'] = $sql;

		}catch (Exception $e) {
			$error =  $e->getMessage();
			$result['error'] = true;
			$result['mensaje'] = $error;

			$bd->log_error("Aplicacion", "sc_linea.php",  "$usuario", "$error", "$sql");
		}	
		break;		
		
	}        
}
print_r(json_encode($result));
return json_encode($result);

?>
