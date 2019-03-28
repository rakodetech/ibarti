<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);


$bd = new DataBase();


$cedula     = $_POST['cedula'];
$cedula_old = $_POST['cedula_old'];
$huella     = $_POST['huella'];
$huella_old = $_POST['huella_old'];

$href     = $_POST['href'];
$proced   = $_POST['proced'];
$metodo   = $_POST['metodo'];
$usuario  = $_POST['usuario'];

if(isset($_POST['proced'])){

		if($metodo == "eliminar"){
		$sql    = " SELECT clientes_ub_ch.cod_capta_huella FROM clientes_ub_ch ";
		$query = $bd->consultar($sql);
			while($datos=$bd->obtener_fila($query,0)){
			$capta_huella  = $datos[0];
			$sql02    = "$SELECT p_ch_huella_delete('$huella', '$capta_huella')";
			$query02 = $bd->consultar($sql02);
			}
		 $sql    = "$SELECT $proced('$metodo', '$cedula', '$cedula_old', '$huella', '$huella_old', '$usuario')";
		 $query = $bd->consultar($sql);

		}else{
		 $sql    = "$SELECT $proced('$metodo', '$cedula', '$cedula_old', '$huella', '$huella_old', '$usuario')";
		 $query = $bd->consultar($sql);
		}
	}
	echo " Se Actualizo: Cedula : $cedula, Huella: $huella ";

//	require_once('../funciones/sc_direccionar.php');
?>
