<script type="text/javascript">
  $("#add_cliente_form").on('submit', function(evt){
    evt.preventDefault();
    save_cliente();
  });

  $("#add_cliente_form input, select").change(function (evt) { 
    evt.preventDefault();  
    $("#c_cambios").val('true');
    $('#salvar_cliente').attr('disabled',false);
  }); 
</script>
<form action="" method="post"  id="add_cliente_form">
  <fieldset class="fieldset">
    <legend>Datos <?php echo $leng['cliente'];?></legend>
    <table width="100%" align="center">
      <tr>
        <td width="15%" class="etiqueta">C&oacute;digo:</td>
        <td width="35%"><input type="text" id="c_codigo" maxlength="11" style="width:120px" required value="<?php echo $cl['codigo'];?>" <?php echo $readonly;?> /></td>
        <td width="15%" class="etiqueta">Abreviatura:</td>
        <td width="35%"><input type="text" id="c_abrev" maxlength="14" required style="width:120px" value="<?php echo $cl['abrev'];?>" />
          Activo: <input id="c_activo" type="checkbox" <?php echo statusCheck($cl['status']);?> value="T" />
        </td>
      </tr>

      <td class="etiqueta"><?php echo $leng['rif'];?>: </td>
      <td><input type="text" id="c_rif" maxlength="20" style="width:150px" value="<?php echo $cl['rif'];?>"/></td>
      <td class="etiqueta"><?php echo $leng['nit'];?>:</td>
      <td><input type="text" id="c_nit" maxlength="20" style="width:150px" value="<?php echo $cl['nit'];?>"/></td>
    </tr>
    <tr>
      <td class="etiqueta">Nombre: </td>
      <td><input type="text" id="c_nombre" maxlength="60" style="width:280px" value="<?php echo $cl['nombre'];?>"/></td>
      <td class="etiqueta">Aplicar</td>
      <td><?php echo $leng['juridico'];?>: <input type="checkbox" id="c_juridico" <?php echo statusCheck($cl['juridico']);?> value="T" />  Contribuyente: <input type="checkbox" id="c_contrib" <?php echo statusCheck($cl['contribuyente']);?> value="T" /></td>
    </tr>

    <tr>
     <td class="etiqueta">Tel&eacute;fono: </td>
     <td><input type="text" id="c_telefono" maxlength="60" style="width:250px" value="<?php echo $cl['telefono'];?>"/></td>
     <td class="etiqueta">Fax: </td>
     <td><input type="text" id="c_fax" maxlength="60" style="width:250px" value="<?php echo $cl['fax'];?>"/></td>
     <tr>

      <tr>

        <td class="etiqueta">Tipo <?php echo $leng['cliente'];?>: </td>
        <td><select id="c_cl_tipo" style="width:250px" required="required">
         <option value="<?php echo $cl['cod_cl_tipo'];?>"><?php echo $cl['cl_tipo'];?></option>
         <?php  	$sql = " SELECT codigo, descripcion FROM clientes_tipos
         WHERE status = 'T' AND codigo <> '$cod_cl_tipo' ORDER BY 2 ASC ";
         $query = $bd->consultar($sql);
         while($datos=$bd->obtener_fila($query,0)){
          ?>
          <option value="<?php echo $datos[0];?>"><?php echo $datos[1];?></option>
          <?php }?>
        </select></td>
        <td class="etiqueta"><?php echo $leng['region'];?>:</td>
        <td><select id="c_region" style="width:250px" required>
          <option value="<?php echo $cl['cod_region'];?>"><?php echo $cl['region'];?></option>
          <?php  	$sql = " SELECT codigo, descripcion FROM regiones WHERE status = 'T' ORDER BY 2 ASC ";
          $query = $bd->consultar($sql);
          while($datos=$bd->obtener_fila($query,0)){
           ?>
           <option value="<?php echo $datos[0];?>"><?php echo $datos[1];?></option>
           <?php }?>
         </select></td>

       </tr>
       <tr>
         <td class="etiqueta">Vendedor:</td>
         <td><select id="c_vendedor" style="width:250px" required>
           <option value="<?php echo $cl['cod_vendedor'];?>"><?php echo $cl['vendedor'];?></option>
           <?php  	$sql = " SELECT codigo, nombre FROM vendedores  WHERE status = 'T' ORDER BY 2 ASC ";
           $query = $bd->consultar($sql);
           while($datos=$bd->obtener_fila($query,0)){
            ?>
            <option value="<?php echo $datos[0];?>"><?php echo $datos[1];?></option>
            <?php }?>
          </select></td>
          <td class="etiqueta">Contacto:</td>
          <td><input type="text" id="c_contacto" maxlength="60" style="width:250px" value="<?php echo $cl['contacto'];?>"/></td>
        </tr>
        <tr>
          <td class="etiqueta">Email: </td>
          <td><input type="text" id="c_email" maxlength="60" style="width:250px" value="<?php echo $cl['email'];?>"/></td>
          <td class="etiqueta">Website: </td>
          <td><input type="text" id="c_website" maxlength="60" style="width:250px" value="<?php echo $cl['website'];?>"/></td>
        </tr>
        <tr>
          <td class="etiqueta">Direcci&oacute;n:</td>
          <td><textarea id="c_direccion" cols="38" rows="4" maxlength="300" required><?php echo $cl['direccion'];?></textarea>
            <td class="etiqueta">Observación:</td>
            <td><textarea  id="c_observ" cols="38" rows="4"><?php echo $cl['observacion'];?></textarea></td>
          </tr>
          <tr>
           <td height="8" colspan="4" align="center"><hr></td>
         </tr>
       </table>
       <div align="center">
        <span class="art-button-wrapper">
          <span class="art-button-l"> </span>
          <span class="art-button-r"> </span>
          <input type="submit" name="salvar"  id="salvar_cliente" value="Guardar" class="readon art-button" />
        </span>&nbsp;
        <span class="art-button-wrapper">
          <span class="art-button-l"> </span>
          <span class="art-button-r"> </span>
          <input type="reset" id="limpiar_cliente" value="Restablecer" class="readon art-button" />
        </span>
      </div>
      <input id="c_metodo" type="hidden" value="<?php echo $metodo;?>" />
      <input name="cambios" id="c_cambios" type="hidden"  value="false"/>
    </fieldset>
  </form>
