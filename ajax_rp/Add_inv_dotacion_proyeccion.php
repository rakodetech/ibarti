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
	
$where = " INNER JOIN prod_sub_lineas ON clientes_ub_uniforme.cod_sub_linea = prod_sub_lineas.codigo";

if($sub_linea != "TODOS"){
	$where  .= " AND prod_sub_lineas.codigo = '$sub_linea' ";
}

$where .= " INNER JOIN prod_lineas ON prod_lineas.codigo = prod_sub_lineas.cod_linea";

if($linea != "TODOS"){
	$where .= " AND prod_lineas.codigo = '$linea' ";  // cambie AND asistencia.co_cont = '$contracto'
}

$where .= " INNER JOIN ficha ON ficha.cod_cargo = clientes_ub_uniforme.cod_cargo AND ficha.cod_ficha_status = 'A'";

if($trabajador != NULL){
	$where  .= " AND ficha.cod_ficha = '$trabajador' ";
}

if($rol != "TODOS"){
	$where .= " AND ficha.cod_rol = '$rol' ";
}

$where .= " LEFT JOIN ficha_dotacion ON ficha.cod_ficha = ficha_dotacion.cod_ficha
AND prod_sub_lineas.codigo = ficha_dotacion.cod_sub_linea AND ficha.cod_cargo = clientes_ub_uniforme.cod_cargo
AND clientes_ub_uniforme.cod_sub_linea = ficha_dotacion.cod_sub_linea
INNER JOIN cargos ON clientes_ub_uniforme.cod_cargo = cargos.codigo AND ficha.cod_cargo = cargos.codigo
INNER JOIN clientes_ubicacion ON clientes_ub_uniforme.cod_cl_ubicacion = clientes_ubicacion.codigo
AND ficha.cod_ubicacion = clientes_ubicacion.codigo";

if($ubicacion != "TODOS"){
	$where  .= " AND clientes_ubicacion.codigo = '$ubicacion' ";
}

if($estado != "TODOS"){
	$where .= " AND clientes_ubicacion.cod_estado = '$estado' ";
}

if($cliente != "TODOS"){
	$where  .= " AND clientes_ubicacion.cod_cliente = '$cliente' ";
}

$where .= " INNER JOIN estados ON clientes_ubicacion.cod_estado = estados.codigo ";

if($estado != "TODOS"){
	$where .= " AND estados.codigo = '$estado' ";
}

$where .= " INNER JOIN clientes ON clientes.codigo = clientes_ubicacion.cod_cliente";

if($cliente != "TODOS"){
	$where  .= " AND clientes.codigo = '$cliente' ";
}

$where .= " LEFT JOIN v_prod_dot_max2 ON v_prod_dot_max2.cod_sub_linea = clientes_ub_uniforme.cod_sub_linea
AND v_prod_dot_max2.cod_ficha_status = 'A' AND ficha.cod_ficha = v_prod_dot_max2.cod_ficha
AND v_prod_dot_max2.cod_cargo = clientes_ub_uniforme.cod_cargo AND ficha_dotacion.cod_sub_linea = v_prod_dot_max2.cod_sub_linea
AND v_prod_dot_max2.cod_cargo = ficha.cod_cargo
";

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

$where .= "	LEFT JOIN roles ON v_prod_dot_max2.cod_rol = roles.codigo";

if($rol != "TODOS"){
	$where .= " AND roles.codigo = '$rol' ";
}

$where .= "	INNER JOIN contractos ON  ficha.cod_contracto = contractos.codigo";

if($contrato != "TODOS"){
	$where .= " AND contractos.codigo= '$contrato' ";
}
  
  $where .= " LEFT JOIN productos ON productos.item = v_prod_dot_max2.cod_producto
  LEFT JOIN tallas ON tallas.codigo = ficha_dotacion.cod_talla
  AND productos.cod_talla = tallas.codigo, ";

$sql = "SELECT
IFNULL(
 v_prod_dot_max2.fecha_max,
 'SIN DOTAR'
) AS fecha,
estados.descripcion estado,
clientes.codigo cod_cliente,
clientes.nombre cliente,
clientes_ub_uniforme.cod_cl_ubicacion cod_ubicacion,
clientes_ubicacion.descripcion ubicacion,
contractos.descripcion AS contrato,
IFNULL(
 v_prod_dot_max2.cod_ficha,
 ficha.cod_ficha
) cod_ficha,
IFNULL(
 v_prod_dot_max2.cedula,
 ficha.cedula
) cedula,
IFNULL(
	v_prod_dot_max2.ap_nombre,
 CONCAT(ficha.apellidos, ' ', ficha.nombres)
) ap_nombre,
prod_lineas.codigo cod_linea,
prod_lineas.descripcion AS linea,
clientes_ub_uniforme.cod_sub_linea,
prod_sub_lineas.descripcion AS sub_linea,
IFNULL(
		v_prod_dot_max2.cod_producto,
		prod_sub_lineas.codigo
	) cod_producto,
	IFNULL(
			productos.descripcion,
				CONCAT(prod_sub_lineas.descripcion,
		' ',
		IFNULL(tallas.descripcion, '')
		)
	) producto,
IFNULL(
 SUM(v_prod_dot_max2.cantidad),
 0
) cantidad,
clientes_ub_uniforme.cantidad alcance,
(
 clientes_ub_uniforme.cantidad - IFNULL(
	 SUM(v_prod_dot_max2.cantidad),
	 0
 )
) diff,
(
	IFNULL(
 SUM(v_prod_dot_max2.cantidad),
 0
)+ (
 clientes_ub_uniforme.cantidad - IFNULL(
	 SUM(v_prod_dot_max2.cantidad),
	 0
 )
)
) cant_a_dotar,
DATE_ADD(
 DATE_FORMAT(
	 IFNULL(
		 v_prod_dot_max2.fecha_max,
		 '0001-01-01'
	 ),
	 '%Y-%m-%d'
 ),
 INTERVAL control.dias_proyeccion DAY
) < DATE_ADD(
 '$fecha_D',
 INTERVAL $d_proyeccion DAY
) vencido
FROM
clientes_ub_uniforme
".$where."
control
GROUP BY
cod_cliente,
cod_ubicacion,
cod_ficha,
cod_linea,
cod_sub_linea,
cod_producto
HAVING
vencido = 1
ORDER BY
fecha ASC, ap_nombre ASC, producto ASC
";
echo $sql;
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
			<th width="5%" class="etiqueta">Dotar</th>
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
				  <td class="texto">'.$datos["cant_a_dotar"].'</td>
           </tr>';
        };?>
    </table>
