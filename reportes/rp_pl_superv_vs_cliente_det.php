<?php
define("SPECIALCONSTANT", true);
include_once "../funciones/funciones.php";
require "../autentificacion/aut_config.inc.php";
require "../" . class_bdI;
require "../" . Leng;
$bd = new DataBase();
$reporte          = $_POST['reporte'];
$archivo          = $_POST['archivo'];
$titulo = "Reporte Ubicación - Uniforme";

if (isset($reporte)) {
    $cliente    = $_POST['cliente'];
    $ubicacion  = $_POST['ubicacion'];
    $estado  = $_POST['estado'];
    $region  = $_POST['region'];
    $fecha_D    = conversion($_POST['fecha_desde']);
    $fecha_H    = conversion($_POST['fecha_hasta']);

    $WHERE = " WHERE a.fecha BETWEEN \"$fecha_D\" AND \"$fecha_H\" ";

    if ($region != "TODOS") {
        $WHERE .= " AND a.cod_region = '$region' ";
    }

    if ($estado != "TODOS") {
        $WHERE .= " AND a.cod_estado = '$estado' ";
    }

    if ($cliente != "TODOS") {
        $WHERE .= " AND a.cod_cliente = '$cliente' ";
    }

    if ($ubicacion != "TODOS") {
        $WHERE .= " AND a.cod_ubicacion = '$ubicacion' ";
    }


    // QUERY A MOSTRAR //
    $sql = "SELECT fecha, cod_region, region, cod_estado, estado, 
	cod_cliente, cliente, abrev_cliente, cod_ubicacion, ubicacion, cantidad, contratacion, diff 
	FROM v_semaforo_supervision a
			$WHERE  ";

    if ($reporte == 'excel') {

        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition:  filename=\"rp_$archivo.xls\";");

        $query01  = $bd->consultar($sql);
        echo "<table border=1>";

        echo "<tr><th>Fecha</th><th>Cod. " . $leng['region'] . " </th><th>" . $leng['region'] . " </th><th>Cod. Estado</th><th> " . $leng['estado'] . "  </th>
		<th>Cod. Cliente</th><th>Abrev. Cliente</th><th> " . $leng['cliente'] . "  </th><th>Cod. " . $leng['ubicacion'] . " </th><th> " . $leng['ubicacion'] . "  </th><th> Diferencia </th></tr>";

        while ($row01 = $bd->obtener_num($query01)) {
            if ($row01[12] == 0) {
                $row01[12] = "OK";
            }
            echo "<tr><td>" . $row01[0] . "</td><td>" . $row01[1] . "</td><td>" . $row01[2] . "</td><td>" . $row01[3] . "</td>
			<td>" . $row01[4] . "</td><td>" . $row01[5] . "</td><td>" . $row01[6] . "</td><td>" . $row01[7] . "</td><td>" . $row01[8] . "</td><td>" . $row01[9] . "</td><td>" . $row01[12] . "</td></tr>";
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
		<th width='10%'>" . $leng['region'] . "</th>
		<th width='10%'>" . $leng['estado'] . "</th>
		<th width='12%'>Abrev. " . $leng['cliente'] . " </th>
		<th width='12%'>" . $leng['ubicacion'] . " </th>
		<th width='5%'>Diferencia</th>
		</tr>";

        $f = 0;
        while ($row = $bd->obtener_num($query)) {
            if ($row[12] == 0) {
                $row[12] = "OK";
            }
            if ($f % 2 == 0) {
                echo "<tr>";
            } else {
                echo "<tr class='class= odd_row'>";
            }
            echo   "<td>" . $row[0] . "</td>
			<td>" . $row[2] . "</td>
			<td>" . $row[4] . "</td>
			<td>" . $row[7] . "</td>
			<td>" . $row[9] . "</td>
            <td>" . $row[12] . "</td></tr>";

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
