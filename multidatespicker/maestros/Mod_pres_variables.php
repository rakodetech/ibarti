<?php
$archivo = "pres_variables";
$href    = "pres_variables&Nmenu=".$_GET['Nmenu']."";
$codigo  = $_GET['codigo']; 

$result01 = mysql_query("SELECT pres_variables.codigo, pres_variables.pres_variables_clasif,
                                pres_variables.uso, pres_variables.descripcion,
                                pres_variables.`status`, pres_variables_clasif.descripcion AS clasificacion,
                                pres_variables.valor, pres_variables.cod_factor,
                                pres_factor.descripcion AS factor, formula
                           FROM pres_variables , pres_variables_clasif , pres_factor
                          WHERE pres_variables.pres_variables_clasif = pres_variables_clasif.codigo 
                            AND pres_variables.cod_factor = pres_factor.codigo 
                            AND pres_variables.codigo = '$codigo' ", $cnn);  
$row01    = mysql_fetch_array($result01);
?>

<form action="sc_maestros/<?php echo $archivo;?>.php" method="post" name="Mod" id="Mod"> 
     <table width="70%" align="center">
         <tr valign="top">                    
		     <td height="23" colspan="2" class="etiqueta_title" align="center"> MODIFICAR VARIABLES </td>
         </tr>
         <tr> 
            <td height="8" colspan="2" align="center"><hr></td>
         </tr>	 
    <tr>
      <td class="etiqueta" width="25%">C&oacute;digo:</td>
      <td id="input01" width="75%"><input type="text" name="codigo" maxlength="12" style="width:120px" 
                                           value="<?php echo $row01["codigo"];?>" />	  
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br>
        <span class="textfieldRequiredMsg">La Descripcion es Requerida.</span>
		<span class="textfieldMinCharsMsg">Debe Escribir mínimo 2 Caracteres.</span></td>
    </tr>
    <tr>
      <td class="etiqueta">Descripci&oacute;n:</td>
      <td id="input02"><input type="text" name="descripcion" maxlength="60" value="<?php echo $row01["descripcion"];?>" style="width:250px" />	  
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br>
        <span class="textfieldRequiredMsg">La Descripcion es Requerida.</span>
		<span class="textfieldMinCharsMsg">Debe Escribir mínimo 2 Caracteres.</span></td>
    </tr>
     <tr>
	     <td class="etiqueta">Clasificaci&oacute;n:</td>
	     <td id="select01">		    
			   <select name="clasif" style="width:250px;">
     				   <option value="<?php echo $row01["pres_variables_clasif"];?>"><?php echo $row01["clasificacion"];?></option>
					   <?php 
					   $query03 = mysql_query("SELECT pres_variables_clasif.codigo, pres_variables_clasif.descripcion
                                                 FROM pres_variables_clasif  ORDER BY 2 ASC ", $cnn);
					   while($row03=(mysql_fetch_array($query03))){
					   echo '<option value="'.$row03[0].'">'.$row03[1].'</option>';
					   }
					   ?>    
	           </select><img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br />
       	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
    </tr>   
     <tr>
	     <td class="etiqueta">Factor:</td>
	     <td id="select02">		    
			   <select name="factor" style="width:250px;">	 
     				   <option value="<?php echo $row01["cod_factor"];?>"><?php echo $row01["factor"];?></option>
					   <?php 
					   $query03 = mysql_query("SELECT codigo, descripcion FROM pres_factor ORDER BY 2 ASC ", $cnn);
					   while($row03=(mysql_fetch_array($query03))){
					   echo '<option value="'.$row03[0].'">'.$row03[1].'</option>';
					   }
					   ?>    
	           </select><img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br />
       	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
    </tr>       
     		
    <tr>
      <td class="etiqueta">USO:</td>
      <td id="radio01" class="texto">
		 <?php  $usos =  $row01["uso"];
				if ($usos == 'p'){
				$P = 'checked="checked"';
				}elseif ($usos == 'g'){
				$G = 'checked="checked"';
				}?>	  
	 Generar
            <input type = "radio" name="uso"  value = "g" style="width:auto" <?php echo  $G; ?>   />
     Particular
            <input type = "radio" name="uso"  value = "p" style="width:auto" <?php echo  $P; ?> />															 	         <img src="imagenes/ok.gif" alt="Valido" class="validMsg" border="0"/>
            <span class="radioRequiredMsg">Debe Seleccionar un campo.</span>
        </td>
    </tr>
    <tr>
      <td class="etiqueta">Formula:</td>
      <td id="textarea01"><textarea  name="formula" cols="45" rows="3"><?php echo utf8_decode($row01["formula"]);?></textarea>
        <span id="Counterror_mess2" class="texto">&nbsp;</span> 
        <img src="imagenes/ok.gif" alt="Valido" class="validMsg" border="0"/><br />
        <span class="textareaRequiredMsg">El Campo es Requerido.</span>
        <span class="textareaMinCharsMsg">Debe Escribir mas de 4 caracteres.</span>
        <span class="textareaMaxCharsMsg">El maximo de caracteres permitidos es 120.</span></td>
    </tr>	
    <tr>
      <td class="etiqueta">Valor:</td>
    <td id="input03"><input type="text" name="valor" maxlength="14" style="width:120px" value="<?php echo $row01["valor"];?>" />
        <img src="imagenes/ok.gif" alt="Valido" class="validMsg" border="0"/> <br />
        <span class="textfieldRequiredMsg">El Campo es Requerido.</span> 
        <span class="textfieldMinCharsMsg">Debe Escribir 20 caracteres.</span></td>
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
			<input type="hidden"  name="metodo" value="Modificar" />
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

var textarea01 = new Spry.Widget.ValidationTextarea("textarea01", {minChars:4, maxChars:120, validateOn:["blur", "change"], counterType:"chars_count", counterId:"Counterror_mess2", useCharacterMasking:false });

var radio01 = new Spry.Widget.ValidationRadio("radio01", { validateOn:["change", "blur"]});

var select01 = new Spry.Widget.ValidationSelect("select01", {validateOn:["blur", "change"]});
var select02 = new Spry.Widget.ValidationSelect("select02", {validateOn:["blur", "change"]});

var select10 = new Spry.Widget.ValidationSelect("select10", {validateOn:["blur", "change"]});
</script>