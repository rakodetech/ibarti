<?php
include_once "../funciones/funciones.php";
require "../autentificacion/aut_config.inc.php";
require "../".class_bd;
require "../".Leng;
$bd = new DataBase();

$fecha_D         = conversion($_POST['fecha_desde']);
$fecha_H         = conversion($_POST['fecha_hasta']);
$rol             = $_POST['rol'];
$region          = $_POST['region'];
$estado          = $_POST['estado'];
$cargo           = $_POST['cargo'];
$contrato        = $_POST['contrato'];
$horario           = $_POST['horario'];
$trabajador      = $_POST['trabajador'];

$where = " WHERE planif_clientes_trab_det.fecha BETWEEN \"$fecha_D\" AND \"$fecha_H\"
				 AND planif_clientes_trab_det.cod_ficha = v_ficha.cod_ficha  ";


if($rol != "TODOS"){
	$where .= " AND v_ficha.cod_rol = '$rol' ";
}

if($region != "TODOS"){
	$where .= " AND v_ficha.cod_region = '$region' ";
}

if($estado != "TODOS"){
		$where .= " AND v_ficha.cod_estado = '$estado' ";  // cambie AND asistencia.co_cont = '$contracto'
	}

	if($cargo != "TODOS"){
		$where  .= " AND v_ficha.cod_cargo = '$cargo' ";
	}

	if($contrato != "TODOS"){
		$where  .= " AND v_ficha.cod_contracto = '$contrato' ";
	}

	if($horario != "TODOS"){
		$where  .= " AND horarios.codigo = '$horario' ";
	}

	if($trabajador != "TODOS"){
		$where  .= " AND v_ficha.cod_ficha = '$trabajador' ";
	}
	// QUERY A MOSTRAR //
	$sql = "SELECT planif_clientes_trab_det.fecha, v_ficha.rol, v_ficha.region, v_ficha.estado,
	v_ficha.cod_ficha, v_ficha.cedula,  v_ficha.nombres, v_ficha.cargo,
	v_ficha.contracto, horarios.nombre AS horario,conceptos.abrev concepto
	FROM
	planif_clientes_trab_det
	INNER JOIN turno ON planif_clientes_trab_det.cod_turno = turno.codigo
	INNER JOIN horarios ON turno.cod_horario = horarios.codigo
	INNER JOIN conceptos ON horarios.cod_concepto = conceptos.codigo,
	v_ficha
	$where
	ORDER BY 1 ASC";
	?>
	<table width="100%" border="0" align="center">
		<tr class="fondo00">
			<th width="8%" class="etiqueta">Fecha </th>
			<th width="22%" class="etiqueta"><?php echo $leng['rol']?></th>
			<th width="10%" class="etiqueta"><?php echo $leng['ficha']?></th>
			<th width="10%" class="etiqueta"><?php echo $leng['ci']?></th>
			<th width="28%" class="etiqueta"><?php echo $leng['trabajador']?></th>
			<th width="22%" class="etiqueta"><?php echo $leng['horario']?></th>
			<th width="22%" class="etiqueta"><?php echo $leng['concepto']?></th>
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
			<td class="texto">'.longitud($datos["rol"]).'</td>
			<td class="texto">'.$datos["cod_ficha"].'</td>
			<td class="texto">'.$datos["cedula"].'</td>
			<td class="texto">'.longitud($datos["nombres"]).'</td>
			<td class="texto">'.longitud($datos["horario"]).'</td>
			<td class="texto">'.$datos["concepto"].'</td>';
		};?>
	</table>
