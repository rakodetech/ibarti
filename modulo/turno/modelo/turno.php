<?php
define("SPECIALCONSTANT", true);

include_once('../../../funciones/funciones.php');
require("../../../autentificacion/aut_config.inc.php");
require_once("../../../".class_bdI);
$bd = new DataBase();
$result = array();

  $codigo          = $_POST['codigo'];
  $abrev           = $_POST['abrev'];
  $nombre          = htmlentities($_POST['nombre']);
  $d_habil         = $_POST['d_habil'];
  $horario         = $_POST['horario'];
  $factor          = $_POST['factor'];
  $trab_cubrir     = $_POST['trab_cubrir'];

  $status          = $_POST['activo'];
  $usuario         = $_POST['usuario'];
  $proced          = $_POST['proced'];
  $metodo          = $_POST['metodo'];

	if(isset($_POST['proced'])){

		try {
    $sql    = "$SELECT $proced('$metodo', '$codigo', '$abrev',  '$nombre',
                               '$d_habil', '$horario', '$factor', '$trab_cubrir',
                               '$usuario', '$status')";

	 $query   = $bd->consultar($sql);

   $result['sql'] = $sql;

 		}catch (Exception $e) {
       $error =  $e->getMessage();
       $result['error'] = true;
       $result['mensaje'] = $error;

       $bd->log_error("Aplicacion", "sc_turno.php",  "$usuario", "$error", "$sql");
   }


	}
	print_r(json_encode($result));
	return json_encode($result);

?>
