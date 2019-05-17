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
$contracto       = $_POST['contracto'];
$cliente         = $_POST['cliente'];
$region          = $_POST['region'];

if(isset($reporte)){
	$where = " ";

	if($cliente != "TODOS"){
		$where  .= " AND asistencia.co_cli =  '$cliente' ";
	}

	if($region != "TODOS"){
		$where  .= " AND trabajadores.id_region = '$region' ";
	}

	if($trabajador != NULL){
		$where  .= " AND trabajadores.cod_emp = '$trabajador' ";
	}

	if($usuario_id != "TODOS"){
		$where  .= " AND asistencia.id_usuario = '$usuario_id' ";
	}

	if($contracto != "TODOS"){
		$where  .= " AND asistencia.co_cont = '$contracto' ";
	}

//	$sql01 = $sql00.$cli.$reg.$tratrabajadores.$usuario_id.$orden;
}

		  $sql01 = "SELECT asistencia.fecha AS Fecha_Diaria, regiones.descripcion AS Region,
		                   clientes.co_cli, clientes.cli_des AS Cliente,
						   clientes_ubicacion.descripcion AS Ubicacion,
						   nomina.des_cont AS Contracto,
						    trabajadores.cod_emp AS Codigo,
						   trabajadores.ci AS Cedula, trabajadores.nombres AS Nombres,
						    snvaria.abrev AS Abrev,
						   asistencia.hora_s AS Hora, asistencia.vale
				  	  FROM asistencia, trabajadores, clientes, clientes_ubicacion , snvaria, regiones, nomina, cargos
					 WHERE asistencia.cod_emp =  trabajadores.cod_emp
					   AND asistencia.co_cli =  clientes.co_cli
					   AND asistencia.id_ubicacion =  clientes_ubicacion.id
					   AND asistencia.co_var =  snvaria.co_var
					   AND clientes_ubicacion.id_region = regiones.id
					   AND asistencia.co_cont = nomina.co_cont
					   AND asistencia.fecha between \"$fecha_D\" AND \"$fecha_H\" ".$where." ORDER BY 1, 4, 5  ASC ";

if($reporte== 'excel'){

	mysql_select_db($bd_cnn,$cnn);
	header("Content-type: application/vnd.ms-excel");
	 header("Content-Disposition:  filename=\"REPORTE_ASISTENCIA.xls\";");

	$fondo01 = " bgcolor='#EBEBEB'";
	$fondo02 = " bgcolor='#E0E0E0'";
    $query01 = mysql_query($sql01, $cnn);

	 echo "<table border=1>";
	 echo "<tr><th> FECHA DIARIA </th><th> REGION </th><th> CODIGO  </th><th> CLIENTE </th>
	 <th> UBICACION </th><th> CONTRACTO</th><th> CODIGO </th><th> CEDULA </th>
	 <th> NOMBRE Y APELLIDO </th>  <th> ABREV.</th><th> HORA </th><th> VALE </th></tr>";


	while ($row01 = mysql_fetch_row($query01)){
	 echo "<tr><td >".utf8_decode($row01[0])." </td><td >".utf8_decode($row01[1])." </td>
	           <td>".utf8_decode($row01[2])."</td><td>".utf8_decode($row01[3])."</td>
			   <td>".utf8_decode($row01[4])."</td><td>".utf8_decode($row01[5])."</td>
			   <td>".utf8_decode($row01[6])."</td><td>".utf8_decode($row01[7])."</td>
			   <td>".utf8_decode($row01[8])."</td><td>".utf8_decode($row01[9])."</td>
			   <td>".utf8_decode($row01[10])."</td><td>".utf8_decode($row01[11])."</td></tr>";

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
?>
