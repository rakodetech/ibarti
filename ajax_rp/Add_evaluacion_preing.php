<?php
include_once "../funciones/funciones.php";
require "../autentificacion/aut_config.inc.php";
require "../" . class_bd;
require "../" . Leng;
$bd = new DataBase();

$fecha_D   = conversion($_POST['fecha_desde']);
$fecha_H   = conversion($_POST['fecha_hasta']);
$Nmenu      = $_POST['Nmenu'];
$mod        = $_POST['mod'];
$tipo       = $_POST['tipo'];
$clasif     = $_POST['clasif'];
$cedula    	= $_POST['cedula'];


$where = "";

if ($clasif != "TODOS" && $clasif != "") {
	$where .= " AND nov_clasif.codigo = '$clasif' ";
}

if ($cedula != "TODOS" && $cedula != "") {
	$where .= " AND nov_check_list_trab.cedula = '$cedula' ";
}

if ($tipo != "TODOS" && $tipo != "") {
	$where .= " AND nov_tipo.codigo  = '$tipo' ";
}

$sql   = " SELECT
		nov_check_list_trab.codigo,nov_check_list_trab.fec_us_mod,nov_tipo.descripcion,preingreso.cedula,concat(preingreso.nombres,' ',preingreso.apellidos) nombres,SUM(nov_check_list_trab_det.valor),SUM(nov_check_list_trab_det.valor_max),CONCAT(ROUND((SUM(nov_check_list_trab_det.valor) / SUM(nov_check_list_trab_det.valor_max)) * 100),'%') porcentaje 
	FROM
		preingreso,nov_check_list_trab,nov_check_list_trab_det,nov_tipo,nov_clasif
		WHERE nov_check_list_trab.fec_us_ing BETWEEN \"$fecha_D\" AND \"$fecha_H\" AND  nov_check_list_trab.cedula = preingreso.cedula AND nov_check_list_trab.cod_nov_clasif = nov_clasif.codigo AND nov_check_list_trab.cod_nov_tipo = nov_tipo.codigo AND nov_check_list_trab.codigo = nov_check_list_trab_det.cod_check_list 
					$where
					GROUP BY	nov_check_list_trab.codigo";
$query = $bd->consultar($sql);
?><table width="100%" align="center">
	<tr class="fondo00">
		<th width="7%" class="etiqueta">Codigo</th>
		<th width="8%" class="etiqueta">Fecha</th>
		<th width="22%" class="etiqueta">Evaluacion</th>
		<th width="22%" class="etiqueta">Documento</th>
		<th width="22%" class="etiqueta">Trabajador</th>
		<th width="22%" class="etiqueta">Puntaje</th>
	</tr>
	<?php
	$valor = 0;
	while ($datos = $bd->obtener_fila($query, 0)) {
		if ($valor == 0) {
			$fondo = 'fondo01';
			$valor = 1;
		} else {
			$fondo = 'fondo02';
			$valor = 0;
		}
		echo '<tr class="' . $fondo . '">
                  <td class="texo" style="text-align:center;">' . $datos[0] . '</td>
                  <td class="texo" style="text-align:center;">' . $datos[1] . '</td>
				  <td class="texo" style="text-align:center;">' . longitud($datos[2]) . '</td>
                  <td class="texo" style="text-align:center;">' . longitud($datos[3]) . '</td>
				  <td class="texo" style="text-align:center;">' . strtoupper(longitud($datos[4])) . '</td>
				  <td class="texo" style="text-align:center;">' . $datos[7] . '</td>
            </tr>';
	}; ?>
</table>