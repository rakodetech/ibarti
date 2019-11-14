<?php
require("../modelo/perfiles_modelo.php");

if($_POST['codigo'] != ""){

	$modelo = new novPerfiles;

	$data = $modelo->get($_POST['codigo']);
	$i = 0;

	echo'<table width="90%" align="center" class="tabla_planif">
	<tr>
	<th width="55%"> PERFIL</th>
	<th width="15%">CHECK</th>
	<th width="15%">INGRESO</th>
	<th width="15%">RESPUESTA</th>
	</tr>';

	foreach ($data as  $row03){									  
		$i++;

		if($row03['existe'] != 'NO' && $row03['status'] == 'T'){ 
			$check = 'checked="checked"';
		}else{
			$check = '';	
		}
		if($row03['ingreso'] == 'T'){ 
			$checkI = 'checked="checked"';
		}else{
			$checkI = '';	
		}
		if($row03['respuesta'] == 'T'){ 
			$checkR = 'checked="checked"';
		}else{
			$checkR = '';	
		}

		echo '<tr>
		<td class="etiqueta">'.$row03[1].'</td>
		<td><input type="checkbox" id="check'.$row03[0].'" value="'.$row03[0].'" style="width:auto" '.$check.' onclick="actualizar(\'check\',this.value)"/>
		</td>
		<td><input type="checkbox" id="ingreso'.$row03[0].'" value="'.$row03[0].'" style="width:auto" '.$checkI.' onclick="actualizar(\'ingreso\',this.value)" />
		</td>
		<td><input type="checkbox" id="respuesta'.$row03[0].'" value="'.$row03[0].'" style="width:auto" '.$checkR.' onclick="actualizar(\'respuesta\',this.value)"/>
		</td>
		</tr>';		  		
	}	
	echo'</table>';	 
}else{
	echo '<span>Debe Seleccionar una Clasificacion!.. </span>';
}
?>