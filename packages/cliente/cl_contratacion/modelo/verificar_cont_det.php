<?php
require "../modelo/contratacion_modelo.php";

$plan   = new Contratacion;

$cont  =  $plan->verificar_cont_det($_POST['cliente'],$_POST['contratacion']);

$result[] = $cont;

print_r(json_encode($result));
return json_encode($result);

?>
