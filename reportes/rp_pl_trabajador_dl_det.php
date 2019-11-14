<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php
session_start();
$Nmenu   = 535;
require("../autentificacion/aut_config.inc.php");
include_once('../funciones/funciones.php');
require_once('../autentificacion/aut_verifica_menu_02.php');
require_once("../".class_bd);
$bd = new DataBase();

$rol             = $_POST['rol'];
$region          = $_POST['region'];
$estado          = $_POST['estado'];
$ciudad          = $_POST['ciudad'];
$cargo           = $_POST['cargo'];
$contrato        = $_POST['contrato'];
$cliente         = $_POST['cliente'];
$ubicacion       = $_POST['ubicacion'];


$reporte         = $_POST['reporte'];

$archivo         = "rp_pl_trabajador_dl_".$fecha."";
$titulo          = "  REPORTE PLANIFICACION TRABAJADOR DL \n";

if(isset($reporte)){

	$where = " WHERE cod_ficha_status = control.ficha_activo
                 AND ficha_dl.cod_ficha = v_ficha.cod_ficha
                 AND ficha_dl.cod_turno_dia = turno_dias.dia
                 AND ficha_dl.cod_cliente = clientes.codigo
                 AND ficha_dl.cod_ubicacion = clientes_ubicacion.codigo ";

	if($rol != "TODOS"){
		$where .= " AND v_ficha.cod_rol = '$rol' ";
	}

	if($region != "TODOS"){
		$where .= " AND v_ficha.cod_region = '$region' ";
	}

	if($estado != "TODOS"){
		$where .= " AND v_ficha.cod_estado = '$estado' ";  // cambie AND asistencia.co_cont = '$contracto'
	}

	if($ciudad != "TODOS"){
		$where  .= " AND v_ficha.cod_ciudad = '$ciudad' ";
	}

	if($cargo != "TODOS"){
		$where  .= " AND v_ficha.cod_cargo = '$cargo' ";
	}

	if($contrato != "TODOS"){
		$where  .= " AND v_ficha.cod_contracto = '$contrato' ";
	}

	if($cliente != "TODOS"){
		$where  .= " AND ficha_dl.cod_cliente = '$cliente' ";
	}

	if($ubicacion != "TODOS"){
		$where  .= " AND ficha_dl.cod_ubicacion = '$ubicacion' ";
	}

	// QUERY A MOSTRAR //
	    $sql = "SELECT v_ficha.rol, v_ficha.region,
                       v_ficha.estado, v_ficha.ciudad,
                       v_ficha.cod_ficha, v_ficha.cedula,
                       v_ficha.nombres,  v_ficha.cargo,
                       v_ficha.contracto, turno_dias.descripcion AS dl,
					   clientes.nombre AS cliente, clientes_ubicacion.descripcion AS ubicacion
                  FROM v_ficha, control, ficha_dl, turno_dias, clientes, clientes_ubicacion
				  $where
			  ORDER BY 5 ASC";

	if($reporte== 'excel'){

		header("Content-type: application/vnd.ms-excel");
		 header("Content-Disposition:  filename=\"rp_$archivo.xls\";");

		$query01  = $bd->consultar($sql);
		 echo "<table border=1>";

 	 echo "<tr><th> ROLES </th><th> REGION </th><th> ESTADO </th><th> CIUDAD </th>
	           <th> FICHA </th><th> CEDULA </th><th> TRABAJADOR </th> <th> CARGO</th>
				<th> CONTRATO</th><th> DL</th><th> CLIENTE </th><th> UBICACION </th></tr>";

		while ($row01 = mysql_fetch_row($query01)){
		 echo "<tr><td>".$row01[0]."</td><td>".$row01[1]."</td><td>".$row01[2]."</td><td>".$row01[3]."</td>
		           <td>".$row01[4]."</td><td>".$row01[5]."</td><td>".$row01[6]."</td><td>".$row01[7]."</td>
				   <td>".$row01[8]."</td><td>".$row01[9]."</td><td>".$row01[10]."</td><td>".$row01[11]."</td></tr>";
		}
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
				'cod_ficha'=>'<b>Ficha</b>',
				'nombres'=>'<b>Trabajador</b>',
			    'contracto'=>'<b>Contrato</b>',
				'dl'=>'<b>DL</b>');

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
}
?>
