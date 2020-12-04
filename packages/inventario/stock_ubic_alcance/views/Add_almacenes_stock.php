<?php
require "../modelo/stock_ubic_alcance_modelo.php";
require "../../../../".Leng;

$codigo = $_POST['serial'];
$stock_ubic_alcance      = new stock_ubic_alcance;
$almacenes = $stock_ubic_alcance->get_almacenes_stock($codigo);

echo '<option value="">Seleccione..</option>';
  foreach ($almacenes as  $datos)
  {
    echo '<option value="'.$datos["codigo"].'">'.$datos["descripcion"].'</option>';
  }
?>
