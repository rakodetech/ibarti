<?php
define("SPECIALCONSTANT",true);
require "../autentificacion/aut_config.inc.php";
require_once "../".class_bdI;
$bd = new DataBase();
$cliente         = $_POST['cliente'];
$ubic         = $_POST['ubicacion'];
$contratacion   = $_POST['contratacion'];
$fecha_D = $_POST['fecha_D'];
$fecha_H = $_POST['fecha_H'];
$usuario   = $_POST['usuario'];

$WHERE = "	WHERE a.fecha BETWEEN '$fecha_D' AND '$fecha_H'
	AND a.cod_ubicacion ='$ubic'";

$sql = "SELECT a.cod_ficha ficha, horarios.nombre horario, conceptos.abrev concepto, a.fecha,  CONCAT(ficha.apellidos,' ',ficha.nombres) ap_nombre, ficha.cedula, h2.nombre concepto_horario
FROM
planif_cliente_trab_det AS a
INNER JOIN ficha ON a.cod_ficha = ficha.cod_ficha
INNER JOIN turno ON a.cod_turno = turno.codigo
LEFT JOIN horarios ON turno.cod_horario = horarios.codigo
LEFT JOIN conceptos ON horarios.cod_concepto = conceptos.codigo
INNER JOIN horarios h2 ON conceptos.cod_horario = h2.codigo
$WHERE
ORDER BY 1,4 ASC";

$qry  = $bd->consultar($sql);
while($rows=$bd->obtener_name($qry)){
	$result['servicio'][] = $rows;
}

$sql = "$SELECT p_planif_servicio_contrato('$contratacion','$ubic','$fecha_D','$fecha_H','$usuario')";

$query = $bd->consultar($sql);
while($rows=$bd->obtener_name($query)){
	$result['contrato'][] = $rows;
}

print_r(json_encode($result));
return json_encode($result);

?>