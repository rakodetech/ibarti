<script type="text/javascript" src="../ajax/ajax.js"></script>
<script language="javascript" type="text/javascript"> 

function Activar01(idX){
 document.getElementById("municipio").value= "";
var valor = "ajax/Add_Municipio.php?id="+idX+""; 
		ajax=nuevoAjax();
			ajax.open("GET", valor, true);
			ajax.onreadystatechange=function()  
			{ 
				if (ajax.readyState==1)	{			
				 document.getElementById("select02").innerHTML="Cargando...";
				}
				if (ajax.readyState==4)
				{
				 document.getElementById("select02").innerHTML = ajax.responseText;
				//spryActivar01();
				} 
			}
			ajax.send(null);
}

function Validar01(valor){  // CARGAR EL MODULO DE AGREGAR//
 document.getElementById("municipio").value= valor;
}
</script>
<?php 
$id = $_GET['id']; 
mysql_select_db($bd_cnn, $cnn);

	 $query02 = mysql_query("SELECT cli_des FROM clientes WHERE co_cli = '$id'", $cnn);
	 $row02   = mysql_fetch_array($query02);
?>
<form action="sc_maestros/Ubicacion_Cliente.php" method="post"  name="add" id="add"> 
     <table width="70%" align="center">
         <tr valign="top">                    
		     <td height="23" colspan="2" class="etiqueta_title" align="center"> AGREGAR UBICACION CLIENTE<br /> <br /><?php echo $row02[0];?></td>
         </tr>
         <tr> 
            <td height="8" colspan="2" align="center"><hr></td>
         </tr>	 
    <tr>
      <td class="etiqueta" width="25%">C&oacute;digo:</td>
      <td id="input01" width="75%"><input type="text" name="codigo" maxlength="12" style="width:120px" value="<?php echo $id?>" readonly="true"/>	
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br>
        <span class="textfieldRequiredMsg">La Descripcion es Requerida.</span>
		<span class="textfieldMinCharsMsg">Debe Escribir mínimo 2 Caracteres.</span></td>
    </tr>
    <tr>
      <td class="etiqueta">Sucursal  o Agencia:</td>
      <td id="input00"><input type="text" name="descripcion" maxlength="60" style="width:300px"/>	
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br>
        <span class="textfieldRequiredMsg">La Descripcion es Requerida.</span>
		<span class="textfieldMinCharsMsg">Debe Escribir mínimo 4 Caracteres.</span></td>
    </tr>
     <tr>
	     <td class="etiqueta">Estado:</td>
	     <td id="select01">		    
			   <select name="estado" style="width:200px;" onchange="Activar01(this.value)">	 
     				   <option value=""> Seleccione...</option>
					   <?php
					   $query02 = mysql_query("SELECT * FROM dpt_1 ORDER BY entidescri ASC", $cnn); 
					   while($row02=(mysql_fetch_array($query02))){
					   echo '<option value="'.$row02[0].'">'.$row02[1].'</option>';
					   }
					   ?>    
	           </select><img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br />
       	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
    </tr>
     <tr>
	     <td class="etiqueta">Municipio:</td>
	     <td id="select02"><select name="municipios" style="width:200px;" disabled="disabled"></select></td>	     
	</tr>		
     <tr>
	    <td class="etiqueta">&nbsp;</td>
	     <td id="input02"><input name="municipo" id="municipio" style="display:none"/> 
		 <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br>
        <span class="textfieldRequiredMsg">Debe De Seleccionar Un Campo.</span>
		<span class="textfieldMinCharsMsg">Debe Escribir mínimo 2 Caracteres.</span></td>
    </tr>
     <tr>
	     <td class="etiqueta">Region:</td>
	     <td id="select03">		    
			   <select name="region" style="width:200px;">	 
     				   <option value=""> Seleccione...</option>
					   <?php 
					   $query03 = mysql_query("SELECT * FROM regiones WHERE status =  1 ORDER BY 2 ASC ", $cnn);
					   while($row03=(mysql_fetch_array($query03))){
					   echo '<option value="'.$row03[0].'">'.$row03[1].'</option>';
					   }
					   ?>    
	           </select><img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br />
       	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
    </tr>			
    <tr>
      <td class="etiqueta">Contacto:</td>
      <td id="input03"><input type="text" name="contacto" maxlength="60" style="width:300px" />	
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br>
        <span class="textfieldRequiredMsg">La Descripcion es Requerida.</span>
		<span class="textfieldMinCharsMsg">Debe Escribir mínimo 4 Caracteres.</span></td>
    </tr>
    <tr>
      <td class="etiqueta">Telefeno:</td>
      <td id="input04"><input type="text" name="telefono" style="width:120px" />	
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br>
        <span class="textfieldRequiredMsg">La Descripcion es Requerida.</span>
		<span class="textfieldMinCharsMsg">Debe Escribir mínimo 4 Caracteres.</span></td>
    </tr>
    <tr>
      <td class="etiqueta">Telefeno:</td>
      <td id="input05"><input type="text" name="telefono2" style="width:120px"/>	
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br>
        <span class="textfieldRequiredMsg">La Descripcion es Requerida.</span>
		<span class="textfieldMinCharsMsg">Debe Escribir mínimo 4 Caracteres.</span></td>
    </tr>
    <tr>
      <td class="etiqueta">Correo:</td>
      <td id="input06"><input type="text" name="correo" maxlength="60" style="width:300px" />	
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br>
		<span class="textfieldMinCharsMsg">Debe Escribir mínimo 4 Caracteres.</span></td>
    </tr>
    <tr>
      <td class="etiqueta">Otro:</td>
      <td id="input07"><input type="text" name="otro" maxlength="60" style="width:300px"/>	
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br>
		<span class="textfieldMinCharsMsg">Debe Escribir mínimo 2 Caracteres.</span></td>
    </tr>
    <tr>
      <td class="etiqueta">Ubicacion:</td>
      <td id="textarea02"><textarea  name="ubicacion" cols="45" rows="3"></textarea>
        <span id="Counterror_mess2" class="texto">&nbsp;</span> 
        <img src="imagenes/ok.gif" alt="Valido" class="validMsg" border="0"/><br />
        <span class="textareaRequiredMsg">El Campo es Requerido.</span>
        <span class="textareaMinCharsMsg">Debe Escribir mas de 4 caracteres.</span>
        <span class="textareaMaxCharsMsg">El maximo de caracteres permitidos es 120.</span></td>
    </tr>	
	<!--	
     <tr>
	     <td height="20" class="etiqueta">Status:</td>
	     <td  id="select03">		    
			   <select name="status" style="width:120px;">	 
     				   <option value="1"> Activo </option>
                       <option value="2"> Inactivo </option>    
	           </select><img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br />
       	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
    </tr>
		-->
	  <tr>
		  <td colspan="2" align="center"><hr></td>
	 </tr>
	 <tr> 
		 <td colspan="2" align="center">
		<input  type="submit" name="salvar"  id="salvar" value="Guardar" class="button1"
							  onMouseOver="Fondos (this.id ,'A',  'button1Act', 'button1')" 
							  onMouseOut="Fondos (this.id ,'D', 'button1Act', 'button1')">	&nbsp;
		<input type="reset"   id="limpiar"  value="Restablecer" class="button1"
							  onMouseOver="Fondos (this.id ,'A',  'button1Act', 'button1')" 
							  onMouseOut="Fondos (this.id ,'D', 'button1Act', 'button1')">	&nbsp;
		<input type="button"  id="volver"  value="Volver" onClick="history.back(-1);"  class="button1"
							  onMouseOver="Fondos (this.id ,'A',  'button1Act', 'button1')" 
							  onMouseOut="Fondos (this.id ,'D', 'button1Act', 'button1')">	
		<input type="hidden" name="metodo" value="Agregar"/>			
		<input type="hidden" name="href" value="../inicio.php?area=maestros/Cons_Ubicacion_Clientes&id=<?php echo $id?>&Nmenu=<?php echo $_GET['Nmenu']; ?>"/>
			 </td>
   </tr>
  </table>
