<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php
require_once("../autentificacion/aut_config.inc.php");
include_once('../funciones/funciones.php');
//mysql_select_db($bd_cnn, $cnn);

$fecha_D      = conversion($_POST['fecha_desde']);
$fecha_H      = conversion($_POST['fecha_hasta']);
$region       = $_POST['regiones'];
$reporte      = $_POST['reporte'];

$usuario     = $_POST['usuario'];

if(isset($reporte)){


	$where ="  WHERE v_asis_oesvica_cl.fecha BETWEEN \"$fecha_D\" AND \"$fecha_H\"
                 AND v_asis_oesvica_cl.id_region = regiones.id ";

	if($region != "TODOS"){
		$where .= " AND regiones.id = '$region' ";
	}

       $sql01 = " SELECT v_asis_oesvica_cl.fecha AS FECHA, regiones.descripcion AS REGION,
	                     v_asis_oesvica_cl.N_asis_cliente AS N_ASISTENCIA_CLIENTE,
						 v_asis_oesvica_cl.N_asis_oesvica AS N_ASISTENCIA_OESVICA,
                         IFNULL( v_as_oesvica_24_union.as_oesvica_24, '0' ) AS 24_HORAS,
                         IFNULL(v_as_vacaciones.Vacaciones , '0' ) AS VACACIONES,
                         IFNULL( v_as_reposo.Reposo, '0' ) AS REPOSO
                    FROM v_asis_oesvica_cl LEFT JOIN v_as_oesvica_24_union ON v_asis_oesvica_cl.fecha = v_as_oesvica_24_union.fecha
                         AND v_asis_oesvica_cl.id_region = v_as_oesvica_24_union.id_region
                         LEFT JOIN v_as_vacaciones ON v_asis_oesvica_cl.fecha = v_as_vacaciones.fecha
                         AND v_asis_oesvica_cl.id_region = v_as_vacaciones.id_region
                         LEFT JOIN v_as_reposo ON v_asis_oesvica_cl.fecha = v_as_reposo.fecha
                         AND v_asis_oesvica_cl.id_region = v_as_reposo.id_region , regiones
				 $where
				 ORDER BY 1 , 2 ASC ";
	if($reporte== 'excel'){

		mysql_select_db($bd_cnn,$cnn);
		header("Content-type: application/vnd.ms-excel");
		 header("Content-Disposition:  filename=\"rp_analisis_homb_prod.xls\";");

		$fondo01 = " bgcolor='#EBEBEB'";
		$fondo02 = " bgcolor='#E0E0E0'";
		  $query01 = mysql_query($sql01, $cnn);

		 echo "<table border=1>";

		 echo "<tr><th> FECHA </th><th> REGION </th><th> N. ASIS. CLIENTE </th><th> N. ASIS. OESVICA </th>
		           <th> 24H OESVICA </th><th> VACACIONES </th><th> REPOSOS </th><th> PORCENTAJE </th></tr>";
		while ($row01 = mysql_fetch_row($query01)){
			//$a = round($row01[2]);
			$cl  = intval($row01[2]);
			$oesv = intval($row01[3]);
			$h24  = intval($row01[4]);
			$vac = intval($row01[5]);
			$rep = intval($row01[6]);
		 echo "<tr><td> ".utf8_decode($row01[0])." </td><td>".utf8_decode($row01[1])."</td>
		           <td>".$cl."</td><td>".$oesv."</td>
		           <td>".$h24."</td><td>".$vac."</td>
				   <td>".$rep."</td><td>".intval(((($oesv-($h24+$vac+$rep))*100)/$cl))."</td></tr>";
		}

		// <td>".$c."</td><td>".intval(((($b-$c)*100)/$a))."</td>
		 echo "</table>";
	}
	/*
	if($reporte== 'pdf'){
	require('../fpdf/mysql_report.php');

	$pdf = new PDF('L','pt','letter');
	$pdf->SetFont('Arial','',10);
	$pdf->connect($conf_host,$conf_usuario,$conf_pass,$bd_cnn);
	$attr = array('titleFontSize'=>12, 'titleText'=>'REPORTES DE RESUMEN ASISTENCIA POR CLIENTE, FECHA: '.$fecha_D.' HASTA: '.$fecha_H.'');
	$pdf->mysql_report($sql01, false,$attr);
	$pdf->Output();
	}
	*/
}
?>
