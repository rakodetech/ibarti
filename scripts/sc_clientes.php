<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase();
//include_once('../funciones/mensaje_error.php');
$tabla    = $_POST['tabla'];
$tabla_id = 'codigo';

$codigo  = htmlentities($_POST["codigo"]);
$abrev       = $_POST["abrev"];
$cl_tipo     = $_POST["cl_tipo"];
$region        = $_POST["region"];

$vendedor   = $_POST["vendedor"];
$rif         = $_POST["rif"];
$nit         = $_POST["nit"];
$nombre      = $_POST["nombre"];
$telefono    = $_POST["telefono"];
$fax         = $_POST["fax"];
$direccion   = $_POST["direccion"];

$email       = $_POST["email"];
$website     = $_POST["website"];
$contacto    = $_POST["contacto"];
$observ      = $_POST["observ"];


$dir_entrega = $_POST["dir_entrega"];
$limite_cred = $_POST["limite_cred"];
$plazo_pago = $_POST["plazo_pago"];
$desc_global = $_POST["desc_global"];
$desc_p_pago = $_POST["desc_p_pago"];
$lunes   = statusbd($_POST["lunes"]);
$martes   = statusbd($_POST["martes"]);
$miercoles = statusbd($_POST["miercoles"]);
$jueves  = statusbd($_POST["jueves"]);
$viernes = statusbd($_POST["viernes"]);
$sabado  = statusbd($_POST["sabado"]);
$domingo = statusbd($_POST["domingo"]);

/*
$dir_entrega = "";
$limite_cred = "";
$plazo_pago  = "";
$desc_global = "";
$desc_p_pago = "";
*/
$campo01 = $_POST["campo01"];
$campo02 = $_POST["campo02"];
$campo03 = $_POST["campo03"];
$campo04 = $_POST["campo04"];

$juridico    = statusbd($_POST["juridico"]);
$contrib    = statusbd($_POST["contrib"]);
$activo      = statusbd($_POST["activo"]);

$href     = $_POST['href'];
$usuario  = $_POST['usuario'];
$proced   = $_POST['proced'];
$metodo   = $_POST['metodo'];
	if(isset($_POST['proced'])){
		
 	 $sql    = "$SELECT $proced('$metodo', '$codigo', '$cl_tipo', '$vendedor',
	                            '$region', '$abrev', '$rif', '$nit',
								'$nombre', '$telefono', '$fax', '$direccion',
								'$dir_entrega', '$email', '$website', '$contacto',
								'$observ',
								'$juridico', '$contrib', '$lunes', '$martes',
								'$miercoles', '$jueves', '$viernes', '$sabado',
								'$domingo', '$limite_cred', '$plazo_pago', '$desc_global',
								'$desc_p_pago',
								'$campo01', '$campo02', '$campo03', '$campo04', '$usuario',  '$activo')";
	 $query = $bd->consultar($sql);
	}
require_once('../funciones/sc_direccionar.php');
?>
