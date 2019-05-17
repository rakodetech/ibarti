<?php
require "../modelo/usuario_menu_modelo.php";
$perfil   = $_POST['perfil'];
$modulo = $_POST['modulo'];
$modelo      = new reporte_usuario_menu;

$seccion = $modelo->get_seccion($perfil,$modulo);

echo '<select name="seccione" id="seccione" style="width:120px">
<option value="TODOS">TODOS</option>';
foreach ($seccion as  $datos)
{
	echo '<option value="'.$datos[0].'">'.$datos[1].'</option>';
}
echo '</select>';
?>
