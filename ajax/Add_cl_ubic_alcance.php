<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
require_once("../".Leng);
$bd = new DataBase(); 
$codigo      = $_POST['codigo'];
	   $sql01 ="SELECT clientes_ub_alcance.cod_producto, productos.descripcion producto, clientes_ub_alcance.cantidad
              FROM clientes_ub_alcance, productos WHERE clientes_ub_alcance.cod_producto = productos.item 
              AND clientes_ub_alcance.cod_cl_ubicacion = '$codigo'";
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
              <input type="text" id="codigo_producto'.$i.'" value="'.$datos['producto'].'" disabled  style="width:450px"/>
              <input type="hidden" name="trabajador" id="stdID'.$i.'" value="'.$datos['cod_producto'].'"/>
            </td>
            <td>
             <input type="number" id="cantidad'.$i.'" style="width:100px"  value="'.$datos['cantidad'].'" min="1">
     </td><td align="center"><img src="imagenes/actualizar.bmp" alt="Actualizar" title="Actualizar Registro" border="null" width="20px" height="20px" class="imgLink" onclick="ValidarSubmit('.$modificar.')" />&nbsp;
  <img src="imagenes/borrar.bmp" alt="Detalle" title="Borrar Registro" width="25" height="25" border="null"
     onclick="Borrar(' . $borrar . ')" class="imgLink" />
  </td>
</tr>';
        } mysql_free_result($query);?>