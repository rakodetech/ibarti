<?php
define("SPECIALCONSTANT",true);
session_start();
$Nmenu   = 527;
require("../autentificacion/aut_config.inc.php");
include_once('../funciones/funciones.php');
require_once("../".class_bdI);
require_once("../".Leng);
$bd = new DataBase();

$rol             = $_POST['rol'];
$region          = $_POST['region'];
$estado          = $_POST['estado'];
$cliente         = $_POST['cliente'];
$contrato        = $_POST['contrato'];

$trabajador      = $_POST['trabajador'];

$reporte         = $_POST['reporte'];

$archivo         = "rp_fic_trab_sin_dotacion_det_".$fecha."";
$titulo          = " REPORT TRABAJADORES SIN DOTACION \n";


if(isset($reporte)){

$where = " WHERE v_ficha.cod_ficha NOT IN  (SELECT v_prod_dot_max2.cod_ficha FROM v_prod_dot_max2)
AND v_ficha.cod_ficha_status = control.ficha_activo ";


if($rol != "TODOS"){
	$where .= " AND v_ficha.cod_rol = '$rol' ";
}

if($region != "TODOS"){
	$where .= " AND v_ficha.cod_region = '$region' ";
}
if($estado != "TODOS"){
	$where .= " AND v_ficha.cod_estado = '$estado' ";
}
if($contrato != "TODOS"){
	$where  .= " AND v_ficha.cod_contracto = '$contrato' ";
}
if($cliente != "TODOS"){
	$where .= " AND v_ficha.cod_cliente = '$cliente' ";
}

if($trabajador != NULL){
	$where  .= " AND v_ficha.cod_ficha = '$trabajador' ";
}

	// QUERY A MOSTRAR //
$sql = "SELECT  v_ficha.rol,v_ficha.region,v_ficha.estado,v_ficha.ciudad,
v_ficha.contracto,v_ficha.cedula,v_ficha.cod_ficha,v_ficha.ap_nombre,v_ficha.cliente,
v_ficha.ubicacion FROM v_ficha, control 
$where
ORDER BY 3 DESC  ";

	if($reporte== 'excel'){
		echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition:  filename=\"rp_$archivo.xls\";");

		$query01  = $bd->consultar($sql);
		 echo "<table border=1>";


 	 echo "<tr><th> ".$leng['rol']." </th><th> ".$leng['region']." </th> <th> ".$leng['estado']." </th>
	           <th> ".$leng['ciudad']." </th><th> ".$leng['contrato']." </th><th> ".$leng['ci']." </th><th> ".$leng['ficha']." </th>
			   <th> ".$leng['trabajador']." </th><th> ".$leng['cliente']." </th><th> ".$leng['ubicacion']." </th></tr>";

		while ($row01 = $bd->obtener_num($query01)){
		 echo "<tr><td>".$row01[0]."</td><td>".$row01[1]."</td><td>".$row01[2]."</td><td>".$row01[3]."</td>
		           <td>".$row01[4]."</td><td>".$row01[5]."</td><td>".$row01[6]."</td><td>'".$row01[7]."</td>
				   <td>".$row01[8]."</td><td>".$row01[9]."</td></tr>";
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
            <th width='13%'>".$leng['rol']."</th>
            <th width='13%'>".$leng['estado']."</th>
            <th width='13%'>".$leng['ficha']."</th>
            <th width='30%'>".$leng['trabajador']."</th>
            </tr>";

            $f=0;
    while ($row = $bd->obtener_num($query)){
    	 if ($f%2==0){
                echo "<tr>";
            }else{
                echo "<tr class='class= odd_row'>";
            }
    echo   "<td width='13%'>".$row[0]."</td>
            <td width='13%'>".$row[2]."</td>
            <td width='13%'>".$row[6]."</td>
            <td width='30%'>".$row[7]."</td></tr>";

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
