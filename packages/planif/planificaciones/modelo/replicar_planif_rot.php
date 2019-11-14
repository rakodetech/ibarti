<?php
require "../modelo/planificacion_modelo.php";

$plan   = new Planificacion;

$result  =  $plan->replicar_rot($_POST['cliente'],$_POST['ubicacion'],$_POST['contratacion'],$_POST['apertura'],$_POST['usuario']);

print_r(json_encode($result));
return json_encode($result);

?>
