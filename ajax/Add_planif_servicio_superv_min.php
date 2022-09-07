<?php
define("SPECIALCONSTANT",true);
require "../autentificacion/aut_config.inc.php";
require_once "../".class_bdI;
$bd = new DataBase();
$cliente         = $_POST['cliente'];
$apertura = $_POST['apertura'];
$usuario   = $_POST['usuario'];

$sql = "SELECT f.cod_ficha, pcst.codigo cod_planif, CONCAT(Mes(csa.fecha),'-',DATE_FORMAT(csa.fecha,'%Y')) mes_anio, 
csa.cod_cliente, cl.nombre cliente, csa.cod_ubicacion, c.codigo cod_cargo, c.descripcion cargo,
pcst.cod_proyecto,		pcst.cod_actividad,	
h.nombre horario, (h.minutos_trabajo/60) horas,
ct.codigo cod_concepto,
ct.abrev concepto, 	cu.descripcion ubicacion, pcst.cod_turno,
pcst.fecha,  
CONCAT(f.apellidos,' ',f.nombres) ap_nombre, 
f.cedula,
h2.codigo cod_horario,
h2.nombre concepto_horario,
pcst.cod_turno
FROM clientes_supervision_ap csa, clientes cl, clientes_ubicacion cu, planif_clientes_superv pcs, cargos c, ficha f 
LEFT JOIN planif_clientes_superv_trab pcst ON  f.cod_ficha = pcst.cod_ficha AND pcst.cod_planif_cl = $apertura
					AND pcst.cod_cliente = '$cliente'
LEFT JOIN turno t ON pcst.cod_turno = t.codigo
LEFT JOIN horarios h ON t.cod_horario = h.codigo
LEFT JOIN conceptos ct ON h.cod_concepto = ct.codigo
LEFT JOIN horarios h2 ON ct.cod_horario = h2.codigo, control
WHERE  csa.cod_cliente = '$cliente'
AND csa.cod_cliente = cl.codigo
AND cl.codigo = cu.cod_cliente
AND csa.cod_ubicacion = cu.codigo
AND csa.cod_planif_cl = $apertura
AND f.cod_ficha_status= control.ficha_activo
AND pcs.cod_cliente = csa.cod_cliente
AND pcs.codigo = csa.cod_planif_cl 
AND f.cod_cargo = c.codigo
AND c.planificable = 'T'";

$result['sql'][] = $sql;
$qry  = $bd->consultar($sql);
while($rows=$bd->obtener_name($qry)){
	$result['servicio'][] = $rows;
}

$sql = "SELECT Dia_semana(a.fecha) dia_semana, CONCAT(Mes(a.fecha),'-',DATE_FORMAT(a.fecha,'%Y')) mes_anio, cl.nombre cliente,
a.cod_ubicacion, cu.descripcion ubicacion, a.fecha, 
(h.minutos_trabajo /60)*Sum(a.cantidad) horas, Sum(a.cantidad) AS cantidad, h.codigo AS cod_horario, h.nombre AS horario
FROM clientes_supervision_ap AS a,turno AS t,cargos ca, horarios AS h, dias_habiles, dias_habiles_det, dias_tipo,clientes AS cl,
clientes_ubicacion AS cu
WHERE a.cod_turno = t.codigo AND t.cod_horario = h.codigo AND t.cod_dia_habil = dias_habiles.codigo
AND dias_habiles_det.cod_dias_habiles = dias_habiles.codigo   
AND ((dias_habiles_det.cod_dias_tipo = dias_tipo.dia AND Dia_semana(a.fecha)= dias_tipo.descripcion) 
OR (dias_habiles_det.cod_dias_tipo = dias_tipo.dia AND dias_tipo.tipo = 'D') 
OR (dias_habiles_det.cod_dias_tipo = dias_tipo.dia AND DATE_FORMAT(a.fecha,'%d') = dias_tipo.descripcion))
AND a.cod_cliente = cl.codigo AND a.cod_ubicacion = cu.codigo
AND a.cod_cliente = '$cliente'
AND a.cod_planif_cl = $apertura AND a.`status`='T'  
GROUP BY a.cod_cliente, a.cod_ubicacion, a.cod_turno, a.fecha";
$result['sql'][] = $sql;
$query = $bd->consultar($sql);
while($rows=$bd->obtener_name($query)){
	$result['contrato'][] = $rows;
}

$sql = "SELECT 
t.codigo turno,
t.descripcion,
h.codigo horarios,
c.abrev conceptos
FROM 
turno t INNER JOIN horarios h ON t.cod_horario = h.codigo
LEFT JOIN conceptos c on h.cod_concepto = c.codigo
";
$result['sql'][] = $sql;
$qry  = $bd->consultar($sql);
while($rows=$bd->obtener_name($qry)){
	$result['conceptos'][] = $rows;
}

print_r(json_encode($result));
return json_encode($result);
?>