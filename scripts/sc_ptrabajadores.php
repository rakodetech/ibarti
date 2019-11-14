<?php
include_once('../conexiones/conexion.php');
include_once('../funciones/funciones.php');
include_once('../funciones/mensaje_error.php');
$tabla   = 'trabajadores';
$cedula  = $_POST['cedula'];

if (isset($_POST['archivo'])) {
 $i=$_POST['archivo'];
	switch ($i) {
    case agregar:	
		 begin();
	$sql = "SELECT cedula FROM $tabla WHERE cedula = '$cedula'"; // ID //
	$result = mysql_query($sql,$cnn);
		if (mysql_num_rows($result)==0){		
	
		  echo '<script language="javascript">	  
			window.opener.location.href="../inicio.php?area=formularios/Add_Trabajadores&codigo='.$cedula.'"; 	
			window.close(); 
			</script>';	
		 
	
		}else{
			   echo '<script language="javascript">
			alert("Ya Se Registro Un Trabajador Con El Código:'.$cedula.'");   
			window.close(); 
			</script>';	
		} 			 
	    break;	 
	}        
}
	require_once('../funciones/sc_direccionar.php');  	 						
?>