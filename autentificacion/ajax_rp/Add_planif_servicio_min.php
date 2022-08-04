<?php
define("SPECIALCONSTANT",true);
require "../autentificacion/aut_config.inc.php";
require_once "../".class_bdI;
$bd = new DataBase();
$ubic         = $_POST['ubicacion'];
$contratacion   = $_POST['contratacion'];
$usuario   = $_POST['usuario'];
if(isset($_POST['apertura'])){
	$WHERE = "WHERE a.cod_planif_cl ='".$_POST['apertura']."'
	AND a.cod_ubicacion ='$ubic'";
	$sql = "SELECT
	planif_cliente.fecha_inicio,
	planif_cliente.fecha_fin
	FROM planif_cliente
	WHERE planif_cliente.codigo = ".$_POST['apertura']."";

	$query  = $bd->consultar($sql);
	while($rows=$bd->obtener_fila($query)){
		$fecha_D = $rows['fecha_inicio'];
		$fecha_H = $rows['fecha_fin'];
	}
}else{
	$fecha_D = $_POST['fecha_D'];
	$fecha_H = $_POST['fecha_H'];
	$WHERE = "	WHERE a.fecha BETWEEN '$fecha_D' AND '$fecha_H'
	AND a.cod_ubicacion ='$ubic'";
}

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

$sql = "$SELECT p_planif_servicio_contrato_min('$contratacion','$ubic','$fecha_D','$fecha_H','$usuario')";

$query = $bd->consultar($sql);
while($rows=$bd->obtener_name($query)){
	$result['contrato'][] = $rows;
}

print_r(json_encode($result));
return json_encode($result);

?>