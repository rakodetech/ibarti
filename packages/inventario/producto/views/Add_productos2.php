<?php
require "../modelo/producto_modelo.php";
$modelo = new Producto;

$linea      = $_POST['linea'];
$sub_linea  = $_POST['sub_linea'];
$prod_tipo  = $_POST['prod_tipo'];
$tipo_mov   = $_POST['tipo_mov'];
$filtro     = $_POST['filtro'];
$producto    = $_POST['producto']; 

$prods  =  $modelo->get($linea,$sub_linea,$prod_tipo,$tipo_mov,$filtro,$producto);
$valor = 0;
foreach ($prods as  $datos) {
	if ($valor == 0){
		$fondo = 'fondo01';
		$valor = 1;
	}else{
		$fondo = 'fondo02';
		$valor = 0;
	}
	echo '<tr class="'.$fondo.'" onclick="Cons_producto(\''.$datos["item"].'\', \'MODIFICAR\')" title="Click para Modificar.."> 
	<td class="texo">'.longitudMin($datos["codigo"]).'</td> 
									<td class="texo">'.$datos["item"].'</td> 
									<td class="texo">'.longitud($datos["descripcion"]).'</td>
									<td class="texo">'.longitudMin($datos["linea"]).'</td>
									<td class="texo">'.longitudMin($datos["sub_linea"]).'</td>
									<td class="texo">'.longitudMin($datos["mov_tipo"]).'</td>
									<td class="texo">'.statuscal($datos["status"]).'</td> 
									</tr>';
							}     

							?>