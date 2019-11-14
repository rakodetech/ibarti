<?php
require "../modelo/usuario_menu_modelo.php";

$modelo      = new reporte_usuario_menu;

$modulos = $modelo->get_perfiles();

echo '<select name="perfil" id="perfil" style="width:120px" onchange="cargarModulos(this.value)">
<option value="TODOS">TODOS</option>';
foreach ($modulos as  $datos)
{
	echo '<option value="'.$datos[0].'">'.$datos[1].'</option>';
}
echo '</select>';
?>
