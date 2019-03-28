<div id="Contenedor01" class="mensaje"></div>
     <table width="70%" align="center">
<!--
         <tr valign="top">                    
		     <td height="23" colspan="2" class="etiqueta_title" align="center"> MODIFICAR DOCUMENTOS </td>
         </tr>		 
-->		 
         <tr> 
            <td height="8" colspan="2" align="center"><hr></td>
         </tr>	 
    <tr>
      <td class="etiqueta" width="25%">C&oacute;digo:</td>
      <td id="input01" width="75%"><input type="text" name="codigo" id="codigo" maxlength="12" style="width:120px" 
	                                      value="<?php echo $id;?>" />	  
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br>
        <span class="textfieldRequiredMsg">La Descripcion es Requerida.</span>
		<span class="textfieldMinCharsMsg">Debe Escribir mínimo 2 Caracteres.</span></td>
    </tr>
    <tr>
      <td class="etiqueta" width="25%">Descripci&oacute;n:</td>
      <td id="input02" width="75%"><input type="text" name="descripcion" id="descripcion" maxlength="120" 
                                          style="width:250px" value="<?php echo $row01[1]?>"/>	  
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br>
        <span class="textfieldRequiredMsg">La Descripcion es Requerida.</span>
		<span class="textfieldMinCharsMsg">Debe Escribir mínimo 2 Caracteres.</span></td>
    </tr>		
     <tr>
	     <td height="20" class="etiqueta">Status:</td>
	     <td  id="select01">		    
			   <select name="status" id="status" style="width:120px;">	 
     				   <option value="<?php echo $row01[2];?>"> <?php echo statuscal($row01[2]);?> </option>
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
             <input type="hidden"  id="metodo" name="metodo" value="" />
			 <input type="hidden"  name="tab" id="tab" value="<?php echo $tab;?>" />
	         <input name="usuario" type="hidden"  value="<?php echo $usuario;?>" />			 
			 <input type="hidden"  name="codigo_old" id="codigo_old" value="<?php echo $codigo_old?>"/>
			 <input type="hidden"  name="href" value="../inicio.php?area=pestanas_maestro/<?php echo ''.$pestana.'&Nmenu='.$_GET["Nmenu"].''?>"/>
             <input type="hidden"  id="lim"  value="0">          
             
			 </td>
	   </tr>
  </table>
</body>
</html>
<script language="javascript" type="text/javascript">
var input01  = new Spry.Widget.ValidationTextField("input01", "none", {minChars:2, validateOn:["blur", "change"]});
var input02  = new Spry.Widget.ValidationTextField("input02", "none", {minChars:2, validateOn:["blur", "change"]});
var select01 = new Spry.Widget.ValidationSelect("select01", {validateOn:["blur", "change"]});
</script>