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
$fecha_desde  = $_POST['fecha_desde'];
$trabajador   = $_POST['trabajador'];

$fecha_D   = conversion($_POST['fecha_desde']);

$where = "  WHERE DATE_ADD(DATE_FORMAT(v_prod_dot_max2.fecha_max, '%Y-%m-%d'), INTERVAL control.dias_proyeccion DAY) < DATE_ADD('$fecha_D', INTERVAL '$d_proyeccion' DAY)
              AND v_prod_dot_max2.cod_rol = roles.codigo
              AND v_prod_dot_max2.cod_contracto = contractos.codigo
              AND v_prod_dot_max2.cod_linea = prod_lineas.codigo
              AND v_prod_dot_max2.cod_sub_linea = prod_sub_lineas.codigo
              AND v_prod_dot_max2.cod_producto = productos.codigo
			  AND v_prod_dot_max2.cod_ficha_status = control.ficha_activo  ";



/*
	$where = " WHERE DATE_ADD(v_dot_sub_linea.fecha_max, INTERVAL '$d_proyeccion' DAY) <= '$fecha_D'
		         AND v_dot_sub_linea.cod_ficha = ficha.cod_ficha
                 AND ficha.cod_ficha_status = control.ficha_activo
                 AND ficha.cod_ficha = trab_roles.cod_ficha
                 AND trab_roles.cod_rol = roles.codigo
                 AND v_dot_sub_linea.cod_ficha = prod_dotacion.cod_ficha
                 AND v_dot_sub_linea.fecha_max = prod_dotacion.fec_dotacion
                 AND prod_dotacion.codigo = prod_dotacion_det.cod_dotacion
                 AND prod_dotacion_det.cod_sub_linea = v_dot_sub_linea.cod_sub_linea
                 AND v_dot_sub_linea.cod_linea = prod_lineas.codigo
                 AND v_dot_sub_linea.cod_sub_linea = prod_sub_lineas.codigo
                 AND prod_dotacion_det.cod_producto = productos.codigo ";



 $sql = "SELECT v_dot_sub_linea.fecha_max AS fec_dotacion,  roles.descripcion AS rol,
                v_dot_sub_linea.cod_ficha,  ficha.cedula,
				CONCAT(ficha.apellidos, ficha.nombres) AS ap_nombre,  prod_lineas.descripcion AS linea,
                prod_sub_lineas.descripcion AS sub_linea, prod_dotacion_det.cod_producto,
                productos.descripcion AS producto,  prod_dotacion_det.cantidad
           FROM v_dot_sub_linea, ficha, control, prod_dotacion,
		        trab_roles, roles, prod_dotacion_det, productos,
				prod_lineas, prod_sub_lineas
                $where
	   ORDER BY ap_nombre ASC  ";
*/
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

	if($trabajador != NULL){
		$where  .= " AND v_prod_dot_max2.cod_ficha = '$trabajador' ";
	}


 $sql = "SELECT v_prod_dot_max2.cod_dotacion,
                v_prod_dot_max2.fecha_max AS fecha, v_prod_dot_max2.cod_ficha,
                v_prod_dot_max2.ap_nombre, roles.descripcion AS rol,
                contractos.descripcion AS contrato, prod_lineas.descripcion AS linea,
                prod_sub_lineas.descripcion AS sub_linea, v_prod_dot_max2.cod_producto,
                productos.descripcion AS producto, v_prod_dot_max2.cantidad
           FROM v_prod_dot_max2 , roles,  contractos, prod_lineas,
		        prod_sub_lineas, productos, control
          $where
	       ORDER BY ap_nombre ASC  ";
?>
<table width="100%" border="0" align="center">
		<tr class="fondo00">
  			<th width="10%" class="etiqueta">Fecha</th>
            <th width="10%" class="etiqueta"><?php echo $leng['ficha']?></th>
            <th width="20%" class="etiqueta"><?php echo $leng['rol']?></th>
            <th width="25%" class="etiqueta">Sub Linea</th>
            <th width="30%" class="etiqueta">Producto </th>
            <th width="5%" class="etiqueta">Cantidad</th>
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
				  <td class="texto">'.longitud($datos["rol"]).'</td>
				  <td class="texto">'.longitud($datos["sub_linea"]).'</td>
				  <td class="texto">'.longitudMax($datos["producto"]).'</td>
				  <td class="texto">'.$datos["cantidad"].'</td>
           </tr>';
        };?>
    </table>
