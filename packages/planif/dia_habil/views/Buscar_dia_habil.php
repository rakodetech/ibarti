<?php
$data = $_POST['data'];
$filtro = $_POST['filtro'];

require "../modelo/dia_habil_modelo.php";
$dh = new Dia_habil;

$lista_dia_habil = $dh->buscar_dia_habil($data, $filtro);

foreach ($lista_dia_habil as  $datos) {
echo '<tr onclick="Cons_dia_habil(\''.$datos["codigo"].'\', \'modificar\')" title="Click para Modificar..">
							<td>'.$datos["codigo"].'</td>
							<td>'.longitud($datos["descripcion"]).'</td>
							<td>'.statuscal($datos["status"]).'</td>
							</tr>';
}
?>