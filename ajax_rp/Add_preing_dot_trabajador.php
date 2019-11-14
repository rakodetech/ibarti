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
$cargo          = $_POST['cargo'];
$status          = $_POST['status'];

$trabajador      = $_POST['trabajador'];

	$where = "   WHERE v_preingreso.fec_us_mod BETWEEN \"$fecha_D\" AND \"$fecha_H\"  ";

	if($estado != "TODOS"){
		$where .= " AND v_preingreso.cod_estado = '$estado' ";
	}
	if($ciudad != "TODOS"){
		$where .= " AND v_preingreso.cod_ciudad = '$ciudad' ";
	}

	if($cargo != "TODOS"){
		$where .= " AND v_preingreso.cod_cargo = '$cargo' ";
	}

	if($status != "TODOS"){
		$where .= " AND v_preingreso.cod_status = '$status' ";
	}

	if($trabajador != NULL){
		$where  .= " AND v_preingreso.cedula = '$trabajador' ";
	}


	// QUERY A MOSTRAR //

        $sql = "SELECT v_preingreso.fec_us_mod, v_preingreso.estado,
		               v_preingreso.ciudad, v_preingreso.cargo, v_preingreso.cedula,
					   v_preingreso.ap_nombre AS trabajador, v_preingreso.pantalon,
                       v_preingreso.camisa, v_preingreso.zapato,
                       IFNULL(v_dot_sin_dotacion.fec_ingreso, 'SIN ASIGNAR') AS fec_ingreso,
					   IFNULL(v_dot_sin_dotacion.cod_ficha, 'SIN ASIGNAR') AS cod_ficha,
                       IFNULL(v_dot_sin_dotacion.fec_dotacion, 'SIN DOTACION') AS fec_dotacion,
					   IFNULL(v_dot_sin_dotacion.dotacion, 'SIN DOTACION') AS dotacion,
                       v_preingreso.`status`
                  FROM v_preingreso LEFT JOIN v_dot_sin_dotacion ON v_preingreso.cedula = v_dot_sin_dotacion.cedula
               $where
			  ORDER BY 1 DESC  ";
?>
<table width="100%" border="0" align="center">
		<tr class="fondo00">

            <th width="10%" class="etiqueta">Fecha Ult. Mod.</th>
            <th width="15%" class="etiqueta"><?php echo $leng['estado']?></th>
            <th width="10%" class="etiqueta"><?php echo $leng['ci']?></th>
            <th width="25%" class="etiqueta"><?php echo $leng['trabajador']?></th>
            <th width="10%" class="etiqueta"><?php echo $leng['ficha']?></th>
            <th width="10%" class="etiqueta">Fecha Ingreso </th>
            <th width="10%" class="etiqueta">Fecha Dotacion </th>
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
				  <td class="texto">'.longitud($datos["fec_us_mod"]).'</td>
			      <td class="texto">'.longitudMin($datos["estado"]).'</td>
				  <td class="texto">'.$datos["cedula"].'</td>
				  <td class="texto">'.longitud($datos["trabajador"]).'</td>
				  <td class="texto">'.longitud($datos["cod_ficha"]).'</td>
				  <td class="texto">'.longitud($datos["fec_ingreso"]).'</td>
				  <td class="texto">'.longitud($datos["fec_dotacion"]).'</td>
				  <td class="texto">'.longitudMin($datos["status"]).'</td>
              </tr>';
        };?>
    </table>
