<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase();

	$codigo  = $_POST['codigo'];
     $sql    = "SELECT COUNT(ficha_huella.cedula)  FROM ficha_huella  WHERE ficha_huella.cedula = '$codigo'";							 $query = $bd->consultar($sql);	 
	 $datos=$bd->obtener_fila($query,0);	
	echo $datos[0];
	 	 
?>