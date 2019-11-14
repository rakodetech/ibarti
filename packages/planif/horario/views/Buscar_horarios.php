<?php
$data = $_POST['data'];
$filtro = $_POST['filtro'];

require "../modelo/horario_modelo.php";
$horario = new Horario;

$lista_horarios = $horario->buscar_horario($data, $filtro);

foreach ($lista_horarios as  $datos) {
	echo '<tr onclick="Cons_horario(\''.$datos["codigo"].'\', \'modificar\')" title="Click para Modificar..">
	<td>'.$datos["codigo"].'</td>
	<td>'.longitud($datos["nombre"]).'</td>
	<td>'.$datos["hora_entrada"].'</td>
	<td>'.$datos["hora_salida"].'</td>
	<td>'.$datos["inicio_marc_entrada"].'</td>
	<td>'.$datos["fin_marc_entrada"].'</td>
	<td>'.statuscal($datos["status"]).'</td>
	</tr>';
}
?>