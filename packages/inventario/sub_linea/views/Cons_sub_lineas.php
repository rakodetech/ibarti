<?php
require "../modelo/sub_linea_modelo.php";
$modelo = new ProductoSubLinea;
$data = $_POST['data'];
$sub_lineas  =  $modelo->buscar($data);
$valor = 0;
foreach ($sub_lineas as  $datos) {
	echo '<tr class="color" onclick="Form_prod_modelo(\''.$datos["codigo"].'\', \'modificar\')" title="Click para Modificar.."> 
	<td class="texto">'.$datos["codigo"].'</td>
	<td class="texto">'.$datos["linea"].'</td>
	<td class="texto">'.$datos["descripcion"].'</td>
	<td class="texto">'.$datos["status"].'</td>
	</tr>';
}
?>