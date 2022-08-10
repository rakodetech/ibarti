<script language="JavaScript" type="text/javascript">
function Add_filtroM(codigo){  // CARGAR  ARCHIVO DE AJAX CON UN PARAMETRO //

	var error = 0; 
    var errorMessage = ' ';
 if(error == 0){
	var contenido = "memuX";
	ajax=nuevoAjax();
			ajax.open("POST", "autentificacion/aj_menu_menu.php", true);
			ajax.onreadystatechange=function(){ 
				if (ajax.readyState==4){
		        document.getElementById(contenido).innerHTML = ajax.responseText;					
				}
			} 
			ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			ajax.send("codigo="+codigo+"");	
	
	}else{
	 	 alert(errorMessage);
	}	
}

function Add_filtroX(){  // CARGAR  ARCHIVO DE AJAX CON UN PARAMETRO//
	var codigo      = document.getElementById("codigo").value; 
	var menu        = document.getElementById("menu").value; 
	var modulo      = document.getElementById("modulo").value;		
	var error = 0; 
    var errorMessage = ' ';

	if( modulo == ""){
    var errorMessage = errorMessage + ' \n El Campo Modulo Es Requerido ';
	var error      = error+1; 		 
	}	
	
	if( menu == ""){
    var errorMessage = errorMessage + ' \n El Campo Menu Es Requerido ';
	var error      = error+1; 		 
	}	

 if(error == 0){
	var contenido = "listar";
	ajax=nuevoAjax();
			ajax.open("POST", "autentificacion/aj_menu_perfil.php", true);
			ajax.onreadystatechange=function(){ 
				if (ajax.readyState==4){
		        document.getElementById(contenido).innerHTML = ajax.responseText;					
				}
			} 
			ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			ajax.send("codigo="+codigo+"&menu="+menu+"&modulo="+modulo+"");	
	
	}else{
	 	 alert(errorMessage);
	}	
}

</script>	
<?php
	$metodo = "modificar_perfil";
	$mod   = $_GET['mod'];
	$Nmenu = $_GET['Nmenu'];
	$cod_perfil = $_GET['codigo']; 
	$vinculo = "../inicio.php?area=autentificacion/Mod_Menu_Perfil&Nmenu=$Nmenu&mod=$mod&codigo=$cod_perfil";
	$titulo = " PERFILES ";

	$sql     = " SELECT descripcion FROM men_perfiles WHERE codigo = '$cod_perfil'";
   	$query01 = $bd->consultar($sql);
	$row01   = $bd->obtener_fila($query01,0);		
	$perfil  = $row01[0]; 

?><div align="center" class="etiqueta_title"> CONSULTA <?php echo $titulo;?> </div>
<div id="Contenedor01"></div><form action="autentificacion/sc_Menu_Perfil.php" method="post" name="mod"> 
 <fieldset>
<legend>Filtros:</legend><table width="100%">
		<tr><td width="12%">PERFIL</td>
		    <td width="20%"><select name="codigo" id="codigo" style="width:150px">
				<option value="<?php echo $cod_perfil;?>"><?php echo $perfil;?></option>
 		<?php
		$sql = " SELECT men_perfiles.codigo, men_perfiles.descripcion FROM men_perfiles
		          WHERE men_perfiles.`status` = 'T' 
				    AND men_perfiles.codigo <> '$cod_perfil'
				  ORDER BY 2 ASC ";
    	$query01 = $bd->consultar($sql);
		while($row01=$bd->obtener_fila($query01,0)){ 
		 ?>
          <option value="<?php echo $row01[0];?>"><?php echo $row01[1];?></option>
          <?php }?>		  	  
        </select></td>   
            <td width="12%">MODULO</td>
		    <td width="20%"><select name="modulo" id="modulo" style="width:150px" onchange="Add_filtroM(this.value)">
				<option value="">SELECCIONE...</option>
 <?php
		$sql = " SELECT codigo, descripcion FROM men_modulos WHERE status = 'T' ORDER BY 2 ASC ";
    	$query01 = $bd->consultar($sql);
			while($row01=$bd->obtener_fila($query01,0)){ 
		 ?>
          <option value="<?php echo $row01[0];?>"><?php echo $row01[1];?></option>
          <?php }?>		  	  
        </select></td>    
            <td width="12%">MENU</td>
		    <td width="20%" id="memuX"><select name="menu" id="menu" style="width:150px" onchange="Add_filtroX()" disabled="disabled">
				<option value="">SELECCIONE...</option>
 <?php
		$sql = " SELECT codigo, descripcion FROM men_modulos WHERE status = 'T' ORDER BY 2 ASC ";
    	$query01 = $bd->consultar($sql);
			while($row01=$bd->obtener_fila($query01,0)){ 
		 ?>
          <option value="<?php echo $row01[0];?>"><?php echo $row01[1];?></option>
          <?php }?>		  	  
        </select></td>            
               <td width="4%"><img class="imgLink" id="img_actualizar" src="imagenes/actualizar.png" border="0" 
                                   onclick=" Add_filtroX()"></td>       
        </tr>
        </table>   
          </fieldset>
        <hr>
    	<div id="listar">
        </div>     

	 <br />
     <div align="center">
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
                </span>		    <input name="metodo" type="hidden"  value="<?php echo $metodo;?>"/>
	        <input name="href" type="hidden" value="<?php echo $vinculo;?>"/>
            <input name="usuario" type="hidden" value="<?php echo $usuario;?>"/>		   
            <input name="descripcion" type="hidden" value=""/>
            <input name="orden" type="hidden" value=""/>
            <input name="status" type="hidden" value=""/>           		
	  </div>
</form>	