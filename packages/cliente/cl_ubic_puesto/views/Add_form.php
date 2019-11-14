<script language="javascript">
$("#cl_puesto_form").on('submit', function(evt){
	 evt.preventDefault();
	 save_puesto();
});
</script>
<?php
require "../modelo/puesto_modelo.php";
require "../../../../".Leng;
$ub_puesto = new Ub_puesto;
$metodo = $_POST['metodo'];

if($metodo == 'modificar')
{
	$codigo   = $_POST['codigo'];
	$titulo   = "Modificar Puesto De Trabajo";
	$ub_p     = $ub_puesto->editar("$codigo");
}else{
  $titulo   = "Agregar Puesto De Trabajo";
	$ub_p     = $ub_puesto->inicio();
}
?>

<form id="cl_puesto_form" name="cl_puesto_form" method="post">
<fieldset class="fieldset">
  <legend>Datos <?php echo $titulo;?></legend>
     <table width="90%" align="center">
    <tr>
      <td width="15%" class="etiqueta">C&oacute;digo:</td>
      <td width="35%"><input type="text" id="p_codigo"  maxlength="11" size="15" value="<?php echo $ub_p["codigo"];?>" readonly  />
               Activo: <input id="p_status" type="checkbox"  <?php echo statusCheck($ub_p["status"]);?> value="T" />
      </td>

      <td width="15%" class="etiqueta">Nombre: </td>
      <td width="35%"><input type="text" id="p_nombre" maxlength="30" size="30" required value="<?php echo $ub_p["nombre"];?>"/>
      </td>
    </tr>

    <tr>
      <td class="etiqueta">Actividades:</td>
      <td id="textarea03"><textarea  id="p_actividades" cols="36" rows="4"><?php echo $ub_p["actividades"];?></textarea>
        <span id="Counterror_mess3" class="texto">&nbsp;</span><br />
        <span class="textareaRequiredMsg">El Campo es Requerido.</span>
        <span class="textareaMinCharsMsg">Debe Escribir mas de 4 caracteres.</span>
        <span class="textareaMaxCharsMsg">El maximo de caracteres permitidos es 300.</span></td>

      <td class="etiqueta">Observación:</td>
      <td id="textarea04"><textarea  id="p_observ" cols="36" rows="4"><?php echo $ub_p["observ"];?></textarea>
        <span id="Counterror_mess4" class="texto">&nbsp;</span><br />
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
		 <input type="button" id="volver" value="volver" onClick="Cons_puesto_inicio()" class="readon art-button" />
		 </span>
	</div>
	 <input name="metodo" id="p_metodo" type="hidden"  value="<?php echo $metodo;?>" />

  </fieldset>
</form>
<script type="text/javascript">
var textarea01 = new Spry.Widget.ValidationTextarea("textarea03", {maxChars:300, validateOn:["blur", "change"], counterType:"chars_count", counterId:"Counterror_mess3", useCharacterMasking:false ,isRequired:false});
var textarea02 = new Spry.Widget.ValidationTextarea("textarea04", {maxChars:300, validateOn:["blur", "change"], counterType:"chars_count", counterId:"Counterror_mess4", useCharacterMasking:false ,isRequired:false});
</script>
