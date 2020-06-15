<?php
define("SPECIALCONSTANT",true);
include_once "../funciones/funciones.php";
require "../autentificacion/aut_config.inc.php";
require "../".class_bdI;
require "../".Leng;
$bd = new DataBase();

$fecha_D         = conversion($_POST['fecha_desde']);
$fecha_H         = conversion($_POST['fecha_hasta']);
$rol             = $_POST['rol'];
$region          = $_POST['region'];
$estado          = $_POST['estado'];
$cargo           = $_POST['cargo'];
$contrato        = $_POST['contrato'];
$cliente        = $_POST['cliente'];
$ubicacion        = $_POST['ubicacion'];
$usuario        = $_POST['usuario'];

$reporte         = $_POST['reporte'];
$archivo         = "rp_pl_trab_sin_planif_".$fecha."";
$titulo          = " REPORTE TRABAJADOR SIN PLANIFICACION (Desde: $fecha_D Hasta: $fecha_H) \n ";

if(isset($reporte)){
$where = " 	WHERE v_ficha.cod_ficha_status = control.ficha_activo AND clientes.codigo = clientes_ubicacion.cod_cliente AND clientes_ubicacion.codigo = v_ficha.cod_ubicacion ";


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

	if($cliente != "TODOS"){
		$where  .= " AND clientes.codigo = '$cliente'";
	}

	if($ubicacion != "TODOS"){
		$where  .= " AND v_ficha.cod_ubicacion = '$ubicacion' AND clientes.codigo = clientes_ubicacion.cod_cliente
		AND clientes_ubicacion.codigo = v_ficha.cod_ubicacion ";
	}

	// QUERY A MOSTRAR //
	$sql = "SELECT  v_ficha.rol, v_ficha.region, v_ficha.estado,clientes.abrev cliente,
	clientes_ubicacion.descripcion ubicacion, v_ficha.cod_ficha, v_ficha.cedula, v_ficha.ap_nombre, v_ficha.cargo, v_ficha.contracto,
	Count(planif_clientes_trab_det.cod_ficha) AS cantidad 
	FROM v_ficha 
	LEFT JOIN planif_clientes_trab_det ON v_ficha.cod_ficha = planif_clientes_trab_det.cod_ficha 
	AND planif_clientes_trab_det.fecha BETWEEN \"$fecha_D\" AND \"$fecha_H\" , control, clientes, clientes_ubicacion
	$where
	GROUP BY v_ficha.rol, v_ficha.region, v_ficha.estado,cliente,ubicacion, v_ficha.cod_ficha, v_ficha.cedula, v_ficha.nombres, v_ficha.cargo,v_ficha.contracto HAVING cantidad = 0;";

		if($reporte== 'excel'){
			echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
			header("Content-type: application/vnd.ms-excel");
			header("Content-Disposition:  filename=\"rp_$archivo.xls\";");

			$query01  = $bd->consultar($sql);

			echo "<table border=1>";

			echo "<tr><th> ".$leng['rol']." </th><th> ".$leng['region']." </th><th> ".$leng['estado']." </th><th> ".$leng['cliente']." </th><th> ".$leng['ubicacion']." </th> <th> ".$leng['ficha']." </th>
			<th> ".$leng['ci']." </th><th> ".$leng['trabajador']." </th> <th> Cargo</th> <th> ".$leng['contrato']."</th></tr>";

			while ($row01 = $bd->obtener_num($query01)){
				echo "<tr><td>".$row01[0]."</td><td>".$row01[1]."</td><td>".$row01[2]."</td>
				<td>".$row01[3]."</td><td>".$row01[4]."</td><td>".$row01[5]."</td><td>".$row01[6]."</td> <td> ".$row01[7]." </td><td> ".$row01[8]." </td> <td> ".$row01[9]." </td></tr>";

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
			<th>".$leng['rol']."</th>
			<th>".$leng['estado']."</th>
			<th>".$leng['cliente']."</th>
			<th>".$leng['ubicacion']."</th>
			<th>".$leng['ficha']."</th>
			<th>".$leng['trabajador']."</th>
			<th>".$leng['contrato']."</th></tr>";
			$f=0;
			while ($row = $bd->obtener_num($query)){
				if ($f%2==0){
					echo "<tr>";
				}else{
					echo "<tr class='class= odd_row'>";
				}
				echo   "<td width='15%'>".$row[0]."</td>
				<td width='10%'>".$row[2]."</td>
				<td width='12%'>".$row[3]."</td>
				<td width='12%'>".$row[4]."</td>
				<td width='10%'> ".$row[5]." </td>
				<td width='20%'> ".$row[7]." </td>
				<td width='11%'> ".$row[9]." </td></tr>";

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
