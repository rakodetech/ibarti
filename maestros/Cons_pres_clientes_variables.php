<script language="javascript" type="text/javascript">
	function Actualizar01(){
		var codigo     = document.getElementById("codigo").value;  // REGION
		var region   = document.getElementById("region").value; // CONCEPTOS
        var categoria  = document.getElementById("categoria").value;
		var Contenedor = "Contenedor_Resp";
		var valor      = "ajax/concepto_profit.php"; 			
				
		if ((codigo != "")&&(region != "")){		
			ajax=nuevoAjax();
				ajax.open("POST", valor, true);
				ajax.onreadystatechange=function(){ 
					if (ajax.readyState==4){
					document.getElementById(Contenedor).innerHTML = ajax.responseText;
						//window.location.href=""+href+"";  	 // window.location.reload();				
					} 
				}
				ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");	
				ajax.send("codigo="+codigo+"&region="+region+"&categoria="+categoria+"");
		}
	}	

	function Actualizar03(campo_id){		

		document.getElementById("metodo").value = campo_id; 					
		if (campo_id == "renglones"){
			alert(" Solo se Modificara el Concepto para la Region Actual");
		}else{
			alert(" Se Modificara el Concepto Para Todas las Regiones");	
		}
	}		
</script>
<?php 
$Nmenu     = 330; 
$codigo    = $_GET['id'];
$categoria = $_GET['categoria'];
//$archivo = "concepto_profit&Nmenu=".$Nmenu."&id=".$codigo."";
$archivo = "concepto_profit&Nmenu=".$Nmenu."&id=".$codigo."";
require_once('autentificacion/aut_verifica_menu.php');
$result01 = mysql_query("SELECT snvaria.abrev, snvaria.des_var FROM snvaria WHERE snvaria.co_var = '$codigo'", $cnn);  
$row01    = mysql_fetch_array($result01);
?>
<form action="sc_maestros/Concepto.php" method="post" name="add" id="add"> 
  <fieldset class="fieldset">
  <legend>FILTROS POR REGIONES Y CONCEPTOS:</legend>
     <table width="98%" align="center">
     <tr>
      <td class="etiqueta">REGIONES:</td>
      	<td  id="select02"><select name="region" id="region" style="width:240px" onchange="Actualizar01()">
							<option value="">SELECCIONE...</option>
          <?php  $query05 = mysql_query("SELECT regiones.id, regiones.descripcion
										   FROM regiones WHERE regiones.`status` = 1
										  ORDER BY regiones.descripcion ASC",$cnn);
						  while($row05=mysql_fetch_array($query05)){					   					
		  ?>
          <option value="<?php echo $row05[0];?>"><?php echo utf8_decode($row05[1]);?></option>
          <?php }?>		  	  
        </select>
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br />
        	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
      <td class="etiqueta">CONCEPTO:</td>
      <td id="select01"><select name="codigo" id="codigo" style="width:240px" onchange="Actualizar01()">
							<option value="<?php echo $codigo ?>"><?php echo ''.$codigo.' - '.$row01[1];?></option>
          <?php  $query05 = mysql_query("SELECT snvaria.co_var, snvaria.des_var FROM snvaria 
		                                  ORDER BY snvaria.status, snvaria.co_var ASC",$cnn);
						  while($row05=mysql_fetch_array($query05)){					   					
		  ?>
          <option value="<?php echo $row05[0];?>"><?php echo $row05[0].' - '.$row05[1];?></option>
          <?php }?>		  	  
        </select>
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br />
        	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
    </tr>
     <tr>
      <td class="etiqueta">ACTUALIZAR MASIVO DE REGIONES:</td>
      	<td  id="select03"><select name="masivo" id="masivo" style="width:150px" onchange="Actualizar03(this.value)">
							<option value="renglones">NO</option>
                            <option value="renglones_masivo">SI</option>                         
						</option>
        </select>
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br />
       	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
        
      <td class="etiqueta">CATEGOR&Iacute;A:</td>
     <td id="select04"><select name="categoria" id="categoria" style="width:240px" onchange="Actualizar01( )">
		<?php /*<option value="<?php echo $codigo ?>"><?php echo ''.$codigo.' - '.utf8_decode($row01[1]);?></option> */ ?>
          <?php 
		   if (isset($categoria)){
		   $query05 = mysql_query("SELECT snvaria_categoria.id, snvaria_categoria.descripcion FROM snvaria_categoria
		                                  WHERE snvaria_categoria.status = 1 AND snvaria_categoria.id = '$categoria'",$cnn);
		   		$row05=mysql_fetch_array($query05);
		  echo '<option value="'.$row05[0].'">'.$row05[0].' - '.$row05[1].'</option>';
		   }

		   $query05 = mysql_query("SELECT snvaria_categoria.id, snvaria_categoria.descripcion FROM snvaria_categoria
		                                  WHERE snvaria_categoria.status = 1 ORDER BY 1 ASC",$cnn);
						  while($row05=mysql_fetch_array($query05)){					   					
		  ?>
          <option value="<?php echo $row05[0];?>"><?php echo $row05[0].' - '.$row05[1];?></option>
          <?php }?>		  	  
        </select>
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br />
        	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>

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
        <input name="href" type="hidden" value="../inicio.php?area=maestros/Cons_<?php echo $archivo ?>"/>		   			
		 </td>
	   </tr>
  </table>
  </fieldset>
</form>
<script type="text/javascript">
//	var input01 = new Spry.Widget.ValidationTextField("input01", "none", {minChars:4, validateOn:["blur", "change"]});
//	var input02 = new Spry.Widget.ValidationTextField("input02", "none", {minChars:4, validateOn:["blur", "change"]});	
	var select01 = new Spry.Widget.ValidationSelect("select01", {validateOn:["blur", "change"]});	
	var select02 = new Spry.Widget.ValidationSelect("select02", {validateOn:["blur", "change"]});	
	var select03 = new Spry.Widget.ValidationSelect("select03", {validateOn:["blur", "change"]});	
	var select04 = new Spry.Widget.ValidationSelect("select04", {validateOn:["blur", "change"]});		
	
	function spryValidarDec(ValorN){
	// alert(ValorN);
 		var ValorN = new Spry.Widget.ValidationTextField(ValorN, "currency", {format:"comma_dot",validateOn:["blur"], useCharacterMasking:true, minValue:"0"});
	}
</script>