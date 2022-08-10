<?php 
$metodo = $_GET['metodo'];
if(isset($_GET['codigo'])){
		$codigo = $_GET['codigo'];
		$tabla   = "empresa";
		$archivo = "empresa"; 
		$archivo2 = "autentificacion/cons_empresa&Nmenu=".$_GET['Nmenu'].""; 
//		require_once('../bd/class_postgresql.php');
		$bd = new DataBase();
	$sql = " SELECT codigo, descripcion, rif, telefono, direccion
               FROM empresa WHERE codigo = '$codigo' ";
	$query = $bd->consultar($sql);
	$result=$bd->obtener_fila($query,0);
	  	   
	$codigo      = $result['codigo'];
	$descripcion = $result['descripcion'];
	$rif         = $result['rif'];
	$telefono    = $result['telefono'];
	$direccion   = $result['direccion'];
	}else{
	$codigo      = '';
	$descripcion = '';
	$rif         = '';
	$telefono    = '';
	$direccion   = '';
	}
?>
<form action="autentificacion/sc_<?php echo $archivo;?>.php" method="post" name="add" id="add"> 
  <fieldset class="fieldset">
  <legend>Datos Básicos Empresas </legend>
     <table width="80%" align="center">
    <tr>
      <td class="etiqueta">Codigo:</td>
      <td id="input01"><input type="text" name="codigo" maxlength="11" style="width:120px"      
                              value="<?php echo $codigo;?>" />
           <img src="imagenes/ok.gif" title="Valid" alt="Valid" class="validMsg" border="0"/>
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
	 </tr>
    <tr>
      <td class="etiqueta">RIF:</td>
      <td id="input02">
      <input type="text" name="rif" maxlength="60" style="width:200px" value="<?php echo $rif;?>"/>
		   <img src="imagenes/ok.gif" title="Valid" alt="Valid" class="validMsg" border="0"/>
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
	 </tr>
    <tr>
      <td class="etiqueta">Empresa: </td>
      <td id="input03"><input type="text" name="empresa" maxlength="60" style="width:200px" 
                              value="<?php echo $descripcion;?>"/>
		   <img src="imagenes/ok.gif" title="Valid" alt="Valid" class="validMsg" border="0"/>
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>	
    <tr>
      <td class="etiqueta">Telefono: </td>
      <td id="input04"><input type="text" name="telefono" maxlength="60" style="width:200px" 
                              value="<?php echo $telefono;?>" />
		   <img src="imagenes/ok.gif" title="Valid" alt="Valid" class="validMsg" border="0"/>
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
         </td>
    </tr>	
    <tr>
      <td class="etiqueta">Direcci&oacute;n:</td>
      <td id="textarea01"><textarea  name="direccion" cols="45" rows="3"><?php echo $direccion;?></textarea>
        <span id="Counterror_mess1" class="texto">&nbsp;</span> 
        <img src="imagenes/ok.gif" alt="Valido" class="validMsg" border="0"/>
        <span class="textareaRequiredMsg">El Campo es Requerido.</span>       
        <span class="textareaMaxCharsMsg">El maximo de caracteres permitidos es 255.</span>
      </td>
    </tr>
	 <tr> 
         <td height="8" colspan="2" align="center"><hr></td>
     </tr>	
     <tr> 
         <td colspan="2" align="center">
        <input  type="submit" name="salvar"  id="salvar" value="Guardar" class="button1"
                               onMouseOver="Fondos (this.id ,'A',  'button1Act', 'button1')" 
                               onMouseOut="Fondos (this.id ,'D', 'button1Act', 'button1')">	&nbsp;
        <input type="reset"     id="limpiar"  value="Restablecer" class="button1"
                               onMouseOver="Fondos (this.id ,'A',  'button1Act', 'button1')" 
                               onMouseOut="Fondos (this.id ,'D', 'button1Act', 'button1')">	&nbsp;
        <input type="button"   id="volver"  value="Volver" onClick="history.back(-1);"  class="button1"
                               onMouseOver="Fondos (this.id ,'A',  'button1Act', 'button1')" 
                               onMouseOut="Fondos (this.id ,'D', 'button1Act', 'button1')">
         </td>
   </tr>
  </table>
  		    <input name="metodo" id="metodo" type="hidden"  value="<?php echo $metodo;?>" />
		    <input name="codigo_old" type="hidden"  value="<?php echo $codigo;?>" />
            <input name="tabla" id="tabla" type="hidden"  value="<?php echo $tabla;?>" />            
            <input name="usuario" id="usuario" type="hidden"  value="<?php echo $usuario;?>" />            
	        <input name="href" type="hidden" value="../inicio.php?area=<?php echo $archivo2;?>"/>		   			
  </fieldset>
  </form>
  <script type="text/javascript">
var input01  = new Spry.Widget.ValidationTextField("input01", "none", {validateOn:["blur", "change"]});
var input02  = new Spry.Widget.ValidationTextField("input02", "none", {validateOn:["blur", "change"]});
var input03  = new Spry.Widget.ValidationTextField("input03", "none", {validateOn:["blur", "change"]});
var input04  = new Spry.Widget.ValidationTextField("input04", "none", {validateOn:["blur", "change"]});

var textarea01 = new Spry.Widget.ValidationTextarea("textarea01", {maxChars:255, validateOn:["blur", "change"], counterType:"chars_count", counterId:"Counterror_mess1", useCharacterMasking:false});
</script>