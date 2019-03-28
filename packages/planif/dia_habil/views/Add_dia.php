<?php
require "../modelo/dia_habil_modelo.php";
require "../../../../".Leng;
$codigo       = $_POST['codigo'];
$cod_dia_tipo = $_POST['cod_dia_tipo'];

$dh_det = new Dia_habil;
$det_dia    =  $dh_det->dias_det("$codigo", "$cod_dia_tipo");

?>
<table width="100%" align="center">
	<tr>
		<td height="8" colspan="4" align="center"><hr></td>
	</tr>
	<tr>
		<td class="etiqueta" width="15%">Fecha Diaria</td>
		<td class="etiqueta" width="35%" align="left">Apertura</td>
		<td class="etiqueta" width="15%">Fecha Diaria</td>
		<td class="etiqueta" width="35%" align="left">Apertura</td>
	</tr>
	<?php
	$x = 0;
	foreach ($det_dia as  $datos)
	{
		if ($x == 0){
			echo '<tr>
			<td>'.$datos[2].'</td>
			<td><input type="checkbox" name="DIAS[]" value="'.$datos[0].'" style="width:auto" '.CheckX("$datos[0]", "$datos[5]").' /></td>';
			$x = 1;
		}else {
			$x = 0;
			echo '
			<td>'.$datos[2].'</td>
			<td><input type="checkbox" name="DIAS[]" value="'.$datos[0].'" style="width:auto" '.CheckX("$datos[0]", "$datos[5]").' /></td>
			</tr>';
		}
	}
	if($x == 1){
		echo '<tr>';
	}
	?></table>
