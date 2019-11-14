<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase();
$tabla    = 'ficha';

$codigo      = $_POST['codigo'];
$fecha       = conversion($_POST['fecha']);
$cliente     = $_POST['cliente'];
$ubicacion   = $_POST['ubicacion'];
$cargo       = $_POST['cargo'];
$turno       = $_POST['turno'];

$importe     = $_POST['importe'];
$observacion = $_POST['observacion'];

$href        = $_POST['href'];
$usuario     = $_POST['usuario']; 
$proced      = $_POST['proced'];
$metodo      = $_POST['metodo'];

$href        = $_POST['href'];

if(isset($_POST['proced'])){

   $sql    = "$SELECT $proced('$metodo', '$codigo', '$fecha', '$cliente',
                                    '$ubicacion', '$cargo', '$turno', '$importe', 
									'$observacion',
							        '$usuario')";						  
	 $query = $bd->consultar($sql);	 
	}
require_once('../funciones/sc_direccionar.php');  	 
?>