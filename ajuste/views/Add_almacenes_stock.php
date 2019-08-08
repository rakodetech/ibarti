<?php
require "../modelo/ajuste_modelo.php";
require "../../../../".Leng;

$codigo = $_POST['serial'];
$ajuste      = new Ajuste;
$almacenes = $ajuste->get_almacenes_stock($codigo);

echo '<option value="">Seleccione..</option>';
  foreach ($almacenes as  $datos)
  {
    echo '<option value="'.$datos["codigo"].'">'.$datos["descripcion"].'</option>';
  }
?>
