<?php 
$id      = $_GET['codigo']; 
$Nmenu   = $_GET['Nmenu'];
$titulo  = "INDICADORES";
$archivo = "ind_asignacion";
$archivo2 = "Mod_ind_asignacion&Nmenu=".$Nmenu."&codigo=".$id."";
$metodo  = "modificar";

require_once('autentificacion/aut_verifica_menu.php');
?>
<form action="scripts/sc_<?php echo $archivo;?>.php" method="post" name="add" id="add"> 
     <table width="80%" align="center">
         <tr valign="top">                    
		     <td height="23" colspan="2" class="etiqueta_title" align="center"> PROCESAR <?php echo $titulo;?></td>
         </tr>
         <tr> 
    	       <td height="8" colspan="2" align="center"><hr></td>    
     	</tr>
    <tr>
      <td class="etiqueta" width="35%">Fecha De Indicador:</td>
      <td id="fecha01" width="65%"><input type="text" name="codigo"  style="width:100px" value="<?php echo Rconversion($id);?>" readonly="true" />
            <img src="imagenes/ok.gif" alt="Valido" class="validMsg" border="0"/><br />
            <span class="textfieldRequiredMsg">La Fecha Es Requerida.</span>
            <span class="textfieldInvalidFormatMsg">El Formato Es Invalido</span></td>
    </tr>
    <tr>
      <td class="etiqueta">Indicador:</td>
      	<td id="select01"><select name="metodo" style="width:250px">
							<option value="">Selecione...</option>
          <?php  $query05 = mysql_query("SELECT codigo, descripcion FROM indicadores WHERE status =  '1'",$cnn);
						  while($row05=mysql_fetch_array($query05)){					   					
		  ?>
          <option value="<?php echo $row05[0];?>"><?php echo utf8_decode($row05[1]);?></option>
          <?php }?>		  	  
        </select>
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br />
        	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
    </tr>
<!--
	  <tr>
	     <td height="20" class="etiqueta">Status:</td>
	     <td  id="select01">		    
			   <select name="status" style="width:120px;">	
     				   <option value="1"> Activo </option>
                       <option value="2"> Inactivo </option>    
	           </select><img src="imagenes/ok.gif" alt="Valido" class="validMsg" border="0"/><br />
       	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
    </tr>	 -->

         <tr>
            <td height="8" colspan="2" align="center"><hr></td>
         </tr>	
         <tr> 
		     <td colspan="2" align="center">
      		<input  type="submit" name="salvar"  id="salvar" value="procesar" class="button1"
			                       onMouseOver="Fondos (this.id ,'A',  'button1Act', 'button1')" 
	                               onMouseOut="Fondos (this.id ,'D', 'button1Act', 'button1')">	&nbsp;
		    <input type="reset"     id="limpiar"  value="Restablecer" class="button1"
			                       onMouseOver="Fondos (this.id ,'A',  'button1Act', 'button1')" 
	                               onMouseOut="Fondos (this.id ,'D', 'button1Act', 'button1')">	&nbsp;
		    <input type="button"   id="volver"  value="Volver" onClick="history.back(-1);"  class="button1"
			                       onMouseOver="Fondos (this.id ,'A',  'button1Act', 'button1')" 
	                               onMouseOut="Fondos (this.id ,'D', 'button1Act', 'button1')">
		    <!--<input name="metodo" type="hidden"  value="<?php echo $metodo;?>" />-->
			<input name="usuario" type="hidden"  value="<?php echo $usuario;?>" />
			<input name="status" type="hidden"  value="1" />
	        <input name="href" type="hidden" value="../inicio.php?area=formularios/<?php echo $archivo2?>"/>		   			
		     </td>
	   </tr>
  </table>
</form>
</body>
</html>
<script type="text/javascript">

var fecha01 = new Spry.Widget.ValidationTextField("fecha01", "date", {format:"dd-mm-yyyy", hint:"DD-MM-AAA", 
    validateOn:["blur", "change"], useCharacterMasking:true});

var select01 = new Spry.Widget.ValidationSelect("select01", {validateOn:["blur", "change"]});

</script>