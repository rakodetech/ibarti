<?php
$metodo = $_GET['metodo'];
$titulo = "ACTIVIDADES EN PUESTO DE CLIENTES ";
$archivo = $_GET['archivo'];
$cod     = $_GET['cod'];
$proced = "p_cl_actividades";
$archivo2 = "../inicio.php?area=maestros/Cons_$archivo&Nmenu=".$_GET['Nmenu']."&mod=".$_GET['mod']."&codigo=".$_GET['cod']."";

if($metodo == 'modificar'){
	$codigo = $_GET['codigo'];
	$bd = new DataBase();
 	$sql = " SELECT cl_actividades.descripcion, cl_actividades.observacion,
                  cl_puesto.descripcion puesto,
									cl_actividades.cod_us_ing, cl_actividades.fec_us_ing,
									cl_actividades.cod_us_mod, cl_actividades.fec_us_mod, cl_actividades.`status`
             FROM cl_actividades, cl_puesto
						WHERE cl_actividades.codigo = '$codigo'
						  AND cl_actividades.cod_puesto = cl_puesto.codigo  ";
	$query = $bd->consultar($sql);
	$result=$bd->obtener_fila($query,0);

	$descripcion   = $result['descripcion'];
	$observ        = $result['observacion'];
	$status        = $result['status'];

	}else{

	$codigo        = '';
	$descripcion   = '';
	$observ        = '';
	$status        = 'T';

	}
?>
<div id="Contenedor" class="mensaje"></div>

<form action="sc_maestros/sc_<?php echo $archivo;?>.php" method="post" name="add" id="add">
  <fieldset class="fieldset">
  <legend>DATOS BASICOS <?php echo $titulo;?> </legend>
     <table width="80%" align="center">
    <tr>
      <td class="etiqueta">C&oacute;digo:</td>
      <td id="input01"><input type="text" name="codigo" maxlength="11" style="width:120px" readonly value="<?php echo $codigo;?>" />
        Activo: <input name="activo" type="checkbox"  <?php echo statusCheck("$status");?> value="T"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
	 </tr>
    <tr>
      <td class="etiqueta">Descripci&oacute;n: </td>
      <td id="input02"><input type="text" name="descripcion" maxlength="120" style="width:250px"
                              value="<?php echo $descripcion;?>"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>

 	<tr>
      <td class="etiqueta">Observaci&oacute;n:</td>
      <td id="textarea01" colspan="3"><textarea  name="observ" cols="50" rows="3"><?php echo $observ;?></textarea>
        <span id="Counterror_mess1" class="texto">&nbsp;</span><br />
         <span class="textareaMaxCharsMsg">El maximo de caracteres permitidos es 255.</span></td>
     </tr>

	 <tr>
         <td height="8" colspan="2" align="center"><hr></td>
     </tr>
  </table>
  <div align="center"><span class="art-button-wrapper">
                    <span class="art-button-l"> </span>
                    <span class="art-button-r"> </span>
                <input type="submit" name="salvar"  id="salvar" value="Guardar" class="readon art-button" />
                </span>&nbsp;
             <span class="art-button-wrapper">
                    <span class="art-button-l"> </span>
                    <span class="art-button-r"> </span>
                <input type="reset" id="limpiar" value="Restablecer" class="readon art-button" />
                </span>&nbsp;
             <span class="art-button-wrapper">
                    <span class="art-button-l"> </span>
                    <span class="art-button-r"> </span>
                <input type="button" id="volver" value="Volver" onClick="history.back(-1);" class="readon art-button" />
                </span>
   </div>

  		    <input name="cod" id="cod" type="hidden"  value="<?php echo $cod;?>" />
            <input name="metodo" id="metodo" type="hidden"  value="<?php echo $metodo;?>" />
   		    <input name="proced" id="proced" type="hidden"  value="<?php echo $proced;?>" />
            <input name="usuario" id="usuario" type="hidden"  value="<?php echo $usuario;?>" />
	        <input name="href" type="hidden" value="<?php echo $archivo2;?>"/>
  </fieldset>
</form>
  <script type="text/javascript">
var input02  = new Spry.Widget.ValidationTextField("input02", "none", {validateOn:["blur", "change"]});

var textarea01 = new Spry.Widget.ValidationTextarea("textarea01", {maxChars:255, validateOn:["blur", "change"], counterType:"chars_count", counterId:"Counterror_mess1", useCharacterMasking:false , isRequired:false});

</script>
