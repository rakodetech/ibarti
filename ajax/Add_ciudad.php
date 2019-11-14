<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase(); 

//require_once('../autentificacion/aut_config.inc.php'); 
//include_once('../funciones/mensaje_error.php');
$codigo   = $_POST['codigo'];
$tabla    = "estados";

	$sql = " SELECT codigo, descripcion FROM ciudades
              WHERE cod_estado = '$codigo'
                AND `status` = 'T'
              ORDER BY descripcion ASC ";

   $query = $bd->consultar($sql);

	echo'<select name="ciudad" style="width:250px" required>
			     <option value="">Seleccione...</option>'; 
			  	 while($datos=$bd->obtener_fila($query,0)){					 
		echo '<option value="'.$datos[0].'">'.$datos[1].'</option>';
				}
		  echo' 
        </select>';
mysql_free_result($query); ?>