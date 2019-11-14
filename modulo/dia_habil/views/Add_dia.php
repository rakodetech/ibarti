<?php
include_once('../../../funciones/funciones.php');
require("../../../autentificacion/aut_config.inc.php");
require "../../../".class_bd;
require "../../../".Leng;

	$codigo       = $_POST['codigo'];
	$cod_dia_tipo = $_POST['cod_dia_tipo'];
	$bd = new DataBase();
	$sql  = "SELECT a.* ,  IFNULL(b.cod_dias_tipo, 'FALSE') existe
		  	  	 FROM dias_tipo a LEFT JOIN dias_habiles_det b ON b.`cod_dias_habiles` = '$codigo'
							AND b.cod_dias_tipo = a.dia
						WHERE a.tipo = '$cod_dia_tipo' AND a.`status` = 'T'
						ORDER BY a.orden ASC";
 $query = $bd->consultar($sql);


?>
 				 <table width="100%" align="center">
						<tr>
			         <td height="8" colspan="4" align="center"><hr></td>
			     </tr>
 						<tr>
 							<td class="etiqueta" width="15%">Fecha Diaria</td>
 							<td class="etiqueta" width="35%" align="left">Apertura</td>
							<td class="etiqueta" width="15%">Fecha Diaria</td>
 							<td class="etiqueta" width="35%" align="left">Apertura</td>
 		       </tr>
<?php
					 $x = 0;
 					while($row02=$bd->obtener_fila($query,0)){

						if ($x == 0){
						echo '<tr>
									<td>'.$row02[2].'</td>
									<td><input type="checkbox" name="DIAS[]" value="'.$row02[0].'" style="width:auto" '.CheckX("$row02[0]", "$row02[5]").' /></td>';
							$x = 1;
						}else {
							$x = 0;
							echo '
							<td>'.$row02[2].'</td>
							<td><input type="checkbox" name="DIAS[]" value="'.$row02[0].'" style="width:auto" '.CheckX("$row02[0]", "$row02[5]").' /></td>
						 </tr>';
						}
					}
					if($x == 1){
						echo '<tr>';
					}
				?></table>
