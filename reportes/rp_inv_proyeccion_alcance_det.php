<?php
define("SPECIALCONSTANT", true);
$Nmenu   = 576;
require("../autentificacion/aut_config.inc.php");
include_once('../' . Funcion);
require_once("../" . class_bdI);
require_once("../" . Leng);
$bd = new DataBase();

if (($_POST['fecha_desde'] == "")) {
	exit;
}
$reporte      = $_POST['reporte'];
$fecha_desde  = $_POST['fecha_desde'];
$fecha_D   = conversion($_POST['fecha_desde']);
$archivo      = "rp_inv_proyeccion_alcance" . $fecha_D . "";
$titulo       = "  PROYECCION DE DOTACION DE ALCANCES \n";
$region          = $_POST['region'];
$d_proyeccion = $_POST['d_proyeccion'];
$estado       = $_POST['estado'];
$linea        = $_POST['linea'];
$sub_linea    = $_POST['sub_linea'];
$cliente    = $_POST['cliente'];
$ubicacion    = $_POST['ubicacion'];
$producto    = $_POST['producto'];

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

if ($reporte == 'excel') {
	echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition:  filename=\"rp_$archivo.xls\";");

	$query01  = $bd->consultar($sql);
	echo "<table border=1>";

	echo "<tr><th> Fecha </th><th>" . $leng['region'] . "</th><th>" . $leng['estado'] . " </th><th> " . $leng['cliente'] . " </th>
	<th>Abrev. Cliente</th><th> " . $leng['ubicacion'] . " </th>
		<th> Linea </th><th> Sub Linea </th><th> Cod. Producto</th> <th> Producto </th>
		<th> Cantidad </th><th> Alcance </th><th> Diferencia </th><th> Cant. A Dotar </th></tr>";

	while ($row01 = $bd->obtener_num($query01)) {
		echo "<tr><td>" . $row01[0] . " </td><td>" . $row01[2] . "</td><td>" . $row01[4] . "</td><td>" . $row01[6] . "</td>
			<td>" . $row01[7] . "</td><td>" . $row01[9] . "</td><td>" . $row01[11] . "</td><td>" . $row01[13] . "</td><td>" . $row01[14] . "</td><td>" . $row01[15] . "</td>
			<td>" . $row01[16] . "</td><td>" . $row01[17] . "</td><td>" . $row01[18] . "</td><td>" . $row01[19] . "</td></tr>";
	}
	echo "</table>";
}

if ($reporte == 'pdf') {

	require_once('../' . ConfigDomPdf);
	$dompdf = new DOMPDF();

	$query  = $bd->consultar($sql);

	ob_start();

	require('../' . PlantillaDOM . '/header_ibarti_2.php');
	include('../' . pagDomPdf . '/paginacion_ibarti.php');

	echo "<br><div>
		<table>
		<tbody>
		<tr style='background-color: #4CAF50;'>
		<th width='12%'>Fecha</th>
		<th width='20%'>" . $leng['cliente'] . "</th>
		<th width='20%'>" . $leng['ubicacion'] . "</th>
		<th width='18%'>Producto</th>
		<th width='5%''>Cant.</th>
		<th width='5%'>Alc.</th>
		<th width='5%'>Dif.</th>
		<th width='5%'>Dotar</th>
		</tr>";

	$f = 0;
	while ($row = $bd->obtener_num($query)) {
		if ($f % 2 == 0) {
			echo "<tr>";
		} else {
			echo "<tr class='class= odd_row'>";
		}
		echo   " <td width='12%'>" . $row[0] . "</td>
			<td width='20%'>" . $row[6] . "</td>
			<td width='10%'>" . $row[9] . "</td>
			<td width='20%'>" . $row[11] . "</td>
			<td width='18%'>" . $row[16] . "</td>
			<td width='5%'>" . $row[17] . "</td>
			<td width='5%'>" . $row[18] . "</td>
			<td width='5%'>" . $row[19] . "</td></tr>";

		$f++;
	}

	echo "</tbody>
		</table>
		</div>
		</body>
		</html>";

	$dompdf->load_html(ob_get_clean(), 'UTF-8');
	$dompdf->set_paper('letter', 'landscape');
	$dompdf->render();
	$dompdf->stream($archivo, array('Attachment' => 0));
}
