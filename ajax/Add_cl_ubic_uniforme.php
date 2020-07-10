<?php
define("SPECIALCONSTANT", true);
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bdI);
require_once("../".Leng);

$bd = new DataBase();
$result = '';
$cargos = array();
$codigo      = $_POST['codigo'];
	   $sql01 ="SELECT clientes_ub_uniforme.cod_sub_linea, prod_sub_lineas.descripcion sub_linea,
	   IFNULL(clientes_ub_uniforme.cod_cargo, '') cod_cargo, IFNULL(cargos.descripcion, 'Seleccione') cargo,  clientes_ub_uniforme.cantidad
	   FROM prod_sub_lineas, clientes_ub_uniforme LEFT JOIN cargos ON clientes_ub_uniforme.cod_cargo = cargos.codigo
	  WHERE clientes_ub_uniforme.cod_sub_linea = prod_sub_lineas.codigo
	  AND clientes_ub_uniforme.cod_cl_ubicacion = '$codigo'";

$sqlcargo =	"SELECT codigo, descripcion FROM cargos WHERE `status` = 'T';";
$querycargo = $bd->consultar($sqlcargo);
while ($datoscargo = $bd->obtener_fila($querycargo)) {
	array_push($cargos, $datoscargo);
} 
?>
<tr>
				<td colspan="4" class="etiqueta_title">Listado</td>
			</tr>
    <?php
		$query = $bd->consultar($sql01);
		$i = 0;
		$valor = 0;
		while ($datos = $bd->obtener_fila($query)) {
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
			$result .= '<tr class="' . $fondo . '">
				  <td>     
                  <input type="text" id="codigo_sub_linea_uniforme'.$i.'" value="'.$datos['sub_linea'].'" disabled  style="width:250px"/>
                  <input type="hidden" name="trabajador" id="stdIDuniforme'.$i.'" value="'.$datos['cod_sub_linea'].'"/>
				</td>
				<td>
				<select style="width:250px" id="codigo_cargo'.$i.'" required>
				<option value="'.$datos["cod_cargo"].'">'.$datos["cargo"].'</option>';

					foreach ($cargos as $key => $value) {
						$result .= '<option value="' . $value[0] . '">' . $value[1] . '</option>';
					} 
				
				$result .= '</select></td>
                <td>
                 <input type="number" id="cantidad_uniforme'.$i.'" style="width:50px"  value="'.$datos['cantidad'].'" min="1">
			   </td>
			   <td><img src="imagenes/actualizar.bmp" alt="Actualizar" title="Actualizar Registro" border="null" width="20px" height="20px" class="imgLink" onclick="ValidarSubmitUniforme('.$modificar.')" />&nbsp;
		  <img src="imagenes/borrar.bmp" alt="Detalle" title="Borrar Registro" width="25" height="25" border="null"
			   onclick="Borrar(' . $borrar . ')" class="imgLink" />
		  </td>
	</tr>';
		}
		
		echo $result;?>