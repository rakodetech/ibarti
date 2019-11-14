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

try {
  switch ($metodo) {
  case 'agregar':

        $sql = "INSERT INTO $tabla (codigo, descripcion, campo01, campo02, campo03, campo04,
                                          cod_us_ing, fec_us_ing, cod_us_mod, fec_us_mod, status)
                                  VALUES ('$codigo', '$descripcion',
                        '$campo01', '$campo02', '$campo03', '$campo04',
                        '$usuario', '$date', '$usuario','$date' , '$activo')";
        $query = $bd->consultar($sql);
  break;
  case 'modificar':
        $sql ="UPDATE $tabla SET
                    codigo          = '$codigo',     descripcion    = '$descripcion',
                campo01     = '$campo01',    campo02        = '$campo02',
                campo03     = '$campo03',    campo04        = '$campo04',
                    cod_us_mod  = '$usuario',    fec_us_mod     = '$date',
                status      = '$activo'
              WHERE codigo = '$codigo'";
        $query = $bd->consultar($sql);
  break;
  }
}catch (Exception $e) {
   $error =  $e->getMessage();
   $result['error'] = true;
   $result['mensaje'] = $error;
   $bd->log_error("Aplicacion", "sc_maestro.php",  "$usuario", "$error", "$sql");
}


print_r(json_encode($result));
return json_encode($result);
?>
