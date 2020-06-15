<?php
require "../modelo/planificacion_modelo.php";
require "../../../../".Leng;
$cliente   = $_POST['cliente'];
$ubicacion   = $_POST['ubicacion'];
$apertura   = $_POST['apertura'];
$plan   = new Planificacion;
$datos = $plan->cantidad_trab_sin_planif($cliente,$ubicacion,$apertura);
echo json_encode($datos)
?>