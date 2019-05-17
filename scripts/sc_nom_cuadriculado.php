<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>

<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase();

$fecha       = conversion($_POST['fecha_desde']);

$quincena    = $_POST['quincena'];
$href        = $_POST['href'];
$usuario     = $_POST['usuario']; 

$proced      = $_POST['proced'];
$metodo      = $_POST['metodo'];

	if(isset($_POST['proced'])){
 	 $sql    = "$SELECT $proced('$fecha', '$quincena', '$usuario')";	

	 $query = $bd->consultar($sql);	  			  
	}
require_once('../funciones/sc_direccionar.php');  
?>
</body>
</html>