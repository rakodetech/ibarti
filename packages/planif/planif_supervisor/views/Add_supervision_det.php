<?php
require "../modelo/planificacion_modelo.php";
require "../../../../" . Leng;

$cliente   = $_POST['cliente'];
$ubicacion   = $_POST['ubic'];
$cargo   = $_POST['cargo'];
$plan   = new Planificacion;
$cont = $plan->get_supervision_det($cliente, $ubicacion, $cargo);

echo '<div align="center" class="etiqueta_title">Planificacion Cliente</div><table width="90%" border="0" align="center">
				<tr>
					<th align="center" width="30%">' . $leng["ubicacion"] . '</th>
					<th align="center" width="30%">' . $leng["turno"] . '</th>
					<th align="center" width="30%">Cargo</th>
					<th align="center" width="10%">Cantidad</th>
				</tr>';
foreach ($cont as  $datos) {
	echo '<tr>
										<td align="center">' . $datos["ubicacion"] . '</td>
										<td align="center">' . $datos["turno"] . '</td>
										<td align="center">' . $datos["cargo"] . '</td>
										<td align="center">' . $datos["cantidad"] . '</td>
									<tr>';
}
echo '</table>';
