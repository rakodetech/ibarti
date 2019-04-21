<?php
require "../modelo/ficha_dotacion_modelo.php";
$linea   = $_POST['linea'];
$sub_linea   = $_POST['sub_linea'];
$modelo      = new FichaDotacion;
$productos = $modelo->get_productos($linea,$sub_linea);

echo '<select name="productos" id="dot_producto" style="width:210px" required>
<option value="">Seleccione...</option>';
foreach ($productos as  $datos)
{
	echo '<option value="'.$datos[0].'">'.$datos[1].'</option>';
}
echo '</select>';
?>
