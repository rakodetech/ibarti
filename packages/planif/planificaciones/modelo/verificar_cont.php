<?php
require "../modelo/planificacion_modelo.php";

$plan   = new Planificacion;

$cont  =  $plan->verificar_cont($_POST['cliente'],$_POST['codigo']);

$result[] = $cont;

print_r(json_encode($result));
return json_encode($result);

?>
