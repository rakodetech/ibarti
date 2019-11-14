<?php
	include_once('../autentificacion/aut_config.inc.php');
	include_once('../funciones/funciones.php');
	mysql_select_db($bd_cnn, $cnn);
		$codigo       = $_POST['codigo'];
	
	$result01 = mysql_query("SELECT trabajadores.cod_emp, trabajadores.ci, 
	                                trabajadores.nombres,  trabajadores.fecha_ingreso,
                                    f_edad(trabajadores.fecha_nac) as edad, nomina.des_cont,
									 regiones.descripcion AS regiones, 
                                          trabajadores_status.descripcion AS status
                               FROM trabajadores , nomina , regiones, trabajadores_status
                              WHERE trabajadores.co_cont = nomina.co_cont 
                                AND trabajadores.id_region = regiones.id
								AND trabajadores.`status` = trabajadores_status.codigo
								AND trabajadores.cod_emp = '$codigo' ", $cnn);  
	$row01    = mysql_fetch_array($result01);

?>
<form action="" method="post" name="Mod" id="Mod"> 
     <table width="75%" align="center">
         <tr valign="top">                    
		     <td height="23" colspan="2" class="etiqueta_title" align="center"> DATOS DEL TRABAJADOR  (PROFIT)</td>
         </tr>
         <tr> 
            <td height="8" colspan="2" align="center"><hr></td>
         </tr>	 
    <tr>
      <td class="etiqueta" width="25%">C&oacute;digo:</td>
      <td id="input01" width="75%"><input type="text" name="codigo" maxlength="12" style="width:120px" 
	                                      value="<?php echo $row01["cod_emp"];?>" readonly="true"/>	  
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br>
        <span class="textfieldRequiredMsg">La Descripcion es Requerida.</span>
		<span class="textfieldMinCharsMsg">Debe Escribir mínimo 2 Caracteres.</span></td>
    </tr>
    <tr>
      <td class="etiqueta">Cedula:</td>
      <td id="input02"><input type="text" name="cedula" maxlength="12" style="width:120px" 
	                                      value="<?php echo $row01["ci"];?>" readonly="true"/>	  
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br>
        <span class="textfieldRequiredMsg">La Descripcion es Requerida.</span>
		<span class="textfieldMinCharsMsg">Debe Escribir mínimo 2 Caracteres.</span></td>
    </tr>    
    <tr>
      <td class="etiqueta">Usuarios:</td>
      <td id="input06"><input type="text" name="usuarios" maxlength="60" 
                                          value="<?php echo utf8_decode($row01["nombres"]);?>" style="width:250px" readonly="true"/>	  
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br>
        <span class="textfieldRequiredMsg">La Descripcion es Requerida.</span>
		<span class="textfieldMinCharsMsg">Debe Escribir mínimo 2 Caracteres.</span></td>
    </tr>		  
    <tr>
      <td class="etiqueta">Fecha de Ingreso:</td>
      <td id="input03"><input type="text" name="fecha_ing" maxlength="12" style="width:120px" 
	                                      value="<?php echo $row01["fecha_ingreso"];?>" readonly="true"/>	  
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br>
        <span class="textfieldRequiredMsg">La Descripcion es Requerida.</span>
		<span class="textfieldMinCharsMsg">Debe Escribir mínimo 2 Caracteres.</span></td>
    </tr>    
    <tr>
      <td class="etiqueta">Edad:</td>
      <td id="input04"><input type="text" name="fecha_nac" maxlength="12" style="width:120px" 
	                                      value="<?php echo $row01["edad"];?>" readonly="true"/>	  
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br>
        <span class="textfieldRequiredMsg">La Descripcion es Requerida.</span>
		<span class="textfieldMinCharsMsg">Debe Escribir mínimo 2 Caracteres.</span></td>
    </tr>        
    <tr>
      <td class="etiqueta">Contracto:</td>
      <td id="input05"><input type="text" name="contracto" maxlength="60" 
                                          value="<?php echo utf8_decode($row01["des_cont"]);?>" style="width:250px" readonly="true"/>	  
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br>
        <span class="textfieldRequiredMsg">La Descripcion es Requerida.</span>
		<span class="textfieldMinCharsMsg">Debe Escribir mínimo 2 Caracteres.</span></td>
    </tr>		
    <tr>
      <td class="etiqueta">Departamento:</td>
      <td id="input06"><input type="text" name="departamento" maxlength="60" value="<?php echo utf8_decode($row01["regiones"]);?>" 
	  	style="width:250px" readonly="true"/>	  
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br>
        <span class="textfieldRequiredMsg">La Descripcion es Requerida.</span>
		<span class="textfieldMinCharsMsg">Debe Escribir mínimo 2 Caracteres.</span></td>
    </tr>		  
    <tr>
      <td class="etiqueta">Estado:</td>
      <td id="input04"><input type="text" name="estado" maxlength="12" style="width:120px" 
	                                      value="<?php echo $row01["status"];?>" readonly="true"/>	  
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br>
        <span class="textfieldRequiredMsg">La Descripcion es Requerida.</span>
		<span class="textfieldMinCharsMsg">Debe Escribir mínimo 2 Caracteres.</span></td>
    </tr>        

          <tr>
              <td colspan="2" align="center"><hr></td>
         </tr>
<?php /*
         <tr> 
		     <td colspan="2" align="center">
      		<input  type="submit" name="salvar"  id="salvar" value="Guardar" class="button1"
			                       onMouseOver="Fondos (this.id ,'A',  'button1Act', 'button1')" 
	                               onMouseOut="Fondos (this.id ,'D', 'button1Act', 'button1')">	&nbsp;
		    <input type="reset"     id="limpiar"  value="Restablecer" class="button1"
			                       onMouseOver="Fondos (this.id ,'A',  'button1Act', 'button1')" 
	                               onMouseOut="Fondos (this.id ,'D', 'button1Act', 'button1')">	&nbsp;
		    <input type="button"   id="volver"  value="Volver" onClick="history.back(-1);"  class="button1"
			                       onMouseOver="Fondos (this.id ,'A',  'button1Act', 'button1')" 
	                               onMouseOut="Fondos (this.id ,'D', 'button1Act', 'button1')">			
		    <input type="hidden" name="id" value="<?php echo $id; ?>"/>		 
			<input type="hidden"  name="metodo" value="Modificar" />
			<input type="hidden"  name="archivo" value="Concepto" />
			<input type="hidden"  name="tabla" value="snvaria" /> 
			<input type="hidden"  name="href" value="../inicio.php?area=maestros/Cons_Concepto&Nmenu=<?php echo $_GET['Nmenu'];?>" />	 			
			 </td>
	   </tr>
	    */ ?>
  </table>
</form>
</body>
</html>
<script language="javascript" type="text/javascript">
/*
var input01 = new Spry.Widget.ValidationTextField("input01", "none", {minChars:2, validateOn:["blur", "change"]});
var input02 = new Spry.Widget.ValidationTextField("input02", "none", {minChars:2, validateOn:["blur", "change"]});
var input03 = new Spry.Widget.ValidationTextField("input03", "none", {minChars:1, validateOn:["blur", "change"]});

var select01 = new Spry.Widget.ValidationSelect("select01", {validateOn:["blur", "change"]});
var select10 = new Spry.Widget.ValidationSelect("select10", {validateOn:["blur", "change"]});
*/
</script>