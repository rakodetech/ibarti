<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php
require_once("../autentificacion/aut_config.inc.php");
include_once('../funciones/funciones.php');
mysql_select_db($bd_cnn,$cnn);

$id          = $_POST['id'];
$fecha_D     = conversion($_POST['fecha_desde']);
$fecha_H     = conversion($_POST['fecha_hasta']);

$trabajador  = $_POST['trabajador'];
$usuario     = $_POST['usuario'];
$usuario_id  = $_POST['usuario_id'];
$tipo_nom    = $_POST['tipo_nom'];
$perfil      = $_POST['perfil'];
$reporte     = $_POST['reporte'];
$region      = $_POST['region'];

$archivo     = "rp_as_nomina_".$_POST['fecha_desde']."";

$tabla = 'repAs'.$usuario_id;

if(isset($reporte)){

	$query02 = mysql_query("SELECT nomina.des_cont FROM nomina WHERE nomina.co_cont = '$tipo_nom'", $cnn)or die
					('<br><h3>Error Consulta # 2:</h3> '.mysql_error().'<br>');
	$row02=mysql_fetch_array($query02);
	$Nomina_Desc =  $row02[0];

	$where =" WHERE control_asistencia.cod_emp = control_asistencia.cod_emp ";

	if($trabajador != "TODOS"){
			$where .= " AND control_asistencia.cod_emp = '$trabajador' ";
	}

	if($usuario_id != "TODOS"){
			$where .= " AND control_asistencia.id_usuario = '$usuario_id' ";

	$query02 = mysql_query("SELECT CONCAT(usuarios.apellido,' ',usuarios.nombre)
	                          FROM oesvica_sistema.usuarios
                             WHERE usuarios.cedula = '$usuario_id'", $cnn)or die
					('<br><h3>Error Consulta # 2:</h3> '.mysql_error().'<br>');
	$row02=mysql_fetch_array($query02);
	$us_nomb =  ', USUARIO: ('.$row02[0].')';

	}

	$fecha_N = explode("-", $fecha_D);
	$year1   = $fecha_N[0];
	$mes1    = $fecha_N[1];
	$dia1    = $fecha_N[2];

	$fecha_Inc_M  = mktime(0,0,0,$mes1,$dia1,$year1);

		if ($dia1 <= 15){
			$fecha_H = $year1.'-'.$mes1.'-15';
			$fecha_D = $year1.'-'.$mes1.'-01';

	$sql01 ="SELECT control_asistencia.cod_emp AS Codigo, control_asistencia.ci AS Cedula,  control_asistencia.nombres AS Empleado,                    control_asistencia.d01, control_asistencia.d02, control_asistencia.d03, control_asistencia.d04,
                    control_asistencia.d05, control_asistencia.d06, control_asistencia.d07, control_asistencia.d08,
                    control_asistencia.d09, control_asistencia.d10, control_asistencia.d11, control_asistencia.d12,
                    control_asistencia.d13, control_asistencia.d14, control_asistencia.d15
               FROM control_asistencia ".$where." ORDER BY 3 ASC";

	$tr = "<tr><th> COD. EMPLEADO </th><th> CEDULA  </th><th> NOMBRES  </th>
	           <th> 01 </th><th> 02 </th><th> 03 </th><th> 04 </th><th> 05 </th><th> 06 </th><th> 07 </th><th> 08 </th>
			   <th> 09 </th><th> 10 </th><th> 11 </th><th> 12 </th><th> 13 </th><th> 14 </th><th> 15 </th></tr>";

		}else{

			 $fecha_x    = mktime(0,0,0, $mes1, 01,$year1);
			 $fec_desde  = strtotime("+1 months -1 day", $fecha_x);
			 $fecha_H    = date("Y-m-d", $fec_desde);
			 $fecha_D = $year1.'-'.$mes1.'-16';

 $sql01 = "SELECT control_asistencia.cod_emp AS Cod_Empleado, control_asistencia.ci AS Cedula, control_asistencia.nombres AS Nombres,
                  control_asistencia.d16, control_asistencia.d17, control_asistencia.d18, control_asistencia.d19,
                  control_asistencia.d20, control_asistencia.d21, control_asistencia.d22, control_asistencia.d23,
                  control_asistencia.d24, control_asistencia.d25, control_asistencia.d26, control_asistencia.d27,
                  control_asistencia.d28, control_asistencia.d29, control_asistencia.d30, control_asistencia.d31
             FROM control_asistencia ".$where." ORDER BY 3 ASC";

	$tr = "<tr><th> COD. EMPLEADO </th><th> CEDULA  </th><th> NOMBRES  </th>
	           <th> 16 </th><th> 17 </th><th> 18 </th><th> 19 </th><th> 20 </th><th> 21 </th><th> 22 </th><th> 23 </th>
			   <th> 24 </th><th> 25 </th><th> 26 </th><th> 27 </th><th> 28 </th><th> 29 </th><th> 30 </th><th> 31 </th></tr>";
		}
// CALL  `p_prueba01`('2012-11-16', '2012-11-30', 'tabla', '04');
//CALL p_prueba01("2010-03-01", "2010-03-02");
	//       mysql_query('CALL p_prueba01("'.$fecha_D.'", "'.$fecha_H.'", "'.$tabla.'", "'.$tipo_nom.'")', $cnn)or die
	  //                  ('<br><h3>Error Consulta # 3:</h3> '.mysql_error().'<br>');

	///    LA QUINCENA        ////
	if($reporte== 'excel'){

		mysql_select_db($bd_cnn,$cnn);
		header("Content-type: application/vnd.ms-excel");
		 header("Content-Disposition:  filename=\"$archivo.xls\";");

		$fondo01 = " bgcolor='#EBEBEB'";
		$fondo02 = " bgcolor='#E0E0E0'";
		  $query01 = mysql_query($sql01, $cnn);

		echo "<table border=1>".$tr;
		while ($row01 = mysql_fetch_row($query01)){

			if ($quincena == '01'){

		 echo "<tr><td>".$row01[0]."</td><td>".$row01[1]."</td><td>".$row01[2]."</td><td>".$row01[3]."</td><td>".$row01[4]."</td>
				   <td>".$row01[5]."</td><td>".$row01[6]."</td><td>".$row01[7]."</td><td>".$row01[8]."</td><td>".$row01[9]."</td>
				   <td>".$row01[10]."</td><td>".$row01[11]."</td><td>".$row01[12]."</td><td>".$row01[13]."</td><td>".$row01[14]."</td>
				   <td>".$row01[15]."</td><td>".$row01[16]."</td><td>".$row01[17]."</td></tr>";
			}else{
		 echo "<tr><td>".$row01[0]."</td><td>".$row01[1]."</td><td>".$row01[2]."</td><td>".$row01[3]."</td><td>".$row01[4]."</td>
				   <td>".$row01[5]."</td><td>".$row01[6]."</td><td>".$row01[7]."</td><td>".$row01[8]."</td><td>".$row01[9]."</td>
				   <td>".$row01[10]."</td><td>".$row01[11]."</td><td>".$row01[12]."</td><td>".$row01[13]."</td><td>".$row01[14]."</td>
				   <td>".$row01[15]."</td><td>".$row01[16]."</td><td>".$row01[17]."</td><td>".$row01[18]."</td></tr>";

			}
		}
		 echo "</table>";
	}

	if($reporte== 'pdf'){
	//echo "pdf";
	require('../fpdf/mysql_report.php');

		$pdf = new PDF('L','pt','legal');
		$pdf->SetFont('Arial','',10);
		$pdf->connect($conf_host,$conf_usuario,$conf_pass,$bd_cnn);
		$attr = array('titleFontSize'=>12, 'titleText'=>'REPORTES DE MOMINA FECHA: '.$fecha_D.' HASTA: '.$fecha_H.' NOMINA:('.$Nomina_Desc.') '.$us_nomb);

		$pdf->mysql_report($sql01, false,$attr);
		$pdf->Output();
	}
}
?>
