<?php
define("SPECIALCONSTANT", true);
session_start();
$Nmenu   = 525;
require("../autentificacion/aut_config.inc.php");
include_once('../' . Funcion);
require_once("../" . class_bdI);
require_once("../" . Leng);
$bd = new DataBase();

$cliente           = $_POST['cliente'];
$region        = $_POST['region'];
$documento     = $_POST['documento'];
$doc_check     = $_POST['doc_check'];
$doc_vencimiento     = $_POST['doc_vencimiento'];
$doc_vencido     = $_POST['doc_vencido'];

$reporte       = $_POST['reporte'];
$trabajador    = $_POST['trabajador'];

$archivo       = "rp_cliente_documento_" . $fecha . "";
$titulo        = "  Reporte Documentos" . $leng['cliente'] . "\n";

if (isset($reporte)) {

	$where = "  WHERE
clientes.codigo = clientes_documentos.cod_cliente
AND clientes_documentos.cod_documento = documentos_cl.codigo
AND documentos_cl.`status` = 'T'
AND clientes.cod_region = regiones.codigo
";

	if ($cliente != "TODOS") {
		$where .= " AND clientes.codigo = '$cliente' ";
	}

	if ($region != "TODOS") {
		$where .= " AND regiones.codigo = '$region' ";
	}

	if ($documento != "TODOS") {
		$where  .= " AND clientes_documentos.cod_documento = '$documento' ";
	}

	if ($doc_check != "TODOS") {
		$where  .= " AND clientes_documentos.checks = '$doc_check' ";
	}
	if ($doc_vencimiento != "TODOS") {
		$where  .= " AND clientes_documentos.vencimiento = '$doc_vencimiento' ";
	}
	if ($doc_vencido != "TODOS") {
		if ($doc_vencido == "S") {
			$where  .= " AND clientes_documentos.venc_fecha < \"" . date("Y-m-d") . "\"";
		} else if ($doc_vencido == "N") {
			$where  .= "  AND (clientes_documentos.venc_fecha >= \"" . date("Y-m-d") . "\" OR ISNULL(clientes_documentos.venc_fecha)) ";
		}
	}

	// QUERY A MOSTRAR //
	$sql = "SELECT
clientes.nombre cliente,
regiones.descripcion region,
clientes_documentos.cod_documento,
documentos_cl.descripcion doc,
StatusD (clientes_documentos.checks) checks,
StatusD (
	clientes_documentos.vencimiento
) vencimiento,
IFNULL(clientes_documentos.venc_fecha, 'NO VENCE') venc_fecha,
clientes_documentos.fec_us_ing fec_ingreso
FROM
clientes,
clientes_documentos,
documentos_cl,
regiones
                $where
				ORDER BY 1 ASC
			 ";

	if ($reporte == 'excel') {
		echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition:  filename=\"$archivo.xls\";");

		$query01  = $bd->consultar($sql);
		echo "<table border=1>";
		echo "<tr><th> " . $leng['cliente'] . " </th><th> " . $leng['region'] . " </th><th> Cod. Documento </th><th> Documento </th><th> CHECKS </th> <th> VENCIMIENTO </th> 
		<th> FECHA VENCIMIENTO </th><th> Fecha de Ingreso </th></tr>";

		while ($row01 = $bd->obtener_num($query01)) {
			echo "<tr><td>" . $row01[0] . "</td><td>" . $row01[1] . "</td><td>'" . $row01[2] . "'</td><td>" . $row01[3] . "</td>
		           <td>" . $row01[4] . "</td><td>" . $row01[5] . "</td><td>" . $row01[6] . "</td><td>" . $row01[7] . "</td> </tr>";
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
            <th width='20%'>" . $leng['cliente'] . "</th>
            <th width='20%'>" . $leng['region'] . "</th>
            <th width='20%'>Documento</th>
            <th width='10%'>Checks</th>
			<th width='10%'>Venc.</th>
			<th width='10%'> Fecha Venc. </th>
			<th width='10%'> Fecha de Ingreso </th>
            </tr>";

		$f = 0;
		while ($row = $bd->obtener_num($query)) {
			if ($f % 2 == 0) {
				echo "<tr>";
			} else {
				echo "<tr class='class= odd_row'>";
			}
			echo   "<td width='20%'>" . $row[0] . "</td>
            <td width='20%'>" . $row[1] . "</td>
            <td width='20%'>" . $row[3] . "</td>
            <td width='10%'>" . $row[4] . "</td>
						<td width='10%'>" . $row[5] . "</td>
						<td width='10%'>" . $row[6] . "</td>
						<td width='10%'>" . $row[7] . "</td>";

			$f++;
		}

		echo "</tbody>
        </table>
</div>
</body>
</html>";

		$dompdf->load_html(ob_get_clean(), 'UTF-8');
		$dompdf->render();
		$dompdf->stream($archivo, array('Attachment' => 0));
	}
}
