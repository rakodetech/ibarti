<?php
define("SPECIALCONSTANT",true);
$Nmenu   = 560;
require("../autentificacion/aut_config.inc.php");
require_once("../".Funcion);
require_once("../".class_bdI);
require_once("../".Leng);
$bd = new DataBase();

$novedades       = $_POST['novedades'];
$clasif          = $_POST['clasif'];
$tipo            = $_POST['tipo'];
$check_list      = $_POST['check_list'];
$valores         = $_POST['valores'];
$status          = $_POST['status'];
$reporte         = $_POST['reporte'];
$archivo         = "rp_nov_novedad_clasif_".$fecha."";
$titulo          = " REPORTE DE NOVEDADES CLASIFICACION \n";

if(isset($reporte)){

	$where = "  WHERE novedades.cod_nov_clasif = nov_clasif.codigo
                  AND novedades.cod_nov_tipo = nov_tipo.codigo ";

	$where02 = "  WHERE novedades.cod_nov_clasif = nov_clasif.codigo
                    AND novedades.cod_nov_tipo = nov_tipo.codigo
                    AND novedades.codigo = nov_valores_det.cod_novedades
                    AND nov_valores_det.cod_valores = nov_valores.codigo ";


	if($novedades != "TODOS"){
		$where  .= " AND novedades.codigo = '$novedades' ";
		$where02 .= " AND novedades.codigo = '$novedades' ";
	}

	if($clasif != "TODOS"){
		$where .= " AND nov_clasif.codigo = '$clasif' ";
 		$where02 .= " AND nov_clasif.codigo = '$clasif' ";
	}

	if($check_list != "TODOS"){
		$where  .= " AND nov_clasif.campo04 = '$check_list' ";
		$where02  .= " AND nov_clasif.campo04 = '$check_list' ";
	}

	if($tipo != "TODOS"){
		$where  .= " AND nov_tipo.codigo = '$tipo' ";
		$where02  .= " AND nov_tipo.codigo = '$tipo' ";
	}
	if($status != "TODOS"){
		$where  .= " AND novedades.`status` = '$status' ";
		$where02  .= " AND novedades.`status` = '$status' ";
	}


	// QUERY A MOSTRAR //
		  	$sql = "SELECT novedades.codigo,   Valores(nov_clasif.campo04) AS check_list,
                           nov_clasif.descripcion AS clasif,  nov_tipo.descripcion AS tipo,
  			               novedades.descripcion AS novedades, novedades.orden,
						   Valores(novedades.`status`) AS `status`
                      FROM novedades , nov_clasif, nov_tipo
                    $where
                  ORDER BY 2, novedades.orden ASC ";


		  	$sql02 = "SELECT novedades.codigo, Valores(nov_clasif.campo04) AS check_list,
                             nov_clasif.descripcion AS clasif, nov_tipo.descripcion AS tipo,
                             novedades.descripcion AS novedades,  novedades.orden,
							 Valores(novedades.`status`) AS `status`,
                             nov_valores.abrev, nov_valores.descripcion AS valores,
                             nov_valores.factor, nov_valores_det.valor

                        FROM novedades , nov_clasif , nov_tipo , nov_valores_det ,
                             nov_valores
                    $where02
                  ORDER BY 2, novedades.orden ASC ";


	if($reporte== 'excel'){
		echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition:  filename=\"$archivo.xls\";");
		echo "<table border=1>";

		if ($valores == "F"){

		$query01  = $bd->consultar($sql);

				 echo "<tr><th> Código </th><th> Check List </th><th>Clasificación </th> <th>Tipo </th>
						   <th> Novedades </th><th> Orden </th><th> Status </th></tr>";

				while ($row01 = $bd->obtener_num($query01)){
				 echo "<tr><td>".$row01[0]."</td><td>".$row01[1]."</td><td>".$row01[2]."</td><td>".$row01[3]."</td>
						   <td>".$row01[4]."</td><td>".$row01[5]."</td><td>".$row01[6]."</td></tr>";
				}
		}elseif($valores == "T"){

		$query01  = $bd->consultar($sql02);

				 echo "<tr><th> Código </th><th> Check List </th><th>Clasificación </th> <th>Tipo </th>
						   <th> Novedades </th><th> Orden </th><th> Status </th><th> Abreviatura </th>
						   <th> Valores </th><th> Factor </th><th> Valor </th>
						   </tr>";

				while ($row01 = $bd->obtener_num($query01)){
				 echo "<tr><td>".$row01[0]."</td><td>".$row01[1]."</td><td>".$row01[2]."</td><td>".$row01[3]."</td>
						   <td>".$row01[4]."</td><td>".$row01[5]."</td><td>".$row01[6]."</td><td>".$row01[7]."</td>
						   <td>".$row01[8]."</td><td>".$row01[9]."</td><td>".$row01[10]."</td></tr>";
				}
		}
	 echo "</table>";
	}
	if($reporte == 'pdf'){

		require_once('../'.ConfigDomPdf);
		$dompdf= new DOMPDF();


		if ($valores == "F"){

		$query = $bd->consultar($sql);

		}elseif($valores == "T"){

		$query  = $bd->consultar($sql02);

		}


		ob_start();

		require('../'.PlantillaDOM.'/header_ibarti_2.php');
		include('../'.pagDomPdf.'/paginacion_ibarti.php');


		if ($valores == "F"){
		echo "<br><div>
        <table>
		<tbody>
            <tr style='background-color: #4CAF50;'>
            <th width='10%'>Código</th>
            <th width='12%'>Check List</th>
            <th width='28%'>Clasificación</th>
            <th width='34%'>Novedades</th>
            <th width='8%'>Orden</th>
            <th width='8%'>Status</th>
            </tr>";

            $f=0;
    while ($row = $bd->obtener_num($query)){
    	 if ($f%2==0){
                echo "<tr>";
            }else{
                echo "<tr class='class= odd_row'>";
            }
    echo   "<td width='10%'>".$row[0]."</td>
   		    <td width='12%'>".$row[1]."</td>
            <td width='28%'>".$row[2]."</td>
            <td width='34%'>".$row[4]."</td>
            <td width='8%'>".$row[5]."</td>
            <td width='8%'>".$row[6]."</td></tr>";

             $f++;
         }
          echo "</tbody>
		        </table>
				</div>
				</body>
				</html>";

         	$dompdf->load_html(ob_get_clean(),'UTF-8');
		    $dompdf->render();
		    $dompdf->stream($archivo, array('Attachment' => 0));

		}elseif($valores == "T"){
			echo "<br><div>
        <table>
		<tbody>
            <tr style='background-color: #4CAF50;'>
            <th width='10%'  style='text-align:center;'>Código</th>
            <th width='12%'  style='text-align:center;'>Check List</th>
            <th width='20%'>Clasificación</th>
            <th width='32%'>Novedades</th>
            <th width='10%' style='text-align:center;'>Abreviatura</th>
            <th width='8%'  style='text-align:center;'>Valor</th>
            <th width='8%'  style='text-align:center;'>Status</th>
            </tr>";


            $f=0;
    while ($row = $bd->obtener_num($query)){
    	 if ($f%2==0){
                echo "<tr>";
            }else{
                echo "<tr class='class= odd_row'>";
            }
    echo   "<td width='10%'  style='text-align:center;'>".$row[0]."</td>
   		    <td width='12%'  style='text-align:center;'>".$row[1]."</td>
            <td width='20%'>".$row[2]."</td>
            <td width='32%'>".$row[4]."</td>
            <td width='10%'  style='text-align:center;'>".$row[7]."</td>
            <td width='8%'  style='text-align:center;'>".$row[10]."</td>
            <td width='8%'  style='text-align:center;'>".$row[6]."</td></tr>";

             $f++;
         }
			
    echo "</tbody>
        </table>
		</div>
		</body>
		</html>";

		    $dompdf->load_html(ob_get_clean(),'UTF-8');
		    $dompdf->set_paper ('letter','landscape');
		    $dompdf->render();
		    $dompdf->stream($archivo, array('Attachment' => 0));
	}
	}

	/*
	if($reporte== 'excel'){

		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition:  filename=\"$archivo.xls\";");
		echo "<table border=1>";

		if ($valores == "F"){

		$query01  = $bd->consultar($sql);

				 echo "<tr><th> CODIGO </th><th> CHECK LIST </th><th>CLASIFICACION </th> <th>TIPO </th>
						   <th> NOVEDADES </th><th> STATUS </th></tr>";

				while ($row01 = mysql_fetch_row($query01)){
				 echo "<tr><td>".$row01[0]."</td><td>".$row01[1]."</td><td>".$row01[2]."</td><td>".$row01[3]."</td>
						   <td>".$row01[4]."</td><td>".$row01[5]."</td></tr>";
				}
		}elseif($valores == "T"){

		$query01  = $bd->consultar($sql02);

				 echo "<tr><th> CODIGO </th><th> CHECK LIST </th><th>CLASIFICACION </th> <th>TIPO </th>
						   <th> NOVEDADES </th><th> STATUS </th><th> ABREVIATURA </th><th> VALORES </th>
						   <th> FACTOR </th><th> VALOR </th>
						   </tr>";

				while ($row01 = mysql_fetch_row($query01)){
				 echo "<tr><td>".$row01[0]."</td><td>".$row01[1]."</td><td>".$row01[2]."</td><td>".$row01[3]."</td>
						   <td>".$row01[4]."</td><td>".$row01[5]."</td><td>".$row01[6]."</td><td>".$row01[7]."</td>
						   <td>".$row01[8]."</td><td>".$row01[9]."</td></tr>";
				}
		}
	 echo "</table>";
	}
	*/
