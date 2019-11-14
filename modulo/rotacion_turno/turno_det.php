<?php
define("SPECIALCONSTANT", true);
include_once('../../funciones/funciones.php');
require("../../autentificacion/aut_config.inc.php");
require_once("../../".class_bdI);
$bd = new DataBase();
$result = array();

$codigo          = $_POST['codigo'];
$usuario         = $_POST['usuario'];

	try {
    $sql    = "SELECT horarios.nombre horario, dias_habiles.descripcion dh
                 FROM turno , horarios , dias_habiles
                WHERE  turno.codigo = '$codigo'
                  AND turno.cod_dia_habil = dias_habiles.codigo
                  AND turno.cod_horario = horarios.codigo";
	 $query = $bd->consultar($sql);
   $row   = $bd->obtener_fila($query);
   $result = "Horario: ".$row[0].", Dia Habil: ".$row[1]."";

 		}catch (Exception $e) {
      $error =  $e->getMessage();
      $result['error'] = true;
      $result['mensaje'] = $error;

      $bd->log_error("Aplicacion", "rotacion_turno/sc_turno_det.php",  "$usuario", "$error", "$sql");
   }

	print_r(json_encode($result));
	return json_encode($result);
?>
