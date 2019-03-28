<?php
require "../modelo/producto_modelo.php";
$codigo   = $_POST['codigo'];
$modelo      = new Producto;
$result = array();
$result['data'] = $modelo->get_modelo_det($codigo);
$result['colores']= $modelo->get_colores();


/*
if($modelo_det['color'] == 'T'){
	echo '<tr>
	<td class="etiqueta">Color: </td>
	<td>
	<select name="color" id="color" style="width:250px">';
	foreach ($colores as  $datos) {
		echo '<option value="'.$datos[0].'">'.$datos[1].'</option>';
	}	  
	echo '</select>
	</td>
	</tr>';
}*/
echo json_encode($result);

?>
