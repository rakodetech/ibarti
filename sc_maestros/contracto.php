<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase();

$codigo      = $_POST['codigo'];
$descripcion = htmlentities($_POST['descripcion']);
$contracto_tipo = $_POST['contracto_tipo'];	
$cestaticket = $_POST['cestaticket'];
$fec_inicio  = conversion($_POST['fec_inicio']);
$fec_ultimo = conversion($_POST['fec_ultimo']);
$activo      = statusbd($_POST['activo']);

$usuario     = $_POST['usuario'];
$href        = $_POST['href']; 

$proced      = $_POST['proced'];
$metodo      = $_POST['metodo']; 

if(isset($_POST['proced'])){

   $sql   = "$SELECT $proced('$metodo', '$codigo', '$descripcion', '$contracto_tipo',
                             '$cestaticket', '$fec_inicio', '$fec_ultimo', '$usuario', '$activo')";						  
	 $query = $bd->consultar($sql);	 
	}

require_once('../funciones/sc_direccionar.php');  	 				
?>