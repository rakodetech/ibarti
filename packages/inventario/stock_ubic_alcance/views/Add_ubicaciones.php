<?php
require "../modelo/stock_ubic_alcance_modelo.php";
require "../../../../" . Leng;

$stock_ubic_alcance      = new stock_ubic_alcance;
$cliente = $_POST['cliente'];
$ubicaciones = $stock_ubic_alcance->get_ubicaciones($cliente);

echo '<option value="">Seleccione..</option>';
foreach ($ubicaciones as  $datos) {
  echo '<option value="' . $datos["codigo"] . '">' . $datos["descripcion"] . '</option>';
}
