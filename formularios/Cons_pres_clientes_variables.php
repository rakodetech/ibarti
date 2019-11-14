<?php 
$Nmenu     = 430; 
$codigo    = $_GET['id'];
//$archivo = "concepto_profit&Nmenu=".$Nmenu."&id=".$codigo."";
$archivo = "pres_clientes_variables&Nmenu=".$Nmenu."&id=".$codigo."";
require_once('autentificacion/aut_verifica_menu.php');
/*
$result01 = mysql_query("SELECT snvaria.abrev, snvaria.des_var FROM snvaria WHERE snvaria.co_var = '$codigo'", $cnn);  
$row01    = mysql_fetch_array($result01);
*/
?>
<form action="scripts/sc_pres_clientes_variables.php" method="post" name="add" id="add"> 
  <fieldset class="fieldset">
  <legend>FILTROS POR CLIENTES:  CAMPOS VARAIBLES</legend>
     <table width="98%" align="center">
     <tr>
      <td class="etiqueta">CLIENTES:</td>
      	<td  id="select01"><select name="cliente" id="cliente" style="width:240px" onchange="Actualizar01()">
							<option value="">SELECCIONE...</option>
          <?php  $query05 = mysql_query("SELECT pres_clientes.codigo, pres_clientes.descripcion
                                           FROM pres_clientes
                                          WHERE pres_clientes.`status` = '1'
										  ORDER BY 2 ASC",$cnn);
						  while($row05=mysql_fetch_array($query05)){					   					
		  ?>
          <option value="<?php echo $row05[0];?>"><?php echo utf8_decode($row05[1]);?></option>
          <?php }?>		  	  
        </select>
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br />
        	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span>
      </td>
      <td class="etiqueta">&nbsp;</td>
        <td class="etiqueta">&nbsp;</td>

    </tr>
	 <tr> 
		<td height="8" colspan="4" align="center"><hr></td>
	 </tr>
   	 <tr> 
		<td colspan="4" id="Contenedor_Resp"></td>
	 </tr>
		 <td colspan="4" align="center">
		 
		<input  type="submit" name="salvar"  id="salvar04" value="Guardar" class="button1" 
							   onMouseOver="Fondos (this.id ,'A',  'button1Act', 'button1')" 
							   onMouseOut="Fondos (this.id ,'D', 'button1Act', 'button1')">	&nbsp;
		<input type="reset"     id="limpiar04"  value="Restablecer" class="button1"
							   onMouseOver="Fondos (this.id ,'A',  'button1Act', 'button1')" 
							   onMouseOut="Fondos (this.id ,'D', 'button1Act', 'button1')">	&nbsp;
		<input type="button"   id="volver04"  value="Volver" onClick="Vinculo('inicio.php?area=maestros/Cons_Concepto&Nmenu=<?php echo $Nmenu;?>')"  class="button1"
							   onMouseOver="Fondos (this.id ,'A',  'button1Act', 'button1')" 
							   onMouseOut="Fondos (this.id ,'D', 'button1Act', 'button1')">
		<input name="metodo" id="metodo" type="hidden"  value="renglones" />
    <?php /*	<!--	<input name="codigo" id="codigo" type="hidden"  value="<?php echo $codigo;?>" />--> */ ?>
        <input name="usuario" type="hidden"  value="<?php echo $usuario;?>" />		
        <input name="href" type="hidden" value="../inicio.php?area=formularios/Cons_<?php echo $archivo ?>"/>		   			
		 </td>
	   </tr>
  </table>
  </fieldset>
</form>
<script type="text/javascript">
//	var input01 = new Spry.Widget.ValidationTextField("input01", "none", {minChars:4, validateOn:["blur", "change"]});
//	var input02 = new Spry.Widget.ValidationTextField("input02", "none", {minChars:4, validateOn:["blur", "change"]});	
	var select01 = new Spry.Widget.ValidationSelect("select01", {validateOn:["blur", "change"]});		
	
	function spryValidarDec(ValorN){
	// alert(ValorN);
 		var ValorN = new Spry.Widget.ValidationTextField(ValorN, "currency", {format:"comma_dot",validateOn:["blur"], useCharacterMasking:true, minValue:"0"});
	}
</script>