<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase(); 

//$codigo         = $_POST['codigo']; 
$fecha         = conversion($_POST['fecha_recep']);
$cliente        = $_POST['cliente'];
$representante  = htmlentities($_POST['representante']);
$cargo          = htmlentities($_POST['cargo']);
$telefono       = htmlentities($_POST['telefono']); 
$email          = htmlentities($_POST['email']); 
$descripcion    = htmlentities($_POST['descripcion']); 
$prioridad      = $_POST['prioridad'];
$tipo_contacto  = $_POST['tipo_contacto'];
$requerimiento  = $_POST['requerimiento'];
$status_negocio = $_POST['status_negocio'];
$status_contacto = $_POST['status_contacto'];

$campo01       = $_POST['campo01'];
$campo02       = $_POST['campo02'];
$campo03       = $_POST['campo03'];
$campo04       = $_POST['campo04'];

$href     = $_POST['href'];
$usuario  = $_POST['usuario']; 
$proced   = $_POST['proced'];
$metodo   = $_POST['metodo'];

$i = $_POST['metodo'];

//  PROBLEMAS CON LA FECHA EN APERTURA DE FECHA

if (isset($_POST['metodo'])) {
	
	$sql    = " DELETE FROM cont_proceso_req WHERE  cod_fecha = '$fecha' AND cod_cont_cliente = '$cliente' ";
	$query  = $bd->consultar($sql);
	$datos  = $bd->obtener_fila($query,0);	

	 foreach($requerimiento as $valorX){	

		$sql    = " INSERT INTO cont_proceso_req SET
						   cod_fecha     = '$fecha',   cod_cont_cliente   = '$cliente',
						   cod_cont_tipo_req = '$valorX' ";
		$query  = $bd->consultar($sql);

	 }

	$sql    = "$SELECT $proced('$metodo', '$fecha', '$cliente', '$representante', 
	                           '$cargo', '$telefono', '$email', '$descripcion',
							   '$prioridad', '$tipo_contacto', '$status_negocio', '$status_contacto',
							   '$campo01', '$campo02', '$campo03', '$campo04',							   
							   '$usuario')";						  
	 $query = $bd->consultar($sql);	       
}

require_once('../funciones/sc_direccionar.php');  
?>