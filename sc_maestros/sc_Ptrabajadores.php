<?php
require_once('../autentificacion/aut_config.inc.php'); 
include_once('../funciones/funciones.php');
include_once('../funciones/mensaje_error.php');
mysql_select_db($bd_cnn, $cnn);
  
$tabla   = 'trabajadores';
$codigo  = $_POST['codigo'];
$Nmenu   = $_POST['Nmenu'];
if (isset($_POST['archivo'])) {
 $i=$_POST['archivo'];
	switch ($i) {
    case agregar:	

	$query01 = mysql_query("SELECT cod_emp FROM $tabla WHERE cod_emp = '$codigo'",$cnn);
		if (mysql_num_rows($query01)==0){
	
		  echo '<script language="javascript">	  
			window.opener.location.href="../inicio.php?area=maestros/Add_trabajadores&codigo='.$codigo.'&Nmenu='.$Nmenu.'"; 	
			window.close(); 
			</script>';			 

		}else{

			   echo'<script language="javascript">
						alert("Ya Se Registro Un Trabajador Con El Codigo: '.$codigo.'");   
						window.close(); 
					</script>';	
	
		} 			 
	    break;	 
	}        
}
	if (mysql_errno($cnn)==0){
	
//	commit();	
/*     echo '<script language="javascript">
	       location.href="'.$href.'";
	       </script>';		    
*/	 
	 }else{

	 	$Nerror = mysql_errno($cnn);
		$Derror = mysql_error($cnn);

		mensajeria("".Errror_Ms($Nerror, $Derror)."");
//		rollback();
/*     echo '<script language="javascript">
	       location.href="'.$href.'";
	       </script>';		    
*/	 }
mysql_close($cnn);	 
?>