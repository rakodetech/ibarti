<?php
require_once('../autentificacion/aut_config.inc.php'); 
include_once('../funciones/funciones.php');
include_once('../funciones/mensaje_error.php');
mysql_select_db($bd_cnn, $cnn);

$tabla       = "cont_clientes";
$tabla_id    = "codigo";

$codigo      = strtoupper($_POST['codigo']);
$campo_id    = $_POST['campo_id'];

$estado      = $_POST['estado'];
$municipio   = $_POST['municipios'];
$descripcion = strtoupper($_POST['descripcion']);
$direccion   = $_POST['direccion'];
$telefono    = $_POST['telefono'];
$clasif      = $_POST['clasif'];
$usuario     = $_POST['usuario'];
$status      = $_POST['status'];
$href        = $_POST['href']; 

if (isset($_POST['metodo'])) {
   $i=$_POST['metodo'];
   
	switch ($i) {
    case Agregar:	
	 
		       mysql_query("INSERT INTO $tabla SET 			 
								   $tabla_id   = '$codigo',       cod_cont_clasif  = '$clasif', 
								   id_dpt1     = '$estado',       id_dpt2        = '$municipio',
								   descripcion = '$descripcion',  direccion = '$direccion',
								   telefono    = '$telefono',     
								   cod_us_ing  = '$usuario',      fec_us_ing  = '$date',
								   cod_us_mod  = '$usuario',      fec_us_mod  = '$date',
								   `status`    = '$status'",$cnn);          	
    break;				 
	case Modificar:  
	
		   mysql_query("UPDATE $tabla SET
                                   cod_cont_clasif  = '$clasif', 
								   id_dpt1     = '$estado',       id_dpt2        = '$municipio',
								   descripcion = '$descripcion',  direccion = '$direccion',
								   telefono    = '$telefono',     
								   cod_us_ing  = '$usuario',      fec_us_ing  = '$date',
								   cod_us_mod  = '$usuario',      fec_us_mod  = '$date',
								   `status`    = '$status'
			  		   WHERE $tabla_id   = '$codigo'", $cnn) or die
								 ('<br><h3>Error Consulta # 3:</h3> '.mysql_error().'<br>');														  
	break;
	case Eliminar:

	          mysql_query("UPDATE $tabla SET
			                      status = 2
			                      WHERE $tabla_id = '".$campo_id."'", $cnn);													  
	break;		 
	}        
}
	require_once('../funciones/sc_direccionar.php');  	 				
?>