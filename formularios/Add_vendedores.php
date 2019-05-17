<?php
$metodo = $_GET['metodo'];
$titulo = $_GET['titulo'];
$tabla   = $_GET['tb'];
$archivo = $_GET['archivo'];
$proced  = 'p_vendedor';

$Nmenu = 437;
require_once('autentificacion/aut_verifica_menu.php');

$archivo2 = "../inicio.php?area=formularios/Cons_$archivo&Nmenu=".$_GET['Nmenu']."&mod=".$_GET['mod']."";

if($metodo == 'modificar'){
	$codigo = $_GET['codigo'];
	$bd = new DataBase();
	$sql = " SELECT vendedores.codigo, vendedores.cod_vend_tipo, vendedor_tipos.descripcion AS vend_tipo,
                    vendedores.cedula, vendedores.nombre,
                    vendedores.telefono, vendedores.direccion,
                    vendedores.email, vendedores.vendedor,
                    vendedores.cobrador, vendedores.coms_vent,
                    vendedores.coms_cob, vendedores.campo01,
                    vendedores.campo02, vendedores.campo03,
                    vendedores.campo04, vendedores.cod_us_ing,
                    vendedores.fec_us_ing, vendedores.cod_us_mod,
                    vendedores.fec_us_mod, vendedores.status
               FROM vendedores , vendedor_tipos
              WHERE vendedores.cod_vend_tipo = vendedor_tipos.codigo
				AND vendedores.codigo = '$codigo'  ";

	$query = $bd->consultar($sql);
	$result=$bd->obtener_fila($query,0);

	$cedula     = $result["cedula"];
	$cod_vend_tipo = $result["cod_vend_tipo"];
	$vend_tipo  = $result["vend_tipo"];
	$cedula     = $result["cedula"];
	$nombre     = $result["nombre"];
	$telefono   = $result["telefono"];
	$direccion  = $result["direccion"];
	$email      = $result["email"];
	$coms_vent  = $result["coms_vent"];
	$coms_cob   = $result["coms_cob"];
	$vendedor   = $result["vendedor"];
	$cobrador   = $result["cobrador"];

	$campo01    = $result["campo01"];
	$campo02    = $result["campo02"];
	$campo03    = $result["campo03"];
	$campo04    = $result["campo04"];
	$activo     = $result["status"];
	}else{
	$codigo     = '';
	$cedula     = '';
	$cod_vend_tipo = '';
	$vend_tipo  = ' Seleccione... ';
	$cedula     = '';
	$nombre     = '';
	$telefono   = '';
	$direccion  = '';
	$email      = '';
	$coms_vent  = '';
	$coms_cob   = '';
	$vendedor   = 'T';
	$cobrador   = 'T';
	$activo     = 'T';
	$campo01    = '';
	$campo02    = '';
	$campo03    = '';
	$campo04    = '';

	}
