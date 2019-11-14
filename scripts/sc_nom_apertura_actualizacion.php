<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase();

$co_cont   = $_POST['co_cont']; 
$rol      = $_POST['rol']; 			  
$href     = $_POST['href'];
$usuario  = $_POST['usuario']; 
$proced   = $_POST['proced'];
$metodo   = $_POST['metodo'];

$href     = $_POST['href'];

if(isset($_POST['proced']) && ($rol !="")){

 	 $sql   = "$SELECT $proced('$metodo', '$co_cont', '$rol', '$usuario')";						  
	 $query = $bd->consultar($sql);	 

	 $mensaje = "SE APERTURO EL CONTRATO ";	
	}else{
	$mensaje = "DEBE SELECCIONAR UN ROL ";	
	}

     echo '<script language="javascript">
	      alert("'.$mensaje.'");
	       </script>';
	require_once('../funciones/sc_direccionar.php');  	
?>