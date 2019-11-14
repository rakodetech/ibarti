<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
</head>
<body>
<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase();
//include_once('../funciones/mensaje_error.php');

$tabla_id = 'codigo';
$codigo   = $_POST["codigo"];

$psi_apto        = $_POST["psi_apto"];
$psic_observacion = htmlspecialchars($_POST["psic_observacion"]);
$status   = $_POST["status"];

 	 $sql    = "SELECT control.preingreso_nuevo, control.preingreso_apto, 
	                   control.preingreso_aprobado, control.preingreso_rechazado
                  FROM control";						  
	$query     = $bd->consultar($sql);	
	$result    = $bd->obtener_fila($query,0); 
	$nuevo     = $result['preingreso_nuevo']; 
	$aprobado  = $result['preingreso_aprobado']; 
	$apto      = $result['preingreso_apto']; 
	$rechazado = $result['preingreso_rechazado'];
	
	if($psi_apto == 'N'){
		$status =  $rechazado;	
	}
		
$href     = $_POST['href'];
$usuario  = $_POST['usuario']; 
$proced   = $_POST['proced'];
$metodo   = $_POST['metodo'];

	if(isset($_POST['proced'])){
	 $sql    = "$SELECT $proced('$metodo', '$codigo', '$psi_apto', '$psic_observacion',
	                            '$usuario',  '$status')";						  
	 $query = $bd->consultar($sql);	  			   		
	}
 require_once('../funciones/sc_direccionar.php');  
?>
</body>
</html>