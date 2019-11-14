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

  if($tabla == "prod_sub_lineas"){
    $productos = array();
    $sql = "SELECT descripcion FROM productos WHERE cod_sub_linea = '$codigo'";
    $query = $bd->consultar($sql);
    while ($datos= $bd->obtener_fila($query)) {
      $productos[] = $datos;
    }
    if(count($productos) > 0){
      $result['error'] = true;
      $result['mensaje'] = "No es posible eliminar esta Sub Linea, debido a que ya existen productos en la misma";
    }
      print_r(json_encode($result));
      return json_encode($result);
  }
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
