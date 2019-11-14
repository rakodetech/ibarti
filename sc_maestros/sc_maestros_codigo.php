<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
</head>
<?php
require_once('../autentificacion/aut_config.inc.php'); 
include_once('../funciones/funciones.php');
include_once('../funciones/mensaje_error.php');
mysql_select_db($bd_cnn, $cnn);
mysql_query("SET NAMES 'utf8'");
$tabla_id    = 'codigo';
$tabla       = $_POST['tab'];

$codigo      = strtoupper($_POST['codigo']);
$codigo_old  = strtoupper($_POST['codigo_old']);
$descripcion = strtoupper($_POST['descripcion']);
$campo01     = strtoupper($_POST['ad01']);
$campo02     = strtoupper($_POST['ad02']);
$campo03     = strtoupper($_POST['ad03']);
$campo04     = strtoupper($_POST['ad04']);
$campo05     = strtoupper($_POST['ad05']);
$campo06     = strtoupper($_POST['ad06']);

$usuario     = $_POST['usuario']; 
$href        = $_POST['href'];
$status      = $_POST['status'];

if (isset($_POST['metodo'])) {
   $i=$_POST['metodo'];

	switch ($i) {
    case Agregar:
	 	begin();

              mysql_query("INSERT INTO $tabla SET 			  
		                          $tabla_id  = '$codigo',      descripcion = '$descripcion', 
						          campo01    = '$campo01',     campo02     = '$campo02', 
							      campo03    = '$campo03',     campo04     = '$campo04',  
							      campo05    = '$campo05',     campo06     = '$campo06',
							      cod_us_ing = '$usuario',     fec_us_ing  = '$date',
								  status     = '$status'", $cnn);
     break;		
	 case Modificar:  
	 	  begin();
			
	           mysql_query("UPDATE $tabla SET 			  
		                          $tabla_id  = '$codigo',      descripcion = '$descripcion', 
						          campo01    = '$campo01',     campo02     = '$campo02', 
							      campo03    = '$campo03',     campo04     = '$campo04',  
							      campo05    = '$campo05',     campo06     = '$campo06',
							      cod_us_mod = '$usuario',     fec_us_mod  = '$date',
								  status     = '$status'
						   WHERE $tabla_id = '$codigo_old'",$cnn);
														  
	break;
	case Eliminar:  
		 begin();  	 

	          mysql_query("UPDATE $tabla SET
			                      status = 2,
								  cod_us_mod  = '$usuario',  fec_us_mod = '$date'
			                      WHERE $tabla_id = '$codigo'", $cnn);	
								  												  
	break;	
	
	case Borrar:  
		 begin();  	 

		mysql_query ("DELETE FROM $tabla WHERE  $tabla_id = '$codigo'", $cnn);  
		$mensaje = "Registro Borrado";												  

	break;			
	case Borrar2:  
		 begin();  	 
		mysql_query ("DELETE FROM $tabla WHERE  $tabla_id = '$codigo' AND  $campoXR  = '$campoXV'", $cnn);  
		$mensaje = "Registro Borrado";												  
	break;			 
	}        
}

	if (mysql_errno($cnn)==0){
	commit();	

	    echo '<input type="hidden" id="mensaje_aj" value="'.$mensaje.'"/>';						   
     echo '<script language="javascript">
	       location.href="'.$href.'";
	       </script>';		    

	 }else{

	 	$Nerror = mysql_errno($cnn);
		$Merror = mysql_error($cnn);
		rollback();
		mensajeria("".Errror_Ms($Nerror, $Merror)."");
	 echo '<input type="hidden" id="mensaje_aj" value="Error en proceso '.Errror_Ms($Nerror, $Merror).'"/>';
	 echo '<script language="javascript">
			   location.href="'.$href.'";
			   </script>';	
	 } 
mysql_close($cnn); 	 
?>
<body>
</body>
</html>