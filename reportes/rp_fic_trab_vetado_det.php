<?php
define("SPECIALCONSTANT",true);
session_start();
$Nmenu   = 538;
include_once "../funciones/funciones.php";
require "../autentificacion/aut_config.inc.php";
require "../".class_bdI;
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

$reporte         = $_POST['reporte'];

$archivo         = "rp_fic_trab_vetado_".$fecha."";
$titulo          = " REPORTE TRABAJADORES VETADOS ";

if(isset($reporte)){
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
	$sql = "SELECT v_ficha.rol,v_ficha.region,v_ficha.estado, v_ficha.cod_ficha,v_ficha.cedula, v_ficha.ap_nombre,v_ficha.cargo, v_ficha.contracto,
	cl.abrev cliente, cu.descripcion ubicacion,cv.fec_us_ing fec_desde,v_ficha.`status`
	FROM v_ficha INNER JOIN clientes_vetados cv ON v_ficha.cod_ficha = cv.cod_ficha 
	INNER JOIN clientes cl ON cv.cod_cliente = cl.codigo 
	INNER JOIN clientes_ubicacion cu ON cv.cod_ubicacion = cu.codigo 
	$where
	ORDER BY 6 ASC;";

	if($reporte== 'excel'){

		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition:  filename=\"rp_$archivo.xls\";");

		$query01  = $bd->consultar($sql);
		echo "<table border=1>";

		echo "<tr><th> ROLES </th><th> REGION </th><th> ESTADO </th> <th> FICHA </th>
		<th> CEDULA </th><th> TRABAJADOR </th> <th> CARGO</th> <th> CONTRATO</th>
		<th> CLIENTE VETADO</th><th> UBICACION VETADO</th><th> FECHA DESDE</th><th> STATUS FICHA</th></tr>";

		while ($row01 = $bd->obtener_num($query01)){
			echo "<tr><td>".$row01[0]."</td><td>".$row01[1]."</td><td>".$row01[2]."</td><td>".$row01[3]."</td>
			<td>".$row01[4]."</td><td>".$row01[5]."</td><td>".$row01[6]."</td><td>".$row01[7]."</td>
			<td>".$row01[8]."</td><td>".$row01[9]."</td><td>".$row01[10]."</td><td>".$row01[11]."</td>
			</tr>";
		}
		echo "</table>";
	}
	if($reporte == 'pdf'){

		require_once('../'.ConfigDomPdf);

		$dompdf= new DOMPDF();

		$query  = $bd->consultar($sql);

		ob_start();

		require('../'.PlantillaDOM.'/header_ibarti_2.php');
		include('../'.pagDomPdf.'/paginacion_ibarti.php');

		echo "<br><div>
		<table>
		<tbody>
		<tr style='background-color: #4CAF50;'>
		<th width='10%'>".$leng['ficha']."</th>
		<th width='10%'>".$leng['ci']."</th>
		<th width='30%'>".$leng['trabajador']."</th>
		<th width='15%'>".$leng['cliente']." V.</th>
		<th width='15%'>".$leng['ubicacion']." V.</th>
		<th width='12%'>Fecha Desde V.</th>
		<th width='8%'>Status Ficha</th>
		</tr>";

		$f=0;
		while ($row = $bd->obtener_num($query)){
			if ($f%2==0){
				echo "<tr>";
			}else{
				echo "<tr class='class= odd_row'>";
			}
			echo   "<td width='10%'>".$row[3]."</td>
			<td width='10%'>".$row[4]."</td>
			<td width='26%'>".$row[5]."</td>
			<td width='15%'>".$row[8]."</td>
			<td width='15%'>".$row[9]."</td>
			<td width='12%'>".$row[10]."</td>
			<td width='12%'>".$row[11]."</td></tr>";

			$f++;
		}

		echo "</tbody>
		</table>
		</div>
		</body>
		</html>";

		$dompdf->load_html(ob_get_clean(),'UTF-8');
		$dompdf->set_paper('letter','landscape');
		$dompdf->render();
		$dompdf->stream($archivo, array('Attachment' => 0));
	}
}
?>
