<?php
define("SPECIALCONSTANT", true);
require  "../../../../autentificacion/aut_config.inc.php";
require_once  "../../../../" . class_bdI;

$bd = new DataBase();
$result = array();

foreach ($_POST as $nombre_campo => $valor) {
  $variables = "\$" . $nombre_campo . "='" . $valor . "';";
  eval($variables);
}
try {
  $sql = "INSERT INTO planif_perfil_cargos(cod_perfil, cod_cargo, status) VALUES('$perfil', '$cargo', '$estatus') ON DUPLICATE KEY UPDATE status = '$estatus';";

  $query = $bd->consultar($sql);

  $result['sql'] = $sql;
} catch (Exception $e) {
  $error =  $e->getMessage();
  $result['error'] = true;
  $result['mensaje'] = $error;
  $bd->log_error("Aplicacion", "sc_perfil_nov.php",  "$usuario", "$error", "$sql");
}
print_r(json_encode($result));
return json_encode($result);
