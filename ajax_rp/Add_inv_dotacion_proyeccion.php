<?php
include_once "../funciones/funciones.php";
require "../autentificacion/aut_config.inc.php";
require "../".class_bd;
require "../".Leng;
$bd = new DataBase();

$rol          = $_POST['rol'];
$d_proyeccion = $_POST['d_proyeccion'];
$estado       = $_POST['estado'];
$contrato     = $_POST['contrato'];
$linea        = $_POST['linea'];
$sub_linea    = $_POST['sub_linea'];
$cliente    = $_POST['cliente'];
$ubicacion    = $_POST['ubicacion'];
$fecha_desde  = $_POST['fecha_desde'];
$trabajador   = $_POST['trabajador'];
$fecha_D   = conversion($_POST['fecha_desde']);
/* $where = " WHERE DATE_ADD(DATE_FORMAT(v_prod_dot_max2.fecha_max, '%Y-%m-%d'), INTERVAL control.dias_proyeccion DAY) < DATE_ADD('$fecha_D', INTERVAL $d_proyeccion DAY)
			AND v_prod_dot_max2.cod_rol = roles.codigo
			AND v_prod_dot_max2.cod_contracto = contractos.codigo
			AND v_prod_dot_max2.cod_linea = prod_lineas.codigo
			AND v_prod_dot_max2.cod_sub_linea = prod_sub_lineas.codigo
			AND v_prod_dot_max2.cod_producto = productos.item
			AND v_prod_dot_max2.cod_ficha_status = control.ficha_activo 
			AND v_prod_dot_max2.cod_cliente = clientes.codigo
			AND v_prod_dot_max2.cod_ubicacion = clientes_ubicacion.codigo
			AND v_prod_dot_max2.cod_sub_linea = clientes_ub_uniforme.cod_sub_linea
			AND v_prod_dot_max2.cod_ubicacion = clientes_ub_uniforme.cod_cl_ubicacion "; */
	
	$where = " LEFT JOIN v_prod_dot_max2 ON v_prod_dot_max2.cod_sub_linea = clientes_ub_uniforme.cod_sub_linea
	AND v_prod_dot_max2.cod_ubicacion = clientes_ub_uniforme.cod_cl_ubicacion AND v_prod_dot_max2.cod_ficha_status = 'A' ";

	if($rol != "TODOS"){
		$where .= " AND v_prod_dot_max2.cod_rol = '$rol' ";
	}

	if($estado != "TODOS"){
		$where .= " AND v_prod_dot_max2.cod_estado = '$estado' ";
	}

	if($contrato != "TODOS"){
		  $where .= " AND v_prod_dot_max2.cod_contracto = '$contrato' ";
	}

	if($linea != "TODOS"){
		$where .= " AND v_prod_dot_max2.cod_linea = '$linea' ";  // cambie AND asistencia.co_cont = '$contracto'
	}

	if($sub_linea != "TODOS"){
		$where  .= " AND v_prod_dot_max2.cod_sub_linea = '$sub_linea' ";
	}
	
	
	if($cliente != "TODOS"){
		$where  .= " AND v_prod_dot_max2.cod_cliente = '$cliente' ";
	}

	
	if($ubicacion != "TODOS"){
		$where  .= " AND v_prod_dot_max2.cod_ubicacion = '$ubicacion' ";
	}

	if($trabajador != NULL){
		$where  .= " AND v_prod_dot_max2.cod_ficha = '$trabajador' ";
	}

	$where .= " LEFT JOIN roles ON v_prod_dot_max2.cod_rol = roles.codigo
	LEFT JOIN contractos ON v_prod_dot_max2.cod_contracto = contractos.codigo
	LEFT JOIN prod_sub_lineas ON clientes_ub_uniforme.cod_sub_linea = prod_sub_lineas.codigo
	LEFT JOIN prod_lineas ON prod_lineas.codigo = prod_sub_lineas.cod_linea
	LEFT JOIN productos ON v_prod_dot_max2.cod_producto = productos.item AND clientes_ub_uniforme.cod_sub_linea = productos.cod_sub_linea
	INNER JOIN clientes_ubicacion ON clientes_ub_uniforme.cod_cl_ubicacion = clientes_ubicacion.codigo ";
	if($ubicacion != "TODOS"){
		$where  .= " AND clientes_ub_uniforme.cod_cl_ubicacion = '$ubicacion' ";
	}	
	$where  .= " INNER JOIN clientes ON  clientes.codigo = clientes_ubicacion.cod_cliente ";

	if($cliente != "TODOS"){
		$where  .= " AND clientes.codigo = '$cliente' ";
	}
