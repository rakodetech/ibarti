<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php
require_once("../autentificacion/aut_config.inc.php");
include_once('../funciones/funciones.php');
mysql_select_db($bd_cnn,$cnn);

$id           = $_POST['id'];

$fecha_D      = conversion($_POST['fecha_desde']);
$fecha_H      = conversion($_POST['fecha_hasta']);

$region       = $_POST['regiones'];
$contracto    = $_POST['contracto'];
$rango        = $_POST['rango'];

$reporte      = $_POST['reporte'];

$usuario     = $_POST['usuario'];
$usuario_id  = $_POST['usuario_id'];

$perfil      = $_POST['perfil'];

/*
SELECT tmp_asis_perfecta.id_region, regiones.descripcion AS Region,
tmp_asis_perfecta.co_cont, nomina.des_cont AS Contracto,
tmp_asis_perfecta.cod_emp, trabajadores.nombres AS Trabajador,
Count(tmp_asis_perfecta.co_var) AS N_asistencia

FROM tmp_asis_perfecta , regiones , nomina, trabajadores
WHERE tmp_asis_perfecta.id_region =  regiones.id
AND tmp_asis_perfecta.cod_emp =  trabajadores.cod_emp
AND tmp_asis_perfecta.co_cont =  nomina.co_cont
GROUP BY tmp_asis_perfecta.cod_emp, tmp_asis_perfecta.id_region,
tmp_asis_perfecta.co_cont, nomina.des_cont,
trabajadores.nombres, regiones.descripcion
HAVING Count(tmp_asis_perfecta.co_var) >=  '2'
*/

if(isset($reporte)){

	$where =" WHERE tmp_asis_perfecta.id_region =  regiones.id
                AND tmp_asis_perfecta.cod_emp =  trabajadores.cod_emp
                AND tmp_asis_perfecta.co_cont =  nomina.co_cont ";

	if($region != "TODOS"){
			$where .= " AND regiones.id = '$region' ";
		}

	if($contracto != "TODOS"){
			$where .= " AND nomina.co_cont = '$contracto' ";
		}

 mysql_query("CALL p_asis_perfecta('$fecha_D', '$fecha_H')", $cnn)or die
        		 ('<br><h3>Error Consulta # 1:</h3> '.mysql_error().'<br>');


$sql01 = "SELECT tmp_asis_perfecta.id_region, regiones.descripcion AS Region,
                 tmp_asis_perfecta.co_cont, nomina.des_cont AS Contracto,
                 tmp_asis_perfecta.cod_emp, trabajadores.nombres AS Trabajador,
                 Count(tmp_asis_perfecta.co_var) AS N_asistencia
            FROM tmp_asis_perfecta , regiones , nomina, trabajadores
            ".$where."
			GROUP BY tmp_asis_perfecta.cod_emp, tmp_asis_perfecta.id_region,
tmp_asis_perfecta.co_cont, nomina.des_cont,
trabajadores.nombres, regiones.descripcion
HAVING Count(tmp_asis_perfecta.co_var) >=  '$rango'
           ORDER BY 2, 4, 6 ASC ";

$titulo = "ASISTENCIA PERFECTA FECHA: ".Rconversion($fecha_D)." HASTA: ".Rconversion($fecha_H).", RANGO MAYOR O IGUAL: ".$rango."";
	if($reporte  == 'excel'){

		mysql_select_db($bd_cnn,$cnn);
		header("Content-type: application/vnd.ms-excel");
		 header("Content-Disposition:  filename=\"asis_perfecta.xls\";");

		$fondo01 = " bgcolor='#EBEBEB'";
		$fondo02 = " bgcolor='#E0E0E0'";
		  $query01 = mysql_query($sql01, $cnn);

		 echo "<table border=1>";
		 echo "<tr><th colspan='6'> ASISTENCIA PERFECTA FECHA: ".$fecha_D." HASTA: ".$fecha_H.", RANGO: ".$rango." <th></tr>";
		 echo "<tr><th> COD. REGION </th><th> REGION  </th><th> COD. CONTRACTO </th><th> CONTRACTO </th><th> COD. TRABAJADOR </th><th> TRABAJADOR </th><th>N. ASISTENCIA </tr>";

		while ($row01 = mysql_fetch_row($query01)){
		 echo "<tr><td ".$fondo01."> ".$row01[0]." </td><td".$fondo01.">".$row01[1]."</td><td".$fondo01.">".$row01[2]."</td><td".$fondo01.">".$row01[3]."</td><td".$fondo01.">".utf8_decode($row01[4])."</td><td".$fondo01.">".$row01[5]."</td><td".$fondo01.">".$row01[6]."</td></tr>";

		}
		 echo "</table>";
	}

	if($reporte== 'pdf'){
	require('../fpdf/mysql_report.php');

	$pdf = new PDF('L','pt','letter');
	$pdf->SetFont('Arial','',10);
	$pdf->connect($conf_host,$conf_usuario,$conf_pass,$bd_cnn);
	$attr = array('titleFontSize'=>12, 'titleText'=>$titulo);
	$pdf->mysql_report($sql01, false,$attr);
	$pdf->Output();
	}
}
?>
