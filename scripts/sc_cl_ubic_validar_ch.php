<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase();

$codigo        = $_POST['codigo']; 

     $sql    = "SELECT COUNT(clientes_ub_ch.cod_capta_huella) FROM clientes_ub_ch
                 WHERE clientes_ub_ch.cod_capta_huella = '$codigo' ";						  
	 $query = $bd->consultar($sql);	 
	 $datos=$bd->obtener_fila($query,0);	
	echo $datos[0];
	 	 
?>