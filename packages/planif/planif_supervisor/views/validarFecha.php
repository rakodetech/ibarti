<?php
require "../modelo/planificacion_modelo.php";
require "../../../../".Leng;

$plan   = new Planificacion;

$cliente     = $_POST['cliente'];
$fecha     = $_POST['fecha'];
$apertura     = $_POST['apertura'];
$result  =  $plan->validar_fecha($fecha, $cliente, $apertura);

print_r(json_encode($result));
return json_encode($result);
?>
