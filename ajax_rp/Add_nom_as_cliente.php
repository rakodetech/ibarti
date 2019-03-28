<?php
include_once "../funciones/funciones.php";
require "../autentificacion/aut_config.inc.php";
require "../".class_bd;
require "../".Leng;
$bd = new DataBase();

$fecha_D         = conversion($_POST['fecha_desde']);
$fecha_H         = conversion($_POST['fecha_hasta']);

$region          = $_POST['region'];
$estado          = $_POST['estado'];
$ciudad          = $_POST['ciudad'];
$cliente         = $_POST['cliente'];

		$where = " WHERE asistencia_apertura.fec_diaria BETWEEN \"$fecha_D\" AND \"$fecha_H\"
                     AND asistencia_apertura.codigo = v_asistencia.cod_as_apertura
                     AND v_asistencia.cod_ubicacion =  v_cliente_ubic.cod_ubicacion
                     AND v_asistencia.cod_cliente = v_cliente_ubic.cod_cliente";

	if($region != "TODOS"){
		$where .= " AND v_cliente_ubic.cod_region = '$region' ";
	}

	if($estado != "TODOS"){
		$where .= " AND v_cliente_ubic.cod_estado = '$estado' ";  // cambie AND asistencia.co_cont = '$contracto'
	}

	if($ciudad != "TODOS"){
		$where  .= " AND v_cliente_ubic.cod_ciudad = '$ciudad' ";
	}

	if($cliente != "TODOS"){
		$where  .= " AND v_cliente_ubic.cod_cliente = '$cliente' ";
	}

	// QUERY A MOSTRAR //
    	$sql = "SELECT asistencia_apertura.fec_diaria, v_cliente_ubic.region,
                       v_cliente_ubic.estado, v_cliente_ubic.ciudad,
                       v_cliente_ubic.cliente,
                       Sum(v_asistencia.valor) AS valor
                  FROM asistencia_apertura, v_asistencia , v_cliente_ubic
                $where
              GROUP BY asistencia_apertura.fec_diaria, v_cliente_ubic.region,
                       v_cliente_ubic.estado, v_cliente_ubic.ciudad,
                       v_cliente_ubic.cliente
                 UNION
                SELECT CURDATE(), '', '', '', 'TOTAL',
                       Sum(v_asistencia.valor) AS valor
                  FROM asistencia_apertura, v_asistencia , v_cliente_ubic
                $where
              ORDER BY 1 ASC";
?><table width="100%" border="0" align="center">
		<tr class="fondo00">
  			<th width="10%" class="etiqueta">Fecha</th>
            <th width="20%" class="etiqueta"><?php echo $leng['region']?></th>
		    <th width="20%" class="etiqueta"><?php echo $leng['estado']?></th>
            <th width="20%" class="etiqueta"><?php echo $leng['ciudad']?></th>
            <th width="20%" class="etiqueta"><?php echo $leng['cliente']?></th>
            <th width="10%" class="etiqueta">Valor </th>
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
			      <td class="texto">'.$datos["fec_diaria"].'</td>
				  <td class="texto">'.longitud($datos["region"]).'</td>
				  <td class="texto">'.longitud($datos["estado"]).'</td>
				  <td class="texto">'.longitud($datos["ciudad"]).'</td>
				  <td class="texto">'.longitud($datos["cliente"]).'</td>
				  <td class="texto">'.longitud($datos["valor"]).'</td>
           </tr>';
        };?>
    </table>
