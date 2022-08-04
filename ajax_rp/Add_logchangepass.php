<?php
include_once "../funciones/funciones.php";
require "../autentificacion/aut_config.inc.php";
require "../" . class_bd;
require "../" . Leng;
$bd = new DataBase();

$perfil             = $_POST['perfil'];

$status          = $_POST['status'];
$usuario      = $_POST['usuario'];

$where = " WHERE v_log_cambio_clave.cod_usuario = v_log_cambio_clave.cod_usuario ";

if ($_POST['fecha_desde'] != "") {
	$fecha_D         = conversion($_POST['fecha_desde']);
	$where .= " AND v_log_cambio_clave.fecha >= \"$fecha_D\" ";
}

if ($_POST['fecha_hasta'] != "") {
	$fecha_H         = conversion($_POST['fecha_hasta']);
	$where .= " AND v_log_cambio_clave.fecha <= \"$fecha_H\" ";
}

if ($perfil != "TODOS") {
	$where .= " AND v_log_cambio_clave.cod_perfil = '$perfil' ";
}

if ($status != "TODOS") {
	$where .= " AND v_log_cambio_clave.cod_status = '$status' ";
}
if ($usuario != NULL) {
	$where  .= " AND v_log_cambio_clave.cod_usuario = '$usuario' ";
}

// QUERY A MOSTRAR //
$sql = "SELECT v_log_cambio_clave.*
	FROM v_log_cambio_clave
	$where
	ORDER BY 2 ASC";
?><table width="100%" border="0" align="center">
	<tr class="fondo00">
		<th width="15%" class="etiqueta">Fecha</th>
		<th width="18%" class="etiqueta">Perfil Usuario</th>
		<th width="10%" class="etiqueta">Usuario</th>
		<th width="18%" class="etiqueta">Perfil Usuario Mod.</th>
		<th width="10%" class="etiqueta">Usuario Mod.</th>
		<th width="7%" class="etiqueta">Status</th>
	</tr>
	<?php
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
		echo '<tr class="' . $fondo . '">
			<td class="texto">' . $datos["fecha"] . '</td>
			<td class="texto">' . $datos["perfil_usuario"] . '</td>
			<td class="texto">' . $datos["ap_nombre_usuario"] . '</td>
			<td class="texto">' . $datos["perfil_usuario_mod"] . '</td>
			<td class="texto">' . $datos["ap_nombre_usuario_mod"] . '</td>
			<td class="texto">' . $datos["status_usuario"] . '</td>
			</tr>';
	}; ?>
</table>