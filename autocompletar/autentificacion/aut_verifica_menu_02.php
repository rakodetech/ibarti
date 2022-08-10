<?php
    $fechaGuardada = $_SESSION["ultimoAcceso"];
    $ahora = date("Y-n-j H:i:s");
    $tiempo_transcurrido = (strtotime($ahora)-strtotime($fechaGuardada));
    //comparamos el tiempo transcurrido
     if($tiempo_transcurrido >= 600) {
		
	 // descoloco todas la variables de la sesión
	 session_unset();
	
	 // Destruyo la sesión
	 session_destroy();
	
	 $vinc = Sitio."/".Carpeta."/";
	 //Y me voy al inicio 
		 Redirec("$vinc");
	
		 echo "<html></html>";
	   exit;	 
		 
     //si pasaron 10 minutos o más
//      session_destroy(); // destruyo la sesión
//     header("Location: index.php"); //envío al usuario a la pag. de autenticación

      //sino, actualizo la fecha de la sesión
    }else {
    $_SESSION["ultimoAcceso"] = $ahora;
   }

if((!$_SESSION['usuario_cod']) or ($_SESSION['captcha']== "")){	 	 
	   echo '<script language="javascript">
	   		alert("Acceso Denegado, No puede Ingresar a Esta Pagina ...");	
		</script>';


	 session_unset();
	
	 // Destruyo la sesión
	 session_destroy();
	
	 $vinc = Sitio."/".Carpeta."/";
	 //Y me voy al inicio 
		 Redirec("$vinc");
	
		 echo "<html></html>";
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