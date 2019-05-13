<?php
session_start();
require_once('../../../../sql/sql_report_t.php');
require "../modelo/ajuste_modelo.php";
require "../../../../".Leng;
$titulo     = "MOVIMIENTO";
$ajuste  = new Ajuste;
$listar  =  $ajuste->get();
?>
<div align="center" class="etiqueta_title">CONSULTA <?php echo $titulo;?></div>
<div id="Contenedor01"></div>
<form name="form_reportes" id="form_reportes">
<fieldset>
<legend>Filtros:</legend>
  <table width="100%">
    <tr><td width="10%">Fecha Desde:</td>
     <td width="14%" id="fecha01"><input type="text" name="fecha_desde" id="fecha_desde" size="9" required  onclick="javascript:muestraCalendario('form_reportes', 'fecha_desde');">&nbsp;<img src="imagenes/icono-calendario.gif" onclick="javascript:muestraCalendario('form_reportes', 'fecha_desde');" border="0" width="17px"></td>
        <td width="10%">Fecha Hasta:</td>
    <td width="14%" id="fecha02"><input type="text" name="fecha_hasta" id="fecha_hasta" size="9"  required onclick="javascript:muestraCalendario('form_reportes', 'fecha_hasta');">&nbsp;<img src="imagenes/icono-calendario.gif" onclick="javascript:muestraCalendario('form_reportes', 'fecha_hasta');" border="0" width="17px"></td>
           <td width="12%">Tipo Mov.:</td>
      <td width="14%"><select  name="tipo_mov" id="tipo_mov" style="width:110px;">
          <option value="TODOS">TODOS</option>
          <?php
          $query01 = $bd->consultar($sql_tipo_mov);
        while($row01=$bd->obtener_fila($query01,0)){
           echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
         }?></select></td>
        <td width="12%">Proveedor: </td>
      <td width="14%"><select  name="proveedor" id="proveedor" style="width:120px;">
          <option value="TODOS">TODOS</option>
          <?php
          $query01 = $bd->consultar($sql_proveedor);
        while($row01=$bd->obtener_fila($query01,0)){
           echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
         }?></select></td>
       <td width="4%" id="cont_img"><img class="imgLink" id="img_actualizar" src="imagenes/actualizar.png" border="0"
                                                onclick=" buscarMovimiento()"  /></td>
             <td><input type="hidden" name="Nmenu" id="Nmenu" value="<?php echo $Nmenu;?>" />
                 <input type="hidden" name="mod" id="mod" value="<?php echo $mod;?>" />
                 <input type="hidden" name="archivo" id="archivo" value="<?php echo $archivo;?>" />
                 <input type="hidden" name="tabla" id="tabla" value="<?php echo $tabla;?>"/></td>
            </tr>
    <!-- <tr>
   <td>Producto:</td>

      <td colspan="4"><input  id="stdName" type="text" style="width:300px"/>
        <input type="hidden" name="producto" id="stdID" value=""/></td>
       </tr>-->
</table>
</fieldset>
</form>
  <table width="100%">
    <tr>
        <td><input type="hidden" name="Nmenu" id="Nmenu" value="<?php echo $Nmenu;?>" />
         <input type="hidden" name="mod" id="mod" value="<?php echo $mod;?>" />
         <input type="hidden" name="archivo" id="archivo" value="<?php echo $archivo;?>" />
         <input type="hidden" name="tabla" id="tabla" value="<?php echo $tabla;?>"/></td>
       </tr>
        </table>
     <div class="tabla_sistema listar">
      <table  width="100%" border="0" align="center">
        <thead>
          <tr>
            <th>N. Movimiento</th>
            <th>Referencia</th>      
            <th>Proveedor</th>    
            <th>Fecha</th>          
            <th>Tipo Movimiento</th>
            <th>Descripcion</th>
            <th>Monto</th>
        <th align="center"><img src="imagenes/nuevo.bmp" alt="Agregar Registro" title="Agregar Registro" width="20px" height="20px" border="null"onclick="Form_ajuste('','agregar')" title="Agregar Registro"/></th>
    </tr>
        </thead>
        <tbody id="listar_ajuste">
          <?php
          foreach ($listar as  $datos) {

            echo '
            <tr onclick="Form_ajuste(\''.$datos["codigo"].'\', \'modificar\',\''.$datos["cod_tipo"].'\',\''.$datos["anulado"].'\')">
            <td>'.$datos["codigo"].'</td>
            <td>'.$datos["referencia"].'</td>
            <td>'.$datos["proveedor"].'</td>
            <td>'.$datos["fecha"].'</td>
            <td>'.$datos["tipo"].'</td>
            <td>'.$datos["motivo"].'</td>
            <td>'.$datos["total"].'</td>
            <td></td>
            </tr>';
          } ?>

        </tbody>
      </table>
    </div>
<script language="JavaScript" type="text/javascript">
  new Autocomplete("stdName", function() { 
    this.setValue = function(id) {
      console.log(id);
      $("#stdID").val(id);
    }
    if (this.value.length < 1) return ;
    return "autocompletar/tb/producto_base_serial.php?q="+this.text.value +"&filtro=codigo"});
</script>