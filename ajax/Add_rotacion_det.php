<?php
require_once('../sql/sql_report_t.php');
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase();


$read_cod      = 'readonly="readonly"';
$codigo   = $_POST['codigo'];


	$SQL_PAG = " SELECT rotacion_det.codigo, rotacion_det.cod_horario,
                      horarios.nombre AS horario, rotacion_det.cod_turno,
                      turno.descripcion turno
                 FROM rotacion_det, horarios, turno
                WHERE rotacion_det.cod_horario = horarios.codigo
								  AND rotacion_det.cod_turno = turno.codigo
                  AND rotacion_det.cod_rotacion = '$codigo'
 		    	   ORDER BY 1 ASC";
			   ?>

<table width="95%" border="0" align="center">
		<tr class="fondo00">
        <th width="10%" class="etiqueta">Item</th>
        <th width="20%" class="etiqueta">Codigo</th>
				<th width="30%" class="etiqueta">Turno</th>
				<th width="30%" class="etiqueta">Horario</th>
			<th width="10%"><img src="imagenes/loading2.gif" width="40px" height="40px"/></th>
		</tr><?php	echo '<tr class="fondo01">
		<td>&nbsp;</td>
		<td><input type="text" id="cod_det" name="cod_det" maxlength="16" size="14"  '.$read_cod.' /></td>
		<td><select name="turno" id="turno" style="width:160px;" onchange="Filtrar_horario(this.value, \'horario\', \'horarioX\', \'160px\',\'\')">
		<option value="">Seleccione...</option>';
		$query03 = $bd->consultar($sql_turno);
		while($row03=$bd->obtener_fila($query03,0)){
		echo '<option value="'.$row03[0].'">'.$row03[1].'</option>';
		}
		echo'</select></td>

				<td id="horarioX"><select name="horario" id="horario" style="width:160px;">
							<option value="">Seleccione Un Turno</option>
							</select>'; ?>

			  <td align="center"><span class="art-button-wrapper">
                    <span class="art-button-l"> </span>
                    <span class="art-button-r"> </span>
                 <input type="button" name="submit" id="submit" value="Ingresar" class="readon art-button"
                        onclick="Ingresar_Det('agregar_det')" />
                </span></td>
		</tr><?php
	   $query = $bd->consultar($SQL_PAG);
		$valor = 1;
		$i     = 0;
		while ($datos=$bd->obtener_fila($query,0)){
		$i++;
		if ($valor == 0){
			$fondo = 'fondo01';
		$valor = 1;
		}else{
			$fondo = 'fondo02';
			$valor = 0;
		}
		$cod_det     = $datos['codigo'];
		$mod_det     = "Rotacion_Det('modificar_det', '".$cod_det."')";
		$borrar_det  = "Rotacion_Det('borrar_det', '".$cod_det."')";

		 $fechaX  = conversion($fecha);
		 $campo_id = $datos[0];
        echo '<tr class="'.$fondo.'"><td>'.$i.'</td>
		<td><input type="text" id="cod_det_'.$datos["codigo"].'" name="cod_det" maxlength="16"
		           size="14" value="'.$datos["codigo"].'" '.$read_cod.' /></td>
		<td><select id="turno_'.$cod_det.'" style="width:160px;" onchange="Filtrar_horario(this.value, \'horario_'.$cod_det.'\', \'horarioX_'.$cod_det.'\', \'160px\',\'\')">
					 <option value="'.$datos["cod_turno"].'">'.$datos["turno"].'</option>';
				$query03 = $bd->consultar($sql_turno);
				 while($row03=$bd->obtener_fila($query03,0)){
				 echo '<option value="'.$row03[0].'">'.$row03[1].'</option>';
				 }echo'</select> </td>
					<td id="horarioX_'.$cod_det.'"> <select id="horario_'.$cod_det.'" style="width:160px;">
							   <option value="'.$datos["cod_horario"].'">'.$datos["horario"].'</option>
							</select> </td>

			    <td align="center"><img src="imagenes/actualizar.bmp" alt="Actualizar" title="Actualizar Registro" border="null" width="20px" height="20px" class="imgLink" onclick="'.$mod_det.'" />&nbsp;<img src="imagenes/borrar.bmp" alt="Borrar" title="Borrar Registro" border="null" class="imgLink" width="20px" height="20px" onclick="'.$borrar_det.'"/></td>
			</tr>';
        }mysql_free_result($query);?><tr>
		</tr>
	</table>
