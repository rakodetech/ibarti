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

	$arrayFechas=devuelveArrayFechasEntreOtrasDos($fecha_D, $fecha_H);

	$longitud = count($arrayFechas);


	if($reporte== 'excel'){
		echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition:  filename=\"rp_$archivo.xls\";");
		echo "<table border=1>";

		echo "<tr><th>Fecha</th><th> ".$leng['rol']." </th><th> ".$leng['region']." </th><th> ".$leng['estado']." </th><th> ".$leng['cliente']." </th><th> ".$leng['ubicacion']." </th> <th> ".$leng['ficha']." </th>
		<th> ".$leng['ci']." </th><th> ".$leng['trabajador']." </th> <th> Cargo</th> <th> ".$leng['contrato']."</th></tr>";
				//Recorro todas las fechas del rango
		for($i=0; $i<$longitud; $i++)
		{
      //saco el valor de cada elemento
			$sql = "SELECT  \"$arrayFechas[$i]\" fecha, v_ficha.rol, v_ficha.region, v_ficha.estado,clientes.abrev cliente,
			clientes_ubicacion.descripcion ubicacion, v_ficha.cod_ficha, v_ficha.cedula, v_ficha.ap_nombre, v_ficha.cargo, v_ficha.contracto,
			Count(planif_clientes_trab_det.cod_ficha) AS cantidad 
			FROM v_ficha 
			LEFT JOIN planif_clientes_trab_det ON v_ficha.cod_ficha = planif_clientes_trab_det.cod_ficha 
			AND planif_clientes_trab_det.fecha = \"$arrayFechas[$i]\" , control, clientes, clientes_ubicacion
			$where
			GROUP BY v_ficha.rol, v_ficha.region, v_ficha.estado,cliente,ubicacion, v_ficha.cod_ficha, v_ficha.cedula, v_ficha.nombres, v_ficha.cargo,v_ficha.contracto HAVING cantidad = 0 ";

			$query01  = $bd->consultar($sql);

			while ($row01 = $bd->obtener_num($query01)){
				echo "<tr><td>".$row01[0]."</td><td>".$row01[1]."</td><td>".$row01[2]."</td>
				<td>".$row01[3]."</td><td>".$row01[4]."</td><td>".$row01[5]."</td><td>".$row01[6]."</td> <td> ".$row01[7]." </td><td> ".$row01[8]." </td> <td> ".$row01[9]." </td><td> ".$row01[10]." </td></tr>";

			}
		}

		echo "</table>";
	}
}
