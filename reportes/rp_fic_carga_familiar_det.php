<?php
define("SPECIALCONSTANT",true);
$Nmenu   = 521;
require "../autentificacion/aut_config.inc.php";
include_once '../'.Funcion;
require_once "../".class_bdI;
require "../".Leng;

$bd = new DataBase();

$region          = $_POST['region'];
$estado          = $_POST['estado'];
$rol             = $_POST['rol'];
$contrato        = $_POST['contrato'];

$parentesco      = $_POST['parentesco'];

$reporte         = $_POST['reporte'];
$trabajador      = $_POST['trabajador'];

$archivo         = "rp_fic_carga_familiar_det_".$fecha."";
$titulo          = " REPORTE CARGA FAMILIAR TRABAJADORES \n";

if(isset($reporte)){

		$where = " WHERE v_ficha.cod_ficha_status = control.ficha_activo
                     AND v_ficha.cod_ficha = ficha_familia.cod_ficha
 			         AND ficha_familia.cod_parentesco = parentescos.codigo ";

	if($region != "TODOS"){
		$where .= " AND v_ficha.cod_region = '$region' ";
	}

	if($estado != "TODOS"){
		$where .= " AND v_ficha.cod_estado = '$estado' ";  // cambie AND asistencia.co_cont = '$contracto'
	}

	if($rol != "TODOS"){
		$where .= " AND v_ficha.cod_rol = '$rol' ";
	}

	if($contrato != "TODOS"){
		$where  .= " AND v_ficha.cod_contracto = '$contrato' ";
	}

	if($parentesco != "TODOS"){
		$where .= " AND ficha_familia.cod_parentesco = '$parentesco' ";
	}

	if($trabajador != NULL){
		$where  .= " AND v_ficha.cod_ficha = '$trabajador' ";
	}
	// QUERY A MOSTRAR //
	   $sql = "SELECT  v_ficha.region, v_ficha.rol,
                        v_ficha.estado, v_ficha.ciudad,
                      	v_ficha.contracto, v_ficha.cod_ficha,
						v_ficha.cedula, v_ficha.ap_nombre,
					    ficha_familia.codigo, parentescos.descripcion AS parentescos,
                        ficha_familia.nombres AS familiar, ficha_familia.fec_nac,
						Edad(ficha_familia.fec_nac) AS edad, Sexo(ficha_familia.sexo) sexo
                   FROM v_ficha, ficha_familia, parentescos, control
					    $where
			   ORDER BY 2 ASC";


	if($reporte== 'excel'){
		echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition:  filename=\"rp_$archivo.xls\";");

		$query01  = $bd->consultar($sql);
		 echo "<table border=1>";

 		 echo "<tr><th> ".$leng['region']." </th> <th> ".$leng['rol']." </th><th> ".$leng['estado']." </th><th> ".$leng['ciudad']." </th>
	           <th> ".$leng['contrato']." </th><th> ".$leng['ficha']." </th><th> ".$leng['ci']." </th><th> ".$leng['trabajador']." </th>
			   <th> Código</th><th> Parentesco</th><th> Familiar </th><th> Fecha de Nacimiento </th>
			   <th> Edad </th><th> Sexo </th></tr>";

		while ($row01 = $bd->obtener_num($query01)){
		 echo "<tr><td>".$row01[0]."</td><td>".$row01[1]."</td><td>".$row01[2]."</td><td>".$row01[3]."</td>
		           <td>".$row01[4]."</td><td>'".$row01[5]."</td><td>".$row01[6]."</td><td>".$row01[7]."</td>
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
            <th width:'15%'>".$leng['region']."</th>
            <th width:'10%'>".$leng['ficha']."</th>
            <th width:'30%'>".$leng['trabajador']."</th>
            <th width:'20%'>Parentesco</th>
            <th width:'25%'>Familiar</th>
            </tr>";

            $f=0;
    		while ($row = $bd->obtener_num($query)){
    	 if ($f%2==0){
                echo "<tr>";
            }else{
                echo "<tr class='class= odd_row'>";
            }
   		 	echo   "<td width:'15%'>".$row[0]."</td>
            <td width:'10%'>".$row[5]."</td>
            <td width:'30%'>".$row[7]."</td>
            <td width:'20%'>".$row[9]."</td>
            <td width:'25%'>".$row[10]."</td></tr>";

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
