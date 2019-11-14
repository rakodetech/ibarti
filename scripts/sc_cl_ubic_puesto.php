<?php
define("SPECIALCONSTANT", true);
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bdI);
$bd = new DataBase();
$result = array();

$codigo      = htmlentities($_POST["codigo"]);
$cliente     = $_POST['cliente'];
$ubicacion   = $_POST["ubicacion"];
$nombre      = $_POST["nombre"];
$actividades = $_POST["actividades"];
$observ      = $_POST["observ"];
$activo      = statusbd($_POST["activo"]);

$usuario  = $_POST['usuario'];
$proced   = $_POST['proced'];
$metodo   = $_POST['metodo'];
	if(isset($_POST['proced'])){

		try {

 	 $sql    = "$SELECT $proced('$metodo', '$codigo', '$cliente', '$ubicacion',
	                            '$nombre', '$actividades', '$observ',
															'$usuario',  '$activo')";
	 $query = $bd->consultar($sql);

   $result['sql'] = $sql;

 		}catch (Exception $e) {
       $error =  $e->getMessage();
       $result['error'] = true;
       $result['mensaje'] = $error;

       $bd->log_error("Aplicacion", "sc_cl_ubic_puesto.php",  "$usuario", "$error", "$sql");
   }


	}
	print_r(json_encode($result));
	return json_encode($result);
?>
