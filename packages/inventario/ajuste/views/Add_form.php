<script language="javascript">
  $("#add_ajuste_form").on('submit', function(evt){
    evt.preventDefault();
    save_ajuste();
  });
</script>

<?php
require "../modelo/ajuste_modelo.php";
require "../../../../".Leng;
$ajuste = new Ajuste;
$metodo = $_POST['metodo'];

if($metodo == 'modificar')
{
  $anulado   = $_POST['anulado'];
  $codigo   = $_POST['codigo'];
  $titulo   = "Modificar Movimiento";
  $ped      =  $ajuste->editar("$codigo");
}else{
 $titulo    = "Agregar Movimiento";
 $ped       = $ajuste->inicio();
 $anulado   = "F";
 $codigo    = 0;
 $tipo       = $ajuste->get_tipo($ped["cod_tipo"]);
 $proveedor       = $ajuste->get_proveedor($ped["cod_proveedor"]);
}
?>

<div id="add_ajustes">
  <span class="etiqueta_title"><?php echo $titulo;?></span>

  <form name="add_ajuste" id="add_ajuste_form">

    <div style="float: right;" align="center">
      <img  style ="display: none;" border="null" width="25px" height="25px" src="imagenes/borrar.bmp" title="Borrar Registro" id="borrar_ajuste" onclick="Borrar_ajuste()" />
      <img style="display: none;" border="null" width="25px" height="25px" src="imagenes/nuevo.bmp" id="agregar_ajuste" title="Agregar Registro" onclick="Agregarajuste()" />
      <img border="null" width="25px" height="25px" src="imagenes/buscar.bmp" title="Buscar Registro" id="buscar_producto_title" onclick="Cons_ajuste()" />
    </div>
    <table width="95%" align="center">
      <tr>
        <td height="8" colspan="4" align="center"><hr></td>
      </tr>
      <tr>
        <td width="20%" class="etiqueta">N. Movimiento:</td>
        <td class="etiqueta" >Cod. Referencia: </td>
        <td width="25%" class="etiqueta">Tipo de Movimiento:</td>
        <?php if(($metodo == 'modificar') && ($ped['cod_tipo'] == 'COM')){
          echo '<td width="25%%" class="etiqueta" id="etiqueta_proveedor">Proveedor:</td>';
        }else{
          echo '<td width="25%%" class="etiqueta" id="etiqueta_proveedor" style="display: none;">Proveedor:</td>';
        }
        ?>
        <td width="30%" class="etiqueta">Fecha</td>
      </tr>
      <tr>
        <td > 
          <input type="text" id="ped_codigo" style="width: 100px;" title="Este codigo es generado por el sistema, al guardar el movimiento"  placeholder="Código" value="<?php echo $ped['codigo'];?>" required readonly>
        </td>
        <td ><input type="text" id="ped_referencia" title="Referencia"  placeholder="Referencia" value="<?php echo $ped['referencia'];?>" style="width: 200px;" required></td>
        <td> <input type="hidden" id="ped_cod_tipo" value="<?php echo $ped['cod_tipo'];?>">
          <select id="ped_tipo" required  onchange="Selec_tipo(this.value)">
          <option value="<?php echo $ped['cod_tipo'];?>" style="width: 210px;" ><?php echo $ped['tipo'];?></option>
          <?php
          foreach ($tipo as  $datos) {
           echo '<option value="'.$datos["codigo"].'">'.$datos["descripcion"].'</option>';
         }?>
       </select>
     </td>
     <?php if(($metodo == 'modificar') && ($ped['cod_tipo'] == 'COM')){
      echo '<td id="select_proveedor">';
    }else{
      echo '<td id="select_proveedor" style="display: none;">';
    }
    ?>
    <select id="ped_proveedor" required>
      <option value="<?php echo $ped['cod_proveedor'];?>" style="width: 210px;" ><?php echo $ped['proveedor'];?></option>
      <?php
      foreach ($proveedor as  $datos) {
        echo '<option value="'.$datos["codigo"].'">'.$datos["descripcion"].'</option>';
      }?>
    </select></td>
    <td>   
      <input type="date" id="ped_fecha" value="<?php echo $ped['fecha'];?>" placeholder="Fecha de Emisión"
      required>
    </td>
  </tr>
  <tr>
    <td colspan="5" class="etiqueta">Descripcion</td>
  </tr>
  <tr>  <td colspan="5">  
    <textarea id="ped_descripcion"  cols="100" rows="3"><?php echo $ped['motivo'];?></textarea>
  </td>

</tr>
<tr>
  <td height="8" colspan="5" align="center"><hr></td>
</tr>
</table>
<div id="ajuste_det"></div>
<br>
<div align="center">
  <?php if($metodo == "agregar"){
   echo '<span class="art-button-wrapper">
   <span class="art-button-l"> </span>
   <span class="art-button-r"> </span>
   <input  type="submit" title="Guardar Registro" class="readon art-button" value="Guardar" />
   </span>

   <span class="art-button-wrapper">
   <span class="art-button-l"> </span>
   <span class="art-button-r"> </span>
   <input type="reset" title="Restaurar Valores" class="readon art-button"  value="Restaurar" />
   </span>';
 }else{
  if($anulado == "F"){
    echo '<span class="art-button-wrapper">
    <span class="art-button-l"> </span>
    <span class="art-button-r"> </span>
    <input type="button" title="Anular Ajuste" class="readon art-button" id="anulador" value="Anular" onclick="anular_ajuste()" />
    </span>';
  }
}?>
<span class="art-button-wrapper">
  <span class="art-button-l"> </span>
  <span class="art-button-r"> </span>
  <input type="button"  title="Volver a la página anterior" onclick="Cons_ajuste()" class="readon art-button"  value="Volver" />
  <input id="ped_metodo" type="text" value="<?php echo $metodo;?>" hidden>
</span>
</div>

</form>
</div>
