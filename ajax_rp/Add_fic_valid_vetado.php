<?php
define("SPECIALCONSTANT", true);
include_once "../funciones/funciones.php";
require "../autentificacion/aut_config.inc.php";
require "../".class_bdI;
require "../".Leng;
$bd = new DataBase();

$codigo = $_POST['codigo'];
$cliente = $_POST['cliente'];

$result = array();

$sql = "SELECT CONCAT(ficha.apellidos,' ',ficha.nombres,' (',a.cod_ficha,')') trabajador,b.nombre cliente,c.descripcion ubicacion
FROM
clientes_vetados AS a
INNER JOIN clientes AS b ON a.cod_cliente = b.codigo
INNER JOIN clientes_ubicacion AS c ON a.cod_ubicacion = c.codigo AND b.codigo = c.cod_cliente
INNER JOIN ficha ON a.cod_ficha = ficha.cod_ficha
WHERE a.cod_ficha = '$codigo' AND a.cod_cliente = '$cliente'";

$qry  = $bd->consultar($sql);
while($rows=$bd->obtener_name($qry)){
	$result[] = $rows;
}

print_r(json_encode($result));
return json_encode($result);

