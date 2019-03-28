<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase();

$usuario   = $_POST['usuario'];	
$contracto = $_POST["contracto"];					
$apertura_cod  = $_POST['apertura_cod'];

$usuario   = $_POST['usuario'];
$href      = $_POST['href'];

$i=$_POST['metodo'];
if (isset($_POST['metodo'])) {
	switch ($i){
	case 'apertura':    	 
	
		 $sql = "UPDATE asistencia_apertura  SET   asistencia_apertura.apertura  = 'N'             
                  WHERE asistencia_apertura.cod_contracto = '$contracto' "; 
		 $query = $bd->consultar($sql);   

		 foreach ($apertura_cod  as $valorX){  // $valorX  fehcha_ingreso	
		 $sql = "UPDATE asistencia_apertura  SET   asistencia_apertura.apertura  = 'S'             
                  WHERE asistencia_apertura.cod_contracto = '$contracto'
                    AND   asistencia_apertura.codigo = '$valorX'";    
		 $query = $bd->consultar($sql);					
		}	
	break;	
	}
}	

	require_once('../funciones/sc_direccionar.php');  	 					
?>