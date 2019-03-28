<?php
require "../modelo/existencia_modelo.php";
$producto   = $_POST['producto'];
$modelo      = new Existencia;
if($producto!=""){
	$almacenes = $modelo->get_prod_almacen_stock($producto);
}else{
	$almacenes = $modelo->get_prod_almacenes();
}

echo '<select name="almacen" id="prod_almacen" style="width:200px">
<option value="TODOS">TODOS</option>';
foreach ($almacenes as  $datos)
{
	echo '<option value="'.$datos[0].'">'.$datos[1].'</option>';
}
echo '</select>';
?>
