<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php
require_once("../autentificacion/aut_config.inc.php");
include_once('../funciones/funciones.php');

$id              = $_POST['id'];
$fecha_D         = conversion($_POST['fecha_desde']);
$fecha_H         = conversion($_POST['fecha_hasta']);

$region          = $_POST['region'];
$contracto       = $_POST['contracto'];
$categoria       = $_POST['categoria'];
$usuario_id      = $_POST['usuario_id'];
$trabajador      = $_POST['trabajador'];
$usuario         = $_POST['usuario'];

$reporte         = $_POST['reporte'];

$archivo         = "nomina_".$_POST['fecha_desde']."_".$_POST['fecha_hasta']."";
$titulo          = "REPORTE DE ASISTENCIA FECHA: ".$fecha_D." HASTA: ".$fecha_H."";

if(isset($reporte)){

		$where = " WHERE asistencia.fecha BETWEEN \"$fecha_D\" AND \"$fecha_H\"
                     AND asistencia.co_var = snvaria.co_var
	                 AND asistencia.co_var = snvaria_det.snvaria
	                 AND asistencia.cod_emp = trabajadores.cod_emp
	                 AND trabajadores.id_region = regiones.id
	                 AND trabajadores.co_cont = nomina.co_cont
					 AND trabajadores.id_region = snvaria_det.cod_region
					 AND control.profit_nomina = snvaria_det.cod_categoria";

	if($region != "TODOS"){
		$where .= " AND regiones.id = '$region' ";
	}

	if($contracto != "TODOS"){
		$where .= " AND nomina.co_cont = '$contracto' ";  // cambie AND asistencia.co_cont = '$contracto'
	}

	if($usuario_id != "TODOS"){
		$where  .= " AND asistencia.id_usuario = '$usuario_id' ";
	}

	if($trabajador != NULL){
		$where  .= " AND trabajadores.cod_emp = '$trabajador' ";
	}

	 mysql_select_db($bd_cnn,$cnn);

// QUERY A MOSTRAR //

     $sql01 = "SELECT trabajadores.cod_emp, trabajadores.ci,
                      trabajadores.nombres AS trabajdor, trabajadores.id_region,
				      regiones.descripcion AS region, trabajadores.co_cont,
				      nomina.des_cont AS nomina, snvaria_det.cod_snvaria AS conceptos,
				      SUM(snvaria_det.cantidad) AS Cantidad
                 FROM asistencia , snvaria , snvaria_det , trabajadores , regiones , nomina, control ".$where."
 		        GROUP BY trabajadores.cod_emp, trabajadores.ci,
                      trabajadores.nombres, trabajadores.id_region,
                      regiones.descripcion, trabajadores.co_cont,
                      nomina.des_cont, snvaria_det.cod_snvaria
		        ORDER BY 2 ASC";

if($reporte == 'excel'){

	header("Content-type: application/vnd.ms-excel");
	 header("Content-Disposition:  filename=\"".$archivo.".xls\";");

	$fondo01 = " bgcolor='#EBEBEB'";
	$fondo02 = " bgcolor='#E0E0E0'";
    $query01 = mysql_query($sql01, $cnn);

	 echo "<table border=1>";
	 echo "<tr><th> COD EMPLEADO </th><th> CI</th><th> TRABAJADOR </th><th> COD REGION </th>
	           <th> REGION </th><th> COD NOMINA </th><th> NOMINA </th><th> CONCEPTO </th>
			   <th> CANTIDAD </th></tr>";

	while ($row01 = mysql_fetch_row($query01)){
	 echo "<tr><td >".utf8_decode($row01[0])." </td><td >".utf8_decode($row01[1])." </td>
			 <td>".utf8_decode($row01[2])."</td><td>".utf8_decode($row01[3])."</td>
			 <td>".utf8_decode($row01[4])."</td><td>".utf8_decode($row01[5])."</td>
			 <td>".utf8_decode($row01[6])."</td><td>".utf8_decode($row01[7])."</td>
			 <td>".utf8_decode($row01[8])."</td></tr>";

	}
	 echo "</table>";
}

	if($reporte== 'pdf'){

	require('../fpdf/mysql_report.php');

		$pdf = new PDF('L','pt','letter');
		$pdf->SetFont('Arial','',10);
		$pdf->connect($conf_host,$conf_usuario,$conf_pass,$bd_cnn);
		$attr = array('titleFontSize'=>12, 'titleText'=>''.$titulo.'');
		$pdf->mysql_report($sql01, false,$attr);
		$pdf->Output();
	}

	if($reporte == 'txt'){

	Header("Content-Type: text/plain");
//	Header("Content-Disposition: attachment; filename=../txt/asistencia.txt");
	Header("Content-Disposition: attachment; filename=".$archivo.".txt");

		  $query01 = mysql_query($sql01, $cnn);
		//  $archivo = fopen("../txt/asistencia.txt","w+");
			while ($row01 = mysql_fetch_row($query01)){
				echo "".utf8_decode($row01[7]).";".utf8_decode($row01[0]).";".utf8_decode($row01[8])."\r\n";

	//				//  $archivo = fopen("../txt/asistencia.txt","w+");
//			while ($row01 = mysql_fetch_row($query01)){
				//$texto = "".utf8_decode($row01[0]).";".utf8_decode($row01[7]).";".utf8_decode($row01[8]).";\n";
			//	fwrite($archivo, $texto);
		}
	/*
		  $query01 = mysql_query($sql01, $cnn);
		  $archivo = fopen("../txt/asistencia.txt","w+");
			while ($row01 = mysql_fetch_row($query01)){
				$texto = "".utf8_decode($row01[0]).";".utf8_decode($row01[7]).";".utf8_decode($row01[8]).";\n";
				fwrite($archivo, $texto);
		}
		fclose($archivo);
*/
	}
}
?>
