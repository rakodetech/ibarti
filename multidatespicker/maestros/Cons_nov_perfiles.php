<?php 
$Nmenu    =  341;
$metodo   = "actualizar";
$titulo   = "NOVEDADES Y PERFILES";
$archivo  = "nov_perfiles";
require_once('autentificacion/aut_verifica_menu.php');
$archivo2 = "../inicio.php?area=maestros/Cons_$archivo&Nmenu=$Nmenu&mod=".$_GET['mod'].""; 
$bd = new DataBase();
?>
<form action="sc_maestros/sc_<?php echo $archivo;?>.php" method="post" name="add" id="add"> 
  <fieldset class="fieldset">
  <legend><?php echo $titulo;?></legend>
     <table width="80%" align="center">  
   <tr>
      <td class="etiqueta">NOVEDADES CLASIFICACION:</td>
      	<td id="select01"><select id="codigo" name="codigo" style="width:220px" 
                       onchange="Add_ajax01(this.value,'ajax/nov_perfiles.php', 'Contenedor')">
							      <option value="">Seleccione...</option>
          <?php         	  	  		  
			$sql = "SELECT nov_clasif.codigo, nov_clasif.descripcion
                      FROM nov_clasif WHERE nov_clasif.`status` = 'T'";
		   $query = $bd->consultar($sql);
		
		while($datos=$bd->obtener_fila($query,0)){					   					
		  ?>
          <option value="<?php echo $datos[0];?>"><?php echo $datos[1];?></option>
          <?php }?>		  	  
        </select>
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br />
        	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
	</tr>
	 	<tr> 
            <td height="8" colspan="2" align="center"><hr></td>
     </tr>	
	<tr>
		<td colspan="2" id="Contenedor">&nbsp; </td>
	</tr>				
	 	<tr> 
            <td height="8" colspan="2" align="center"><hr></td>
         </tr>	
  </table>
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
                </span>  

		    <input name="metodo" id="metodo" type="hidden"  value="<?php echo $metodo;?>" />
            <input name="tabla" id="tabla" type="hidden"  value="<?php echo $tabla;?>" />            
            <input name="usuario" id="usuario" type="hidden"  value="<?php echo $usuario;?>" />            
	        <input name="href" type="hidden" value="<?php echo $archivo2;?>"/>		   		  
  </div>
</fieldset>
</form>
</body>
</html>