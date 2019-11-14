<?php		 		 
include_once('../autentificacion/aut_config.inc.php');
include_once('../funciones/funciones.php');
include_once('../funciones/mensaje_error.php');

mysql_select_db($bd_cnn, $cnn);

$href = $_POST['href'];

if (isset($_POST['archivo'])) {
	  $i = $_POST['archivo'];
	  
		$path="../xml2/"; 
		$nombre_archivo = $_FILES['file']['name'];
		$tipo_archivo   = $_FILES['file']['type'];
		$tamano_archivo = $_FILES['file']['size'];
			
			if ($i == 'ficha_trab'){
			$campoX         = 'snemple.xml';
			}else{
			$campoX         = $i.'.xml';
			}
					

		if (!((strpos($tipo_archivo, "xml") || strpos($tipo_archivo, "")) && ($tamano_archivo < 100000000)  && ($campoX == $nombre_archivo))) {
			mensajeria("La Extensión, Nombre Del Archivo  O El Tamaño De Los Archivos No Es Correcta");
		}else{

			if (move_uploaded_file($_FILES['file']['tmp_name'], $path.$nombre_archivo)){
			
			   echo "El archivo ha sido cargado correctamente.";

			switch ($i) {

			case 'clientes':
			
					$archivo = "../xml2/clientes.xml";
					$tabla   = "clientes";
					
				if(file_exists($archivo)){ 
					$xml = simplexml_load_file($archivo); 		 
					if($xml) { 
					
						foreach ($xml->ccliente as $campo){		
		
							 $co_cli    = $campo->co_cli; 
							 $tipo      = $campo->tipo; 
							 $cli_des   = $campo->cli_des; 
							 $direc1    = $campo->direc1; 
							 $direc2    = $campo->direc2; 
							 $telefonos = $campo->telefonos; 
							 $fax       = $campo->fax; 
							 $inactivo  = $campo->inactivo; 
							 $juridico  = $campo->juridico; 
							 $respons   = $campo->respons; 
							 $mont_cre  = $campo->mont_cre; 
							 $plaz_pag  = $campo->plaz_pag; 
							 $co_zon    = $campo->co_zon; 
							 $co_seg    = $campo->co_seg; 
							 $co_ven    = $campo->co_ven; 					
						
						$query01 = mysql_query("SELECT co_cli FROM $tabla WHERE co_cli = '$co_cli'",$cnn)or die
											 ('<br><h3>Error Consulta # 2:</h3> '.mysql_error().'<br>');		
				
							 if (mysql_num_rows($query01)==0){							  
							 mysql_query("INSERT INTO $tabla
											 (co_cli, tipo, cli_des, direc1, direc2, telefonos, fax, inactivo,
											  juridico, respons, mont_cre, plaz_pag, co_zon, co_seg, co_ven, status)					
															   
									  VALUES ('$co_cli', '$tipo', '$cli_des', '$direc1', '$direc2', '$telefonos', '$fax', '$inactivo',
											  '$juridico', '$respons', '', $plaz_pag, '$co_zon', '$co_seg', '$co_ven', 1)",$cnn);			
							// echo 'insert';

							 mysql_query("INSERT INTO clientes_ubicacion
											 (id,  codigo, descripcion, co_cli, id_dpt_2, id_region, ubicacion, status)					
															   
									  VALUES (null, null, '$cli_des', '$co_cli', 2323, '9999', '$direc1', 1)",$cnn);								
					
							  mysql_query("UPDATE $tabla SET   
												  tipo     = '$tipo',
												  cli_des  = '$cli_des',   direc1    = '$direc1',
												  direc2   = '$direc2',    telefonos = '$telefonos',
												  fax      = '$fax',       inactivo  = '$inactivo',
												  juridico = '$juridico',  respons   =  '$respons',
												  mont_cre = '$mont_cre',  plaz_pag  = '$plaz_pag',
												  co_zon   = '$co_zon',    co_seg    = '$co_seg',
												  co_ven   = '$co_ven'    
										 WHERE    co_cli   = '$co_cli'", $cnn);			
							 //echo 'actualiza';
							 }					
						} 
					}else{ 
						  mensajeria("Sintaxis XML invalida"); 
					} 
				}else { 
					   mensajeria("Error abriendo $archivo"); 
				}
			
			break;
			
			// TRABAJADORES
			case 'snemple':			
					$archivo = "../xml2/snemple.xml";
					$tabla   = "trabajadores";
			
				if(file_exists($archivo)) { 
					$xml = simplexml_load_file($archivo); 		 
					if($xml) { 
						foreach ($xml->csnemple as $campo) { 
							$cod_emp = $campo->cod_emp; 
							$nombre  = $campo->nombres; 
							$ci      = $campo->ci; 
							$sexo    = $campo->sexo; 
							$status  = $campo->status; 
							$co_cont = $campo->co_cont; 
							$fecha_nac     = $campo->fecha_nac; 
							$fecha_ingreso = $campo->fecha_ing; 
							$fecha_egreso  = $campo->fecha_egr; 
							$telefono      = $campo->telefono;
							$co_depart     = $campo->co_depart;
						
						$query01 = mysql_query("SELECT cod_emp FROM trabajadores WHERE cod_emp = '$cod_emp'",$cnn)or die
											 ('<br><h3>Error Consulta # 2:</h3> '.mysql_error().'<br>');
		
							 if (mysql_num_rows($query01)==0){							  
							 mysql_query("INSERT INTO $tabla
											 (cod_emp, nombres, ci, sexo, status, co_cont, fecha_nac,
											  fecha_ingreso, fecha_egreso, telefonos, id_region)						                  
									  VALUES ('$cod_emp', '$nombre', '$ci', '$sexo', '$status', '$co_cont', '$fecha_nac',
											  '$fecha_ingreso', '$fecha_egreso', '$telefono', '$co_depart')",$cnn)or die
											 ('<br><h3>Error Consulta # 3:</h3> '.mysql_error().'<br>');	
							 //echo 'insert';
							 }else{
					
							  mysql_query("UPDATE $tabla SET   
												  nombres   = '$nombre',      ci     = '$ci', 
												  sexo      = '$sexo',        status = '$status',
												  co_cont   = '$co_cont',     
												  fecha_nac = '$fecha_nac',  
												  fecha_ingreso = '$fecha_ingreso', 
												  fecha_egreso = '$fecha_egreso',  id_region = '$co_depart',
												  telefonos    = '$telefono'  					
										 WHERE  cod_emp = '$cod_emp'", $cnn);			
							 //echo 'actualiza';
							 }
						//////////  DESACTIVAR TRABAJADOR
						/*	
							if ($status != "A" ){											
								  mysql_query("DELETE FROM `usuario_cliente` 
													 WHERE `usuario_cliente`.`codigo` = '$cod_emp' 
													   AND `usuario_cliente`.`tipo` = 'T'", $cnn);
							}*/
						} 
					}else{ 
						  mensajeria("Sintaxis XML invalida"); 
					}
					 
				}else { 
					   mensajeria("Error abriendo $archivo"); 
				}
				
			break;			
			case 'ficha_trab':  //  FICHA TRABAJADOR			
					$archivo = "../xml2/snemple.xml";
					$tabla   = "ficha";
			
				if(file_exists($archivo)) { 
					$xml = simplexml_load_file($archivo); 		 
					if($xml) { 
					
						foreach ($xml->csnemple as $campo) { 
				
							$cod_emp       = $campo->cod_emp; 
							$nombre        = $campo->nombres; 
							$ci            = $campo->ci; 
							$sexo          = $campo->sexo; 
							$status        = $campo->status; 
							$fecha_nac     = $campo->fecha_nac;
							$co_cont       = $campo->co_cont; 
							$fecha_ingreso = $campo->fecha_ing; 
							$fecha_egreso  = $campo->fecha_egr; 
							$telefono      = $campo->telefono; //	<telefono>0241-878.85.80 - 0412 - 409.8325</telefono> 
							$direccion     = $campo->direccion; 
							$co_depart     = $campo->co_depart;
							$co_ban        = $campo->co_ban;
							$co_cargo      = $campo->co_cargo;
							$cta_banc      = $campo->cta_banc;
							$edo_civ       = $campo->edo_civ;
					
							$query01 = mysql_query("SELECT ci FROM ficha WHERE ci = '$ci'",$cnn)or die
											 ('<br><h3>Error Consulta # 2:</h3> '.mysql_error().'<br>');
		
							 if (mysql_num_rows($query01)==0){
							 
								if($status == 'A'){
							 mysql_query("INSERT INTO $tabla
										 (ci, nombres, fecha_nac, fecha_ingreso, sexo, direccion, cargo, id_contracto, 
										 departamento, banco, cta_banco, fec_act, fec_sistema, telefono, status)				                  
								  VALUES ('$ci', '$nombre', '$fecha_nac', '$date', '$sexo', '$direccion', '$co_cargo', '$co_cont',   
										  '$co_depart', '$co_ban', '$cta_banc', '$date', '$date', '$telefono', '$status')",$cnn)or die
											 ('<br><h3>Error Consulta # 2:</h3> '.mysql_error().'<br>');								  
										
								mysql_query("INSERT INTO ficha_uniforme (id_ci) VALUES ('$ci')",$cnn);
								mysql_query("INSERT INTO ficha_egreso (id_ci) VALUES ('$ci')",$cnn);
								}							 							  

							 //echo 'insert';
							 }/* else{					
							  mysql_query("UPDATE $tabla SET   
												  nombres = '$nombre',      ci     = '$ci', 
												  sexo    = '$sexo',        status = '$status',
												  co_cont = '$co_cont',     fecha_ingreso = '$fecha_ingreso', 
												  fecha_egreso = '$fecha_egreso',  id_region = '$co_depart'  					
										 WHERE  cod_emp = '$cod_emp'", $cnn);			
							 //echo 'actualiza';
							 }*/
						} 
					}else{ 
						  mensajeria("Sintaxis XML invalida"); 
					}
					 
				}else { 
					   mensajeria("Error abriendo $archivo"); 
				}				
			
			break;
			case 'snvaria':  // VARIACIONES
		
					$archivo = "../xml2/snvaria.xml";
					$tabla   = "snvaria";
				if(file_exists($archivo)) { 
				$xml = simplexml_load_file($archivo); 
				 
					if($xml) { 
						foreach ($xml->csnvaria as $campo) { 
							$co_var  = $campo->co_var; 
							$des_var = $campo->des_var; 
							$uso     = $campo->uso; 
							$tipo    = $campo->tipo; 								
		
						$query01 = mysql_query("SELECT co_var FROM $tabla WHERE co_var = '$co_var'",$cnn)or die
											 ('<br><h3>Error Consulta # 2:</h3> '.mysql_error().'<br>');
							 if (mysql_num_rows($query01)==0){ 
									  
							 mysql_query("INSERT INTO $tabla
											 (co_var, des_var, uso, tipo)						                  
									  VALUES ('$co_var', '$des_var', $uso, $tipo)",$cnn);			
							 //echo 'insert';
							 }else{
					
							  mysql_query("UPDATE $tabla SET 		
												  des_var = '$des_var', 
												  uso     = $uso,         tipo        = $tipo			
										 WHERE  co_var = '$co_var'", $cnn);
							  //echo 'update';
							 }		
						} 
					}else{ 
					mensajeria("Sintaxis XML invalida"); 
					} 
				}else { 
					mensajeria("Error abriendo $archivo"); 
				}
			break;					
				
			case 'snbanco':		// BANCOS  
					$archivo = "../xml2/snbanco.xml";
					$tabla   = "bancos";
					$i = $tabla;	
				if(file_exists($archivo)) { 
				$xml = simplexml_load_file($archivo); 
				 
					if($xml) { 
						foreach ($xml->csnbanco as $campo) { 
							$codigo      = $campo->co_ban; 
						 	$descripcion = $campo->des_ban; 
		
						$query01 = mysql_query("SELECT id FROM $tabla WHERE id = '$codigo'",$cnn)or die
											 ('<br><h3>Error Consulta # 2:</h3> '.mysql_error().'<br>');
							 if (mysql_num_rows($query01)==0){ 
									  
							 mysql_query("INSERT INTO $tabla
											 (id, descripcion, status)						                  
									  VALUES ('$codigo', '$descripcion', 1)",$cnn);			
							 //echo 'insert';
							 }else{
					
							  mysql_query("UPDATE $tabla SET 													  
												  descripcion   = '$descripcion'		
										    WHERE id = '$codigo'", $cnn);
							  //echo 'update';
							 }		
						} 
					}else{ 
					mensajeria("Sintaxis XML invalida"); 
					} 
				}else { 
					mensajeria("Error abriendo $archivo"); 
				}
			break;
			case sncargos:		// CARGOS
					$archivo = "../xml2/sncargos.xml";
					$tabla   = "cargos";
					$i = $tabla;	
				if(file_exists($archivo)) { 
				$xml = simplexml_load_file($archivo); 
				 
					if($xml) { 
						foreach ($xml->ccargo as $campo) { 
							$codigo      = $campo->co_cargo; 
						 	$descripcion = $campo->des_cargo; 
		
						$query01 = mysql_query("SELECT id FROM $tabla WHERE id = '$codigo'",$cnn)or die
											 ('<br><h3>Error Consulta # 2:</h3> '.mysql_error().'<br>');
							 if (mysql_num_rows($query01)==0){ 
									  
							 mysql_query("INSERT INTO $tabla
											 (id, descripcion, status)						                  
									  VALUES ('$codigo', '$descripcion', 1)",$cnn);			
							 //echo 'insert';
							 }else{
					
							  mysql_query("UPDATE $tabla SET 													  
												  descripcion   = '$descripcion'		
										    WHERE id = '$codigo'", $cnn);
							  //echo 'update';
							 }		
						} 
					}else{ 
					mensajeria("Sintaxis XML invalida"); 
					} 
				}else { 
					mensajeria("Error abriendo $archivo"); 
				}
			break;
			case 'sndepart':		// REGIONES  O 	DEPARTAMENTOS
		
					$archivo = "../xml2/sndepart.xml";
					$tabla   = "regiones";
				if(file_exists($archivo)) { 
				$xml = simplexml_load_file($archivo); 
				 
					if($xml) { 
						foreach ($xml->csndepart as $campo) { 
							$co_depart  = $campo->co_depart; 
						 	$des_depart = $campo->des_depart; 
		
						$query01 = mysql_query("SELECT id FROM $tabla WHERE id = '$co_depart'",$cnn)or die
											 ('<br><h3>Error Consulta # 2:</h3> '.mysql_error().'<br>');
							 if (mysql_num_rows($query01)==0){ 
									  
							 mysql_query("INSERT INTO $tabla
											 (id, descripcion, status)						                  
									  VALUES ('$co_depart', '$des_depart', 1)",$cnn);			
							 //echo 'insert';
							 }else{
					
							  mysql_query("UPDATE $tabla SET 													  
												  descripcion   = '$des_depart'		
										    WHERE id = '$co_depart'", $cnn);
							  //echo 'update';
							 }		
						} 
					}else{ 
					mensajeria("Sintaxis XML invalida"); 
					} 
				}else { 
					mensajeria("Error abriendo $archivo"); 
				}
			break;
			case sncont:  // TIPO  NOMINA
					$archivo = "../xml2/sncont.xml";
					$tabla   = "nomina";
				if(file_exists($archivo)) { 
				$xml = simplexml_load_file($archivo); 
				 
					if($xml) { 
						foreach ($xml-> csncont as $campo) { 
							$co_cont  = $campo->co_cont; 
							$des_cont = $campo->des_cont;
							$co_calen = $campo->co_calen; 
							$fec_inic = $campo->fec_inic; 
							$fec_ult  = $campo->fec_ult;
							$tip_cont = $campo->tip_cont; 								
		
					$query01 = mysql_query("SELECT co_cont FROM $tabla WHERE co_cont = '$co_cont'",$cnn)or die
											 ('<br><h3>Error Consulta # 2:</h3> '.mysql_error().'<br>');
							 if (mysql_num_rows($query01)==0){ 									  
							 mysql_query("INSERT INTO $tabla
											 (co_cont, des_cont, co_calen, fec_inic, fec_ult, tip_cont)			                  
									  VALUES ('$co_cont', '$des_cont', '$co_calen', '$fec_inic', '$fec_ult', '$tip_cont')",$cnn);			
							 //echo 'insert';
							 }else{
					
							  mysql_query("UPDATE $tabla SET 		
												  des_cont  = '$des_cont',    co_calen    = '$co_calen',
												  tip_cont  = '$tip_cont'
										    WHERE co_cont = '$co_cont'", $cnn);
							 // echo 'update';
							 }		
						} 
					}else{ 
					mensajeria("Sintaxis XML invalida"); 
					} 
				}else { 
					mensajeria("Error abriendo $archivo"); 
				}
			break;							 		 		
			}        


			}else{
				mensajeria("Ocurrió algún error al subir el fichero. No pudo guardarse.");
			}
		} 

	/////////////////////////           PROCESOS   ///////////////////
}
	if (mysql_errno($cnn)==0){
	//commit();	
	
		if(isset($i)){
		//////////////	  TABLA DE CONTROL  ////////						
					$control = mysql_query("SELECT * FROM control",$cnn);
	
					 if (mysql_num_rows($control)!=0){
				
						 mysql_query("UPDATE control SET  $i = '$date'", $cnn);						
					 }else{
					 echo $i;
						 mysql_query("INSERT INTO control ($i) VALUES ('$date')",$cnn);						
					 }
		}	
    echo '<script language="javascript">
	       location.href="'.$href.'";
	       </script>';		    
	 }else{
	 	$Nerror = mysql_errno($cnn);
		$Derror = mysql_error($cnn);

		mensajeria("".Errror_Ms($Nerror, $Merror)."");
	//rollback();		
     echo '<script language="javascript">
	       location.href="'.$href.'";
	       </script>';		    

	 }
mysql_close($cnn); 	
?>