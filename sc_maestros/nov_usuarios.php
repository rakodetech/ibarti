<?php
require_once('../autentificacion/aut_config.inc.php'); 
include_once('../funciones/funciones.php');
include_once('../funciones/mensaje_error.php');
mysql_select_db($bd_cnn, $cnn);

$tabla    = 'nov_usuarios';
$tabla_id = 'codigo';

$codigo         = $_POST['codigo']; 
$usuarios       = $_POST['usuarios'];
$usuario        = $_POST['usuario'];

$href           = $_POST['href'];

$mensaje = "";

if (isset($_POST['metodo'])) {
	$i=$_POST['metodo'];
	switch ($i) {

	case 'renglones':    	

			 mysql_query ("DELETE FROM $tabla WHERE $tabla.cod_novedad = '$codigo'",$cnn); 


			 foreach ($usuarios as $valorX){	

				 mysql_query("INSERT INTO $tabla 
							 (cod_novedad, cod_usuario)			
					  VALUES ('$codigo', '$valorX')",$cnn) or die
						 ('<br><h3>Error Consulta # 1:</h3> '.mysql_error().'<br>');			 
			 }		
	break;			  
	case 'borrar':    
	begin();
		mysql_query ("DELETE FROM $tabla WHERE  $tabla_id = '$id'", $cnn);  
		$mensaje = "Registro Borrado";												 
	}        
}
require_once('../funciones/sc_direccionar.php');  
?>