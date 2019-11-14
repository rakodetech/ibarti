<?php
define("SPECIALCONSTANT",true);
require("../autentificacion/aut_config.inc.php");
include_once('../'.Funcion);
require_once("../".class_bdI);
require_once("../".Leng);
$bd = new DataBase();

$contrato        = $_POST['contrato'];
$rol             = $_POST['rol'];

$reporte         = $_POST['reporte'];
$archivo         = "rp_nom_cierra_asistencia_diaria_".$fecha."";
$titulo          = "  REPORTE CIERRRE DE ASISTENCIA DIARIA \n";

if(isset($reporte)){

	$where = "WHERE asistencia_cierre.`status` = 'T'
                AND asistencia_cierre.cod_as_apertura =  asistencia_apertura.codigo
                AND asistencia_cierre.cod_rol = roles.codigo
				AND roles.status = 'T'
                AND asistencia_cierre.cod_contracto = contractos.codigo ";

	if($contrato != "TODOS"){
		$where   .= " AND contractos.codigo = '$contrato' ";
	}
	if($rol != "TODOS"){
		$where  .= " AND roles.codigo = '$rol' ";
	}
	// QUERY A MOSTRAR //
		$sql = "SELECT Min(asistencia_apertura.fec_diaria) AS fec_diaria,
                       DATE_ADD(asistencia_apertura.fec_diaria, INTERVAL -1 DAY) AS fecha_cierre,
                       DATEDIFF(CURDATE(), (DATE_ADD(asistencia_apertura.fec_diaria, INTERVAL -1 DAY))) AS dias,
                       asistencia_cierre.cod_rol, roles.descripcion AS rol,
                       asistencia_cierre.cod_contracto, contractos.descripcion AS contrato
                  FROM asistencia_cierre, asistencia_apertura, roles, contractos
					   $where
              GROUP BY asistencia_cierre.cod_rol, roles.descripcion,
                       asistencia_cierre.cod_contracto, contractos.descripcion
          	  ORDER BY 1 ASC";

	if($reporte== 'excel'){
		echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition:  filename=\"rp_$archivo.xls\";");

		$query01  = $bd->consultar($sql);

		 echo "<table border=1>";
 	 echo "<tr><th>FECHA DE CIERRE </th><th> DIAS DE ATRASOS </th><th> COD. ROLES </th><th> ROLES </th>
	           <th> COD. CONTRATOS </th><th> CONTRATOS </th></tr>";

		while ($row01 = $bd->obtener_num($query01)){
		 echo "<tr><td > ".$row01[1]." </td><td>".$row01[2]."</td>
		 <td>".$row01[3]."</td><td>".$row01[4]."</td>
		 <td>".$row01[5]."</td><td>".$row01[6]."</td></tr>";

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
            <th width='15%'>Fecha</th>
            <th width='15%'>Fecha Cierre</th>
            <th width='20%' style='text-align:center;'>Dias de Atraso</th>
            <th width='20%'>".$leng['rol']."</th>
            <th width='30%'>".$leng['contrato']."</th>
            </tr>";

            $f=0;
    while ($row = $bd->obtener_num($query)){
    	 if ($f%2==0){
                echo "<tr>";
            }else{
                echo "<tr class='class= odd_row'>";
            }
    echo   "<td width='15%'>".conversion($row[0])."</td>
   		    <td width='15%'>".conversion($row[1])."</td>
            <td width='10%' style='text-align:center;'>".$row[2]."</td>
            <td width='20%'>".$row[4]."</td>
            <td width='40%'>".$row[6]."</td></tr>";

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
}