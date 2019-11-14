<?php
include_once('../../../funciones/funciones.php');
require("../../../autentificacion/aut_config.inc.php");
require "../../../".class_bd;
require "../../../".Leng;

$codigo = $_POST['codigo'];

$sql_turno         = " SELECT turno.codigo, turno.descripcion
                         FROM turno WHERE turno.`status` = 'T'
				             ORDER BY 2 ASC ";

$sql_det = " SELECT rotacion_det.codigo, rotacion_det.cod_turno, turno.descripcion turno,
                    CONCAT('Horario:', horarios.nombre, ', Dia Habil: ',dias_habiles.descripcion) detalle
               FROM rotacion_det, turno, horarios,  dias_habiles
              WHERE rotacion_det.cod_rotacion = '$codigo'
                AND rotacion_det.cod_turno = turno.codigo
                AND turno.cod_horario = horarios.codigo
                AND turno.cod_dia_habil = dias_habiles.codigo
           ORDER BY 1 ASC ";
?>

		 <table width="100%" border="0" align="center">
       <tr>
            </br>
            <td colspan="4"></hr></td>
            </br>
       </tr>
      	<tr>
						<th width="10%">Posicion</th>
						<th width="30%"><?php echo $leng["horario"];?></th>
				    <th width="45%">Detalle:</th>
				    <th width="10%"><img src="imagenes/loading2.gif" width="30px" height="30px"/></th>
				</tr>
				<tr>
					<td><input type="hidden" name="cod_det" id="cod_det" value=""> &nbsp;</td>
					<td><select name="r_turno" id="r_turno" style="width:200px;" onchange="Mostrar_Detalle(this.value, 'detalleX')">
					<option  value="">Seleccione...</option>
					<?php
					$query03 = $bd->consultar($sql_turno);
					while($row03=$bd->obtener_fila($query03,0)){
					echo '<option value="'.$row03[0].'">'.$row03[1].'</option>';
					}
					?>
					</select></td>
		        <td id="mostrar_detalle"></td>
					  <td align="center"><span class="art-button-wrapper">
		                    <span class="art-button-l"> </span>
		                    <span class="art-button-r"> </span>
		                 <input type="button" name="submit" id="submit" value="Ingresar" class="readon art-button"
		                        onclick="save_det('','agregar')" />
		                </span></td>
				</tr>

        <?php
        $i     = 0;
        $query = $bd->consultar($sql_det);
          while ($datos=$bd->obtener_fila($query,0)){
            	$i++;
             $cod_det     = $datos['codigo'];
             $sql_turno = " SELECT turno.codigo, turno.descripcion
                             FROM turno
                            WHERE turno.`status` = 'T'
                              AND turno.codigo <> '".$datos['cod_turno']."'
                      ORDER BY 2 ASC";
                                $query02 = $bd->consultar($sql_turno);
      echo '<tr>
    					<td>'.$i.'<input type="hidden" name="cod_det" id="cod_det'.$cod_det.'" value="'.$cod_det.'"></td>
    					<td><select name="r_turno" id="r_turno'.$cod_det.'" style="width:200px;" onchange="Mostrar_Detalle(this.value, \'detalleX_'.$cod_det.'\')">
    					<option  value="'.$datos["cod_turno"].'">'.$datos["turno"].'</option>';
              while($row02=$bd->obtener_fila($query02,0)){
                echo '<option value="'.$row02[0].'">'.$row02[1].'</option>';
              }
    		echo '</select></td>
    		        <td id="mostrar_detalle_'.$cod_det.'">'.$datos["detalle"].'</td>
    					  <td align="center"><img src="imagenes/actualizar.bmp" alt="Actualizar" title="Actualizar Registro" border="null" width="20px" height="20px" class="imgLink" onclick="save_det(\''.$cod_det.'\',\'modificar\')" />&nbsp;<img src="imagenes/borrar.bmp" alt="Borrar" title="Borrar Registro" border="null" class="imgLink" width="20px" height="20px" onclick="save_det(\''.$cod_det.'\',\'borrar\')"/></td>
                </td>
    				</tr>';
          }
         ?>
		</table>
