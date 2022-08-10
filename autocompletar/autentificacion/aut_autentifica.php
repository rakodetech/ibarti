<?php
session_start(); 
//(require("aut_verifica.inc1.php");
require("aut_verifica.inc.php");
require("aut_mensaje_error.inc.php");

if (isset($_GET['error_login'])){
	echo "<script language='javascript'>
			alert('Error: ".$error_login_ms[$error]."');
	</script>";
} 

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

if ($_SESSION['dias_caduca'] > 90){
    $cad = (95-($_SESSION['dias_caduca']));  
   echo '<script language="javascript">
        alert("Cambien la Clave Y Salga y vuelva entra al Sistema. Se Bloqueara el Usuario en '.$cad.' Dias ");	
	</script>';	

if($_GET['Nmenu']!= '102'){
	   echo '<script language="javascript">
		location.href="inicio.php?area=autentificacion/cambiar_Clave&Nmenu=102";
		</script>';		
	}
}
?>