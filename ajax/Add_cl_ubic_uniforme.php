<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
require_once("../".Leng);
$bd = new DataBase(); 
$codigo      = $_POST['codigo'];
	   $sql01 ="SELECT clientes_ub_uniforme.cod_sub_linea, prod_sub_lineas.descripcion sub_linea, clientes_ub_uniforme.cantidad
	   FROM clientes_ub_uniforme, prod_sub_lineas
	  WHERE clientes_ub_uniforme.cod_sub_linea = prod_sub_lineas.codigo
	  AND clientes_ub_uniforme.cod_cl_ubicacion = '$codigo'";
?>
<tr>
    <td colspan="2" class="etiqueta_title">Listado</td></tr>
    <?php
		$query = $bd->consultar($sql01);
		$i = 0;
		$valor = 0;
		while ($datos = $bd->obtener_fila($query, 0)) {
			$i++;
			if ($valor == 0) {
				$fondo = 'fondo01';
				$valor = 1;
			} else {
				$fondo = 'fonddo02';
				$valor = 0;
			}
			$modificar = 	 "'" . $i . "', 'modificar'";
			$borrar    = 	 "'" . $i . "', 'eliminar' ";
			echo '<tr class="' . $fondo . '">
				  <td>     
                  <input type="text" id="codigo_sub_linea_uniforme'.$i.'" value="'.$datos['sub_linea'].'" disabled  style="width:450px"/>
                  <input type="hidden" name="trabajador" id="stdIDuniforme'.$i.'" value="'.$datos['cod_sub_linea'].'"/>
                </td>
                <td>
                 <input type="number" id="cantidad_uniforme'.$i.'" style="width:100px"  value="'.$datos['cantidad'].'" min="1">
			   </td>
			   <td align="center"><img src="imagenes/actualizar.bmp" alt="Actualizar" title="Actualizar Registro" border="null" width="20px" height="20px" class="imgLink" onclick="ValidarSubmitUniforme('.$modificar.')" />&nbsp;
		  <img src="imagenes/borrar.bmp" alt="Detalle" title="Borrar Registro" width="25" height="25" border="null"
			   onclick="Borrar(' . $borrar . ')" class="imgLink" />
		  </td>
	</tr>';
        } mysql_free_result($query);?>