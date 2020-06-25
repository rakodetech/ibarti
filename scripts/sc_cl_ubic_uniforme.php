<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase();

$codigo        = $_POST['codigo']; 
$cod_sub_linea     = $_POST['cod_sub_linea'];
$cantidad     = $_POST['cantidad'];

$href     = $_POST['href'];
$proced   = $_POST['proced'];
$metodo   = $_POST['metodo'];
$usuario  = $_POST['usuario'];

if(isset($_POST['proced'])){
     $sql    = "$SELECT $proced('$metodo', '$codigo', '$cod_sub_linea', $cantidad, '$usuario')";						  
	 $query = $bd->consultar($sql);	 
	}
	require_once('../funciones/sc_direccionar.php');  	 
?>