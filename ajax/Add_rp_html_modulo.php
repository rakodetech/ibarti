<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase(); 

//require_once('../autentificacion/aut_config.inc.php'); 
//include_once('../funciones/mensaje_error.php');
	$codigo   = $_POST['codigo'];
	$sql   = " SELECT men_modulos.vista FROM men_modulos WHERE men_modulos.codigo = '$codigo' ";
    $query = $bd->consultar($sql);
  	$datos = $bd->obtener_fila($query,0);					 
	$view  = $datos[0];					
	 
	$sql = " SHOW COLUMNS FROM $view ";
    $query = $bd->consultar($sql);
	echo'<select name="ciudad" style="width:120px">
			     <option value="">Ver Campos Disponibles</option>'; 
			  	 while($datos=$bd->obtener_fila($query,0)){					 
		echo '<option value="'.$datos[0].'">'.utf8_decode($datos[0]).'</option>';
		}
		echo'</select>';
mysql_free_result($query); ?>