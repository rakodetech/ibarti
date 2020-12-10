<?php
include_once "../funciones/funciones.php";
require "../autentificacion/aut_config.inc.php";
require "../" . class_bd;
require "../" . Leng;
$bd = new DataBase();

$region          = $_POST['region'];
$d_proyeccion = $_POST['d_proyeccion'];
$estado       = $_POST['estado'];
$linea        = $_POST['linea'];
$sub_linea    = $_POST['sub_linea'];
$cliente    = $_POST['cliente'];
$ubicacion    = $_POST['ubicacion'];
$producto    = $_POST['producto'];
$fecha_desde  = $_POST['fecha_desde'];
$fecha_D   = conversion($_POST['fecha_desde']);

$where = " WHERE al.vencimiento = 'T' ";

if ($linea != "TODOS") {
	$where .= " AND l.codigo = '$linea' ";  // cambie AND asistencia.co_cont = '$contracto'
}

if ($sub_linea != "TODOS") {
	$where  .= " AND sl.codigo = '$sub_linea' ";
}

if ($region != "TODOS") {
	$where .= " AND r.codigo = '$region' ";
}

if ($estado != "TODOS") {
	$where .= " AND e.codigo = '$estado' ";
}

if ($cliente != "TODOS") {
	$where .= " AND c.codigo = '$cliente' ";
}

if ($ubicacion != "TODOS") {
	$where .= " AND al.cod_cl_ubicacion = '$ubicacion' ";
}

if ($producto != "") {
	$where .= " AND al.cod_producto = '$producto' ";
}

$sql = "SELECT
IFNULL(a.codigo, 'SIN DOTAR'),
IFNULL(MAX(a.fecha), 'SIN DOTAR') fecha,
cu.cod_region,
r.descripcion region,
cu.cod_estado,
e.descripcion estado,
cu.cod_cliente,
c.nombre cliente,
c.abrev abrev_cliente,
al.cod_cl_ubicacion cod_ubicacion,
cu.descripcion ubicacion,
sl.cod_linea,
l.descripcion linea,
p.cod_sub_linea,
sl.descripcion sub_linea,
al.cod_producto,
p.descripcion producto,
IFNULL(ar.cantidad, 0) cantidad,
al.cantidad alcance,
(
	al.cantidad - IFNULL(SUM(ar.cantidad), 0)
) diff,
(
	IFNULL(SUM(ar.cantidad), 0) + (
		al.cantidad - IFNULL(SUM(ar.cantidad), 0)
	)
) cant_a_dotar,
DATE_ADD(
	DATE_FORMAT(
		IFNULL(MAX(a.fecha), '0001-01-01'),
		'%Y-%m-%d'
	),
	INTERVAL al.dias DAY
) < DATE_ADD('$fecha_D', INTERVAL " . $d_proyeccion . " DAY) vencido
FROM
clientes_ub_alcance al
LEFT JOIN ajuste_alcance a ON al.cod_cl_ubicacion = a.cod_ubicacion
LEFT JOIN ajuste_alcance_reng ar ON a.codigo = ar.cod_ajuste
AND al.cod_producto = ar.cod_producto
INNER JOIN clientes_ubicacion cu ON al.cod_cl_ubicacion = cu.codigo
INNER JOIN clientes c ON cu.cod_cliente = c.codigo
INNER JOIN productos p ON al.cod_producto = p.item
INNER JOIN prod_sub_lineas sl ON p.cod_sub_linea = sl.codigo
INNER JOIN prod_lineas l ON sl.cod_linea = l.codigo
INNER JOIN regiones r ON cu.cod_region = r.codigo
INNER JOIN estados e ON cu.cod_estado = e.codigo
" . $where . "
GROUP BY
a.fecha,
al.cod_cl_ubicacion,
al.cod_producto
HAVING
vencido = 1
ORDER BY
fecha ASC,
cod_cliente ASC,
cod_cl_ubicacion ASC,
cod_producto ASC";
?>

<table width="100%" border="0" align="center">
	<tr class="fondo00">
		<th width="10%" class="etiqueta">Fecha</th>
		<th width="15%" class="etiqueta"><?php echo $leng['cliente'] ?></th>
		<th width="15%" class="etiqueta"><?php echo $leng['ubicacion'] ?></th>
		<th width="15%" class="etiqueta">Sub Linea</th>
		<th width="20%" class="etiqueta">Producto </th>
		<th width="5%" class="etiqueta">Cant.</th>
		<th width="5%" class="etiqueta">Alc.</th>
		<th width="5%" class="etiqueta">Dif.</th>
		<th width="5%" class="etiqueta">Dotar</th>
	</tr>
	<?php
	$valor = 0;
	$query = $bd->consultar($sql);

	while ($datos = $bd->obtener_fila($query, 0)) {
		if ($valor == 0) {
			$fondo = 'fondo01';
			$valor = 1;
		} else {
			$fondo = 'fondo02';
			$valor = 0;
		}
		echo '<tr class="' . $fondo . '">
			      <td class="texto">' . $datos["fecha"] . '</td>
				  <td class="texto">' . longitud($datos["cliente"]) . '</td>
				  <td class="texto">' . longitud($datos["ubicacion"]) . '</td>
				  <td class="texto">' . longitud($datos["sub_linea"]) . '</td>
				  <td class="texto">' . longitudMax($datos["producto"]) . '</td>
				  <td class="texto">' . $datos["cantidad"] . '</td>
				  <td class="texto">' . $datos["alcance"] . '</td>
				  <td class="texto">' . $datos["diff"] . '</td>
				  <td class="texto">' . $datos["cant_a_dotar"] . '</td>
           </tr>';
	}; ?>
</table>