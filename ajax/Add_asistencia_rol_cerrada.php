<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase(); 

$codigo   = $_POST['codigo'];
$usuario  = $_POST['usuario'];
			
	$sql = " SELECT DISTINCT roles.codigo, roles.descripcion AS rol
               FROM asistencia_apertura , asistencia_cierre , usuario_roles,  roles
              WHERE asistencia_apertura.`status` = 'T' 
			    AND asistencia_apertura.cod_contracto = '$codigo' 
			    AND asistencia_apertura.codigo = asistencia_cierre.cod_as_apertura 
				AND asistencia_apertura.cod_contracto = asistencia_cierre.cod_contracto 
				AND usuario_roles.cod_usuario = '$usuario'
				AND usuario_roles.cod_rol = roles.codigo
				AND  asistencia_cierre.cod_rol = roles.codigo
           ORDER BY 2 ASC ";

 $query = $bd->consultar($sql);

	echo'<select name="rol" id="rol" style="width:250px" onchange="Asistencia_Fec()">
	             <option value=""> Seleccione..</option>'; 
			  	 while($datos=$bd->obtener_fila($query,0)){					 
				echo '<option value="'.$datos[0].'">'.$datos[1].'</option>';
				}
		  echo'</select>';
  mysql_free_result($query);
?>