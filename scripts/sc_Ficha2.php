<?php
require_once('../autentificacion/aut_config.inc.php'); 
include_once('../funciones/funciones.php');
include_once('../funciones/mensaje_error.php');
mysql_select_db($bd_cnn, $cnn);
$tabla          = 'ficha_uniforme';
$tabla2         = 'ficha_familia';
$tabla3         = 'ficha_egreso';
$tabla_id       = 'id_ci';
$Nmenu          = $_POST['Nmenu'];
$codigo         = $_POST['codigo'];
$cod_emp        = strtoupper($_POST['cod_emp']);
$t_pantalon     = $_POST['t_pantalon'];
$t_camisa       = $_POST['t_camisa'];
$n_zapato       = $_POST['n_zapato'];
$fec_dotacion   = Rconversion($_POST['fec_dotacion']);
$codigo_fam      = strtoupper($_POST['codigo_fam']);
$codigo_old    = $_POST['codigo_old'];
$nombre       = htmlentities(strtoupper($_POST['nombre']));
$fec_nac      = Rconversion($_POST['fec_nac']);
$sexo         = strtoupper($_POST['sexo2']);
$parentesco   = htmlentities(strtoupper($_POST['parentesco']));

$fec_egreso       = Rconversion($_POST['fec_egreso']); 
$motivo           = $_POST['motivo'];      
$preaviso         = $_POST['preaviso'];
$fec_inicio       = Rconversion($_POST['fec_inicio']);
$fec_culminacion  = Rconversion($_POST['fec_culminacion']);
$fec_calculo      = Rconversion($_POST['fec_calculo']);
$fec_pago         = Rconversion($_POST['fec_pago']);
$cheque           = $_POST['cheque'];
$banco            = htmlentities(strtoupper($_POST['banco']));
$importe          = $_POST['importe'];
$entrega_uniforme = $_POST['entrega_uniforme'];
$observacion      =  htmlentities(strtoupper($_POST['observacion']));
$observacion2     =  htmlentities(strtoupper($_POST['observacion2']));
$status         = $_POST['status'];			  
$href           = $_POST['href'];


if (isset($_POST['archivo'])) {
	$i=$_POST['archivo'];

	switch ($i) {

	case 'actualizar':          

      mysql_query("UPDATE $tabla SET   					
						t_pantalon       = '$t_pantalon',   t_camisa     = '$t_camisa',   
						n_zapato         = '$n_zapato',     fec_dotacion = '$fec_dotacion',
						status           = 1  						
	  		     WHERE  $tabla_id = '$codigo'", $cnn)or die
								 ('<br><h3>Error Consulta # 2:</h3> '.mysql_error().'<br>');
	break;	
	case 'agregar':
	 mysql_query("INSERT INTO $tabla2 (id_ci, codigo, nombres, fec_nac, parentesco, sexo, status) 
	                           VALUES ('$codigo', '$codigo_fam', '$nombre', '$fec_nac','$parentesco', '$sexo', 1)",$cnn);
	break;	
	case 'modificar':    
		 //begin();	 			 

      mysql_query("UPDATE $tabla2 SET   					
						codigo           = '$codigo_fam',     nombres       = '$nombre',   
						fec_nac          = '$fec_nac',       sexo          = '$sexo',
						parentesco       = '$parentesco'
	  		      WHERE $tabla_id = '$codigo'
				    AND codigo    = '$codigo_old'", $cnn);
					$mensaje = "Se Actualizaron Correctamente Los Datos..."; 
	break; 		 	 
	case 'eliminar':    
	     //begin();
		 echo "Eliminar";
		 mysql_query ("DELETE FROM $tabla2  WHERE $tabla_id = '$codigo' AND codigo  = '$codigo_fam'",$cnn)or die
					 ('<br><h3>Error Consulta # 2:</h3> '.mysql_error().'<br>');	
	break;

	case 'egreso':          

      mysql_query("UPDATE $tabla3 SET   
	  					egreso           = 'S',					
						fec_egreso       = '$fec_egreso',      motivo           = '$motivo',   
						preaviso         = '$preaviso',        fec_inicio       = '$fec_inicio',
						fec_culminacion  = '$fec_culminacion', fec_calculo      = '$fec_calculo',
						entrega_uniforme = '$entrega_uniforme',  observacion    = '$observacion'   						
	  		     WHERE  $tabla_id = '$codigo'", $cnn)or die
								 ('<br><h3>Error Consulta # 4:</h3> '.mysql_error().'<br>');
      mysql_query("UPDATE ficha SET 
	                      status  = '$status'  						
	  		     WHERE     ci = '$codigo'", $cnn)or die
								 ('<br><h3>Error Consulta # 2:</h3> '.mysql_error().'<br>');
	break;		
	case 'egreso_anexo':          

      mysql_query("UPDATE $tabla3 SET   					 
	                      fec_calculo   = '$fec_calculo', 	fec_pago = '$fec_pago',
						  cheque        = '$cheque',        banco    = '$banco',  
						  importe       = '$importe',       observacion2    = '$observacion2'			
	  		     WHERE  $tabla_id = '$codigo'", $cnn)or die
								 ('<br><h3>Error Consulta # 4:</h3> '.mysql_error().'<br>');
								 
	break;			
	}        
}
	require_once('../funciones/sc_direccionar.php');  	 				 
?>