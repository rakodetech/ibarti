<?php
include_once('../funciones/funciones.php');
require "../autentificacion/aut_config.inc.php";
require "../".class_bd;
require "../".Leng;

$bd = new DataBase();
//require_once('../autentificacion/aut_config.inc.php');
//include_once('../funciones/mensaje_error.php');

$archivo    = "prod_movimiento";
$tabla      = "";

$linea      = $_POST['linea'];
$sub_linea  = $_POST['sub_linea'];
$tipo_mov   = $_POST['tipo_mov'];
$estado     = $_POST['estado'];
$Nmenu      = $_POST['Nmenu'];
$mod        = $_POST['mod'];
$filtro     = $_POST['filtro'];
$producto    = $_POST['producto'];

$vinculo = "inicio.php?area=pestanas/add_$archivo&Nmenu=$Nmenu&mod=$mod&archivo=$archivo";

	$where ="  WHERE prod_movimiento.cod_producto = productos.codigo
                 AND prod_movimiento.cod_cliente = clientes.codigo
                 AND prod_movimiento.cod_ubicacion = clientes_ubicacion.codigo
                 AND clientes_ubicacion.cod_estado = estados.codigo
                 AND prod_movimiento.`status` = 'T'
                 AND prod_movimiento.cod_mov_tipo =  prod_mov_tipo.codigo
                 AND productos.cod_linea = prod_lineas.codigo
                 AND productos.cod_sub_linea = prod_sub_lineas.codigo ";

	if($linea != "TODOS"){
		$where .= " AND prod_lineas.codigo  = '$linea' ";
	}
	if($sub_linea != "TODOS"){
		$where .= "  AND prod_sub_lineas.codigo = '$sub_linea' ";
	}
	if($tipo_mov != "TODOS"){
		$where .= "  AND prod_mov_tipo.codigo = '$tipo_mov' ";
	}

	if($estado != "TODOS"){
		$where .= "  AND estados.codigo = '$estado' ";
	}

	if(($filtro != "TODOS") and ($producto) != ""){
		$where .= "  AND productos.codigo = '$producto' ";
	}

	$sql = "SELECT prod_movimiento.codigo, 
	/*productos.item AS serial,*/
			       prod_movimiento.cod_producto, productos.descripcion AS producto,
		           prod_movimiento.cod_mov_tipo, prod_mov_tipo.descripcion AS mov_tipo,
				    prod_lineas.descripcion AS linea, prod_sub_lineas.descripcion AS sub_linea,
				   clientes_ubicacion.cod_estado, estados.descripcion AS estado,
				   prod_movimiento.cod_cliente, clientes.nombre AS cliente,
				   prod_movimiento.cod_ubicacion, clientes_ubicacion.descripcion AS ubicacion,
				   prod_movimiento.fecha, prod_movimiento.`status`
              FROM prod_movimiento, productos, clientes_ubicacion, clientes, estados,
			       control, prod_mov_tipo,  prod_lineas, prod_sub_lineas
			  $where
		    ORDER BY 2 DESC ";
?><table width="100%" border="0" align="center">
		<tr class="fondo00">
           <th width="8%" class="etiqueta">Codigo</th>
            <th width="8%" class="etiqueta">Fecha</th>
            <th width="10%" class="etiqueta">Producto</th>
			<th width="10%" class="etiqueta">Serial</th>
  			<th width="16%" class="etiqueta"><?php echo $leng['estado'];?></th>
            <th width="20%" class="etiqueta"><?php echo $leng['cliente'];?></th>
             <th width="15%" class="etiqueta">Tipo Movimiento</th>
		    <th width="5%" align="center"><a href="<?php echo $vinculo."&codigo=''&metodo=agregar";?>"><img src="imagenes/nuevo.bmp" alt="Detalle" title="Detalle Registro" width="25px" height="25px" border="null"/></a></th>
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

	// $Modificar = "Add_Mod01('".$datos[0]."', 'modificar')";
	   $Borrar = "Borrar01('".$datos[0]."')";
        echo '<tr class="'.$fondo.'">
  				  <td class="texo">'.longitud($datos["codigo"]).'</td>
				  <td class="texo">'.conversion($datos["fecha"]).'</td>
				  <td class="texo">'.longitudMin($datos["producto"]).'</td>
                  <td class="texo">'.longitudMin($datos["serial"]).'</td>
				  <td class="texo">'.longitudMin($datos["estado"]).'</td>
				  <td class="texo">'.longitudMin($datos["cliente"]).'</td>
				  <td class="texo">'.longitudMin($datos["mov_tipo"]).'</td>
				  <td align="center"><a href="'.$vinculo.'&codigo='.$datos[0].'&metodo=modificar"><img src="imagenes/actualizar.bmp" alt="Modificar" title="Modificar Registro" width="20" height="20" border="null"/></a>&nbsp;<img src="imagenes/borrar.bmp"  width="20px" height="20px" title="Borrar Registro" border="null" onclick="'.$Borrar.'" class="imgLink"/></td>
            </tr>';
        }
     echo '<input type="hidden" name="tabla" id="tabla" value="'.$tabla.'"/>';
	mysql_free_result($query);
	?>
    </table>
