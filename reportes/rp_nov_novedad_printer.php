
<?php
define("SPECIALCONSTANT", true);
$Nmenu   = 560;

$reporte         = $_GET['reporte'];

require("../autentificacion/aut_config.inc.php");
require_once("../".Funcion);
require_once("../".class_bdI);
require_once("../".Leng);
$bd = new DataBase();

$codigo         = $_GET['codigo'];
$archivo         = "rp_nov_novedad_printer.php";
$titulo          = " PLANILLA DE NOVEDADES ";

$logo = "../imagenes/logo.jpg";

if(isset($reporte)){

  if (file_exists($logo)) {
	 $logo_img =  '<img src='.$logo.' width="150" height="100">';
	} else {
	 $logo_img  =  '<img src="../imagenes/img_no_disp.jpg"/>';
	}

	// QUERY A MOStrAR //
   	$sql = " SELECT Max(nov_procesos_det.codigo) AS cod_det, nov_procesos.codigo,
                    novedades.descripcion AS novedad, clientes.nombre AS cliente,
                    clientes_ubicacion.descripcion AS ubicacion, nov_procesos.cod_ficha,
                    ficha.cedula, CONCAT(ficha.apellidos,' ', ficha.nombres) AS trabajador,
                    nov_procesos.observacion, nov_procesos.repuesta ,
                    nov_procesos.fec_us_ing, nov_procesos.fec_us_mod,
                    CONCAT(men_usuarios.apellido,' ', men_usuarios.nombre) AS us_ing, nov_procesos.cod_nov_status,
                    nov_status.descripcion AS `status`, control.cl_rif AS rif
               FROM nov_procesos , men_usuarios,
			        clientes , novedades , clientes_ubicacion , nov_status,
			  	    ficha, control, nov_procesos_det
              WHERE nov_procesos.codigo         = '$codigo'
                AND nov_procesos.cod_us_ing     = men_usuarios.codigo
			    AND nov_procesos.cod_cliente    = clientes.codigo
				AND nov_procesos.cod_novedad    =  novedades.codigo
				AND nov_procesos.cod_ubicacion  = clientes_ubicacion.codigo
				AND nov_procesos.cod_nov_status = nov_status.codigo
				AND nov_procesos.cod_ficha      = ficha.cod_ficha
			    AND nov_procesos.codigo         = nov_procesos_det.cod_nov_proc
           GROUP BY nov_procesos.codigo ";

		$query01 = $bd->consultar($sql);
		$row01   = $bd->obtener_name($query01);
		$cod_det = $row01['cod_det'];

   	$sql02 = " SELECT nov_status.descripcion AS `status`,CONCAT (men_usuarios.apellido,' ',men_usuarios.nombre) AS usuario_mod,
                      nov_procesos_det.observacion, nov_procesos_det.fec_us_ing AS fecha,
                      nov_procesos_det.hora
                 FROM nov_procesos_det, men_usuarios, nov_status
                WHERE nov_procesos_det.codigo = '$cod_det'
                  AND nov_procesos_det.cod_us_ing = men_usuarios.codigo
                  AND nov_procesos_det.cod_nov_status = nov_status.codigo ";

		$query02 = $bd->consultar($sql02);
		$row02   = $bd->obtener_name($query02);

	if(($reporte=='pdf') || ($reporte=='printer')){

		// require_once('../'.ConfigDomPdf);

		// $dompdf= new DOMPDF();

		// ob_start();

		require('../'.PlantillaDOM.'/header_ibarti_2.php');
		include('../'.pagDomPdf.'/paginacion_ibarti.php');

 		echo "<div><table><tr>
		 		<th style='text-align:center;'>".$logo_img."</th>
	         	<th style='text-align:center;'><span class='etiqueta'>".$leng['rif']."</span>: ".$row01['rif']."</th>
	         	</tr>
	         	</table>
	         	</div>
	         	<div style='margin-top:0.5cm;'>
	         	<table>
			   <tr class='odd_row'>
			   <td><span class='etiqueta'>Código</span>: ".$row01['codigo']."</td>
			   <td><span class='etiqueta'>Fecha De Sistema: </span>".$row01['fec_us_ing']." </td>
			   </tr>
			   <tr>
			   <td><span class='etiqueta'>Novedad: </span>".$row01['novedad']."</td>
			   <td><span class='etiqueta'>Usuario: </span>".$row01['us_ing']."</td>
			   </tr>
			   <tr class='odd_row'>
			   <td colspan='2'><span class='etiqueta'>".$leng['trabajador']."</span>: ".$row01['trabajador']."</td>
			   </tr>
			   <tr>
			   <td> <span class='etiqueta'>".$leng['cliente']."</span>: ".$row01['cliente']."</td>
			   <td> <span class='etiqueta'>".$leng['ubicacion']."</span>: ".$row01['ubicacion']."</td>
			   </tr>
			   <tr class='odd_row'>
			   <td colspan='2'><span class='etiqueta'> Observación General</span>: ".$row01['observacion']."</td>
			   </tr>
			   <tr>
			   <td colspan='2'><span class='etiqueta'> Repuesta General</span>: ".$row01['repuesta']."</td>
			   </tr>
			   </table>
			   </div>
			   <div style='margin-top:0.5cm'>
			   <table>
   			   <tr class='odd_row'>
   			   <td colspan='2'><span class='etiqueta'>Observación Detalle</span>: ".$row02['observacion']."</td>
   			   </tr>
			   <tr>
			   <td><span class='etiqueta'>Usuario</span>: ".$row02['usuario_mod']."</td>
			   <td><span class='etiqueta'>Fecha</span>: ".$row02['fecha']." ".$row02['hora']."</td>
			   </tr>
			   <tr class='odd_row'>
			   <td colspan='2'><span class='etiqueta'>Status<span>: ".$row02['status']."</td>
			   </tr>
			   </table>
			   </div>
			   	 <table style='margin-top:1cm;'>
			        <tbody>
			            <tr >
			            <td style='text-align: center;font-size: 11px;''>
			                _________________________<br>
			                <span class='firma'>Entregado Por</span><br><br>
			                _____________________<br>
			                <span class='firma'>".$leng['ci']."</span><br><br>
			                _____________________<br>
			                <span class='firma'>Firma</span>
			            </td>
			            <td style='text-align: center;font-size: 11px;''>
			                _________________________<br>
			                <span class='firma'>Recibido Por</span><br><br>
			                _____________________<br>
			                <span class='firma'>".$leng['ci']."</span><br><br>
			                _____________________<br>
			                <span class='firma'>Firma</span>
			            </td>
			        </tbody>
			        </table>";

		    // $dompdf->load_html(ob_get_clean(),'UTF-8');
		    // $dompdf->set_paper ('letter');
		    // $dompdf->render();
		    // $dompdf->stream($archivo, array('Attachment' => 0));
	}
}
?>
<body>
</body>
</html>
