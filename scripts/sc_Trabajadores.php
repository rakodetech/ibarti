<?php
include_once('../conexiones/conexion.php');
include_once('../funciones/funciones.php');
include_once('../funciones/mensaje_error.php');

$tabla    = 'trabajadores';
$tabla_id = 'cedula';

$id             = $_POST['id'];
$cedula         = strtoupper($_POST['cedula']); 
$cedula2        = strtoupper($_POST['cedula2']); 
$nombre         = strtoupper($_POST['nombre']);
$apellido       = strtoupper($_POST['apellido']);
$cargo          = strtoupper($_POST['cargo']); 
$fecha_nac      = Rconversion($_POST['fecha_nac']);
$sexo           = $_POST['sexo'];
$telefono       = $_POST['telefono'];
$telefono_otro  = $_POST['telefono_otro'];
$fax            = $_POST['fax'];
$email          = $_POST['email'];
$turno_rotativo = $_POST['turno_rotativo'];
$direccion      = strtoupper($_POST['direccion']);
$observacion    = strtoupper($_POST['observacion']);
$status         = $_POST['status'];			  
$href           = $_POST['href'];

$TV             = 'NO';
////////////////           VALIDACION DE TURNOS ROTATIVOS ////////////
$Vrotativo = explode("-", $turno_rotativo);

	$TP01 = 'T'.$Vrotativo[0]; 
		$result01 = mysql_query("SELECT id FROM turnos  WHERE id = '$TP01'  AND status = 1" ,$cnn);
		if (mysql_num_rows($result01)!=0){	
		$TV = 'SI';
		}
	$TP02 = 'T'.$Vrotativo[1]; 
		$result02 = mysql_query("SELECT id FROM turnos  WHERE id = '$TP02'  AND status = 1" ,$cnn);
		if (mysql_num_rows($result02)!=0){	
		$TV = 'SI';
		}	
	$TP03 = 'T'.$Vrotativo[2]; 
		$result03 = mysql_query("SELECT id FROM turnos  WHERE id = '$TP03'  AND status = 1" ,$cnn);
		if (mysql_num_rows($result03)!=0){	
		$TV = 'SI';
		}	
	$TP04 = 'T'.$Vrotativo[3]; 
		$result04 = mysql_query("SELECT id FROM turnos  WHERE id = '$TP04'  AND status = 1" ,$cnn);
		if (mysql_num_rows($result04)!=0){	
		$TV = 'SI';
		}
		if($TV=='SI'){
		$turno_rotativo  = $turno_rotativo; 
		}else{
		$turno_rotativo = '1-1-1-1';
		}

//cedula,  nombre,  apellido, fecha_nacimiento,  sexo, telefono, telefono_otro, fax,  email, direccion, observacion, status

if (isset($_POST['archivo'])) {
	 $i=$_POST['archivo'];
	switch ($i) {
    case agregar:   
	 	 begin();	
         
		 mysql_query("INSERT INTO $tabla
		                 (cedula, cedula2, nombre,  apellido, fecha_nacimiento,  sexo, telefono, telefono_otro, fax,  email, 
						  turno_rotativo, direccion, observacion, status)						                  
						 VALUES ('$cedula', '$cedula2', '$nombre', '$apellido', '$fecha_nac', '$sexo', '$telefono', '$telefono_otro', '$fax',                                 '$email', '$turno_rotativo', '$direccion', '$observacion', $status)",$cnn);
	
			 mysql_query("INSERT INTO trabajador
							 (id,  cedula, id_cargo, status)		
					 VALUES (null, '$id', '$cargo', 1)",$cnn);	
	break;	
	case modificar:    
		 begin();	 	
	
      mysql_query("UPDATE $tabla SET   
						cedula          = '$cedula',      cedula2       = '$cedula2',
						nombre           = '$nombre',     apellido      = '$apellido', 
						fecha_nacimiento = '$fecha_nac',  sexo          = '$sexo',
						telefono         = '$telefono',   telefono_otro = '$telefono_otro', 
						fax              = '$fax',        email         = '$email', 
						turno_rotativo   = '$turno_rotativo',
						direccion        = '$direccion',  observacion   = '$observacion', 
						status           = $status       
						
	  		     WHERE  $tabla_id = '$id'", $cnn);

		$result01 = mysql_query("SELECT id_cargo FROM trabajador WHERE cedula = '$id'
									AND id_cargo = '$cargo'
									AND status = 1",$cnn);

			if (mysql_num_rows($result01)==0){	
				  mysql_query("UPDATE trabajador SET
									  status = 2
									  WHERE cedula = '$id'", $cnn);
									   
				 mysql_query("INSERT INTO trabajador
								 (id,  cedula, id_cargo, status)		
						 VALUES (null, '$id', '$cargo', 1)",$cnn);					
			}


	break; 		 	 
	case eliminar:    
	     begin();
	     mysql_query("UPDATE $tabla SET
			                      status = 2
			                      WHERE $tabla_id = '".$id."'", $cnn); 	
	break;	 
	}        
}

	if (mysql_errno($cnn)==0){
	
	commit();	
     echo '<script language="javascript">
	       location.href="'.$href.'";
	       </script>';		    
	 
	 }else{

	 	$Nerror = mysql_errno($cnn);
		$Derror = mysql_error($cnn);

		mensajeria("".Errror_Ms($Nerror, $Merror)."");
		rollback();
     echo '<script language="javascript">
	       location.href="'.$href.'";
	       </script>';		    
	 }
mysql_close($cnn); 		 				
?>