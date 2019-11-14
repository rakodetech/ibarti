<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php
require_once("../autentificacion/aut_config.inc.php");
include_once('../funciones/funciones.php');

$id              = $_POST['id'];
$fecha_D         = conversion($_POST['fecha_desde']);
$fecha_H         = conversion($_POST['fecha_hasta']);

$usuario         = $_POST['usuario'];
$usuario_id      = $_POST['usuario_id'];
$perfil          = $_POST['perfil'];
$reporte         = $_POST['reporte'];
$trabajador      = $_POST['trabajador'];
$cliente         = $_POST['cliente'];
$region          = $_POST['region'];
$contracto       = $_POST['contracto'];

$archivo         = "Rp_horas_extras_$fecha_D";

if(isset($reporte)){
	$where = "  WHERE v_as_hora_extra.cod_emp = trabajadores.cod_emp
                  AND trabajadores.id_region = regiones.id
                  AND v_as_hora_extra.co_cli = clientes.co_cli
                  AND v_as_hora_extra.id_ubicacion = clientes_ubicacion.id
                  AND trabajadores.co_cont = nomina.co_cont
			      AND v_as_hora_extra.fecha BETWEEN \"$fecha_D\" AND \"$fecha_H\" ";

	if($cliente != "TODOS"){
		$where  .= " AND clientes.co_cli =  '$cliente' ";
	}

	if($region != "TODOS"){
		$where  .= " AND regiones.id = '$region' ";
	}

	if($trabajador != NULL){
		$where  .= " AND trabajadores.cod_emp  = '$trabajador' ";
	}

	if($usuario_id != "TODOS"){
		$where  .= " AND v_as_hora_extra.id_usuario = '$usuario_id' ";
	}

	if($contracto != "TODOS"){
		$where  .= " AND trabajadores.co_cont = '$contracto' ";
	}

//	$sql01 = $sql00.$cli.$reg.$trab.$usuario_id.$orden;
}

		  $sql01 = "SELECT v_as_hora_extra.fecha, trabajadores.cod_emp, trabajadores.ci,
		                   trabajadores.nombres AS trabajador, nomina.des_cont AS contracto,
						   regiones.descripcion AS region, clientes.cli_des AS clientes,
                           clientes_ubicacion.descripcion AS ubicacion,
                           v_as_hora_extra.cod_snvaria, v_as_hora_extra.horas
                      FROM v_as_hora_extra, trabajadores, regiones, clientes, clientes_ubicacion, nomina
					       ".$where." ORDER BY 1, 4, 5  ASC ";

if($reporte== 'excel'){

	mysql_select_db($bd_cnn,$cnn);
	header("Content-type: application/vnd.ms-excel");
	 header("Content-Disposition:  filename=\"".$archivo.".xls\";");


	$fondo01 = " bgcolor='#EBEBEB'";
	$fondo02 = " bgcolor='#E0E0E0'";
	$fondo03 = " bgcolor='#FFFFFF'";

	  $query01 = mysql_query($sql01, $cnn);

	 echo "<table border=1>";
	 echo "<tr ".$fondo02."><th> FECHA </th><th> COD EMPLEADO </th><th> CI</th> <th> TRABAJADOR </th>
	           <th> CONTRACTO </th><th> REGION  </th><th> CLIENTE </th> <th> UBICACION </th>
			   <th> COD VAR </th><th> HORA </th></tr>";


	while ($row01 = mysql_fetch_row($query01)){
	 echo "<tr><td ".$fondo03.">".$row01[0]." </td><td ".$fondo03.">".$row01[1]." </td><td".$fondo03.">".$row01[2]."</td><td".$fondo03.">".$row01[3]."</td><td".$fondo03.">".$row01[4]."</td><td".$fondo03.">".$row01[5]."</td><td".$fondo03.">".$row01[6]."</td><td".$fondo03.">".$row01[7]."</td><td".$fondo03.">".$row01[8]."</td><td".$fondo03.">".$row01[9]."</td></tr>";

	}
	 echo "</table>";
}

if($reporte== 'pdf'){
//echo "pdf";

require('../fpdf/mysql_report.php');

	$pdf = new PDF('L','pt','letter');
	$pdf->SetFont('Arial','',10);
	$pdf->connect($conf_host,$conf_usuario,$conf_pass,$bd_cnn);
	$attr = array('titleFontSize'=>12, 'titleText'=>'REPORTES DE ASISTENCIA FECHA: '.$fecha_D.' HASTA: '.$fecha_H.'');
	$pdf->mysql_report($sql01, false,$attr);
	$pdf->Output();
}

	if($reporte == 'txt'){

		  $sql01 = "SELECT v_as_hora_extra.cod_snvaria, trabajadores.cod_emp, Sum(v_as_hora_extra.horas)
                      FROM v_as_hora_extra, trabajadores, regiones, clientes, clientes_ubicacion, nomina
                ".$where."
                     GROUP BY trabajadores.cod_emp, v_as_hora_extra.cod_snvaria
					 ORDER BY 1 ASC ";
	Header("Content-T}ype: text/plain");
	Header("Content-Disposition: attachment; filename=".$archivo.".txt");
			mysql_select_db($bd_cnn,$cnn);
		  $query01 = mysql_query($sql01, $cnn);
			while ($row01 = mysql_fetch_array($query01)){
				echo "".utf8_decode($row01[0]).";".utf8_decode($row01[1]).";".utf8_decode($row01[2])."\r\n";
		}
	}
?>
