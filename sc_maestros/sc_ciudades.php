<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase();
//include_once('../funciones/mensaje_error.php');

$codigo      = htmlentities($_POST['codigo']);
$pais        = $_POST["pais"];
$estados     = $_POST["estados"];
$descripcion = $_POST["descripcion"];			
$activo      = statusbd($_POST['activo']);
$proced      = $_POST['proced'];
$metodo      = $_POST["metodo"];

$href        = $_POST['href'];
$usuario     = $_POST['usuario']; 

  $sql    = "$SELECT $proced('$metodo', '$codigo', '$pais', '$estados', '$descripcion',  '$usuario', '$activo')";						  
  $query = $bd->consultar($sql);	  	
  
	require_once('../funciones/sc_direccionar.php');  
?>
