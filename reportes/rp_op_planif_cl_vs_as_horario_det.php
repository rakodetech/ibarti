<?php
session_start();
$Nmenu   = 547;
require("../autentificacion/aut_config.inc.php");
include_once('../funciones/funciones.php');
require_once('../autentificacion/aut_verifica_menu_02.php');

$reporte         = $_POST['reporte'];

$archivo         = "rp_rop_planif_cl_vs_as_horario".$fecha."";
$titulo          = " REPORTE PLANIFICACION CLIENTE VS ASISTENCIA HORARIO \n";
if($reporte== 'excel'){

	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition:  filename=\"rp_$archivo.xls\";");
	echo "<table border=1>";

	echo $_POST['contenido_reporte'];
	echo "</table>";
}

if($reporte == 'pdf'){

	require_once('../'.ConfigDomPdf);

	$dompdf= new DOMPDF();

	ob_start();

	require('../'.PlantillaDOM.'/header_ibarti_2.php');
	include('../'.pagDomPdf.'/paginacion_ibarti.php');

		echo "<br><div>
		<table border='1'>";
		echo $_POST['contenido_reporte'];
		echo "</table>
		</div>
		</body>
		</html>";

	$dompdf->load_html(ob_get_clean(),'UTF-8');
	$dompdf->render();
	$dompdf->stream($archivo, array('Attachment' => 0));
}
?>
