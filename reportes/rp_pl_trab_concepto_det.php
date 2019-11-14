<?php
define("SPECIALCONSTANT",true);
session_start();
$Nmenu   = 527;
require("../autentificacion/aut_config.inc.php");
include_once('../'.Funcion);
require_once("../".class_bdI);
require_once("../".Leng);
$bd = new DataBase();

$fecha_D         = conversion($_POST['fecha_desde']);
$fecha_H         = conversion($_POST['fecha_hasta']);
$rol             = $_POST['rol'];
$region          = $_POST['region'];
$estado          = $_POST['estado'];
$cargo           = $_POST['cargo'];
$contrato        = $_POST['contrato'];
$horario           = $_POST['horario'];
$trabajador      = $_POST['trabajador'];
$reporte         = $_POST['reporte'];
$archivo         = "rp_pl_trab_concepto_".$fecha."";
$titulo          = " REPORTE PLANIFICACION TRABAJADOR CONCEPTO \n ";

if(isset($reporte)){


	$where = " WHERE planif_clientes_trab_det.fecha BETWEEN \"$fecha_D\" AND \"$fecha_H\"
	AND planif_clientes_trab_det.cod_ficha = v_ficha.cod_ficha  ";


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

	if($horario != "TODOS"){
		$where  .= " AND horarios.codigo = '$horario' ";
	}

	if($trabajador != "TODOS"){
		$where  .= " AND v_ficha.cod_ficha = '$trabajador' ";
	}
	// QUERY A MOSTRAR //
	$sql = "SELECT planif_clientes_trab_det.fecha, v_ficha.rol, v_ficha.region, v_ficha.estado,
	v_ficha.cod_ficha, v_ficha.cedula,  v_ficha.nombres, v_ficha.cargo,
	v_ficha.contracto, horarios.nombre AS horario, conceptos.abrev concepto
	FROM
	planif_clientes_trab_det
	INNER JOIN turno ON planif_clientes_trab_det.cod_turno = turno.codigo
	INNER JOIN horarios ON turno.cod_horario = horarios.codigo
	INNER JOIN conceptos ON horarios.cod_concepto = conceptos.codigo,
	v_ficha
	$where
	ORDER BY 1 ASC";

	if($reporte== 'excel'){
		echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition:  filename=\"rp_$archivo.xls\";");

		$query01  = $bd->consultar($sql);
		echo "<table border=1>";

		echo "<tr><th> Fecha </th><th> ".$leng['rol']." </th><th> ".$leng['region']." </th><th> ".$leng['estado']." </th>
		<th> ".$leng['ficha']." </th><th> ".$leng['ci']." </th><th> ".$leng['trabajador']." </th> <th> Cargo</th>
		<th> ".$leng['contrato']."</th><th> ".$leng['horario']." </th></th><th> ".$leng['concepto']." </th></tr>";

		while ($row01 = $bd->obtener_num($query01)){
			echo "<tr><td>".$row01[0]."</td><td>".$row01[1]."</td><td>".$row01[2]."</td><td>".$row01[3]."</td>
			<td>".$row01[4]."</td><td>".$row01[5]."</td><td>".$row01[6]."</td><td>".$row01[7]."</td>
			<td>".$row01[8]."</td><td>".$row01[9]."</td><td>".$row01[10]."</td></tr>";
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
		<th width='10%'>Fecha</th>
		<th width='15%'>".$leng['rol']."</th>
		<th width='10%'>".$leng['ficha']."</th>
		<th width='22%'>".$leng['trabajador']."</th>
		<th width='20%'>".$leng['contrato']."</th>
		<th width='13%'>".$leng['horario']."</th>
		<th width='10%'>".$leng['concepto']."</th>
		</tr>";

		$f=0;
		while ($row = $bd->obtener_num($query)){
			if ($f%2==0){
				echo "<tr>";
			}else{
				echo "<tr class='class= odd_row'>";
			}
			echo   "<td width='10%'>".$row[0]."</td>
			<td width='15%'>".$row[1]."</td>
			<td width='10%'>".$row[4]."</td>
			<td width='22%'>".$row[6]."</td>
			<td width='20%'>".$row[8]."</td>
			<td width='13%'>".$row[9]."</td>
			<td width='10%'>".$row[10]."</td></tr>";

			$f++;
		}

		echo "</tbody>
		</table>
		</div>
		</body>
		</html>";

		$dompdf->load_html(ob_get_clean(),'UTF-8');
		$dompdf->render();
		$dompdf->stream($archivo, array('Attachment' => 0));
	}
}
