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
AND planif_clientes_trab_det.cod_cliente = clientes.codigo
AND planif_clientes_trab_det.cod_ubicacion = clientes_ubicacion.codigo
AND planif_clientes_trab_det.cod_ficha = v_ficha.cod_ficha";

if($rol != "TODOS"){
	$where .= " AND v_ficha.cod_rol  = '$rol' ";
}

if($region != "TODOS"){
	$where  .= " AND v_ficha.cod_region = '$region' ";
}

if($estado != "TODOS"){
	$where  .= " AND v_ficha.cod_estado = '$estado' ";
}

if($contrato != "TODOS"){
	$where   .= " AND v_ficha.cod_contracto = '$contrato' ";
}

if($trabajador != NULL){
	$where   .= " AND  v_ficha.cod_ficha = '$trabajador' ";
}

if($cliente  != "TODOS"){
	$where   .= " AND planif_clientes_trab_det.cod_cliente = '$cliente' ";
}

if($ubicacion != "TODOS"){
	$where   .= " AND planif_clientes_trab_det.cod_ubicacion = '$ubicacion' ";
}

$sql = "SELECT planif_clientes_trab_det.fecha, v_ficha.rol,
v_ficha.region, v_ficha.estado,
clientes.nombre AS cliente, clientes_ubicacion.descripcion AS ubicacion,
v_ficha.contracto, v_ficha.cargo,
planif_clientes_trab_det.cod_ficha,
v_ficha.ap_nombre, horarios.nombre  AS horario
FROM
planif_clientes_trab_det
INNER JOIN turno ON planif_clientes_trab_det.cod_turno = turno.codigo
INNER JOIN horarios ON turno.cod_horario = horarios.codigo ,
clientes ,
clientes_ubicacion ,
v_ficha
$where
ORDER BY 1, 2 ASC ";

?><table width="100%" border="0" align="center">
	<tr class="fondo00">
		<th width="8%" class="etiqueta">Fecha</th>
		<th width="10%" class="etiqueta"><?php echo $leng['ficha']?></th>
		<th width="25%" class="etiqueta"><?php echo $leng['trabajador']?></th>
		<th width="20%" class="etiqueta"><?php echo $leng['cliente']?></th>
		<th width="22%" class="etiqueta"><?php echo $leng['ubicacion']?></th>
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
		<td class="texto">'.longitud($datos["cod_ficha"]).'</td>
		<td class="texto">'.longitud($datos["ap_nombre"]).'</td>
		<td class="texto">'.longitud($datos["cliente"]).'</td>
		<td class="texto">'.longitud($datos["ubicacion"]).'</td>
		<td class="texto">'.longitud($datos["horario"]).'</td>
		</tr>';
	};?>
</table>
