<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php
session_start();
$Nmenu   = 550;
require("../autentificacion/aut_config.inc.php");
include_once('../funciones/funciones.php');
require_once('../autentificacion/aut_verifica_menu_02.php');
require_once("../".class_bd);
$bd = new DataBase();

$fecha_D         = conversion($_POST['fecha_desde']);
$fecha_H         = conversion($_POST['fecha_hasta']);
$cliente         = $_POST['cliente'];
$cargo           = $_POST['cargo'];
$turno           = $_POST['turno'];

$reporte         = $_POST['reporte'];

$archivo         = "rp_vc_calculo_cl_importe_".$fecha."";
$titulo          = "  REPORTE CALCULO CLIENTES IMPORTE  \n";

if(isset($reporte)){


		$where = "WHERE pl_cliente.fecha BETWEEN \"$fecha_D\" AND \"$fecha_H\"
				    AND pl_cliente.codigo = pl_cliente_det.cod_pl_cliente
                    AND pl_cliente_det.cod_cliente = clientes.codigo
                    AND pl_cliente_det.cod_ubicacion = clientes_ubicacion.codigo
                    AND pl_cliente_det.cod_cargo = cargos.codigo
                    AND pl_cliente.cod_turno = turno.codigo
                    AND clientes.codigo = clientes_importe.cod_cliente
                    AND clientes_ubicacion.codigo = clientes_importe.cod_ubicacion
                    AND cargos.codigo = clientes_importe.cod_cargo
                    AND turno.codigo = clientes_importe.cod_turno
					AND clientes_importe.fecha = (SELECT MAX(a.fecha) AS fecha
                                                    FROM clientes_importe AS a
                                                   WHERE a.cod_ubicacion = clientes_importe.cod_ubicacion
                                                     AND a.cod_cliente = clientes_importe.cod_cliente
                                                     AND a.cod_cargo = clientes_importe.cod_cargo
                                                     AND a.cod_turno = clientes_importe.cod_turno)";

	if($cliente != "TODOS"){
		$where  .= " AND clientes.codigo = '$cliente' ";
	}

	if($cargo  != "TODOS"){
		$where .= " AND cargo.codigo = '$cargo' ";
	}

	if($turno  != "TODOS"){
		$where .= " AND turno.codigo = '$turno' ";
	}

	// QUERY A MOSTRAR //
		$sql = " SELECT DISTINCT clientes.abrev AS cl_abrev, clientes.nombre AS cliente,
                        clientes_ubicacion.descripcion AS ubicacion, cargos.descripcion AS cargo,
                        turno.abrev AS turno_abrev, turno.descripcion AS turno,
                        pl_cliente_det.cantidad, Count(pl_cliente_det.cantidad) AS rep,
						clientes_importe.importe, ((pl_cliente_det.cantidad)*(clientes_importe.importe)) AS total
                   FROM pl_cliente , pl_cliente_det, clientes, clientes_ubicacion,
				        cargos, turno , clientes_importe
                 $where

			   GROUP BY clientes.abrev, clientes.nombre,
                        clientes_ubicacion.descripcion, cargos.descripcion,
                        turno.abrev, turno.descripcion
			   ORDER BY rep DESC";

	if($reporte== 'excel'){

		header("Content-type: application/vnd.ms-excel");
		 header("Content-Disposition:  filename=\"rp_$archivo.xls\";");

		$query01  = $bd->consultar($sql);
		 echo "<table border=1>";
 	 echo "<tr><th> CLIENTE </th><th> UBICACION</th><th> CARGO </th> <th> TURNO </th>
	           <th> CANTIDAD </th><th> IMPORTE </th><th> TOTAL </th></tr>";

		while ($row01 = mysql_fetch_row($query01)){
		 echo "<tr><td > ".$row01[1]." </td><td>".$row01[2]."</td><td>".$row01[3]."</td><td>".$row01[5]."</td>
		 <td>".$row01[6]."</td><td>".$row01[8]."</td><td>".$row01[9]."</td></tr>";
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
				'cliente'=>'<b>Cliente</b>',
				'ubicacion'=>'<b>Ubicacion</b>',
				'cargo'=>'<b>Cargo</b>',
				'cantidad'=>'<b>Cantidad</b>',
				'importe'=>'<b>Importe</b>',
				'total'=>'<b>Total</b>');

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
