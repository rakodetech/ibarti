<?php
define("SPECIALCONSTANT",true);
session_start();
$Nmenu   = 5400;
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
$rango           = $_POST['rango'];
$rol             = $_POST['rol'];
$region          = $_POST['region'];
$estado          = $_POST['estado'];
$ciudad          = $_POST['ciudad'];
$contrato        = $_POST['contrato'];

$trabajador     = $_POST['trabajador'];
$reporte         = $_POST['reporte'];

$archivo         = "rp_nom_as_perfecta_".$_POST['fecha_desde']."";
$titulo          = " REPORTE ASISTENCIA PERFECTA FECHA: ".$fecha_D." HASTA: ".$fecha_H."\n";

if(isset($reporte)){

	$where = " WHERE asistencia_apertura.fec_diaria BETWEEN \"$fecha_D\" AND \"$fecha_H\"
				 AND asistencia_apertura.codigo = v_asistencia.cod_as_apertura
				 AND v_asistencia.cod_concepto = conceptos.codigo
				 AND conceptos.asist_perfecta = 'S'
				 AND v_asistencia.cod_ficha = ficha.cod_ficha
                 AND ficha.cod_ficha = trab_roles.cod_ficha
                 AND trab_roles.cod_rol = roles.codigo
                 AND ficha.cod_region = regiones.codigo
                 AND ficha.cod_contracto = contractos.codigo
                 AND ficha.cedula = preingreso.cedula
                 AND preingreso.cod_estado = estados.codigo
                 AND preingreso.cod_ciudad = ciudades.codigo ";

	if($rol != "TODOS"){
		$where  .= " AND roles.codigo   = '$rol' ";
	}
	if($region != "TODOS"){
		$where .= " AND regiones.codigo = '$region' ";
	}

	if($estado != "TODOS"){
		$where .= " AND estados.codigo  = '$estado' ";  // cambie AND asistencia.co_cont = '$contracto'
	}

	if($ciudad != "TODOS"){
		$where  .= " AND ciudades.codigo = '$ciudad' ";
	}

	if($contrato != "TODOS"){
		$where  .= " AND ficha.cod_contracto = '$contrato' ";
	}

	if($trabajador != NULL){
		$where  .= " AND v_asistencia.cod_ficha = '$trabajador' ";
	}

	// QUERY A MOSTRAR //
	$sql = "SELECT roles.descripcion AS rol, regiones.descripcion AS region,
                   estados.descripcion AS estado, ciudades.descripcion AS ciudad,
                   contractos.descripcion AS contrato, v_asistencia.cod_ficha,
                   ficha.cedula, CONCAT(preingreso.apellidos, ' ', preingreso.nombres) AS trabajador,
                   COUNT(v_asistencia.cod_concepto) AS cantidad
              FROM asistencia_apertura , v_asistencia ,ficha, trab_roles,
			       roles, regiones, contractos, preingreso, estados, ciudades, conceptos
                   $where
          GROUP BY roles.descripcion, regiones.descripcion,
                   estados.descripcion, ciudades.descripcion,
                   contractos.descripcion, v_asistencia.cod_ficha,
                   ficha.cedula
		    HAVING cantidad  >= '$rango'
          ORDER BY 1 ASC ";

	if($reporte== 'excel'){
		echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition:  filename=\"$archivo.xls\";");

		$query01  = $bd->consultar($sql);

		 echo "<table border=1>";

	 echo "<tr><th>".$leng['rol']."</th><th> ".$leng['region']." </th><th> ".$leng['estado']." </th> <th> ".$leng['ciudad']." </th>
               <th> ".$leng['contrato']." </th><th> ".$leng['ficha']." </th><th> ".$leng['ci']." </th> <th> Nombre </th>
			   <th> Cantidad </th></tr>";

		while ($row01 = $bd->obtener_num($query01)){
		 echo "<tr><td >".$row01[0]."</td><td>".$row01[1]."</td><td>".$row01[2]."</td><td>".$row01[3]."</td>
		 <td >".$row01[4]."</td><td>".$row01[5]."</td><td>".$row01[6]."</td><td>".$row01[7]."</td>
		 <td>".$row01[8]."</td></tr>";

		}
		 echo "</table>";

	}

	if($reporte == 'pdf'){

		$titulo          = " REPORTE ASISTENCIA PERFECTA <br> FECHA: ".$fecha_D." HASTA: ".$fecha_H."";
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
            <th width='15%'>".$leng['estado']."</th>
            <th width='15%'>".$leng['ficha']."</th>
            <th width='40%'>".$leng['trabajador']."</th>
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
            <td width='15%'>".$row[2]."</td>
            <td width='15%'>".$row[5]."</td>
            <td width='40%'>".$row[7]."</td>
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
		    $pdf=$dompdf->output();
		    $dompdf->stream($archivo, array('Attachment' => 0));
		}
	}
