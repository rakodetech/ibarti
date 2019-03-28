<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php
require_once("../autentificacion/aut_config.inc.php");
include_once('../funciones/funciones.php');

$id              = $_POST['id'];
$fecha_D         = conversion($_POST['fecha_desde']);
$fecha_H         = conversion($_POST['fecha_hasta']);

$region          = $_POST['region'];
$contracto       = $_POST['contracto'];

$usuario_id      = $_POST['usuario_id'];
$trabajador      = $_POST['trabajador'];
$usuario         = $_POST['usuario'];

$reporte         = $_POST['reporte'];

if(isset($reporte)){

		$where = " WHERE asistencia.fecha BETWEEN \"$fecha_D\" AND \"$fecha_H\"
		             AND asistencia.cod_emp = trabajadores.cod_emp
					 AND trabajadores.id_region  = regiones.id";

	if($region != "TODOS"){
		$where .= " AND trabajadores.id_region = '$region' ";
	}

	if($contracto != "TODOS"){
		$where .= " AND trabajadores.co_cont = '$contracto' ";  // cambie AND asistencia.co_cont = '$contracto'
	}

	if($usuario_id != "TODOS"){
		$where  .= " AND asistencia.id_usuario = '$usuario_id' ";
	}

	if($trabajador != NULL){
		$where  .= " AND trabajadores.cod_emp = '$trabajador' ";
	}

	 mysql_select_db($bd_cnn,$cnn);
	 mysql_query("TRUNCATE TABLE temp_asis_concep", $cnn)or die ('<br><h3>Error Consulta # 01:</h3> '.mysql_error().'<br>');

 	  $sql01 = "INSERT INTO temp_asis_concep (temp_asis_concep.cod_emp, temp_asis_concep.cod_cont, temp_asis_concep.id_region,
								temp_asis_concep.`X001`, temp_asis_concep.`X003`,
								temp_asis_concep.`X002`, temp_asis_concep.A006,
								temp_asis_concep.`X004`, temp_asis_concep.`X007`,
								temp_asis_concep.`X008`, temp_asis_concep.B001,
								temp_asis_concep.B002, temp_asis_concep.B103,
								temp_asis_concep.A019, temp_asis_concep.B104,
								temp_asis_concep.E001, temp_asis_concep.`X005`,
								temp_asis_concep.`X006`, temp_asis_concep.`A010`,
								temp_asis_concep.`X012`, temp_asis_concep.`X013` )

					SELECT DISTINCT asistencia.cod_emp, asistencia.co_cont, trabajadores.id_region,
						   (SELECT Count(a.co_var)  FROM asistencia AS a , trabajadores AS b
							WHERE a.fecha BETWEEN \"$fecha_D\" AND \"$fecha_H\"
							AND a.co_var = 'X001'
							AND a.cod_emp = asistencia.cod_emp
							AND a.co_cont = asistencia.co_cont
							AND a.id_usuario = asistencia.id_usuario
							AND a.cod_emp = b.cod_emp
							AND b.id_region = trabajadores.id_region
							) AS D,

							(SELECT Count(a.co_var) FROM asistencia AS a , trabajadores AS b
							WHERE a.fecha BETWEEN \"$fecha_D\" AND \"$fecha_H\"
							AND a.co_var = 'X003'
							AND a.cod_emp = asistencia.cod_emp
							AND a.co_cont = asistencia.co_cont
							AND a.cod_emp = b.cod_emp
							AND b.id_region = trabajadores.id_region
							AND a.id_usuario = asistencia.id_usuario
							) AS N,

							(SELECT Count(a.co_var) FROM asistencia AS a , trabajadores AS b
							WHERE a.fecha BETWEEN \"$fecha_D\" AND \"$fecha_H\"
							AND a.co_var = 'X002'
							AND a.cod_emp = asistencia.cod_emp
							AND a.co_cont = asistencia.co_cont
							AND a.cod_emp = b.cod_emp
							AND b.id_region = trabajadores.id_region
							AND a.id_usuario = asistencia.id_usuario
							) AS M,

							(SELECT Count(a.co_var) FROM asistencia AS a , trabajadores AS b
							WHERE a.fecha BETWEEN \"$fecha_D\" AND \"$fecha_H\"
							AND a.co_var = 'A006'
							AND a.cod_emp = asistencia.cod_emp
							AND a.co_cont = asistencia.co_cont
							AND a.cod_emp = b.cod_emp
							AND b.id_region = trabajadores.id_region
							AND a.id_usuario = asistencia.id_usuario
							) AS DLT,

							(SELECT Count(a.co_var) FROM asistencia AS a , trabajadores AS b
							WHERE a.fecha BETWEEN \"$fecha_D\" AND \"$fecha_H\"
							AND a.co_var = 'X004'
							AND a.cod_emp = asistencia.cod_emp
							AND a.co_cont = asistencia.co_cont
							AND a.cod_emp = b.cod_emp
							AND b.id_region = trabajadores.id_region
							AND a.id_usuario = asistencia.id_usuario
							) AS DL,

							(SELECT Count(a.co_var) FROM asistencia AS a , trabajadores AS b
							WHERE a.fecha BETWEEN \"$fecha_D\" AND \"$fecha_H\"
							AND a.co_var = 'X007'
							AND a.cod_emp = asistencia.cod_emp
							AND a.co_cont = asistencia.co_cont
							AND a.cod_emp = b.cod_emp
							AND b.id_region = trabajadores.id_region
							AND a.id_usuario = asistencia.id_usuario
							) AS FDT,

							(SELECT Count(a.co_var) FROM asistencia AS a , trabajadores AS b
							WHERE a.fecha BETWEEN \"$fecha_D\" AND \"$fecha_H\"
							AND a.co_var = 'X008'
							AND a.cod_emp = asistencia.cod_emp
							AND a.co_cont = asistencia.co_cont
							AND a.cod_emp = b.cod_emp
							AND b.id_region = trabajadores.id_region
							AND a.id_usuario = asistencia.id_usuario
							) AS FNT,

							(SELECT Count(a.co_var) FROM asistencia AS a , trabajadores AS b
							WHERE a.fecha BETWEEN \"$fecha_D\" AND \"$fecha_H\"
							AND a.co_var = 'B001'
							AND a.cod_emp = asistencia.cod_emp
							AND a.co_cont = asistencia.co_cont
							AND a.cod_emp = b.cod_emp
							AND b.id_region = trabajadores.id_region
							AND a.id_usuario = asistencia.id_usuario
							) AS 	HED,

							(SELECT Count(a.co_var) FROM asistencia AS a , trabajadores AS b
							WHERE a.fecha BETWEEN \"$fecha_D\" AND \"$fecha_H\"
							AND a.co_var = 'B002'
							AND a.cod_emp = asistencia.cod_emp
							AND a.co_cont = asistencia.co_cont
							AND a.cod_emp = b.cod_emp
							AND b.id_region = trabajadores.id_region
							AND a.id_usuario = asistencia.id_usuario
							) AS 	HEN,

							(SELECT Count(a.co_var) FROM asistencia AS a , trabajadores AS b
							WHERE a.fecha BETWEEN \"$fecha_D\" AND \"$fecha_H\"
							AND a.co_var = 'B103'
							AND a.cod_emp = asistencia.cod_emp
							AND a.co_cont = asistencia.co_cont
							AND a.cod_emp = b.cod_emp
							AND b.id_region = trabajadores.id_region
							AND a.id_usuario = asistencia.id_usuario
							) AS PR,

							(SELECT Count(a.co_var) FROM asistencia AS a , trabajadores AS b
							WHERE a.fecha BETWEEN \"$fecha_D\" AND \"$fecha_H\"
							AND a.co_var = 'A019'
							AND a.cod_emp = asistencia.cod_emp
							AND a.co_cont = asistencia.co_cont
							AND a.cod_emp = b.cod_emp
							AND b.id_region = trabajadores.id_region
							AND a.id_usuario = asistencia.id_usuario
							) AS RSS,

							(SELECT Count(a.co_var) FROM asistencia AS a , trabajadores AS b
							WHERE a.fecha BETWEEN \"$fecha_D\" AND \"$fecha_H\"
							AND a.co_var = 'B104'
							AND a.cod_emp = asistencia.cod_emp
							AND a.co_cont = asistencia.co_cont
							AND a.cod_emp = b.cod_emp
							AND b.id_region = trabajadores.id_region
							AND a.id_usuario = asistencia.id_usuario
							) AS PNR,

							(SELECT Count(a.co_var) FROM asistencia AS a , trabajadores AS b
							WHERE a.fecha BETWEEN \"$fecha_D\" AND \"$fecha_H\"
							AND a.co_var = 'E001'
							AND a.cod_emp = asistencia.cod_emp
							AND a.co_cont = asistencia.co_cont
							AND a.cod_emp = b.cod_emp
							AND b.id_region = trabajadores.id_region
							AND a.id_usuario = asistencia.id_usuario
							) AS FI,

							(SELECT Count(a.co_var) FROM asistencia AS a , trabajadores AS b
							WHERE a.fecha BETWEEN \"$fecha_D\" AND \"$fecha_H\"
							AND a.co_var = 'X005'
							AND a.cod_emp = asistencia.cod_emp
							AND a.co_cont = asistencia.co_cont
							AND a.cod_emp = b.cod_emp
							AND b.id_region = trabajadores.id_region
							AND a.id_usuario = asistencia.id_usuario
							) AS R,

							(SELECT Count(a.co_var) FROM asistencia AS a , trabajadores AS b
							WHERE a.fecha BETWEEN \"$fecha_D\" AND \"$fecha_H\"
							AND a.co_var = 'X006'
							AND a.cod_emp = asistencia.cod_emp
							AND a.co_cont = asistencia.co_cont
							AND a.cod_emp = b.cod_emp
							AND b.id_region = trabajadores.id_region
							AND a.id_usuario = asistencia.id_usuario
							) AS V,

							(SELECT Count(a.co_var) FROM asistencia AS a , trabajadores AS b
							WHERE a.fecha BETWEEN \"$fecha_D\" AND \"$fecha_H\"
							AND a.co_var = 'X010'
							AND a.cod_emp = asistencia.cod_emp
							AND a.co_cont = asistencia.co_cont
							AND a.cod_emp = b.cod_emp
							AND b.id_region = trabajadores.id_region
							AND a.id_usuario = asistencia.id_usuario
							) AS RD,

							(SELECT Count(a.co_var) FROM asistencia AS a , trabajadores AS b
							WHERE a.fecha BETWEEN \"$fecha_D\" AND \"$fecha_H\"
							AND a.co_var = 'X012'
							AND a.cod_emp = asistencia.cod_emp
							AND a.co_cont = asistencia.co_cont
							AND a.cod_emp = b.cod_emp
							AND b.id_region = trabajadores.id_region
							AND a.id_usuario = asistencia.id_usuario
							) AS NLT,

							(SELECT Count(a.co_var) FROM asistencia AS a , trabajadores AS b
							WHERE a.fecha BETWEEN \"$fecha_D\" AND \"$fecha_H\"
							AND a.co_var = 'X013'
							AND a.cod_emp = asistencia.cod_emp
							AND a.co_cont = asistencia.co_cont
							AND a.cod_emp = b.cod_emp
							AND b.id_region = trabajadores.id_region
							AND a.id_usuario = asistencia.id_usuario
							) AS MLT

            FROM asistencia , trabajadores, regiones ".$where."
 				   ORDER BY 2 ASC";

