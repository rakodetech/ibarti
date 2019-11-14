<?php
define("SPECIALCONSTANT",true);
include_once "../funciones/funciones.php";
require "../autentificacion/aut_config.inc.php";
require_once "../".class_bdI;
require "../".Leng;

$bd = new DataBase();
$cliente         = $_POST['cliente'];
$ubic         = $_POST['ubicacion'];
$cargo         = $_POST['cargo'];
$turno         = $_POST['turno'];
$fecha_D = conversion($_POST['fecha_desde']);
$fecha_H = conversion($_POST['fecha_hasta']);
$usuario = $_POST['usuario'];

$reporte         = $_POST['reporte'];
$archivo         = "rp_pl_cliente_ubicacion".$fecha."";
$titulo          = "  REPORTE PLANTILLA CLIENTES  \n";

$WHERE = " WHERE a.fecha BETWEEN '$fecha_D' AND '$fecha_H' AND a.`status`='T' ";

if($cliente != 'TODOS'){
	$WHERE .= " AND a.cod_cliente = '$cliente' "; 
}

if($ubic != 'TODOS'){
	$WHERE .= " AND a.cod_ubicacion = '$ubic' "; 
}

if($turno != 'TODOS'){
	$WHERE .= " AND a.cod_turno = '$turno' "; 
}

if($cargo != 'TODOS'){
	$WHERE .= " AND a.cod_cargo = '$cargo' "; 
}

$sql ="SELECT
a.fecha,
cl.abrev cliente,
cu.descripcion ubicacion,
t.descripcion turno,
cg.descripcion cargo,
Sum(a.cantidad) cantidad,
SUM(a.cantidad * t.trab_cubrir) trab_neces
FROM
clientes_contratacion_ap AS a
INNER JOIN turno AS t ON a.cod_turno = t.codigo
INNER JOIN cargos AS cg ON a.cod_cargo = cg.codigo
INNER JOIN horarios AS h ON t.cod_horario = h.codigo
INNER JOIN dias_habiles ON t.cod_dia_habil = dias_habiles.codigo
INNER JOIN dias_habiles_det ON dias_habiles_det.cod_dias_habiles = dias_habiles.codigo
INNER JOIN dias_tipo ON dias_habiles_det.cod_dias_tipo = dias_tipo.dia AND Dia_semana(a.fecha)= dias_tipo.descripcion
OR (dias_habiles_det.cod_dias_tipo = dias_tipo.dia AND dias_tipo.tipo = 'D')
OR (dias_habiles_det.cod_dias_tipo = dias_tipo.dia AND DATE_FORMAT(a.fecha,'%d') = dias_tipo.descripcion)
INNER JOIN clientes AS cl ON a.cod_cliente = cl.codigo
INNER JOIN clientes_ubicacion AS cu ON a.cod_ubicacion = cu.codigo
$WHERE
GROUP BY a.cod_cliente, a.cod_ubicacion, a.cod_turno,a.cod_cargo, a.fecha";
if(isset($reporte)){

	if($reporte== 'excel'){
		echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition:  filename=\"rp_$archivo.xls\";");

		echo "<table border=1>";

		$query01  = $bd->consultar($sql);

		echo '<tr><th>Fecha </th><th>'.$leng['cliente'].'</th><th>'.$leng['ubicacion'].'</th><th>'.$leng['turno'].'</th>
		<th>Cargo</th><th>Cantidad</th><th>Trab. Neces.</th></tr>';

		while ($datos = $bd->obtener_num($query01)){
			echo '<tr><td>'.$datos[0].'</td><td>'.$datos[1].'</td><td class="texto">'.$datos[2].'</td><td class="texto">'.$datos[3].'</td><td class="texto">'.$datos[4].'</td>
			<td class="texto">'.$datos[5].'</td><td class="texto">'.$datos[6].'</td></tr>';

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

		echo '<br><div>
		<table border="1">
		<tbody>
		<tr style="background-color: #4CAF50;">
		<th width="10%" class="etiqueta">Fecha </th>
		<th width="15%" class="etiqueta">'.$leng['cliente'].'</th>
		<th width="20%" class="etiqueta">'.$leng['ubicacion'].'</th>
		<th width="15%" class="etiqueta">'.$leng['turno'].'</th>
		<th width="20%" class="etiqueta">Cargo</th>
		<th width="10%" class="etiqueta">Cantidad</th>
		<th width="10%" class="etiqueta">Trab. Neces.</th>
		</tr>';
		$valor = 0;
		$query = $bd->consultar($sql);

		$f=0;
		while ($datos = $bd->obtener_num($query)){
			if ($f%2==0){
				echo "<tr>";
			}else{
				echo "<tr class='class= odd_row'>";
			}
			echo '<td class="texto">'.$datos[0].'</td>
			<td class="texto">'.$datos[1].'</td>
			<td class="texto">'.$datos[2].'</td>
			<td class="texto">'.$datos[3].'</td>
			<td class="texto">'.longitud($datos[4]).'</td>
			<td class="texto">'.$datos[5].'</td>
			<td class="texto">'.$datos[6].'</td></tr>';

			$f++;
		};
		echo "</tbody></table>
		</div>
		</body>
		</html>";

		$dompdf->load_html(ob_get_clean(),'UTF-8');
		$dompdf->set_paper ('letter','landscape');
		$dompdf->render();
		$dompdf->stream($archivo, array('Attachment' => 0));
	}
}
