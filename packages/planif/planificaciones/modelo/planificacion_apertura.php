<?php
define("SPECIALCONSTANT", true);
require "../../../../autentificacion/aut_config.inc.php";
require "../../../../".class_bdI;
$bd = new DataBase();

$result = array();

foreach($_POST as $nombre_campo => $valor){
  $variables = "\$".$nombre_campo."='".$valor."';";
  eval($variables);
}

if(isset($_POST['metodo'])){
  try {
    if ($metodo == "agregar") {
      $sql  = "INSERT INTO planif_clientes
      (codigo,cod_cliente,cod_contratacion, fecha_inicio, fecha_fin,
      cod_us_ing, fec_us_ing, cod_us_mod, fec_us_mod,  `status`)
      VALUES (NULL, '$cliente','$contratacion', '$fec_inicio', '$fec_fin',
      '$usuario', CURRENT_TIMESTAMP, '$usuario', CURRENT_TIMESTAMP, 'T');";
    }elseif ($metodo == "cerrar") {
      $sql  = "UPDATE planif_clientes SET `status` = 'F', cod_us_mod = '$usuario',
      fec_us_mod = CURRENT_TIMESTAMP
      WHERE codigo = '$codigo'";
    }

    $query = $bd->consultar($sql);

    $result['sql'] = $sql;

  }catch (Exception $e) {
   $error =  $e->getMessage();
   $result['error'] = true;
   $result['mensaje'] = $error;
   $bd->log_error("Aplicacion", "sc_planificacion_aoertura.php",  "$usuario", "$error", "$sql");
 }
}
print_r(json_encode($result));
return json_encode($result);
?>
