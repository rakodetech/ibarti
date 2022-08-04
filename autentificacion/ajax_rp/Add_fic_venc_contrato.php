<?php
include_once "../funciones/funciones.php";
require "../autentificacion/aut_config.inc.php";
require "../".class_bd;
require "../".Leng;
$bd = new DataBase();

$fecha_H         = conversion($_POST['fecha_H']);
$rol             = $_POST['rol'];
$region          = $_POST['region'];
$estado          = $_POST['estado'];
$contrato        = $_POST['contrato'];
$n_contrato      = $_POST['n_contrato'];

$trabajador      = $_POST['trabajador'];

		$where = " WHERE v_ficha.cod_ficha_status = control.ficha_activo
                     AND ficha_n_contracto.vencimiento = 'T'
				     AND v_ficha.cod_n_contracto = ficha_n_contracto.codigo 
				     AND ficha_historial.cod_ficha = v_ficha.cod_ficha
					 AND ficha_historial.cod_n_contrato = ficha_n_contracto.codigo";

	if($region != "TODOS"){
		$where .= " AND v_ficha.cod_region = '$region' ";
	}

	if($estado != "TODOS"){
		$where .= " AND v_ficha.cod_estado = '$estado' ";  // cambie AND asistencia.co_cont = '$contracto'
	}

	if($rol != "TODOS"){
		$where .= " AND v_ficha.cod_rol = '$rol' ";
	}

	if($contrato != "TODOS"){
		$where  .= " AND v_ficha.cod_contracto = '$contrato' ";
	}

	if($n_contrato != "TODOS"){
		$where  .= " AND v_ficha.cod_n_contracto = '$n_contrato' ";
	}

	if($trabajador != NULL){
		$where  .= " AND v_ficha.cod_ficha = '$trabajador' ";
	}
	// QUERY A MOSTRAR //

	$sql = "	SELECT v_ficha.rol,  v_ficha.contracto,
	                   v_ficha.cod_ficha,  v_ficha.cedula,
					   v_ficha.ap_nombre, ficha_n_contracto.descripcion AS n_contrato,
					   v_ficha.fec_ingreso , ADDDATE(v_ficha.fec_ingreso,INTERVAL ficha_n_contracto.dias DAY ) AS fec_vencimiento ,
						((ficha_n_contracto.dias) -(DATEDIFF('$fecha_H',MAX(ficha_historial.fec_inicio)))) AS dias_venc
				  FROM v_ficha, control, ficha_n_contracto, ficha_historial
                $where
                GROUP BY 3
              ORDER BY 2 ASC";

?><table width="100%" border="0" align="center">
		<tr class="fondo00">
            <th width="20%" class="etiqueta"><?php echo $leng['rol']?></th>
            <th width="10%" class="etiqueta"><?php echo $leng['ficha']?></th>
            <th width="26%" class="etiqueta"><?php echo $leng['trabajador']?></th>
    	    <th width="18%" class="etiqueta">N. Contrato</th>
            <th width="14%" class="etiqueta">Fecha Venc. </th>
            <th width="10%" class="etiqueta">Dias. Venc.<br />((+) Ha vencer, <br /> (-) vencidos)</th>


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
				  <td class="texto">'.longitud($datos["ap_nombre"]).'</td>
				  <td class="texto">'.longitud($datos["n_contrato"]).'</td>
				  <td class="texto">'.$datos["fec_vencimiento"].'</td>
				  <td class="texto">'.longitud($datos["dias_venc"]).'</td>
           </tr>';
        };?>
    </table>
