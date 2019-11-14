<?php
define("SPECIALCONSTANT",true);
session_start();
$Nmenu   = 520;
require "../autentificacion/aut_config.inc.php";
include "../funciones/funciones.php";
require "../".class_bdI;
require "../".Leng;
$bd = new DataBase();

$fecha_D         = conversion($_POST['fecha_desde']);
$fecha_H         = conversion($_POST['fecha_hasta']);

$estado          = $_POST['estado'];
$ciudad          = $_POST['ciudad'];
$cargo           = $_POST['cargo'];
$status          = $_POST['status'];

$reporte         = $_POST['reporte'];
$trabajador      = $_POST['trabajador'];

$archivo         = "rp_fic_referencia_".$fecha."";
$titulo          = "  REPORTE REFERENCIA TRABAJADORES \n";

if(isset($reporte)){

	$where = " WHERE v_preingreso.fec_us_ing BETWEEN \"$fecha_D\" AND \"$fecha_H\"  ";

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
                       v_preingreso.cargo, v_preingreso.refp01_nombre,
                       v_preingreso.refp01_telf, v_preingreso.refp01_parentezco,
                       v_preingreso.refp01_observacion, Valores(v_preingreso.refp01_apto) AS refp01_apto,
					   v_preingreso.refp02_nombre, v_preingreso.refp02_telf,
					   v_preingreso.refp02_parentezco, v_preingreso.refp02_observacion,
					   Valores(v_preingreso.refp02_apto) AS refp02_apto, v_preingreso.refp03_nombre,
					   v_preingreso.refp03_telef, v_preingreso.refp03_parentezco,
					   v_preingreso.refp03_observacion, Valores(v_preingreso.refp03_apto) AS refp03_apto,
					   v_preingreso.refl01_empresa, v_preingreso.refl01_telf,
					   v_preingreso.refl01_contacto, v_preingreso.refl01_observacion,
				  	   Valores(v_preingreso.refl01_apto) AS refl01_apto, v_preingreso.refl02_empresa,
					   v_preingreso.refl02_telf, v_preingreso.refl02_contacto,
					   v_preingreso.refl02_observacion, Valores(v_preingreso.refl02_apto) AS refl02_apto,
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

 	 echo "<tr><th> Fecha de Sistema </th><th> ".$leng['estado']." </th><th> ".$leng['ciudad']." </th><th>".$leng['ci']."</th>
	           <th> ".$leng['trabajador']." </th><th> Cargo </th><th> REF. P 1. NOMBRE  </th> <th>REF. TELF. </th>
			   <th> Parentesco </th><th> Observación </th> <th> REF. PERS. 1 </th><th> REF. P 2. Nombre </th>
			   <th>REF. TELF. </th><th> Parentesco </th><th> Observación </th><th>  REF. PERS. 2 </th>
			   <th>REF. P 3. Nombre  </th><th>REF. TELF. </th><th> Parentesco </th><th> Observación </th>
			   <th>  REF. PERS. 3 </th><th> REF. LAB 1. ".$leng['cliente']."  </th><th> REF TELF. </th><th> Contacto </th>
			   <th> Observación </th><th> REF. LAB 1.  </th> <th> REF. LAB 2. ".$leng['cliente']."  </th><th> REF TELF. </th>
			   <th> Contacto </th><th> Observación </th><th> REF. LAB 2.</th><th> Status </th></tr>";

		while ($row01 = $bd->obtener_num($query01)){
		 echo "<tr><td>".$row01[0]."</td><td>".$row01[1]."</td><td>".$row01[2]."</td><td>".$row01[3]."</td>
		           <td>".$row01[4]."</td><td>".$row01[5]."</td><td>".$row01[6]."</td><td>".$row01[7]."</td>
				   <td>".$row01[8]."</td><td>".$row01[9]."</td><td>".$row01[10]."</td><td>".$row01[11]."</td>
				   <td>".$row01[12]."</td><td>".$row01[13]."</td><td>".$row01[14]."</td><td>".$row01[15]."</td>
				   <td>".$row01[16]."</td><td>".$row01[17]."</td><td>".$row01[18]."</td><td>".$row01[19]."</td>
				   <td>".$row01[20]."</td><td>".$row01[21]."</td><td>".$row01[22]."</td><td>".$row01[23]."</td>
				   <td>".$row01[24]."</td><td>".$row01[25]."</td><td>".$row01[26]."</td><td>".$row01[27]."</td>
				   <td>".$row01[28]."</td><td>".$row01[29]."</td><td>".$row01[30]."</td><td>".$row01[31]."</td></tr>";
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
        <table>
		<tbody>
            <tr style='background-color: #4CAF50;'>
            <th width='10%'>".$leng['estado']."</th>
            <th width='12%'>".$leng['ci']."</th>
            <th width='16%'>".$leng['trabajador']."</th>
            <th width='13%' style='text-align:center;'>Ref. Personal 1</th>
            <th width='13%' style='text-align:center;'>Ref. Personal 2</th>
            <th width='12%' style='text-align:center;'>Ref. Personal 3</th>
            <th width='12%' style='text-align:center;'>Ref. Laboral 1</th>
            <th width='12%' style='text-align:center;'>Ref. Laboral 2</th>
            </tr>";

            $f=0;
    while ($row = $bd->obtener_num($query)){
    	 if ($f%2==0){
                echo "<tr>";
            }else{
                echo "<tr class='class= odd_row'>";
            }
    echo   "<td width='10%'>".$row[1]."</td>
            <td width='10%'>".$row[3]."</td>
            <td width='30%'>".$row[4]."</td>
            <td width='10%' style='text-align:center;'>".$row[10]."</td>
            <td width='10%' style='text-align:center;'>".$row[15]."</td>
            <td width='10%' style='text-align:center;'>".$row[20]."</td>
            <td width='10%' style='text-align:center;'>".$row[25]."</td>
            <td width='10%' style='text-align:center;'>".$row[31]."</td></tr>";

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
