<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php

require "../autentificacion/aut_config.inc.php";
include_once "../".Funcion;
require "../".class_bd;
require "../".Leng;

if(($_POST['fecha_desde'] == "" or $_POST['fecha_hasta'] == "")){
	exit;
}

$bd = new DataBase();

$fecha_D    = conversion($_POST['fecha_desde']);
$fecha_H    = conversion($_POST['fecha_hasta']);

$trabajador   = $_POST['trabajador'];
$capta_huella = $_POST['capta_huella'];
$cliente      = $_POST['cliente'];

$reporte         = $_POST['reporte'];

$archivo         = "capta_huella_".$fecha_D."_".$fecha_H."";
$titulo          = " REPORTE CAPTA HUELLA \n";

$where       = " WHERE DATE_FORMAT(v_ch_identify.fecha, '%Y-%m-%d') BETWEEN \"$fecha_D\" AND \"$fecha_H\"
									 AND v_ch_identify.cod_dispositivo = clientes_ub_ch.cod_capta_huella
									 AND clientes_ub_ch.cod_cl_ubicacion = clientes_ubicacion.codigo
									 AND clientes_ubicacion.cod_cliente = clientes.codigo ";

	 if($cliente != "TODOS"){
		$where  .= " AND clientes.codigo =  '$cliente' ";
	}

	if($capta_huella != "TODOS"){
		$where  .= " AND v_ch_identify.cod_dispositivo = '$capta_huella' ";
	}

	if($trabajador != NULL){
		$where  .= " AND ficha.cod_ficha = '$trabajador' ";
	}

$sql = "SELECT v_ch_identify.codigo,
							 IFNULL(ficha.cedula, 'SIN CEDULA') cedula ,  IFNULL(ficha.cod_ficha, 'SIN FICHA') cod_ficha,
							 IFNULL(CONCAT(ficha.apellidos,' ',ficha.nombres), 'v_ch_identify.huella') ap_nombre ,
							 v_ch_identify.cod_dispositivo, clientes_ubicacion.descripcion ubicacion,
							 clientes.nombre cliente, v_ch_identify.fechaserver,
							 v_ch_identify.fecha, v_ch_identify.hora
					FROM v_ch_identify LEFT JOIN ficha ON v_ch_identify.cedula = ficha.cedula AND ficha.cod_ficha_status = 'A',
							 clientes_ub_ch, clientes_ubicacion, clientes
			$where
					 ORDER BY fecha DESC ";

			$query_ch  = $bd->consultar($sql) or die ("error ch");


	if($reporte== 'excel'){
		header("Content-type: application/vnd.ms-excel");
		 header("Content-Disposition:  filename=\"rp_$archivo.xls\";");

		 echo "<table border=1>";

 	 echo "<tr><th> FECHA DISPOSITIVO </th><th> FECHA SERVER </th> <th>".$leng['cliente']."</th><th>".$leng['ubicacion']."</th>
	           <th>".$leng['ficha']."</th><th>".$leng['trabajador']."</th></tr>";

	while ($datos =$bd->obtener_fila($query_ch)){

				echo '<tr>
						  <td>'.$datos["fecha"].'</td>
						  <td>'.$datos["fechaserver"].'</td>
						  <td>'.$datos["cliente"].'</td>
						  <td>'.$datos["ubicacion"].'</td>
						  <td>'.$datos["cod_ficha"].'</td>
						  <td>'.$datos["ap_nombre"].'</td>
					</tr>';
        }
		 echo "</table>";
	}

	if($reporte == 'pdf'){

	require_once('../pdfClasses/class.ezpdf.php');
	$pdf =& new Cezpdf('A4', 'landscape');
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

				'fecha'=>'<b>Fecha</b>',
				'cliente'=>'<b>Clinte</b>',
				'ubicacion'=>'<b>Ubicacion</b>',
				'ap_nombre'=>'<b>Trabajador</b>');

    $options = array(
                    'shadeCol'=>array(0.9,0.9,0.9),
                    'xOrientation'=>'center',
                    'width'=>800 );

    $txttit = "<b>$titulo</b>\n";

    $pdf->ezText($txttit, 12);
    $pdf->ezTable($data, $titles, '', $options);
    $pdf->ezText("\n\n\n", 10);
    $pdf->ezText("<b>Fecha:</b> ".date("d/m/Y"), 10);
    $pdf->ezText("<b>Hora:</b> ".date("H:i:s")."\n\n", 10);
    $pdf->ezStream();    $txttit = "<b>BLOG.UNIJIMPE.NET</b>\n";
    $txttit.= "Ejemplo de PDF con PHP y MYSQL \n";
	}
?>
