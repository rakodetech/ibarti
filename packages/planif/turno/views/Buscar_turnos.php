<?php
$data = $_POST['data'];
$filtro = $_POST['filtro'];

require "../modelo/turno_modelo.php";
$turno = new Turno;

$lista_turnos = $turno->buscar_turno($data, $filtro);

foreach ($lista_turnos as  $datos) {
	 echo '<tr onclick="Cons_turno(\''.$datos["codigo"].'\', \'modificar\')" title="Click para Modificar..">
    <td>'.$datos["codigo"].'</td>
    <td>'.$datos["abrev"].'</td>
    <td>'.longitud($datos["descripcion"]).'</td>
    <td>'.statuscal($datos["status"]).'</td>
    </tr>';
}
?>