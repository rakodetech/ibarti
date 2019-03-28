<?php
require "../modelo/producto_modelo.php";
$codigo   = $_POST['codigo'];
$modelo      = new Producto;
$sub_lineas = $modelo->get_sub_lineas($codigo);

echo '<select name="sub_linea" id="p_sub_linea" style="width:250px" onchange="get_modelos(this.value)" required>
<option value="">Seleccione...</option>';
foreach ($sub_lineas as  $datos)
{
	echo '<option value="'.$datos[0].'">'.$datos[1].'</option>';
}
echo '</select>';
?>
