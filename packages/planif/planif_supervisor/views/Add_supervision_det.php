<?php
require "../modelo/planificacion_modelo.php";
require "../../../../".Leng;

$ubic   = $_POST['ubicacion'];
$plan   = new Planificacion;
$cont = $plan->get_supervision_det($ubic);

echo '<div align="center" class="etiqueta_title">Detalle de Supervision</div><table width="90%" border="0" align="center">
				<tr>
					<th width="40%">'.$leng["ubicacion"].'</th>
					<th width="40%">'.$leng["turno"].'</th>
					<th width="20%">Cantidad</th>
				</tr>';
					foreach ($cont as  $datos)
					{
						echo '<tr>
										<td align="center">'.$datos["ubicacion"].'</td>
										<td align="center">'.$datos["turno_abrev"].'</td>
										<td align="center">'.$datos["cantidad"].'</td>
									<tr>';
					}
					echo '</table>';
?>