/* 
 $sql = "SELECT v_prod_dot_max2.cod_dotacion, v_prod_dot_max2.fecha_max AS fecha, 
 				v_prod_dot_max2.cod_ficha, v_prod_dot_max2.ap_nombre,
                contractos.descripcion AS contrato, prod_lineas.descripcion AS linea,
                prod_sub_lineas.descripcion AS sub_linea, v_prod_dot_max2.cod_producto,
                productos.descripcion AS producto, v_prod_dot_max2.cantidad,
								clientes.nombre cliente, clientes_ubicacion.descripcion ubicacion
           FROM v_prod_dot_max2 , roles,  contractos, prod_lineas,
		        prod_sub_lineas, productos, control, clientes, clientes_ubicacion, clientes_ub_uniforme
			$where
		   ORDER BY ap_nombre ASC   "; */

 $sql = "SELECT
 IFNULL(v_prod_dot_max2.cod_dotacion, 'SIN DOTAR') cod_dotacion,
 IFNULL(v_prod_dot_max2.fecha_max, 'NO EXISTE') AS fecha,
 IFNULL(v_prod_dot_max2.cod_ficha, 'NO EXISTE') cod_ficha,
 v_prod_dot_max2.ap_nombre,
 contractos.descripcion AS contrato,
 prod_lineas.codigo cod_linea,
 prod_lineas.descripcion AS linea,
 prod_sub_lineas.descripcion AS sub_linea,
 clientes_ub_uniforme.cod_sub_linea,
 v_prod_dot_max2.cod_producto,
 IFNULL(productos.descripcion, 'NO EXISTE') AS producto,
 clientes.codigo cod_cliente,
 clientes.nombre cliente,
clientes_ub_uniforme.cod_cl_ubicacion cod_ubicacion,
 clientes_ubicacion.descripcion ubicacion,
IFNULL(SUM(v_prod_dot_max2.cantidad), 0) cantidad,
clientes_ub_uniforme.cantidad alcance,
(clientes_ub_uniforme.cantidad - IFNULL(SUM(v_prod_dot_max2.cantidad),0) ) diff,
DATE_ADD(DATE_FORMAT(IFNULL(v_prod_dot_max2.fecha_max, '0001-01-01'), '%Y-%m-%d'), INTERVAL control.dias_proyeccion DAY) < DATE_ADD('$fecha_D', INTERVAL $d_proyeccion DAY) vencido
FROM
 clientes_ub_uniforme ".
$where.", 
control
GROUP BY cod_cliente, cod_ubicacion, cod_ficha,cod_linea, cod_sub_linea, cod_producto
HAVING vencido = 1
ORDER BY
 ap_nombre ASC
";
?>
<table width="100%" border="0" align="center">
		<tr class="fondo00">
  			<th width="10%" class="etiqueta">Fecha</th>
            <th width="10%" class="etiqueta"><?php echo $leng['ficha']?></th>
			<th width="15%" class="etiqueta"><?php echo $leng['cliente']?></th>
			<th width="15%" class="etiqueta"><?php echo $leng['ubicacion']?></th>
            <th width="15%" class="etiqueta">Sub Linea</th>
            <th width="20%" class="etiqueta">Producto </th>
            <th width="5%" class="etiqueta">Cant.</th>
			<th width="5%" class="etiqueta">Alc.</th>
			<th width="5%" class="etiqueta">Dif.</th>
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
				  <td class="texto">'.$datos["cod_ficha"].'</td>
				  <td class="texto">'.longitud($datos["cliente"]).'</td>
				  <td class="texto">'.longitud($datos["ubicacion"]).'</td>
				  <td class="texto">'.longitud($datos["sub_linea"]).'</td>
				  <td class="texto">'.longitudMax($datos["producto"]).'</td>
				  <td class="texto">'.$datos["cantidad"].'</td>
				  <td class="texto">'.$datos["alcance"].'</td>
				  <td class="texto">'.$datos["diff"].'</td>
           </tr>';
        };?>
    </table>
