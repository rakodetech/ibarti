<?php
require_once('../autentificacion/aut_config.inc.php'); 
include_once('../funciones/funciones.php');
include_once('../funciones/mensaje_error.php');
mysql_select_db($bd_cnn, $cnn);

$tabla       = "productos";
$tabla_id    = "codigo";

$codigo      = $_POST['codigo'];
$clasif      = $_POST['clasif'];
$usuario     = $_POST['usuario'];   

$status      = $_POST['status'];
$href        = $_POST['href'].''; 
$Nmenu       = $_POST['Nmenu'];
if (isset($_POST['metodo'])) {
   $i=$_POST['metodo'];
   
	switch ($i) {
	
	case renglones:    	 
			$query03 = mysql_query("SELECT productos.codigo, productos.descripcion, productos.existencia
                                      FROM productos 
									 WHERE productos.`status` = 1 
									   AND productos.cod_prod_clasif = '$clasif'
									 ORDER BY 2 ASC ",$cnn) or die
				 ('<br><h3>Error Consulta # 1:</h3> '.mysql_error().'<br>');

			while($row03 = mysql_fetch_array($query03)){
				
				$variable =  $row03[0];
				$valor    = $_POST[$variable];				
						
			  mysql_query("UPDATE $tabla SET
			  					  existencia  = '$valor',
							      cod_us_mod  = '$usuario', 
								  fec_us_mod  = '$date'   								  
							WHERE codigo      = '$variable'",$cnn); 
					}		
	break;	  
	}        
}
	require_once('../funciones/sc_direccionar.php');  	 				
?>