<?php
require "../modelo/producto_modelo.php";
$modelo      = new Producto;
$colores = $modelo->get_colores();

echo '<select name="color" id="p_color" style="width:250px" required>
<option value="">Seleccione...</option>';
foreach ($colores as  $datos)
{
	echo '<option value="'.$datos[0].'">'.$datos[1].'</option>';
}
echo '</select>';
?>
