<?php 

$Nmenu = $_GET['Nmenu'];
$titulo = " AGREGAR CLIENTES ";
$archivo = "cont_clientes";
$metodo  = "agregar";

?>
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
				 document.getElementById("select03").innerHTML="Cargando...";
				}
				if (ajax.readyState==4){
				 document.getElementById("select03").innerHTML = ajax.responseText;
				//spryActivar01();
				} 
			}
			ajax.send(null);
}

function Validar01(valor){  // CARGAR EL MODULO DE AGREGAR//
 document.getElementById("municipio").value= valor;
}
</script>

<form action="sc_maestros/<?php echo $archivo;?>.php" method="post" name="Mod" id="Mod"> 
     <table width="70%" align="center">
         <tr valign="top">                    
		     <td height="23" colspan="2" class="etiqueta_title" align="center"> AGREGAR CLIENTES </td>
         </tr>
         <tr> 
            <td height="8" colspan="2" align="center"><hr></td>
         </tr>	 
    <tr>
      <td class="etiqueta" width="25%">C&oacute;digo (RIF / C.I):</td>
      <td id="input01" width="75%"><input type="text" name="codigo" maxlength="12" style="width:150px" value="" />	  
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br>
        <span class="textfieldRequiredMsg">La Descripcion es Requerida.</span>
		<span class="textfieldMinCharsMsg">Debe Escribir mínimo 2 Caracteres.</span></td>
    </tr>
    <tr>
      <td class="etiqueta">Nombre del Cliente:</td>
      <td id="input02"><input type="text" name="descripcion" maxlength="60" value="" style="width:250px" />	  
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br>
        <span class="textfieldRequiredMsg">La Descripcion es Requerida.</span>
		<span class="textfieldMinCharsMsg">Debe Escribir mínimo 2 Caracteres.</span></td>
    </tr>		

    <tr>
      <td class="etiqueta">Telefeno:</td>
      <td id="input03"><input type="text" name="telefono" style="width:250px" maxlength="60"/>	
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br>
        <span class="textfieldRequiredMsg">La Descripcion es Requerida.</span>
		<span class="textfieldMinCharsMsg">Debe Escribir mínimo 4 Caracteres.</span></td>
    </tr>
    <tr>
      <td class="etiqueta">Direccion:</td>
      <td id="textarea01"><textarea  name="direccion" cols="45" rows="3"></textarea>
        <span id="Counterror_mess2" class="texto">&nbsp;</span> 
        <img src="imagenes/ok.gif" alt="Valido" class="validMsg" border="0"/><br />
        <span class="textareaRequiredMsg">El Campo es Requerido.</span>
        <span class="textareaMinCharsMsg">Debe Escribir mas de 4 caracteres.</span>
        <span class="textareaMaxCharsMsg">El maximo de caracteres permitidos es 120.</span></td>
    </tr>	
     <tr>
	     <td class="etiqueta">Clasificacion:</td>
	     <td id="select01">		    
			   <select name="clasif" style="width:200px;">	 
     				   <option value=""> Seleccione...</option>                       
					   <?php 
					   	$sql  = " SELECT * FROM cont_clientes_clasif WHERE status =  1 ORDER BY 2 ASC ";
                    	$query  = $bd->consultar($sql);
                     	$result = $bd->obtener_fila($query,0);
						while($row03=$bd->obtener_fila($query,0)){	
		  	
						   echo '<option value="'.$row03[0].'">'.$row03[1].'</option>';
					   }
					   ?>    
	           </select><img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br />
       	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
    </tr>			
     <tr>
	     <td class="etiqueta">Estado:</td>
	     <td id="select02">		    
			   <select name="estado" style="width:200px;" onchange="Activar01(this.value)">	 
     				   <option value=""> Seleccione...</option>
					   <?php
					   $sql  = " SELECT * FROM dpt_1 ORDER BY entidescri ASC ";
                    	$query  = $bd->consultar($sql);
                     	$result = $bd->obtener_fila($query,0);
						while($row02=$bd->obtener_fila($query,0)){
					   echo '<option value="'.$row02[0].'">'.$row02[1].'</option>';
					   }
					   ?>    
	           </select><img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br />
       	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
    </tr>
     <tr>
	     <td class="etiqueta">Municipio:</td>
	     <td id="select03"><select name="municipios" style="width:200px;" disabled="disabled"></select></td>	     
	</tr>		

     <tr>
	    <td class="etiqueta">&nbsp;</td>
	     <td id="input02"><input name="municipo" id="municipio" style="display:none"/> 
		 <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br>
        <span class="textfieldRequiredMsg">Debe De Seleccionar Un Campo.</span>
		<span class="textfieldMinCharsMsg">Debe Escribir mínimo 2 Caracteres.</span></td>
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
		<input type="hidden"  name="usuario" value="<?php echo $usuario?>" /> 
		<input type="hidden"  name="href" value="../inicio.php?area=maestros/Cons_<?php echo $archivo?>&Nmenu=<?php echo $Nmenu;?>" />	 			
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

var textarea01 = new Spry.Widget.ValidationTextarea("textarea01", {minChars:4, maxChars:120, validateOn:["blur", "change"], counterType:"chars_count", counterId:"Counterror_mess2", useCharacterMasking:false }); <!--isRequired:false -->

var select01 = new Spry.Widget.ValidationSelect("select01", {validateOn:["blur", "change"]});
var select02 = new Spry.Widget.ValidationSelect("select02", {validateOn:["blur", "change"]});

var select10 = new Spry.Widget.ValidationSelect("select10", {validateOn:["blur", "change"]});
</script>