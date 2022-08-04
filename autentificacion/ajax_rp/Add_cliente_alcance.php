<?php
include_once "../funciones/funciones.php";
require "../autentificacion/aut_config.inc.php";
require "../".class_bd;
require "../".Leng;
$bd = new DataBase();

$region          = $_POST['region'];
$estado          = $_POST['estado'];
$ciudad          = $_POST['ciudad'];
$cliente          = $_POST['cliente'];
$ubicacion          = $_POST['ubicacion'];
$producto      = $_POST['producto'];
$vencimiento      = $_POST['vencimiento'];

$where = " 	WHERE clientes_ub_alcance.cod_producto = productos.item
AND clientes_ub_alcance.cod_cl_ubicacion = clientes_ubicacion.codigo
AND clientes_ubicacion.cod_cliente = clientes.codigo
AND clientes.cod_region = regiones.codigo
AND clientes_ubicacion.cod_estado = estados.codigo
AND clientes_ubicacion.cod_ciudad = ciudades.codigo ";


if($region != "TODOS"){
	$where .= " AND regiones.codigo = '$region' ";
}

if($estado != "TODOS"){
		$where .= " AND estados.codigo = '$estado' ";  // cambie AND asistencia.co_cont = '$contracto'
	}

	if($ciudad != "TODOS"){
		$where  .= " AND ciudades.codigo = '$ciudad' ";
	}

	if($cliente != "TODOS"){
		$where .= " AND clientes.codigo = '$cliente' ";
	}

	if($ubicacion != "TODOS"){
		$where .= " AND clientes_ubicacion.codigo = '$ubicacion' "; 
	}

	if($vencimiento != "TODOS"){
		$where .= " AND clientes_ub_alcance.vencimiento = '$vencimiento' "; 
	}

	if($producto != NULL){
		$where  .= " AND productos.item = '$producto' ";
	}

	// QUERY A MOSTRAR //
	$sql = "SELECT regiones.descripcion region,
	estados.descripcion estado,
	ciudades.descripcion ciudad,
	clientes.nombre cliente, 
	clientes_ubicacion.descripcion ubicacion,
	productos.descripcion producto,
	clientes_ub_alcance.cantidad,
	clientes_ub_alcance.dias,
	clientes_ub_alcance.vencimiento
	FROM clientes_ub_alcance, productos, clientes_ubicacion, clientes, regiones, estados, ciudades
	$where
	ORDER BY 5,6 ASC;";

	?><table width="100%" border="0" align="center">
		<tr class="fondo00">
			<th width="15%" class="etiqueta"><?php echo $leng['region']?></th>
			<th width="15%" class="etiqueta"><?php echo $leng['estado']?> </th>
			<th width="15%" class="etiqueta"><?php echo $leng['ciudad']?> </th>
			<th width="15%" class="etiqueta"><?php echo $leng['cliente']?> </th>
			<th width="10%" class="etiqueta"><?php echo $leng['ubicacion']?> </th>
			<th width="15%" class="etiqueta"><?php echo $leng['producto']?> </th>
			<th width="5%" class="etiqueta">Cantidad</th>
			<th width="5%" class="etiqueta">Días</th>
			<th width="5%" class="etiqueta">Aplica brvencimiento</th>
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
		echo '<tr class="'.$fondo.'" >
			<td class="texto">'.$datos["region"].'</td>
			<td class="texto">'.$datos["estado"].'</td>
			<td class="texto">'.$datos["ciudad"].'</td>
			<td class="texto">'.$datos["cliente"].'</td>
			<td class="texto">'.$datos["ubicacion"].'</td>
			<td class="texto">'.$datos["producto"].'</td>
			<td class="texto">'.$datos["cantidad"].'</td>
			<td class="texto">'.$datos["dias"].'</td>
			<td class="texto">'.valorF($datos["vencimiento"]).'</td>
			</tr>';
		};?>
	</table>
