<?php
require "../modelo/ficha_dotacion_modelo.php";
$codigo   = $_POST['codigo'];
$modelo      = new FichaDotacion;
$sub_lineas = $modelo->get_sub_lineas($codigo);

echo '<select name="sub_lineas" id="dot_sub_linea" style="width:250px" onchange="get_productos(this.value)" required>
<option value="">Seleccione...</option>';
foreach ($sub_lineas as  $datos)
{
	echo '<option value="'.$datos[0].'">'.$datos[1].'</option>';
}
echo '</select>';
?>
