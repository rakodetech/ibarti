<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase();

$usuario = $_POST['usuario'];
$href = $_POST['href'];

if (isset($_POST['archivo'])) {
	  $i = $_POST['archivo'];

		//$campoX         = $i.'.xml';	  
		$path="../xml2/"; 
		$nombre_archivo = $_FILES['file']['name'];
		$tipo_archivo   = $_FILES['file']['type'];
		$tamano_archivo = $_FILES['file']['size'];
			
		$sql   = " SELECT archivo, proced FROM actualizar WHERE codigo = '$i'";
		$query = $bd->consultar($sql);
		$datos = $bd->obtener_fila($query,0);	
		$doc   = $datos['archivo'];
		$proc  = $datos['proced'];
	    $archivo = "../xml2/$doc";    

		if (!((strpos($tipo_archivo, "xml") || strpos($tipo_archivo, "")) && ($tamano_archivo < 10000000)  && ($doc == $nombre_archivo))) {
			mensajeria("La Extensi&oacute;n (XML), Nombre Del Archivo  O El Tama&ntilde;o De Los Archivos No Es Correcta");
		}else{

			if (move_uploaded_file($_FILES['file']['tmp_name'], $path.$nombre_archivo)){
			
			   echo "El archivo ha sido cargado correctamente.";

			switch ($i) {

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
				// masivo
			case '02':			
				if(file_exists($archivo)) { 
					$xml = simplexml_load_file($archivo); 		 
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
	require_once('../funciones/sc_direccionar.php');	
?>