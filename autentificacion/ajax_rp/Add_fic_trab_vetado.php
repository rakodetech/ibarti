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
	$where .= " AND cv.fec_us_ing >= \"$fecha_D\" ";
}

if($_POST['fecha_hasta'] != ""){
	$fecha_H         = conversion($_POST['fecha_hasta']);
	$where .= " AND cv.fec_us_ing <= \"$fecha_H\" ";
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
		$where .= " AND cv.cod_cliente = '$cliente' ";
	}

	if($ubicacion != "TODOS"){
		$where .= " AND cv.cod_ubicacion = '$ubicacion' "; 
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
	$sql = "SELECT v_ficha.cod_ficha,v_ficha.ap_nombre,v_ficha.cargo,cl.abrev cliente, 
	cu.descripcion ubicacion,cv.fec_us_ing fec_desde,v_ficha.`status`,cl.codigo cod_cliente,cu.codigo cod_ubicacion
	FROM v_ficha INNER JOIN clientes_vetados cv ON v_ficha.cod_ficha = cv.cod_ficha 
	INNER JOIN clientes cl ON cv.cod_cliente = cl.codigo 
	INNER JOIN clientes_ubicacion cu ON cv.cod_ubicacion = cu.codigo 
	$where
	ORDER BY 6 ASC;";

	?><table width="100%" border="0" align="center">
		<tr class="fondo00">
			<th width="10%" class="etiqueta"><?php echo $leng['ficha']?></th>
			<th width="25%" class="etiqueta"><?php echo $leng['trabajador']?></th>
			<th width="15%" class="etiqueta"><?php echo $leng['cliente']?> V.</th>
			<th width="15%" class="etiqueta"><?php echo $leng['ubicacion']?> V.</th>
			<th width="10%" class="etiqueta">Fecha Desde</th>
			<th width="10%" class="etiqueta">Status</th>
			<!--<th width="5%" class="etiqueta">Consultar</th>-->
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
			echo '<tr class="'.$fondo.'" onclick="Cons_vetado(\''.$datos['cod_ficha'].'\',\''.$datos["cod_cliente"].'\',\''.$datos["cod_ubicacion"].'\',\'consultar\')" title="Consultar ('.$datos['cod_ficha'].')">
			<td class="texto">'.$datos["cod_ficha"].'</td>
			<td class="texto">'.longitud($datos["ap_nombre"]).'</td>
			<td class="texto">'.$datos["cliente"].'</td>
			<td class="texto">'.longitud($datos["ubicacion"]).'</td>
			<td class="texto">'.$datos["fec_desde"].'</td>
			<td class="texto">'.$datos["status"].'</td>
			</tr>';
		};?>
	</table>
