<?php
require "../modelo/planificacion_modelo.php";
require "../../../../".Leng;

$plan   = new Planificacion;
$proyectos  =  $plan->get_proyectos();
	echo '<option value="">Seleccione...</option>';
foreach ($proyectos as  $datos)
{
	echo '<option value="'.$datos[0].'">'.$datos[1].'</option>';
}?>
