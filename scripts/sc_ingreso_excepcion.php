<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
</head>
<body>
<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase();
//include_once('../funciones/mensaje_error.php');

$tabla_id = 'codigo';

$codigo   = $_POST["codigo"];

$psic_observacion = htmlspecialchars($_POST["psic_observacion"]);
$pol_observacion = htmlspecialchars($_POST["pol_observacion"]);
$observacion     = htmlspecialchars($_POST["observacion"]);
$status   = $_POST["status"];
$href     = $_POST['href'];
$usuario  = $_POST['usuario']; 
$proced   = $_POST['proced'];
$metodo   = $_POST['metodo'];

	if(isset($_POST['proced'])){
	 $sql    = "$SELECT $proced('$metodo', '$codigo', '$psic_observacion', '$pol_observacion',
	                            '$observacion', '$usuario',  '$status')";						  
	 $query = $bd->consultar($sql);	  			   		
	}
  require_once('../funciones/sc_direccionar.php');  
?>
</body>
</html>