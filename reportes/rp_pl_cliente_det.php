<?php
define("SPECIALCONSTANT",true);
session_start();
$Nmenu   = 527;
require("../autentificacion/aut_config.inc.php");
include_once('../'.Funcion);
require_once("../".class_bdI);
require_once("../".Leng);
$bd = new DataBase();

if(($_POST['fecha_desde'] == "" or $_POST['fecha_hasta'] == "")){
exit;
}

$region    = $_POST['region'];
$estado    = $_POST['estado'];
$cliente   = $_POST['cliente'];
$turno     = $_POST['turno'];
$cargo     = $_POST['cargo'];

$fecha_D   = conversion($_POST['fecha_desde']);
$fecha_H   = conversion($_POST['fecha_hasta']);

$reporte         = $_POST['reporte'];
$archivo         = "rp_pl_cliente_".$fecha."";
$titulo          = "  REPORTE PLANTILLA CLIENTES  \n";

if(isset($reporte)){

	$where = "  WHERE pl_cliente.fecha BETWEEN  \"$fecha_D\" AND \"$fecha_H\"
                  AND pl_cliente.codigo = pl_cliente_det.cod_pl_cliente
				  AND pl_cliente.cod_turno = turno.codigo
			      AND turno.cod_horario = horarios.codigo
				  AND pl_cliente_det.cod_region = regiones.codigo
			      AND pl_cliente_det.cod_estado = estados.codigo
                  AND pl_cliente_det.cod_cliente = clientes.codigo
                  AND pl_cliente_det.cod_cargo = cargos.codigo ";


	if($region != "TODOS"){
		$where .= " AND pl_cliente_det.cod_region = '$region' ";
	}

	if($estado != "TODOS"){
		$where .= " AND estados.codigo = '$estado' ";  // cambie AND asistencia.co_cont = '$contracto'
	}

	if($cliente != "TODOS"){
		$where  .= " AND clientes.codigo = '$cliente' ";
	}

	if($turno != "TODOS"){
		$where  .= " AND turno.codigo = '$turno' ";
	}

	if($cargo != "TODOS"){
		$where  .= " AND cargos.codigo = '$cargo' ";
	}

 $sql = " SELECT  pl_cliente.fecha,  regiones.descripcion AS region,
                  estados.descripcion AS estado, clientes.nombre AS cliente,
				  clientes.abrev AS cl_abrev, turno.descripcion AS turno,
				  horarios.nombre AS horario, cargos.descripcion AS cargo,
				  SUM(pl_cliente_det.cantidad) AS cantidad, (SUM(pl_cliente_det.cantidad) * turno.trab_cubrir) AS trab_necesario
             FROM pl_cliente , turno , horarios , pl_cliente_det ,
                  regiones , estados , clientes , cargos
            $where
		  GROUP BY pl_cliente.fecha, regiones.descripcion,
                   estados.descripcion, clientes.nombre,
                   turno.descripcion, horarios.nombre,
                   cargos.descripcion
          ORDER BY 1 ASC ";

	if($reporte== 'excel'){
		echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
		header("Content-type: application/vnd.ms-excel");
		 header("Content-Disposition:  filename=\"rp_$archivo.xls\";");

		$query01  = $bd->consultar($sql);
		 echo "<table border=1>";
 	 echo "<tr><th> Fecha </th><th> ".$leng['region']." </th><th> ".$leng['estado']." </th><th> ".$leng['cliente']." </th>
               <th> CL. Abreviatura </th><th> Turno </th><th> Horario </th> <th> Cargo </th>
			   <th> Cantidad </th><th> Trab. Necesarios </th>
			  </tr>";

		while ($row01 =  $bd->obtener_num($query01)){
		 echo "<tr><td> ".$row01[0]." </td><td>".$row01[1]."</td><td>".$row01[2]."</td><td>".$row01[3]."</td>
		           <td>".$row01[4]."</td><td>".$row01[5]."</td><td>".$row01[6]."</td><td>".$row01[7]."</td>
				   <td>".$row01[8]."</td> <td>".$row01[9]."</td></tr>";
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
            <th width='10%'>Fecha</th>
            <th width='10%'>".$leng['estado']."</th>
            <th width='10%'>".$leng['cliente']."</th>
            <th width='25%'>Cargo</th>
            <th width='25%'>Turno</th>
            <th width='8%' style='text-align:center;'>Cantidad</th>
            <th width='12%'>Trab. Necesario</th>
            </tr>";

            $f=0;
    while ($row =  $bd->obtener_num($query)){
    	 if ($f%2==0){
                echo "<tr>";
            }else{
                echo "<tr class='class= odd_row'>";
            }
    echo   "<td width='10%'>".$row[0]."</td>
            <td width='10%'>".$row[2]."</td>
            <td width='10%'>".$row[3]."</td>
            <td width='25%'>".$row[7]."</td>
            <td width='25%'>".$row[5]."</td>
            <td width='10%' style='text-align:center;'>".$row[8]."</td>
            <td width='10%' style='text-align:center;'>".$row[9]."</td></tr>";

             $f++;
         }

    echo "</tbody>
        </table>
		</div>
		</body>
		</html>";

		    $dompdf->load_html(ob_get_clean(),'UTF-8');
		    $dompdf->set_paper ('letter','landscape');
		    $dompdf->render();
		    $dompdf->stream($archivo, array('Attachment' => 0));
	}
}