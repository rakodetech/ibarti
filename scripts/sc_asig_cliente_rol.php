<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase();

$tabla1    = 'usuario_roles';
$tabla2    = 'usuario_clientes';
$tabla_id = 'cod_usuario';

$codigo	  = $_POST['codigo'];	
$href     = $_POST['href'];

$usuario  = $_POST['usuario']; 
$metodo   = $_POST['metodo'];

	if (isset($_POST['metodo'])) {
	$i=$_POST['metodo'];
		switch ($i) {
			   	
		case 'usuarios_roles':    	 	
		$roles = $_POST['roles'];

 	    $sql = "DELETE FROM $tabla1 WHERE cod_usuario = '$codigo'";						  
	    $query = $bd->consultar($sql);	
	
			foreach ($roles as $valorX){				
			$sql = "INSERT INTO $tabla1 (cod_usuario, cod_rol)			
								 VALUES ('$codigo', '$valorX')";						  
	    $query = $bd->consultar($sql);	
									 
			 }
		 break;
		 
		 
		case 'usuarios_clientes':    	 	
		$ubicacion = $_POST['ubicacion'];

 	    $sql = "DELETE FROM $tabla2 WHERE cod_usuario = '$codigo'";						  
	    $query = $bd->consultar($sql);	
	
			foreach ($ubicacion as $valorX){				
			$sql = "INSERT INTO $tabla2 (cod_usuario, cod_ubicacion)			
								 VALUES ('$codigo', '$valorX')";						  
	    $query = $bd->consultar($sql);	
									 
			 }
		 break;		 
		}        
	}
require_once('../funciones/sc_direccionar.php');  
?>