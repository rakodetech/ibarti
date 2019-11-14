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

	if ($perfil == 1){

	}

	/*
SELECT nv_asistencia_tra_ubic.fecha, nv_asistencia_tra_ubic.id_usuario,
regiones.descripcion AS Region, nv_asistencia_tra_ubic.co_cli,
clientes.cli_des AS Clientes,  nv_asistencia_tra_ubic.id_ubicacion,
clientes_ubicacion.descripcion AS Ubicacion, nv_asistencia_tra_ubic.N_Hombres
FROM nv_asistencia_tra_ubic, clientes ,
clientes_ubicacion, regiones
WHERE nv_asistencia_tra_ubic.co_cli =  clientes.co_cli
AND nv_asistencia_tra_ubic.id_ubicacion =  clientes_ubicacion.id
AND clientes_ubicacion.id_region =  regiones.id  */

	$where =" WHERE nv_asistencia_tra_ubic.co_cli =  clientes.co_cli
                AND nv_asistencia_tra_ubic.id_ubicacion =  clientes_ubicacion.id
                AND clientes_ubicacion.id_region =  regiones.id
                AND nv_asistencia_tra_ubic.fecha BETWEEN \"$fecha_D\" AND \"$fecha_H\" ";

	if($region != "TODOS"){
		$where .=" AND clientes_ubicacion.id_region = '$region' ";
	}

	if($usuario_id != "TODOS"){
		$where .= " AND nv_asistencia_tra_ubic.id_usuario = '$usuario_id' ";
	}

	if($cliente != "TODOS"){
			$where .= " AND nv_asistencia_tra_ubic.co_cli = '$cliente' ";
	}

	   $sql01 = "SELECT nv_asistencia_tra_ubic.fecha, nv_asistencia_tra_ubic.id_usuario,
                        regiones.descripcion AS Region, nv_asistencia_tra_ubic.co_cli,
                        clientes.cli_des AS Clientes,  nv_asistencia_tra_ubic.id_ubicacion,
                        clientes_ubicacion.descripcion AS Ubicacion, nv_asistencia_tra_ubic.N_Hombres
                   FROM nv_asistencia_tra_ubic, clientes , clientes_ubicacion, regiones
                        ".$where."
				 UNION
				 SELECT CURDATE(), '', '', '',  '', '',
				        'TOTAL', Sum(nv_asistencia_tra_ubic.N_Hombres)
				    FROM nv_asistencia_tra_ubic, clientes , clientes_ubicacion, regiones
                        ".$where." ORDER BY 1, 5, 7 ASC";
	if($reporte== 'excel'){

		mysql_select_db($bd_cnn,$cnn);
		header("Content-type: application/vnd.ms-excel");
		 header("Content-Disposition:  filename=\"Resumen_Asist_Ubicacion.xls\";");

		$fondo01 = " bgcolor='#EBEBEB'";
		$fondo02 = " bgcolor='#E0E0E0'";
		  $query01 = mysql_query($sql01, $cnn);

		 echo "<table border=1>";
		 echo "<tr><th> FECHA </th><th> REGION </th><th> COD USUARIO </th><th> COD CLIENTE </th><th> CLIENTE </th><th> COD UBIC. </th><th> UBICACION </th><th> N� PERSONA </th></tr>";

		while ($row01 = mysql_fetch_row($query01)){
		 echo "<tr><td ".$fondo01."> ".$row01[0]." </td><td".$fondo01.">".$row01[1]."</td><td".$fondo01.">".$row01[2]."</td><td".$fondo01.">".$row01[3]."</td><td".$fondo01.">".$row01[4]."</td><td".$fondo01.">".$row01[5]."</td><td".$fondo01.">".$row01[6]."</td><td".$fondo01.">".$row01[7]."</td></tr>";
		}
		 echo "</table>";
	}

	if($reporte== 'pdf'){
	require('../fpdf/mysql_report.php');

	$pdf = new PDF('L','pt','letter');
	$pdf->SetFont('Arial','',10);
	$pdf->connect($conf_host,$conf_usuario,$conf_pass,$bd_cnn);
	$attr = array('titleFontSize'=>12, 'titleText'=>'REPORTES DE RESUMEN ASITENCIA POR UBICACION CLIENTE, FECHA: '.$fecha_D.' HASTA: '.$fecha_H.'');
	$pdf->mysql_report($sql01, false,$attr);
	$pdf->Output();
	}
}
?>
