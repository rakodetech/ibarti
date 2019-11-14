<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase(); 
$codigo      = $_POST['codigo'];
$tamano      = $_POST['tamano'];

    $sql = "SELECT clientes_ub_puesto.codigo, clientes_ub_puesto.nombre
			  FROM clientes_ub_puesto 
			 WHERE clientes_ub_puesto.cod_cl_ubicacion = '$codigo' 
			   AND clientes_ub_puesto.`status` = 'T'
			 ORDER BY 2 ASC";

   $query = $bd->consultar($sql);
	echo'<select name="puesto" id="puesto" style="width:'.$tamano.'px" required >
			     <option value="TODOS">Seleccione...</option>'; 
    while($row02=$bd->obtener_fila($query,0)){
				echo '<option value="'.$row02[0].'">'.$row02[1].'</option>';
				}
		  echo'</select>';
mysql_free_result($query);?>		  