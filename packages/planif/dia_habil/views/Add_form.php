<script language="javascript">
  $("#add_dia_habil").on('submit', function(evt){
    evt.preventDefault();
    save_dia_habil();
  });

  $("#add_dia_habil input, select").change(function (evt) { 
    evt.preventDefault();  
    $("#dh_cambios").val('true');
    $('#salvar_dia_habil').attr('disabled',false);
  }); 

  $("#bus_dia_habil").on('submit', function(evt){
    evt.preventDefault();
    buscar_dia_habil(true);
  });

</script>

<?php
require "../modelo/dia_habil_modelo.php";
require "../../../../".Leng;
$dh = new Dia_habil;
$metodo  = $_POST['metodo'];

if($metodo == 'modificar')
{
	$codigo    = $_POST['codigo'];
	$titulo    = "Modificar ".$leng['dia_habil'];
	$dia_h     = $dh->editar("$codigo");

}else{
	$titulo    = "Agregar ".$leng['dia_habil'];
	$dia_h     = $dh->inicio();
}
$dias_tipo = $dh->dias_tipo($dia_h['cod_dias_tipo']);
?>
<form action="" method="post" name="add_dia_habil" id="add_dia_habil">
  <span class="etiqueta_title" id="title_dia_habil"><?php echo $titulo;?></span>
  <span style="float: right;" align="center">
    <img  style ="display: none;" border="null" width="25px" height="25px" src="imagenes/borrar.bmp" title="Borrar Registro" onclick="Borrar_dia_habil()" id="borrar_dia_habil" />
    <img style="display: none;" border="null" width="25px" height="25px" src="imagenes/nuevo.bmp" alt="Agregar" onclick="irAAgregarDia_habil()" title="Agregar Registro" id="agregar_dia_habil" />
    <img border="null" width="25px" height="25px" src="imagenes/buscar.bmp" title="Buscar Registro" id="buscar_dia_habil_title" onclick="irABuscarDia_habil()" />
  </span>
  <table width="90%" align="center">
    <tr>
     <td height="8" colspan="4" align="center"><hr></td>
   </tr>
   <tr>
    <td width="15%" class="etiqueta">C&oacute;digo:</td>
    <td width="35%"><input type="text" id="dh_codigo" maxlength="11" readonly  value="<?php echo $dia_h['codigo'];?>" />
     Activo: <input  id="dh_status" type="checkbox"  <?php echo statusCheck($dia_h['status']);?> value="T" />
   </td>

   <td width="15%" class="etiqueta">descripcion: </td>
   <td width="35%"><input type="text"  id="dh_descripcion" minlength="2" maxlength="60" required style="width:300px"
     value="<?php echo $dia_h['descripcion'];?>"/>

   </td>
 </tr>

 <tr>
  <td class="etiqueta">Clasificación:</td>
  <td><select name="clasif" id="dh_clasif" style="width:200px" required onchange="Add_dh_det(this.value)">
   <option value="<?php echo $dia_h['cod_dias_tipo'];?>"><?php echo $dia_h['dias_tipo'];?></option>
   <?php
   foreach ($dias_tipo as  $datos)
   {
    echo '<option value="'.$datos[0].'">'.$datos[1].'</option>';
  }?>
</select></td>
</tr>
<td colspan="4" id="Cont_dh_det"></td>
<tr>

</tr>

<tr>
 <td height="8" colspan="4" align="center"><hr></td>
</tr>
</table>

<div align="center"><span class="art-button-wrapper">
  <span class="art-button-l"> </span>
  <span class="art-button-r"> </span>
  <input type="submit" name="salvar"  id="salvar_dia_habil" value="Guardar" class="readon art-button" />
</span>&nbsp;
<span class="art-button-wrapper">
  <span class="art-button-l"> </span>
  <span class="art-button-r"> </span>
  <input type="reset" id="limpiar_dia_habil" value="Restablecer" class="readon art-button" />
</span>

<input name="metodo" id="dh_metodo" type="hidden"  value="<?php echo $metodo;?>" />
<input name="cambios" id="dh_cambios" type="hidden"  value="false"/>
</div>
</form>

<div id="buscar_dia_habil" style="display: none;">
  <div id="form_buscar_dia_habil" style="width: 90%"> 
    <form name="bus_dia_habil" id="bus_dia_habil" style="float: right;">
      <input type="text" name="codigo_buscar" id="data_buscar_dia_habil" maxlength="11" placeholder="Escribe aqui para filtrar.. "/>
      <select name="filtro_buscar_dia_habil" id="filtro_buscar_dia_habil" style="width:110px" required>
        <option value="codigo">Código</option>
        <option value="descripcion">Nombre</option>
      </select>
      <input type="submit" name="buscarDiaHabil" id="buscarDiaHabil" hidden="">
      <span class="art-button-wrapper">
        <img border="null" width="25px" height="25px" src="imagenes/buscar.bmp" title="Buscar Registro" id="buscarDH" onclick="buscar_dia_habil(true);" />
      </span>
    </form>
  </div>
  <div class="tabla_sistema listar">
    <span align="center" class="etiqueta_title"> Consulta De <?php echo $leng['dia_habil'];?> </span>
    <table width="100%" border="0" align="center" id="lista_dia_habil">
    <thead>
      <tr>
        <th width="15%">Codigo</th>
        <th width="50%">Nombre</th>
        <th width="20%" class="etiqueta">Status</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $matriz  =  $dh->get();

      foreach ($matriz as  $datos)
      {
        echo '<tr onclick="Cons_dia_habil(\''.$datos[0].'\', \'modificar\')" title="Click para Modificar..">
        <td>'.$datos["codigo"].'</td>
        <td>'.longitud($datos["descripcion"]).'</td>
        <td>'.statuscal($datos["status"]).'</td>
        </tr>';
      }
      ?>
    </tbody>
  </table>
</div>
<div align="center">
  <span class="art-button-wrapper">
    <span class="art-button-l"> </span>
    <span class="art-button-r"> </span>
    <input type="button" id="volver_dia_habil" value="Volver" onclick="volverDiaHabil()" class="readon art-button" />
  </span>
</div>
</div>