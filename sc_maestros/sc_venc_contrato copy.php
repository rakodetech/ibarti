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

$codigo      = htmlentities($_POST['codigo']);
$descripcion = $_POST["descripcion"];			
$dias        = $_POST["dias"];
$vencimiento = $_POST["vencimiento"];
$campo01 = $_POST['campo01'];	
$campo02 = $_POST['campo02'];	
$campo03 = $_POST['campo03'];	
$campo04 = $_POST['campo04'];	
$activo      = statusbd($_POST['activo']);

$href     = $_POST['href'];
$usuario  = $_POST['usuario']; 
$proced   = $_POST['proced'];
$metodo   = $_POST['metodo'];
	if(isset($_POST['proced'])){
		
	$sql    = "$SELECT $proced('$metodo', '$codigo', '$descripcion', '$vencimiento',
	                            '$dias',  '$campo01', '$campo02', '$campo03',
							   '$campo04', '$usuario', '$activo')";						 		

	$query = $bd->consultar($sql);	  			   	
	}
require_once('../funciones/sc_direccionar.php');  
?>
<body>
</body>
</html>