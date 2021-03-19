<?php
define("SPECIALCONSTANT", true);
include_once "../funciones/funciones.php";
require "../autentificacion/aut_config.inc.php";
require "../" . class_bdI;
require "../" . Leng;
$bd = new DataBase();


$cliente           = $_POST['cliente'];
$region        = $_POST['region'];
$documento     = $_POST['documento'];
$doc_check     = $_POST['doc_check'];
$doc_vencimiento     = $_POST['doc_vencimiento'];
$doc_vencido     = $_POST['doc_vencido'];


$where = "  WHERE
clientes.codigo = clientes_documentos.cod_cliente
AND clientes_documentos.cod_documento = documentos_cl.codigo
AND documentos_cl.`status` = 'T'
AND clientes.cod_region = regiones.codigo
";

if ($cliente != "TODOS") {
	$where .= " AND clientes.codigo = '$cliente' ";
}

if ($region != "TODOS") {
	$where .= " AND regiones.codigo = '$region' ";
}

if ($documento != "TODOS") {
	$where  .= " AND clientes_documentos.cod_documento = '$documento' ";
}

if ($doc_check != "TODOS") {
	$where  .= " AND clientes_documentos.checks = '$doc_check' ";
}
if ($doc_vencimiento != "TODOS") {
	$where  .= " AND clientes_documentos.vencimiento = '$doc_vencimiento' ";
}
if ($doc_vencido != "TODOS") {
	if ($doc_vencido == "S") {
		$where  .= " AND clientes_documentos.venc_fecha < \"" . date("Y-m-d") . "\"";
	} else if ($doc_vencido == "N") {
		$where  .= "  AND (clientes_documentos.venc_fecha >= \"" . date("Y-m-d") . "\" OR ISNULL(clientes_documentos.venc_fecha)) ";
	}
}

// QUERY A MOSTRAR //
$sql = "SELECT
clientes.nombre cliente,
regiones.descripcion region,
clientes_documentos.cod_documento,
documentos_cl.descripcion doc,
StatusD (clientes_documentos.checks) checks,
StatusD (
	clientes_documentos.vencimiento
) vencimiento,
IFNULL(clientes_documentos.venc_fecha, 'NO VENCE') venc_fecha,
clientes_documentos.fec_us_ing fec_ingreso
FROM
clientes,
clientes_documentos,
documentos_cl,
regiones
                $where
				ORDER BY 1 ASC
			 ";
?>
<table width="100%" border="0" align="center">
	<tr class="fondo00">
		<th width="20%" class="etiqueta">Región</th>
		<th width="20%" class="etiqueta"><?php echo $leng['cliente'] ?></th>
		<th width="20%" class="etiqueta">Documento</th>
		<th width="9%" class="etiqueta">Check</th>
		<th width="9%" class="etiqueta">Vencimiento</th>
		<th width="9%" class="etiqueta">Fec. Vencimineto</th>
		<th width="9%" class="etiqueta">Fec. Ingreso</th>
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
			      <td class="texto">' . $datos["region"] . '</td>
				  <td class="texto">' . $datos["cliente"] . ' </td>
				  <td class="texto">' . longitud($datos["doc"]) . '</td>
				  <td class="texto">' . $datos["checks"] . '</td>
				  <td class="texto">' . $datos["vencimiento"] . '</td>
				  <td class="texto">' . $datos["venc_fecha"] . '</td>
				  <td class="texto">' . $datos["fec_ingreso"] . '</td>
           </tr>';
	}; ?>
</table>