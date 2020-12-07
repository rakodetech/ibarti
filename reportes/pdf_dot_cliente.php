<?php
define("SPECIALCONSTANT", true);
require "../autentificacion/aut_config.inc.php";
include "../" . Funcion;
require "../" . class_bdI;
require "../" . Leng;
$bd = new DataBase();
$bde = new DataBase();
require_once('../' . ConfigDomPdf);

$codigo      = $_POST["codigo"];

$sql = "SELECT ajuste_alcance.codigo, ajuste_alcance.fecha fec_dotacion, 
IF(ajuste_alcance.anulado = 'T', 'SI', 'NO') anulado,
ajuste_alcance.motivo descripcion, clientes_ubicacion.cod_cliente, clientes.nombre cliente,
 ajuste_alcance.cod_ubicacion, clientes_ubicacion.descripcion ubicacion
FROM ajuste_alcance, clientes, clientes_ubicacion
WHERE ajuste_alcance.codigo = " . $codigo . "
AND clientes.codigo = clientes_ubicacion.cod_cliente
AND clientes_ubicacion.codigo = ajuste_alcance.cod_ubicacion";
//query Cliente
$queryc = $bd->consultar($sql);

$sql02 = "SELECT
IF (
	prod_sub_lineas.talla = 'T',
	CONCAT(
		productos.descripcion,
		' ',
		tallas.descripcion
	),
	productos.descripcion
) producto,
 prod_lineas.descripcion AS linea,
 prod_sub_lineas.descripcion AS sub_linea,
 ajuste_alcance_reng.cantidad,
 ajuste_alcance_reng.cod_ajuste,
ajuste_alcance_reng.reng_num
FROM
	ajuste_alcance_reng,
	productos,
	prod_lineas,
	prod_sub_lineas,
	tallas
WHERE
	ajuste_alcance_reng.cod_ajuste =  " . $codigo . "
AND ajuste_alcance_reng.cod_producto = productos.item
AND productos.cod_linea = prod_lineas.codigo
AND productos.cod_sub_linea = prod_sub_lineas.codigo
AND productos.cod_talla = tallas.codigo;";
//query Producto
$queryp = $bd->consultar($sql02);

if ($row = $bd->obtener_name($queryc)) {
	ob_start();
	$titulo = 'DOTACIÓN DE CLIENTE';
	require_once('../' . PlantillaDOM . '/unicas/prod_dotacion_cliente.php');
} else {
	echo "<h3>Error</h3>";
}
