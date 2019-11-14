  <fieldset class="fieldset">
    <legend>EAN</legend>
<table width="95%" align="center">
  <tr>
    <td class="etiqueta">Codigo</td>
    <td class="etiqueta">Agregar</td>
  </tr>
  <tr>
     <td width="90%">
     <input type="text" id="prod_ean" style="width:300px" placeholder="">
   </td>
    <td align="center">
      <img  border="null" width="20px" height="20px" src="imagenes/ico_agregar.ico" onclick="agregar_ean()" disabled title="Agregar renglon" />
    </td>
  </tr>
</table>
<table class="tabla_sistema"  width="95%">
  <thead>
    <tr class="fondo00">
      <th>Codigo EAN</th>
      <th></th>
    </tr>
  </thead>
  <tbody id="listar_eans">
  </tbody>
</table>
<div align="center">
  <span class="art-button-wrapper">
    <span class="art-button-l"> </span>
    <span class="art-button-r"> </span>
    <input type="submit" name="salvar"  id="salvar" value="Guardar" class="readon art-button" />  
  </span>   
</div>
</fieldset>