/*
	if($reporte == 'pdf'){

	require_once('../pdfClasses/class.ezpdf.php');
	$pdf =& new Cezpdf('A4', 'landscape');
	$pdf->selectFont('../pdfClasses/fonts/Courier.afm');
	$pdf->ezSetCmMargins(1,1,1.5,1.5);

		if ($valores == "F"){

		$query01  = $bd->consultar($sql);

		}elseif($valores == "T"){

		$query01  = $bd->consultar($sql02);

		}

		$totEmp = mysql_num_rows($query01);
    $ixx = 0;

    while($datatmp = mysql_fetch_assoc($query01)) {
        $ixx = $ixx+1;
        $data[] = array_merge($datatmp, array('num'=>$ixx));
    }

		if ($valores == "F"){
			$titles = array(
							'codigo'=>'<b>Codigo</b>',
							'check_list'=>'<b>Check List</b>',
							'clasif'=>'<b>Clasificacion</b>',
							'novedades'=>'<b>Novedades</b>',
							'status'=>'<b>Status</b>');
			$options = array(
							'shadeCol'=>array(0.9,0.9,0.9),
							'xOrientation'=>'center',
							'width'=>800);

		}elseif($valores == "T"){
			$titles = array(
							'codigo'=>'<b>Codigo</b>',
							'check_list'=>'<b>Check List</b>',
							'clasif'=>'<b>Clasificacion</b>',
							'novedades'=>'<b>Novedades</b>',
							'abrev'=>'<b>Abreviatura</b>',
							'valor'=>'<b>Valor</b>',
							'status'=>'<b>Status</b>');
			$options = array(
							'shadeCol'=>array(0.9,0.9,0.9),
							'xOrientation'=>'center',
							'width'=>800);
		}
    $txttit = "<b>$titulo</b>\n";

    $pdf->ezText($txttit, 12);
    $pdf->ezTable($data, $titles, '', $options);
    $pdf->ezText("\n\n\n", 10);
    $pdf->ezText("<b>Fecha:</b> ".date("d/m/Y"), 10);
    $pdf->ezText("<b>Hora:</b> ".date("H:i:s")."\n\n", 10);
    $pdf->ezStream();
	}
*/
}