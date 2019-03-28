<?php
require_once('../autentificacion/aut_config.inc.php'); 
include_once('../funciones/funciones.php');
include_once('../funciones/mensaje_error.php');
mysql_select_db($bd_cnn, $cnn);

$tabla        = 'trabajadores';
$tabla_id     = 'cod_emp';

$codigo       = $_POST['codigo'];
$cedula       = $_POST['cedula']; 
$nombre       = htmlentities(strtoupper($_POST['nombre']));
$sexo         = $_POST['sexo'];
$telefono     = $_POST['telefono'];
$contracto    = $_POST['contracto'];
$region       = $_POST['region'];
$fecha_nac    = Rconversion($_POST['fecha_nac']);
$fecha_ing    = Rconversion($_POST['fecha_ing']);

$status       = $_POST['status'];			  
$href         = $_POST['href'];

if (isset($_POST['archivo'])) {
	 $i=$_POST['archivo'];
	switch ($i) {
    case agregar:   
	 	 begin();	
		 $query01 = mysql_query(" SELECT control.eventuales +1 FROM control ", $cnn);
         $row01   = mysql_fetch_array($query01);
         $status = 'A';
		 $codigo = $row01[0];
		 	     mysql_query("UPDATE control SET eventuales = '$codigo'", $cnn); 	
		            
		 mysql_query("INSERT INTO $tabla  SET 		                  
		                     cod_emp   = 'E$codigo',    ci   = '$cedula',
						     nombres   = '$nombre',    sexo = '$sexo',
						     telefonos = '$telefono',  co_cont = '$contracto',
							 id_region = '$region',    fecha_nac = '$fecha_nac',
                             fecha_ingreso = '$fecha_ing', `status` = '$status'",$cnn)or die
								 ('<br><h3>Error Consulta # 2:</h3> '.mysql_error().'<br>');

	break; 	
	case modificar:    
		 begin();	 	
	
      mysql_query("UPDATE $tabla SET   
                             ci        = '$cedula',
						     nombres   = '$nombre',    sexo = '$sexo',
						     telefonos = '$telefono',  co_cont = '$contracto',
							 id_region = '$region',    fecha_nac = '$fecha_nac',
                             fecha_ingreso = '$fecha_ing', `status` = '$status'				
	  		     WHERE  $tabla_id = '$codigo'", $cnn);


	break; 		 	 
	case eliminar:    
	     begin();
	     mysql_query("UPDATE $tabla SET
			                      status = 2
			                      WHERE $tabla_id = '$id'", $cnn); 	
	break;	 

	case borrar:    
	     begin();

		mysql_query ("DELETE FROM $tabla WHERE  $tabla_id = '$id'", $cnn);  
		$mensaje = "Registro Borrado";												 
	}        
}
require_once('../funciones/sc_direccionar.php');  
?>