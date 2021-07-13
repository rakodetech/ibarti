<?php
define("SPECIALCONSTANT", true);
include_once "../funciones/funciones.php";
require "../autentificacion/aut_config.inc.php";
require "../" . class_bdI;
require "../" . Leng;
$bd = new DataBase();

$proyecto    = $_POST['proyecto'];

$sql = "SELECT
planif_proyecto.codigo,
planif_proyecto.descripcion,
planif_proyecto.abrev,
Valores(planif_proyecto.`status`) AS `status`
FROM
planif_proyecto
LEFT JOIN planif_actividad ON planif_actividad.cod_proyecto = planif_proyecto.codigo
LEFT JOIN planif_proyecto_cargos ON planif_proyecto_cargos.cod_proyecto = planif_proyecto.codigo
WHERE planif_proyecto.codigo = $proyecto 
GROUP BY planif_proyecto.codigo";

$sql_actividaes = "SELECT
planif_actividad.codigo,
planif_actividad.descripcion,
planif_actividad.minutos,
Valores(planif_actividad.obligatoria) obligatoria,
Valores(planif_actividad.participantes) participantes
FROM
planif_actividad
WHERE
planif_actividad.cod_proyecto = $proyecto
AND planif_actividad.`status` = 'T'";

$sql_cargos = "SELECT
cargos.codigo,
cargos.descripcion
FROM
	planif_proyecto_cargos,
	cargos
WHERE
	planif_proyecto_cargos.cod_proyecto = $proyecto
AND planif_proyecto_cargos.cod_cargo = cargos.codigo
GROUP BY planif_proyecto_cargos.cod_cargo";

$query = $bd->consultar($sql);
$proyecto = $bd->obtener_fila($query);
?>
<form method="post" name="detail" id="detail" enctype="multipart/form-data">
	<fieldset class="fieldset">
		<legend>Proyecto</legend>
		<table width="100%" align="center" border="0">
			<tr>
				<th class="etiqueta">Código: <?php echo $proyecto['codigo']; ?></th>
				<th class="etiqueta">Descripción: <?php echo $proyecto['descripcion']; ?></th>
				<th class="etiqueta">Abreviatura: <?php echo $proyecto['abrev']; ?></th>
				<th class="etiqueta">Activo: <?php echo $proyecto['status']; ?></th>
			<tr>
		</table>
	</fieldset>
	<fieldset class="fieldset">
		<legend>Actividades</legend>
		<table width="100%" align="center" border="0">
			<thead>
				<tr class="fondo00">
					<th class='etiqueta'>Código</th>
					<th class="etiqueta">Descripción</th>
					<th class="etiqueta">Minutos</th>
					<th class="etiqueta">Obligatoria</th>
					<th class="etiqueta">Aplica Participantes</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$query_actividades = $bd->consultar($sql_actividaes);
				while ($actividad = $bd->obtener_fila($query_actividades)) {
					echo "	<tr>
							<td class='etiqueta'>" . $actividad['codigo'] . "</td>
							<td class='etiqueta'>" . $actividad['descripcion'] . "</td>
							<td class='etiqueta'>" . $actividad['minutos'] . "</td>
							<td class='etiqueta'>" . $actividad['obligatoria'] . "</td>
							<td class='etiqueta'>" . $actividad['participantes'] . "</td>
							</tr>";
				}
				?>
			</tbody>
		</table>
	</fieldset>
	<fieldset class="fieldset">
		<legend>Cargos</legend>
		<table width="100%" align="center" border="0">
			<thead>
				<tr class="fondo00">
					<th class='etiqueta'>Código</th>
					<th class='etiqueta'>Descripción</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$query_cargos = $bd->consultar($sql_cargos);
				while ($cargo = $bd->obtener_fila($query_cargos)) {
					echo "	<tr>
							<td class='etiqueta'>" . $cargo['codigo'] . "</td>
							<td class='etiqueta'>" . $cargo['descripcion'] . "</td>
							</tr>";
				}
				?>
			</tbody>
		</table>
	</fieldset>
</form>