<?php
define("SPECIALCONSTANT",true);
require "../../../../autentificacion/aut_config.inc.php";
require_once "../../../../".class_bdI;
$bd = new DataBase();
$ubic         = $_POST['ubicacion'];
$apertura     = $_POST['apertura'];

	$result = array();
	$sql = "SELECT a.cod_ficha ficha, conceptos.abrev concepto, date_format(a.fecha, 'd%d') dia,  CONCAT(ficha.apellidos,' ',ficha.nombres) ap_nombre, ficha.cedula
	FROM
	planif_cliente_trab_det AS a
	INNER JOIN ficha ON a.cod_ficha = ficha.cod_ficha
	LEFT JOIN turno ON a.cod_turno = turno.codigo
	LEFT JOIN horarios ON turno.cod_horario = horarios.codigo
	RIGHT JOIN conceptos ON horarios.cod_concepto = conceptos.codigo
	WHERE a.cod_planif_cl ='$apertura'
	AND a.cod_ubicacion ='$ubic'
	ORDER BY 1,3";

	$qry  = $bd->consultar($sql);
	while($rows=$bd->obtener_name($qry)){
		$result[] = $rows;
	}
	print_r(json_encode($result));
	return json_encode($result);

?>