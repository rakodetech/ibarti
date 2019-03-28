<?php
$cliente = $_POST['cliente'];
$ubicacion = $_POST['ubicacion'];

require "../modelo/vetados_modelo.php";
$vetado = new Vetado;

$lista_vetados = $vetado->get_trab($cliente, $ubicacion);

if($lista_vetados){
	echo '<select id="vet_ficha" style="width:220px" required>
	<option value="">Seleccione...</option>';
	foreach ($lista_vetados as  $datos) {
		echo '<option value="'.$datos[0].'">('.$datos[0].') '.$datos[1].'</option>';
	}
}else{
	echo '<select id="vet_ficha" style="width:220px" required>
	<option value="">Seleccione...</option>';
}
?>