<?php
$id       = $_GET['id'];
// $result01 = mysql_query("SELECT * FROM documentos WHERE id = '$id'", $cnn);  
// $row01    = mysql_fetch_array($result01);

?>
     <table width="70%" align="center">      
	  <!--   <tr valign="top">                    
		     <td height="23" colspan="2" class="etiqueta_title" align="center"> MODIFICAR DOCUMENTOS </td>
         </tr>
		 -->
         <tr> 
            <td height="8" colspan="2" align="center"><hr></td>
         </tr>	 
    <tr>
      <td class="etiqueta" width="25%">Campo 1:</td>
      <td id="input02" width="75%"><input type="text" name="ad01" id="ad01" maxlength="60" style="width:250px"/>	  
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br>
        <span class="textfieldRequiredMsg">La Descripcion es Requerida.</span>
		<span class="textfieldMinCharsMsg">Debe Escribir mínimo 2 Caracteres.</span></td>
    </tr>
    <tr>
      <td class="etiqueta">Campo 2:</td>
      <td id="input02"><input type="text" name="ad02" id="ad02" maxlength="60" style="width:250px"/>	  
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br>
        <span class="textfieldRequiredMsg">La Descripcion es Requerida.</span>
		<span class="textfieldMinCharsMsg">Debe Escribir mínimo 2 Caracteres.</span></td>
    </tr>		
    <tr>
      <td class="etiqueta">Campo 3:</td>
      <td id="input02"><input type="text" name="ad03" id="ad03" maxlength="60" style="width:250px"/>	  
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br>
        <span class="textfieldRequiredMsg">La Descripcion es Requerida.</span>
		<span class="textfieldMinCharsMsg">Debe Escribir mínimo 2 Caracteres.</span></td>
    </tr>			
    <tr>
      <td class="etiqueta">Campo 4:</td>
      <td id="input02"><input type="text" name="ad04" id="ad04" maxlength="60" style="width:250px"/>	  
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br>
        <span class="textfieldRequiredMsg">La Descripcion es Requerida.</span>
		<span class="textfieldMinCharsMsg">Debe Escribir mínimo 2 Caracteres.</span></td>
    </tr>		
    <tr>
      <td class="etiqueta">Campo 5:</td>
      <td id="input02"><input type="text" name="ad05" id="ad05" maxlength="60" style="width:250px"/>	  
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br>
        <span class="textfieldRequiredMsg">La Descripcion es Requerida.</span>
		<span class="textfieldMinCharsMsg">Debe Escribir mínimo 2 Caracteres.</span></td>
    </tr>		
    <tr>
      <td class="etiqueta">Campo 6:</td>
      <td id="input02"><input type="text" name="ad06" id="ad06" maxlength="60" style="width:250px"/>	  
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br>
        <span class="textfieldRequiredMsg">La Descripcion es Requerida.</span>
		<span class="textfieldMinCharsMsg">Debe Escribir mínimo 2 Caracteres.</span></td>
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
 			 </td>
	   </tr>
  </table>
</body>
</html>
<script language="javascript" type="text/javascript">
//var input01 = new Spry.Widget.ValidationTextField("input01", "none", {minChars:2, validateOn:["blur", "change"]});
var input02 = new Spry.Widget.ValidationTextField("input02", "none", {minChars:2, validateOn:["blur", "change"]});
var select01 = new Spry.Widget.ValidationSelect("select01", {validateOn:["blur", "change"]});
</script>