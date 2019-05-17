<?php
require "../modelo/existencia_modelo.php";
$linea   = $_POST['linea'];
$modelo      = new Existencia;
$sub_lineas = $modelo->get_prod_sub_linea($linea);

echo '<select name="sub_linea" id="prod_sub_linea" style="width:200px" onchange="Actualizar_productos(this.value)">
<option value="TODOS">TODOS</option>';
foreach ($sub_lineas as  $datos)
{
	echo '<option value="'.$datos[0].'">'.$datos[1].'</option>';
}
echo '</select>';
?>
