<?php
require "../modelo/planificacion_modelo.php";
require "../../../../".Leng;

$result = array();

$apertura  = $_POST['codigo'];
$cliente  = $_POST['cliente'];
$ficha  = $_POST['ficha'];
$plan  = new Planificacion;
$fechas = $plan->get_fechas_apertura($apertura, $cliente);
$trab  = $plan->get_planif_trab_det(null, null, $ficha, $fechas);
$result["data"] = $trab;
$result["fechas"] = $fechas;
print_r(json_encode($result));
return json_encode($result);
?>
