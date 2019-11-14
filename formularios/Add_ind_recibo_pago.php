<?php 
$id      = $_GET['codigo']; 
$Nmenu   = $_GET['Nmenu'];
$titulo  = "ASIGNACION DE RECIBOS PAGOS";
$archivo = "ind_recibo_pago";
$metodo  = "agregar";

require_once('autentificacion/aut_verifica_menu.php');
?>
<form action="scripts/sc_<?php echo $archivo;?>.php" method="post" name="add" id="add"> 
     <table width="80%" align="center">
         <tr valign="top">                    
		     <td height="23" colspan="2" class="etiqueta_title" align="center"> AGREGAR <?php echo $titulo;?></td>
         </tr>
         <tr> 
    	       <td height="8" colspan="2" align="center"><hr></td>    
     	</tr>
    <tr>
      <td class="etiqueta" width="35%">Fecha De Recibos:</td>
      <td id="fecha01" width="65%"><input type="text" name="fecha"  style="width:100px" /><br />
            <span class="textfieldRequiredMsg">La Fecha Es Requerida.</span>
            <span class="textfieldInvalidFormatMsg">El Formato Es Invalido</span></td>
    </tr>
	 <tr>
      <td class="etiqueta">Porcentaje (%):</td>
      <td id="input01"><input type="text" name="porcentaje" maxlength="2" style="width:100px" /><br />
        <span class="textfieldRequiredMsg">El Campo es Requerido.</span> 
		<span class="textfieldInvalidFormatMsg">El Formato Es Invalido</span></td>
	 </tr>		 	 

         <tr>
            <td height="8" colspan="2" align="center"><hr></td>
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
			<input name="trabajador" type="hidden"  value="" />
         	<input name="region" type="hidden"  value="" />
            <input name="recibo" type="hidden"  value="" />
            <input name="status" type="hidden"  value="1" />
	        <input name="href" type="hidden" value="../inicio.php?area=formularios/Cons_<?php echo $archivo?>&Nmenu=<?php echo $Nmenu;?>"/>		   			
		     </td>
	   </tr>
  </table>
</form>
</body>
</html>
<script type="text/javascript">

var fecha01 = new Spry.Widget.ValidationTextField("fecha01", "date", {format:"dd-mm-yyyy", hint:"DD-MM-AAA", 
    validateOn:["blur", "change"], useCharacterMasking:true});

var input01 = new Spry.Widget.ValidationTextField("input01", "integer", {minChars:1, validateOn:["blur", "change"]});
</script>