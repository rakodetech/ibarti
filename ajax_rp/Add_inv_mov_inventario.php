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

$where = " WHERE ajuste_reng.cod_almacen = almacenes.codigo AND ajuste_reng.cod_producto = productos.item
AND ajuste.codigo = ajuste_reng.cod_ajuste AND ajuste.cod_tipo = prod_mov_tipo.codigo 
AND prod_sub_lineas.codigo = productos.cod_sub_linea AND tallas.codigo = productos.cod_talla
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

$sql = " SELECT ajuste.fecha,prod_mov_tipo.descripcion ajuste,prod_mov_tipo.tipo_movimiento,almacenes.codigo cod_almacen, almacenes.descripcion almacen,productos.item cod_producto, IF(prod_sub_lineas.talla = 'T', CONCAT(productos.descripcion,' ',tallas.descripcion), productos.descripcion ) producto ,ajuste_reng.cantidad,ajuste_reng.costo,ajuste_reng.neto,
ajuste_reng.cant_acum,ajuste_reng.importe importe_acum,ajuste_reng.cos_promedio ,ajuste_reng.aplicar
FROM ajuste,ajuste_reng,prod_mov_tipo,almacenes,productos,prod_sub_lineas,tallas
$where
ORDER BY ajuste.fecha,ajuste_reng.cod_ajuste, ajuste_reng.reng_num  ASC ";

$query = $bd->consultar($sql);
while($rows=$bd->obtener_name($query)){
	$result[] = $rows;
}

// print_r(json_encode($result));
// return json_encode($result);

?>
<table class="tabla_sistema" width="100%" border="0" align="center">
	<tr>
		<th width="8%" class="etiqueta">Fecha Hora</th>
		<th width="13%" class="etiqueta">Tipo Movimiento</th>
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
		$signo = "";
		if($datos["aplicar"]=="IN"){
			$signo = "+";
		}elseif($datos["aplicar"]=="OUT"){
				$signo = "-";
		}
		echo '<tr>
		<td class="texto">'.$datos["fecha"].'</td>
		<td class="texto">'.longitud($datos["ajuste"]).'</td>
		<td class="texto">'.longitud($datos["almacen"]).'</td>
		<td class="texto">'.$datos["producto"].'</td>
		<td class="texto">'.$signo.''.$datos["cantidad"].'</td>
		<td class="texto">'.$datos["costo"].'</td>
		<td class="texto">'.$datos["neto"].'</td>
		<td class="texto">'.$datos["cant_acum"].'</td>
		<td class="texto">'.$datos["importe_acum"].'</td>
		<td class="texto">'.$datos["cos_promedio"].'</td>
		</tr>';
	};?>
</table>
