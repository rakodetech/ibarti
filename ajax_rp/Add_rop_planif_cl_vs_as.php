<?php
include_once "../funciones/funciones.php";
require "../autentificacion/aut_config.inc.php";
require "../".class_bd;
require "../".Leng;
$bd = new DataBase();


$region     = $_POST['region'];
$estado     = $_POST['estado'];
$cliente    = $_POST['cliente'];
$ubicacion  = $_POST['ubicacion'];
$fecha_D    = conversion($_POST['fecha_desde']);
$fecha_H    = conversion($_POST['fecha_hasta']);

	$where =" WHERE v_pl_ubic_concepto.fecha BETWEEN \"$fecha_D\" AND \"$fecha_H\"
                AND v_pl_ubic_concepto.cod_ubicacion = v_cliente_ubic.cod_ubicacion ";

	if($region != "TODOS"){
		$where .= " AND  v_cliente_ubic.cod_region = '$region' ";
	}
	if($estado != "TODOS"){
		$where .= " AND v_cliente_ubic.cod_estado = '$estado' ";
	}
	if($cliente != "TODOS"){
		$where .= " AND v_cliente_ubic.cod_cliente = '$cliente' ";
	}
	if($ubicacion != "TODOS"){
		$where .= " AND v_pl_ubic_concepto.cod_ubicacion = '$ubicacion' ";
	}

 	$sql = " SELECT v_pl_ubic_concepto.fecha, v_cliente_ubic.region,
				 v_cliente_ubic.estado, v_cliente_ubic.ciudad,
				 v_cliente_ubic.cliente,  v_cliente_ubic.ubicacion,
				 v_pl_ubic_concepto.valor_pl,  IFNULL( v_as_ubic_concepto.valor_as, 0 ) AS valor_as,
				 ((IFNULL( v_as_ubic_concepto.valor_as, 0 )) - v_pl_ubic_concepto.valor_pl) AS factor
	        FROM v_pl_ubic_concepto LEFT JOIN v_as_ubic_concepto
		                          ON v_pl_ubic_concepto.fecha = v_as_ubic_concepto.fec_diaria
                                  AND v_pl_ubic_concepto.cod_ubicacion = v_as_ubic_concepto.cod_ubicacion,
                  v_cliente_ubic
           $where
         ORDER BY 1 ASC ";

?>
<table width="100%" border="0" align="center">
		<tr class="fondo00">
  			<th width="8%" class="etiqueta">Fecha</th>
            <th width="22%" class="etiqueta"><?php echo $leng['estado'];?></th>
            <th width="30%" class="etiqueta"><?php echo $leng['cliente'];?></th>
            <th width="30%" class="etiqueta"><?php echo $leng['ubicacion'];?></th>
		    <th width="10%" class="etiqueta">Factor</th>
		</tr>
    <?php
	$valor = 0;
   $query = $bd->consultar($sql);

		while ($datos=$bd->obtener_fila($query,0)){
			$factor = $datos["factor"];

		if($factor == 0){
			$fondo = 'fondo01';
			$factor = 'OK';
		}elseif($factor > 0){
			$fondo = 'fondo02';
		}else{
			$fondo = 'fondo03';
		}

	// $Modificar = "Add_Mod01('".$datos[0]."', 'modificar')";
	   $Borrar = "Borrar01('".$datos[0]."')";
        echo '<tr class="'.$fondo.'">
			      <td class="texto">'.$datos["fecha"].'</td>
				  <td class="texto">'.longitud($datos["estado"]).'</td>
				  <td class="texto">'.longitud($datos["cliente"]).'</td>
				  <td class="texto">'.longitud($datos["ubicacion"]).'</td>
				  <td class="texto">'.$factor.'</td>
            </tr>';
        };?>
    </table>
