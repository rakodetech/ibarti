<?php
include_once "../funciones/funciones.php";
require "../autentificacion/aut_config.inc.php";
require "../".class_bd;
require "../".Leng;
$bd = new DataBase();

$fecha_D         = conversion($_POST['fecha_desde']);
$fecha_H         = conversion($_POST['fecha_hasta']);

$estado          = $_POST['estado'];
$ciudad          = $_POST['ciudad'];
$cargo           = $_POST['cargo'];
$status          = $_POST['status'];

$trabajador      = $_POST['trabajador'];

	$where = " WHERE v_preingreso.fec_us_ing BETWEEN \"$fecha_D\" AND \"$fecha_H\"  ";

	if($estado != "TODOS"){
		$where .= " AND v_preingreso.cod_estado = '$estado' ";  // cambie AND asistencia.co_cont = '$contracto'
	}

	if($ciudad != "TODOS"){
		$where  .= " AND v_preingreso.cod_ciudad = '$ciudad' ";
	}

	if($cargo != "TODOS"){
		$where  .= " AND v_preingreso.cod_cargo = '$cargo' ";
	}

	if($status != "TODOS"){
		$where .= " AND v_preingreso.cod_status = '$status' ";
	}
	if($trabajador != NULL){
		$where  .= " AND v_preingreso.cedula = '$trabajador' ";
	}
	// QUERY A MOSTRAR //
	    $sql = "SELECT v_preingreso.fec_us_ing,
               		   v_preingreso.estado, v_preingreso.ciudad,
                       v_preingreso.cedula, v_preingreso.ap_nombre,
					   Valores(v_preingreso.refp01_apto) AS refp01_apto , Valores(v_preingreso.refp02_apto) AS refp02_apto,
                       Valores(v_preingreso.refp03_apto) AS refp03_apto, Valores(v_preingreso.refl01_apto) AS refl01_apto,
                       Valores(v_preingreso.refl02_apto) AS refl02_apto, v_preingreso.`status`
                  FROM v_preingreso
					   $where
			  ORDER BY 2 ASC ";
?>
<table width="100%" border="0" align="center">
		<tr class="fondo00">
            <th width="7%" class="etiqueta">Fecha</th>
            <th width="18%" class="etiqueta"><?php echo $leng['estado']?></th>
             <th width="10%" class="etiqueta"><?php echo $leng['ci']?></th>
            <th width="20%" class="etiqueta"><?php echo $leng['trabajador']?></th>
		    <th width="9%" class="etiqueta">REF. PERS. 1</th>
            <th width="9%" class="etiqueta">REF. PERS. 2</th>
            <th width="9%" class="etiqueta">REF. PERS. 3</th>
            <th width="9%" class="etiqueta">REF. LAB. 1</th>
            <th width="9%" class="etiqueta">REF. LAB. 2</th>
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
   				 <td class="texto">'.longitud($datos["fec_us_ing"]).'</td>
				 <td class="texto">'.longitud($datos["estado"]).'</td>
				 <td class="texto">'.$datos["cedula"].'</td>
				 <td class="texto">'.longitud($datos["ap_nombre"]).'</td>
                 <td class="texto">'.$datos["refp01_apto"].'</td>
				 <td class="texto">'.$datos["refp02_apto"].'</td>
				 <td class="texto">'.$datos["refp03_apto"].'</td>
				 <td class="texto">'.$datos["refl01_apto"].'</td>
				 <td class="texto">'.$datos["refl02_apto"].'</td>';
        };?>
    </table>
