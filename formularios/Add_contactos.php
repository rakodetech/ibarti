<link rel="stylesheet" type="text/css" href="latest/stylesheets/autocomplete.css" />
<script type="text/javascript" src="latest/scripts/autocomplete.js"></script>
<?php 
$Nmenu = $_GET['Nmenu'];
$titulo = " AGREGAR CONTACTOS ";
$archivo = "contactos";
$metodo  = "agregar";

require_once('autentificacion/aut_verifica_menu.php');
?>
<form action="scripts/sc_<?php echo $archivo;?>.php" method="post" name="add" id="add"> 
     <table width="80%" align="center">
         <tr valign="top">                    
		     <td height="23" colspan="2" class="etiqueta_title" align="center"><?php echo $titulo;?></td>
         </tr>
         <tr> 
    	       <td height="8" colspan="2" align="center"><hr></td>    
     	</tr>
    <tr>
      <td class="etiqueta">Fecha Recepcion:</td>
      <td id="fecha01"><input type="text" name="fecha_recep" id="fecha_recep" size="10" value=""/><br />
            <span class="textfieldRequiredMsg">La Fecha Es Requerida.</span>
            <span class="textfieldInvalidFormatMsg">El Formato Es Invalido</span></td>
    </tr>    
    <tr>
      <td class="etiqueta">Cliente:</td>
      	<td id="select01"><select name="cliente" style="width:250px">
							<option value="">Seleccione...</option>                            
          <?php  
		  					   $sql  = " SELECT cont_clientes.codigo, cont_clientes.descripcion
                                            FROM cont_clientes
                                           WHERE cont_clientes.`status` = 1 ORDER BY 2 ASC ";
                    	$query  = $bd->consultar($sql);
						while($row02=$bd->obtener_fila($query,0)){
	
		  ?>
          <option value="<?php echo $row02[0];?>"><?php echo $row02[1];?></option>
          <?php }?>		  	  
        </select><br />
        	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
    </tr>
    <tr>
    <td class="etiqueta" >Representante:</td>
    <td id="input01"><input type="text" id="representante" name="representante" maxlength="120"  size="30" /> <br />
        <span class="textfieldRequiredMsg">El Campo es Requerido.</span>
        <span class="textfieldMinCharsMsg">Debe Escribir m&aacute;s de 4 caracteres.</span></td>
    </tr>    
    <tr>
      <td class="etiqueta">Cargo:</td>
      <td id="input02"><input type="text" id="cargo" name="cargo" maxlength="60" size="30" /> <br />
        <span class="textfieldRequiredMsg">El Campo es Requerido.</span>
        <span class="textfieldMinCharsMsg">Debe Escribir m&aacute;s de 4 caracteres.</span></td>
    </tr>    
    <tr>
      <td class="etiqueta">Tel&eacute;fonos:</td>
      <td id="input03">
      <input type="texto" name="telefono" size="30" maxlength="60"/><br /> 
      <span class="textfieldRequiredMsg">El Campo es Requerido.</span> 
        <span class="textfieldMinCharsMsg">Debe Escribir m&aacute;s de 11 caracteres.</span></td>
    </tr>
	<tr>
      <td class="etiqueta">Email:</td>
      <td id="email"><input name="email" type="text" maxlength="60" size="30" ><br />
        <span class="textfieldRequiredMsg">El Campo es Requerido.</span>
        <span class="textfieldMinCharsMsg">Debe Escribir m&aacute;s de 4 caracteres.</span></td>
    </tr>
    <tr>
      <td class="etiqueta">Descripcion:</td>
      <td id="textarea01"><textarea  name="descripcion" cols="45" rows="3"></textarea>
        <span id="Counterror_mess1" class="texto">&nbsp;</span><br />
        <span class="textareaRequiredMsg">El Campo es Requerido.</span>
        <span class="textareaMinCharsMsg">Debe Escribir mas de 10 caracteres.</span>
        <span class="textareaMaxCharsMsg">El maximo de caracteres permitidos es 255.</span></td>
    </tr>      
    <tr> 
      <td class="etiqueta">Prioridad:</td>
      	<td id="select02"><select name="prioridad" style="width:250px">
							<option value="">Seleccione...</option>
          <?php  
					   $sql  = " SELECT codigo, descripcion FROM cont_prioridad
                                          WHERE `status` = 'T'  ORDER BY 2 ASC ";
                    	$query  = $bd->consultar($sql);
						while($row02=$bd->obtener_fila($query,0)){		  

		  ?>
          <option value="<?php echo $row02[0];?>"><?php echo $row02[1];?></option>
          <?php }?>		  	  
        </select><br />
        	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
    </tr>
    <tr>
      <td class="etiqueta">Tipo de contacto:</td>
      	<td id="select03"><select name="tipo_contacto" style="width:250px">
							<option value="">Seleccione...</option>
          <?php 
					   $sql  = " SELECT codigo, descripcion FROM cont_tipo_contacto
                                          WHERE `status` = 'T'  ORDER BY 2 ASC ";
                    	$query  = $bd->consultar($sql);
						while($row02=$bd->obtener_fila($query,0)){		  		  
		 		  ?>
          <option value="<?php echo $row02[0];?>"><?php echo $row02[1];?></option>
          <?php }?>		  	  
        </select><br />
        	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
    </tr>    
    <tr>    
      <td class="etiqueta">Tipos de Requerimientos:</td>
      <td>				
			<table width="100%" border="0">
			    <tr>
      				<td class="etiqueta" width="60%">REQUERIMIENTOS:</td>
					<td class="etiqueta" width="20%">CHECK:</td>
                    <td width="20%">&nbsp;</td>
    			</tr>
			<?php 
					   $sql  = " SELECT codigo, descripcion FROM cont_tipo_req
                                     WHERE `status` = 'T' ";
                    	$query  = $bd->consultar($sql);
						while($row02=$bd->obtener_fila($query,0)){		  		  
			
				echo'<tr>
						<td class="texto">'.$row02[0].' - '.$row02[1].'</td>
						<td >&nbsp;&nbsp;<input name="requerimiento[]" type="checkbox" value="'.$row02[0].'"                                          style="width:auto" /></td>	
							<td>&nbsp;</td>
						</tr>';
					}?>	
		</table>
      </td>
	</tr>
    <tr>
      <td class="etiqueta">status de Negocio:</td>
      	<td id="select04"><select name="status_negocio" style="width:250px">
							<option value="">Seleccione...</option>

          <?php
					   $sql  = "SELECT codigo, descripcion FROM cont_status_negocios
                                          WHERE `status` = 'T'  ORDER BY 2 ASC ";
                    	$query  = $bd->consultar($sql);
						while($row02=$bd->obtener_fila($query,0)){		  		  		  
		  ?>
          <option value="<?php echo $row02[0];?>"><?php echo $row02[1];?></option>
          <?php }?>		  	  
        </select><br />
        	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
    </tr>
    <tr>
      <td class="etiqueta">Status De Contacto:</td>
      	<td id="select05"><select name="status_contacto" style="width:250px">
							<option value="">Seleccione...</option>
          <?php
					   $sql  = " SELECT codigo, descripcion FROM cont_status
                                          WHERE `status` = 'T'  ORDER BY 2 ASC ";
                    	$query  = $bd->consultar($sql);
						while($row02=$bd->obtener_fila($query,0)){		  		  		  
		  ?>
          <option value="<?php echo $row02[0];?>"><?php echo $row02[1];?></option>
          <?php }?>		  	  
        </select><br />
        	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
    </tr>        
    
         <tr> 
            <td height="8" colspan="2" align="center"><br />              <hr></td>
         </tr>	
         <tr> 
		     <td colspan="2" align="center">
             <span class="art-button-wrapper">
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
		    <input name="metodo" type="hidden"  value="<?php echo $metodo;?>" />
			<input name="usuario" type="hidden"  value="<?php echo $usuario;?>" />
	        <input name="href" type="hidden" value="../inicio.php?area=formularios/Cons_<?php echo $archivo."&Nmenu=".$Nmenu;?>"/>	   			
		     </td>
	   </tr>
  </table>
