<?php

define("SPECIALCONSTANT", true);

include_once('../../../funciones/funciones.php');
require("../../../autentificacion/aut_config.inc.php");
require_once("../../../".class_bdI);
$bd = new DataBase();
$result = array();

foreach($_POST as $nombre_campo => $valor){
  $variables = "\$".$nombre_campo."='".$valor."';";
  eval($variables);
}

$codigo      = htmlentities($codigo);
$activo      = statusbd($activo);

	if(isset($_POST['proced'])){

		try {

 	 $sql    = "$SELECT $proced('$metodo', '$codigo', '$cliente', '$descripcion',
	                            '$fecha_inicio', '$fecha_fin',
															'$usuario', '$activo')";
	 $query = $bd->consultar($sql);

   $result['sql'] = $sql;

 		}catch (Exception $e) {
       $error =  $e->getMessage();
       $result['error'] = true;
       $result['mensaje'] = $error;

       $bd->log_error("Aplicacion", "sc_contratacion.php",  "$usuario", "$error", "$sql");
   }


	}
	print_r(json_encode($result));
	return json_encode($result);
?>
