<script language="javascript">
	$("#pl_vet_form").on('submit', function(evt){
		evt.preventDefault();
		add_vetados();
	});
</script>
<?php
require "../modelo/vetados_modelo.php";
require "../../../../".Leng;

$cliente   = $_POST['cliente'];
$vet   = new Vetado;

$ubicacion = $vet->get_ubic($cliente);

echo '<form id="pl_vet_form" name="pl_vet_form" method="post">
<table width="100%" border="0" align="center">
<tr>
<th>'.$leng["ubicacion"].'</th>
<th>'.$leng["trabajador"].'</th>
<th>Comentario </th>
<th>Eventos</th>
</tr>';
echo '<tr>
</td>
<td><select id="vet_ubicacion" style="width:220px" onchange="getTrab('.$cliente.',this.value)" required>
<option value="">Seleccione...</option>';
foreach ($ubicacion as $datosX){
	echo '<option value="'.$datosX[0].'">('.$datosX[0].') '.$datosX[1].'</option>';
}
echo '<td id="td_vet_ficha"><select id="vet_ficha" style="width:220px" required>
<option value="">Seleccione...</option>';
echo '</td>
<td><textarea id="comentario_add_vetado" required  cols="70" rows="3"></textarea></td>
<td>
<span class="art-button-wrapper">
<span class="art-button-l"> </span>
<span class="art-button-r"> </span>
<input type="submit" name="salvar"  id="salvar" value="Guardar" class="readon art-button" />
</span></td>
<tr>';
echo '</table>
</form>';