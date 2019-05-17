<?php
session_start(); 
$Nmenu   = 561;
require("../autentificacion/aut_config.inc.php");
include_once('../funciones/funciones.php');
require_once('../autentificacion/aut_verifica_menu_02.php');
require_once("../".class_bd);
$bd = new DataBase(); 

if(($_POST['fecha_desde'] == "" or $_POST['fecha_hasta'] == "")){
	exit;
}

$fecha_D         = conversion($_POST['fecha_desde']);
$fecha_H         = conversion($_POST['fecha_hasta']);

$clasif          = $_POST['clasif'];
$tipo            = $_POST['tipo'];
$cliente         = $_POST['cliente'];
$ubicacion       = $_POST['ubicacion'];
$status          = $_POST['status'];

$trabajador     = $_POST['trabajador'];

$reporte         = $_POST['reporte'];

$archivo         = "rp_nov_check_list_".$_POST['fecha_desde'].""; 
$titulo          = " REPORTE DE NOVEDADES CHECK LIST FECHA: ".$fecha_D." HASTA: ".$fecha_H."\n"; 	

if(isset($reporte)){	

		$where = " WHERE nov_check_list.fec_us_ing BETWEEN \"$fecha_D\" AND \"$fecha_H\"
                     AND nov_check_list.cod_nov_clasif = nov_clasif.codigo
				     AND nov_check_list.cod_nov_tipo   = nov_tipo.codigo
                     AND nov_check_list.codigo = nov_check_list_det.cod_check_list      
                     AND nov_check_list_det.cod_novedades = novedades.codigo
                     AND nov_check_list.cod_cliente = clientes.codigo
                     AND nov_check_list.cod_ubicacion = clientes_ubicacion.codigo 
                     AND nov_check_list.cod_ficha = ficha.cod_ficha 
                     AND ficha.cedula = preingreso.cedula 
                     AND nov_check_list.cod_nov_status = nov_status.codigo ";				 

	if($clasif != "TODOS"){		
		$where .= " AND nov_clasif.codigo = '$clasif' ";  
	}		

	if($clasif != "TODOS"){		
		$where .= " AND nov_tipo.codigo = '$tipo' ";  
	}		
	if($status != "TODOS"){
		$where  .= " AND nov_status.codigo = '$status' ";
	}

	if($cliente != "TODOS"){
		$where  .= " AND clientes.codigo = '$cliente' ";
	}  

	if($ubicacion != "TODOS"){
		$where  .= " AND clientes_ubicacion.codigo = '$ubicacion' ";
	}  	                  

	if($trabajador != NULL){
		$where  .= " AND ficha.cod_ficha = '$trabajador' ";
	}			 
	// QUERY A MOSTRAR //
    	$sql = "SELECT  nov_check_list.codigo, nov_check_list.fec_us_ing, 
                       CONCAT(preingreso.apellidos, ' ', preingreso.nombres) AS superv, clientes.nombre AS cliente,                                              clientes_ubicacion.descripcion AS ubicacion, nov_check_list.repuesta, 
					   nov_clasif.descripcion AS clasif, nov_clasif.descripcion AS tipo,   
					   novedades.descripcion AS check_list ,
					   Valores(nov_check_list_det.valor) AS valor, nov_check_list_det.observacion, 
					   nov_check_list.fec_us_mod, nov_status.descripcion AS nov_status
                  FROM nov_check_list , nov_check_list_det, novedades,
				       nov_clasif , nov_tipo, clientes , clientes_ubicacion , 
					   ficha , preingreso , nov_status
                $where            	
              ORDER BY 3 ASC ";

	if($reporte== 'excel'){ 
	
		header("Content-type: application/vnd.ms-excel");
		 header("Content-Disposition:  filename=\"$archivo.xls\";");
		
		$query01  = $bd->consultar($sql);

		 echo "<table border=1>";

	 echo "<tr><th>CODIGO </th><th>FECHA </th><th> SUPERVISOR </th><th> CLIENTE </th>
	           <th> UBICACION </th><th>RESPUESTA </th> <th> CLASIFICACION </th> <th> TIPO </th>
			   <th> CHECK LIST </th><th> VALOR </th><th> OBSERVACION </th><th> FEC. ULTIMA MODIFICACION </th>
			   <th> STATUS </th></tr>";
		
		while ($row01 = mysql_fetch_row($query01)){
		 echo "<tr><td>".$row01[0]."</td><td>".$row01[1]."</td><td>".$row01[2]."</td><td>".$row01[3]."</td>
		           <td>".$row01[4]."</td><td>".$row01[5]."</td><td>".$row01[6]."</td><td>".$row01[7]."</td>
		           <td>".$row01[8]."</td><td>".$row01[9]."</td><td>".$row01[10]."</td><td>".$row01[11]."</td>
				   <td>".$row01[12]."</td></tr>";		
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
				'codigo'=>'<b>Codigo</b>',
				'fec_us_ing'=>'<b>Fecha</b>',
				'clasif'=>'<b>Clasificacion</b>',
				'check_list'=>'<b>Check List</b>',
				'cliente'=>'<b>Cliente</b>',
				'ubicacion'=>'<b>Ubicacion</b>',	
				'valor'=>'<b>Valor</b>');			
	
    $options = array(
                    'shadeCol'=>array(0.9,0.9,0.9),
                    'xOrientation'=>'center',
                    'width'=>800);	
	
    $txttit = "<b>$titulo</b>\n";
	     
    $pdf->ezText($txttit, 12);
    $pdf->ezTable($data, $titles, '', $options);
    $pdf->ezText("\n\n\n", 10);
    $pdf->ezText("<b>Fecha:</b> ".date("d/m/Y"), 10);
    $pdf->ezText("<b>Hora:</b> ".date("H:i:s")."\n\n", 10);
    $pdf->ezStream();  
	}
}?>