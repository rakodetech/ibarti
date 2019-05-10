<?php
require "../modelo/movimiento_modelo.php";
require "../../../../".Leng;

$dato    = $_POST['dato'];
$almacen    = $_POST['almacen'];
$mov      = new Movimiento;
$productos = $mov->buscar_productos($dato,$almacen);
echo '<option value="">Seleccione..</option>';
  foreach ($productos as  $datos)
  {
    echo '<option value="'.$datos["item"].'">'.$datos["descripcion"].'</option>';
  }
?>
