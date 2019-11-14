<?php
require "../modelo/planificacion_modelo.php";
require "../../../../".Leng;
$cliente   = $_POST['cliente'];
$ubicacion   = $_POST['ubicacion'];
$contratacion   = $_POST['contratacion'];
$apertura   = $_POST['apertura'];
$plan   = new Planificacion;
$datos_ap = $plan->get_dias_planif_apertura($cliente,$ubicacion,$contratacion,$apertura);

echo json_encode($datos_ap);

?>
