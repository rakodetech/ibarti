<?php
define("SPECIALCONSTANT", true);

include_once('../../funciones/funciones.php');
require("../../autentificacion/aut_config.inc.php");
require_once("../../".class_bdI);
$bd = new DataBase();
$result = array();


  $codigo           = $_POST['codigo'];
  $nombre           = htmlentities($_POST['nombre']);
  $concepto         = $_POST['concepto'];
  $h_entrada        = $_POST['h_entrada'];
  $h_salida         = $_POST['h_salida'];
  $inicio_m_entrada = $_POST['inicio_m_entrada'];
  $fin_m_entrada    = $_POST['fin_m_entrada'];
  $inicio_m_salida  = $_POST['inicio_m_salida'];
  $fin_m_salida     = $_POST['fin_m_salida'];
  $dia_trabajo     = $_POST['dia_trabajo'];
  $minutos_trabajo = $_POST['minutos_trabajo'];
  $status          = $_POST['activo'];
  $usuario         = $_POST['usuario'];
  $proced          = $_POST['proced'];
  $metodo          = $_POST['metodo'];

	if(isset($_POST['proced'])){

		try {

    $sql    = "$SELECT $proced('$metodo', '$codigo', '$nombre',  '$concepto',
                               '$h_entrada', '$h_salida', '$inicio_m_entrada', '$fin_m_entrada',
                               '$inicio_m_salida', '$fin_m_salida', '$dia_trabajo', '$minutos_trabajo',
                               '$usuario', '$status')";
	 $query = $bd->consultar($sql);

   $result['sql'] = $sql;

 		}catch (Exception $e) {
       $error =  $e->getMessage();
       $result['error'] = true;
       $result['mensaje'] = $error;
       $bd->log_error("Aplicacion", "sc_horario.php",  "$usuario", "$error", "$sql");
   }

	}
	print_r(json_encode($result));
	return json_encode($result);

?>
