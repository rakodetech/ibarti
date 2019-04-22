<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase();
$codigo   = $_POST['codigo'];
$relacion = $_POST['relacion'];

$sql = "
SELECT productos.item, productos.descripcion
FROM productos
WHERE productos.cod_linea = '$codigo'
AND productos.`status` = 'T'
AND productos.item IN (SELECT stock.cod_producto FROM stock WHERE stock.cod_producto = productos.item AND stock.stock_actual > 0 )
ORDER BY descripcion ASC;";
$query = $bd->consultar($sql);

echo'<select name="producto_'.$relacion.'" id="producto_'.$relacion.'" style="width:200px" 
onchange="Activar_almacen(this.value,'.$relacion.', \'select_3_'.$relacion.'\')" required>
<option value="">Seleccione...</option>';
while($datos=$bd->obtener_fila($query,0)){
	echo '<option value="'.$datos[0].'">'.$datos[1].'</option>';
}
echo'</select>';
mysql_free_result($query);
?>
