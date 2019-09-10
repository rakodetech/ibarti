<?php
require "../modelo/producto_modelo.php";
require "../../../../".Leng;
$ajuste = new Producto;
$codigo = $_POST['codigo'];
$reng   = $ajuste->get_eans($codigo);
print_r(json_encode($reng));
return json_encode($reng);
?>
