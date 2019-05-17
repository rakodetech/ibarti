<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase(); 

$codigo   = $_POST['codigo'];
$usuario  = $_POST['usuario'];
			
 $sql = " SELECT DISTINCT roles.codigo, roles.descripcion AS ROL
           FROM roles , trab_roles , ficha ,  control 
          WHERE roles.`status` = 'T' 
            AND roles.codigo = trab_roles.cod_rol 
            AND trab_roles.cod_ficha = ficha.cod_ficha  
            AND ficha.cod_ficha_status = control.ficha_activo
            AND ficha.cod_contracto = '$codigo'
		  ORDER BY 2 ASC ";
 
 $query = $bd->consultar($sql);

	echo'<select name="rol" id="rol" style="width:250px">
       	         <option value=""> Seleccione..</option>'; 
			  	 while($datos=$bd->obtener_fila($query,0)){					 
				$cod_rol = $datos[0];
				$rol     = $datos[1];
			
				$sql02 = " SELECT COUNT(asistencia_cierre.cod_rol) AS cantidad
						     FROM asistencia_apertura, asistencia_cierre
						    WHERE asistencia_apertura.`status` = 'T'
						   	  AND asistencia_apertura.cod_contracto = '$codigo'
							  AND asistencia_apertura.codigo = asistencia_cierre.cod_as_apertura
							  AND asistencia_apertura.cod_contracto = asistencia_cierre.cod_contracto
						 	  AND asistencia_cierre.cod_rol = '$cod_rol' ";
				$query02 = $bd->consultar($sql02);
				$result = $bd->obtener_fila($query02,0);		
					if($result[0]==0){
						
						echo '<option value="'.$cod_rol.'">'.$rol.'</option>';
					}
				 }
		  echo'</select>';
mysql_free_result($query);
?>