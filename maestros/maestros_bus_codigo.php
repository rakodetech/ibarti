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
      		<input  type="button"  id="salvar" value="Consultar" class="button1"
			                       onMouseOver="Fondos (this.id ,'A',  'button1Act', 'button1')" 
	                               onMouseOut="Fondos (this.id ,'D', 'button1Act', 'button1')" onclick="Mod_maestros()">	&nbsp;
		    <input type="reset"    id="limpiar"  value="Restablecer" class="button1"
			                       onMouseOver="Fondos (this.id ,'A',  'button1Act', 'button1')" 
	                               onMouseOut="Fondos (this.id ,'D', 'button1Act', 'button1')">	&nbsp;
		    <input type="button"   id="volver"  value="Volver" onClick="history.back(-1);"  class="button1"
			                       onMouseOver="Fondos (this.id ,'A',  'button1Act', 'button1')" 
	                               onMouseOut="Fondos (this.id ,'D', 'button1Act', 'button1')">	
			 </td>
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
          return "autocompletar/tb/maestros_codigo.php?q="+ this.text.value +"&filtro="+filtroValue+"&tab=<?php echo $tab;?>"});
   </script>