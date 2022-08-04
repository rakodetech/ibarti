<?php
include_once "../funciones/funciones.php";
require "../autentificacion/aut_config.inc.php";
require "../".class_bd;
require "../".Leng;
$bd = new DataBase();

//require_once('../autentificacion/aut_config.inc.php');
//include_once('../funciones/mensaje_error.php');

$rol             = $_POST['rol'];
$region          = $_POST['region'];
$estado          = $_POST['estado'];
$cliente         = $_POST['cliente'];
$contrato        = $_POST['contrato'];

$trabajador      = $_POST['trabajador'];


	$where = "  WHERE v_prod_dot_max2.cod_rol = roles.codigo
                  AND v_prod_dot_max2.cod_region = regiones.codigo
                  AND v_prod_dot_max2.cod_contracto = contractos.codigo
                  AND v_prod_dot_max2.cod_cliente = clientes.codigo
                  AND v_prod_dot_max2.cod_linea = prod_lineas.codigo
                  AND v_prod_dot_max2.cod_sub_linea = prod_sub_lineas.codigo
                  AND v_prod_dot_max2.cod_producto = productos.item
	  			  AND v_prod_dot_max2.cod_ficha_status = control.ficha_activo 
	  			  AND productos.cod_talla = tallas.codigo ";



	if($rol != "TODOS"){
		$where .= " AND v_prod_dot_max2.cod_rol = '$rol' ";
	}

	if($region != "TODOS"){
		$where .= " AND v_prod_dot_max2.cod_region = '$region' ";
	}
	if($estado != "TODOS"){
		$where .= " AND v_prod_dot_max2.cod_estado = '$estado' ";
	}
	if($contrato != "TODOS"){
		$where  .= " AND v_prod_dot_max2.cod_contracto = '$contrato' ";
	}
	if($cliente != "TODOS"){
		$where .= " AND v_prod_dot_max2.cod_cliente = '$cliente' ";
	}

	if($trabajador != NULL){
		$where  .= " AND v_prod_dot_max2.cod_ficha = '$trabajador' ";
	}

	// QUERY A MOSTRAR //
	    $sql = "SELECT v_prod_dot_max2.cod_dotacion,
		               v_prod_dot_max2.fecha_max AS fecha, v_prod_dot_max2.cod_ficha,
                       v_prod_dot_max2.ap_nombre AS trabajador, roles.descripcion AS rol,
                       regiones.descripcion AS region,  contractos.descripcion AS contrato,
                       clientes.nombre AS ciente, prod_lineas.descripcion AS linea,
                       prod_sub_lineas.descripcion AS sub_linea, v_prod_dot_max2.cod_producto,
                       CONCAT(productos.descripcion,' ',tallas.descripcion) AS producto, v_prod_dot_max2.cantidad
                  FROM v_prod_dot_max2 , roles, regiones,  contractos,
                       clientes, prod_lineas, prod_sub_lineas, productos,
					   control,tallas
                  $where
				  ORDER BY 3 DESC  ";
?><table width="100%" border="0" align="center">
		<tr class="fondo00">
            <th width="10%" class="etiqueta">Codigo </th>
            <th width="10%" class="etiqueta">Fecha </th>
            <th width="18%" class="etiqueta"><?php echo $leng['rol']?></th>
            <th width="18%" class="etiqueta"><?php echo $leng['ficha']?> </th>
            <th width="18%" class="etiqueta"><?php echo $leng['trabajador']?></th>
            <th width="10%" class="etiqueta">Sub. Linea</th>
            <th width="18%" class="etiqueta">Dotacion </th>
            <th width="8%" class="etiqueta">Cantidad </th>
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
				  <td class="texto">'.$datos["cod_dotacion"].'</td>
				  <td class="texto">'.longitudMin($datos["fecha"]).'</td>
			      <td class="texto">'.longitud($datos["rol"]).'</td>
				  <td class="texto">'.longitudMin($datos["cod_ficha"]).'</td>
				  <td class="texto">'.longitud($datos["trabajador"]).'</td>
				  <td class="texto">'.longitud($datos["sub_linea"]).'</td>
				  <td class="texto">'.$datos["producto"].'</td>
  				  <td class="texto">'.longitud($datos["cantidad"]).'</td>
              </tr>';
        };?>
    </table>
