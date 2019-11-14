<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase();
$tabla    = 'nov_procesos';
$tabla_id = 'codigo';

$codigo    = $_POST['codigo']; 
$nombre    = htmlspecialchars($_POST['nombre']);
$abrev     = htmlspecialchars($_POST['abrev']);
$turno_tipo     = $_POST['turno_tipo'];
$horario   = $_POST['horario']; 
$factor    = $_POST['factor']; 
$trab_cubrir = $_POST['trab_cubrir']; 
$fec_inic  = conversion($_POST['fec_inic']);
$fec_fin   = conversion($_POST['fec_fin']);
$activo    = statusbd($_POST['activo']);
$dia       = $_POST['DIA'];

$href      = $_POST['href'];
$usuario   = $_POST['usuario']; 
$proced    = $_POST['proced'];
$proced2   = $_POST['proced2'];
$metodo    = $_POST['metodo'];

	if(isset($_POST['proced'])){

 	 $sql    = "$SELECT $proced('$metodo', '$codigo', '$turno_tipo', '$horario', 
	                            '$abrev', '$nombre', '$fec_inic', '$fec_fin', 
								'$factor', '$trab_cubrir', '$usuario',  '$activo')";						  
	 $query = $bd->consultar($sql);	  			   		

		if(isset($_POST['proced2'])){
        $sql   = "DELETE FROM turno_det WHERE cod_turno = '$codigo'";						  
	    $query = $bd->consultar($sql);	
			foreach ($dia as $valorX){				
			$sql = "INSERT INTO turno_det (cod_turno, dias)			
								   VALUES ('$codigo', '$valorX')";						  
	    	$query = $bd->consultar($sql);	
			}
		}
	}
require_once('../funciones/sc_direccionar.php');  
?>