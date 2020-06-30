<?php
define("SPECIALCONSTANT",true);
$Nmenu   = 576;
require("../autentificacion/aut_config.inc.php");
include_once('../'.Funcion);
require_once("../".class_bdI);
require_once("../".Leng);
$bd = new DataBase();

if(($_POST['fecha_desde'] == "")){
	exit;
}

$rol          = $_POST['rol'];
$d_proyeccion = $_POST['d_proyeccion'];
$estado       = $_POST['estado'];
$contrato     = $_POST['contrato'];
$linea        = $_POST['linea'];
$sub_linea    = $_POST['sub_linea'];
$cliente    = $_POST['cliente'];
$ubicacion    = $_POST['ubicacion'];
$fecha_desde  = $_POST['fecha_desde'];
$trabajador   = $_POST['trabajador'];

$fecha_D      = conversion($_POST['fecha_desde']);

$reporte      = $_POST['reporte'];
$archivo      = "rp_inv_dotacion_proyeccion_".$fecha."";
$titulo       = "  PROYECCION DE DOTACION DE TRABAJADOR \n";

if(isset($reporte)){

	$where = " WHERE DATE_ADD(DATE_FORMAT(v_prod_dot_max2.fecha_max, '%Y-%m-%d'), INTERVAL control.dias_proyeccion DAY) < DATE_ADD('2020-06-30', INTERVAL '0' DAY)
	AND v_prod_dot_max2.cod_rol = roles.codigo
	AND v_prod_dot_max2.cod_contracto = contractos.codigo
	AND v_prod_dot_max2.cod_linea = prod_lineas.codigo
	AND v_prod_dot_max2.cod_sub_linea = prod_sub_lineas.codigo
	AND v_prod_dot_max2.cod_producto = productos.item
	AND v_prod_dot_max2.cod_ficha_status = control.ficha_activo 
	AND v_prod_dot_max2.cod_cliente = clientes.codigo
	AND v_prod_dot_max2.cod_ubicacion = clientes_ubicacion.codigo
	AND v_prod_dot_max2.cod_sub_linea = clientes_ub_uniforme.cod_sub_linea
	AND v_prod_dot_max2.cod_ubicacion = clientes_ub_uniforme.cod_cl_ubicacion
	AND v_prod_dot_max2.cod_estado = estados.codigo  ";

	if($rol != "TODOS"){
		$where .= " AND v_prod_dot_max2.cod_rol = '$rol' ";
	}

	if($estado != "TODOS"){
		$where .= " AND v_prod_dot_max2.cod_estado = '$estado' ";
	}

	if($contrato != "TODOS"){
		$where .= " AND v_prod_dot_max2.cod_contracto = '$contrato' ";
	}

	if($cliente != "TODOS"){
		$where  .= " AND v_prod_dot_max2.cod_cliente = '$cliente' ";
	}

	
	if($ubicacion != "TODOS"){
		$where  .= " AND v_prod_dot_max2.cod_ubicacion = '$ubicacion' ";
	}

	if($linea != "TODOS"){
		$where .= " AND v_prod_dot_max2.cod_linea = '$linea' ";  // cambie AND asistencia.co_cont = '$contracto'
	}

	if($sub_linea != "TODOS"){
		$where  .= " AND v_prod_dot_max2.cod_sub_linea = '$sub_linea' ";
	}

	if($trabajador != NULL){
		$where  .= " AND v_prod_dot_max2.cod_ficha = '$trabajador' ";
	}

	$sql = "SELECT v_prod_dot_max2.fecha_max AS fecha,roles.descripcion AS rol,
			estados.descripcion AS estado, clientes.nombre cliente,  clientes_ubicacion.descripcion ubicacion,
			contractos.descripcion AS contrato,  v_prod_dot_max2.cod_ficha,
			v_prod_dot_max2.cedula, v_prod_dot_max2.ap_nombre,
			prod_lineas.descripcion AS linea, prod_sub_lineas.descripcion AS sub_linea,  
			v_prod_dot_max2.cod_producto, productos.descripcion AS producto, 
			v_prod_dot_max2.cantidad
			FROM v_prod_dot_max2 , roles,  contractos, prod_lineas,
			prod_sub_lineas, productos, control, clientes, clientes_ubicacion, clientes_ub_uniforme, estados
			$where
			ORDER BY ap_nombre ASC   ";

	if($reporte== 'excel'){
		echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition:  filename=\"rp_$archivo.xls\";");

		$query01  = $bd->consultar($sql);
		echo "<table border=1>";

		echo "<tr><th> Fecha </th><th> ".$leng['rol']." </th><th> ".$leng['estado']." </th><th> ".$leng['cliente']." </th><th> ".$leng['ubicacion']." </th>
		<th>".$leng['contrato']."</th> <th> ".$leng['ficha']." </th><th> ".$leng['ci']." </th><th> ".$leng['trabajador']." </th>
		<th> Linea </th><th> Sub Linea </th><th> Cod. Producto</th> <th> Producto </th>
		<th> Cantidad </th></tr>";

		while ($row01 = $bd->obtener_num($query01)){
			echo "<tr><td>".$row01[0]." </td><td>".$row01[1]."</td><td>".$row01[2]."</td><td>".$row01[3]."</td>
			<td>".$row01[4]."</td><td>".$row01[5]."</td><td>".$row01[6]."</td><td>".$row01[7]."</td>
			<td>".$row01[8]."</td><td>".$row01[9]."</td><td>".$row01[10]."</td><td>".$row01[11]."</td>
			<td>".$row01[12]."</td><td>".$row01[13]."</td></tr>";
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
		<th width='20%'>Fecha</th>
		<th width='15%'>".$leng['rol']."</th>
		<th width='10%'>".$leng['ficha']."</th>
		<th width='30%'>".$leng['trabajador']."</th>
		<th width='15%'>Producto</th>
		<th width='10%''>Cantidad</th>
		</tr>";

		$f=0;
		while ($row = $bd->obtener_num($query)){
			if ($f%2==0){
				echo "<tr>";
			}else{
				echo "<tr class='class= odd_row'>";
			}
			echo   " <td width='20%'>".$row[0]."</td>
			<td width='15%'>".$row[1]."</td>
			<td width='10%'>".$row[6]."</td>
			<td width='30%'>".$row[8]."</td>
			<td width='15%'>".$row[12]."</td>
			<td width='10%'>".$row[13]."</td></tr>";

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