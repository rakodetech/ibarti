<?php
define("SPECIALCONSTANT", true);
require "../autentificacion/aut_config.inc.php";
require "../".class_bdI;
$bd = new DataBase();

$codigo        = $_POST['codigo'];

$where = " WHERE b.cod_producto = a.item ";

if($codigo != "TODOS"){
	$where .= " AND b.cod_almacen= '$codigo' ";
}

$sql = " SELECT a.item, a.descripcion FROM productos a ,stock b 
$where  ORDER BY 2 ASC ";

$query = $bd->consultar($sql);

echo'<select name="producto" id="producto" style="width:120px;" onchange="Add_filtroX()" required>
<option value="TODOS">TODOS</option>';
while($datos=$bd->obtener_fila($query,0)){

	echo '<option value="'.$datos[0].'">'.$datos[1].'</option>';
}
echo'</select>';
?>
