<script language="javascript" type="text/javascript">
	function Actualizar01(codigo){
		var Contenedor = "Contenedor_Resp";
		var valor      = "ajax/nov_usuarios.php"; 	
			
		if ((codigo != "")){		
			ajax=nuevoAjax();
				ajax.open("POST", valor, true);
				ajax.onreadystatechange=function(){ 
					if (ajax.readyState==4){
					document.getElementById(Contenedor).innerHTML = ajax.responseText;
						//window.location.href=""+href+"";  	 // window.location.reload();				
					} 
				}
				ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");	
				ajax.send("codigo="+codigo+"");
		}
	}			
</script>
<?php 
$Nmenu     = 345; 
$archivo = "nov_usuarios&Nmenu=".$Nmenu."";
require_once('autentificacion/aut_verifica_menu.php');
?>
<form action="sc_maestros/nov_usuarios.php" method="post" name="add" id="add"> 
  <fieldset class="fieldset">
  <legend>FILTROS POR NOVEDADES:</legend>
     <table width="80%" align="center">
     <tr>
      <td class="etiqueta" width="15%">NOVEDADES:</td>
      <td id="select01" width="35%"><select name="codigo" id="codigo" style="width:240px" onchange="Actualizar01(this.value)">
							<option value="">Seleccione...</option>
          <?php  $query05 = mysql_query("SELECT codigo, descripcion FROM novedades
                                          WHERE status = '1' ORDER BY 2 ASC",$cnn);
						  while($row05=mysql_fetch_array($query05)){					   					
		  ?>
          <option value="<?php echo $row05[0];?>"><?php echo $row05[0].' - '.utf8_decode($row05[1]);?></option>
          <?php }?>		  	  
        </select>
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br />
        	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
            <td colspan="2" width="50%">&nbsp;</td>
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
         <input name="usuario" type="hidden"  value="<?php echo $usuario;?>" />		
        <input name="href" type="hidden" value="../inicio.php?area=maestros/Cons_<?php echo $archivo ?>"/>		   			
		 </td>
	   </tr>
  </table>
  </fieldset>
</form>
<script type="text/javascript">

	var select01 = new Spry.Widget.ValidationSelect("select01", {validateOn:["blur", "change"]});	
	function spryValidarDec(ValorN){
	// alert(ValorN);
 		var ValorN = new Spry.Widget.ValidationTextField(ValorN, "currency", {format:"comma_dot",validateOn:["blur"], useCharacterMasking:true, minValue:"0"});
	}
</script>