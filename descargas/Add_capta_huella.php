<?php
require "../autentificacion/aut_config.inc.php";
include_once "../".Funcion;
require "../".class_bd;
require "../".Leng;

$bd  = new DataBase();

$trabajador   = $_POST['trabajador'];
$cliente      = $_POST['cliente'];
$capta_huella = $_POST['capta_huella'];

$fecha_D    = conversion($_POST['fecha_desde']);
$fecha_H    = conversion($_POST['fecha_hasta']);

$Nmenu      = $_POST['Nmenu'];
$mod        = $_POST['mod'];

	$archivo = "reportes/rp_op_planif_cl_vs_trab_det.php?Nmenu=$Nmenu&mod=$mod";
	$tabla  = "ficha";

	$vinculo     = "inicio.php?area=pestanas/add_$archivo&Nmenu=$Nmenu&mod=$mod";

 	$where       = " WHERE DATE_FORMAT(v_ch_identify.fecha, '%Y-%m-%d') BETWEEN \"$fecha_D\" AND \"$fecha_H\"
                     AND v_ch_identify.cod_dispositivo = clientes_ub_ch.cod_capta_huella
		                 AND clientes_ub_ch.cod_cl_ubicacion = clientes_ubicacion.codigo
		                 AND clientes_ubicacion.cod_cliente = clientes.codigo ";

		 if($cliente != "TODOS"){
	 		$where  .= " AND clientes.codigo =  '$cliente' ";
	 	}

	 	if($capta_huella != "TODOS"){
	 		$where  .= " AND v_ch_identify.cod_dispositivo = '$capta_huella' ";
	 	}

	 	if($trabajador != NULL){
	 		$where  .= " AND ficha.cod_ficha = '$trabajador' ";
	 	}

$sql = "SELECT v_ch_identify.codigo,
									 IFNULL(ficha.cedula, 'SIN CEDULA') cedula ,  IFNULL(ficha.cod_ficha, 'SIN FICHA') cod_ficha,
									 IFNULL(CONCAT(ficha.apellidos,' ',ficha.nombres), v_ch_identify.huella) ap_nombre ,
									 v_ch_identify.cod_dispositivo, clientes_ubicacion.descripcion ubicacion,
									 clientes.nombre cliente, v_ch_identify.fechaserver,
									 v_ch_identify.fecha, v_ch_identify.hora
							FROM v_ch_identify LEFT JOIN ficha ON v_ch_identify.cedula = ficha.cedula AND ficha.cod_ficha_status = 'A',
									 clientes_ub_ch, clientes_ubicacion, clientes
        $where
             ORDER BY fecha DESC ";
	$query = $bd->consultar($sql);

   ?><table width="100%" border="0" align="center">
		<tr class="fondo00">
			<th width="12%" class="etiqueta">Fecha</th>
			<th width="8%" class="etiqueta">Hora</th>
    	<th width="22%" class="etiqueta"><?php echo $leng["cliente"];?></th>
      <th width="24%" class="etiqueta"><?php echo $leng["ubicacion"];?></th>
      <th width="10%" class="etiqueta"><?php echo $leng["ficha"];?></th>
			<th width="24%" class="etiqueta"><?php echo $leng["trabajador"];?></th>

	</tr>
    <?php
	$valor = 0;
		while ($datos=$bd->obtener_fila($query,0)){
	//	if(($cantidad_trab != 0) and ($cantidad_ub != 0)){
			if ($valor == 0){
				$fondo = 'fondo01';
			$valor = 1;
			}else{
				$fondo = 'fondo02';
				$valor = 0;
			}
		// $Modificar = "Add_Mod01('".$datos[0]."', 'modificar')";
		//   $Borrar = "Borrar01('".$datos[0]."')";
			echo '<tr class="'.$fondo.'">
					  <td>'.longitudMin($datos["fecha"]).'</td>
						<td>'.longitudMin($datos["hora"]).'</td>
						<td>'.longitudMin($datos["cliente"]).'</td>
					  <td>'.longitud($datos["ubicacion"]).'</td>
					  <td>'.longitudMin($datos["cod_ficha"]).'</td>
					  <td>'.longitud($datos["ap_nombre"]).'</td>
				</tr>';
		}
      //  }
	//	$bdp->close();
     echo '<input type="hidden" name="tabla" id="tabla" value="'.$tabla.'"/>';
	 mysql_free_result($query);
	?>
    </table>
