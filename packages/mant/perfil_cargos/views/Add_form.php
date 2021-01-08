<?php
require("../modelo/perfil_cargos_modelo.php");

if ($_POST['codigo'] != "") {

	$modelo = new PerfilCargos;

	$data = $modelo->get($_POST['codigo']);
	$i = 0;

	echo '<table width="90%" align="center" class="tabla_planif">
	<tr>
	<th width="55%"> PERFIL</th>
	<th width="15%">CHECK</th>
	</tr>';

	foreach ($data as  $row03) {
		$i++;

		if ($row03['existe'] != 'NO' && $row03['status'] == 'T') {
			$check = 'checked="checked"';
		} else {
			$check = '';
		}

		echo '<tr>
		<td class="etiqueta">' . $row03[1] . '</td>
		<td><input type="checkbox" id="' . $row03[0] . '" value="' . $row03[0] . '" style="width:auto" ' . $check . ' onclick="actualizar(this.value)"/>
		</tr>';
	}
	echo '</table>';
} else {
	echo '<span>Debe Seleccionar un Perfil!.. </span>';
}
