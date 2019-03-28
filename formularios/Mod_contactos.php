<link rel="stylesheet" type="text/css" href="latest/stylesheets/autocomplete.css" />
<script type="text/javascript" src="latest/scripts/autocomplete.js"></script>
<?php 
$Nmenu = $_GET['Nmenu'];
$codigo  = $_GET['codigo']; 
$cliente = $_GET['cliente']; 
$titulo  = " MODIFICAR CONTACTOS ";
$archivo = "contactos";
$metodo  = "modificar";
require_once('autentificacion/aut_verifica_menu.php');
$result01 = mysql_query("SELECT cont_proceso.cod_cont_cliente, cont_clientes.descripcion AS cliente,                                cont_proceso.representante, cont_proceso.cargo, 
                                cont_proceso.telefono, cont_proceso.correo, 
								cont_proceso.descripcion, 
                                cont_proceso.cod_cont_prioridad, cont_prioridad.descripcion AS prioridad,
                                cont_proceso.cod_tipo_cont, cont_tipo_contacto.descripcion AS contacto,
                                cont_proceso.cod_stastus_neg, cont_status_negocios.descripcion AS negocio,
                                cont_proceso.cod_status_cont, cont_status.descripcion AS status_cont
                           FROM cont_clientes, cont_proceso,
                                cont_prioridad, cont_tipo_contacto,
                                cont_status_negocios , cont_status
                          WHERE cont_proceso.fecha = '$codigo'  						   
                            AND cont_proceso.cod_cont_cliente = '$cliente'
							AND cont_proceso.cod_cont_cliente = cont_clientes.codigo
                            AND cont_proceso.cod_cont_cliente = cont_proceso.cod_cont_cliente 
                            AND cont_proceso.cod_cont_prioridad = cont_prioridad.codigo 
                            AND cont_proceso.cod_tipo_cont = cont_tipo_contacto.codigo 
                            AND cont_proceso.cod_stastus_neg = cont_status_negocios.codigo 
                            AND cont_proceso.cod_status_cont = cont_status.codigo ", $cnn)or die
								 ('<br><h3>Error Consulta # 2:</h3> '.mysql_error().'<br>');  
         $row01    = mysql_fetch_array($result01);
?>
<form action="scripts/sc_<?php echo $archivo;?>.php" method="post" name="add" id="add"> 
     <table width="80%" align="center">
         <tr valign="top">                    
		     <td height="23" colspan="2" class="etiqueta_title" align="center"><?php echo $titulo;?></td>
         </tr>
         <tr> 
    	       <td height="8" colspan="2" align="center"><hr></td>    
     	</tr>
    <tr>
      <td class="etiqueta">Fecha Recepcion:</td>
      <td id="fecha01"><input type="text" name="fecha_recep" id="fecha_recep"  style="width:100px" 
                              value="<?php echo Rconversion($codigo);?>"/><br />
            <span class="textfieldRequiredMsg">La Fecha Es Requerida.</span>
            <span class="textfieldInvalidFormatMsg">El Formato Es Invalido</span></td>
    </tr>    
    <tr>                           
      <td class="etiqueta">Cliente:</td>
      	<td id="select01"><select name="cliente" style="width:250px">
							<option value="<?php echo $row01['cod_cont_cliente'];?>"><?php echo $row01['cliente'];?></option>
          <?php  $query05 = mysql_query(" SELECT cont_clientes.codigo, cont_clientes.descripcion
                                            FROM cont_clientes
                                           WHERE cont_clientes.`status` = 1 ORDER BY 2 ASC ",$cnn);
						  while($row05=mysql_fetch_array($query05)){					   					
		  ?>
          <option value="<?php echo $row05[0];?>"><?php echo utf8_decode($row05[1]);?></option>
          <?php }?>		  	  
        </select><br /><span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
    </tr>
    <tr>
    <td class="etiqueta" >Representante:</td>
    <td id="input01"><input type="text" id="representante" name="representante" maxlength="120" style="width:250px"
                            value="<?php echo $row01['representante'];?>" /><br />
        <span class="textfieldRequiredMsg">El Campo es Requerido.</span>
        <span class="textfieldMinCharsMsg">Debe Escribir m&aacute;s de 4 caracteres.</span></td>
    </tr>    
    <tr>
      <td class="etiqueta">Cargo:</td>
      <td id="input02"><input type="text" id="cargo" name="cargo" maxlength="60" style="width:250px" 
                              value="<?php echo $row01['cargo'];?>" /><br />
        <span class="textfieldRequiredMsg">El Campo es Requerido.</span>
        <span class="textfieldMinCharsMsg">Debe Escribir m&aacute;s de 4 caracteres.</span></td>
    </tr>    
    <tr>
      <td class="etiqueta">Tel&eacute;fonos:</td>
      <td id="input03">
      <input type="texto" name="telefono" style="width:250px" maxlength="60" value="<?php echo $row01['telefono'];?>"/><br /> 
      <span class="textfieldRequiredMsg">El Campo es Requerido.</span> 
        <span class="textfieldMinCharsMsg">Debe Escribir m&aacute;s de 11 caracteres.</span></td>
    </tr>
	<tr>
      <td class="etiqueta">Email:</td>
      <td id="email"><input name="email" type="text" maxlength="60" style="width:250px" value="<?php echo $row01['correo'];?>"><br />
        <span class="textfieldRequiredMsg">El Campo es Requerido.</span>
        <span class="textfieldMinCharsMsg">Debe Escribir m&aacute;s de 4 caracteres.</span></td>
    </tr>
    <tr>
      <td class="etiqueta">Descripcion:</td>
      <td id="textarea01"><textarea  name="descripcion" cols="45" rows="3"><?php echo $row01['descripcion'];?></textarea>
        <span id="Counterror_mess1" class="texto">&nbsp;</span> <br />
        <span class="textareaRequiredMsg">El Campo es Requerido.</span>
        <span class="textareaMinCharsMsg">Debe Escribir mas de 10 caracteres.</span>
        <span class="textareaMaxCharsMsg">El maximo de caracteres permitidos es 255.</span></td>
    </tr>      
    <tr> 
      <td class="etiqueta">Prioridad:</td>
      	<td id="select02"><select name="prioridad" style="width:250px">
							<option value="<?php echo $row01['cod_cont_prioridad'];?>">
							<?php echo $row01['prioridad'];?></option>
          <?php  $query05 = mysql_query("SELECT codigo, descripcion FROM cont_prioridad
                                          WHERE `status` = 1  ORDER BY 2 ASC",$cnn);
						  while($row05=mysql_fetch_array($query05)){					   					
		  ?>
          <option value="<?php echo $row05[0];?>"><?php echo utf8_decode($row05[1]);?></option>
          <?php }?>		  	  
        </select><br /><span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
    </tr>
    <tr>
      <td class="etiqueta">Tipo de contacto:</td>
      	<td id="select03"><select name="tipo_contacto" style="width:250px">
						  <option value="<?php echo $row01['cod_tipo_cont'];?>"><?php echo $row01['contacto'];?></option>
          <?php  $query05 = mysql_query("SELECT codigo, descripcion FROM cont_tipo_contacto
                                          WHERE `status` = 1  ORDER BY 2 ASC",$cnn);
						  while($row05=mysql_fetch_array($query05)){					   					
		  ?>
          <option value="<?php echo $row05[0];?>"><?php echo utf8_decode($row05[1]);?></option>
          <?php }?>		  	  
        </select><br /><span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
    </tr>    
    <tr>    
      <td class="etiqueta">Tipos de Requerimientos:</td>
      <td>				
			<table width="100%" border="0">
			    <tr>
      				<td class="etiqueta" width="60%">REQUERIMIENTOS:</td>
					<td class="etiqueta" width="20%">CHECK:</td>
                    <td width="20%">&nbsp;</td>
    			</tr>
			<?php 
			$query03 = mysql_query("SELECT codigo, descripcion FROM cont_tipo_req
                                     WHERE `status` = 1",$cnn) or die
				 ('<br><h3>Error Consulta # 1:</h3> '.mysql_error().'<br>');
			while($row03=mysql_fetch_array($query03)){
	             $cod_req = $row03[0]; 

			$query04 = mysql_query("SELECT cont_proceso_req.cod_fecha FROM  cont_proceso_req
                                     WHERE cont_proceso_req.cod_fecha = '$codigo' 
									   AND cont_proceso_req.cod_cont_cliente = '$cliente' 
									   AND cont_proceso_req.cod_cont_tipo_req = '$cod_req'",$cnn) or die
				 ('<br><h3>Error Consulta # 1:</h3> '.mysql_error().'<br>');
					
					$row04 = mysql_fetch_array($query04); 
					$req = $row04[0];
					if (isset($req)){
						$result = 'checked="checked"';
						}else{
						$result = '';	
						}	 
				 				
					echo'<tr>
						<td class="texto">'.$row03[0].' - '.$row03[1].'</td>
						<td >&nbsp;&nbsp;<input name="requerimiento[]" type="checkbox" value="'.$row03[0].'"                                         '.$result.' style="width:auto" /></td>	
							<td>&nbsp;</td>
						</tr>';
					}?>	
		</table>
      </td>
	</tr>
    <tr>
      <td class="etiqueta">status de Negocio:</td>
      	<td id="select04"><select name="status_negocio" style="width:250px">
							<option value="<?php echo $row01['cod_stastus_neg'];?>"><?php echo $row01['negocio'];?></option>
          <?php  $query05 = mysql_query("SELECT codigo, descripcion FROM cont_status_negocios
                                          WHERE `status` = 1  ORDER BY 2 ASC",$cnn);
						  while($row05=mysql_fetch_array($query05)){					   					
		  ?>
          <option value="<?php echo $row05[0];?>"><?php echo utf8_decode($row05[1]);?></option>
          <?php }?>		  	  
        </select><br /><span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
    </tr>                       
    <tr>
      <td class="etiqueta">status de contacto:</td>
      	<td id="select05"><select name="status_contacto" style="width:250px">
							<option value="<?php echo $row01['cod_status_cont'];?>"><?php echo $row01['status_cont'];?></option>
          <?php  $query05 = mysql_query("SELECT codigo, descripcion FROM cont_status
                                          WHERE `status` = 1  ORDER BY 2 ASC",$cnn);
						  while($row05=mysql_fetch_array($query05)){					   					
		  ?>
          <option value="<?php echo $row05[0];?>"><?php echo utf8_decode($row05[1]);?></option>
          <?php }?>		  	  
        </select><br /><span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
    </tr>            
         <tr> 
            <td height="8" colspan="2" align="center"><br /><hr></td>
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
var input03 = new Spry.Widget.ValidationTextField("input03", "none", {validateOn:["blur", "change"],isRequired:false});

var email    = new Spry.Widget.ValidationTextField("email", "email", {minChars:4, validateOn:["blur"]});

var select01 = new Spry.Widget.ValidationSelect("select01", {validateOn:["blur", "change"]});
var select02 = new Spry.Widget.ValidationSelect("select02", {validateOn:["blur", "change"]});
var select03 = new Spry.Widget.ValidationSelect("select03", {validateOn:["blur", "change"]});
var select04 = new Spry.Widget.ValidationSelect("select04", {validateOn:["blur", "change"]});
var select05 = new Spry.Widget.ValidationSelect("select05", {validateOn:["blur", "change"]});

var textarea01 = new Spry.Widget.ValidationTextarea("textarea01", {minChars:4, maxChars:255, validateOn:["blur", "change"], counterType:"chars_count", counterId:"Counterror_mess2", useCharacterMasking:false ,isRequired:false});
</script>