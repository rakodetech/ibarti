<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase();
$tabla    = 'ficha';

$codigo         = $_POST['codigo'];
$fecha          = $_POST['fecha'];
$replicar       = $_POST['replicar'];
$excepcion      = $_POST['excepcion'];


$href     = $_POST['href'];
$usuario  = $_POST['usuario'];
$proced   = $_POST['proced'];
$metodo   = $_POST['metodo'];


	if(isset($_POST['proced'])){
	 $sql    = "$SELECT $proced('$metodo', '$codigo', '$fecha', '$replicar',
	                            '$excepcion', '$usuario')";
	 $query = $bd->consultar($sql);
	}
 require_once('../funciones/sc_direccionar.php');
?>
