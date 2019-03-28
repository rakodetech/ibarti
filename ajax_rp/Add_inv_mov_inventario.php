<?php
define("SPECIALCONSTANT", true);
include_once "../funciones/funciones.php";
require "../autentificacion/aut_config.inc.php";
require "../".class_bdI;
require "../".Leng;
$bd = new DataBase();

$fecha_D   = conversion($_POST['fecha_desde']);
$fecha_H   = conversion($_POST['fecha_hasta']);
$almacen   = $_POST['almacen'];
$producto  = $_POST['producto'];
$tipo      = $_POST['tipo'];
$result = array();

$where = " WHERE ajuste_reng.cod_almacen = almacenes.codigo AND ajuste_reng.cod_producto = productos.codigo
AND ajuste.codigo = ajuste_reng.cod_ajuste AND ajuste.cod_tipo = ajuste_tipo.codigo 
AND ajuste.fecha BETWEEN '$fecha_D' AND '$fecha_H' ";

if($almacen != "TODOS"){
	$where .= " AND ajuste_reng.cod_almacen = '$almacen' ";
}

if($producto != "TODOS"){
	$where .= " AND ajuste_reng.cod_producto = '$producto' ";
}

if($tipo != "TODOS"){
	$where .= " AND ajuste.cod_tipo= '$tipo' ";
}

$sql = " SELECT ajuste.fecha,ajuste_tipo.descripcion ajuste,ajuste_tipo.tipo,almacenes.codigo cod_almacen, almacenes.descripcion almacen,productos.codigo cod_producto, productos.descripcion producto,ajuste_reng.cantidad,ajuste_reng.costo,ajuste_reng.neto,
ajuste_reng.cant_acum,ajuste_reng.importe importe_acum,ajuste_reng.cos_promedio 
FROM ajuste,ajuste_reng,ajuste_tipo,almacenes,productos
$where
ORDER BY 1,ajuste.codigo ASC ";

$query = $bd->consultar($sql);
while($rows=$bd->obtener_name($query)){
	$result[] = $rows;
}

// print_r(json_encode($result));
// return json_encode($result);

?>
<table width="100%" border="0" align="center">
	<tr class="fondo00">
		<th width="8%" class="etiqueta">Fecha Hora</th>
		<th width="13%" class="etiqueta">Ajuste</th>
		<th width="13%" class="etiqueta">Almacen</th>
		<th width="18%" class="etiqueta"><?php echo $leng['producto']?></th>
		<th width="8%" class="etiqueta">Cantidad</th>
		<th width="8%" class="etiqueta">Costo</th>
		<th width="8%" class="etiqueta">Neto</th>
		<th width="8%" class="etiqueta">Cant. Acum.</th>
		<th width="8%" class="etiqueta">Importe</th>
		<th width="8%" class="etiqueta">Costo Prom.</th>
	</tr>
	<?php
	$valor = 0;
	$query = $bd->consultar($sql);

	while ($datos=$bd->obtener_fila($query,0)){
		if ($valor == 0){
			$fondo = 'fondo01';
			$valor = 1;
		}else{
			$fondo = 'fondo02';
			$valor = 0;
		}
		echo '<tr class="'.$fondo.'">
		<td class="texto">'.$datos["fecha"].'</td>
		<td class="texto">'.longitud($datos["ajuste"]).'</td>
		<td class="texto">'.longitud($datos["almacen"]).'</td>
		<td class="texto">'.longitud($datos["producto"]).'</td>
		<td class="texto">'.$datos["cantidad"].'</td>
		<td class="texto">'.$datos["costo"].'</td>
		<td class="texto">'.$datos["neto"].'</td>
		<td class="texto">'.$datos["cant_acum"].'</td>
		<td class="texto">'.$datos["importe_acum"].'</td>
		<td class="texto">'.$datos["cos_promedio"].'</td>
		</tr>';
	};?>
</table>
