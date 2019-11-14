<?php
define("SPECIALCONSTANT", true);
require "../autentificacion/aut_config.inc.php";
require "../".class_bdI;
$bd = new DataBase();
$result = array();

foreach($_POST as $nombre_campo => $valor){
  $variables = "\$".$nombre_campo."='".$valor."';";
  eval($variables);
}

try {
  $sql = " SELECT DATEDIFF(MAX(ficha_historial.fec_fin),CURDATE()) dias
  FROM  ficha , ficha_historial
  WHERE ficha.cod_ficha = ficha_historial.cod_ficha
  AND ficha.cod_ficha = '$trabajador'";

  $result["sql"] = $sql;
  $query = $bd->consultar($sql);
  while($data = $bd->obtener_fila($query)){
    $result['data']=$data;
  };
  

}catch (Exception $e) {
 $error =  $e->getMessage();
 $result['error'] = true;
 $result['mensaje'] = $error;
 $bd->log_error("Aplicacion", "nomina/dias_vencimiento.php",  "$usuario", "$error", "$sql");
}

print_r(json_encode($result));
return json_encode($result);
?>

