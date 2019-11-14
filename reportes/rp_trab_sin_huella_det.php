<?php
define("SPECIALCONSTANT",true);
$Nmenu   = 5201;
require("../autentificacion/aut_config.inc.php");
include_once('../'.Funcion);
require_once("../".class_bdI);
require_once("../".Leng);
$bd = new DataBase();

$rol        = $_POST['rol'];
$contrato   = $_POST['contrato'];
$estado     = $_POST['estado'];
$ciudad     = $_POST['ciudad'];
$huellas    = $_POST['huellas'];
$trabajador = $_POST['trabajador'];

$reporte         = $_POST['reporte'];
$archivo         = "rp_trab_sin_huella_det_".$fecha."";
$titulo          = " REPORTE TRABAJADOR HUELLA \n";

if(isset($reporte)){
$where = " WHERE v_ficha.cod_ficha = v_ficha.cod_ficha ";

	if($rol != "TODOS"){
		$where .= " AND v_ficha.cod_rol  = '$rol' ";
	}

	if($contrato != "TODOS"){
		$where   .= " AND v_ficha.cod_contracto = '$contrato' ";
	}

	if($estado != "TODOS"){
		$where  .= " AND v_ficha.cod_estado = '$estado' ";
	}

	if($ciudad != "TODOS"){
		$where  .= " AND v_ficha.cod_ciudad = '$ciudad' ";
	}

	if($trabajador != NULL){
		$where   .= " AND  v_ficha.cod_ficha = '$trabajador' ";
	}

	// having
	if($huellas != "TODOS"){
		if($huellas == "SI"){
		$where .= "HAVING huella <> 'NO' ";
		}elseif($huellas == "NO"){
		$where .= "HAVING huella = 'NO' ";
		}
	}

	 $sql = "SELECT v_ficha.rol, v_ficha.estado,  v_ficha.ciudad,  v_ficha.contracto,
	                v_ficha.cod_ficha, v_ficha.cedula,  	v_ficha.ap_nombre,
					IFNULL(ficha_huella.huella, 'NO') AS huella
               FROM v_ficha LEFT JOIN ficha_huella ON v_ficha.cedula =  ficha_huella.cedula
             $where
  		   ORDER BY 1, 2 ASC ";
	if($reporte== 'excel'){
		echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition:  filename=\"rp_$archivo.xls\";");

		$query01  = $bd->consultar($sql);
		 echo "<table border=1>";

 	 echo "<tr><th> ".$leng['rol']." </th><th> ".$leng['estado']." </th><th> ".$leng['ciudad']." </th> <th>".$leng['contrato']."</th>
	           <th> ".$leng['ficha']." </th><th> ".$leng['ci']." </th> <th> ".$leng['trabajador']." </th><th>Huella</th></tr>";

	while ($row01 = $bd->obtener_num($query01)){

		 echo "<tr><td>".$row01[0]."</td><td>".$row01[1]."</td><td>".$row01[2]."</td><td>".$row01[3]."</td>
				   <td>".$row01[4]."</td><td>".$row01[5]."</td><td>".$row01[6]."</td><td>".$row01[7]."</td></tr>";

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
            <th width='10%'>".$leng['ci']."</th>
            <th width='30%'>".$leng['trabajador']."</th>
            <th width='35%'>Huella</th>
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
            <td width='10%'>".$row[5]."</td>
            <td width='30%'>".$row[6]."</td>
            <td width='35%'>".$row[7]."</td></tr>";

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
