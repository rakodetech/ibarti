<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require "../".class_bd;
require "../".Leng;
require "../bd/class_postgresql.php";
$bd = new DataBase();
$bdp = new DataBaseP();

$rol        = $_POST['rol'];
$cliente    = $_POST['cliente'];
$ubicacion  = $_POST['ubicacion'];
$fecha_D    = conversion($_POST['fecha_desde']);
$fecha_H    = conversion($_POST['fecha_hasta']);

	$where =" WHERE pl_trab_mensual.fecha BETWEEN \"$fecha_D\" AND \"$fecha_H\"
                AND pl_trab_mensual.cod_horario = horarios.codigo
                AND pl_trab_mensual.cod_ficha = ficha.cod_ficha ";

	$where_trab  = " WHERE ficha_huella.cedula = v_ficha.cedula
				       AND v_ficha.cod_ficha_status = control.ficha_activo ";

	$where_ubic  = " WHERE clientes_ub_ch.cod_cl_ubicacion =  clientes_ubicacion.codigo
                       AND  clientes_ubicacion.cod_cliente = clientes.codigo ";

	if($rol != "TODOS"){
		$where .= " AND  ficha.cod_rol = '$rol' ";
		$where_trab .= " AND v_ficha.cod_rol   = '$rol' ";
	}

	if($cliente != "TODOS"){
		$where .= " AND pl_trab_mensual.cod_cliente = '$cliente' ";
		$where_ubic .= " AND clientes.codigo = '$cliente' ";
	}
	if($ubicacion != "TODOS"){
		$where .= " AND  pl_trab_mensual.cod_ubicacion = '$ubicacion' ";
		$where_ubic .= " AND clientes_ubicacion.codigo  = '$ubicacion' ";
	}

 $sql = " SELECT pl_trab_mensual.fecha, horarios.inicio_marc_entrada,
                  horarios.fin_marc_salida,  pl_trab_mensual.cod_ficha,
                  pl_trab_mensual.cod_cliente, pl_trab_mensual.cod_ubicacion,
                  horarios.cod_concepto
             FROM pl_trab_mensual , horarios, ficha
           $where
         ORDER BY 1, 2 ASC ";

   $query = $bd->consultar($sql);
?>
<table width="100%" border="0" align="center">
		<tr class="fondo00">
  			<th width="8%" class="etiqueta">Fecha</th>
            <th width="22%" class="etiqueta"><?php echo $leng['cliente'];?></th>
            <th width="22%" class="etiqueta"><?php echo $leng['ubicacion'];?></th>
            <th width="26%" class="etiqueta"><?php echo $leng['trabajador'];?></th>
 		    <th width="20%" class="etiqueta"><?php echo $leng['concepto'];?></th>
		</tr>
    <?php
	$valor = 0;

   	$sql_pg = " SELECT to_char(ch_inout.fecha_dispositivo, 'DD-MM-YYYY') AS fecha_dispositivo,
	                   to_char(ch_inout.fecha_dispositivo, 'HH:MM:SS') AS hora_dispositivo,
	                   ch_inout.cod_huella,  ch_inout.cod_dispositivo
		          FROM ch_inout
                 WHERE to_char(ch_inout.fecha_dispositivo, 'YYYY-MM-DD') >= '$fecha_D'
				   AND to_char(ch_inout.fecha_dispositivo, 'YYYY-MM-DD') <= '$fecha_H'
		         ORDER BY 1 DESC ";
	$query  = $bdp->consultar($sql_pg) or die ("error pg");

		while($datosPg=$bdp->obtener_fila($query,0)){

		$huella    = $datosPg['cod_huella'];
		$dispotivo = $datosPg['cod_dispositivo'];


		$sql01 = "SELECT COUNT(ficha_huella.huella) AS cantidad_trab, v_ficha.rol,
		                 IFNULL(v_ficha.ap_nombre, '$huella') AS ap_nombre, v_ficha.cod_ficha,
						 v_ficha.cedula
			        FROM ficha_huella, v_ficha, control
						 $where_trab
					 AND ficha_huella.huella = '$huella' ";

		$sql02 = " SELECT COUNT(clientes_ub_ch.cod_capta_huella) AS cantidad_ub,
		                  clientes.nombre AS cliente, clientes_ubicacion.descripcion AS ubicacion,
						  clientes_ub_ch.cod_cl_ubicacion AS cod_ubicacion, clientes_ubicacion.cod_cliente
			         FROM clientes_ub_ch , clientes_ubicacion, clientes
                          $where_ubic
					  AND clientes_ub_ch.cod_capta_huella = '$dispotivo' ";

	   	$query01 = $bd->consultar($sql01);
		$datos = $bd->obtener_fila($query01,0);

	   	$query02 = $bd->consultar($sql02);
		$datos02 = $bd->obtener_fila($query02,0);

		$cantidad_trab = $datos["cantidad_trab"];
		$cantidad_ub   = $datos02["cantidad_ub"];

		if(($cantidad_trab != 0) and ($cantidad_ub != 0)){
/*
		$fecha        = $datosPg['fecha_dispositivo'];
		$hora         = $datosPg['hora_dispositivo'];
		$cod_ficha    = $datos['cod_ficha'];
		$cod_cliente  = $datos02['cod_cliente'];
		$cod_ubicacion= $datos02['cod_ubicacion'];


	    $capta_huella[] = array('fecha'=> $fecha, 'hora'=> $hora, 'cod_ficha'=> $cod_ficha, 'cod_cliente'=> $cod_cliente,
                                'cod_ubicacion'=> $cod_ubicacion);
					echo "hola";
	*/
				}
		}

	  $query = $bd->consultar($sql);
		while ($datos=$bd->obtener_fila($query,0)){

		if(($cantidad_trab != 0) and ($cantidad_ub != 0)){
			if ($valor == 0){
				$fondo = 'fondo01';
			$valor = 1;
			}else{
				$fondo = 'fondo02';
				$valor = 0;
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
        }};?>
    </table>
