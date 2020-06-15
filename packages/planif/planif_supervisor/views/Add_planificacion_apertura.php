<?php
require "../modelo/planificacion_modelo.php";
require "../../../../".Leng;
$cliente   = $_POST['cliente'];
$ubicacion   = $_POST['ubicacion'];
$apertura   = $_POST['apertura'];
$plan   = new Planificacion;
$datos_ap = $plan->get_dias_planif_apertura($cliente,$ubicacion,$apertura);

echo json_encode($datos_ap);

?>
