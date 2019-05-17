<script language="javascript" type="text/javascript">
function Actualizar01(){
var Contenedor = "Contenedor_R";
var Usuario    = document.getElementById("id").value;
var idX        = document.getElementById("relacion").value;
var Valido = 0; 

	if(idX == "Clientes"){
	 var valor = "autentificacion/aj_Clientes.php"; 
	 var valor2 = "autentificacion/aj_Clientes_F.php"; 
 
	 Valido = 1; 
	}else if(idX == "Trabajadores"){	
	 var valor = "autentificacion/aj_Trabajadores.php"; 
 	 var valor2 = "autentificacion/aj_Trabajadores_F.php"; 

	 Valido = 1;
	}else{

	} 		

		if( Valido == 1){
			
			ajax=nuevoAjax();
				ajax.open("POST", valor, true);
				ajax.onreadystatechange=function()  
				{ 
					if (ajax.readyState==4)
					{
					document.getElementById(Contenedor).innerHTML = ajax.responseText;
					Actualizar02(valor2);
					//window.location.href=""+href+"";  	 // window.location.reload();				
					} 
				}
				ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				ajax.send("id="+idX+"&usuario="+Usuario+"&filtro=TODOS");
		}	
}

function Actualizar02(valor){
//alert(valor);
	 var Contenedor = "Filtro_R";					
			ajax=nuevoAjax();
				ajax.open("POST", valor, true);
				ajax.onreadystatechange=function()  
				{ 
					if (ajax.readyState==4)
					{
					document.getElementById(Contenedor).innerHTML = ajax.responseText;
					//window.location.href=""+href+""; 	 // window.location.reload();				
					} 
				}
				ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				ajax.send("");
}


function Actualizar03(filtro, relacion){
var Contenedor = "Contenedor_R";
var Usuario    = document.getElementById("id").value;
var idX        = document.getElementById("relacion").value;
var Filtro     = filtro;  

var Valido = 0; 
//alert(filtro+relacion);
	if(idX == "Clientes"){
	 var valor = "autentificacion/aj_Clientes.php"; 
	 Valido = 1; 
	}else if(idX == "Trabajadores"){	
	 var valor = "autentificacion/aj_Trabajadores.php"; 

	 Valido = 1;
	} 		

		if( Valido == 1){
			
			ajax=nuevoAjax();
				ajax.open("POST", valor, true);
				ajax.onreadystatechange=function()  
				{ 
					if (ajax.readyState==4)
					{
					document.getElementById(Contenedor).innerHTML = ajax.responseText;
					//Actualizar02(valor2);
					//window.location.href=""+href+"";
					 // window.location.reload();				
					} 
				}
				ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				ajax.send("id="+idX+"&usuario="+Usuario+"&filtro="+Filtro+"");
		}	
}

