<?php
require "../modelo/perfiles_modelo.php";

$modelo      = new novPerfiles;

$perfiles = $modelo->get_clasif();

echo '<select id="nov_clasif" name="nov_clasif" style="width:220px" onchange="Cons_perfil_form(this.value)">
       <option value="">Seleccione...</option>';
foreach ($perfiles as  $datos)
{
	echo '<option value="'.$datos[0].'">'.$datos[1].'</option>';
}
echo '</select>';
?>
