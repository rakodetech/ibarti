<?php
require "../modelo/ajuste_modelo.php";
require "../../../../".Leng;

$ajuste      = new Ajuste;
$almacenes = $ajuste->get_almacenes();

echo '<option value="">Seleccione..</option>';
  foreach ($almacenes as  $datos)
  {
    echo '<option value="'.$datos["codigo"].'">'.$datos["descripcion"].'</option>';
  }
?>
