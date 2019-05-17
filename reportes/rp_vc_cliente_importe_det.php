<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php
session_start();
$Nmenu   = 550;
require("../autentificacion/aut_config.inc.php");
include_once('../funciones/funciones.php');
require_once('../autentificacion/aut_verifica_menu_02.php');
require_once("../".class_bd);
$bd = new DataBase();

$cliente         = $_POST['cliente'];
$cargo           = $_POST['cargo'];
$turno           = $_POST['turno'];

$reporte         = $_POST['reporte'];

$archivo         = "rp_vc_cliente_importe".$fecha."";
$titulo          = "  REPORTE CLIENTES IMPORTE  \n";

if(isset($reporte)){

		$where = "WHERE clientes_importe.cod_cliente = clientes.codigo
	                AND clientes_importe.cod_ubicacion = clientes_ubicacion.codigo
                    AND clientes_importe.cod_cargo = cargos.codigo
                    AND clientes_importe.cod_turno = turno.codigo ";

	if($cliente != "TODOS"){
		$where .= " AND clientes.codigo = '$cliente' ";
	}

	if($cargo != "TODOS"){
		$where  .= " AND cargos.codigo = '$cargo' ";
	}

	if($turno != "TODOS"){
		$where  .= " AND turno.codigo = '$turno' ";
	}

	// QUERY A MOSTRAR //
		$sql = " SELECT clientes_importe.fecha, clientes.nombre AS cliente,
                         clientes.abrev AS cl_abrev, clientes_ubicacion.descripcion AS ubicacion,
						 cargos.descripcion AS cargo, turno.descripcion AS turno,
						  clientes_importe.importe, clientes_importe.observacion,
						 clientes_importe.fec_us_mod, clientes_importe.fec_us_ing
                    FROM clientes_importe , clientes , clientes_ubicacion, cargos , turno
                  $where
			    ORDER BY 1 ASC ";
	if($reporte== 'excel'){

		header("Content-type: application/vnd.ms-excel");
		 header("Content-Disposition:  filename=\"rp_$archivo.xls\";");

		$query01  = $bd->consultar($sql);
		 echo "<table border=1>";
 	 echo "<tr><th> FECHA </th><th> CLIENTE </th><th> CL. ABREV. </th><th> UBICACION</th>
	           <th> CARGO </th><th> TURNO </th><th> IMPORTE </th><th> OBSERVACION </th></tr>";

		while ($row01 = mysql_fetch_row($query01)){
		 echo "<tr><td > ".$row01[0]." </td><td>".$row01[1]."</td><td>".$row01[2]."</td><td>".$row01[3]."</td>
		 <td>".$row01[4]."</td><td>".$row01[5]."</td><td>".$row01[6]."</td><td>".$row01[7]."</td></tr>";
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
				'cliente'=>'<b>Cliente</b>',
				'ubicacion'=>'<b>Ubicacion</b>',
				'cargo'=>'<b>Cargo</b>',
				'turno'=>'<b>Turno</b>',
				'importe'=>'<b>importe</b>');

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
