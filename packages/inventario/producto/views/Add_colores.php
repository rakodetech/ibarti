<?php
require "../modelo/producto_modelo.php";
$metodo = $_POST["metodo"];
$modelo      = new Producto;


echo '<select name="color" id="p_color" style="width:250px" required>';
if($metodo == "MODIFICAR"){
	$color = $modelo->get_color($_POST["serial"]);
	echo '<option value="'.$color[0].'">'.$color[1].'</option>';
}else{
	$colores = $modelo->get_colores();
	echo '<option value="">Seleccione...</option>';
	foreach ($colores as  $datos)
	{
		echo '<option value="'.$datos[0].'">'.$datos[1].'</option>';
	}
}


echo '</select>';
?>
