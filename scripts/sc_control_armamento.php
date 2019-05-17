<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase();
$tabla    = 'nov_procesos';
$tabla_id = 'codigo';

$codigo         = $_POST['codigo']; 
$producto       = $_POST['producto']; 
$cliente        = $_POST['cliente'];
$ubicacion      = $_POST['ubicacion'];
$fec_entrega    = conversion($_POST['fec_entrega']);
$fec_retiro     = conversion($_POST['fec_retiro']);
$motivo         = htmlentities($_POST['motivo']); 
$observacion    = htmlentities($_POST['observacion']); 

$campo01        = $_POST['campo01'];
$campo02        = $_POST['campo02'];
$campo03        = $_POST['campo03'];
$campo04        = $_POST['campo04'];
$activo    = statusbd($_POST['activo']);

$href     = $_POST['href'];
$usuario  = $_POST['usuario']; 
$proced   = $_POST['proced'];
$metodo   = $_POST['metodo'];

if($activo == "F"){	

	if($motivo != "" or $fec_retiro != ""){ 

	}else{
	$mensaje = "Debe De Ingresar Lo Siguiente: Fecha de Retiro y Motivo";
	echo '<script language="javascript">
	    alert("'.$mensaje.'");
		</script>';				    
		$activo = "T";
	}
}
	if(isset($_POST['proced'])){
   	 $sql    = "$SELECT $proced('$metodo', '$codigo', '$producto','$cliente',
	                            '$ubicacion', '$fec_entrega', '$fec_retiro', '$motivo', '$observacion',
                                '$campo01', '$campo02', '$campo03', '$campo04', '$usuario', '$activo')";						  
	 $query = $bd->consultar($sql);	 
	}
require_once('../funciones/sc_direccionar.php');  
?>