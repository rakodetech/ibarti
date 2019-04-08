<table width="95%" align="center">
  <tr>
    <td width="15%" class="etiqueta">Linea</td>
    <td width="15%" class="etiqueta">Sub Linea</td>
    <td width="10%" class="etiqueta"><?php echo $leng['producto'];?></td>
    <td width="20%" class="etiqueta" id="add_renglon_etiqueta">Agregar</td>
  </tr>
  <tr>
  <td>
    <select id="dot_linea" onchange="Selec_producto(this.value)" style="width:200px">
      <option value="">Seleccione...</option>
    </select>
  </td>
  <td>
    <select id="dot_sub_linea" onchange="Selec_almacen(this.value)"  style="width:200px" >
      <option value="">Seleccione...</option>
    </select>
  </td>
  <td>
    <select id="dot_producto" onchange="Selec_almacen(this.value)"  style="width:200px" >
      <option value="">Seleccione...</option>
    </select>
  </td>
 <td align="center">
  <img  border="null" width="20px" height="20px" src="imagenes/ico_agregar.ico" id="add_renglon" onclick="Agregar_renglon()" disabled title="Agregar renglon" />
  <img  border="null" width="20px" height="20px" src="imagenes/borrar.bmp" id="canc_renglon" onclick="Cancelar_renglon()" hidden title="Cancelar renglon" />
  <img  border="null" width="20px" height="20px" src="imagenes/actualizar.bmp"  id="update_renglon" onclick="Actualizar_renglon()" hidden title="Actualizar renglon" />
</td>
</tr>
</table>
