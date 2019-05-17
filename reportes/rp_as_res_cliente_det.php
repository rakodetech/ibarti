<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php
require_once("../autentificacion/aut_config.inc.php");
include_once('../funciones/funciones.php');
//mysql_select_db($bd_cnn, $cnn);
$id           = $_POST['id'];
$fecha_D      = conversion($_POST['fecha_desde']);
$fecha_H      = conversion($_POST['fecha_hasta']);
$cliente      = $_POST['cliente'];
$region       = $_POST['regiones'];
$reporte      = $_POST['reporte'];
$clasif_serv  = $_POST['clasif_serv'];
$rol          = $_POST['rol'];

$usuario     = $_POST['usuario'];
$usuario_id  = $_POST['usuario_id'];
$perfil      = $_POST['perfil'];

if(isset($reporte)){

	$where ="  WHERE v_asistencia_total_trab.co_cli =  clientes.co_cli
                 AND v_asistencia_total_trab.fecha BETWEEN \"$fecha_D\" AND \"$fecha_H\" ";

	if($usuario_id != "TODOS"){
		$where .= " AND v_asistencia_total_trab.id_usuario = '$usuario_id' ";
	}

	if($cliente != "TODOS"){
			$where .= " AND v_asistencia_total_trab.co_cli = '$cliente' ";
	}

       $sql01 = "SELECT v_asistencia_total_trab.fecha, v_asistencia_total_trab.id_usuario,
                        v_asistencia_total_trab.co_cli, clientes.cli_des AS Clientes,
                        v_asistencia_total_trab.N_Hombres
				   FROM v_asistencia_total_trab, clientes
                  ".$where."
				 UNION
				 SELECT CURDATE(), '', '',
				        'TOTAL', Sum(v_asistencia_total_trab.N_Hombres) AS N_Hombres
				   FROM v_asistencia_total_trab, clientes
                        ".$where." ORDER BY 1, 4 ASC";
	if($reporte== 'excel'){

		mysql_select_db($bd_cnn,$cnn);
		header("Content-type: application/vnd.ms-excel");
		 header("Content-Disposition:  filename=\"Resumen_Asist_Cliente.xls\";");

		$fondo01 = " bgcolor='#EBEBEB'";
		$fondo02 = " bgcolor='#E0E0E0'";
		  $query01 = mysql_query($sql01, $cnn);

		 echo "<table border=1>";

		 echo "<tr><th> FECHA </th><th> COD USUARIO </th><th> COD CLIENTES </th><th> CLIENTE </th><th> N� HOMBRES </th></tr>";
		while ($row01 = mysql_fetch_row($query01)){
		 echo "<tr><td ".$fondo01."> ".$row01[0]." </td><td".$fondo01.">".$row01[1]."</td><td".$fondo01.">".$row01[2]."</td><td".$fondo01.">".$row01[3]."</td><td".$fondo01.">".$row01[4]."</td></tr>";
		}
		 echo "</table>";
	}

	if($reporte== 'pdf'){
	require('../fpdf/mysql_report.php');

	$pdf = new PDF('L','pt','letter');
	$pdf->SetFont('Arial','',10);
	$pdf->connect($conf_host,$conf_usuario,$conf_pass,$bd_cnn);
	$attr = array('titleFontSize'=>12, 'titleText'=>'REPORTES DE RESUMEN ASISTENCIA POR CLIENTE, FECHA: '.$fecha_D.' HASTA: '.$fecha_H.'');
	$pdf->mysql_report($sql01, false,$attr);
	$pdf->Output();
	}
}
?>
