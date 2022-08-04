<?php
define("SPECIALCONSTANT", true);
session_start();
$Nmenu   = 592;
require("../autentificacion/aut_config.inc.php");
include_once('../funciones/funciones.php');
require_once("../" . class_bdI);
require_once("../" . Leng);
$bd = new DataBase();
$perfil             = $_POST['perfil'];
$status          = $_POST['status'];
$usuario      = $_POST['usuario_filter'];
$reporte         = $_POST['reporte'];
$archivo         = "rp_log_cambio_clave_" . $fecha . "";
$titulo          = "  REPORTE LOG CAMBIO de CLAVE \n";

if (isset($reporte)) {

	$where = " WHERE v_log_cambio_clave.cod_usuario = v_log_cambio_clave.cod_usuario ";

	if ($_POST['fecha_desde'] != "") {
		$fecha_D         = conversion($_POST['fecha_desde']);
		$where .= " AND v_log_cambio_clave.fecha >= \"$fecha_D\" ";
	}

	if ($_POST['fecha_hasta'] != "") {
		$fecha_H         = conversion($_POST['fecha_hasta']);
		$where .= " AND v_log_cambio_clave.fecha <= \"$fecha_H\" ";
	}

	if ($perfil != "TODOS") {
		$where .= " AND v_log_cambio_clave.cod_perfil = '$perfil' ";
	}

	if ($status != "TODOS") {
		$where .= " AND v_log_cambio_clave.cod_status = '$status' ";
	}
	if ($usuario != NULL) {
		$where  .= " AND v_log_cambio_clave.cod_usuario = '$usuario' ";
	}

	// QUERY A MOSTRAR //
	$sql = "SELECT fecha, perfil_usuario, ap_nombre_usuario, perfil_usuario_mod, ap_nombre_usuario_mod, status_usuario
		FROM v_log_cambio_clave
		$where
		ORDER BY 2 ASC";

	if ($reporte == 'excel') {
		echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition:  filename=\"rp_$archivo.xls\";");

		$query01  = $bd->consultar($sql);
		echo "<table border=1>";

		echo "<tr><th> Fecha </th><th> Perfil Usuario </th><th> Usuario </th><th> Perfil Usuario Mod. </th><th> Usuario Mod. </th><th> Estatus </th></tr>";

		while ($row01 = $bd->obtener_num($query01)) {
			echo "<tr><td>" . $row01[0] . "</td><td>" . $row01[1] . "</td><td>" . $row01[2] . "</td><td>" . $row01[3] . "</td>
			<td>" . $row01[4] . "</td><td>" . $row01[5] . "</td></tr>";
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
		<th width='10%'>Fecha</th>
		<th width='10%'>Perfil usuario</th>
		<th width='10%'>Usuario</th>
		<th width='10%'>Perfil usuario mod.</th>
		<th width='10%'>Usuario mod.</th>
		<th width='10%'>Estatus</th>
		</tr>";

		$f = 0;
		while ($row = $bd->obtener_num($query)) {
			if ($f % 2 == 0) {
				echo "<tr>";
			} else {
				echo "<tr class='class= odd_row'>";
			}
			echo   "<td width='15%'>" . $row[0] . "</td>
			<td width='10%'>" . $row[1] . "</td>
			<td width='10%'>" . $row[2] . "</td>
			<td width='10%'>" . $row[3] . "</td>
			<td width='10%'>" . $row[4] . "</td>
			<td width='10%'>" . $row[5] . "</td>";

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
}
