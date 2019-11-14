<?php
include_once "../funciones/funciones.php";
require "../autentificacion/aut_config.inc.php";
require "../".class_bd;
require "../".Leng;
$bd = new DataBase();

$rol        = $_POST['rol'];
$region     = $_POST['region'];
$estado     = $_POST['estado'];
$contrato   = $_POST['contrato'];
$cliente    = $_POST['cliente'];
$ubicacion  = $_POST['ubicacion'];
$trabajador = $_POST['trabajador'];

$fecha_D   = conversion($_POST['fecha_desde']);
$fecha_H   = conversion($_POST['fecha_hasta']);

$where = " WHERE planif_clientes_trab_det.fecha BETWEEN \"$fecha_D\" AND \"$fecha_H\"
AND turno.cod_horario = horarios.codigo
AND planif_clientes_trab.cod_cliente = clientes.codigo
AND planif_clientes_trab.cod_ubicacion = clientes_ubicacion.codigo
AND planif_clientes_trab.cod_rotacion = rotacion.codigo
AND planif_clientes_trab.cod_ficha = ficha.cod_ficha
AND trab_roles.cod_ficha = ficha.cod_ficha
AND ficha.cedula = preingreso.cedula
AND trab_roles.cod_rol = roles.codigo
AND ficha.cod_region = regiones.codigo
AND ficha.cod_contracto = contractos.codigo
AND preingreso.cod_cargo = cargos.codigo
AND preingreso.cod_estado = estados.codigo";


if($rol != "TODOS"){
	$where .= " AND roles.codigo  = '$rol' ";
}

if($region != "TODOS"){
	$where  .= " AND ficha.cod_region = '$region' ";
}

if($estado != "TODOS"){
	$where  .= " AND estados.codigo = '$estado' ";
}

if($contrato != "TODOS"){
	$where   .= " AND contractos.codigo = '$contrato' ";
}

if($trabajador != NULL){
	$where   .= " AND  ficha.cod_ficha = '$trabajador' ";
}

if($cliente  != "TODOS"){
	$where   .= " AND planif_clientes_trab.cod_cliente = '$cliente' ";
}

if($ubicacion != "TODOS"){
	$where   .= " AND planif_clientes_trab.cod_ubicacion = '$ubicacion' ";
}


$sql = "SELECT planif_clientes_trab_det.fecha, roles.descripcion AS rol,
regiones.descripcion AS region, estados.descripcion AS estado,
clientes.nombre AS cliente,  clientes_ubicacion.descripcion AS ubicacion,
contractos.descripcion AS contrato, cargos.descripcion AS cargo ,
planif_clientes_trab.cod_ficha, CONCAT(preingreso.apellidos,' ',preingreso.nombres) AS ap_nombre,
rotacion.abrev, rotacion.descripcion AS rotacion,
horarios.nombre AS horario
FROM
planif_clientes_trab
INNER JOIN planif_clientes_trab_det ON planif_clientes_trab.codigo = planif_clientes_trab_det.cod_planif_cl_trab 
INNER JOIN turno ON planif_clientes_trab_det.cod_turno = turno.codigo ,clientes ,clientes_ubicacion ,horarios ,
rotacion ,ficha ,preingreso ,trab_roles ,roles ,regiones ,contractos ,cargos ,estados
$where
ORDER BY 1, 2 ASC ";

?><table width="100%" border="0" align="center">
	<tr class="fondo00">
		<th width="8%" class="etiqueta">Fecha</th>
		<th width="8%" class="etiqueta"><?php echo $leng['ficha']?></th>
		<th width="20%" class="etiqueta"><?php echo $leng['trabajador']?></th>
		<th width="20%" class="etiqueta"><?php echo $leng['cliente']?></th>
		<th width="20%" class="etiqueta"><?php echo $leng['ubicacion']?></th>
		<th width="9%" class="etiqueta">Rotacion </th>
		<th width="15%" class="etiqueta">Horario </th>
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
		<td class="texto">'.longitudMin($datos["cod_ficha"]).'</td>
		<td class="texto">'.longitud($datos["ap_nombre"]).'</td>
		<td class="texto">'.longitudMin($datos["cliente"]).'</td>
		<td class="texto">'.longitudMin($datos["ubicacion"]).'</td>
		<td class="texto">'.longitudMin($datos["abrev"]).'</td>
		<td class="texto">'.longitudMin($datos["horario"]).'</td>
		</tr>';
	};?>
</table>
