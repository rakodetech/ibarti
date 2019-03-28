<?php
require("../../../libs/PHPMailer/enviar.php");

	$cuentaDestino = $_POST['envio'];
	$codigo = $_POST['codigo'];
	$nombre = "IBARTI SOFTWARE";
	$tema = 'CAMBIO DE CLAVE';
	define("SPECIALCONSTANT", true);
	require  "../../../autentificacion/aut_config.inc.php";
	require_once "../../../".Funcion;
	require_once  "../../../".class_bdI;

	$datos= array();
	$bd = new Database;


	$sql = "SELECT host_smtp,puerto_smtp,protocolo_smtp,cuenta_smtp,password_smtp from control";
	$query = $bd->consultar($sql);
	$result =$bd->obtener_fila($query,0);
	
	$host =$result['host_smtp'];
	$puerto =$result['puerto_smtp'];
	$protocolo =$result['protocolo_smtp'];

	$cuentaDeEnvio=$result['cuenta_smtp'];
	$passwordCuentaDeEnvio =$result['password_smtp'];
	$cuerpo = "Su condigo de verificacion para cambio de clave es:\n ".$codigo;
	//enviar_mail_html($host,$puerto,$smtpSecure,$cuentaDeEnvio,$passwordCuentaDeEnvio,$nombre,$tema,$cuerpo,$cuerpoHtml,$cuentaDestino)
	enviar_mail_html($host,$puerto,$protocolo,$cuentaDeEnvio,$passwordCuentaDeEnvio,$nombre,$tema,"",$cuerpo,$cuentaDestino);

?>