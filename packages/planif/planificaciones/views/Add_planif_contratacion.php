<?php
require "../modelo/planificacion_modelo.php";
require "../../../../".Leng;

$cliente  = $_POST['cliente'];
$plan     = new Planificacion;
$contratacion    = $plan->get_planif_contrato($cliente);

echo '<option value="">Seleccione..</option>';
foreach ($contratacion as  $datos)
{
	echo '<option value="'.$datos["codigo"].'">'.$datos["descripcion"].' ('.$datos["fecha_inicio"].')</option>
	';
}
?>