function Check(){
var incrX    = document.getElementById("n_incr").value;
	var 	incr =	++incrX;
	if(document.getElementById("Check_ctr").checked==true){
		//alert('true');	
			for (i = 1; i < incr; i++){	
			document.getElementById("check"+i+"").checked = true;
			//chk[i].checked = true ;
		//	alert(chec);
			}
	}else{
	
//	alert('false');	
			for (i = 1; i < incr; ++i){		
			document.getElementById("check"+i+"").checked = false;
			//alert(chec);
			//document.getElementById(chec).checked==false;
			//chk[i].checked = false ;
			}
	}
}
</script>
<?php
mysql_select_db($bd2_cnn, $cnn);
$id = $_GET['codigo'];
$result01 = mysql_query("SELECT usuarios.cedula, usuarios.nombre, usuarios.apellido, usuarios.login,
                                usuarios.id_perfil, perfil.descripcion AS perfil, usuarios.fec_mod_pass, usuarios.`status`,
								usuarios.email
                           FROM usuarios, perfil 
                          WHERE usuarios.id_perfil = perfil.id
                            AND usuarios.cedula = '$id'", $cnn); 
$row01    = mysql_fetch_array($result01);
?>
<form action="autentificacion/sc_Usuarios.php" method="post" name="mod_usuarios" id="mod_usuarios"> 
  <fieldset class="fieldset">
  <legend>Modificar Datos Básicos Usuarios </legend>
     <table width="80%" align="center">
    <tr>
      <td class="etiqueta">C&eacute;dula:</td>
      <td id="input01"><input type="text" name="cedula" maxlength="11" value="<?php echo $id?>" readonly="true" style="width:120px" />
        <img src="imagenes/ok.gif" alt="Valido" class="validMsg" border="0"/> <br />
        <span class="textfieldRequiredMsg">El Campo es Requerido.</span> 
        <span class="textfieldMinCharsMsg">Debe Escribir m&aacute;s de 4 caracteres.</span></td>
	 </tr>
    <tr>
      <td class="etiqueta">Nombres:</td>
      <td id="input02"><input type="text" name="nombre" maxlength="120" style="width:200px" value="<?php echo $row01['nombre']?>"/>
        <img src="imagenes/ok.gif" alt="Valido" class="validMsg" border="0"/> <br />
        <span class="textfieldRequiredMsg">El Campo es Requerido.</span> 
        <span class="textfieldMinCharsMsg">Debe Escribir m&aacute;s de 4 caracteres.</span></td>
	 </tr>
    <tr>
      <td class="etiqueta">Apellidos: </td>
      <td id="input03"><input type="text" name="apellido" maxlength="120" style="width:200px" value="<?php echo $row01['apellido']?>"/>
        <img src="imagenes/ok.gif" alt="Valido" class="validMsg" border="0"/> <br />
        <span class="textfieldRequiredMsg">El Campo es Requerido.</span>
        <span class="textfieldMinCharsMsg">Debe Escribir m&aacute;s de 4 caracteres.</span></td>
    </tr>
	<tr>
      <td class="etiqueta">Email:</td>
      <td id="email"><input name="email" type="text" maxlength="60" style="width:250px" value="<?php echo $row01['email']?>">
        <img src="imagenes/ok.gif" alt="Valido" class="validMsg" border="0"/> <br />
        <span class="textfieldRequiredMsg">El Campo es Requerido.</span>
        <span class="textfieldMinCharsMsg">Debe Escribir m&aacute;s de 4 caracteres.</span></td>
    </tr>	
	<tr>
      <td class="etiqueta">Login:</td>
      <td id="input04"><input name="login" type="text" maxlength="15" style="width:120px" value="<?php echo $row01['login']?>"/>
        <img src="imagenes/ok.gif" alt="Valido" class="validMsg" border="0"/> <br />
        <span class="textfieldRequiredMsg">El Campo es Requerido.</span>
        <span class="textfieldMinCharsMsg">Debe Escribir m&aacute;s de 4 caracteres.</span></td>
    </tr>
    <tr>
      <td class="etiqueta">Password:</td>
      <td><input name="check"  id"check" type="checkbox"  value="ON"  onchange="document.mod_usuarios.password1.disabled=!document.mod_usuarios.password1.disabled; 
document.mod_usuarios.password2.disabled=!document.mod_usuarios.password2.disabled;"/>
<span id="input05">
<input name="password1" id="password1" type="password" style="width:120px" maxlength="11" disabled="disabled" value=""/>
      		  <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br>
          	<span class="textfieldRequiredMsg">El Valor es Requerido.</span>
          	<span class="textfieldMinCharsMsg">Debe Escribir mas de 4 caracteres.</span>
	  </span>
</span>	  
	  </td>
    </tr>	   
    <tr>
      <td class="etiqueta">Password (repitalo):</td>
      <td id="input06">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	          <input name="password2" id="password2" type="password" style="width:120px" maxlength="11" disabled="disabled">
      		  <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/> <br>
          	<span class="textfieldRequiredMsg">El Valor es Requerido.</span>
          	<span class="textfieldMinCharsMsg">Debe Escribir mas de 4 caracteres.</span>
     </td>
    </tr> 	
    <tr>
      <td class="etiqueta">Perfil:</td>
      	<td id="select01">
      		<select name="perfil" style="width:200px">
			<option value="<?php echo $row01['id_perfil']?>"><?php echo $row01['perfil']?></option> 
          <?php  $query02 = mysql_query("SELECT * FROM perfil WHERE status = 1 ORDER BY 2 ",$cnn);
						  while($row02=mysql_fetch_array($query02))
				  {
   
					if($row02[0] == 1){
						if($row02[0] == $_SESSION['id_perfil']){
							echo '<option value="'.$row02[0].'">'.$row02[1].'</option>';				
						}	
					}else{			  
						echo '<option value="'.$row02[0].'">'.$row02[1].'</option>';
					}   				
				}?>
         </select>
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br />
        	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
    </tr>
	<tr>
	     <td height="20" class="etiqueta">Status:</td>
	     <td  id="select06">		    
			   <select name="status" style="width:120px;">    				   
					   <option value="<?php echo $row01['status']?>"> <?php echo statuscal($row01['status'])?></option>
					   <option value="1"> Activo </option>
                       <option value="2"> Inactivo </option>    
	           </select><img src="imagenes/ok.gif" alt="Valido" class="validMsg" border="0"/><br />
       	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
    </tr>	
	 <tr> 
            <td height="8" colspan="2" align="center"><hr></td>
         </tr>	
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
		    <input name="archivo" type="hidden"  value="modificar"/>
		    <input name="id" id="id" type="hidden"  value="<?php echo $id;?>" />
	        <input name="href" type="hidden" value="../inicio.php?area=autentificacion/Cons_Usuarios&Nmenu=<?php echo $_GET['Nmenu']?>"/>		   			
		     </td>
	   </tr>
  </table>
  </fieldset>
</form>
<form action="autentificacion/sc_Usuarios.php" method="post" name="mod_usuarios_II" id="mod_usuarios_II"> 
  <fieldset class="fieldset">
  <legend>Establecer Relacion Clientes O Trabajadores</legend>
     <table width="80%" align="center">

     <tr>
	     <td class="etiqueta" width="35%">Relacion:</td>
	     <td  id="select02" width="65%">		    
			   <select name="relacion" id="relacion" style="width:200px;" onchange="Actualizar01()">	 
     				   <option value="">Seleccione...</option>
					   <option value="Clientes">CLIENTES</option>
					   <option value="Trabajadores">TRABAJADORES</option>
	           </select><img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br />
       	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
    </tr>
	 	<tr> 
            <td height="8" colspan="2" align="center"><hr></td>
     </tr>	
	<tr>
		<td colspan="2" id="Filtro_R">&nbsp; </td>
	</tr>					 
	<tr>
		<td colspan="2" id="Contenedor_R">&nbsp; </td>
	</tr>				
	
	
	 	<tr> 
            <td height="8" colspan="2" align="center"><hr></td>
         </tr>	
         <tr> 
		     <td colspan="2" align="center">
      		<input  type="submit" name="salvar"  id="salvar01" value="Guardar" class="button1"
			                       onMouseOver="Fondos (this.id ,'A',  'button1Act', 'button1')" 
	                               onMouseOut="Fondos (this.id ,'D', 'button1Act', 'button1')">	&nbsp;
		    <input type="reset"     id="limpiar01"  value="Restablecer" class="button1"
			                       onMouseOver="Fondos (this.id ,'A',  'button1Act', 'button1')" 
	                               onMouseOut="Fondos (this.id ,'D', 'button1Act', 'button1')">	&nbsp;
		    <input type="button"   id="volver01"  value="Volver" onClick="history.back(-1);"  class="button1"
			                       onMouseOver="Fondos (this.id ,'A',  'button1Act', 'button1')" 
	                               onMouseOut="Fondos (this.id ,'D', 'button1Act', 'button1')">
		    <input name="cedula" id="cedula" type="hidden"  value="<?php echo $id;?>" />			
	        <input name="href" type="hidden" value="../inicio.php?area=autentificacion/Mod_Usuarios&Nmenu=<?php echo $_GET['Nmenu']?>&codigo=<?php echo $id?>"/>		   			
		     </td>
	   </tr>
  </table>
</fieldset>
</form>
</body>
</html>
<script type="text/javascript">
var input01  = new Spry.Widget.ValidationTextField("input01", "none", {minChars:4, validateOn:["blur", "change"]});
var input02  = new Spry.Widget.ValidationTextField("input02", "none", {minChars:4, validateOn:["blur", "change"]});
var input03  = new Spry.Widget.ValidationTextField("input03", "none", {minChars:4, validateOn:["blur", "change"]});
var input04  = new Spry.Widget.ValidationTextField("input04", "none", {minChars:4, validateOn:["blur", "change"]});
var input05  = new Spry.Widget.ValidationTextField("input05", "none", {minChars:4, validateOn:["blur"]});
var input06  = new Spry.Widget.ValidationTextField("input06", "none", {minChars:4, validateOn:["blur"]});
//var select01 = new Spry.Widget.ValidationSelect("select01", {validateOn:["blur", "change"]});
var select06 = new Spry.Widget.ValidationSelect("select01", {validateOn:["blur", "change"]});

var email    = new Spry.Widget.ValidationTextField("email", "email", {minChars:4, validateOn:["blur"]});
</script>