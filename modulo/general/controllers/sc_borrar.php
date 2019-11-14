<?php
define("SPECIALCONSTANT", true);

include_once('../../../funciones/funciones.php');
require("../../../autentificacion/aut_config.inc.php");
require_once("../../../".class_bdI);
$bd = new DataBase();
$result = array();

  $codigo           = $_POST['codigo'];
  $usuario          = $_POST['usuario'];
  $tabla            = $_POST['tabla'];


		try {
    $sql  = "DELETE FROM $tabla  WHERE codigo = '$codigo' ";

	 $query = $bd->consultar($sql);

   $result['sql'] = $sql;

 		}catch (Exception $e) {
       $error =  $e->getMessage();
       $result['error'] = true;
       $result['mensaje'] = $error;

       $bd->log_error("Aplicacion", "sc_borrar.php",  "$usuario", "$error", "$sql");
   }


	print_r(json_encode($result));
	return json_encode($result);

?>
