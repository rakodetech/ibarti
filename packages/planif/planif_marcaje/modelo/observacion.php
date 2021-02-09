<?php
define("SPECIALCONSTANT", true);
include_once('../../../../funciones/funciones.php');
require "../../../../autentificacion/aut_config.inc.php";
require "../../../../" . class_bdI;
$bd = new DataBase();
$result = array();
$result['error'] = false;
foreach ($_POST as $nombre_campo => $valor) {
  $variables = "\$" . $nombre_campo . "='" . $valor . "';";
  eval($variables);
}

try {
  $sql = "INSERT INTO planif_clientes_superv_trab_det_observ(cod_det, observacion, cod_us_ing, fec_us_ing)
        VALUES($cod_det, '$observacion', '$usuario', CURDATE())";
  $query = $bd->consultar($sql);
  $result['sql'] = $sql;
} catch (Exception $e) {
  $error =  $e->getMessage();
  $result['error'] = true;
  $result['sql'] = $sql;
  $result['mensaje'] = $error;
  $bd->log_error("Aplicacion", "sc_participante_Actividad.php",  "$usuario", "$error", "$sql");
}
print_r(json_encode($result));
return json_encode($result);
