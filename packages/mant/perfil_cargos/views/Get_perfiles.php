<?php
require "../modelo/perfil_cargos_modelo.php";

$modelo = new PerfilCargos;

$perfiles = $modelo->get_perfiles();

echo '<select id="perfil" name="perfil" style="width:300px" onchange="Cons_perfil_form(this.value)">
       <option value="">Seleccione...</option>';
foreach ($perfiles as  $datos) {
       echo '<option value="' . $datos[0] . '">' . $datos[1] . '</option>';
}
echo '</select>';
