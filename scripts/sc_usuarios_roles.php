<?php
/*

include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase();

$tabla    = 'usuario_roles';
$tabla_id = 'cod_usuario';

$codigo	  = $_POST['codigo'];	
$href     = $_POST['href'];

$usuario  = $_POST['usuario']; 
$metodo   = $_POST['metodo'];

	if (isset($_POST['metodo'])) {
	$i=$_POST['metodo'];
		switch ($i) {
  			   	
		case 'usuarios_roles':    	 

		$query01 = mysql_query ("DELETE FROM $tabla WHERE cod_usuario = '$codigo'",$cnn);	
	
			 foreach ($codigo as $valorX){
	
				 mysql_query("INSERT INTO $tabla
							 (cod_usuario, cod_rol)			
					  VALUES ($codigo, $valorX)",$cnn);       			 
			 }
		 break;


		}        
	}
		require_once('../funciones/sc_direccionar.php');  
		
*/		
?>