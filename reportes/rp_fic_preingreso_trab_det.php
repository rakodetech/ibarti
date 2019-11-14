<?php
define("SPECIALCONSTANT",true);
session_start();
$Nmenu   = 520;
require "../autentificacion/aut_config.inc.php";
include "../funciones/funciones.php";
require "../".class_bdI;
require "../".Leng;
$bd = new DataBase();

$estado          = $_POST['estado'];
$ciudad          = $_POST['ciudad'];
$cargo           = $_POST['cargo'];
$nivel_academico = $_POST['nivel_academico'];
$status          = $_POST['status'];

$reporte         = $_POST['reporte'];
$trabajador      = $_POST['trabajador'];

$archivo         = "rp_preingreso_trab_".$fecha."";
$titulo          = "  REPORTE PREINGRESO DE TRABAJADORES \n";

if(isset($reporte)){

		$where = " WHERE v_preingreso.cedula = v_preingreso.cedula ";

	if($estado != "TODOS"){
		$where .= " AND v_preingreso.cod_estado = '$estado' ";  // cambie AND asistencia.co_cont = '$contracto'
	}

	if($ciudad != "TODOS"){
		$where  .= " AND v_preingreso.cod_ciudad = '$ciudad' ";
	}

	if($cargo != "TODOS"){
		$where  .= " AND v_preingreso.cod_cargo = '$cargo' ";
	}

	if($nivel_academico != "TODOS"){
		$where .= " AND v_preingreso.cod_nivel_academico = '$nivel_academico' ";
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
                       v_preingreso.cedula, v_preingreso.apellidos,
                       v_preingreso.nombres, v_preingreso.nacionalidad,
                       v_preingreso.estado_civil, v_preingreso.fec_nacimiento,
                       v_preingreso.lugar_nac, Sexo(v_preingreso.sexo) sexo,
                       v_preingreso.telefono, v_preingreso.celular,
                       v_preingreso.correo, v_preingreso.direccion,
                       v_preingreso.ocupacion, v_preingreso.cargo,
                       v_preingreso.nivel_academico, v_preingreso.pantalon,
                       v_preingreso.camisa, v_preingreso.zapato,
                       v_preingreso.fec_psic, v_preingreso.psic_observacion,
                       Valores(v_preingreso.psic_apto) AS psic_apto, v_preingreso.fec_pol,
                       v_preingreso.pol_observacion, Valores(v_preingreso.pol_apto) AS pol_apto,
                       v_preingreso.observacion, v_preingreso.`status`
                  FROM v_preingreso
					   $where
			  ORDER BY 2 ASC ";

	if($reporte== 'excel'){
		echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition:  filename=\"rp_$archivo.xls\";");

		$query01  = $bd->consultar($sql);
		 echo "<table border=1>";

 	 echo "<tr><th> FECHA DE SISTEMA </th><th>".$leng['estado']." </th><th>".$leng['ciudad']."</th><th>".$leng['ci']." </th>
	       <th> Apellido </th><th> Nombre </th><th>".$leng['nacionalidad']."</th> <th>".$leng['estado_civil']."</th>
			   <th> Fecha Nacimiento </th><th> Lugar Nacimiento </th> <th> Sexo </th><th> Teléfono </th>
			   <th> Celular </th><th>".$leng['correo']." </th><th> Dirección</th><th> Ocupación </th>
			   <th> Cargo </th><th> Nivel Académico</th><th> Talla Pantalón</th><th> Talla Camisa</th>
			   <th> Talla Zapato</th><th>".$leng['psic_fec']."</th><th>".$leng['psic_observ']."</th><th>".$leng['psic_desc']."</th>
			   <th> ".$leng['pol_fec']."</th><th> ".$leng['pol_observ']." </th><th>".$leng['pol_desc']." </th><th> Observación General </th>
			   <th> Status </th></tr>";

		while ($row01 = $bd->obtener_num($query01)){
		 echo "<tr><td>".$row01[0]."</td><td>".$row01[1]."</td><td>".$row01[2]."</td><td>".$row01[3]."</td>
		           <td>".$row01[4]."</td><td>".$row01[5]."</td><td>".$row01[6]."</td><td>".$row01[7]."</td>
				   <td>".$row01[8]."</td><td>".$row01[9]."</td><td>".$row01[10]."</td><td>".$row01[11]."</td>
				   <td>".$row01[12]."</td><td>".$row01[13]."</td><td>".$row01[14]."</td><td>".$row01[15]."</td>
				   <td>".$row01[16]."</td><td>".$row01[17]."</td><td>".$row01[18]."</td><td>".$row01[19]."</td>
				   <td>".$row01[20]."</td><td>".$row01[21]."</td><td>".$row01[22]."</td><td>".$row01[23]."</td>
				   <td>".$row01[24]."</td><td>".$row01[25]."</td><td>".$row01[26]."</td><td>".$row01[27]."</td>
				   <td>".$row01[28]."</td></tr>";
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
            <th width='12%'>".$leng['estado']."</th>
            <th width='20%'>Apellidos</th>
            <th width='20%'>Nombres</th>
            <th width='38%'>Nivel Academico</th>
            <th width='10%'>Status</th>
            </tr>";

            $f=0;
    while ($row = $bd->obtener_num($query)){
    	 if ($f%2==0){
                echo "<tr>";
            }else{
                echo "<tr class='class= odd_row'>";
            }
    echo   "<td width='12%'>".$row[1]."</td>
            <td width='20%'>".$row[4]."</td>
            <td width='20%'>".$row[5]."</td>
            <td width='38%'>".$row[17]."</td>
            <td width='10%'>".$row[28]."</td></tr>";

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
