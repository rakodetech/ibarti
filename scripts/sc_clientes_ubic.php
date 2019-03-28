<?php
define("SPECIALCONSTANT", true);

include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bdI);
$bd = new DataBase();
$result = array();

$codigo      = htmlentities($_POST["codigo"]);
$cliente     = $_POST['cliente'];
$estado      = $_POST["estado"];
$ciudad      = $_POST["ciudad"];
$region      = $_POST["region"];
$calendario  = $_POST["calendario"];
$nombre      = $_POST["nombre"];
$contacto    = $_POST["contacto"];
$cargo       = $_POST["cargo"];
$telefono    = $_POST["telefono"];
$email       = $_POST["email"];
$direccion   = $_POST["direccion"];
$observ      = $_POST["observ"];

$campo01 = $_POST["campo01"];
$campo02 = $_POST["campo02"];
$campo03 = $_POST["campo03"];
$campo04 = $_POST["campo04"];

$activo      = statusbd($_POST["activo"]);

$usuario  = $_POST['usuario'];
$proced   = $_POST['proced'];
$metodo   = $_POST['metodo'];
	if(isset($_POST['proced'])){

		try {

 	 $sql    = "$SELECT $proced('$metodo', '$codigo', '$cliente', '$estado',
	                            '$ciudad', '$region', '$calendario', '$nombre',
								'$contacto', '$cargo', '$telefono', '$email',
								'$direccion', '$observ',
								'$campo01', '$campo02', '$campo03', '$campo04', '$usuario',  '$activo')";
	 $query = $bd->consultar($sql);

   $result['sql'] = $sql;

 		}catch (Exception $e) {
       $error =  $e->getMessage();
       $result['error'] = true;
       $result['mensaje'] = $error;

       $bd->log_error("Aplicacion", "sc_clientes_ubic.php",  "$usuario", "$error", "$sql");
   }


	}
	print_r(json_encode($result));
	return json_encode($result);

?>
