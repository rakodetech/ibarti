<?php
define("SPECIALCONSTANT",true);
include_once "../funciones/funciones.php";
require "../autentificacion/aut_config.inc.php";
require_once "../".class_bdI;
require "../".Leng;

$bd = new DataBase();
$cliente         = $_POST['cliente'];
$ubic         = $_POST['ubicacion'];
$cargo         = $_POST['cargo'];
$turno         = $_POST['turno'];
$fecha_D = conversion($_POST['fecha_desde']);
$fecha_H = conversion($_POST['fecha_hasta']);
$usuario = $_POST['usuario'];

$WHERE = " WHERE a.fecha BETWEEN '$fecha_D' AND '$fecha_H' AND a.`status`='T' ";

if($cliente != 'TODOS'){
	$WHERE .= " AND a.cod_cliente = '$cliente' "; 
}

if($ubic != 'TODOS'){
	$WHERE .= " AND a.cod_ubicacion = '$ubic' "; 
}

if($turno != 'TODOS'){
	$WHERE .= " AND a.cod_turno = '$turno' "; 
}

if($cargo != 'TODOS'){
	$WHERE .= " AND a.cod_cargo = '$cargo' "; 
}

$sql ="SELECT
a.fecha,
cl.abrev cliente,
cu.descripcion ubicacion,
t.descripcion turno,
cg.descripcion cargo,
Sum(a.cantidad) cantidad,
SUM(a.cantidad * t.trab_cubrir) trab_neces
FROM
clientes_contratacion_ap AS a
INNER JOIN turno AS t ON a.cod_turno = t.codigo
INNER JOIN cargos AS cg ON a.cod_cargo = cg.codigo
INNER JOIN horarios AS h ON t.cod_horario = h.codigo
INNER JOIN dias_habiles ON t.cod_dia_habil = dias_habiles.codigo
INNER JOIN dias_habiles_det ON dias_habiles_det.cod_dias_habiles = dias_habiles.codigo
INNER JOIN dias_tipo ON dias_habiles_det.cod_dias_tipo = dias_tipo.dia AND Dia_semana(a.fecha)= dias_tipo.descripcion
OR (dias_habiles_det.cod_dias_tipo = dias_tipo.dia AND dias_tipo.tipo = 'D')
OR (dias_habiles_det.cod_dias_tipo = dias_tipo.dia AND DATE_FORMAT(a.fecha,'%d') = dias_tipo.descripcion)
INNER JOIN clientes AS cl ON a.cod_cliente = cl.codigo
INNER JOIN clientes_ubicacion AS cu ON a.cod_ubicacion = cu.codigo
$WHERE
GROUP BY a.cod_cliente, a.cod_ubicacion, a.cod_turno,a.cod_cargo, a.fecha";

?>
<table width="100%" border="0" align="center">
	<tr class="fondo00">
		<th width="10%" class="etiqueta">Fecha </th>
		<th width="15%" class="etiqueta"><?php echo $leng['cliente']?></th>
		<th width="20%" class="etiqueta"><?php echo $leng['ubicacion']?></th>
		<th width="15%" class="etiqueta"><?php echo $leng['turno']?></th>
		<th width="20%" class="etiqueta">Cargo</th>
		<th width="10%" class="etiqueta">Cantidad</th>
		<th width="10%" class="etiqueta">Trab. Neces.</th>
	</tr>
	<?php
	$valor = 0;
	$query = $bd->consultar($sql);

	while ($datos=$bd->obtener_fila($query,0)){
		if ($valor == 0){
			$fondo = 'fondo01';
			$valor = 1;
		}else{
			$fondo = 'fondo02';
			$valor = 0;
		}
		echo '<tr class="'.$fondo.'">
		<td class="texto">'.$datos["fecha"].'</td>
		<td class="texto">'.$datos["cliente"].'</td>
		<td class="texto">'.$datos["ubicacion"].'</td>
		<td class="texto">'.$datos["turno"].'</td>
		<td class="texto">'.longitud($datos["cargo"]).'</td>
		<td class="texto">'.$datos["cantidad"].'</td>
		<td class="texto">'.$datos["trab_neces"].'</td>';
	};?>
</table>