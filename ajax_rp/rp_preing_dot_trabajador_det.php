<?php
define("SPECIALCONSTANT",true);
session_start();
$Nmenu   = 580;
require("../autentificacion/aut_config.inc.php");
include_once('../'.Funcion);
require_once("../".class_bdI);
require_once("../".Leng);

$bd = new DataBase();

$fecha_D         = conversion($_POST['fecha_desde']);
$fecha_H         = conversion($_POST['fecha_hasta']);

$estado          = $_POST['estado'];
$ciudad          = $_POST['ciudad'];
$cargo          = $_POST['cargo'];
$status          = $_POST['status'];
$trabajador      = $_POST['trabajador'];

$reporte         = $_POST['reporte'];
$archivo         = "rp_preing_dot_trabajador_det_".$fecha."";
$titulo          = " REPORTE REFERENCIA PREINGRESO UNIFOFRME \n";


if(isset($reporte)){

	$where = "   WHERE v_preingreso.fec_us_mod BETWEEN \"$fecha_D\" AND \"$fecha_H\"  ";

	if($estado != "TODOS"){
		$where .= " AND v_preingreso.cod_estado = '$estado' ";
	}
	if($ciudad != "TODOS"){
		$where .= " AND v_preingreso.cod_ciudad = '$ciudad' ";
	}

if($cargo != "TODOS"){
		$where .= " AND v_preingreso.cod_cargo = '$cargo' ";
	}
	if($status != "TODOS"){
		$where .= " AND v_preingreso.cod_status = '$status' ";
	}

	if($trabajador != NULL){
		$where  .= " AND v_preingreso.cedula = '$trabajador' ";
	}

	// QUERY A MOSTRAR //
        $sql = "SELECT v_preingreso.fec_us_mod, v_preingreso.estado,
		               v_preingreso.ciudad,v_preingreso.cargo,  v_preingreso.cedula,
					   v_preingreso.ap_nombre AS trabajador, v_preingreso.pantalon,
                       v_preingreso.camisa, v_preingreso.zapato,
                       IFNULL(v_dot_sin_dotacion.fec_ingreso, 'SIN ASIGNAR') AS fec_ingreso,
					   IFNULL(v_dot_sin_dotacion.cod_ficha, 'SIN ASIGNAR') AS cod_ficha,
                       IFNULL(v_dot_sin_dotacion.fec_dotacion, 'SIN DOTACION') AS fec_dotacion,
					   IFNULL(v_dot_sin_dotacion.dotacion, 'SIN DOTACION') AS dotacion,
                       v_preingreso.`status`
                  FROM v_preingreso LEFT JOIN v_dot_sin_dotacion ON v_preingreso.cedula = v_dot_sin_dotacion.cedula
                $where
			  ORDER BY 1 DESC  ";
	if($reporte== 'excel'){
		echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition:  filename=\"rp_$archivo.xls\";");

		$query01  = $bd->consultar($sql);
	 echo "<table border=1>";
 	 echo "<tr><th> Fecha Ult. Modificación </th><th> ".$leng['estado']." </th><th> ".$leng['ciudad']." </th>
 	 		<th> Cargo</th><th> ".$leng['ci']." </th><th> ".$leng['trabajador']." </th> <th> Talla Pantalón </th><th> Talla Camisa</th><th> Número Zapato </th>
			   <th> Fecha Ingreso </th> <th> Cod. ".$leng['ficha']." </th> <th> Fecha Dotación </th> <th> Dotación </th>
			   <th> Status </th></tr>";

		while ($row01 = $bd->obtener_num($query01)){
		 echo "<tr><td>".$row01[0]."</td><td>".$row01[1]."</td><td>".$row01[2]."</td><td>".$row01[3]."</td>
		           <td>".$row01[4]."</td><td>".$row01[5]."</td><td>".$row01[6]."</td><td>".$row01[7]."</td>
				   <td>".$row01[8]."</td><td>".$row01[9]."</td><td>".$row01[10]."</td><td>".$row01[11]."</td>
				   <td>".$row01[12]."</td><td>".$row01[13]."</td></tr>";
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
            <th width='10%'>".$leng['estado']."</th>
            <th width='26%'>".$leng['trabajador']."</th>
            <th width='26%'>Cargo</th>
            <th width='15%'>Fec. Usuario Mod.</th>
            <th width='12%'>Fec. Ingreso</th>
            <th width='12%'>Cod. Ficha</th>
            <th width='15%'>Fec. Dotación</th>
            <th width='10%'>Status</th>
            </tr>";

            $f=0;
    while ($row = $bd->obtener_num($query)){
    	 if ($f%2==0){
                echo "<tr>";
            }else{
                echo "<tr class='class= odd_row'>";
            }
    echo   "<td width='10%'>".$row[1]."</td>
            <td width='26%'>".$row[5]."</td>
            <td width='26%'>".$row[3]."</td>
            <td width='15%'>".conversion($row[0])."</td>
            <td width='12%'>".$row[9]."</td>
            <td width='12%'>".$row[10]."</td>
            <td width='15%'>".$row[11]."</td>
            <td width='10%'>".$row[13]."</td></tr>";

             $f++;
         }

    echo "</tbody>
        </table>
</div>
</body>
</html>";

		    $dompdf->load_html(ob_get_clean(),'UTF-8');
		    $dompdf->set_paper('letter','landscape');
		    $dompdf->render();
		    $dompdf->stream($archivo, array('Attachment' => 0));  
	}
}
