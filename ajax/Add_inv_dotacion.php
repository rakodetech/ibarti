<?php
include_once "../funciones/funciones.php";
require "../autentificacion/aut_config.inc.php";
require "../".class_bd;
require "../".Leng;
$bd = new DataBase();

$rol        = $_POST['rol'];
$linea      = $_POST['linea'];
$sub_linea  = $_POST['sub_linea'];
$producto   = $_POST['producto'];
$anulado    = $_POST['anulado'];
$trabajador = $_POST['trabajador'];

$fecha_D   = conversion($_POST['fecha_desde']);
$fecha_H   = conversion($_POST['fecha_hasta']);

	$where = "  WHERE DATE_FORMAT(prod_dotacion.fec_dotacion, '%Y-%m-%d') BETWEEN  \"$fecha_D\" AND \"$fecha_H\"
   	              AND prod_dotacion.codigo = prod_dotacion_det.cod_dotacion
			      AND prod_dotacion_det.cod_producto = productos.item
			      AND productos.cod_linea = prod_lineas.codigo
			      AND productos.cod_sub_linea = prod_sub_lineas.codigo
			      AND v_ficha.cod_ficha = prod_dotacion.cod_ficha ";

	if($rol != "TODOS"){
		$where .= " AND v_ficha.cod_rol = '$rol' ";
	}

	if($linea != "TODOS"){
		$where .= " AND prod_lineas.codigo = '$linea' ";  // cambie AND asistencia.co_cont = '$contracto'
	}

	if($sub_linea != "TODOS"){
		$where  .= " AND prod_sub_lineas.codigo = '$sub_linea' ";
	}
	if($producto != "TODOS"){
		$where  .= " AND productos.item  = '$producto' ";
	}

	if($anulado != "TODOS"){
		$where  .= " AND  prod_dotacion.anulado  = '$anulado' ";
	}

	if($trabajador != NULL){
		$where  .= " AND v_ficha.cod_ficha = '$trabajador' ";
	}

 $sql = " SELECT prod_dotacion.codigo, prod_dotacion.fec_dotacion,
                 v_ficha.rol, v_ficha.cod_ficha,
                 v_ficha.cedula, v_ficha.nombres AS trabajador,
                 prod_dotacion.descripcion, prod_lineas.descripcion AS linea,
                 prod_sub_lineas.descripcion AS sub_linea, CONCAT(productos.descripcion,' (',productos.item,') ') AS producto,
                 prod_dotacion_det.cantidad
            FROM prod_dotacion , prod_dotacion_det , productos , prod_lineas ,
                 prod_sub_lineas, v_ficha
          $where
        ORDER BY 2 ASC ";

?>
<table width="100%" border="0" align="center">
		<tr class="fondo00">
  			<th width="9%" class="etiqueta">Codigo</th>
            <th width="8%" class="etiqueta">Fecha</th>
            <th width="10%" class="etiqueta"><?php echo $leng['ficha']?></th>
            <th width="20%" class="etiqueta"><?php echo $leng['rol']?></th>
            <th width="24%" class="etiqueta">Sub Linea</th>
            <th width="24%" class="etiqueta">Producto </th>
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
			      <td class="texto">'.$datos["codigo"].'</td>
			      <td class="texto">'.$datos["fec_dotacion"].'</td>
				  <td class="texto">'.$datos["cod_ficha"].'</td>
				  <td class="texto">'.longitud($datos["rol"]).'</td>
				  <td class="texto">'.longitud($datos["sub_linea"]).'</td>
				  <td class="texto">'.$datos["producto"].'</td>
				  <td class="texto">'.$datos["cantidad"].'</td>
           </tr>';
        };?>
    </table>
