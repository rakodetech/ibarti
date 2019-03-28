<?php
define("SPECIALCONSTANT", true);

include_once('../../../../funciones/funciones.php');
require("../../../../autentificacion/aut_config.inc.php");
require_once("../../../../".class_bdI);
$bd = new DataBase();
$result = array();

foreach($_POST as $nombre_campo => $valor){
  if($nombre_campo != 'dias'){
    $variables = "\$".$nombre_campo."='".$valor."';";
    eval($variables);
  }
}

$dias = $_POST["dias"];

$descripcion      = htmlentities($descripcion);

if(isset($_POST['proced'])){

  try {

   if($metodo == "agregar"){

    $sql =  "INSERT INTO dias_habiles (codigo, cod_dias_tipo, descripcion,
    cod_us_ing, fec_us_ing, cod_us_mod, fec_us_mod,`status`) VALUES
    (NULL, '$tipo', '$descripcion',
    '$usuario', CURDATE(), '$usuario', CURDATE(), '$status')";
    $query = $bd->consultar($sql);
    $sql   = "SELECT LAST_INSERT_ID()";
    $query = $bd->consultar($sql);
    $datos = $bd->obtener_fila($query,0);
    $codigo = $datos[0];
  }else{

    $sql    = "$SELECT $proced('$metodo', '$codigo', '$descripcion',  '$tipo',
    '$usuario', '$status')";
    $query = $bd->consultar($sql);

  }
  $sql   = "DELETE FROM dias_habiles_det WHERE cod_dias_habiles = '$codigo'";
  $query = $bd->consultar($sql);
  foreach ($dias as $valorX){
   $sql = "INSERT INTO dias_habiles_det (cod_dias_habiles, cod_dias_tipo)
   VALUES ('$codigo', '$valorX')";
   $query = $bd->consultar($sql);
 }


}catch (Exception $e) {
 $error =  $e->getMessage();
 $result['error'] = true;
 $result['mensaje'] = $error;

 $bd->log_error("Aplicacion", "sc_dia_habil.php",  "$usuario", "$error", "$sql");
}


}
print_r(json_encode($result));
return json_encode($result);

?>
