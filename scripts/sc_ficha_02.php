<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase();
$tabla    = 'ficha';

$codigo         = $_POST['codigo']; 
$pantalon     = $_POST['t_pantalon'];
$camisa       = $_POST['t_camisa'];
$zapato       = $_POST['n_zapato'];


$href     = $_POST['href'];
$usuario  = $_POST['usuario']; 
$proced   = $_POST['proced'];
$metodo   = $_POST['metodo'];


	if(isset($_POST['proced'])){ 	
	 $sql    = "$SELECT $proced('$metodo', '$codigo', '$pantalon', '$camisa', 
	                            '$zapato')";						  
	 $query = $bd->consultar($sql);	 
	}
require_once('../funciones/sc_direccionar.php');  	 
?>