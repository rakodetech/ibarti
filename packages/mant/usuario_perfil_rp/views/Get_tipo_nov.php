<?php
require "../modelo/usuario_menu_modelo.php";
$modelo      = new reporte_usuario_menu;

$tipo = $modelo->get_tipo();

echo '<select name="tipos" id="tipos" style="width:120px">
<option value="TODOS">TODOS</option>';
foreach ($tipo as  $datos)
{
	echo '<option value="'.$datos[0].'">'.$datos[1].'</option>';
}
echo '</select>';
?>
