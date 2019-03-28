<link rel="stylesheet" href="css/modal_planif.css" type="text/css" media="screen" />
<script type="text/javascript" src="funciones/modal.js"></script>

<div id="myModal" class="modal">
  <div class="modal-content">
    <div class="modal-header">
      <span class="close" onclick="CloseModal()" >&times;</span>
      <span id="modal_titulo"></span>
    </div>
    <div class="modal-body">
      <div id="modal_contenido"></div>
    </div>
  </div>
</div>

<?php $titulo  = " RELACION PERFIL VS NOVEDADES"; ?>

<div align="center" class="etiqueta_title"><?php echo $titulo;?> </div>
<div id="Contenedor01"></div>
<div id="cargar"></div>
<form name="form_reportes" id="form_reportes" action="<?php echo $archivo;?>"  method="post" target="_blank">

  <hr /><table width="100%" class="etiqueta" id="prueba">

  	<td width="10%">Perfil: </td>

       <td width="14%" id="et">
      <div id="contenedor3">
      <select name="departamentos" id="departamentos" style="width:120px;" onchange="" required>
        <option value="TODOS">TODOS</option>
       </select>
     </td>

      <td width="10%">Checklist: </td>
       <td width="14%">
      
      <select name="checklist" id="checklist" style="width:120px;" onchange="" required>
        <option value="TODOS">TODOS</option>
        <option value="T">SI</option>
        <option value="F">NO</option>
       </select>
        </td>

      <td width="10%">Tipo</td>
      <td width="14%" id="tipo"></td>


       <td width="28%"></td>
    
     <input type="hidden" name="Nmenu" id="Nmenu" value="<?php echo $Nmenu;?>" />
     <input type="hidden" name="mod" id="mod" value="<?php echo $mod;?>" />
     <input type="hidden" name="usuario" id="usuario" value="<?php echo $_SESSION['usuario_cod'];?>"/> 
   </td>
 </tr>  
</table><hr />
<div id='contenedor'></div>

<div align="center"><br/>
  <span class="art-button-wrapper">
    <span class="art-button-l"> </span>
    <span class="art-button-r"> </span>
    <input type="button" name="salir" id="salir" value="Salir" onclick="Vinculo('inicio.php?area=formularios/index')"
    class="readon art-button">

  </span>&nbsp;
  <img class="imgLink" src="imagenes/detalle2.bmp" border="0" onclick="llenar_perfil_novedad()">
</div>
</form>

<script type="text/javascript" src="packages/mant/usuario_perfil_rp/controllers/usuario_menu_Ctrl.js"></script>
<script type="text/javascript" src="packages/novedades_rp/controllers/novedades_rpCtrl.js"></script>
<script type="text/javascript">
  llenar_departamentos();
  cargartipo();
</script>

<form id="report" action="packages/mant/usuario_perfil_rp/views/rp_perfil_menu.php" method="post" target="_blank">
  <input type="hidden" name="reporte" id="reporte" >
  <button type="submit" hidden="hidden"></button>
</form>