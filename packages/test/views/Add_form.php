<script language="javascript">
  $("#add_test_form").on('submit', function(evt){
    evt.preventDefault();
    save_test();
  });
</script>
<?php
require "../modelo/test_modelo.php";
require "../../../".Leng;
$test = new Test;
$metodo = $_POST['metodo'];

if($metodo == 'modificar')
{
	$id   = $_POST['id'];
	$titulo   = "Modificar Test";
	$t      =  $test->editar($codigo);
}else{
 $titulo    = "Agregar Test";
 $t      =  $test->inicio();
}

?>
<div id="add_test">
  <form action="" method="post" name="add_test" id="add_test_form">
    <span class="etiqueta_title" id="title_horario"><?php echo $titulo;?></span>
    <span style="float: right;" align="center" >
      <img  style ="display: none;" border="null" width="25px" height="25px" src="imagenes/borrar.bmp" title="Borrar Registro" onclick="Borrar_horario()" id="borrar_horario" />
      <img border="null" width="25px" height="25px" src="imagenes/buscar.bmp" title="Buscar Registro" id="buscar_test_title" onclick="irABuscarTest()" />
    </span>
    <table width="90%" align="center">
      <tr>
        <td height="8" colspan="4" align="center"><hr></td>
      </tr>
      <tr>
       <td width="15%" class="etiqueta">Id:</td>
       <td width="35%"><input type="text" name="id" id="t_id" minlength="2" maxlength="11" readonly value="<?php echo $t['id'];?>" />
         Activo: <input name="activo" id="activo" type="checkbox" value="<?php echo statusCheck($t['estado']);?>" />
       </td>
       <td width="15%" class="etiqueta">Descripción:</td>
       <td width="35%">
       	<input type="text" name="descripcion" id="t_descripcion" required value="<?php echo $t['descripcion'];?>" />
       </td>
    </tr>
    <tr>
      <td height="8" colspan="4" align="center"><hr></td>
    </tr>
  </table>

  <div align="center"><span class="art-button-wrapper">
    <span class="art-button-l"> </span>
    <span class="art-button-r"> </span>
    <input type="submit" name="salvar"  id="salvar_test" value="Guardar" class="readon art-button" />
  </span>&nbsp;
  <span class="art-button-wrapper">
    <span class="art-button-l"> </span>
    <span class="art-button-r"> </span>
    <input type="reset" id="limpiar_test" value="Restablecer" class="readon art-button" />
  </span>&nbsp;
  <span class="art-button-wrapper">
    <span class="art-button-l"> </span>
    <span class="art-button-r"> </span>
    <input type="button" id="volver_horario" value="Volver" onclick="volverTest()" class="readon art-button" />
  </span>
  <input name="metodo" id="t_metodo" type="hidden"  value="<?php echo $metodo;?>" />
</div>
</form>
</div>
</div>
