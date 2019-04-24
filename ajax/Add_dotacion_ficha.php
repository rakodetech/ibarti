<?php
define("SPECIALCONSTANT", true);
require  "../autentificacion/aut_config.inc.php";
require_once "../".Funcion;
require_once  "../".class_bdI;
$bd = new Database;

$ficha = $_POST['cod_ficha'];
$result = [];

$sql = "SELECT  CONCAT(productos.descripcion,' (',productos.item,') ') producto, ficha_dotacion.cantidad,
IFNULL((SELECT MAX(prod_dotacion.fec_us_mod) FROM prod_dotacion, prod_dotacion_det
WHERE prod_dotacion.codigo = prod_dotacion_det.cod_dotacion
AND prod_dotacion_det.cod_producto = ficha_dotacion.cod_item
AND prod_dotacion.cod_ficha = ficha_dotacion.cod_ficha) ,'SIN DOTACION') ult_dotacion
FROM ficha_dotacion ,
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