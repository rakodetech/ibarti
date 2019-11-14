<?php
define("SPECIALCONSTANT",true);
include_once "../funciones/funciones.php";
require "../autentificacion/aut_config.inc.php";
require "../".class_bdI;
require "../".Leng;
$bd = new DataBase();

$fecha_D         = conversion($_POST['fecha_desde']);
$fecha_H         = conversion($_POST['fecha_hasta']);
$rol             = $_POST['rol'];
$region          = $_POST['region'];
$estado          = $_POST['estado'];
$cargo           = $_POST['cargo'];
$contrato        = $_POST['contrato'];
$cliente        = $_POST['cliente'];
$ubicacion        = $_POST['ubicacion'];
$usuario        = $_POST['usuario'];

$where = " 	WHERE v_ficha.cod_ficha_status = control.ficha_activo AND clientes.codigo = clientes_ubicacion.cod_cliente AND clientes_ubicacion.codigo = v_ficha.cod_ubicacion ";


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

	if($cliente != "TODOS"){
		$where  .= " AND clientes.codigo = '$cliente'";
	}

	if($ubicacion != "TODOS"){
		$where  .= " AND v_ficha.cod_ubicacion = '$ubicacion' AND clientes.codigo = clientes_ubicacion.cod_cliente
		AND clientes_ubicacion.codigo = v_ficha.cod_ubicacion ";
	}

	$arrayFechas=devuelveArrayFechasEntreOtrasDos($fecha_D, $fecha_H);

	$longitud = count($arrayFechas);
	
	?>
	<table width="100%" border="0" align="center">
		<tr class="fondo00">
			<th width="10%" class="etiqueta">Fecha</th>
			<th width="15%" class="etiqueta"><?php echo $leng['rol']?></th>
			<th width="10%" class="etiqueta"><?php echo $leng['estado']?></th>
			<th width="10%" class="etiqueta"><?php echo $leng['cliente']?></th>
			<th width="15%" class="etiqueta"><?php echo $leng['ubicacion']?></th>
			<th width="10%" class="etiqueta"><?php echo $leng['ficha']?></th>
			<th width="10%" class="etiqueta"><?php echo $leng['ci']?></th>
			<th width="25%" class="etiqueta"><?php echo $leng['trabajador']?></th>
		</tr>
		<?php
		$valor = 0;
	//Recorro todas las fechas del rango
		for($i=0; $i<$longitud; $i++)
		{
      //saco el valor de cada elemento
			$sql = "SELECT  \"$arrayFechas[$i]\" fecha, v_ficha.rol, v_ficha.region, v_ficha.estado,clientes.abrev cliente,
			clientes_ubicacion.descripcion ubicacion, v_ficha.cod_ficha, v_ficha.cedula, v_ficha.ap_nombre, v_ficha.cargo, v_ficha.contracto,
			Count(planif_clientes_trab_det.cod_ficha) AS cantidad 
			FROM v_ficha 
			LEFT JOIN planif_clientes_trab_det ON v_ficha.cod_ficha = planif_clientes_trab_det.cod_ficha 
			AND planif_clientes_trab_det.fecha = \"$arrayFechas[$i]\" , control, clientes, clientes_ubicacion
			$where
			GROUP BY v_ficha.rol, v_ficha.region, v_ficha.estado,cliente,ubicacion, v_ficha.cod_ficha, v_ficha.cedula, v_ficha.nombres, v_ficha.cargo,v_ficha.contracto HAVING cantidad = 0 ";

			$query = $bd->consultar($sql);

			while ($datos=$bd->obtener_name($query,0)){
				if ($valor == 0){
					$fondo = 'fondo01';
					$valor = 1;
				}else{
					$fondo = 'fondo02';
					$valor = 0;
				}
				echo '<tr class="'.$fondo.'">
				<td class="texto">'.longitud($datos["fecha"]).'</td>
				<td class="texto">'.longitud($datos["rol"]).'</td>
				<td class="texto">'.longitud($datos["estado"]).'</td>
				<td class="texto">'.longitud($datos["cliente"]).'</td>
				<td class="texto">'.longitud($datos["ubicacion"]).'</td>
				<td class="texto">'.$datos["cod_ficha"].'</td>
				<td class="texto">'.$datos["cedula"].'</td>
				<td class="texto">'.longitud($datos["ap_nombre"]).'</td>'; 
			};
	}
	?>
			</table>
