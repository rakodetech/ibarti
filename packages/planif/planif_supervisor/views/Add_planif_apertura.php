<?php
require "../modelo/planificacion_modelo.php";
require "../../../../".Leng;

$cliente     = $_POST['cliente'];
$planif      = new Planificacion;
$apertura = $planif->get_planif_act($cliente);

echo '<option value="">Seleccione..</option>';
  foreach ($apertura as  $datos)
  {
    echo '<option value="'.$datos["codigo"].'">'.$datos["fecha_inicio"].' - '.$datos["fecha_fin"].'</option>
    ';
  }
?>
