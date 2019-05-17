<?php
define("SPECIALCONSTANT",true);
session_start();
$Nmenu   = 524;
require("../autentificacion/aut_config.inc.php");
include_once('../funciones/funciones.php');
require_once("../".class_bdI);
require_once("../".Leng);
$bd = new DataBase();

$f_d =$_POST["fecha_desde"];
$f_h =$_POST["fecha_hasta"];
$ficha = $_POST["trabajador"];
$usuario = $_POST["user"];
$cod_accion = $_POST["act"];
$reporte =$_POST["reporte"];
$campo = $_POST['campo'];
$archivo         = "rp_fic_audit";
$where="";
$titulo = "REPORTE DE AUDITORIA";
if ($f_d != "" && $f_h != "") {
    $where .= " AND audit_ficha.fecha BETWEEN '$f_d' AND '$f_h'";
}

if ($ficha != "") {
    $where .= " AND audit_ficha.cod_ficha = '$ficha'";
}

if ($campo != "") {
    $where .= " AND audit_ficha_det.campo = '$campo'";
}

if ($usuario != "") {
    $where .= " AND men_usuarios.codigo = '$usuario'";
}

if ($cod_accion != "") {
    $where .= " AND acciones.codigo = '$cod_accion'";
}

$sql =
    "SELECT
        audit_ficha.fecha,
        audit_ficha.hora,
        CONCAT(
            men_usuarios.nombre,
            ' ',
            men_usuarios.apellido
        ) usuario,
        audit_ficha.cod_ficha,
        acciones.descripcion accion,
        audit_ficha_det.campo,
        audit_ficha_det.valor_ant,
        audit_ficha_det.valor_new
    FROM
        audit_ficha,
        men_usuarios,
        acciones,
        audit_ficha_det
    WHERE audit_ficha.cod_us_ing = men_usuarios.codigo
    AND audit_ficha.cod_accion = acciones.codigo
    AND audit_ficha_det.cod_audit = audit_ficha.codigo
	" . $where;
	
if(isset($reporte)){

	
	
	if($reporte== 'excel'){
		echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition:  filename=\"rp_audit.xls\";");

		//$query01  = $bd->consultar($sql);
		echo "<table border=1>";

		echo '<tr class="fondo00">
        <th width="10%" class="etiqueta">Fecha</th>
        <th width="10%" class="etiqueta">Hora</th>
        <th width="15%" class="etiqueta">Usuario</th>
        <th width="5%" class="etiqueta">Ficha</th>
        <th width="20%" class="etiqueta">Accion</th>
        <th width="15%" class="etiqueta">Campo</th>
        <th width="10%" class="etiqueta">Valor Anterior</th>
        <th width="10%" class="etiqueta">Valor Actual</th>
	</tr>';
	$valor = 0;
	$query = $bd->consultar($sql);

	while ($datos = $bd->obtener_fila($query, 0)) {
		if ($valor == 0) {
			$fondo = 'fondo01';
			$valor = 1;
		} else {
			$fondo = 'fondo02';
			$valor = 0;
		}
		echo '<tr class="' . $fondo . '" >
<td >' . $datos["fecha"] . '</p></td>
<td >' . $datos["hora"] . '</td>
<td >' . $datos["usuario"] . '</td>
<td >' . $datos["cod_ficha"] . '</td>
<td >' . $datos["accion"] . '</td>
<td >' . $datos["campo"] . '</td>
<td >' . $datos["valor_ant"] . '</td>
<td >' . $datos["valor_new"] . '</td>
</tr>';
	};
/*

		while ($row01 = $bd->obtener_num($query01)){
			echo "<tr><td>".$row01[0]."</td><td>".$row01[1]."</td><td>".$row01[2]."</td><td>".$row01[3]."</td>
			<td>".$row01[4]."</td><td>".$row01[5]."</td><td>".$row01[6]."</td><td>".$row01[7]."</td>
			<td>".$row01[8]."</td><td>".$row01[9]."</td><td>".$row01[10]."</td><td>".$row01[11]."</td>
			<td>".$row01[12]."</td><td>".$row01[13]."</td><td>".$row01[14]."</td><td>".$row01[15]."</td>
			<td>".$row01[16]."</td><td>".$row01[17]."</td><td>".$row01[18]."</td><td>".$row01[19]."</td>
			<td>".$row01[20]."</td><td>".$row01[21]."</td><td>".$row01[22]."</td><td>Nº ".$row01[23]."</td>
			<td>".$row01[24]."</td><td>".$row01[25]."</td><td>".$row01[26]."</td><td>".$row01[27]."</td>
			<td>".$row01[28]."</td><td>".$row01[29]."</td> <td>".$row01[30]."</td> <td>".$row01[31]."</td> <td>".$row01[32]."</td>
			<td>".$row01[33]."</td><td>".$row01[34]."</td>
			</tr>";
		}*/
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
		<table>
		<tbody>
		<tr>
		<th width="10%" class="etiqueta">Fecha</th>
        <th width="10%" class="etiqueta">Hora</th>
        <th width="15%" class="etiqueta">Usuario</th>
        <th width="5%" class="etiqueta">Ficha</th>
        <th width="20%" class="etiqueta">Accion</th>
        <th width="15%" class="etiqueta">Campo</th>
        <th width="10%" class="etiqueta">Valor Anterior</th>
        <th width="10%" class="etiqueta">Valor Actual</th>
		</tr>';
		$f=0;

		while ($datos = $bd->obtener_fila($query, 0)) {
			if ($f%2==0){
				echo "<tr>";
			}else{
				echo "<tr class='class= odd_row'>";
			}
			echo '
	<td >' . $datos["fecha"] . '</td>
	<td >' . $datos["hora"] . '</td>
	<td >' . $datos["usuario"] . '</td>
	<td >' . $datos["cod_ficha"] . '</td>
	<td >' . $datos["accion"] . '</td>
	<td >' . $datos["campo"] . '</td>
	<td >' . $datos["valor_ant"] . '</td>
	<td >' . $datos["valor_new"] . '</td>
	</tr>';
		};

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
