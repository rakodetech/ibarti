<?php
include_once "../funciones/funciones.php";
require "../autentificacion/aut_config.inc.php";
require "../".class_bd;
require "../".Leng;
$bd = new DataBase();


$estado          = $_POST['estado'];
$ciudad          = $_POST['ciudad'];
$cargo           = $_POST['cargo'];
$status          = $_POST['status'];

$trabajador      = $_POST['trabajador'];

	$where = " WHERE v_preingreso.cedula = v_preingreso.cedula ";

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
	    $sql = "SELECT v_preingreso.estado, v_preingreso.ciudad,
                       v_preingreso.cedula, v_preingreso.ap_nombre,
					   v_preingreso.`status`
                  FROM v_preingreso
					   $where
			  ORDER BY 2 ASC ";
?>
<table width="100%" border="0" align="center">
		<tr class="fondo00">
            <th width="20%" class="etiqueta"><?php echo $leng['estado']?></th>
            <th width="20%" class="etiqueta"><?php echo $leng['ciudad']?></th>
            <th width="15%" class="etiqueta"><?php echo $leng['ci']?> </th>
            <th width="25%" class="etiqueta">Nombre</th>
		    <th width="10%" class="etiqueta">Status </th>
            <th width="10%" class="etiqueta">Planilla</th>
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
				  <td class="texto">'.longitud($datos["estado"]).'</td>
				  <td class="texto">'.longitud($datos["ciudad"]).'</td>
				  <td class="texto">'.$datos["cedula"].'</td>
				  <td class="texto">'.longitud($datos["ap_nombre"]).'</td>
				  <td class="texto">'.$datos["status"].'</td>
			      <td class="texto"><a href="reportes/rp_fic_control_saime_det.php?reporte=pantalla&codigo='.$datos["cedula"].'"><img class="imgLink" src="imagenes/printer.png"
    border="0" width="22px" height="22px"></a></td>';
        };?>
    </table>
