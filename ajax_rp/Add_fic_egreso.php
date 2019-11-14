<?php
include_once "../funciones/funciones.php";
require "../autentificacion/aut_config.inc.php";
require "../".class_bd;
require "../".Leng;
$bd = new DataBase();


$fecha_D         = conversion($_POST['fecha_desde']);
$fecha_H         = conversion($_POST['fecha_hasta']);

$rol             = $_POST['rol'];
$region          = $_POST['region'];
$estado          = $_POST['estado'];
$ciudad          = $_POST['ciudad'];
$cargo           = $_POST['cargo'];
$contrato        = $_POST['contrato'];

$status          = $_POST['status'];
$trabajador      = $_POST['trabajador'];


	$where = " WHERE ficha_egreso.fec_egreso BETWEEN \"$fecha_D\" AND \"$fecha_H\"
	             AND v_ficha.cod_ficha = ficha_egreso.cod_ficha ";

	if($rol != "TODOS"){
		$where .= " AND v_ficha.cod_rol = '$rol' ";
	}

	if($region != "TODOS"){
		$where .= " AND v_ficha.cod_region = '$region' ";
	}

	if($estado != "TODOS"){
		$where .= " AND v_ficha.cod_estado = '$estado' ";  // cambie AND asistencia.co_cont = '$contracto'
	}

	if($ciudad != "TODOS"){
		$where  .= " AND v_ficha.cod_ciudad = '$ciudad' ";
	}

	if($cargo != "TODOS"){
		$where  .= " AND v_ficha.cod_cargo = '$cargo' ";
	}

	if($contrato != "TODOS"){
		$where  .= " AND v_ficha.cod_contracto = '$contrato' ";
	}

	if($status != "TODOS"){
		$where .= " AND v_ficha.cod_ficha_status = '$status' ";
	}
	if($trabajador != NULL){
		$where  .= " AND v_ficha.cod_ficha = '$trabajador' ";
	}

	// QUERY A MOSTRAR //
	    $sql = "SELECT v_ficha.rol, v_ficha.region,
                       v_ficha.estado, v_ficha.ciudad,
                       v_ficha.cod_ficha, v_ficha.cedula,
                       v_ficha.ap_nombre, v_ficha.cargo,
                       v_ficha.contracto,  v_ficha.fec_ingreso,
					   ficha_egreso.fec_egreso, ficha_egreso.motivo,
					   ficha_egreso.preaviso, ficha_egreso.fec_inicio,
					   ficha_egreso.fec_culminacion, ficha_egreso.calculo,
					   ficha_egreso.calculo_status, ficha_egreso.fec_calculo,
					   ficha_egreso.fec_posible_pago, ficha_egreso.fec_pago,
					   ficha_egreso.cheque, ficha_egreso.banco,
					   ficha_egreso.importe, ficha_egreso.observacion,
					   ficha_egreso.observacion2, v_ficha.`status`
                  FROM v_ficha , ficha_egreso
                       $where
              ORDER BY ficha_egreso.fec_egreso DESC";

?><table width="100%" border="0" align="center">
		<tr class="fondo00">
            <th width="20%" class="etiqueta"><?php echo $leng['rol']?></th>
            <th width="10%" class="etiqueta"><?php echo $leng['ficha']?></th>
            <th width="10%" class="etiqueta"><?php echo $leng['ci']?></th>
            <th width="20%" class="etiqueta"><?php echo $leng['trabajador']?></th>
    	    <th width="20%" class="etiqueta"><?php echo $leng['contrato']?></th>
      	    <th width="10%" class="etiqueta">Fec. Egreso</th>
            <th width="10%" class="etiqueta">Status</th>
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
			      <td class="texto">'.$datos["rol"].'</td>
				  <td class="texto">'.$datos["cod_ficha"].'</td>
				  <td class="texto">'.$datos["cedula"].'</td>
				  <td class="texto">'.longitud($datos["ap_nombre"]).'</td>
				  <td class="texto">'.longitud($datos["contracto"]).'</td>
				  <td class="texto">'.$datos["fec_egreso"].'</td>
				  <td class="texto">'.$datos["status"].'</td>
           </tr>';
        };?>
    </table>
