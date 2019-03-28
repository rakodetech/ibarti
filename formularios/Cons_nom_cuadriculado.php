<?php 
$Nmenu = '413';
require_once('autentificacion/aut_verifica_menu.php');
require_once('sql/sql_report.php');
$titulo = " GENERAR CUADRICULADO ";
	$bd = new DataBase();
$archivo = "nom_cuadriculado";
$archivo2 = "../inicio.php?area=formularios/Cons_$archivo&Nmenu=$Nmenu&mod=".$_GET['mod'].""; 
$proced = "p_nom_cuadriculado"; 
$metodo = "modificar";?> 
<div align="center" class="etiqueta_title"> <?php echo $titulo;?></div> 
<br/>
<form name="form_reportes" id="form_reportes" action="scripts/sc_<?php echo $archivo;?>.php" method="post">
  <table width="75%" border="0" align="center">
	<tr> 
       <td height="8" colspan="2" align="center"><hr></td>
    </tr>	 
    <tr>
      <td class="etiqueta" width="30%">Fecha:</td>
      <td id="date01" width="70%">
      <input type="text" name="fecha_desde" id="fecha_desde" style="width:100px"  onclick="javascript:muestraCalendario('form_reportes', 'fecha_desde');">&nbsp;<img src="imagenes/icono-calendario.gif" onclick="javascript:muestraCalendario('form_reportes', 'fecha_desde');" border="0" width="17px"><br />
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br>
        <span class="textfieldRequiredMsg">El Campo Es Requerido.</span>
	  <span class="textfieldInvalidFormatMsg">Fromato Invalido.</span></td>
    </tr> 
    <tr>
        <td class="etiqueta">Quincena:</td>
		<td id="select01"><select name="quincena" style="width:250px;">						   
                    <option value="">Seleccione...</option>
                    <option value="01">Primera Quincena</option>
                    <option value="02">Segunda Quincena</option>
            </select><br /><span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td></tr>	    

	 <tr> 
       <td height="8" colspan="2" align="center"><hr></td>
    </tr> 
  </table>
	 <br />
     <div align="center">
     <span class="art-button-wrapper">
                    <span class="art-button-l"> </span>
                    <span class="art-button-r"> </span>
                <input type="submit" name="salvar"  id="salvar" value="Procesar" class="readon art-button" />	
                </span>&nbsp;
             <span class="art-button-wrapper">
                    <span class="art-button-l"> </span>
                    <span class="art-button-r"> </span>
                <input type="reset" id="limpiar" value="Restablecer" class="readon art-button" />	
                </span>
		    <input name="metodo" type="hidden"  value="<?php echo $metodo;?>" />
            <input name="proced" id="proced" type="hidden"  value="<?php echo $proced;?>" /> 
		    <input name="usuario" type="hidden"  value="<?php echo $usuario;?>" />
 	        <input name="href" type="hidden" value="<?php echo $archivo2;?>"/>	   			
		</div>
</form>	
<br />
<br />
<div align="center">  
</div>
<script type="text/javascript">
	var input01 = new Spry.Widget.ValidationTextField("date01", "none", {minChars:4, validateOn:["blur", "change"]});
	
//	var fecha01 = new Spry.Widget.ValidationTextField("fecha01", "date", {format:"dd-mm-yyyy", hint:"DD-MM-AAAA", 
//		validateOn:["blur", "change"], useCharacterMasking:true});		
	var select01 = new Spry.Widget.ValidationSelect("select01", {validateOn:["blur", "change"]});
</script>
