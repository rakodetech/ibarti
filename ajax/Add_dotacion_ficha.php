<?php
define("SPECIALCONSTANT", true);
require  "../autentificacion/aut_config.inc.php";
require_once "../".Funcion;
require_once  "../".class_bdI;
$bd = new Database;

$ficha = $_POST['cod_ficha'];
$result = [];

$sql = "SELECT  CONCAT(productos.descripcion,' (',productos.item,') ') producto, ficha_dotacion.cantidad,
IFNULL(prod_dotacion.fec_us_mod,'SIN DOTACION') ult_dotacion
FROM ficha_dotacion LEFT JOIN prod_dotacion on prod_dotacion.cod_ficha = ficha_dotacion.cod_ficha
LEFT JOIN prod_dotacion_det on prod_dotacion.codigo = prod_dotacion_det.cod_dotacion AND prod_dotacion_det.cod_producto = ficha_dotacion.cod_item,
productos
WHERE
ficha_dotacion.cod_ficha = '$ficha'
AND ficha_dotacion.cod_item = productos.item
";
$query         = $bd->consultar($sql);
while ($datos= $bd->obtener_fila($query)) {
	$result[] = $datos;
}	
echo json_encode($result);
?>