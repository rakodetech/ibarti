<?php
define("SPECIALCONSTANT",true);
session_start();
$Nmenu   = 529;
require("../autentificacion/aut_config.inc.php");
include_once('../funciones/funciones.php');
require_once("../".class_bdI);
require_once("../".Leng);
$bd = new DataBase();

$fecha_D         = conversion($_POST['fecha_desde']);
$fecha_H         = conversion($_POST['fecha_hasta']);
$estado          = $_POST['estado'];
$ciudad          = $_POST['ciudad'];
$cargo           = $_POST['cargo'];
$status          = $_POST['status'];

$reporte         = $_POST['reporte'];
$trabajador      = $_POST['trabajador'];
$archivo         = "rp_fic_ingreso_result_".$fecha."";
$titulo          = "  REPORTE INGRESO RESULTADO \n";

if(isset($reporte)){

	$where = " WHERE v_preingreso.fec_us_ing BETWEEN \"$fecha_D\" AND \"$fecha_H\" ";

	if($estado != "TODOS"){
		$where .= " AND v_preingreso.cod_estado = '$estado' ";  // cambie AND asistencia.co_cont = '$contracto'
	}

	if($ciudad != "TODOS"){
		$where  .= " AND v_preingreso.cod_ciudad = '$ciudad' ";
	}

	if($cargo != "TODOS"){
		$where  .= " AND v_preingreso.cod_cargo = '$cargo' ";
	}

	if($status != "TODOS"){
		$where .= " AND v_preingreso.cod_status = '$status' ";
	}
	if($trabajador != NULL){
		$where  .= " AND v_preingreso.cedula = '$trabajador' ";
	}
	// QUERY A MOSTRAR //
	    $sql = "SELECT v_preingreso.fec_us_ing AS fec_sistema,
		               v_preingreso.estado, v_preingreso.ciudad,
                       v_preingreso.cedula, v_preingreso.ap_nombre,
					   Valores(v_preingreso.psic_apto) AS psic_apto, v_preingreso.psic_observacion,
                       Valores(v_preingreso.pol_apto) AS pol_apto, v_preingreso.pol_observacion,
                       Valores(v_preingreso.refp01_apto) AS refp01_apto, v_preingreso.refp01_observacion,
					   Valores(v_preingreso.refp02_apto) AS refp02_apto, v_preingreso.refp02_observacion,
					   Valores(v_preingreso.refp03_apto) AS refp03_apto, v_preingreso.refp03_observacion,
					   Valores(v_preingreso.refl01_apto) AS refl01_apto, v_preingreso.refl01_observacion,
					   Valores(v_preingreso.refl02_apto) AS refl02_apto, v_preingreso.refl02_observacion,
					   v_preingreso.`status`
                  FROM v_preingreso
				$where
              ORDER BY 2 ASC ";

	if($reporte== 'excel'){
		echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition:  filename=\"rp_$archivo.xls\";");

		$query01  = $bd->consultar($sql);
		 echo "<table border=1>";

 	 echo "<tr><th> Fecha de Sistema </th><th> ".$leng['estado']." </th><th> ".$leng['ciudad']." </th><th> ".$leng['ci']." </th>
	           <th> ".$leng['trabajador']." </th> <th> EXAM. PSICOLOGICO </th><th> Observación PSIC. </th><th>  EXAM. POLICIAL</th>
			   <th> Observación POL.</th><th> REF. PERS. 1 </th><th> Observación </th><th>  REF. PERS. 2 </th>
			   <th> Observación </th><th>  REF. PERS. 3 </th><th> Observación </th><th> REF. LAB 1.  </th>
			   <th> Observación </th><th> REF. LAB 2.</th><th> Observación </th><th> Status </th></tr>";

		while ($row01 = $bd->obtener_num($query01)){
		 echo "<tr><td>".$row01[0]."</td><td>".$row01[1]."</td><td>".$row01[2]."</td><td>".$row01[3]."</td>
		           <td>".$row01[4]."</td><td>".$row01[5]."</td><td>".$row01[6]."</td><td>".$row01[7]."</td>
				   <td>".$row01[8]."</td><td>".$row01[9]."</td><td>".$row01[10]."</td><td>".$row01[11]."</td>
				   <td>".$row01[12]."</td><td>".$row01[13]."</td><td>".$row01[14]."</td><td>".$row01[15]."</td>
				   <td>".$row01[16]."</td><td>".$row01[17]."</td><td>".$row01[18]."</td><td>".$row01[19]."</td></tr>";
		}
		 echo "</table>";
	}

	elseif($reporte == 'pdf'){

	require_once('../'.ConfigDomPdf);

		$dompdf= new DOMPDF();

		$query  = $bd->consultar($sql);

		ob_start();

		require('../'.PlantillaDOM.'/header_ibarti_2.php');
		include('../'.pagDomPdf.'/paginacion_ibarti.php');

		echo "<br><div>
        <table style='padding:0 0 0.5cm 0;'>
		<tbody>
            <tr style='background-color: #4CAF50;'>
            <th width='9%'>".$leng['ci']."</th>
            <th width='22%'>".$leng['trabajador']."</th>
            <th width='9%'>Exam. Psic.</th>
            <th width='9%'>Exam. Pol.</th>
            <th width='9%'>Ref. Per. 1</th>
            <th width='9%'>Ref. Per. 2</th>
            <th width='9%'>Ref. Per. 3</th>
            <th width='9%'>Ref. Lab. 1</th>
            <th width='9%'>Ref. Lab. 2</th>
            <th width='6%'>Status</th>
            </tr>";

            $f=0;
    while ($row = $bd->obtener_num($query)){
    	 if ($f%2==0){
                echo "<tr>";
            }else{
                echo "<tr class='class= odd_row'>";
            }
    echo   "<td width='9%'>".$row[3]."</td>
            <td width='22%'>".$row[4]."</td>
            <td width='9%'>".$row[5]."</td>
            <td width='9%'>".$row[7]."</td>
            <td width='9%'>".$row[9]."</td>
            <td width='9%'>".$row[11]."</td>
            <td width='9%'>".$row[13]."</td>
            <td width='9%'>".$row[15]."</td>
            <td width='9%'>".$row[17]."</td>
            <td width='6%'>".$row[19]."</td></tr>";

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