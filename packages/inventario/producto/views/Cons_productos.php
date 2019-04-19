<?php
require "../modelo/producto_modelo.php";
$producto = new Producto;
$prods  =  $producto->inicio_buscar();
$valor = 0;
foreach ($prods as  $datos) {
	if ($valor == 0){
		$fondo = 'fondo01';
		$valor = 1;
	}else{
		$fondo = 'fondo02';
		$valor = 0;
	}
	echo '<tr class="'.$fondo.'" onclick=" Cons_producto(\''.$datos["codigo"].'\', \'modificar\')" title="Click para Modificar.."> 
	<td class="texo">'.longitudMin($datos["codigo"]).'</td>
	<td class="texo">'.longitudMin($datos["item"]).'</td> 
	<td class="texo">'.longitud($datos["descripcion"]).'</td>
	<td class="texo">'.longitudMin($datos["linea"]).'</td>
	<td class="texo">'.longitudMin($datos["sub_linea"]).'</td>
	<td class="texo">'.longitudMin($datos["mov_tipo"]).'</td>
	<td class="texo">'.statuscal($datos["status"]).'</td>
	</tr>';
}
?>
