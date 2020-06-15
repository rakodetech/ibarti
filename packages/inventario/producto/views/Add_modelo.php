<?php
require "../modelo/producto_modelo.php";
$codigo   = $_POST['codigo'];
$modelo      = new Producto;
$modelos = $modelo->get_modelos($codigo);

echo '<select name="modelo" id="p_modelo" style="width:250px" onchange="get_modelos_det(this.value)">
<option value="">Seleccione...</option>';
foreach ($modelos as  $datos)
{
	echo '<option value="'.$datos[0].'">'.$datos[1].'</option>';
}
echo '</select>';
?>
