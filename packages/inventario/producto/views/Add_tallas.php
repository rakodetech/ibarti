<?php
require "../modelo/producto_modelo.php";
$metodo = $_POST["metodo"];
$modelo      = new Producto;


echo '<select name="talla" id="p_talla" style="width:250px" required>';
if($metodo == "MODIFICAR"){
	$talla = $modelo->get_talla($_POST["serial"]);
	echo '<option value="'.$talla[0].'">'.$talla[1].'</option>';
}else{
	$tallas = $modelo->get_tallas();
	echo '<option value="">Seleccione...</option>';
	foreach ($tallas as  $datos)
	{
		echo '<option value="'.$datos[0].'">'.$datos[1].'</option>';
	}
}


echo '</select>';
?>
