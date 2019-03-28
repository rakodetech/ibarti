<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase();
$codigo   = $_POST['codigo'];
$relacion = $_POST['relacion'];

	$sql = " SELECT a.codigo, a.descripcion FROM almacenes a ,stock b
    WHERE b.cod_almacen = a.codigo 
    AND b.cod_producto = '$codigo' ORDER BY 2 ASC ";
   $query = $bd->consultar($sql);

	echo'<select name="almacen_'.$relacion.'" id="almacen_'.$relacion.'" style="width:200px"
	onchange="cantidad_maxima(this.value,'.$relacion.')" required>
			     <option value="">Seleccione...</option>';
			  	 while($datos=$bd->obtener_fila($query,0)){
		echo '<option value="'.$datos[0].'">'.$datos[1].'</option>';
				}
		  echo'</select>';
		  mysql_free_result($query);
?>
