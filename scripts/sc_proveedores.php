<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
</head>
<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase();
//include_once('../funciones/mensaje_error.php');
$tabla    = $_POST['tabla'];
$tabla_id = 'codigo';

$codigo  = htmlentities($_POST["codigo"]);
$prov_tipo     = $_POST["prov_tipo"];		
$zona        = $_POST["zona"];		
$estados       = $_POST["estados"];
$ciudad       = $_POST["ciudad"];
$rif         = $_POST["rif"];
$nit         = $_POST["nit"];
$nombre      = $_POST["nombre"];
$telefono    = $_POST["telefono"];
$fax         = $_POST["fax"];
$direccion   = $_POST["direccion"];
$email       = $_POST["email"];
$website     = $_POST["website"];
$contacto    = $_POST["contacto"];
$dias_credito = $_POST["dias_credito"];
$lim_credito = $_POST["lim_credito"];
$plazo_pago = $_POST["plazo_pago"];
$desc_global = $_POST["desc_global"];
$desc_pago = $_POST["desc_pago"];
$campo01 = $_POST["campo01"];
$campo02 = $_POST["campo02"];
$campo03 = $_POST["campo03"];
$campo04 = $_POST["campo04"];

$nacional    = statusbd($_POST["nacional"]);
$activo      = statusbd($_POST["activo"]);

$href     = $_POST['href'];
$usuario  = $_POST['usuario']; 
$proced   = $_POST['proced'];
$metodo   = $_POST['metodo'];
	if(isset($_POST['proced'])){

	 $sql    = "$SELECT $proced('$metodo',  '$codigo', '$prov_tipo',  '$zona',
                               '$estados', '$ciudad', '$rif', '$nit',  
							   '$nacional', '$nombre', '$telefono', '$fax',
							   '$direccion', '$email', '$website', '$contacto',
							   '$dias_credito', '$lim_credito', '$plazo_pago', '$desc_global',
							   '$desc_pago',                                        
                               '$campo01', '$campo02', '$campo03', '$campo04', '$usuario',  '$activo')";						  
	 $query = $bd->consultar($sql);	  			   		

	}
 require_once('../funciones/sc_direccionar.php');  
?>
<body>
</body>
</html>