// Ejecuta La Condicion //
	 mysql_query("$sql01", $cnn)or die ('<br><h3>Error Consulta # 01:</h3> '.mysql_error().'<br>');

// QUERY A MOSTRAR //

$sql01 = "SELECT regiones.descripcion AS Region, nomina.des_cont AS Contracto,
                 temp_asis_concep.cod_emp AS Ficha, trabajadores.ci AS Cedula,
			     trabajadores.nombres AS Trabajador,
			     temp_asis_concep.`X001` AS D, temp_asis_concep.`X003` AS N,
			     temp_asis_concep.`X002` AS M, temp_asis_concep.A006 AS DLT,
				 temp_asis_concep.`X013` AS MLT, temp_asis_concep.`X012` AS NLT,
			     temp_asis_concep.`X004` AS DL , temp_asis_concep.`X007` AS FDT,
			     temp_asis_concep.`X008` AS FNT, temp_asis_concep.`A010` AS RD,
				 temp_asis_concep.B001 AS HED ,
			     temp_asis_concep.B002 AS HEN, temp_asis_concep.B103 AS PR,
			     temp_asis_concep.A019 AS RSS, temp_asis_concep.B104 AS PNR,
			     temp_asis_concep.E001 AS FI, temp_asis_concep.`X005` AS R,
			     temp_asis_concep.`X006` AS V,
				(temp_asis_concep.`X001` + temp_asis_concep.`X003` + temp_asis_concep.`X002` + temp_asis_concep.A006 + temp_asis_concep.`X007` + temp_asis_concep.`X008`) AS CT
		   FROM temp_asis_concep , nomina , regiones , trabajadores
		  WHERE temp_asis_concep.cod_emp = trabajadores.cod_emp
		    AND temp_asis_concep.cod_cont = nomina.co_cont
		    AND temp_asis_concep.id_region = regiones.id
		  ORDER BY 1, 2, 5 ASC" or die ('<br><h3>Error Consulta # 02:</h3> '.mysql_error().'<br>');

