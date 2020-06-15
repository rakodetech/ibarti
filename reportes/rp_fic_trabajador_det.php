<?php
define("SPECIALCONSTANT",true);
session_start();
$Nmenu   = 524;
require("../autentificacion/aut_config.inc.php");
include_once('../funciones/funciones.php');
require_once("../".class_bdI);
require_once("../".Leng);
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

$archivo         = "rp_fic_trabajador_".$fecha."";
$titulo          = "  REPORTE FICHA TRABAJADOR \n";

if(isset($reporte)){

	$where = "  WHERE v_ficha.cod_ficha = v_ficha.cod_ficha
	AND v_ficha.cod_banco = bancos.codigo
	AND v_ficha.cod_n_contracto = ficha_n_contracto.codigo
	AND v_ficha.cod_t_camisas = preing_camisas.codigo
	AND v_ficha.cod_t_pantalon = preing_pantalon.codigo
	AND v_ficha.cod_n_zapatos = preing_zapatos.codigo
	AND v_ficha.cod_nivel_academico = nivel_academico.codigo 
	AND v_ficha.cod_us_mod = men_usuarios.codigo";

	// and v_ficha.cod_ficha_status_militar = ficha_status_militar.codigo";

	if($_POST['fecha_desde'] != ""){
		$fecha_D         = conversion($_POST['fecha_desde']);
		$where .= " AND v_ficha.fec_ingreso >= \"$fecha_D\" ";
	}

	if($_POST['fecha_hasta'] != ""){
		$fecha_H         = conversion($_POST['fecha_hasta']);
		$where .= " AND v_ficha.fec_ingreso <= \"$fecha_H\" ";
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
		$where .= " AND v_ficha.cod_cliente = '$cliente' ";
	}

	if($ubicacion != "TODOS"){
		$where .= " AND v_ficha.cod_ubicacion = '$ubicacion' "; 
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
	$sql = " SELECT v_ficha.rol, v_ficha.region, v_ficha.estado, v_ficha.ciudad,v_ficha.abrev_cliente,
	v_ficha.ubicacion,v_ficha.cod_ficha, v_ficha.cedula,  v_ficha.apellidos, v_ficha.nombres,
	v_ficha.fec_nacimiento, Sexo(v_ficha.sexo), v_ficha.telefono,	 v_ficha.celular,
	v_ficha.correo, v_ficha.experiencia, v_ficha.direccion, v_ficha.observacion,
	nivel_academico.descripcion AS nivel_academico, v_ficha.cargo,
	v_ficha.contracto, ficha_n_contracto.descripcion AS n_contracto,
	bancos.descripcion AS banco,  v_ficha.cta_banco,
	preing_camisas.descripcion AS camisa, preing_pantalon.descripcion AS pantalon, preing_zapatos.descripcion AS zapato,
	v_ficha.fec_ingreso,  v_ficha.fec_profit, v_ficha.fec_contracto, ficha_egreso.fec_egreso,
	v_ficha.`status`,v_ficha.fec_us_mod,Concat(men_usuarios.nombre,' ',men_usuarios.apellido) us_mod
	FROM  v_ficha LEFT JOIN ficha_egreso ON v_ficha.cod_ficha = ficha_egreso.cod_ficha, bancos, ficha_n_contracto, preing_camisas,
	preing_pantalon, preing_zapatos, nivel_academico,men_usuarios
	$where
	ORDER BY 7 ASC ";
	//,ficha_status_militar parte del FROM
	//, if(v_ficha.servicio_militar='T','SI','NO') fic_militar, ficha_status_militar.descripcion rango_militar parte del SELECT
	if($reporte== 'excel'){
		echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition:  filename=\"rp_$archivo.xls\";");

		$query01  = $bd->consultar($sql);
		echo "<table border=1>";

		echo "<tr><th> ".$leng['rol']." </th><th> ".$leng['region']." </th><th> ".$leng['estado']." </th><th> ".$leng['ciudad']." </th><th> ".$leng['cliente']." </th><th> ".$leng['ubicacion']." </th>
		<th> ".$leng['ficha']." </th><th> ".$leng['ci']." </th><th> Apellido </th> <th> Nombre </th>
		<th> Fecha NACIMIENTO </th> <th> Sexo </th><th> Teléfono </th><th> Celular</th>
		<th> Correo </th> <th> Experiencia </th><th> Dirección </th><th> Observación </th>
		<th> Nivel Académico </th><th> Cargo</th><th> ".$leng['contrato']."</th><th> N. ".$leng['contrato']." </th>
		<th> Banco </th><th> Cta. Bancaria </th><th> T. Camisa </th><th>T. Pantalón </th>
		<th>N. Zapato</th> <th> Fec. Ingreso </th><th> Fecha Ing. Sistema </th><th> Fec.. ".$leng['contrato']." </th>
		<th> Fec. Egreso </th><th> Status </th><th> Fecha Ultima Modificacion </th>
		</tr><th> Usuario Ultima Modificacion </th>";
		//<th> Servicio Militar </th><th> Rango Militar </th>


		while ($row01 = $bd->obtener_num($query01)){
			echo "<tr><td>".$row01[0]."</td><td>".$row01[1]."</td><td>".$row01[2]."</td><td>".$row01[3]."</td>
			<td>".$row01[4]."</td><td>".$row01[5]."</td><td>".$row01[6]."</td><td>".$row01[7]."</td>
			<td>".$row01[8]."</td><td>".$row01[9]."</td><td>".$row01[10]."</td><td>".$row01[11]."</td>
			<td>".$row01[12]."</td><td>".$row01[13]."</td><td>".$row01[14]."</td><td>".$row01[15]."</td>
			<td>".$row01[16]."</td><td>".$row01[17]."</td><td>".$row01[18]."</td><td>".$row01[19]."</td>
			<td>".$row01[20]."</td><td>".$row01[21]."</td><td>".$row01[22]."</td><td>Nº ".$row01[23]."</td>
			<td>".$row01[24]."</td><td>".$row01[25]."</td><td>".$row01[26]."</td><td>".$row01[27]."</td>
			<td>".$row01[28]."</td><td>".$row01[29]."</td> <td>".$row01[30]."</td>
			<td>".$row01[31]."</td> <td>".$row01[32]."</td><td>".$row01[33]."</td>
			</tr>";
			//<td>".$row01[33]."</td><td>".$row01[34]."</td>
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
		<th width='15%'>".$leng['rol']."</th>
		<th width='10%'>".$leng['estado']."</th>
		<th width='10%'>".$leng['cliente']."</th>
		<th width='10%'>".$leng['ubicacion']."</th>
		<th width='10%'>".$leng['ficha']."</th>
		<th width='18%'>Apellido</th>
		<th width='18%'>Nombre</th>
		<th width='19%'>".$leng['contrato']."</th>
		<th width='10%'>Status</th>
		</tr>";

		$f=0;
		while ($row = $bd->obtener_num($query)){
			if ($f%2==0){
				echo "<tr>";
			}else{
				echo "<tr class='class= odd_row'>";
			}
			echo   "<td width='15%'>".$row[0]."</td>
			<td width='10%'>".$row[2]."</td>
			<td width='10%'>".$row[4]."</td>
			<td width='10%'>".$row[5]."</td>
			<td width='10%'>".$row[6]."</td>
			<td width='18%'>".$row[8]."</td>
			<td width='18%'>".$row[9]."</td>
			<td width='19%'>".$row[20]."</td>
			<td width='10%'>".$row[31]."</td>";

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
