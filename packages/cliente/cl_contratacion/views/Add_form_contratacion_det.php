<script language="javascript">
$("#cl_contratacion_det_form").on('submit', function(evt){
	 evt.preventDefault();
	 validar_contratacion_det("", "agregar");
});
	</script>
	<?php
	require "../modelo/contratacion_modelo.php";
	require "../../../../".Leng;
	$contratacion = new Contratacion;
	$codigo     = $_POST['contratacion'];
	$cliente    = $_POST['cliente'];
	$ubic       = $contratacion->get_ubicacion($cliente);
	$turno      = $contratacion->get_turno();
	$cargo      = $contratacion->get_cargo();
	$cont_det   = $contratacion->get_cont_det($codigo);
	?><form id="cl_contratacion_det_form" name="cl_contratacion_det_form" method="post">
		 <table width="100%" border="0" align="center">
    		<tr>
						<th width="20%"><?php echo $leng["ubicacion"];?></th>
						<th width="20%">Puesto Trabajo</th>
				    <th width="20%">Turno:</th>
            <th width="20%">Cargo:</th>
            <th width="12%">Cantidad:</th>
				    <th width="8%"><img src="imagenes/loading2.gif" width="30px" height="30px"/></th>
				</tr>
				<tr>
					<td><select id="cont_ubicacion" required style="width:160px;" onchange="Cargar_puesto(this.value, 'cont_puesto')">
					    <option  value="">Seleccione...</option>
  					<?php
						  foreach ($ubic as  $datos) {
  					      echo '<option value="'.$datos[0].'">'.$datos[1].'</option>';
              }
  					?>
					</select></td>
					<td><select id="cont_puesto" style="width:160px;">
					                      <option  value="">Seleccione...</option>
										            </select></td>
          <td><select id="cont_turno" required style="width:160px;">
          <option  value="">Seleccione...</option>
          <?php
						foreach ($turno as  $datos) {
            	echo '<option value="'.$datos[0].'">'.$datos[1].'</option>';
          	}
          ?>
          </select></td>
          <td><select id="cont_cargo" required style="width:160px;">
          <option  value="">Seleccione...</option>
          <?php
      		foreach ($cargo as  $datos) {
            echo '<option value="'.$datos[0].'">'.$datos[1].'</option>';
          }?>
          </select></td>
          <td><input type="number" id="cont_cantidad" required  style="width:80px;" min="1"></td>

					  <td align="center"><span class="art-button-wrapper">
		                    <span class="art-button-l"> </span>
		                    <span class="art-button-r"> </span>
		                 <input type="submit"  id="Ingresar_det" value="Ingresar" class="readon art-button" />
		                </span></td>
				</tr>
        <?php
        $i     = 0;
        foreach ($cont_det as $datos) {
            	$i++;
             $cod_det     = $datos['codigo'];
      echo '<tr>
    					<td><select id="cont_ubicacion'.$cod_det.'"  style="width:160px;" onchange="Cargar_puesto(this.value, \'cont_puesto'.$cod_det.'\')">
							    <option  value="'.$datos["cod_ubicacion"].'">'.$datos["ubicacion"].'</option>';
									foreach ($ubic as  $d_det) {
										if($datos["cod_ubicacion"] <> $d_det[0])
										echo '<option value="'.$d_det[0].'">'.$d_det[1].'</option>';
									}
		  				echo '
							</select></td>
							<td><select id="cont_puesto'.$cod_det.'" style="width:160px;">
							    	<option  value="'.$datos["cod_ub_puesto"].'">'.$datos["puesto"].'</option>';
									$puesto   = $contratacion->get_puesto($datos["cod_ubicacion"]);
									foreach ($puesto as  $d_det) {
										if($datos["cod_ub_puesto"] <> $d_det[0])
										echo '<option value="'.$d_det[0].'">'.$d_det[1].'</option>';
									}
										echo '</select></td>
							<td><select id="cont_turno'.$cod_det.'" style="width:160px;">
							     	<option  value="'.$datos["cod_turno"].'">'.$datos["turno"].'</option>';
										foreach ($turno as  $d_det) {
											if($datos["cod_turno"] <> $d_det[0])
											echo '<option value="'.$d_det[0].'">'.$d_det[1].'</option>';
										}
										echo '</select></td>
							<td><select id="cont_cargo'.$cod_det.'" style="width:160px;">
							     	<option  value="'.$datos["cod_cargo"].'">'.$datos["cargo"].'</option>';
										foreach ($cargo as  $d_det) {
											if($datos["cod_cargo"] <> $d_det[0])
											echo '<option value="'.$d_det[0].'">'.$d_det[1].'</option>';
										}
										echo '</select></td>
								<td><input type="number" id="cont_cantidad'.$cod_det.'" style="width:80px;" value="'.$datos["cantidad"].'" min="1"></td>
    		        <td align="center"><img src="imagenes/actualizar.bmp" alt="Actualizar" title="Actualizar Registro" border="null" width="20px" height="20px" class="imgLink" onclick="validar_contratacion_det(\''.$cod_det.'\',\'modificar\')" />&nbsp;<img src="imagenes/borrar.bmp" alt="Borrar" title="Borrar Registro" border="null" class="imgLink" width="20px" height="20px" onclick="validar_contratacion_det(\''.$cod_det.'\',\'borrar\')"/></td>
                </td>
    				</tr>';
          }
         ?></table>
  </form>
