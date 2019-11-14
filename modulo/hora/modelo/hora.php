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
  $nombre    = htmlentities($nombre);
  $activo	   = $activo;

	if(isset($_POST['proced'])){
		try {

    $sql    = "$SELECT $proced('$metodo', '$codigo', '$nombre',  '$concepto',
                               '$h_entrada', '$h_salida', '$inicio_m_entrada', '$fin_m_entrada',
                               '$inicio_m_salida', '$fin_m_salida', '$dia_trabajo', '$minutos_trabajo',
                               '$usuario', '$activo')";
	 $query = $bd->consultar($sql);

   $result['sql'] = $sql;

 		}catch (Exception $e) {
       $error =  $e->getMessage();
       $result['error'] = true;
       $result['mensaje'] = $error;
       $bd->log_error("Aplicacion", "sc_hora.php",  "$usuario", "$error", "$sql");
   }

	}
	print_r(json_encode($result));
	return json_encode($result);

?>
