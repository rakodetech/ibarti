<?php 
$Nmenu   = 426; 
$archivo = "borrar_asistencia&Nmenu=".$Nmenu."";

require_once('autentificacion/aut_verifica_menu.php');
?>
<script language="javascript" type="text/javascript">
	function ConsTrabajador(){
		var codigo   = document.getElementById("stdID").value;		
		if(codigo!='') {
		var valor   = "ajax/Add_trabajadores.php"; 
		ajax=nuevoAjax();
			ajax.open("POST", valor, true);
			ajax.onreadystatechange=function()  
			{ 
				if (ajax.readyState==4){
		        document.getElementById("Contenedor01").innerHTML = ajax.responseText;		
				}
			} 
			ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			ajax.send("codigo="+codigo+"");			

     	}else{
			alert(" Debe de Seleccionar un Trabajador ");	 
	 	}  
	}
</script>
<link rel="stylesheet" type="text/css" href="latest/stylesheets/autocomplete.css" />
<script type="text/javascript" src="latest/scripts/autocomplete.js"></script>
	<fieldset>
	<legend> BORRAR ASISTENCIA TRABAJADOR:  </legend>
	<form action="scripts/sc_borrar_asistencia.php" method="post" name="add" id="add"> 
  	<table width="750" border="0" align="center" >
	<tr>
		<td class="etiqueta">Filtro:</td>	
		<td id="select01">
			<select id="paciFiltro" onchange="EstadoFiltro()" style="width:200px">
				<option value=""> Seleccione el campo a filtrar </option>
				<option value="codigo"> C&oacute;digo (N. Ficha) </option>
				<option value="cedula"> C&eacute;dula</option>
                <option value="nombre"> Nombre</option>
		</select><img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br />
       	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
    </tr>
	<tr>   
      <td class="etiqueta">Trabajadores:</td> 
      <td><input  id="stdName" type="text" style="width:350px" disabled="disabled"/>
	        <span id="input01"><input type="hidden" name="codigo" id="stdID"/>	       
            <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/> <br /> 
            <span class="textfieldRequiredMsg">Debe De Seleccionar Un Campo De la Lista.</span>
            <span class="textfieldInvalidFormatMsg">El Formato es Invalido</span> </span></td>
    </tr>
    <tr>
      <td class="etiqueta">A partir de la Fecha:</td>
      <td id="fecha01">
          	<input type="text" name="fecha" value=""/>
            <img src="imagenes/ok.gif" alt="Valido" class="validMsg" border="0"/><br />
            <span class="textfieldRequiredMsg">La Fecha Es Requerida.</span>
            <span class="textfieldInvalidFormatMsg">El Formato Es Invalido</span>
      </td>
    </tr>
    <tr>
          <td colspan="2" align="center"><hr></td>
     </tr>
         <tr> 
		     <td colspan="2" align="center">
      		<input type="submit"   id="salvar" value="Consultar" class="button1"  
			                       onMouseOver="Fondos (this.id ,'A',  'button1Act', 'button1')" 
	                               onMouseOut="Fondos (this.id ,'D', 'button1Act', 'button1')">	&nbsp;
		    <input type="reset"    id="limpiar"  value="Restablecer" class="button1"
			                       onMouseOver="Fondos (this.id ,'A',  'button1Act', 'button1')" 
	                               onMouseOut="Fondos (this.id ,'D', 'button1Act', 'button1')">	&nbsp;
		    <input type="button"   id="volver"  value="Volver" onClick="history.back(-1);"  class="button1"
			                       onMouseOver="Fondos (this.id ,'A',  'button1Act', 'button1')" 
	                               onMouseOut="Fondos (this.id ,'D', 'button1Act', 'button1')">	
	 		 <input type="hidden" name="metodo" value="Eliminar"/>
			 <input type="hidden" name="Nmenu" value="<?php echo $Nmenu;?>"/>
              <input name="href" type="hidden" value="../inicio.php?area=formularios/Cons_<?php echo $archivo?>"/>		   			 			
             </td>
	   </tr>	
	</table>	
	</form>
</fieldset>
<div id="Contenedor01">
</div>

<script type="text/javascript">

	var select01 = new Spry.Widget.ValidationSelect("select01", {validateOn:["blur", "change"]});
	
	var fecha01 = new Spry.Widget.ValidationTextField("fecha01", "date", {format:"dd-mm-yyyy", hint:"DD-MM-AAA", 
    validateOn:["blur", "change"], useCharacterMasking:true, isRequired:false});
	
    var input01 = new Spry.Widget.ValidationTextField("input01", "none", {minChars:2, validateOn:["blur", "change"]});
	
	filtroId = document.getElementById("paciFiltro");
	filtroIndice = filtroId.selectedIndex;
	filtroValue  = filtroId.options[filtroIndice].value; 
	
    new Autocomplete("stdName", function() { 
        this.setValue = function(id) {
            document.getElementById("stdID").value = id; // document.getElementsByName("stdID")[0].value = id;
        }
        if (this.isModified) this.setValue("");
        if (this.value.length < 1) return ;
          return "autocompletar/tb/trabajador.php?q="+ this.text.value +"&filtro="+filtroValue+""});
   </script>