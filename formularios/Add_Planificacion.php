<form action="scripts/sc_Planificacion.php" method="post" name="add" id="add"> 
  <fieldset class="fieldset">
  <legend>Agregar Planificacion: </legend>
     <table width="80%" align="center">
    <tr>
      <td class="etiqueta">Planificacion Semanal:</td>
      	<td id="select02">
      		<select name="semana" style="width:180px">
			<option value="">Seleccione...</option> 
          <?php         $query03 = mysql_query("SELECT * FROM semana WHERE status = 1 ORDER BY periodo, semana ASC",$cnn);
		  					$x = 1;
						  while($row03=mysql_fetch_array($query03))
						  {
						  $id_x = $row03[0];						   
						  $query04 = mysql_query("SELECT  descripcion FROM planificacion_personal WHERE id_semana = $id_x",$cnn);
						  	
							  if (mysql_num_rows($query04)==0){
							  
							   if ($x==1){					  
						  ?>
					  <option value="<?php echo $row03[0];?>"><?php echo $row03[3];?></option>
					  <?php 
					  	$x++;}}}?>
        	</select><br />
			<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
    </tr>	
<!--
    <tr>
      <td class="etiqueta">Descripcion:</td>
      <td id="input01"><input type="text" name="descripcion" maxlength="120" style="width:200px"/>
        <img src="imagenes/ok.gif" alt="Valido" class="validMsg" border="0"/> <br />
        <span class="textfieldRequiredMsg">El Campo es Requerido.</span> 
        <span class="textfieldMinCharsMsg">Debe Escribir m&aacute;s de 4 caracteres.</span></td>
	 </tr>  
-->
	  <tr>
	     <td height="20" class="etiqueta">Status:</td>
	     <td  id="select03">		    
			   <select name="status" style="width:120px;">	
     				   <option value="1"> Activo </option>
                       <option value="2"> Inactivo </option>    
	           </select><img src="imagenes/ok.gif" alt="Valido" class="validMsg" border="0"/><br />
       	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
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
		    <input name="archivo" type="hidden"  value="agregar" />
		    <input name="id" type="hidden"  value="<?php echo $id;?>" />
	        <input name="href" type="hidden" value="../pl_inicio.php?area=formularios/Cons_Planificacion"/>		   			
		     </td>
	   </tr>
  </table>
  </fieldset>
</form>
</body>
</html>
<script type="text/javascript">
var select02 = new Spry.Widget.ValidationSelect("select02", {validateOn:["blur", "change"]});
var select03 = new Spry.Widget.ValidationSelect("select03", {validateOn:["blur", "change"]});
</script>