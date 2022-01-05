<?php
require "../modelo/planificacion_modelo.php";
require "../../../../" . Leng;
$apertura   = $_POST['apertura'];
$plan   = new Planificacion;
$resp = $plan->delete_planif_ap($apertura);

echo json_encode($resp);
