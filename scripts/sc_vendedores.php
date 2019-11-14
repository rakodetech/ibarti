<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
</head>
<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase();
//include_once('../funciones/mensaje_error.php');
$tabla    = $_POST['tabla'];
$tabla_id = 'codigo';

$codigo  = htmlentities($_POST['codigo']);
$vend_tipo   = $_POST["vend_tipo"];
$cedula      = $_POST["cedula"];
$nombre      = $_POST["nombre"];
$telefono    = $_POST["telefono"];
$direccion   = $_POST["direccion"];
$email       = $_POST["email"];
$vendedor    = statusbd($_POST["vendedor"]);
$cobrador    = statusbd($_POST["cobrador"]);
$coms_vent   = $_POST["coms_vent"];
$coms_cob    = $_POST["coms_cob"];
$campo01 = $_POST["campo01"];
$campo02 = $_POST["campo02"];
$campo03 = $_POST["campo03"];
$campo04 = $_POST["campo04"];

$activo      = statusbd($_POST['activo']);

$href     = $_POST['href'];
$usuario  = $_POST['usuario']; 
$proced   = $_POST['proced']; 
$metodo   = $_POST['metodo'];
   

 $sql    = "$SELECT $proced('$metodo', '$codigo', '$vend_tipo','$cedula' ,'$nombre', '$telefono', '$direccion', '$email', '$vendedor','$cobrador', '$coms_vent', '$coms_cob','$campo01', '$campo02', '$campo03', '$campo04', '$usuario',  '$activo')";						  
  $query = $bd->consultar($sql);	  			   	
	require_once('../funciones/sc_direccionar.php');  
?>
<body>
</body>
</html>