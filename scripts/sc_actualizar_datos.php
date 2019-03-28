				<?php
				ini_set('display_errors', 1);
				error_reporting(E_ALL);
				define("SPECIALCONSTANT",true);
				include_once('../funciones/funciones.php');
				require("../autentificacion/aut_config.inc.php");
				require_once("../".class_bdI);
				$bd = new DataBase();

				$usuario = $_POST['usuario'];
				$href = $_POST['href'];

				if (isset($_POST['archivo'])) {


					$a = $_POST['archivo'];

					$sql   = " SELECT archivo, proced FROM actualizar WHERE codigo = '$a'";
					$query = $bd->consultar($sql);
					$datos = $bd->obtener_fila($query,0);	
					$doc   = $datos['archivo'];
					$proc  = $datos['proced']; 
        //Aquí es donde seleccionamos nuestro csv

					$path="../xml2/"; 
					$nombre_archivo = $_FILES['file']['name'];
					$tmp_archivo = $_FILES['file']['tmp_name'];
					$tipo_archivo   = $_FILES['file']['type'];
					$tamano_archivo = $_FILES['file']['size'];

					$chk_ext = explode(".",$nombre_archivo);
					/*	if (!((strpos($tipo_archivo, "xml") || strpos($tipo_archivo, "") || strpos($tipo_archivo, "csv") || strpos($tipo_archivo, "txt")) && ($tamano_archivo < 10000000)  && ($doc == $nombre_archivo))) {*/

						if (!(((strtolower(end($chk_ext)) == "csv") || strtolower(end($chk_ext)) == "txt") && ($doc.".".strtolower(end($chk_ext)) == $nombre_archivo) && ($tamano_archivo < 10000000))) {
							mensajeria("La Extensi&oacute;n (XML), Nombre Del Archivo  O El Tama&ntilde;o De Los Archivos No Es Correcta");
						}else{

							$archivo = "../xml2/$doc".".".strtolower(end($chk_ext)); 
							if (move_uploaded_file($_FILES['file']['tmp_name'], $path.$nombre_archivo)){

								echo "El archivo ha sido cargado correctamente. <br>";

								switch ($a) {

								// FICHA
									case '01':			
									if(file_exists($archivo)) { 
										$xml = simplexml_load_file($archivo); 		 
										if($xml) { 
											foreach ($xml->csnemple as $campo) { 
												$cedula  = $campo->ci;
												$cod_ficha = $campo->cod_emp; 
												$fec_ingreso = $campo->fecha_ing;
											//$nombre  = $campo->nombres; 
											//$fecha_nac     = $campo->fecha_nac;					 
											//$sexo    = $campo->sexo;
											//$telefono      = $campo->telefono;
											//$direccion      = $campo->direccion;	
											//$fec_egreso  = $campo->fecha_egr; 
											//$co_cont = $campo->co_cont; 							 							
											//$departamento     = $campo->co_depart;
					           			    // $status  = $campo->status;
												$sql = "CALL $proc('$cedula', '$cod_ficha', '$fec_ingreso', '$usuario')";					
												$query = $bd->consultar($sql);
											} 
										}else{ 
											mensajeria("Sintaxis XML invalida"); 
										}

									}else { 
										mensajeria("Error abriendo $archivo"); 
									}


									break;			
								// ficha masivo
									case '02':			
									if(file_exists($archivo)) { 
									/*$xml = simplexml_load_file($archivo); 		 
									if($xml) { 
										foreach ($xml->csnemple as $campo) { 
											$cedula  = $campo->ci;
											$cod_ficha = $campo->cod_emp; 
											$nombre  = htmlentities($campo->nombres); 
											$fecha_nac     = $campo->fecha_nac;					 
											$sexo    = $campo->sexo;
											$telefono      = $campo->telefono;
											$direccion      = $campo->direccion;							 
											$fec_ingreso = $campo->fecha_ing; 
											//$fec_egreso  = $campo->fecha_egr; 
											//$co_cont = $campo->co_cont; 							 							
											//$departamento     = $campo->co_depart;
					           			    // $status  = $campo->status;
								echo		$sql = "CALL $proc('$cedula', '$cod_ficha', '$nombre', '$fecha_nac', '$sexo',
										                   '$telefono', '$direccion', '$fec_ingreso', '$usuario')", '</br>';					
										$query = $bd->consultar($sql);
										} 
									}else{ 
										  mensajeria("Sintaxis XML invalida"); 
									}
									 */

									$i=0;
             //si es correcto, entonces damos permisos de lectura para subir
									$handle = fopen($archivo, "r");

									while (($data = fgetcsv($handle, 1000, ";")) !== FALSE)
									{
										if($i != 0) 
										{ 
											if(isset($data[0])){
												$cedula  = $data[0];
											}else{
												echo("No esta definido el campo 'cedula' en la fila <br> Error en la linea ".$i);
											}
											if(isset($data[1])){
												$cod_ficha  = $data[1];
											}else{
												echo("No esta definido el campo 'cod_ficha' en la fila <br> Error en la linea ".$i);	
											}
											if(isset($data[2])){
												$nacionalidad  = $data[2];
											}else{
												echo("No esta definido el campo 'nacionalidad' en la fila <br> Error en la linea ".$i);
											}
											if(isset($data[3])){
												$nombre  = $data[3];
											}else{
												echo("No esta definido el campo 'nombres' en la fila <br> Error en la linea ".$i);
											}
											if(isset($data[4])){
												$apellido  = $data[4];
											}else{
												echo("No esta definido el campo 'apellidos' en la fila <br> Error en la linea ".$i);
											}
											if(isset($data[5])){
												$f_nac  = $data[5];
											}else{
												echo("No esta definido el campo 'fecha_nacimiento' en la fila <br> Error en la linea ".$i);
											}
											if(isset($data[6])){
												$sexo  = $data[6];
											}else{
												echo("No esta definido el campo 'sexo' en la fila <br> Error en la linea ".$i);
											}
											if(isset($data[7])){
												$estado_civil  = $data[7];
											}else{
												echo("No esta definido el campo 'estado_civil' en la fila <br> Error en la linea ".$i);
											}
											if(isset($data[8])){
												$telefono  = $data[8];
											}else{
												echo("No esta definido el campo 'telefono' en la fila <br> Error en la linea ".$i);
											}
											if(isset($data[9])){
												$direccion  = $data[9];
											}else{
												echo("No esta definido el campo 'direccion' en la fila <br> Error en la linea ".$i);
											}
											if(isset($data[10])){
												$email  = $data[10];
											}else{
												echo("No esta definido el campo 'email' en la fila <br> Error en la linea ".$i);
											}
											if(isset($data[11])){
												$f_ingreso  = $data[11];
											}else{
												echo("No esta definido el campo 'fecha_ingreso' en la fila <br> Error en la linea ".$i);
											}
											if(isset($data[12])){
												$cliente  = $data[12];
											}else{
												echo("No esta definido el campo 'cliente' en la fila <br> Error en la linea ".$i);
											}
											if(isset($data[13])){
												$ubicacion  = $data[13];
											}else{
												echo("No esta definido el campo 'ubicacion' en la fila <br> Error en la linea ".$i);
											}
											if(isset($data[14])){
												$rol  = $data[14];
											}else{
												echo("No esta definido el campo 'rol' en la fila <br> Error en la linea ".$i);
											}
											if(isset($data[15])){
												$f_ingreso  = $data[15];
											}else{
												echo("No esta definido el campo 'usuario' en la fila <br> Error en la linea ".$i);
											}
									$sql = "CALL $proc('$cedula', '$cod_ficha','$nacionalidad', '$nombre','$apellido', '$f_nac', '$sexo','$estado_civil','$telefono','$direccion','$email','$f_ingreso',
										                   '$cliente', '$ubicacion', '$rol', '$usuario')";					
										$query = $bd->consultar($sql) or die('Error: '.mysql_error());

										}else{
											if(!(isset($data[0]) && $data[0] == "cedula")){
												die("ERROR nombre cabecera (cedula), columna 1");
											}
										}
										$i++;
									}

             //cerramos la lectura del archivo "abrir archivo" con un "cerrar archivo"
									fclose($handle);
									echo "Importación exitosa!";

								}else { 
									mensajeria("Error abriendo $archivo"); 
								}


								break;		
				case '03':  // CONCEPTOS O VARIACIONES

				if(file_exists($archivo)) { 
					$xml = simplexml_load_file($archivo); 

					if($xml) { 
						foreach ($xml-> csnvaria as $campo) { 
							$codigo      = $campo->co_var; 
							$descripcion = $campo->des_var;

							$sql = "CALL $proc('$codigo', '$descripcion', '$usuario')";					
							$query = $bd->consultar($sql);	
						} 
					}else{ 
						mensajeria("Sintaxis XML invalida"); 
					} 
				}else { 
					mensajeria("Error abriendo $archivo"); 
				}
				break;							 		 		
				case '04':	// REGIONES  O 	DEPARTAMENTOS
				if(file_exists($archivo)) { 
					$xml = simplexml_load_file($archivo); 

					if($xml) { 
						foreach ($xml->csndepart as $campo) { 
							$codigo  = $campo->co_depart; 
							$descripcion = $campo->des_depart; 

							$sql = "CALL $proc('$codigo', '$descripcion', '$usuario')";					
							$query = $bd->consultar($sql);

						} 
					}else{ 
						mensajeria("Sintaxis XML invalida"); 
					} 
				}else { 
					mensajeria("Error abriendo $archivo"); 
				}
				break;


				case '05':	// CARGOS

				if(file_exists($archivo)) { 
					$xml = simplexml_load_file($archivo); 				 
					if($xml) { 
						foreach ($xml->ccargo as $campo) { 
							$codigo      = $campo->co_cargo; 
							$descripcion = $campo->des_cargo; 
							$sql = "CALL $proc('$codigo', '$descripcion', '$usuario')";					
							$query = $bd->consultar($sql);	
						} 
					}else{ 
						mensajeria("Sintaxis XML invalida"); 
					} 
				}else { 
					mensajeria("Error abriendo $archivo"); 
				}
				break;
				case '06':			
				if(file_exists($archivo)){ 
					$xml = simplexml_load_file($archivo); 		 
					if($xml) { 

						foreach ($xml->ccliente as $campo){		

							$codigo    = $campo->co_cli; 
				// $tipo      = $campo->tipo; 
							$nombre   = $campo->cli_des; 
							$direccion  = $campo->direc1; 
							$telefono = $campo->telefonos; 
				// $fax       = $campo->fax; 
							$contacto   = $campo->respons; 					

							$sql = "CALL $proc('$codigo', '$nombre', '$direccion', '$telefono', '$contacto', '$usuario')";					
							$query = $bd->consultar($sql);				

						} 
					}else{ 
						mensajeria("Sintaxis XML invalida"); 
					} 
				}else { 
					mensajeria("Error abriendo $archivo"); 
				}

				break;
				case '07':	// CARGOS

				if(file_exists($archivo)) { 
					$xml = simplexml_load_file($archivo); 				 
					if($xml) { 
						foreach ($xml->ficha as $campo) { 
							$cedula      = $campo->CEDULA; 
							$nombres = htmlentities($campo->NOMBRES);
							$ficha = $campo->FICHA;
							$contracto = $campo->CONTRACTO; 
							$sql = "CALL $proc('$cedula', '$nombres', '$ficha', '$contracto', '$usuario')";					
							$query = $bd->consultar($sql);	
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
			mensajeria("Ocurri&oacute; alg&uacute;n error al subir el fichero. No pudo guardarse.");
		}
	} 
}
				//require_once('../funciones/sc_direccionar.php');	
?>