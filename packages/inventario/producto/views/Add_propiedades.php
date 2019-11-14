<?php
require "../modelo/producto_modelo.php";
$sub_linea   = $_POST['codigo'];
$modelo      = new Producto;
$propiedades = $modelo->get_propiedades($sub_linea);

print_r(json_encode($propiedades));
return json_encode($propiedades);
?>
