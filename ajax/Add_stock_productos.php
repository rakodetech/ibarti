<?php
define("SPECIALCONSTANT", true);
require "../autentificacion/aut_config.inc.php";
require "../".class_bdI;
$bd = new DataBase();

$codigo        = $_POST['codigo'];

$where = " WHERE b.cod_producto = a.item AND a.cod_talla = c.codigo AND d.codigo = a.cod_sub_linea";

if($codigo != "TODOS"){
	$where .= " AND b.cod_almacen= '$codigo' ";
}

$sql = " SELECT a.item, IF(d.talla = 'T', CONCAT(a.descripcion,' ',c.descripcion), a.descripcion ) descripcion FROM productos a ,stock b ,tallas c,prod_sub_lineas d
$where  ORDER BY 2 ASC ";

$query = $bd->consultar($sql);

echo'<select name="producto" id="producto" style="width:120px;" onchange="Add_filtroX()" required>
<option value="TODOS">TODOS</option>';
while($datos=$bd->obtener_fila($query,0)){

	echo '<option value="'.$datos[0].'">'.$datos[1].'</option>';
}
echo'</select>';
?>
