<?php
define("SPECIALCONSTANT",true);
include_once "../funciones/funciones.php";
require "../autentificacion/aut_config.inc.php";
require_once "../".class_bdI;
$bd = new DataBase();
$cliente         = $_POST['cliente'];
$ubicacion        = $_POST['ubicacion'];

$whereS = " WHERE a.codigo = a.codigo ";
$whereC = " WHERE a.status = 'T' ";

if($_POST['fecha_desde'] != ""){
	$fecha_D         = conversion($_POST['fecha_desde']);
	$whereC .= " AND a.fecha >= \"$fecha_D\" ";
	$whereS .= " AND a.fecha >= \"$fecha_D\" ";
}

if($_POST['fecha_hasta'] != ""){
	$fecha_H         = conversion($_POST['fecha_hasta']);
	$whereS .= " AND a.fecha <= \"$fecha_H\" ";
	$whereC .= " AND a.fecha <= \"$fecha_H\" ";
}

if($cliente != "TODOS"){
	$whereS .= " AND a.cod_cliente = '$cliente' ";
	$whereC .= " AND a.cod_cliente = '$cliente' ";
}

if($ubicacion != "TODOS"){
	$whereS .= " AND a.cod_ubicacion = '$ubicacion' ";
	$whereC .= " AND a.cod_ubicacion = '$ubicacion' "; 
}


$sql = "SELECT 
a.codigo cod_planif,
a.cod_planif_cl_trab planif_cl_trab,
a.cod_planif_cl planif_cl,
CONCAT(Mes(a.fecha),'-',DATE_FORMAT(a.fecha,'%Y')) mes_anio,
a.cod_cliente,
a.cod_ubicacion,
a.cod_puesto_trabajo cod_puesto,
clientes_ub_puesto.nombre puesto,
a.cod_ficha ficha, 
horarios.nombre horario, 
(horarios.minutos_trabajo/60) horas,
conceptos.codigo cod_concepto,
conceptos.abrev concepto, 
a.fecha,  
CONCAT(ficha.apellidos,' ',ficha.nombres) ap_nombre, 
ficha.cedula,
h2.codigo cod_horario,
h2.nombre concepto_horario,
a.cod_turno
FROM
planif_clientes_trab_det AS a
INNER JOIN clientes_ub_puesto ON a.cod_puesto_trabajo = clientes_ub_puesto.codigo
INNER JOIN ficha ON a.cod_ficha = ficha.cod_ficha
INNER JOIN turno ON a.cod_turno = turno.codigo
LEFT JOIN horarios ON turno.cod_horario = horarios.codigo
LEFT JOIN conceptos ON horarios.cod_concepto = conceptos.codigo
INNER JOIN horarios h2 ON conceptos.cod_horario = h2.codigo
$whereS
GROUP BY a.cod_ubicacion,a.cod_puesto_trabajo,a.cod_ficha,a.cod_turno,a.fecha";

$qry  = $bd->consultar($sql);
while($rows=$bd->obtener_name($qry)){
	$result['servicio'][] = $rows;
}
$result['sql'][]= $sql;

$sql = "SELECT
ca.codigo cod_cargo, 
ca.descripcion cargo,
Dia_semana(a.fecha) dia_semana,
CONCAT(Mes(a.fecha),'-',DATE_FORMAT(a.fecha,'%Y')) mes_anio,
cl.nombre cliente,
a.cod_ubicacion,
a.cod_ub_puesto cod_puesto,
cp.nombre puesto,
cu.descripcion ubicacion,
a.fecha,
(h.minutos_trabajo /60)*Sum(a.cantidad) horas,
Sum(a.cantidad) AS cantidad,
h.codigo AS cod_horario,
h.nombre AS horario
FROM
clientes_contratacion_ap AS a
INNER JOIN turno AS t ON a.cod_turno = t.codigo
INNER JOIN cargos AS ca ON a.cod_cargo = ca.codigo
INNER JOIN horarios AS h ON t.cod_horario = h.codigo
INNER JOIN dias_habiles ON t.cod_dia_habil = dias_habiles.codigo
INNER JOIN dias_habiles_det ON dias_habiles_det.cod_dias_habiles = dias_habiles.codigo
INNER JOIN dias_tipo ON dias_habiles_det.cod_dias_tipo = dias_tipo.dia AND Dia_semana(a.fecha)= dias_tipo.descripcion
OR (dias_habiles_det.cod_dias_tipo = dias_tipo.dia AND dias_tipo.tipo = 'D')
OR (dias_habiles_det.cod_dias_tipo = dias_tipo.dia AND DATE_FORMAT(a.fecha,'%d') = dias_tipo.descripcion) 
INNER JOIN clientes AS cl ON a.cod_cliente = cl.codigo
INNER JOIN clientes_ubicacion AS cu ON a.cod_ubicacion = cu.codigo
INNER JOIN clientes_ub_puesto AS cp ON a.cod_ub_puesto = cp.codigo
$whereC
GROUP BY a.cod_cliente, a.cod_ubicacion,a.cod_ub_puesto, a.cod_turno, a.fecha";

$query = $bd->consultar($sql);
while($rows=$bd->obtener_name($query)){
	$result['contrato'][] = $rows;
}
$result['sql'][]= $sql;

print_r(json_encode($result));
return json_encode($result);

?>