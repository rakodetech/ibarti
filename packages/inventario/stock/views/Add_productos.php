<?php
require "../modelo/existencia_modelo.php";
$sub_linea   = $_POST['sub_linea'];
$modelo      = new Existencia;
$productos = $modelo->get_prod_productos($sub_linea);

echo '<select name="producto" id="prod_producto" style="width:200px" onchange="Actualizar_almacenes(this.value)">
<option value="TODOS">TODOS</option>';
foreach ($productos as  $datos)
{
	echo '<option value="'.$datos[0].'">'.$datos[1].'</option>';
}
echo '</select>';
?>
