<?php
include_once "../funciones/funciones.php";
require "../autentificacion/aut_config.inc.php";
require "../".class_bd;
require "../".Leng;
$bd = new DataBase();

$fecha_D         = conversion($_POST['fecha_desde']);
$fecha_H         = conversion($_POST['fecha_hasta']);
$cliente         = $_POST['cliente'];
$cargo           = $_POST['cargo'];
$turno           = $_POST['turno'];
		$where = "WHERE pl_cliente.fecha BETWEEN \"$fecha_D\" AND \"$fecha_H\"
				    AND pl_cliente.codigo = pl_cliente_det.cod_pl_cliente
                    AND pl_cliente_det.cod_cliente = clientes.codigo
                    AND pl_cliente_det.cod_ubicacion = clientes_ubicacion.codigo
                    AND pl_cliente_det.cod_cargo = cargos.codigo
                    AND pl_cliente.cod_turno = turno.codigo
                    AND clientes.codigo = clientes_importe.cod_cliente
                    AND clientes_ubicacion.codigo = clientes_importe.cod_ubicacion
                    AND cargos.codigo = clientes_importe.cod_cargo
                    AND turno.codigo = clientes_importe.cod_turno
				    AND clientes_importe.fecha = (SELECT MAX(a.fecha) AS fecha
                                                    FROM clientes_importe AS a
                                                   WHERE a.cod_ubicacion = clientes_importe.cod_ubicacion
                                                     AND a.cod_cliente = clientes_importe.cod_cliente
                                                     AND a.cod_cargo = clientes_importe.cod_cargo
                                                     AND a.cod_turno = clientes_importe.cod_turno)	";

	if($cliente != "TODOS"){
		$where  .= " AND clientes.codigo = '$cliente' ";
	}

	if($cargo  != "TODOS"){
		$where .= " AND cargo.codigo = '$cargo' ";
	}

	if($turno  != "TODOS"){
		$where .= " AND turno.codigo = '$turno' ";
	}

	// QUERY A MOSTRAR //
		$sql = " SELECT clientes.abrev AS cl_abrev, clientes.nombre AS cliente,
                        clientes_ubicacion.descripcion AS ubicacion, cargos.descripcion AS cargo,
                        turno.abrev AS turno_abrev, turno.descripcion AS turno,
                        pl_cliente_det.cantidad, COUNT(pl_cliente_det.cantidad) AS rep,
						clientes_importe.importe, clientes_importe.fecha,
						((pl_cliente_det.cantidad)*(clientes_importe.importe)) AS total
                   FROM pl_cliente , pl_cliente_det, clientes, clientes_ubicacion,
				        cargos, turno , clientes_importe
				 $where
			   GROUP BY clientes.abrev, clientes.nombre,
                        clientes_ubicacion.descripcion, cargos.descripcion,
                        turno.abrev, turno.descripcion
			    ORDER BY clientes_importe.fecha DESC";


		   'SELECT COUNT(pl_cliente_det.cantidad) AS moda, pl_cliente_det.cantidad,
		    pl_cliente_det.cod_ubicacion, pl_cliente_det.cod_cargo, pl_cliente.cod_turno
FROM
pl_cliente, pl_cliente_det
WHERE
pl_cliente.fecha BETWEEN "2014-08-01" AND "2014-08-30"
AND pl_cliente.codigo =  pl_cliente_det.cod_pl_cliente
and pl_cliente_det.cod_cliente = "0001"
GROUP BY pl_cliente_det.cod_ubicacion, pl_cliente_det.cod_cargo, pl_cliente.cod_turno
ORDER BY moda DESC';
?><table width="100%" border="0" align="center">
   <tr class="fondo00">
            <th width="15%" class="etiqueta"><?php echo $leng['cliente'];?></th>
            <th width="20%" class="etiqueta"><?php echo $leng['ubicacion'];?></th>
            <th width="20%" class="etiqueta">Cargo</th>
		    <th width="15%" class="etiqueta">Turno </th>
            <th width="10%" class="etiqueta">Cantidad </th>
            <th width="10%" class="etiqueta">Importe </th>
            <th width="10%" class="etiqueta">Total </th>
		</tr><?php
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
				  <td class="texto">'.$datos["cl_abrev"].'</td>
				  <td class="texto">'.longitud($datos["ubicacion"]).'</td>
				  <td class="texto">'.longitud($datos["cargo"]).'</td>
				  <td class="texto">'.$datos["turno_abrev"].'</td>
				  <td class="texto">'.$datos["cantidad"].'</td>
				  <td class="texto">'.$datos["importe"].'</td>
				  <td class="texto">'.$datos["total"].'</td>
				  </ tr>';};?>
                  </table>
