<?php

require("../autentificacion/aut_config.inc.php");
include_once("../" . Funcion);
require_once("../" . class_bd);
$bd = new DataBase();
$tabla    = 'ficha';

$codigo          = $_POST['codigo'];
$cod_ficha       = $_POST['cod_ficha'];
$fecha           = conversion($_POST['fecha']);
$dosis        = $_POST['dosis'];
$observacion     = htmlspecialchars($_POST['observacion']);

// $href     = $_POST['href'];

$usuario  = $_POST['usuario'];
$proced   = $_POST['proced'];
$metodo   = $_POST['metodo'];

// $href     = $_POST['href'];

if (isset($_POST['proced'])) {
	$sql    = "$SELECT $proced('$metodo', $codigo, '$cod_ficha', '$fecha',
	'$dosis', '$observacion', '$usuario')";
	$query = $bd->consultar($sql);
	echo $sql;
}
// require_once('../funciones/sc_direccionar.php');
