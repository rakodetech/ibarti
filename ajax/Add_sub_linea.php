<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase();

$codigo   = $_POST['codigo'];

	$sql = " SELECT codigo, descripcion FROM prod_sub_lineas
              WHERE cod_linea = '$codigo'
                AND status = 'T'
              ORDER BY descripcion ASC ";

   $query = $bd->consultar($sql);

	echo'<select name="sub_linea" id="sub_linea" style="width:250px" required>
			     <option value="">Seleccione...</option>';
			  	 while($datos=$bd->obtener_fila($query,0)){

		echo '<option value="'.$datos[0].'">'.$datos[1].'</option>';
				}
		  echo'</select>';
mysql_free_result($query);
?>