if($reporte == 'excel'){

	header("Content-type: application/vnd.ms-excel");
	 header("Content-Disposition:  filename=\"ASISTENCIA_CONCEPTOS.xls\";");

	$fondo01 = " bgcolor='#EBEBEB'";
	$fondo02 = " bgcolor='#E0E0E0'";
	  $query01 = mysql_query($sql01, $cnn);

	 echo "<table border=1>";
	 echo "<tr><th> REGION </th><th> CONTRACTO </th><th> FICHA </th><th> CEDULA </th><th> TRABAJADORES  </th>
	           <th> D </th><th> N </th><th> M </th><th> DLT </th>
			   <th> MLT </th><th> NLT </th><th> DL </th><th> FDT </th>
			   <th> FNT </th> <th> RD </th><th> HED </th> <th> HEN </th>
			   <th> PR </th><th> RRS </th><th> PNR </th><th> FI </th>
			   <th> R </th> <th> V </th> <th> Cestaticket </th></tr>";

	while ($row01 = mysql_fetch_row($query01)){
	 echo "<tr><td ".$fondo01.">".utf8_decode($row01[0])." </td><td ".$fondo01.">".utf8_decode($row01[1])." </td><td".$fondo01.">".utf8_decode($row01[2])."</td><td".$fondo01.">".utf8_decode($row01[3])."</td><td".$fondo01.">".utf8_decode($row01[4])."</td><td".$fondo01.">".utf8_decode($row01[5])."</td><td".$fondo01.">".utf8_decode($row01[6])."</td><td".$fondo01.">".utf8_decode($row01[7])."</td><td".$fondo01.">".utf8_decode($row01[8])."</td><td".$fondo01.">".utf8_decode($row01[9])."</td><td".$fondo01.">".utf8_decode($row01[10])."</td><td".$fondo01.">".utf8_decode($row01[11])."</td><td".$fondo01.">".utf8_decode($row01[12])."</td><td".$fondo01.">".utf8_decode($row01[13])."</td><td".$fondo01.">".utf8_decode($row01[14])."</td><td".$fondo01.">".utf8_decode($row01[15])."</td><td".$fondo01.">".utf8_decode($row01[16])."</td><td".$fondo01.">".utf8_decode($row01[17])."</td><td".$fondo01.">".utf8_decode($row01[18])."</td><td".$fondo01.">".utf8_decode($row01[19])."</td><td".$fondo01.">".utf8_decode($row01[20])."</td><td".$fondo01.">".utf8_decode($row01[21])."</td><td".$fondo01.">".utf8_decode($row01[22])."</td><td".$fondo01.">".utf8_decode($row01[23])."</td></tr>";

	}
	 echo "</table>";
}

	if($reporte== 'pdf'){
	//echo "pdf";
	require('../fpdf/mysql_report.php');

		$pdf = new PDF('L','pt','letter');
		$pdf->SetFont('Arial','',10);
		$pdf->connect($conf_host,$conf_usuario,$conf_pass,$bd_cnn);
		$attr = array('titleFontSize'=>12, 'titleText'=>'REPORTES DE ASISTENCIA CONCEPTOS FECHA: '.$fecha_D.' HASTA: '.$fecha_H.'');
		$pdf->mysql_report($sql01, false,$attr);
		$pdf->Output();
	}
}
?>
