<?php
require "../modelo/ficha_dotacion_modelo.php";
$linea   = $_POST['linea'];
$sub_linea   = $_POST['sub_linea'];
$modelo      = new FichaDotacion;
$tallas = $modelo->get_tallas($linea,$sub_linea);

echo '<select name="tallas" id="dot_talla" style="width:210px" required>
<option value="">Seleccione...</option>';
foreach ($tallas as  $datos)
{
	echo '<option value="'.$datos[0].'">'.$datos[1].'</option>';
}
echo '</select>';
?>
