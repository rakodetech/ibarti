<?php
$archivo = "pres_clientes";
$href    = "pres_clientes&Nmenu=".$_GET['Nmenu']."";
$codigo  = $_GET['codigo']; 

$result01 = mysql_query("SELECT pres_clientes.codigo, pres_clientes.descripcion,
pres_clientes.codigo_pres_clientes_tipo, pres_clientes_tipo.descripcion AS tipo,
pres_clientes.contacto, pres_clientes.direccion,
pres_clientes.telefonos, pres_clientes.`status`
FROM pres_clientes , pres_clientes_tipo
WHERE pres_clientes.codigo = ".$codigo."  AND
pres_clientes.codigo_pres_clientes_tipo = pres_clientes_tipo.codigo", $cnn);  
$row01    = mysql_fetch_array($result01);
?>
<form action="sc_maestros/<?php echo $archivo;?>.php" method="post" name="Mod" id="Mod"> 
     <table width="70%" align="center">
         <tr valign="top">                    
		     <td height="23" colspan="2" class="etiqueta_title" align="center"> MODIFICAR CLIENTES </td>
         </tr>
         <tr> 
            <td height="8" colspan="2" align="center"><hr></td>
         </tr>	 
    <tr>
      <td class="etiqueta" width="25%">C&oacute;digo:</td>
      <td id="input01" width="75%"><input type="text" name="codigo" maxlength="12" style="width:120px" 
                                          value="<?php echo $row01["codigo"];?>"/>	  
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br>
        <span class="textfieldRequiredMsg">La Descripcion es Requerida.</span>
		<span class="textfieldMinCharsMsg">Debe Escribir mínimo 2 Caracteres.</span></td>
    </tr>
    <tr>
      <td class="etiqueta">Descripci&oacute;n:</td>
      <td id="input02"><input type="text" name="descripcion" maxlength="60" style="width:250px"       
                              value="<?php echo $row01["descripcion"];?>"/>	  
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br>
        <span class="textfieldRequiredMsg">La Descripcion es Requerida.</span>
		<span class="textfieldMinCharsMsg">Debe Escribir mínimo 2 Caracteres.</span></td>
    </tr>		
     <tr>
	     <td class="etiqueta">Tipo:</td>
	     <td id="select01">		    
			   <select name="tipo" style="width:200px;">	 
     				   <option value="<?php echo $row01["codigo_pres_clientes_tipo"];?>"><?php echo $row01["tipo"];?></option>
					   <?php 
					   $query03 = mysql_query("SELECT codigo, descripcion FROM pres_clientes_tipo
                                                WHERE `status` = 1  ORDER BY 2 ASC ", $cnn);
					   while($row03=(mysql_fetch_array($query03))){
					   echo '<option value="'.$row03[0].'">'.$row03[1].'</option>';
					   }
					   ?>    
	           </select><img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br />
       	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
    </tr>			
    <tr>
      <td class="etiqueta">Telefeno:</td>
      <td id="input03"><input type="text" name="telefonos" style="width:250px" maxlength="60" value="<?php echo $row01["telefonos"];?>"/>	
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br>
        <span class="textfieldRequiredMsg">La Descripcion es Requerida.</span>
		<span class="textfieldMinCharsMsg">Debe Escribir mínimo 4 Caracteres.</span></td>
    </tr>
    <tr>
      <td class="etiqueta">Direccion:</td>
      <td id="textarea01"><textarea  name="direccion" cols="45" rows="3"><?php echo $row01["direccion"];?></textarea>
        <span id="Counterror_mess2" class="texto">&nbsp;</span> 
        <img src="imagenes/ok.gif" alt="Valido" class="validMsg" border="0"/><br />
        <span class="textareaRequiredMsg">El Campo es Requerido.</span>
        <span class="textareaMinCharsMsg">Debe Escribir mas de 4 caracteres.</span>
        <span class="textareaMaxCharsMsg">El maximo de caracteres permitidos es 120.</span></td>
    </tr>	
    <tr>
      <td class="etiqueta">Contacto:</td>
      <td id="input04"><input type="text" name="contacto" maxlength="60" style="width:300px" value="<?php echo $row01["contacto"];?>"/>	
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br>
        <span class="textfieldRequiredMsg">La Descripcion es Requerida.</span>
		<span class="textfieldMinCharsMsg">Debe Escribir mínimo 4 Caracteres.</span></td>
    </tr>
     <tr>
	     <td height="20" class="etiqueta">Status:</td>
	     <td  id="select10">		    
			   <select name="status" style="width:120px;">	 
     				   <option value="<?php echo $row01["status"];?>"><?php echo statuscal($row01["status"]);?></option>
					   <option value="1"> Activo </option>
                       <option value="2"> Inactivo </option>    
	           </select><img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br />
       	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
    </tr>
          <tr>
              <td colspan="2" align="center"><hr></td>
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
			<input type="hidden"  name="metodo" value="Modificar"/>
           <input name="usuario" type="hidden"  value="<?php echo $usuario;?>" />			
			<input type="hidden"  name="href" value="../inicio.php?area=maestros/Cons_<?php echo $href;?>" />	 			
			 </td>
	   </tr>
  </table>
</form>
</body>
</html>
<script language="javascript" type="text/javascript">
var input01 = new Spry.Widget.ValidationTextField("input01", "none", {minChars:2, validateOn:["blur", "change"]});
var input02 = new Spry.Widget.ValidationTextField("input02", "none", {minChars:2, validateOn:["blur", "change"]});
var input03 = new Spry.Widget.ValidationTextField("input03", "none", {minChars:1, validateOn:["blur", "change"]});
var input04 = new Spry.Widget.ValidationTextField("input04", "none", {minChars:1, validateOn:["blur", "change"]});


var textarea01 = new Spry.Widget.ValidationTextarea("textarea01", {minChars:4, maxChars:120, validateOn:["blur", "change"], counterType:"chars_count", counterId:"Counterror_mess2", useCharacterMasking:false }); <!--isRequired:false -->

var select01 = new Spry.Widget.ValidationSelect("select01", {validateOn:["blur", "change"]});

var select10 = new Spry.Widget.ValidationSelect("select10", {validateOn:["blur", "change"]});
</script>