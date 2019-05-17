<?php
require "../modelo/usuario_menu_modelo.php";
$modelo      = new reporte_usuario_menu;

$clasif = $modelo->get_clasifi();

echo '<select name="clasifi" id="clasifi" style="width:120px">
<option value="TODOS">TODOS</option>';
foreach ($clasif as  $datos)
{
	echo '<option value="'.$datos[0].'">'.$datos[1].'</option>';
}
echo '</select>';
?>
