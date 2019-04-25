<?php
include_once "../funciones/funciones.php";
require "../autentificacion/aut_config.inc.php";
require "../".class_bd;
require "../".Leng;
$bd = new DataBase();

$rol             = $_POST['rol'];
$region          = $_POST['region'];
$estado          = $_POST['estado'];
$ciudad          = $_POST['ciudad'];
$cliente          = $_POST['cliente'];
$ubicacion          = $_POST['ubicacion'];
$cargo           = $_POST['cargo'];
$contrato        = $_POST['contrato'];

$status          = $_POST['status'];
$trabajador      = $_POST['trabajador'];

$where = " WHERE v_ficha.cod_ficha = v_ficha.cod_ficha ";

if($_POST['fecha_desde'] != ""){
	$fecha_D         = conversion($_POST['fecha_desde']);
	$where .= " AND v_ficha.fec_ingreso >= \"$fecha_D\" ";
}

if($_POST['fecha_hasta'] != ""){
	$fecha_H         = conversion($_POST['fecha_hasta']);
	$where .= " AND v_ficha.fec_ingreso <= \"$fecha_H\" ";
}

if($rol != "TODOS"){
	$where .= " AND v_ficha.cod_rol = '$rol' ";
}

if($region != "TODOS"){
	$where .= " AND v_ficha.cod_region = '$region' ";
}

if($estado != "TODOS"){
		$where .= " AND v_ficha.cod_estado = '$estado' ";  // cambie AND asistencia.co_cont = '$contracto'
	}

	if($ciudad != "TODOS"){
		$where  .= " AND v_ficha.cod_ciudad = '$ciudad' ";
	}

	if($cliente != "TODOS"){
		$where .= " AND v_ficha.cod_cliente = '$cliente' ";
	}

	if($ubicacion != "TODOS"){
		$where .= " AND v_ficha.cod_ubicacion = '$ubicacion' "; 
	}

	if($cargo != "TODOS"){
		$where  .= " AND v_ficha.cod_cargo = '$cargo' ";
	}

	if($contrato != "TODOS"){
		$where  .= " AND v_ficha.cod_contracto = '$contrato' ";
	}

	if($status != "TODOS"){
		$where .= " AND v_ficha.cod_ficha_status = '$status' ";
	}
	if($trabajador != NULL){
		$where  .= " AND v_ficha.cod_ficha = '$trabajador' ";
	}

	// QUERY A MOSTRAR //
	$sql = "SELECT v_ficha.rol, v_ficha.region,
	v_ficha.estado, v_ficha.ciudad,
	v_ficha.cod_ficha, v_ficha.cedula,
	v_ficha.ap_nombre, v_ficha.cargo,
	v_ficha.contracto,v_ficha.ubicacion,v_ficha.abrev_cliente,
	v_ficha.`status`
	FROM v_ficha
	$where
	ORDER BY 2 ASC";
	echo $sql;
	?><table width="100%" border="0" align="center">
		<tr class="fondo00">
			<th width="15%" class="etiqueta"><?php echo $leng['rol']?></th>
			<th width="18%" class="etiqueta"><?php echo $leng['contrato']?></th>
			<th width="10%" class="etiqueta"><?php echo $leng['cliente']?></th>
			<th width="10%" class="etiqueta"><?php echo $leng['ubicacion']?></th>
			<th width="10%" class="etiqueta"><?php echo $leng['ficha']?></th>
			<th width="8%" class="etiqueta"><?php echo $leng['ci']?></th>
			<th width="22%" class="etiqueta"><?php echo $leng['trabajador']?></th>
			<th width="7%" class="etiqueta">Status</th>
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
			<td class="texto">'.$datos["rol"].'</td>
			<td class="texto">'.longitud($datos["contracto"]).'</td>
			<td class="texto">'.longitud($datos["abrev_cliente"]).'</td>
			<td class="texto">'.longitud($datos["ubicacion"]).'</td>
			<td class="texto">'.$datos["cod_ficha"].'</td>
			<td class="texto">'.$datos["cedula"].'</td>
			<td class="texto">'.longitud($datos["ap_nombre"]).'</td>
			<td class="texto">'.$datos["status"].'</td>
			</tr>';
		};?>
	</table>
