<?php
include_once "../funciones/funciones.php";
require "../autentificacion/aut_config.inc.php";
require "../".class_bd;
require "../".Leng;
$bd = new DataBase();

$rol        = $_POST['rol'];
$region     = $_POST['region'];
$estado     = $_POST['estado'];
$contrato   = $_POST['contrato'];
$cliente    = $_POST['cliente'];
$ubicacion  = $_POST['ubicacion'];
$trabajador = $_POST['trabajador'];

$fecha_D   = conversion($_POST['fecha_desde']);
$fecha_H   = conversion($_POST['fecha_hasta']);

$where = " WHERE pl_trabajador.fecha BETWEEN \"$fecha_D\" AND \"$fecha_H\"
		     AND pl_trabajador.codigo = pl_trabajador_det.cod_pl_trabajador
		     AND pl_trabajador_det.cod_ficha = v_ficha.cod_ficha
			 AND pl_trabajador.cod_turno = turno.codigo
             AND pl_trabajador_det.cod_cliente = clientes.codigo
             AND pl_trabajador_det.cod_ubicacion = clientes_ubicacion.codigo ";

$where1 = " WHERE pl_trab_dl.fecha BETWEEN \"$fecha_D\" AND \"$fecha_H\"
		      AND pl_trab_dl.cod_ficha = v_ficha.cod_ficha
              AND pl_trab_dl.cod_cliente = clientes.codigo
              AND pl_trab_dl.cod_ubicacion = clientes_ubicacion.codigo
              AND pl_trab_dl.cod_turno = turno.codigo ";

$where2 = "WHERE pl_trab_concepto_det.fecha BETWEEN \"$fecha_D\" AND \"$fecha_H\"
             AND pl_trab_concepto.codigo = pl_trab_concepto_det.cod_pl_trab_concepto
		     AND pl_trab_concepto_det.cod_turno = turno.codigo
		     AND pl_trab_concepto_det.cod_ficha  = v_ficha.cod_ficha";

	if($rol != "TODOS"){
		$where .= " AND v_ficha.cod_rol  = '$rol' ";
		$where1 .= " AND v_ficha.cod_rol = '$rol' ";
		$where2 .= " AND v_ficha.cod_rol = '$rol' ";
	}
	if($region != "TODOS"){
		$where  .= " AND v_ficha.cod_region = '$region' ";
		$where1 .= " AND v_ficha.cod_region = '$region' ";
		$where2 .= " AND v_ficha.cod_region = '$region' ";
	}

	if($estado != "TODOS"){
		$where  .= " AND v_ficha.cod_estado = '$estado' ";
		$where1 .= " AND v_ficha.cod_estado = '$estado' ";
		$where2 .= " AND v_ficha.cod_estado = '$estado' ";
	}

	if($contrato != "TODOS"){
		$where   .= " AND v_ficha.cod_contracto = '$contrato' ";
		$where1  .= " AND v_ficha.cod_contracto = '$contrato' ";
		$where2  .= " AND v_ficha.cod_contracto = '$contrato' ";
	}

	if($trabajador != NULL){
		$where   .= " AND  v_ficha.cod_ficha = '$trabajador' ";
		$where1  .= " AND  v_ficha.cod_ficha = '$trabajador' ";
		$where2  .= " AND  v_ficha.cod_ficha = '$trabajador' ";
	}

	if($cliente  != "TODOS"){
		$where   .= " AND pl_trabajador_det.cod_cliente = '$cliente' ";
		$where1  .= " AND pl_trab_dl.cod_cliente = '$cliente' ";
		$where2  .= " AND pl_trab_concepto.cod_cliente = '$cliente'  ";
	}

	if($ubicacion != "TODOS"){
		$where   .= " AND pl_trabajador_det.cod_ubicacion = '$ubicacion' ";
		$where1  .= " AND  pl_trab_dl.cod_ubicacion = '$ubicacion' ";
		$where2  .= " AND pl_trab_concepto.cod_ubicacion = '$ubicacion' ";
	}

 $sql = "SELECT pl_trabajador.fecha, 'PLANIF TRABAJADOR' AS clasif,
                    turno.abrev as detalle,  pl_trabajador_det.cod_ficha,
                    v_ficha.ap_nombre, v_ficha.rol,
			   v_ficha.region,  v_ficha.estado,
               clientes.nombre AS cliente,  clientes_ubicacion.descripcion AS ubicacion,
               v_ficha.contracto, v_ficha.cargo
	      FROM pl_trabajador , pl_trabajador_det, v_ficha, turno, clientes, clientes_ubicacion
		  $where
    UNION ALL
		SELECT pl_trab_dl.fecha,  'PLANIF DL' AS planif_dl,
		       turno.abrev AS turno,  pl_trab_dl.cod_ficha,
		       v_ficha.ap_nombre, v_ficha.rol,
		       v_ficha.region, v_ficha.estado,
               clientes.nombre AS cliente, clientes_ubicacion.descripcion AS ubicacion,
		       v_ficha.contracto, v_ficha.cargo
	      FROM pl_trab_dl, v_ficha, clientes, clientes_ubicacion, turno

	 $where1
UNION ALL

		SELECT pl_trab_concepto_det.fecha, 'conceptos' ,
		       turno.abrev AS detalle,  pl_trab_concepto_det.cod_ficha,
               v_ficha.ap_nombre, v_ficha.rol,
			   v_ficha.region, v_ficha.estado,
               '' AS cliente, '' AS ubicacion,
			   v_ficha.contracto, v_ficha.cargo
		  FROM pl_trab_concepto, pl_trab_concepto_det, turno, v_ficha

		  $where2
  ORDER BY 1, 2 ASC ";

?><table width="100%" border="0" align="center">
		<tr class="fondo00">
  			<th width="8%" class="etiqueta">Fecha</th>
		    <th width="10%" class="etiqueta"><?php echo $leng['ficha']?></th>
            <th width="25%" class="etiqueta"><?php echo $leng['trabajador']?></th>
            <th width="20%" class="etiqueta"><?php echo $leng['cliente']?></th>
            <th width="22%" class="etiqueta"><?php echo $leng['ubicacion']?></th>
             <th width="15%" class="etiqueta">Detalle </th>

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
				  <td class="texto">'.longitud($datos["cod_ficha"]).'</td>
				  <td class="texto">'.longitud($datos["ap_nombre"]).'</td>
				   <td class="texto">'.longitud($datos["cliente"]).'</td>
				  <td class="texto">'.longitud($datos["ubicacion"]).'</td>
				  <td class="texto">'.longitud($datos["detalle"]).'</td>
           </tr>';
        };?>
    </table>
