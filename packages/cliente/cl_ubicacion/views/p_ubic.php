<script language="javascript">
$("#ub_form").on('submit', function(evt){
	 evt.preventDefault();
	 save_ubic();
});
</script>
<form id="ub_form" name="ub_form" method="post">
<fieldset class="fieldset">
  <legend><?php echo $titulo;?></legend>
     <table width="90%" align="center">
    <tr>
      <td width="15%" class="etiqueta">C&oacute;digo:</td>
      <td width="35%"><input type="text" id="ub_codigo" maxlength="11" size="15" value="<?php echo $ubic["codigo"];?>" readonly  />
               Activo: <input id="ub_status" type="checkbox"  <?php echo statusCheck($ubic["status"]);?> value="T" />
      </td>
      <td width="15%" class="etiqueta"><?php echo $leng['ubicacion']?>: </td>
      <td width="35%"><input type="text" id="ub_nombre" maxlength="30" size="30" required value="<?php echo $ubic["descripcion"];?>"/>
      </td>
    </tr>

	  <tr>
      <td class="etiqueta"><?php echo $leng['region']?>:</td>
      	<td><select id="ub_region" style="width:250px" required>
							<option value="<?php echo $ubic["cod_region"];?>"><?php echo $ubic["region"];?></option>
          	<?php
					    foreach ($region as  $datos) {
          			echo '<option value="'.$datos[0].'">'.$datos[1].'</option>';
           	}?>
        </select></td>
      <td class="etiqueta"><?php echo $leng['estado']?>: </td>
      	<td><select id="ub_estado" required style="width:250px" onchange="Filtrar_select(this.value, 'ub_ciudad', 'ajax/Add_select_ciudad.php', 'ciudad', '250px', '')">
							<option value="<?php echo $ubic["cod_estado"];?>"><?php echo $ubic["estado"];?></option>
							<?php
								foreach ($estado as $datos) {
									echo '<option value="'.$datos[0].'">'.$datos[1].'</option>';
							}?>
        </select><br /><span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
	 </tr>

    <tr>
      <td class="etiqueta"><?php echo $leng['ciudad']?>:</td>
      <td id="ciudad"><select id="ub_ciudad" style="width:250px"  required>
							<option value="<?php echo $ubic["cod_ciudad"];?>"><?php echo $ubic["ciudad"];?></option>
							<?php
								foreach ($ciudad as $datos) {
									echo '<option value="'.$datos[0].'">'.$datos[1].'</option>';
							}?>
        </select></td>
				<td class="etiqueta">Zona:</td>
				<td id="ciudad"><select id="ub_zona" style="width:250px"  required>
								<option value="<?php echo $ubic["cod_zona"];?>"><?php echo $ubic["zona"];?></option>
								<?php
									foreach ($zona as $datos) {
										echo '<option value="'.$datos[0].'">'.$datos[1].'</option>';
								}?>
					</select></td>
    </tr>
		<tr>
				<td class="etiqueta">Calendario:</td>
				<td id="ciudad"><select id="ub_calendario" style="width:250px"  required>
								<option value="<?php echo $ubic["cod_calendario"];?>"><?php echo $ubic["calendario"];?></option>
								<?php
									foreach ($calendario as $datos) {
										echo '<option value="'.$datos[0].'">'.$datos[1].'</option>';
								}?>
					</select></td>
		</tr>
    <tr>
      <td class="etiqueta">Contacto: </td>
      <td id="input03"><input type="text" id="ub_contacto" maxlength="30" size="30" value="<?php echo $ubic["contacto"];?>" required/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>

      <td class="etiqueta">Cargo: </td>
      <td id="input04"><input type="text" id="ub_cargo" maxlength="30" size="30" value="<?php echo $ubic["cargo"];?>" required/>
      </td>
    </tr>
    <tr>
      <td class="etiqueta">Tel&eacute;fono: </td>
      <td id="input05"><input type="text" id="ub_telefono" maxlength="60" size="30" value="<?php echo $ubic["telefono"];?>"/>
      </td>

      <td class="etiqueta"><?php echo $leng['correo']?>: </td>
      <td><input  type="email" id="ub_email" maxlength="60" size="30" value="<?php echo $ubic["email"];?>"/></td>
    </tr>
    <tr>
      <td class="etiqueta">Direcci&oacute;n:</td>
      <td id="textarea01"><textarea  id="ub_direccion" cols="50" rows="3"><?php echo $ubic["direccion"];?></textarea>
        <span id="Counterror_mess2" class="texto">&nbsp;</span><br />
        <span class="textareaRequiredMsg">El Campo es Requerido.</span>
        <span class="textareaMinCharsMsg">Debe Escribir mas de 4 caracteres.</span>
        <span class="textareaMaxCharsMsg">El maximo de caracteres permitidos es 300.</span></td>

      <td class="etiqueta">Observación:</td>
      <td id="textarea02"><textarea  id="ub_observ" cols="50" rows="3"><?php echo $ubic["observacion"];?></textarea>
        <span id="Counterror_mess2" class="texto">&nbsp;</span><br />
        <span class="textareaRequiredMsg">El Campo es Requerido.</span>
        <span class="textareaMinCharsMsg">Debe Escribir mas de 4 caracteres.</span>
        <span class="textareaMaxCharsMsg">El maximo de caracteres permitidos es 300.</span></td>
    </tr>
	 <tr>
         <td height="8" colspan="4" align="center"><hr></td>
     </tr>

  </table>
	<div align="center"><br/>
		 <span class="art-button-wrapper">
		 			 <span class="art-button-l"> </span>
		 			 <span class="art-button-r"> </span>
		 			<input type="submit" name="salvar"  id="salvar" value="Guardar" class="readon art-button" />
		 	 </span>&nbsp;

	<span class="art-button-wrapper">
				 <span class="art-button-l"> </span>
				 <span class="art-button-r"> </span>
		 <input type="reset" id="limpiar" value="Restablecer" class="readon art-button" />
		 </span>&nbsp;
	<span class="art-button-wrapper">
				 <span class="art-button-l"> </span>
				 <span class="art-button-r"> </span>
		 <input type="button" id="volver" value="Cerrar" onClick="CloseModal();" class="readon art-button" />
		 </span>
	</div>
	 <input name="metodo" id="ub_metodo" type="hidden"  value="<?php echo $metodo;?>" />
  </fieldset>
</form>
