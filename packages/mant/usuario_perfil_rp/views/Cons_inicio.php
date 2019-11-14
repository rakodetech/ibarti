<div align="center" class="etiqueta_title">RELACION PERFIL VS MENU</div>
<form name="form_reportes" id="form_reportes">
  <hr />
  <div id="cargar"></div>
  <table width="100%">
   <td width="10%" class="etiqueta">Perfil: </td>
   <td width="14%" id="perfiles">
      <select name="perfil" id="perfil" style="width:120px;" onchange="cargarModulos(this.value)" required>
        <option value="TODOS">TODOS</option>
      </select>
  </td>
  <td width="10%" class="etiqueta">Modulo: </td>
  <td width="14%" id="modulos">
      <select name="modulo" id="modulo" style="width:120px;" onchange="cargarSeccion(this.value)" required>
        <option value="TODOS">TODOS</option>
      </select>
  </td>
  <td width="10%" class="etiqueta">Seccion: </td>
  <td width="14%" id="seccion">
      <select name="seccione" id="seccione" style="width:120px;"  required>
        <option value="TODOS">TODOS</option>
      </select>
  </td>

  <td width="40%"></td>
  
 
</tr>
</table><hr />
<br/>
<div align="center">
  <span class="art-button-wrapper">
    <span class="art-button-l"> </span>
    <span class="art-button-r"> </span>
    <input type="button" name="salir" id="salir" value="Salir" onclick="Vinculo('inicio.php?area=formularios/index')"
    class="readon art-button">
  </span>&nbsp;
  <img  class="imgLink" src="imagenes/detalle2.bmp" border="0" onclick="llenar_perfil_menu()"/>
</div>
</form>

<form id="report" action="packages/mant/usuario_perfil_rp/views/rp_perfil_menu.php" method="post" target="_blank">
  <input type="hidden" name="reporte" id="reporte" >
  
  <button type="submit" hidden="hidden"></button>
</form>