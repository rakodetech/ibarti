<td class="etiqueta"><span id="actividad_texto">Actividad:</span> </td>
<td>
<?php
require "../modelo/planificacion_modelo.php";
require "../../../../".Leng;

$plan   = new Planificacion;

$proyecto     = $_POST['proyecto'];
$actividades  =  $plan->get_actividades($proyecto);

foreach ($actividades as  $datos)
{
	if($datos[3] == "T"){
		$checked = "checked disabled='disabled'";
	}else{
		$checked = "";
	}
	echo ''.$datos[1].'<input type="checkbox" name="actividades[]" value="'.$datos[0].'" '.$checked.'
	id="actividad'.$datos[0].'" minutos="'.$datos[2].'" onchange="updateFecFin(null)" style="width:auto"> '.$datos[2].' min.<br>';
}
?>
</td>
