<link rel="stylesheet" type="text/css" href="latest/stylesheets/autocomplete.css" />
<script type="text/javascript" src="latest/scripts/autocomplete.js"></script>
	<fieldset>
	<legend> BUSCAR REGISTROS: </legend>
  	<table width="750" border="0" align="center" >
	<tr>
		<td class="etiqueta">Filtro:</td>	
		<td id="selectP01">
			<select id="paciFiltro" onchange="EstadoFiltro()" style="width:200px">
				<option value=""> Seleccione el campo a filtrar </option>
				<option value="codigo"> Codigo </option>
				<option value="descripcion"> Descripcion </option>
		</select><img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br />
       	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
    </tr>
	<tr>   
      <td class="etiqueta">DESCRIPCION:</td> 
      <td><input  id="stdName" type="text" style="width:300px" disabled="disabled"/>
	        <span id="inputP01"><input type="hidden" name="stdID" id="stdID"/>	       
            <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/> <br /> 
            <span class="textfieldRequiredMsg">Debe De Seleccionar Un Campo De la Lista.</span>
            <span class="textfieldInvalidFormatMsg">El Formato es Invalido</span> </span></td>
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
                </span></td>
	   </tr>	
	</table>
</fieldset>
<div id="ContendorConsulta">
</div>
<script type="text/javascript">

	var select01 = new Spry.Widget.ValidationSelect("selectP01", {validateOn:["blur", "change"],isRequired:false});
    var input01 = new Spry.Widget.ValidationTextField("inputP01", "none", {minChars:2, validateOn:["blur", "change"],isRequired:false});
	
	filtroId = document.getElementById("paciFiltro");
	filtroIndice = filtroId.selectedIndex;
	filtroValue  = filtroId.options[filtroIndice].value; 
	
    new Autocomplete("stdName", function() { 
        this.setValue = function(id) {
            document.getElementById("stdID").value = id; // document.getElementsByName("stdID")[0].value = id;
			
        }
        if (this.isModified) this.setValue("");
        if (this.value.length < 1) return ;
          return "autocompletar/tb/maestros.php?q="+ this.text.value +"&filtro="+filtroValue+"&tab=<?php echo $tab;?>"});
   </script>