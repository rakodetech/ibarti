<?php
require "../modelo/planificacion_modelo.php";
require "../../../../".Leng;

$ubic     = $_POST['ubic'];
$cargo     = $_POST['cargo'];
$planif      = new Planificacion;
$apertura = $planif->get_planif_act($ubic, $cargo);

echo '<option value="">Seleccione..</option>';
  foreach ($apertura as  $datos)
  {
    echo '<option value="'.$datos["codigo"].'">'.$datos["fecha_inicio"].' - '.$datos["fecha_fin"].'</option>
    ';
  }
