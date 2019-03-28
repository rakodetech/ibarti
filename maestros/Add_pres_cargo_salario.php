<?php

$archivo = "pres_cargo_salario";
$href    = "pres_cargo_salario&Nmenu=".$_GET['Nmenu']."";
?>
<form action="sc_maestros/<?php echo $archivo;?>.php" method="post" name="Mod" id="Mod"> 
     <table width="70%" align="center">
         <tr valign="top">                    
		     <td height="23" colspan="2" class="etiqueta_title" align="center"> AGREGAR CARGOS Y SALARIOS </td>
         </tr>
         <tr> 
            <td height="8" colspan="2" align="center"><hr></td>
         </tr>	 
    <tr>
      <td class="etiqueta" width="25%">C&oacute;digo:</td>
      <td id="input01" width="75%"><input type="text" name="codigo" maxlength="12" style="width:120px" value="" />	  
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br>
        <span class="textfieldRequiredMsg">La Descripcion es Requerida.</span>
		<span class="textfieldMinCharsMsg">Debe Escribir mínimo 2 Caracteres.</span></td>
    </tr>
    <tr>
      <td class="etiqueta">Descripci&oacute;n:</td>
      <td id="input02"><input type="text" name="descripcion" maxlength="60" value="" style="width:250px" />	  
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br>
        <span class="textfieldRequiredMsg">La Descripcion es Requerida.</span>
		<span class="textfieldMinCharsMsg">Debe Escribir mínimo 2 Caracteres.</span></td>
    </tr>		
    <tr>
      <td class="etiqueta">Salario:</td>
      <td id="input03"><input type="text" name="salario" maxlength="14" style="width:200px" />
        <img src="imagenes/ok.gif" alt="Valido" class="validMsg" border="0"/> <br />
        <span class="textfieldRequiredMsg">El Campo es Requerido.</span> 
        <span class="textfieldMinCharsMsg">Debe Escribir 20 caracteres.</span></td>
	 </tr>	 		 

     <tr>
	     <td height="20" class="etiqueta">Status:</td>
	     <td  id="select10">		    
			   <select name="status" style="width:120px;">	 
     				   <option value="">Seleccione...</option>
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
           <input type="hidden"  name="metodo" value="Agregar" />
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
var input03 = new Spry.Widget.ValidationTextField("input03", "currency", {format:"comma_dot",validateOn:["blur"], 
     	useCharacterMasking:true});

var select10 = new Spry.Widget.ValidationSelect("select10", {validateOn:["blur", "change"]});
</script>