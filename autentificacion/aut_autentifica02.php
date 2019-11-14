<?php
// session_start(); 
// require("aut_verifica.inc.php");
require("aut_mensaje_error.inc.php");
$bd = new DataBase();
	
	$usuario =  $_SESSION['usuario_cod'];

	$sql = "SELECT men_usuarios.ip, men_usuarios.captcha
			  FROM men_usuarios 
			 WHERE men_usuarios.codigo = '$usuario' ";
    $query = $bd->consultar($sql);
	$datos = $bd->obtener_fila($query,0);

if ($_SESSION['ip']<> $datos[0]){
	echo "<script language='javascript'>
			alert('Error: ".$error_login_ms[5]."');
	</script>";
	require("aut_logout.php");	
} 

if ($_SESSION['captcha']<> $datos[1]){
	echo "<script language='javascript'>
			alert('Error: ".$error_login_ms[5]."');
	</script>";
	require("aut_logout.php");	
} 

	$fechaGuardada = $_SESSION["ultimoAcceso"];
	$ahora = date("Y-n-j H:i:s");
	$tiempo_transcurrido = (strtotime($ahora)-strtotime($fechaGuardada));
	
	//comparamos el tiempo transcurrido
	 if($tiempo_transcurrido >= 600) {
	 //si pasaron 10 minutos o más
	echo "<script language='javascript'>
				alert('Error: ".$error_login_ms[11]."');
		</script>";
	require("aut_logout.php");	
	}else {
	$_SESSION["ultimoAcceso"] = $ahora;
	}
?>