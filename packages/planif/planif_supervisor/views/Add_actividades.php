<?php
require "../modelo/planificacion_modelo.php";
require "../../../../".Leng;

$plan   = new Planificacion;
$result = array();
$proyecto     = $_POST['proyecto'];
$result  =  $plan->get_actividades($proyecto);

print_r(json_encode($result));
return json_encode($result);
?>
