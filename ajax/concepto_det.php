<?php
include_once '../funciones/funciones.php';
require "../autentificacion/aut_config.inc.php";
require "../".class_bd;
require "../".Leng;

$bd = new DataBase();
	$codigo    = $_POST['codigo'];
	$rol    = $_POST['rol'];
	//$usuario   = $_POST['usuario'];
	$categoria = $_POST['categoria'];

		echo '<table width="75%" border="0" align="center">
			<tr>
				<td width="65%" class="etiqueta">'.$leng["concepto"].':</td>
				<td width="20%" class="etiqueta">CANTIDAD:</td>
				<td width="15%" class="etiqueta">CHECK:</td>
			</tr>';
		 $sql02    = "SELECT conceptos.codigo AS cod_concepto, conceptos.descripcion
					    FROM conceptos WHERE conceptos.`status` = 'T'";
		 $query = $bd->consultar($sql02);
		$valor = 0;
		while($row02=$bd->obtener_fila($query,0)){
		if ($valor == 0){
			$fondo = 'fondo01';
		$valor = 1;
		}else{
			$fondo = 'fondo02';
			$valor = 0;
		}
			extract($row02);
		 $sql03    = "SELECT concepto_det.cantidad, concepto_det.checks FROM concepto_det
					   WHERE concepto_det.codigo        = '$codigo'
					     AND concepto_det.cod_concepto  ='$cod_concepto'
					     AND concepto_det.cod_rol    = '$rol'
					     AND concepto_det.cod_categoria = '$categoria'";
		 $query03 = $bd->consultar($sql03);
		 $row03=$bd->obtener_fila($query03,0);
			echo'<tr  class="'.$fondo.'">

					<td class="texto">'.$cod_concepto.' - '.$descripcion.'</td>
					<td class="texto"><input type="text" name="'.$cod_concepto.'" id="'.$cod_concepto.'" maxlength="4"
						onclick="spryValidarDec(this.id)" style="width:50px" value="'.$row03[0].'"/></td>
					<td><input name="conceptos[]" type="checkbox" value="'.$cod_concepto.'" style="width:auto"
					 '.CheckX(''.$row03[1].'', 'S').' " /></td>
				</tr>';
			}
echo '</table>';
 	  mysql_free_result($query);
?>
