<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php
$Nmenu   = 5201;
require("../autentificacion/aut_config.inc.php");
include_once('../funciones/funciones.php');
require_once("../".class_bd);
$bd = new DataBase();

$rol          = $_POST['rol'];
$contrato          = $_POST['contrato'];
$estado          = $_POST['estado'];
$ciudad          = $_POST['ciudad'];
$cargo           = $_POST['cargo'];
$cedula          = $_POST['cedula'];
$status          = $_POST['status'];
$trabajador      = $_POST['trabajador'];

$reporte         = $_POST['reporte'];
$archivo         = "rp_fic_cedula_det_".$fecha."";
$titulo          = " REPORTE TRABAJADOR CEDULA \n";

if(isset($reporte)){
	$where = "  WHERE  v_ficha.cod_ficha =  v_ficha.cod_ficha ";

if($contrato != "TODOS"){
		$where .= " AND v_ficha.cod_contracto = '$contrato' ";  // cambie AND asistencia.co_cont = '$contracto'
	}

	if($rol != "TODOS"){
		$where .= " AND v_ficha.cod_rol = '$rol' ";  // cambie AND asistencia.co_cont = '$contracto'
	}

	if($estado != "TODOS"){
		$where .= " AND v_ficha.cod_estado = '$estado' ";  // cambie AND asistencia.co_cont = '$contracto'
	}

	if($estado != "TODOS"){
		$where .= " AND v_ficha.cod_estado = '$estado' ";  // cambie AND asistencia.co_cont = '$contracto'
	}

	if($ciudad != "TODOS"){
		$where .= " AND  v_ficha.cod_ciudad = '$ciudad' ";  // cambie AND asistencia.co_cont = '$contracto'
	}

	if($cargo != "TODOS"){
		$where  .= " AND  v_ficha.cod_cargo = '$cargo' ";
	}

	if($status != "TODOS"){
		$where  .= " AND  v_ficha.cod_ficha_status = '$status' ";
	}

	if($trabajador != NULL){
		$where  .= " AND  v_ficha.cod_ficha = '$trabajador' ";
	}

	$sql = " SELECT  v_ficha.rol,    v_ficha.estado,
			         v_ficha.ciudad, v_ficha.cargo,
				     v_ficha.cedula, v_ficha.ap_nombre ,
					 v_ficha.status
               FROM  v_ficha
		      $where
			  ORDER BY 1 ASC   ";


	if($reporte== 'excel'){

		header("Content-type: application/vnd.ms-excel");
		 header("Content-Disposition:  filename=\"rp_$archivo.xls\";");

		$query01  = $bd->consultar($sql);
		 echo "<table border=1>";


 	 echo "<tr><th> ROL </th><th> ESTADO </th><th> CIUDAD </th> <th> CARGO </th>
	           <th> CEDULA </th> <th> TRABAJADOR </th><th> STATUS</th> <th>CARGA DE CEDULA</th> </tr>";

	while ($row01 = mysql_fetch_row($query01)){

	$ci   = $row01[4];
	$filename = "../imagenes/cedula/$ci.jpg";

		if($cedula == "TODOS"){
		$imprimir = "SI";
			if (file_exists($filename)) {
			$ced = "SI";
			}else {
			$ced = "NO";
			}
		}elseif($cedula == "S"){
			if (file_exists($filename)) {
			$imprimir = "SI";
			$ced = "SI";
			}else {
			$ced = "NO";
			$imprimir = "NO";
			}

		}elseif($cedula == "N"){
			if (file_exists($filename)) {
			$imprimir = "NO";
			$ced = "SI";
			}else{
			$imprimir = "SI";
			$ced = "NO";
			}
		}else{
			$imprimir = "NO";
		}

		if($imprimir == "SI"){
		 echo "<tr><td>".$row01[0]."</td><td>".$row01[1]."</td><td>".$row01[2]."</td><td>".$row01[3]."</td>
				   <td>".$row01[4]."</td><td>".$row01[5]."</td><td>".$row01[6]."</td><td>".$ced."</td></tr>";

		}}
		 echo "</table>";
	}
	if($reporte== 'pantalla'){

		$query01  = $bd->consultar($sql);
		 echo "<table border=1>";

 	 echo "<tr><th> ROL </th><th> ESTADO </th><th> CIUDAD </th> <th> CARGO </th>
	           <th> CEDULA </th> <th> TRABAJADOR </th><th> STATUS</th> <th>CARGA DE CEDULA</th> </tr>";

	while ($row01 = mysql_fetch_row($query01)){

	$ci     = $row01[4];
	$filename = "../imagenes/cedula/$ci.jpg";

		if($cedula == "TODOS"){
		$imprimir = "SI";
			if(file_exists($filename)) {
			$ced = "SI";
			}else {
			$ced = "NO";
			}
		}elseif($cedula == "S"){
			if (file_exists($filename)) {
			$imprimir = "SI";
			$ced = "SI";
			}else {
			$ced = "NO";
			$imprimir = "NO";
			}

		}elseif($cedula == "N"){
			if (file_exists($filename)) {
			$imprimir = "NO";
			$ced = "SI";
			}else{
			$imprimir = "SI";
			$ced = "NO";
			}
		}else{
			$imprimir = "NO";
		}

		if($imprimir == "SI"){
		 echo "<tr><td>".$row01[0]."</td><td>".$row01[1]."</td><td>".$row01[2]."</td><td>".$row01[3]."</td>
				   <td>".$row01[4]."</td><td>".$row01[5]."</td><td>".$row01[6]."</td><td>";

		if (file_exists($filename)){
			 echo "<a href='".$filename."'><img src='".$filename."' border='0' width='130' height='70'/></a>";
		}else{
			   echo '<img src="../imagenes/cedula.jpg" width="130px" height="70px" alt="SIN CEDULA"  />';
		}
		echo "</td></tr>";

		}}
		 echo "</table>";
	}

	if($reporte == 'pdf'){

	require_once('../pdfClasses/class.ezpdf.php');
	$pdf =& new Cezpdf('A4', 'landscape');
	$pdf->selectFont('../pdfClasses/fonts/Courier.afm');
	$pdf->ezSetCmMargins(1,1,1.5,1.5);


		$query01  = $bd->consultar($sql);
		$totEmp = mysql_num_rows($query01);
    $ixx = 0;

    while($datatmp = mysql_fetch_assoc($query01)) {
        $ixx = $ixx+1;
        $data[] = array_merge($datatmp, array('num'=>$ixx));
    }

$titles = array(

				'rol'=>'<b>Roles</b>',
				'estado'=>'<b>Estado</b>',
				'ciudad'=>'<b>Ciudad</b>',
				'cedula'=>'<b>Cedula</b>',
				'ap_nombre'=>'<b>Trabajador</b>');

    $options = array(
                    'shadeCol'=>array(0.9,0.9,0.9),
                    'xOrientation'=>'center',
                    'width'=>800 );

    $txttit = "<b>$titulo</b>\n";

    $pdf->ezText($txttit, 12);
    $pdf->ezTable($data, $titles, '', $options);
    $pdf->ezText("\n\n\n", 10);
    $pdf->ezText("<b>Fecha:</b> ".date("d/m/Y"), 10);
    $pdf->ezText("<b>Hora:</b> ".date("H:i:s")."\n\n", 10);
    $pdf->ezStream();    $txttit = "<b>BLOG.UNIJIMPE.NET</b>\n";
    $txttit.= "Ejemplo de PDF con PHP y MYSQL \n";
	}
}?>
