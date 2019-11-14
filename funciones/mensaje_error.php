<?php
function Errror_Ms($Nerror, $Merror){

		if($Nerror==1054){ 
		
		$error = "La Columna Del Campo Es Desconocida, Error N.: ".$Nerror."";	
		//$error = "La Columna Del Campo Es Desconocida, Error N&ordm; 1054,  ".$Merror."";		
		}elseif($Nerror==1062){ 
		
		$error = "No Se Pudo Ingresar El Registro, Error N.: ".$Nerror.", Archivo Duplicado...";		
		//$error = "".$Merror."";		
		}elseif ($Nerror==1451){ 
		
		$error ="No se puede Eliminar o Actualizar un Registro de una Fila Primaria: Error N.: ".$Nerror.", Debido a una Restriccion de Clave Foranea en la Base de Datos.";			
		//$error = "".$Merror."";		
		}
		elseif ($Nerror==1452){ 
		
		$error ="No se puede Agregar o Actualizar un Registro de una Fila Primaria: Error N.: ".$Nerror.", Debido a una Restriccion de clave Foranea en la Base de Datos.";			
		//$error = "".$Merror."";		
		}else{ 
		
		$error ="Se Ha Producido Un Error N.: ".$Nerror." Contacte Al Administrador del Sistema ";			
		
		}
	return $error;
}
?>