</form>
</body>
</html>
<script language="javascript" type="text/javascript">
var input00 = new Spry.Widget.ValidationTextField("input00", "none", {minChars:4, validateOn:["blur", "change"]});
var input01 = new Spry.Widget.ValidationTextField("input01", "none", {minChars:2, validateOn:["blur", "change"]});
var input02 = new Spry.Widget.ValidationTextField("input02", "none", {validateOn:["blur", "change"]});

var input03 = new Spry.Widget.ValidationTextField("input03", "none", {minChars:4, validateOn:["blur", "change"],isRequired:false});
var input04  = new Spry.Widget.ValidationTextField("input04", "none", {pattern:"0000-0000000",  hint:"0241-0000000",  validateOn:["blur"],useCharacterMasking:true,isRequired:false});
var input05  = new Spry.Widget.ValidationTextField("input05", "none", {pattern:"0000-0000000",  hint:"0241-0000000",  validateOn:["blur"],useCharacterMasking:true,isRequired:false});
var input06  = new Spry.Widget.ValidationTextField("input06", "email", {validateOn:["blur", "change"], isRequired:false});
var input07  = new Spry.Widget.ValidationTextField("input07", "none", {minChars:2, validateOn:["blur", "change"],isRequired:false});

var select01 = new Spry.Widget.ValidationSelect("select01", {validateOn:["blur", "change"]});
//var select02 = new Spry.Widget.ValidationSelect("select02", {validateOn:["blur", "change"]});
var select03 = new Spry.Widget.ValidationSelect("select03", {validateOn:["blur", "change"]});

var textarea02 = new Spry.Widget.ValidationTextarea("textarea02", {minChars:4, maxChars:120, validateOn:["blur", "change"], counterType:"chars_count", counterId:"Counterror_mess2", useCharacterMasking:false ,isRequired:false});
</script>