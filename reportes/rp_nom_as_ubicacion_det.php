<?php
define("SPECIALCONSTANT",true);
session_start();
$Nmenu   = 543;
require("../autentificacion/aut_config.inc.php");
include_once('../'.Funcion);
require_once("../".class_bdI);
require_once("../".Leng);
$bd = new DataBase();

if(($_POST['fecha_desde'] == "" or $_POST['fecha_hasta'] == "")){

exit;
}

$fecha_D         = conversion($_POST['fecha_desde']);
$fecha_H         = conversion($_POST['fecha_hasta']);
$region          = $_POST['region'];
$estado          = $_POST['estado'];
$ciudad          = $_POST['ciudad'];
$cliente         = $_POST['cliente'];

$reporte         = $_POST['reporte'];

$archivo         = "rp_nom_as_ubicacion_".$_POST['fecha_desde']."";
$titulo          = " REPORTE RESUMEN DE ASISTENCIA POR UBICACION FECHA: ".$fecha_D." HASTA: ".$fecha_H."\n";

if(isset($reporte)){

		$where = " WHERE asistencia_apertura.fec_diaria BETWEEN \"$fecha_D\" AND \"$fecha_H\"
                     AND asistencia_apertura.codigo = v_asistencia.cod_as_apertura
                     AND v_asistencia.cod_ubicacion =  v_cliente_ubic.cod_ubicacion
                     AND v_asistencia.cod_cliente = v_cliente_ubic.cod_cliente";

	if($region != "TODOS"){
		$where .= " AND v_cliente_ubic.cod_region = '$region' ";
	}

	if($estado != "TODOS"){
		$where .= " AND v_cliente_ubic.cod_estado = '$estado' ";  // cambie AND asistencia.co_cont = '$contracto'
	}

	if($ciudad != "TODOS"){
		$where  .= " AND v_cliente_ubic.cod_ciudad = '$ciudad' ";
	}

	if($cliente != "TODOS"){
		$where  .= " AND v_cliente_ubic.cod_cliente = '$cliente' ";
	}
	// QUERY A MOSTRAR //
    	$sql = "SELECT asistencia_apertura.fec_diaria, v_cliente_ubic.region,
                       v_cliente_ubic.estado, v_cliente_ubic.ciudad,
                       v_cliente_ubic.cliente, v_cliente_ubic.ubicacion,
                       Sum(v_asistencia.valor) AS valor
                  FROM asistencia_apertura, v_asistencia , v_cliente_ubic
                $where
              GROUP BY asistencia_apertura.fec_diaria, v_cliente_ubic.region,
                       v_cliente_ubic.estado, v_cliente_ubic.ciudad,
                       v_cliente_ubic.cliente, v_cliente_ubic.ubicacion
                 UNION
                SELECT CURDATE(), '',
                       '', '',
                       '', 'TOTAL:',
                       Sum(v_asistencia.valor) AS valor
                  FROM asistencia_apertura, v_asistencia , v_cliente_ubic
                $where
              ORDER BY 1 ASC";

	if($reporte== 'excel'){
    echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
 		 header("Content-type: application/vnd.ms-excel");
		 header("Content-Disposition:  filename=\"$archivo.xls\";");

		$query01  = $bd->consultar($sql);

		 echo "<table border=1>";

	 echo "<tr><th>Fecha Diaria </th><th> ".$leng['region']." </th><th> ".$leng['estado']." </th><th> ".$leng['ciudad']." </th>
	           <th> ".$leng['cliente']." </th><th> ".$leng['ubicacion']." </th> <th> Valor </th></tr>";

		while ($row01 = $bd->obtener_num($query01)){
		 echo "<tr><td>".$row01[0]."</td><td>".$row01[1]."</td><td>".$row01[2]."</td><td>".$row01[3]."</td>
		           <td>".$row01[4]."</td><td>".$row01[5]."</td><td>".$row01[6]."</td></tr>";
		}
		 echo "</table>";
	}

	if($reporte == 'pdf'){
		$titulo          = " REPORTE RESUMEN <br> DE ASISTENCIA POR UBICACION <br> FECHA: ".$fecha_D." HASTA: ".$fecha_H."";

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
            <th width='15%'>Fecha</th>
            <th width='12%'>".$leng['region']."</th>
            <th width='15%'>".$leng['estado']."</th>
            <th width='23%'>".$leng['cliente']."</th>
            <th width='30%'>".$leng['ubicacion']."</th>
            <th width='10%'>Cantidad</th>
            </tr>";

            $f=0;
    while ($row = $bd->obtener_num($query)){
    	 if ($f%2==0){
                echo "<tr>";
            }else{
                echo "<tr class='class= odd_row'>";
            }
    echo   "<td width='15%'>".conversion($row[0])."</td>
            <td width='12%'>".$row[1]."</td>
            <td width='15%'>".$row[2]."</td>
            <td width='23%'>".$row[4]."</td>
            <td width='30%'>".$row[5]."</td>
            <td width='10%'>".$row[6]."</td></tr>";

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