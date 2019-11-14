<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase();

$tabla    = 'nov_perfiles';
$tabla_id = 'cedula';

$codigo	  = $_POST['codigo'];
$perfil   = $_POST['perfil'];	
$href     = $_POST['href'];
$usuario  = $_POST['usuario']; 

$metodo   = $_POST['metodo'];

	if (isset($_POST['metodo'])) {
	$i=$_POST['metodo'];
		switch ($i) {
  			   	
		case 'actualizar':

		$sql = "DELETE FROM $tabla WHERE nov_perfiles.cod_nov_clasif = '$codigo'";
				  
		    $query = $bd->consultar($sql);	
		 foreach($perfil as $valorX){
			$sql = "INSERT INTO nov_perfiles
					 (cod_nov_clasif, cod_perfil)			
			  VALUES ('$codigo', '$valorX')";	
					  
		    $query = $bd->consultar($sql);			 
		 }			
		break;					

		}        
	}
		require_once('../funciones/sc_direccionar.php');  
?>