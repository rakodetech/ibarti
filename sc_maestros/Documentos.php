<?php
require_once('../autentificacion/aut_config.inc.php'); 
include_once('../funciones/funciones.php');
include_once('../funciones/mensaje_error.php');
mysql_select_db($bd_cnn, $cnn);

$tabla       = "documentos";
$tabla_id    = "id";
$id          = $_POST['id'];
$campo_id    = $_POST['campo_id'];
$codigo      = strtoupper($_POST['codigo']);
$descripcion = strtoupper($_POST['descripcion']);
$status      = $_POST['status'];

$usuario        = $_POST['usuario'];
$href        = $_POST['href']; 
$Nmenu       = $_POST['Nmenu'];
if (isset($_POST['metodo'])) {
   $i=$_POST['metodo'];
   
	switch ($i) {
    case Agregar:	

		 mysql_query("INSERT INTO $tabla SET
		                     $tabla_id = '$codigo',         descripcion = '$descripcion', 							 
							 status    = '1'",$cnn)or die
								 ('<br><h3>Error Consulta # 2:</h3> '.mysql_error().'<br>');
		
		 mysql_query("INSERT INTO ficha_documentos (id_trabajador, id_documento, checks, fec_us_ing,
                                                    cod_us_ing, fec_us_mod, cod_us_mod, status) 
				      SELECT ficha.ci, '$codigo', 'N', '$date', 
			  		         '$usuario', '$date', '$usuario', '1'
                        FROM ficha ",$cnn)or die
								 ('<br><h3>Error Consulta # 3:</h3> '.mysql_error().'<br>');

    break;				 
	case Modificar:  

	           mysql_query("UPDATE $tabla SET			                      
								  descripcion  = '$descripcion',	
								  status       = '$status'		                      
			                WHERE $tabla_id   = '$codigo'", $cnn);														  
	break;
	case Eliminar:

	          mysql_query("UPDATE $tabla SET
			                      status = 2
			                      WHERE $tabla_id = '$codigo'", $cnn);													  
	break;		 
	}        
}

	require_once('../funciones/sc_direccionar.php');  	 				
?>