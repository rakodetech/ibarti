<?php
session_start(); 
require("aut_verifica.inc.php");
require("aut_mensaje_error.inc.php");

if (isset($_GET['error_login'])){
	echo "<script language='javascript'>
			alert('Error: ".$error_login_ms[$error]."');
	</script>";
} 
/*
if (isset($_GET['nivel'])){
	$_SESSION['perfil'] = $_GET['nivel'];
}
 
if ($nivel_acceso > $_SESSION['perfil']){

   echo '<script language="javascript">
        alert("Acceso Denegado, No puede Ingresar a Esta Pagina ...");
		location. href="'.$redir.'";
	</script>';
	exit;
}
*/
?>