</form>
</body>
</html>
<script type="text/javascript">

var fecha01 = new Spry.Widget.ValidationTextField("fecha01", "date", {format:"dd-mm-yyyy", hint:"DD-MM-AAAA", validateOn:["blur", "change"], useCharacterMasking:true, isRequired:true});

var input01 = new Spry.Widget.ValidationTextField("input01", "none", {validateOn:["blur", "change"]});
var input02 = new Spry.Widget.ValidationTextField("input02", "none", {validateOn:["blur", "change"]});
var input03 = new Spry.Widget.ValidationTextField("input03", "none", {validateOn:["blur", "change"],isRequired:false});

var email    = new Spry.Widget.ValidationTextField("email", "email", {minChars:4, validateOn:["blur"]});

var select01 = new Spry.Widget.ValidationSelect("select01", {validateOn:["blur", "change"]});
var select02 = new Spry.Widget.ValidationSelect("select02", {validateOn:["blur", "change"]});
var select03 = new Spry.Widget.ValidationSelect("select03", {validateOn:["blur", "change"]});
var select04 = new Spry.Widget.ValidationSelect("select04", {validateOn:["blur", "change"]});
var select05 = new Spry.Widget.ValidationSelect("select05", {validateOn:["blur", "change"]});

var textarea01 = new Spry.Widget.ValidationTextarea("textarea01", {minChars:4, maxChars:255, validateOn:["blur", "change"], counterType:"chars_count", counterId:"Counterror_mess2", useCharacterMasking:false ,isRequired:false});
</script>