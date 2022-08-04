<?php
include_once "../funciones/funciones.php";
require "../autentificacion/aut_config.inc.php";
require "../".class_bd;
require "../".Leng;
$bd = new DataBase();


$producto   = $_POST['producto'];
$linea      = $_POST['linea'];
$sub_linea  = $_POST['sub_linea'];
$tipo_mov   = $_POST['tipo_mov'];
// $estado     = $_POST['estado'];
$cliente    = $_POST['cliente'];
$ubicacion  = $_POST['ubicacion'];


$fecha_D   = conversion($_POST['fecha_desde']);
$fecha_H   = conversion($_POST['fecha_hasta']);

$where = " WHERE prod_movimiento.fecha BETWEEN \"$fecha_D\" AND \"$fecha_H\"
	             AND prod_movimiento.cod_producto = productos.codigo
                 AND prod_movimiento.cod_cliente = clientes.codigo
                 AND prod_movimiento.cod_ubicacion = clientes_ubicacion.codigo
                 AND clientes_ubicacion.cod_estado = estados.codigo
                 AND prod_movimiento.`status` = 'T'
                 AND prod_movimiento.cod_mov_tipo =  prod_mov_tipo.codigo
                 AND productos.cod_linea = prod_lineas.codigo
                 AND productos.cod_sub_linea = prod_sub_lineas.codigo
                 AND prod_movimiento.cod_ficha = ficha.cod_ficha
                 AND ficha.cedula = preingreso.cedula ";

	if($producto != "TODOS"){
		$where .= " AND productos.codigo  = '$producto' ";
	}
	if($linea != "TODOS"){
		$where .= " AND prod_lineas.codigo  = '$linea' ";
	}
	if($sub_linea != "TODOS"){
		$where .= "  AND prod_sub_lineas.codigo = '$sub_linea' ";
	}
	if($tipo_mov != "TODOS"){
		$where .= "  AND prod_mov_tipo.codigo = '$tipo_mov' ";
	}

	if($cliente != "TODOS"){
		$where .= "  AND clientes.codigo = '$cliente' ";
	}

	if($ubicacion != "TODOS"){
		$where .= "  AND clientes_ubicacion.codigo = '$ubicacion'";
	}



 $sql = " SELECT CONCAT(prod_movimiento.fecha,' ',prod_movimiento.hora) AS fecha,  prod_movimiento.cod_producto,
                 productos.item AS serial, productos.descripcion AS producto,
                 prod_mov_tipo.descripcion AS mov_tipo, prod_lineas.descripcion AS linea,
				 prod_sub_lineas.descripcion AS sub_linea, productos.campo01 AS n_porte,
				 productos.campo02 AS fec_venc_permiso, estados.descripcion AS estado,
         preingreso.cedula, CONCAT(preingreso.apellidos,' ',preingreso.nombres) AS trabajador,
				 clientes.nombre AS cliente, clientes_ubicacion.descripcion AS ubicacion,
				 prod_movimiento.observacion, prod_movimiento.`status`
            FROM prod_movimiento, productos, clientes_ubicacion, clientes, estados,
			     control, prod_mov_tipo,  prod_lineas, prod_sub_lineas, ficha, preingreso
			     $where
		   ORDER BY 2 DESC ";

?>
<table width="100%" border="0" align="center">
		<tr class="fondo00">
			<th width="10%" class="etiqueta">Fecha</th>
            <th width="25%" class="etiqueta">Producto</th>
			<th width="10%" class="etiqueta">Serial</th>
  			<th width="20%" class="etiqueta">Linea</th>
            <th width="20%" class="etiqueta"><?php echo $leng['cliente']?></th>
            <th width="15%" class="etiqueta">Tipo Movimiento</th>
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
                  <td class="texo">'.conversion($datos["fecha"]).'</td>
                  <td class="texo">'.longitud($datos["producto"]).'</td>
				  <td class="texo">'.longitud($datos["serial"]).'</td>
				  <td class="texo">'.longitud($datos["linea"]).'</td>
				  <td class="texo">'.longitud($datos["cliente"]).'</td>
				  <td class="texo">'.longitud($datos["mov_tipo"]).'</td>
           </tr>';
        };?>
    </table>
