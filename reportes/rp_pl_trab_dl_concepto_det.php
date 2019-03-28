<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php
session_start();
$Nmenu   = 5300;
require("../autentificacion/aut_config.inc.php");
include_once('../funciones/funciones.php');
require_once('../autentificacion/aut_verifica_menu_02.php');
require_once("../".class_bd);
$bd = new DataBase();
if(($_POST['fecha_desde'] == "" or $_POST['fecha_hasta'] == "")){
exit;
}
$rol        = $_POST['rol'];
$region     = $_POST['region'];
$estado     = $_POST['estado'];
$contrato   = $_POST['contrato'];
$cliente    = $_POST['cliente'];
$ubicacion  = $_POST['ubicacion'];
$trabajador = $_POST['trabajador'];

$fecha_D   = conversion($_POST['fecha_desde']);
$fecha_H   = conversion($_POST['fecha_hasta']);

$reporte         = $_POST['reporte'];

$archivo         = "rp_pl_trab_dl_concepto_".$fecha."";
$titulo          = "PLANIFICACION DE TRABAJADORES, DL Y CONCEPTOS \n";

if(isset($reporte)){

$where = " WHERE pl_trabajador.fecha BETWEEN \"$fecha_D\" AND \"$fecha_H\"
		     AND pl_trabajador.codigo = pl_trabajador_det.cod_pl_trabajador
		     AND pl_trabajador_det.cod_ficha = v_ficha.cod_ficha
			 AND pl_trabajador.cod_turno = turno.codigo
             AND pl_trabajador_det.cod_cliente = clientes.codigo
             AND pl_trabajador_det.cod_ubicacion = clientes_ubicacion.codigo ";

$where1 = " WHERE pl_trab_dl.fecha BETWEEN \"$fecha_D\" AND \"$fecha_H\"
		      AND pl_trab_dl.cod_ficha = v_ficha.cod_ficha
              AND pl_trab_dl.cod_cliente = clientes.codigo
              AND pl_trab_dl.cod_ubicacion = clientes_ubicacion.codigo
              AND pl_trab_dl.cod_turno = turno.codigo ";

$where2 = "WHERE pl_trab_concepto_det.fecha BETWEEN \"$fecha_D\" AND \"$fecha_H\"
             AND pl_trab_concepto.codigo = pl_trab_concepto_det.cod_pl_trab_concepto
		     AND pl_trab_concepto_det.cod_turno = turno.codigo
		     AND pl_trab_concepto_det.cod_ficha  = v_ficha.cod_ficha";

	if($rol != "TODOS"){
		$where .= " AND v_ficha.cod_rol  = '$rol' ";
		$where1 .= " AND v_ficha.cod_rol = '$rol' ";
		$where2 .= " AND v_ficha.cod_rol = '$rol' ";
	}
	if($region != "TODOS"){
		$where  .= " AND v_ficha.cod_region = '$region' ";
		$where1 .= " AND v_ficha.cod_region = '$region' ";
		$where2 .= " AND v_ficha.cod_region = '$region' ";
	}

	if($estado != "TODOS"){
		$where  .= " AND v_ficha.cod_estado = '$estado' ";
		$where1 .= " AND v_ficha.cod_estado = '$estado' ";
		$where2 .= " AND v_ficha.cod_estado = '$estado' ";
	}

	if($contrato != "TODOS"){
		$where   .= " AND v_ficha.cod_contracto = '$contrato' ";
		$where1  .= " AND v_ficha.cod_contracto = '$contrato' ";
		$where2  .= " AND v_ficha.cod_contracto = '$contrato' ";
	}

	if($trabajador != NULL){
		$where   .= " AND  v_ficha.cod_ficha = '$trabajador' ";
		$where1  .= " AND  v_ficha.cod_ficha = '$trabajador' ";
		$where2  .= " AND  v_ficha.cod_ficha = '$trabajador' ";
	}

	if($cliente  != "TODOS"){
		$where   .= " AND pl_trabajador_det.cod_cliente = '$cliente' ";
		$where1  .= " AND pl_trab_dl.cod_cliente = '$cliente' ";
		$where2  .= " AND pl_trab_concepto.cod_cliente = '$cliente'  ";
	}

	if($ubicacion != "TODOS"){
		$where   .= " AND pl_trabajador_det.cod_ubicacion = '$ubicacion' ";
		$where1  .= " AND  pl_trab_dl.cod_ubicacion = '$ubicacion' ";
		$where2  .= " AND pl_trab_concepto.cod_ubicacion = '$ubicacion' ";
	}

 $sql = "SELECT pl_trabajador.fecha, 'PLANIF TRABAJADOR' AS clasif,
                    turno.abrev as detalle,  pl_trabajador_det.cod_ficha,
                    v_ficha.ap_nombre, v_ficha.rol,
			   v_ficha.region,  v_ficha.estado,
               clientes.nombre AS cliente,  clientes_ubicacion.descripcion AS ubicacion,
               v_ficha.contracto, v_ficha.cargo
	      FROM pl_trabajador , pl_trabajador_det, v_ficha, turno, clientes, clientes_ubicacion
		  $where
    UNION ALL
		SELECT pl_trab_dl.fecha,  'PLANIF DL' AS planif_dl,
		       turno.abrev AS turno,  pl_trab_dl.cod_ficha,
		       v_ficha.ap_nombre, v_ficha.rol,
		       v_ficha.region, v_ficha.estado,
               clientes.nombre AS cliente, clientes_ubicacion.descripcion AS ubicacion,
		       v_ficha.contracto, v_ficha.cargo
	      FROM pl_trab_dl, v_ficha, clientes, clientes_ubicacion, turno

	 $where1
UNION ALL

		SELECT pl_trab_concepto_det.fecha, 'conceptos' ,
		       turno.abrev AS detalle,  pl_trab_concepto_det.cod_ficha,
               v_ficha.ap_nombre, v_ficha.rol,
			   v_ficha.region, v_ficha.estado,
               '' AS cliente, '' AS ubicacion,
			   v_ficha.contracto, v_ficha.cargo
		  FROM pl_trab_concepto, pl_trab_concepto_det, turno, v_ficha
	       $where2
  ORDER BY 1, 2 ASC ";

	if($reporte== 'excel'){

		 header("Content-type: application/vnd.ms-excel");
		 header("Content-Disposition:  filename=\"rp_$archivo.xls\";");

		$query01  = $bd->consultar($sql);

		 echo "<table border=1>";
 	 echo "<tr><th> FECHA </th><th> CLASIFICACION </th><th> DETALLE </th><th> FICHA  </th>
	           <th> TRABAJADOR </th><th> ROL </th><th> REGION </th><th> ESTADO </th>
			   <th> CLIENTE </th><th> UBICACION </th><th> CONTRATO </th><th> CARGO </th></tr>";

		while ($row01 = mysql_fetch_row($query01)){
		 echo "<tr><td> ".$row01[0]." </td><td>".$row01[1]."</td><td>".$row01[2]."</td><td>".$row01[3]."</td>
		           <td>".$row01[4]."</td><td>".$row01[5]."</td><td>".$row01[6]."</td><td>".$row01[7]."</td>
		           <td>".$row01[8]."</td><td>".$row01[9]."</td><td>".$row01[10]."</td><td>".$row01[11]."</td></tr>";
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
				'rol'=>'<b>Rol</b>',
				'fecha'=>'<b>Fecha</b>',
				'cod_ficha'=>'<b>Ficha</b>',
				'ap_nombre'=>'<b>Trabajador</b>',
				'clasif'=>'<b>Clasif</b>',
				'detalle'=>'<b>Detalle</b>');

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
}
?>
