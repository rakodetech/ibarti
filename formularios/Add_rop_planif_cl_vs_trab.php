<?php
define("SPECIALCONSTANT", true);
include_once "../funciones/funciones.php";
require "../autentificacion/aut_config.inc.php";
require "../".class_bdI;
require "../".Leng;
$bd = new DataBase();
$cliente    = $_POST['cliente'];
$ubicacion  = $_POST['ubicacion'];
$estado  = $_POST['estado'];
$region  = $_POST['region'];
$horario    = $_POST['horario'];
$fecha_D    = conversion($_POST['fecha_desde']);
$fecha_H    = conversion($_POST['fecha_hasta']);
$result = array();

$WHERE = " WHERE a.fecha BETWEEN \"$fecha_D\" AND \"$fecha_H\" AND a.`status`='T' ";
$WHERE_21 =" WHERE a.fecha BETWEEN \"$fecha_D\" AND \"$fecha_H\"";

$WHERE_22 = " AND a.cod_ubicacion = cu.codigo AND cu.cod_estado =  estados.codigo AND a.cod_cliente = cl.codigo
AND a.cod_turno = t.codigo AND t.cod_horario = h.codigo";

if( $region != "TODOS"){
	$WHERE .= " AND cu.cod_region = '$region' ";
	$WHERE_21 .= " AND cu.cod_region = '$region' ";
}

if( $estado != "TODOS"){
	$WHERE .= " AND cu.cod_estado = '$estado' ";
	$WHERE_21 .= " AND cu.cod_estado = '$estado' ";
}

if( $cliente != "TODOS"){
	$WHERE .= " AND a.cod_cliente = '$cliente' ";
	$WHERE_21 .= " AND a.cod_cliente = '$cliente' ";
}

if( $ubicacion != "TODOS"){
	$WHERE .= " AND a.cod_ubicacion = '$ubicacion' ";
	$WHERE_21 .= " AND a.cod_ubicacion = '$ubicacion' ";
}

if( $horario != "TODOS"){
	$WHERE .= " AND h.codigo = '$horario' ";
	$WHERE_21 .= " AND h2.codigo = '$horario' ";
}
/*
$sql = "SELECT a.fecha,a.cod_ubicacion,cu.descripcion ubicacion,a.cod_cliente,cl.abrev cliente,t.cod_horario,
h.nombre horario,estados.descripcion estado, COUNT(a.fecha) valor 
FROM planif_clientes_trab_det a,clientes cl,clientes_ubicacion cu,estados,turno t,horarios h
$WHERE_21
$WHERE_22 
GROUP BY 1,2,4,6 ASC";
*/
$sql = "SELECT 
a.fecha,a.cod_ubicacion,cu.descripcion ubicacion,a.cod_cliente,cl.abrev cliente,h2.codigo cod_horario,
h2.nombre horario,estados.descripcion estado, COUNT(a.fecha) valor
FROM
planif_clientes_trab_det AS a
INNER JOIN clientes cl ON a.cod_cliente = cl.codigo
INNER JOIN clientes_ubicacion cu ON a.cod_ubicacion = cu.codigo
INNER JOIN estados ON cu.cod_estado = estados.codigo
INNER JOIN ficha ON a.cod_ficha = ficha.cod_ficha
INNER JOIN turno ON a.cod_turno = turno.codigo
INNER JOIN horarios ON turno.cod_horario = horarios.codigo
INNER JOIN conceptos ON horarios.cod_concepto = conceptos.codigo
INNER JOIN horarios h2 ON conceptos.cod_horario = h2.codigo
$WHERE_21
GROUP BY 1,2,4,6 ASC";

$qry  = $bd->consultar($sql);
while($rows=$bd->obtener_name($qry)){
	$result['asistencia'][] = $rows;
}

$sql = "SELECT
a.fecha,
estados.descripcion estado,
a.cod_ubicacion,
cu.descripcion ubicacion,
a.cod_cliente,
cl.abrev cliente,
h.codigo cod_horario,
h.nombre horario,
Sum(a.cantidad) AS cantidad
FROM
clientes_contratacion_ap AS a
INNER JOIN turno AS t ON a.cod_turno = t.codigo
INNER JOIN horarios AS h ON t.cod_horario = h.codigo
INNER JOIN dias_habiles ON t.cod_dia_habil = dias_habiles.codigo
INNER JOIN dias_habiles_det ON dias_habiles_det.cod_dias_habiles = dias_habiles.codigo
INNER JOIN dias_tipo ON (dias_habiles_det.cod_dias_tipo = dias_tipo.dia AND Dia_semana(a.fecha)= dias_tipo.descripcion) 
OR (dias_habiles_det.cod_dias_tipo = dias_tipo.dia AND dias_tipo.tipo = 'D')
OR (dias_habiles_det.cod_dias_tipo = dias_tipo.dia AND DATE_FORMAT(a.fecha,'%d') = dias_tipo.descripcion) 
INNER JOIN clientes AS cl ON a.cod_cliente = cl.codigo
INNER JOIN clientes_ubicacion AS cu ON a.cod_ubicacion = cu.codigo
INNER JOIN clientes_ub_puesto AS cp ON a.cod_ub_puesto = cp.codigo
INNER JOIN estados ON cu.cod_estado = estados.codigo
$WHERE
GROUP BY a.cod_cliente, a.cod_ubicacion, h.codigo, a.fecha";

/*
$sql ="SELECT a.fecha, estados.descripcion estado, a.cod_ubicacion, cu.descripcion ubicacion, a.cod_cliente, cl.abrev cliente, 
h.codigo cod_horario, h.nombre horario, Sum(a.cantidad) AS cantidad 
FROM clientes_contratacion_ap AS a,clientes AS cl ,turno AS t,horarios AS h,dias_habiles,dias_habiles_det,
dias_tipo, clientes_ubicacion AS cu,clientes_ub_puesto AS cp,estados
WHERE a.cod_cliente = cl.codigo AND a.cod_turno = t.codigo AND  t.cod_horario = h.codigo 
AND t.cod_dia_habil = dias_habiles.codigo AND dias_habiles_det.cod_dias_habiles = dias_habiles.codigo 
AND ((dias_habiles_det.cod_dias_tipo = dias_tipo.dia AND Dia_semana(a.fecha)= dias_tipo.descripcion) 
OR (dias_habiles_det.cod_dias_tipo = dias_tipo.dia AND dias_tipo.tipo = 'D') 
OR (dias_habiles_det.cod_dias_tipo = dias_tipo.dia AND DATE_FORMAT(a.fecha,'%d') = dias_tipo.descripcion)) 
AND  a.cod_ubicacion = cu.codigo AND  a.cod_ub_puesto = cp.codigo AND cu.cod_estado = estados.codigo
$WHERE
GROUP BY a.cod_cliente, a.cod_ubicacion, h.codigo, a.fecha";*/

$query = $bd->consultar($sql);
while($rows=$bd->obtener_name($query)){
	$result['contrato'][] = $rows;
}

print_r(json_encode($result));
return json_encode($result);
?>
