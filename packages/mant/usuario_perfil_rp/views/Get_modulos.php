<?php
require "../modelo/usuario_menu_modelo.php";
$perfil   = $_POST['perfil'];
$modelo      = new reporte_usuario_menu;

$modulos = $modelo->get_modulos($perfil);

echo '<select name="modulo" id="modulo" style="width:120px">
<option value="TODOS">TODOS</option>';
foreach ($modulos as  $datos)
{
	echo '<option value="'.$datos[0].'">'.$datos[1].'</option>';
}
echo '</select>';
?>