?>
<form action="scripts/sc_<?php echo $archivo;?>.php" method="post" name="add" id="add">
  <fieldset class="fieldset">
  <legend>DATOS BASICOS <?php echo $titulo;?> </legend>
     <table width="80%" align="center">
    <tr>
      <td class="etiqueta">C&oacute;digo:</td>
      <td id="input01"><input type="text" name="codigo" maxlength="11" style="width:120px" value="<?php echo $codigo;?>" />
               Activo: <input name="activo" type="checkbox"  <?php echo statusCheck("$activo");?> value="T" /><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
	 </tr>
    <tr>
      <td class="etiqueta"><?php echo $leng['ci'];?>: </td>
      <td id="input02"><input type="text" name="cedula" maxlength="20" style="width:150px"
                              value="<?php echo $cedula;?>"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>

    <tr>
      <td class="etiqueta">nombre: </td>
      <td id="input03"><input type="text" name="nombre" maxlength="120" style="width:300px"
                              value="<?php echo $nombre;?>"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>
    <tr>
      <td class="etiqueta">Vendedor Tipo:</td>
      	<td id="select01"><select name="vend_tipo" style="width:250px">
							<option value="<?php echo $cod_vend_tipo;?>"><?php echo $vend_tipo;?></option>
          <?php  	$sql = " SELECT codigo, descripcion FROM vendedor_tipos  WHERE status = 'T' ORDER BY 2 ASC ";
		            $query = $bd->consultar($sql);
            		while($datos=$bd->obtener_fila($query,0)){
		  ?>
          <option value="<?php echo $datos[0];?>"><?php echo $datos[1];?></option>
          <?php }?>
        </select><br />
        	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
    </tr>
    <tr>
      <td class="etiqueta">Tel&eacute;fono: </td>
      <td id="input04"><input type="text" name="telefono" maxlength="60" style="width:250px"
                              value="<?php echo $telefono;?>"/>
		   <img src="imagenes/ok.gif" title="Valid" alt="Valid" class="validMsg" border="0"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>
  <tr>
      <td class="etiqueta">email: </td>
      <td id="email01"><input type="text" name="email" maxlength="60" style="width:250px"
                              value="<?php echo $email;?>"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
           <span class="textfieldInvalidFormatMsg">El Formato Es Invalido</span>
      </td>
    </tr>
    <tr>
      <td class="etiqueta">Direcci&oacute;n:</td>
      <td id="textarea01"><textarea  name="direccion" cols="45" rows="3"><?php echo $direccion;?></textarea>
        <span id="Counterror_mess2" class="texto">&nbsp;</span><br />
        <span class="textareaRequiredMsg">El Campo es Requerido.</span>
        <span class="textareaMinCharsMsg">Debe Escribir mas de 4 caracteres.</span>
        <span class="textareaMaxCharsMsg">El maximo de caracteres permitidos es 300.</span></td>
    </tr>
   <tr>
      <td class="etiqueta">Comisi&oacute;n de Venta: </td>
      <td id="input05"><input type="text" name="coms_vent" maxlength="60" style="width:150px"
                              value="<?php echo $coms_vent;?>"/>
            Vendedor: <input name="vendedor" type="checkbox"  <?php echo statusCheck("$vendedor");?> value="T" /><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>
   <tr>
      <td class="etiqueta">Comision de Cobrador: </td>
      <td id="input06"><input type="text" name="coms_cob" maxlength="60" style="width:150px"
                              value="<?php echo $coms_cob;?>"/>
             Cobrador: <input name="cobrador" type="checkbox"  <?php echo statusCheck("$cobrador");?> value="T" /><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>
    <tr>
      <td class="etiqueta">Campo adiccional 01: </td>
      <td id="campo01"><input type="text" name="campo01" maxlength="60" style="width:300px"
                              value="<?php echo $campo01;?>"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>
    <tr>
      <td class="etiqueta">Campo adiccional 02: </td>
      <td id="campo02"><input type="text" name="campo02" maxlength="60" style="width:300px"
                              value="<?php echo $campo02;?>"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>
    <tr>
      <td class="etiqueta">Campo adiccional 03: </td>
      <td id="campo03"><input type="text" name="campo03" maxlength="60" style="width:300px"
                              value="<?php echo $campo03;?>"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>
    <tr>
      <td class="etiqueta">Campo adiccional 04: </td>
      <td id="campo04"><input type="text" name="campo04" maxlength="60" style="width:300px"
                              value="<?php echo $campo04;?>"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
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
  		    <input name="metodo" id="metodo" type="hidden"  value="<?php echo $metodo;?>" />
             <input name="proced" id="proced" type="hidden"  value="<?php echo $proced;?>" />
            <input name="tabla" id="tabla" type="hidden"  value="<?php echo $tabla;?>" />
            <input name="usuario" id="usuario" type="hidden"  value="<?php echo $usuario;?>" />
	        <input name="href" type="hidden" value="<?php echo $archivo2;?>"/>
                 </div>
  </fieldset>
  </form>
  <script type="text/javascript">
var input01  = new Spry.Widget.ValidationTextField("input01", "none", {validateOn:["blur", "change"]});
var input02  = new Spry.Widget.ValidationTextField("input02", "integer", {validateOn:["blur", "change"], useCharacterMasking:true});
var input03  = new Spry.Widget.ValidationTextField("input03", "none", {validateOn:["blur", "change"]});
var input04  = new Spry.Widget.ValidationTextField("input04", "none", {validateOn:["blur", "change"],isRequired:false});
var input05  = new Spry.Widget.ValidationTextField("input05", "currency", {format:"comma_dot", validateOn:["blur", "change"],useCharacterMasking:true , isRequired:false});
var input06  = new Spry.Widget.ValidationTextField("input06","currency", {format:"comma_dot", validateOn:["blur", "change"],useCharacterMasking:true , isRequired:false});

var email01    = new Spry.Widget.ValidationTextField("email01", "email", {validateOn:["blur"],isRequired:false});

var select01 = new Spry.Widget.ValidationSelect("select01", {validateOn:["blur", "change"]});

var textarea01 = new Spry.Widget.ValidationTextarea("textarea01", {maxChars:300, validateOn:["blur", "change"], counterType:"chars_count", counterId:"Counterror_mess2", useCharacterMasking:false ,isRequired:false});

var campo01  = new Spry.Widget.ValidationTextField("campo01", "none", {validateOn:["blur", "change"],isRequired:false});
var campo02  = new Spry.Widget.ValidationTextField("campo02", "none", {validateOn:["blur", "change"],isRequired:false});
var campo03  = new Spry.Widget.ValidationTextField("campo03", "none", {validateOn:["blur", "change"],isRequired:false});
var campo04  = new Spry.Widget.ValidationTextField("campo04", "none", {validateOn:["blur", "change"],isRequired:false});
</script>
