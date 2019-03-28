<link rel="stylesheet" type="text/css" href="latest/stylesheets/autocomplete.css" />
<script type="text/javascript" src="latest/scripts/autocomplete.js"></script>
<?php 
$codigo  = $_GET['codigo']; 
$Nmenu   = $_GET['Nmenu'];
$titulo  = " MODIFICAR FOROS ";
$archivo = "foros";
$metodo  = "modificar";

require_once('autentificacion/aut_verifica_menu.php');

mysql_query("SET NAMES utf8");
$result01 = mysql_query("SELECT foros.codigo, foros.cod_autor,
                                foros.expedientes, foros.fecha_notificacion,
                                foros.cod_region, regiones.descripcion AS region,
                                foros.cod_categoria, foros_categoria.descripcion AS categoria,
                                foros.asunto, foros.mensaje,
                                foros.`status`, trabajadores.cod_emp,  trabajadores.nombres AS trabajador
						   FROM foros , regiones , foros_categoria, trabajadores
						  WHERE foros.cod_region = regiones.id 
							AND foros.cod_categoria = foros_categoria.id
							AND foros.cod_emp = trabajadores.cod_emp
							AND foros.codigo = '$codigo' ", $cnn)or die
								 ('<br><h3>Error Consulta # 2:</h3> '.mysql_error().'<br>');  
$row01    = mysql_fetch_array($result01);
?>
<form action="scripts/sc_<?php echo $archivo;?>.php" method="post" name="add" id="add"> 
     <table width="80%" align="center">
         <tr valign="top">                    
		     <td height="23" colspan="2" class="etiqueta_title" align="center"> <?php echo $titulo;?></td>
         </tr>
         <tr> 
    	       <td height="8" colspan="2" align="center"><hr></td>    
     	</tr>
    <tr>
      <td class="etiqueta" width="30%">N Expediente O Referencia:</td>
      <td id="input01" width="70%"><input type="text" id="expediente" name="expediente" maxlength="60" 
                                          style="width:150px" value="<?php echo $row01['expedientes'];?>" /><br />
        <span class="textfieldRequiredMsg">El Campo es Requerido.</span>
        <span class="textfieldMinCharsMsg">Debe Escribir m&aacute;s de 4 caracteres.</span></td>
    </tr>
    <tr>
      <td class="etiqueta">Fecha Recepcion:</td>
      <td id="fecha01"><input type="text" name="fecha_notif" id="fecha_notif"  style="width:100px" 
                              value="<?php echo Rconversion($row01['fecha_notificacion']);?>"/><br />
            <span class="textfieldRequiredMsg">La Fecha Es Requerida.</span>
            <span class="textfieldInvalidFormatMsg">El Formato Es Invalido</span></td>
    </tr>    
    <tr>
      <td class="etiqueta">Titulo:</td>
      <td id="input02"><input type="text" name="titulo" maxlength="60" style="width:350px" 
                              value="<?php echo $row01['asunto'];?>"/><br />
        <span class="textfieldRequiredMsg">El Campo es Requerido.</span>
        <span class="textfieldMinCharsMsg">Debe Escribir m&aacute;s de 4 caracteres.</span></td>
    </tr>
    <tr>
      <td class="etiqueta">Mensaje:</td>
      <td id="textarea01"><textarea  name="mensaje" cols="45" rows="3"><?php echo $row01['mensaje'];?></textarea>
        <span id="Counterror_mess2" class="texto">&nbsp;</span><br />
        <span class="textareaRequiredMsg">El Campo es Requerido.</span>
        <span class="textareaMinCharsMsg">Debe Escribir mas de 4 caracteres.</span>
        <span class="textareaMaxCharsMsg">El maximo de caracteres permitidos es 300.</span></td>
    </tr>	
    <tr>
      <td class="etiqueta">Categoria:</td>
      	<td id="select01"><select name="categoria" style="width:250px">
							<option value="<?php echo $row01['cod_categoria'];?>"><?php echo $row01['categoria'];?></option>
          <?php  $query05 = mysql_query("SELECT foros_categoria.id, foros_categoria.descripcion
                                           FROM foros_categoria
                                          WHERE foros_categoria.`status` = 1  ORDER BY 2 ASC",$cnn);
						  while($row05=mysql_fetch_array($query05)){					   					
		  ?>
          <option value="<?php echo $row05[0];?>"><?php echo utf8_decode($row05[1]);?></option>
          <?php }?>		  	  
        </select><br /><span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
    </tr>

    <tr>
      <td class="etiqueta">Region:</td>
      	<td id="select02"><select name="region" style="width:250px">
							<option value="<?php echo $row01['cod_region'];?>"><?php echo $row01['region'];?></option>
          <?php  $query05 = mysql_query("SELECT regiones.id, regiones.descripcion
                                           FROM regiones
                                          WHERE regiones.`status` = 1 ORDER BY 2 ASC",$cnn);
						  while($row05=mysql_fetch_array($query05)){					   					
		  ?>
          <option value="<?php echo $row05[0];?>"><?php echo utf8_decode($row05[1]);?></option>
          <?php }?>		  	  
        </select><br /><span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
    </tr>    
	<tr>
		<td class="etiqueta">Filtro Trababajador:</td>	
		<td id="select09">
			<select id="paciFiltro" onchange="EstadoFiltro()" style="width:200px">
				<option value="TODOS"> TODOS</option>
				<option value="codigo"> C&oacute;digo </option>
				<option value="cedula"> C&eacute;dula </option>
				<option value="nombre"> Nombre</option>
		</select><br /><span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
    </tr>
	<tr>   
      <td class="etiqueta">Trabajador:</td> 
      <td>
		  <input  id="stdName" type="text" style="width:300px" disabled="disabled" value="<?php echo $row01['trabajador'];?>" />
	        <span id="input10"><input type="hidden" name="trabajador" id="stdID" value="<?php echo $row01['cod_emp'];?>" /><br /> 
            <span class="textfieldRequiredMsg">Debe De Seleccionar Un Campo De la Lista.</span>
            <span class="textfieldInvalidFormatMsg">El Formato es Invalido</span> </span></td>
    </tr>	
	<tr>
	     <td height="20" class="etiqueta">Status:</td>
	     <td  id="select10">		    
			   <select name="status" style="width:120px;">	                
     				   <option value="<?php echo $row01['status'];?>"><?php echo statuscal($row01['status']);?></option>
                       <option value="1"> Activo </option>
                       <option value="2"> Inactivo </option>    
	           </select><br /><span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
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
            <input name="codigo" type="hidden"  value="<?php echo $codigo;?>" />
            <input name="metodo" type="hidden"  value="<?php echo $metodo;?>" />
			<input name="usuario" type="hidden"  value="<?php echo $usuario;?>" />
	        <input name="href" type="hidden" value="../inicio.php?area=formularios/Cons_<?php echo $archivo."&Nmenu=".$Nmenu;?>"/>	   			
		     </td>
	   </tr>
  </table>
</form>
</body>
</html>
<script type="text/javascript">
var fecha01 = new Spry.Widget.ValidationTextField("fecha01", "date", {format:"dd-mm-yyyy", hint:"DD-MM-AAA", validateOn:["blur", "change"], useCharacterMasking:true, isRequired:true});

var input01 = new Spry.Widget.ValidationTextField("input01", "none", {validateOn:["blur", "change"]});
var input02 = new Spry.Widget.ValidationTextField("input02", "none", {validateOn:["blur", "change"]});

var select01 = new Spry.Widget.ValidationSelect("select01", {validateOn:["blur", "change"]});
var select02 = new Spry.Widget.ValidationSelect("select02", {validateOn:["blur", "change"]});

var textarea01 = new Spry.Widget.ValidationTextarea("textarea01", {minChars:4, maxChars:300, validateOn:["blur", "change"], counterType:"chars_count", counterId:"Counterror_mess2", useCharacterMasking:false ,isRequired:false});

var input10 = new Spry.Widget.ValidationTextField("input10", "none", {validateOn:["blur", "change"]});

var select09 = new Spry.Widget.ValidationSelect("select09", {validateOn:["blur", "change"]});
var select10 = new Spry.Widget.ValidationSelect("select10", {validateOn:["blur", "change"]});

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