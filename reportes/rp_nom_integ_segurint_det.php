<?php
define("SPECIALCONSTANT",true);
session_start();
$Nmenu   = 549;
require("../autentificacion/aut_config.inc.php");
include_once('../'.Funcion);
require_once("../".class_bdI);
require_once("../".Leng);
$bd = new DataBase();

if(($_POST['fecha_desde'] == "" or $_POST['fecha_hasta'] == "")){
	exit;
}

$fecha_D   = conversion($_POST['fecha_desde']);
$fecha_H   = conversion($_POST['fecha_hasta']);

$categoria  = $_POST['categoria'];
$contrato   = $_POST['contrato'];
$rol        = $_POST['rol'];
$estado     = $_POST['estado'];
$ciudad     = $_POST['ciudad'];

$trabajador = $_POST['trabajador'];
$reporte     = $_POST['reporte'];
$archivo ="rp_integracion_txt_nomina_".$_POST['fecha_desde']."";
$titulo          = " REPORTE INTEGRACION TXT NOMINA FECHA: ".$fecha_D." HASTA: ".$fecha_H."\n";

if(isset($reporte)){

	$AND = " ";
		if(($categoria == '01')||($categoria == '02')){ // NOMINA 01 CESTATIKET = =2

	$where = "   WHERE asistencia_apertura.fec_diaria BETWEEN \"$fecha_D\" AND \"$fecha_H\"
                 AND asistencia_apertura.codigo = asistencia.cod_as_apertura
				 AND asistencia.cod_ficha = ficha.cod_ficha
                 AND asistencia.cod_ficha = trab_roles.cod_ficha
                 AND trab_roles.cod_rol = concepto_det.cod_rol
                 AND concepto_det.cod_categoria = '$categoria'
				 AND asistencia.cod_concepto = concepto_det.codigo
                 AND trab_roles.cod_rol = roles.codigo
                 AND ficha.cod_contracto = contractos.codigo
				 AND ficha.cod_estado = estados.codigo
                 AND ficha.cod_ciudad = ciudades.codigo ";

	}elseif($categoria == '03'){ // HORA EXTRAS

	$where = " WHERE v_as_hora_extra.fec_diaria BETWEEN \"$fecha_D\" AND \"$fecha_H\"
                 AND v_as_hora_extra.cod_ficha = ficha.cod_ficha
                 AND ficha.cod_ficha = trab_roles.cod_ficha
                 AND ficha.cod_contracto = contractos.codigo
                 AND trab_roles.cod_rol = roles.codigo
				 AND ficha.cod_estado = estados.codigo
                 AND ficha.cod_ciudad = ciudades.codigo ";

	}elseif($categoria == '04'){ // FERIADOS
	$where = " WHERE asistencia_apertura.fec_diaria BETWEEN \"$fecha_D\" AND \"$fecha_H\"
                 AND asistencia_apertura.codigo = asistencia.cod_as_apertura
				 AND asistencia.feriado = '1'
				 AND asistencia.cod_ficha = ficha.cod_ficha
                 AND asistencia.cod_ficha = trab_roles.cod_ficha
                 AND trab_roles.cod_rol = concepto_det.cod_rol
                 AND concepto_det.cod_categoria = '$categoria'
				 AND asistencia.cod_concepto = concepto_det.codigo
				 AND concepto_det.cod_concepto = conceptos.codigo
                 AND trab_roles.cod_rol = roles.codigo
                 AND ficha.cod_contracto = contractos.codigo
				 AND ficha.cod_estado = estados.codigo
                 AND ficha.cod_ciudad = ciudades.codigo ";

	}elseif($categoria == '05'){ // NO LABORAL

	$where = " WHERE asistencia_apertura.fec_diaria BETWEEN \"$fecha_D\" AND \"$fecha_H\"
                 AND asistencia_apertura.codigo = asistencia.cod_as_apertura
				 AND asistencia.cod_ficha = ficha.cod_ficha
				 AND  asistencia.no_laboral= '1'
                 AND asistencia.cod_ficha = trab_roles.cod_ficha
                 AND trab_roles.cod_rol = concepto_det.cod_rol
                 AND concepto_det.cod_categoria = '$categoria'
				 AND asistencia.cod_concepto = concepto_det.codigo
				 AND concepto_det.cod_concepto = conceptos.codigo
                 AND trab_roles.cod_rol = roles.codigo
                 AND ficha.cod_contracto = contractos.codigo
				 AND ficha.cod_estado = estados.codigo
                 AND ficha.cod_ciudad = ciudades.codigo ";

	}elseif($categoria == '06'){ // VAlE

	$where = "  WHERE asistencia_apertura.fec_diaria BETWEEN \"$fecha_D\" AND \"$fecha_H\"
                  AND asistencia_apertura.codigo = asistencia.cod_as_apertura
				  AND asistencia.cod_ficha = ficha.cod_ficha
                  AND asistencia.cod_ficha = trab_roles.cod_ficha
		          AND trab_roles.cod_rol = roles.codigo
                  AND ficha.cod_contracto = contractos.codigo
				  AND ficha.cod_estado = estados.codigo
                  AND ficha.cod_ciudad = ciudades.codigo ";
	}

	if($rol != "TODOS"){
		$AND  .= " AND trab_roles.cod_rol = '$rol' ";
	}

	if($estado != "TODOS"){
		$AND .= " AND ficha.cod_estado  = '$estado' ";  // cambie AND asistencia.co_cont = '$contracto'
	}

	if($ciudad != "TODOS"){
		$AND  .= " AND ficha.cod_ciudad = '$ciudad' ";
	}

	if($contrato != "TODOS"){
		$AND  .= " AND ficha.cod_contracto = '$contrato' ";
	}

	if($trabajador != NULL){
		$AND  .= " AND ficha.cod_ficha = '$trabajador' ";
	}

	if(($categoria == '01')||$categoria == '02') { // NOMINA CESTATICKE
	if($categoria == 01){
		$archivo .= "_nom";
		}else{
		$archivo .= "_cest";
		}
	 $sql = "SELECT roles.descripcion AS rol, contractos.descripcion AS contrato,
                    estados.descripcion AS estado, ciudades.descripcion AS ciudad,
                    ficha.cod_ficha,  SUBSTRING(ficha.cod_ficha,1, CHAR_LENGTH(ficha.cod_ficha)-3) AS cedula,                                             CONCAT('0000',SUBSTRING(ficha.cod_ficha, CHAR_LENGTH(ficha.cod_ficha)-1, 2)) AS n_contrato,
					CONCAT(ficha.apellidos, ' ',ficha.nombres) AS trabajador, concepto_det.cod_concepto,
					SUM(concepto_det.cantidad) AS cantidad
               FROM asistencia_apertura, asistencia, ficha, trab_roles,
			        concepto_det, roles, contractos,
					estados, ciudades
					$where
					$AND
           GROUP BY ficha.cod_ficha, concepto_det.cod_concepto
	       ORDER BY 5 ASC ";

		if($reporte == 'excel'){
			echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
			 header("Content-type: application/vnd.ms-excel");
			 header("Content-Disposition:  filename=\"$archivo.xls\";");

			$query01  = $bd->consultar($sql);

		 echo "<table border=1>";
		 echo "<tr><th> ".$leng['rol']."</th><th> ".$leng['contrato']." </th><th> ".$leng['estado']."</th><th> ".$leng['ciudad']."</th>
		           <th> ".$leng['ficha']." </th><th> ".$leng['ci']." </th><th> N. ".$leng['contrato']." </th><th> ".$leng['trabajador']." </th>
				   <th> Cod. ".$leng['concepto']." </th> <th> Cantidad </th></tr>";

			while ($row01 = $bd->obtener_num($query01)){
			 echo "<tr><td>".$row01[0]."</td><td>".$row01[1]."</td><td>".$row01[2]."</td><td>".$row01[3]."</td>
			 <td >".$row01[4]."</td><td>".$row01[5]."</td><td>".$row01[6]."</td><td>".$row01[7]."</td>
			 <td >".$row01[8]."</td><td >".$row01[9]."</td></tr>";
			}
			 echo "</table>";
		}

		if($reporte == 'pdf'){
		require_once('../'.ConfigDomPdf);
		$dompdf= new DOMPDF();

		$query  = $bd->consultar($sql);

		ob_start();

		require('../'.PlantillaDOM.'/header_ibarti_2.php');
		include('../'.pagDomPdf.'/paginacion_ibarti.php');

		echo "<br><div>
        <table>
		<tbody>
            <tr style='background-color: #4CAF50;'>
            <th width='15%'>".$leng['rol']."</th>
            <th width='10%'>".$leng['ficha']."</th>
            <th width='15%'>".$leng['ci']."</th>
            <th width='30%'>".$leng['trabajador']."</th>
            <th width='15%'>Codigo</th>
            <th width='15%'>Cantidad</th>
            </tr>";

            $f=0;
    while ($row = $bd->obtener_num($query)){
    	 if ($f%2==0){
                echo "<tr>";
            }else{
                echo "<tr class='class= odd_row'>";
            }
    echo   "<td width='15%'>".$row[0]."</td>
   		    <td width='10%'>".$row[4]."</td>
            <td width='15%'>".$row[5]."</td>
            <td width='30%'>".$row[7]."</td>
            <td width='15%'>".$row[8]."</td>
            <td width='15%'>".$row[9]."</td></tr>";

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
			}

		if($reporte == 'txt'){

		 $sql = " SELECT  ficha.cedula, DATE_FORMAT(asistencia_apertura.fec_cierre, '%d/%m/%Y') ,
                      concepto_det.cod_concepto, SUM(concepto_det.cantidad) AS cantidad
                   FROM asistencia_apertura, asistencia, ficha, trab_roles,
			            concepto_det
	              WHERE asistencia_apertura.fec_diaria BETWEEN \"$fecha_D\" AND \"$fecha_H\"
                    AND asistencia_apertura.codigo = asistencia.cod_as_apertura
				    AND asistencia.cod_ficha = ficha.cod_ficha
                    AND asistencia.cod_ficha = trab_roles.cod_ficha
                    AND trab_roles.cod_rol =  concepto_det.cod_rol
                    AND concepto_det.cod_categoria = '$categoria'
				    AND asistencia.cod_concepto = concepto_det.codigo
				   $AND
               GROUP BY ficha.cod_ficha, concepto_det.cod_concepto
	           ORDER BY 2 ASC ";

				$query01  = $bd->consultar($sql);
		Header("Content-Type: text/plain");
	//	Header("Content-Disposition: attachment; filename=../txt/asistencia.txt");
		Header("Content-Disposition: attachment; filename=".$archivo.".txt");
			while ($row01 = $bd->obtener_num($query01)){
			echo "".$row01[0].";".$row01[1].";".$row01[2].";".$row01[3].";\r\n";
			}
		}
	/*
	}elseif($categoria == '02'){ // CESTATICKET

	 $sql = "SELECT roles.descripcion AS rol,  contractos.descripcion AS contrato,
                    estados.descripcion AS estado, ciudades.descripcion AS ciudad,
                    ficha.cod_ficha, ficha.cedula,
					CONCAT(ficha.apellidos, ' ',ficha.nombres) AS trabajador, conceptos.codigo,
					conceptos.abrev, conceptos.descripcion AS concepto,
                    SUM(concepto_det.cantidad) AS cantidad
               FROM asistencia_apertura, asistencia, ficha, trab_roles,
			        concepto_det, conceptos, roles, contractos,
					estados, ciudades	, control
					$where
					$AND
           GROUP BY ficha.cod_ficha, conceptos.codigo
           ORDER BY 5 ASC";

		if($reporte == 'excel'){

			 header("Content-type: application/vnd.ms-excel");
			 header("Content-Disposition:  filename=\"$archivo.xls\";");

			$query01  = $bd->consultar($sql);

		 echo "<table border=1>";
		 echo "<tr><th> ROL</th><th> CONTRATO </th><th> ESTADO</th><th> CIUDAD</th>
		           <th> FICHA </th><th> CEDULA </th><th> TRABAJADOR </th><th> CODIGO CESTATICKET </th>
				   <th> ABREV. </th><th> DESCRIPCION </th><th> CANTIDAD </th></tr>";

			while ($row01 = mysql_fetch_row($query01)){
			 echo "<tr><td>".$row01[0]."</td><td>".$row01[1]."</td><td>".$row01[2]."</td><td>".$row01[3]."</td>
			 <td>".$row01[4]."</td><td>".$row01[5]."</td><td>".$row01[6]."</td><td>".$row01[7]."</td>
			 <td>".$row01[8]."</td><td>".$row01[9]."</td><td>".$row01[10]."</td></tr>";
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
					'cod_ficha'=>'<b>Ficha</b>',
					'cedula'=>'<b>Cedula</b>',
					'trabajador'=>'<b>Trabajador</b>',
					'codigo'=>'<b>Cestaticket</b>',
					'cantidad'=>'<b>Cantidad</b>');

		$options = array(
						'shadeCol'=>array(0.9,0.9,0.9),
						'xOrientation'=>'center',
						'width'=>800);

		$txttit = "<b>$titulo</b>\n";
		$pdf->ezText($txttit, 12);
		$pdf->ezTable($data, $titles, '', $options);
		$pdf->ezText("\n\n\n", 10);
		$pdf->ezText("<b>Fecha:</b> ".date("d/m/Y"), 10);
		$pdf->ezText("<b>Hora:</b> ".date("H:i:s")."\n\n", 10);
		$pdf->ezStream();
		}
		if($reporte == 'txt'){

		Header("Content-Type: text/plain");
	//	Header("Content-Disposition: attachment; filename=../txt/asistencia.txt");
		Header("Content-Disposition: attachment; filename=".$archivo.".txt");
				$query01  = $bd->consultar($sql);
			while ($row01 = mysql_fetch_row($query01)){
			echo "".$row01[7].";".$row01[4].";".$row01[10]."\r\n";
			}
		}
		*/
	}elseif($categoria == '03'){ // HORA EXTRAS

	$sql = "SELECT roles.descripcion AS rol, contractos.descripcion AS contractos ,
	               estados.descripcion AS estado, ciudades.descripcion AS ciudad,
	               ficha.cod_ficha,
			       ficha.cedula, CONCAT(ficha.apellidos, ' ',ficha.nombres) AS trabajador,
                   control.cod_hora_extras, Sum(v_as_hora_extra.hora_extra) AS cantidad_D,
                   control.cod_hora_extras_n, Sum(v_as_hora_extra.hora_extra_n) AS cantidad_N
			  FROM v_as_hora_extra, control, ficha, contractos,
			       trab_roles, roles, estados, ciudades
			$where
			$AND
          GROUP BY v_as_hora_extra.cod_ficha
		  ORDER BY 1 ASC ";

		if($reporte == 'excel'){
			echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
			 header("Content-type: application/vnd.ms-excel");
			 header("Content-Disposition:  filename=\"$archivo.xls\";");

			$query01  = $bd->consultar($sql);

		 echo "<table border=1>";
		 echo "<tr><th> ".$leng['rol']."</th><th> ".$leng['contrato']."</th><th> ".$leng['estado']."</th><th> ".$leng['ciudad']."</th>
		           <th> ".$leng['ficha']." </th> <th> ".$leng['ci']." </th><th> ".$leng['trabajador']." </th><th> HORA EXTRA DIURNA</th>
				   <th> VALOR </th> <th>HORA EXTRA NOTURNA </th><th> VALOR </th></tr>";

			while ($row01 = $bd->obtener_num($query01)){
			 echo "<tr><td>".$row01[0]."</td><td>".$row01[1]."</td><td>".$row01[2]."</td><td>".$row01[3]."</td>
			 <td >".$row01[4]."</td><td>".$row01[5]."</td><td>".$row01[6]."</td><td>".$row01[7]."</td>
			 <td >".$row01[8]."</td><td>".$row01[9]."</td><td>".$row01[10]."</td></tr>";
			}
			 echo "</table>";
		}

		if($reporte == 'pdf'){
		require_once('../'.ConfigDomPdf);
		$dompdf= new DOMPDF();

		$query  = $bd->consultar($sql);

		ob_start();

		require('../'.PlantillaDOM.'/header_ibarti_2.php');
		include('../'.pagDomPdf.'/paginacion_ibarti.php');

		echo "<br><div>
        <table>
		<tbody>
            <tr style='background-color: #4CAF50;'>
            <th width='12%'>".$leng['rol']."</th>
            <th width='10%'>".$leng['ficha']."</th>
            <th width='10%'>".$leng['ci']."</th>
            <th width='18%'>".$leng['trabajador']."</th>
            <th width='15%'>Hora Extra D.</th>
            <th width='10%'>Cantidad</th>
            <th width='15%'>Hora Extra N.</th>
            <th width='10%'>Cantidad</th>
            </tr>";

            $f=0;
    while ($row = $bd->obtener_num($query)){
    	 if ($f%2==0){
                echo "<tr>";
            }else{
                echo "<tr class='class= odd_row'>";
            }
    echo   "<td width='12%'>".$row[0]."</td>
   		    <td width='10%'>".$row[4]."</td>
            <td width='15%'>".$row[5]."</td>
            <td width='29%'>".$row[6]."</td>
            <td width='11%'>".$row[7]."</td>
            <td width='11%'>".$row[8]."</td>
            <td width='11%'>".$row[9]."</td>
            <td width='11%'>".$row[10]."</td></tr>";

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
		}


		if($reporte == 'txt'){
			$sql01 = "SELECT ficha.cod_ficha, control.cod_hora_extras, Sum(v_as_hora_extra.hora_extra) AS cantidad_D
			    FROM v_as_hora_extra, control, ficha, contractos,
			         trab_roles, roles,  estados, ciudades
			  $where
			  $AND
          GROUP BY v_as_hora_extra.cod_ficha
		  UNION ALL

			SELECT ficha.cod_ficha, control.cod_hora_extras_n, Sum(v_as_hora_extra.hora_extra_n) AS cantidad_N
			  FROM v_as_hora_extra, control, ficha, contractos,
			       trab_roles, roles,  estados,  ciudades
			$where
		    $AND
          GROUP BY v_as_hora_extra.cod_ficha
		  ORDER BY 1 ASC ";
		Header("Content-Type: text/plain");
	//	Header("Content-Disposition: attachment; filename=../txt/asistencia.txt");
		Header("Content-Disposition: attachment; filename=".$archivo.".txt");
				$query01  = $bd->consultar($sql01);
			while ($row01 = $bd->obtener_num($query01)){
			echo "".$row01[0].";".$row01[1].";".$row01[2]."\r\n";
			}
		}


	}elseif($categoria == '04'){ // FERIADOS
	 $sql = "SELECT roles.descripcion AS rol,  contractos.descripcion AS contracto,
                    estados.descripcion AS estado, ciudades.descripcion AS ciudad,
                     ficha.cod_ficha,
				    ficha.cedula, CONCAT(ficha.apellidos, ' ',ficha.nombres) AS trabajador,
					asistencia.cod_concepto, conceptos.codigo,
					conceptos.abrev, conceptos.descripcion AS concepto,
                    SUM(concepto_det.cantidad) AS cantidad
               FROM asistencia_apertura, asistencia, ficha, trab_roles,
			        concepto_det, conceptos, roles, contractos,
					estados, ciudades
					$where
					$AND
           GROUP BY ficha.cod_ficha,  conceptos.codigo
           ORDER BY 5 ASC";

		if($reporte == 'excel'){
			echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
			 header("Content-type: application/vnd.ms-excel");
			 header("Content-Disposition:  filename=\"$archivo.xls\";");

			$query01  = $bd->consultar($sql);

		 echo "<table border=1>";
		 echo "<tr><th> ".$leng['rol']."</th><th> ".$leng['contrato']." </th><th> ".$leng['estado']."</th><th> ".$leng['ciudad']."</th><th> ".$leng['ficha']." </th>
				   <th> ".$leng['cedula']." </th><th> ".$leng['trabajador']." </th><th> Cod. Asistencia</th><th> Cod. ".$leng['concepto']." </th>
				   <th> Abrev. </th> <th> ".$leng['concepto']." </th><th> Cantidad </th></tr>";

			while ($row01 = $bd->obtener_num($query01)){
			 echo "<tr><td>".$row01[0]."</td><td>".$row01[1]."</td><td>".$row01[2]."</td><td>".$row01[3]."</td>
			 <td >".$row01[4]."</td><td>".$row01[5]."</td><td>".$row01[6]."</td><td>".$row01[7]."</td>
			 <td >".$row01[8]."</td><td>".$row01[9]."</td><td>".$row01[10]."</td><td>".$row01[11]."</td></tr>";
			}
			 echo "</table>";
		}

		if($reporte == 'pdf'){
		require_once('../'.ConfigDomPdf);
		$dompdf= new DOMPDF();

		$query  = $bd->consultar($sql);

		ob_start();

		require('../'.PlantillaDOM.'/header_ibarti_2.php');
		include('../'.pagDomPdf.'/paginacion_ibarti.php');

		echo "<br><div>
        <table>
		<tbody>
            <tr style='background-color: #4CAF50;'>
            <th width='15%'>".$leng['rol']."</th>
            <th width='10%'>".$leng['ficha']."</th>
            <th width='15%'>".$leng['ci']."</th>
            <th width='30%'>".$leng['trabajador']."</th>
            <th width='15%'>Código</th>
            <th width='15%'>Cantidad</th>
            </tr>";

            $f=0;
    while ($row = $bd->obtener_num($query)){
    	 if ($f%2==0){
                echo "<tr>";
            }else{
                echo "<tr class='class= odd_row'>";
            }
    echo   "<td width='15%'>".$row[0]."</td>
   		    <td width='10%'>".$row[4]."</td>
            <td width='15%'>".$row[5]."</td>
            <td width='30%'>".$row[6]."</td>
            <td width='15%'>".$row[8]."</td>
            <td width='15%'>".$row[11]."</td></tr>";

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
		}
		if($reporte == 'txt'){
		Header("Content-Type: text/plain");
	//	Header("Content-Disposition: attachment; filename=../txt/asistencia.txt");
		Header("Content-Disposition: attachment; filename=".$archivo.".txt");
				$query01  = $bd->consultar($sql);
			while ($row01 = $bd->obtener_num($query01)){
			echo "".$row01[8].";".$row01[4].";".$row01[11]."\r\n";
			}
		}

	}elseif($categoria == '05'){ // NO LABORAL
	 $sql = "SELECT roles.descripcion AS rol,  contractos.descripcion AS contracto,
                    estados.descripcion AS estado, ciudades.descripcion AS ciudad,
                     ficha.cod_ficha,
				    ficha.cedula, CONCAT(ficha.apellidos, ' ',ficha.nombres) AS trabajador,
					asistencia.cod_concepto, conceptos.codigo,
					conceptos.abrev, conceptos.descripcion AS concepto,
                    SUM(concepto_det.cantidad) AS cantidad
               FROM asistencia_apertura, asistencia, ficha, trab_roles,
			        concepto_det, conceptos, roles, contractos,
					estados, ciudades
					$where
					$AND
           GROUP BY ficha.cod_ficha, conceptos.codigo
           ORDER BY 5 ASC";

		if($reporte == 'excel'){
			echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
			 header("Content-type: application/vnd.ms-excel");
			 header("Content-Disposition:  filename=\"$archivo.xls\";");

			$query01  = $bd->consultar($sql);

		 echo "<table border=1>";
		 echo "<tr><th> ".$leng['rol']."</th><th> ".$leng['contrato']." </th><th> ".$leng['estado']."</th><th> ".$leng['ciudad']."</th><th> ".$leng['ficha']." </th>
				   <th> ".$leng['ci']." </th><th> ".$leng['trabajador']." </th><th> Cod. Asistencia</th><th> Cod. ".$leng['concepto']." </th>
				   <th> Abrev. </th> <th> ".$leng['concepto']." </th><th> Cantidad </th></tr>";

			while ($row01 = $bd->obtener_num($query01)){
			 echo "<tr><td>".$row01[0]."</td><td>".$row01[1]."</td><td>".$row01[2]."</td><td>".$row01[3]."</td>
			 <td >".$row01[4]."</td><td>".$row01[5]."</td><td>".$row01[6]."</td><td>".$row01[7]."</td>
			 <td >".$row01[8]."</td><td>".$row01[9]."</td><td>".$row01[10]."</td><td>".$row01[11]."</td></tr>";
			}
			 echo "</table>";
		}

		if($reporte == 'pdf'){
		require_once('../'.ConfigDomPdf);
		$dompdf= new DOMPDF();

		$query  = $bd->consultar($sql);

		ob_start();

		require('../'.PlantillaDOM.'/header_ibarti_2.php');
		include('../'.pagDomPdf.'/paginacion_ibarti.php');

		echo "<br><div>
        <table>
		<tbody>
            <tr style='background-color: #4CAF50;'>
            <th width='15%'>".$leng['rol']."</th>
            <th width='10%'>".$leng['ficha']."</th>
            <th width='15%'>".$leng['ci']."</th>
            <th width='30%'>".$leng['trabajador']."</th>
            <th width='15%'>Codigo</th>
            <th width='15%'>Cantidad</th>
            </tr>";

            $f=0;
    while ($row = $bd->obtener_num($query)){
    	 if ($f%2==0){
                echo "<tr>";
            }else{
                echo "<tr class='class= odd_row'>";
            }
    echo   "<td width='15%'>".$row[0]."</td>
   		    <td width='10%'>".$row[4]."</td>
            <td width='15%'>".$row[5]."</td>
            <td width='30%'>".$row[7]."</td>
            <td width='15%'>".$row[8]."</td>
            <td width='15%'>".$row[11]."</td></tr>";

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
		}

		if($reporte == 'txt'){
		Header("Content-Type: text/plain");
	//	Header("Content-Disposition: attachment; filename=../txt/asistencia.txt");
		Header("Content-Disposition: attachment; filename=".$archivo.".txt");
				$query01  = $bd->consultar($sql);
			while ($row01 = $bd->obtener_num($query01)){
			echo "".$row01[8].";".$row01[4].";".$row01[11]."\r\n";
			}
		}

	}elseif($categoria == '06'){ // VALE

	 $sql = "SELECT roles.descripcion AS rol,   contractos.descripcion AS contrato,
                    estados.descripcion AS estado, ciudades.descripcion AS ciudad,
                    ficha.cod_ficha,
				    ficha.cedula, CONCAT(ficha.apellidos, ' ',ficha.nombres) AS trabajador,
                    control.vale_concepto AS cod_vale, SUM(asistencia.vale) AS cantidad
               FROM asistencia_apertura, asistencia, ficha, trab_roles,
			        roles, contractos,
					estados, ciudades	, control
             $where
			 $AND
           GROUP BY ficha.cod_ficha
		   HAVING cantidad > 0
           ORDER BY trabajador ASC";

		if($reporte == 'excel'){
			echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
			 header("Content-type: application/vnd.ms-excel");
			 header("Content-Disposition:  filename=\"$archivo.xls\";");

			$query01  = $bd->consultar($sql);

		 echo "<table border=1>";
		 echo "<tr><th> ".$leng['rol']."</th><th> ".$leng['contrato']." </th><th> ".$leng['estado']."</th><th> ".$leng['ciudad']."</th>
		           <th> ".$leng['ficha']." </th><th> ".$leng['ci']." </th><th> ".$leng['trabajador']." </th><th> Código VALE </th>
				   <th> Cantidad </th></tr>";

			while ($row01 = $bd->obtener_num($query01)){
			 echo "<tr><td>".$row01[0]."</td><td>".$row01[1]."</td><td>".$row01[2]."</td><td>".$row01[3]."</td>
			 <td>".$row01[4]."</td><td>".$row01[5]."</td><td>".$row01[6]."</td><td>".$row01[7]."</td>
			 <td>".$row01[8]."</td></tr>";
			}
			 echo "</table>";
		}

		if($reporte == 'pdf'){
		require_once('../'.ConfigDomPdf);
		$dompdf= new DOMPDF();

		$query  = $bd->consultar($sql);

		ob_start();

		require('../'.PlantillaDOM.'/header_ibarti_2.php');
		include('../'.pagDomPdf.'/paginacion_ibarti.php');

		echo "<br><div>
        <table>
		<tbody>
            <tr style='background-color: #4CAF50;'>
            <th width='15%'>".$leng['rol']."</th>
            <th width='10%'>".$leng['ficha']."</th>
            <th width='15%'>".$leng['ci']."</th>
            <th width='30%'>".$leng['trabajador']."</th>
            <th width='15%'>Código Vale</th>
            <th width='15%'>Cantidad</th>
            </tr>";

            $f=0;
    while ($row = $bd->obtener_num($query)){
    	 if ($f%2==0){
                echo "<tr>";
            }else{
                echo "<tr class='class= odd_row'>";
            }
    echo   "<td width='15%'>".$row[0]."</td>
   		    <td width='10%'>".$row[4]."</td>
            <td width='15%'>".$row[5]."</td>
            <td width='30%'>".$row[6]."</td>
            <td width='15%'>".$row[7]."</td>
            <td width='15%'>".$row[8]."</td></tr>";

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
		}
		if($reporte == 'txt'){

		Header("Content-Type: text/plain");
	//	Header("Content-Disposition: attachment; filename=../txt/asistencia.txt");
		Header("Content-Disposition: attachment; filename=".$archivo.".txt");
			$query01  = $bd->consultar($sql);
			while ($row01 = $bd->obtener_num($query01)){
			echo "".$row01[7].";".$row01[4].";".$row01[8]."\r\n";
			}
		}

	}
}
