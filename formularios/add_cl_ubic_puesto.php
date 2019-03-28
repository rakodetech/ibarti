<script language="javascript">

$("#cl_p_form").on('submit', function(evt){
	 evt.preventDefault();
	 save_puesto();
});


	</script>
<?php
define("SPECIALCONSTANT", true);
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bdI);

	$proced      = "p_clientes_ubic";
  $codigo      = $_POST['codigo'];
	$metodo      = $_POST['metodo'];
if($metodo == 'modificar'){
$titulo = "Modificar Puesto De Trabajo";
	$bd = new DataBase();
	$sql = " SELECT a.*, clientes.nombre cliente, clientes.abrev, clientes_ubicacion.descripcion ubic
FROM clientes_ub_puesto a, clientes, clientes_ubicacion
            WHERE  a.cod_cliente = clientes.codigo
AND a.cod_cl_ubicacion  = clientes_ubicacion.codigo
AND a.codigo =  '$codigo'";

	$query = $bd->consultar($sql);
	$result=$bd->obtener_fila($query,0);


	$nombre       = $result["nombre"];
	$actividades  = $result["actividades"];
	$observ       = $result["observ"];
	$activo       = $result["status"];

	}else{
	$titulo = "Agregar Puesto De Trabajo";
	$codigo       = '';
	$nombre       = '';
	$actividades  = '';
	$observ       = '';
	$activo      = 'T';

	}
?>

<form id="cl_p_form" name="cl_p_form" method="post">
<fieldset class="fieldset">
  <legend>Datos <?php echo $titulo;?></legend>
     <table width="90%" align="center">
    <tr>
      <td width="15%" class="etiqueta">C&oacute;digo:</td>
      <td width="35%"><input type="text" id="p_codigo" name="p_codigo" maxlength="11" size="15" value="<?php echo $codigo;?>" readonly  />
               Activo: <input id="p_activo" name="p_activo" type="checkbox"  <?php echo statusCheck("$activo");?> value="T" />
      </td>

      <td width="15%" class="etiqueta">Nombre: </td>
      <td width="35%"><input type="text" name="p_nombre" id="p_nombre" maxlength="30" size="30" required value="<?php echo $nombre;?>"/>
      </td>
    </tr>

    <tr>
      <td class="etiqueta">Actividades:</td>
      <td id="textarea03"><textarea  name="p_actividades" id="p_actividades" cols="36" rows="4"><?php echo $actividades;?></textarea>
        <span id="Counterror_mess3" class="texto">&nbsp;</span><br />
        <span class="textareaRequiredMsg">El Campo es Requerido.</span>
        <span class="textareaMinCharsMsg">Debe Escribir mas de 4 caracteres.</span>
        <span class="textareaMaxCharsMsg">El maximo de caracteres permitidos es 300.</span></td>

      <td class="etiqueta">Observación:</td>
      <td id="textarea04"><textarea  name="p_observ" id="p_observ" cols="36" rows="4"><?php echo $observ;?></textarea>
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
		 <input type="button" id="volver" value="volver" onClick="volverP()" class="readon art-button" />
		 </span>
	</div>
	 <input name="metodo" id="p_metodo" type="hidden"  value="<?php echo $metodo;?>" />

  </fieldset>
</form>

<script type="text/javascript">
var textarea01 = new Spry.Widget.ValidationTextarea("textarea03", {maxChars:300, validateOn:["blur", "change"], counterType:"chars_count", counterId:"Counterror_mess3", useCharacterMasking:false ,isRequired:false});
var textarea02 = new Spry.Widget.ValidationTextarea("textarea04", {maxChars:300, validateOn:["blur", "change"], counterType:"chars_count", counterId:"Counterror_mess4", useCharacterMasking:false ,isRequired:false});
</script>
