<?php
define("SPECIALCONSTANT", true);

include_once('../../../../funciones/funciones.php');
require("../../../../autentificacion/aut_config.inc.php");
require_once("../../../../".class_bdI);
$bd = new DataBase();
$result = array();

foreach($_POST as $nombre_campo => $valor){
	if(!is_array($valor)){
		$variables = "\$".$nombre_campo."='".$valor."';";
		eval($variables);
	}
}

$json = json_encode($_POST["json"]);

if(isset($_POST['proced'])){
	try {

		$sql    = "$SELECT $proced('$metodo', '$codigo','$linea', '$descripcion', '$usuario', '$activo','$json')";

		$query   = $bd->consultar($sql);
		$result['sql'] = $sql;

	}catch (Exception $e) {
		$error =  $e->getMessage();
		$result['error'] = true;
		$result['mensaje'] = $error;

		$bd->log_error("Aplicacion", "sc_prod_sub_linea.php",  "$usuario", "$error", "$sql");
	}
}

print_r(json_encode($result));
return json_encode($result);
?>
