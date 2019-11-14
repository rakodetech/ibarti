<?php
define("SPECIALCONSTANT",true);
session_start();
$Nmenu   = 534;
require("../autentificacion/aut_config.inc.php");
include_once('../'.Funcion);
require_once("../".class_bdI);
require_once("../".Leng);
$bd = new DataBase();

if(($_POST['fecha_desde'] == "" or $_POST['fecha_hasta'] == "")){
	exit;
}

$rol        = $_POST['rol'];
$region     = $_POST['region'];
$estado     = $_POST['estado'];
$contrato   = $_POST['contrato'];
$cliente    = $_POST['cliente'];
$ubicacion  = $_POST['ubicacion'];
$trabajador = $_POST['trabajador'];

$fecha_D    = conversion($_POST['fecha_desde']);
$fecha_H    = conversion($_POST['fecha_hasta']);

$reporte    = $_POST['reporte'];
$archivo    = "rp_pl_trabajador_".$fecha."";
$titulo     = "PLANIFICACION ROTACION DE TRABAJADOR \n";

if(isset($reporte)){
	$where = " WHERE planif_clientes_trab_det.fecha BETWEEN \"$fecha_D\" AND \"$fecha_H\"
	AND turno.cod_horario = horarios.codigo
	AND planif_clientes_trab.cod_cliente = clientes.codigo
	AND planif_clientes_trab.cod_ubicacion = clientes_ubicacion.codigo
	AND planif_clientes_trab.cod_rotacion = rotacion.codigo
	AND planif_clientes_trab.cod_ficha = ficha.cod_ficha
	AND trab_roles.cod_ficha = ficha.cod_ficha
	AND ficha.cedula = preingreso.cedula
	AND trab_roles.cod_rol = roles.codigo
	AND ficha.cod_region = regiones.codigo
	AND ficha.cod_contracto = contractos.codigo
	AND preingreso.cod_cargo = cargos.codigo
	AND preingreso.cod_estado = estados.codigo";


	if($rol != "TODOS"){
		$where .= " AND roles.codigo  = '$rol' ";
	}

	if($region != "TODOS"){
		$where  .= " AND ficha.cod_region = '$region' ";
	}

	if($estado != "TODOS"){
		$where  .= " AND estados.codigo = '$estado' ";
	}

	if($contrato != "TODOS"){
		$where   .= " AND contractos.codigo = '$contrato' ";
	}

	if($trabajador != NULL){
		$where   .= " AND  ficha.cod_ficha = '$trabajador' ";
	}

	if($cliente  != "TODOS"){
		$where   .= " AND planif_clientes_trab.cod_cliente = '$cliente' ";
	}

	if($ubicacion != "TODOS"){
		$where   .= " AND planif_clientes_trab.cod_ubicacion = '$ubicacion' ";
	}


	$sql = "SELECT planif_clientes_trab_det.fecha, roles.descripcion AS rol,
	regiones.descripcion AS region, estados.descripcion AS estado,
	clientes.nombre AS cliente,  clientes_ubicacion.descripcion AS ubicacion,
	contractos.descripcion AS contrato, cargos.descripcion AS cargo ,
	planif_clientes_trab.cod_ficha, CONCAT(preingreso.apellidos,' ',preingreso.nombres) AS ap_nombre,
	rotacion.abrev, rotacion.descripcion AS rotacion,
	horarios.nombre AS horario
	FROM
	planif_clientes_trab
	INNER JOIN planif_clientes_trab_det ON planif_clientes_trab.codigo = planif_clientes_trab_det.cod_planif_cl_trab 
	INNER JOIN turno ON planif_clientes_trab_det.cod_turno = turno.codigo ,clientes ,clientes_ubicacion ,horarios ,
	rotacion ,ficha ,preingreso ,trab_roles ,roles ,regiones ,contractos ,cargos ,estados
	$where
	ORDER BY 1, 2 ASC ";


	if($reporte== 'excel'){
		echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition:  filename=\"rp_$archivo.xls\";");

		$query01  = $bd->consultar($sql);
		echo "<table border=1>";
		echo "<tr><th> Fecha </th><th> ".$leng['rol']." </th><th> ".$leng['region']." </th><th> ".$leng['estado']." </th>
		<th> ".$leng['cliente']." </th><th> ".$leng['ubicacion']." </th><th> ".$leng['contrato']." </th><th> Cargo </th>
		<th> ".$leng['ficha']." </th><th> ".$leng['trabajador']." </th><th> Abrev. </th><th> Rotación </th>
		<th> Horario </th>
		</tr>";

		while ($row01 = $bd->obtener_num($query01)){
			echo "<tr><td> ".$row01[0]." </td><td>".$row01[1]."</td><td>".$row01[2]."</td><td>".$row01[3]."</td>
			<td>".$row01[4]."</td><td>".$row01[5]."</td><td>".$row01[6]."</td><td>".$row01[7]."</td>
			<td>".$row01[8]."</td><td>".$row01[9]."</td><td>".$row01[10]."</td><td>".$row01[11]."</td>
			<td>".$row01[12]."</td></tr>";
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
		<th width='15%'>".$leng['cliente']."</th>
		<th width='15%'>".$leng['ubicacion']."</th>
		<th width='10%'>".$leng['ficha']."</th>
		<th width='25%'>".$leng['trabajador']."</th>
		<th width='15%'>Rotación</th>
		<th width='10%'>Horario</th>
		</tr>";

		$f=0;
		while ($row = $bd->obtener_num($query)){
			if ($f%2==0){
				echo "<tr>";
			}else{
				echo "<tr class='class= odd_row'>";
			}
			echo   "<td width='10%'>".$row[0]."</td>
			<td width='10%'>".$row[4]."</td>
			<td width='15%'>".$row[5]."</td>
			<td width='15%'>".$row[8]."</td>
			<td width='25%'>".$row[9]."</td>
			<td width='15%'>".$row[11]."</td>
			<td width='10%'>".$row[12]."</td></tr>";

			$f++;
		}

		echo "</tbody>
		</table>
		</div>
		</body>
		</html>";

		$dompdf->load_html(ob_get_clean(),'UTF-8');
		$dompdf->set_paper ('letter','landscape');
		$dompdf->render();
		$dompdf->stream($archivo, array('Attachment' => 0));
	}
}
