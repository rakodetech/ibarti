<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase();
$tabla    = 'nov_procesos';
$tabla_id = 'codigo';

$codigo    = $_POST['codigo'];
$abrev     = htmlspecialchars($_POST['abrev']);
$descripcion = htmlspecialchars($_POST['descripcion']);
$activo    = statusbd($_POST['activo']);

$cod_det    = $_POST['cod_det'];
$turno      = $_POST['turno'];
$horario    = $_POST['horario'];

$href      = $_POST['href'];
$usuario   = $_POST['usuario'];
$proced    = $_POST['proced'];
$proced2   = $_POST['proced2'];
$metodo    = $_POST['metodo'];
$detalle   = $_POST['detalle'];

	if(isset($_POST['proced'])){

		 $sql    = "$SELECT $proced('$metodo', '$codigo',  '$abrev', '$descripcion',
									'$usuario',  '$activo')";
		 $query = $bd->consultar($sql);

		if($metodo != "agregar"){
			 $sql    = "$SELECT $proced2('$metodo', '$cod_det',  '$codigo', '$turno',
	                                 '$horario', '$usuario')";
		 $query = $bd->consultar($sql);
		}
	}


if ($detalle == "NO"){
	require_once('../funciones/sc_direccionar.php');
}
?>
