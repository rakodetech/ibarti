<?php
require "../modelo/producto_modelo.php";
$sub_linea   = $_POST['codigo'];
$modelo      = new Producto;
$sub_lineas = $modelo->get_propiedades($sub_linea);

print_r(json_encode($sub_lineas));
return json_encode($sub_lineas);
?>
