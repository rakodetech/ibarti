<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php
session_start();
$Nmenu   = 507;
require("../autentificacion/aut_config.inc.php");
include_once('../funciones/funciones.php');
require_once('../autentificacion/aut_verifica_menu_02.php');
require_once("../".class_bd);
$bd = new DataBase();

$fecha_D         = conversion($_POST['fecha_desde']);
$fecha_H         = conversion($_POST['fecha_hasta']);
$region          = $_POST['region'];
$estado          = $_POST['estado'];
$ciudad          = $_POST['ciudad'];
$rol             = $_POST['rol'];
$reporte         = $_POST['reporte'];

$archivo         = "rp_ubicacion_".$_POST['fecha_desde']."";
$titulo          = " REPORTES DE UBICACION FECHA: ".$fecha_D." HASTA: ".$fecha_H."\n";

if(isset($reporte)){

		$where = " WHERE asistencia_apertura.fec_diaria BETWEEN \"$fecha_D\" AND \"$fecha_H\"
                     AND asistencia_apertura.codigo = v_asistencia.cod_as_apertura
					 AND v_asistencia.cod_ficha = v_ficha.cod_ficha ";

	if($region != "TODOS"){
		$where .= " AND v_ficha.cod_region = '$region' ";
	}
/*
	if($estado != "TODOS"){
		$where .= " AND v_ficha.cod_estado = '$estado' ";  // cambie AND asistencia.co_cont = '$contracto'
	}

	if($ciudad != "TODOS"){
		$where  .= "  ";
	}
	*/

	if($rol != "TODOS"){
		$where  .= " AND v_ficha.cod_rol = '$rol' ";
	}


	// QUERY A MOSTRAR //
		$sql = "SELECT asistencia_apertura.fec_diaria, v_asistencia.cod_as_apertura,
                       v_asistencia.cod_ficha, v_asistencia.cod_cliente,
                       v_asistencia.cliente, v_asistencia.cod_ubicacion,
                       v_asistencia.ubicacion, v_asistencia.cod_region,
                       v_asistencia.region, Count(v_asistencia.cod_ficha) AS cantidad
                  FROM asistencia_apertura , v_asistencia , v_ficha
			           $where
			  GROUP BY asistencia_apertura.fec_diaria, v_asistencia.cod_as_apertura,
		           	   v_asistencia.cod_cliente, v_asistencia.cliente,
			           v_asistencia.cod_ubicacion, v_asistencia.ubicacion,
			           v_asistencia.cod_region, v_asistencia.region
		  	  ORDER BY 1 ASC";

	if($reporte== 'excel'){

		header("Content-type: application/vnd.ms-excel");
		 header("Content-Disposition:  filename=\"rp_ubioacion.xls\";");

		$fondo01 = " bgcolor='#EBEBEB'";
		$fondo02 = " bgcolor='#E0E0E0'";

		$query01  = $bd->consultar($sql);

		 echo "<table border=1>";
	 echo "<tr><th>FECHA DIARIA </th><th> REGION </th><th> CLIENTE </th><th> CANTIDAD</th></tr>";

		while ($row01 = mysql_fetch_row($query01)){
		 echo "<tr><td ".$fondo01."> ".$row01[0]." </td><td".$fondo01.">".$row01[1]."</td>
		 <td".$fondo01.">".$row01[2]."</td><td".$fondo01.">".$row01[3]."</td></tr>";

		}
		 echo "</table>";

	}

	if($reporte == 'pdf'){

	require_once('../pdfClasses/class.ezpdf.php');
	$pdf =& new Cezpdf('a4');
	$pdf->selectFont('../pdfClasses/fonts/Courier.afm');
	$pdf->ezSetCmMargins(1,1,1.5,1.5);


		$query01  = $bd->consultar($sql);
		$totEmp = mysql_num_rows($query01);
    $ixx = 0;

    while($datatmp = mysql_fetch_assoc($query01)) {
        $ixx = $ixx+1;
        $data[] = array_merge($datatmp, array('num'=>$ixx));
    }

$titles = array(
				'fec_diaria'=>'<b>Fecha Diaria</b>',
				'region'=>'<b>Region</b>',
				'cliente'=>'<b>Cliente</b>',
				'cantidad'=>'<b>Cantidad</b>' );

    $options = array(
                    'shadeCol'=>array(0.9,0.9,0.9),
                    'xOrientation'=>'center',
                    'width'=>500 );

    $txttit = "<b>$titulo</b>\n";

    $pdf->ezText($txttit, 12);
    $pdf->ezTable($data, $titles, '', $options);
    $pdf->ezText("\n\n\n", 10);
    $pdf->ezText("<b>Fecha:</b> ".date("d/m/Y"), 10);
    $pdf->ezText("<b>Hora:</b> ".date("H:i:s")."\n\n", 10);
    $pdf->ezStream();    $txttit = "<b>BLOG.UNIJIMPE.NET</b>\n";
    $txttit.= "Ejemplo de PDF con PHP y MYSQL \n";
	}
}
?>
