<?php
define("SPECIALCONSTANT", true);

include_once('../../../../funciones/funciones.php');
require("../../../../autentificacion/aut_config.inc.php");
require_once("../../../../".class_bdI);
$bd = new DataBase();
$result = array();

$serial           = $_POST['serial'];
$usuario          = $_POST['usuario'];


try {
  $sql  = "DELETE FROM productos  WHERE item = '$serial' ";

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
