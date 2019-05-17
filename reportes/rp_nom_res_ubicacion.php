<?php 
$Nmenu   = 507; 
$mod     =  $_GET['mod'];
$titulo  = " REPORTE RESUMEN DE ASISTENCIA POR UBICACI&Oacute;N ";
$archivo = "reportes/rp_nom_res_ubicacion_det.php?Nmenu=$Nmenu&mod=$mod";
require_once('autentificacion/aut_verifica_menu.php');
require_once('sql/sql_report.php');
$bd = new DataBase();
?> 
<div align="center" class="etiqueta_title"> <?php echo $titulo;?></div> 
<br/>
<form name="form_reportes" id="form_reportes" action="<?php echo $archivo;?>" method="post" target="_blank">
  <table width="75%" border="0" align="center">
	<tr> 
       <td height="8" colspan="2" align="center"><hr></td>
    </tr>	 
    <tr>
      <td class="etiqueta" width="30%">Fecha Desde:</td>
      <td id="date01" width="70%">
      <input type="text" name="fecha_desde" id="fecha_desde" style="width:100px"  onclick="javascript:muestraCalendario('form_reportes', 'fecha_desde');">&nbsp;<img src="imagenes/icono-calendario.gif" onclick="javascript:muestraCalendario('form_reportes', 'fecha_desde');" border="0" width="17px"><br />
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br>
        <span class="textfieldRequiredMsg">El Campo Es Requerido.</span>
	  <span class="textfieldInvalidFormatMsg">Fromato Invalido.</span></td>
    </tr> 
    <tr>
      <td class="etiqueta">Fecha Hasta:</td>
      <td id="date02">
      <input type="text" name="fecha_hasta" id="fecha_hasta" style="width:100px"  onclick="javascript:muestraCalendario('form_reportes', 'fecha_hasta');">&nbsp;<img src="imagenes/icono-calendario.gif" onclick="javascript:muestraCalendario('form_reportes', 'fecha_hasta');" border="0" width="17px"><br />
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br>
        <span class="textfieldRequiredMsg">El Campo Es Requerido.</span>
	  <span class="textfieldInvalidFormatMsg">Fromato Invalido.</span></td>
  </tr> 
    <tr>
        <td class="etiqueta">Rol:</td>
		<td><select name="rol" style="width:250px;">	 
     		        <option value="TODOS"> TODOS</option>
		<?php $query02 = $bd->consultar($sql_rol);	
             while($row02=$bd->obtener_fila($query02,0)){						   
                   echo '<option value="'.$row02[0].'">'.$row02[1].'</option>';
             }?></select></td></tr>	 
    <tr>
        <td class="etiqueta">Region:</td>
		<td><select name="region" style="width:250px;">	 
     		        <option value="TODOS"> TODOS</option>
		<?php $query02 = $bd->consultar($sql_region);	
             while($row02=$bd->obtener_fila($query02,0)){						   
                   echo '<option value="'.$row02[0].'">'.$row02[1].'</option>';
             }?></select></td></tr>	
  	<tr>
        <td class="etiqueta">Estados</td>
		<td><select name="estado" style="width:250px;">	 
     		        <option value="TODOS"> TODOS</option>
		<?php $query02 = $bd->consultar($sql_estado);	
             while($row02=$bd->obtener_fila($query02,0)){						   
                   echo '<option value="'.$row02[0].'">'.$row02[1].'</option>';
             }?></select></td></tr>		
  	<tr>
        <td class="etiqueta">Ciudad:</td>
		<td><select name="ciudad" style="width:250px;">	 
     		        <option value="TODOS"> TODOS</option>
		<?php $query02 = $bd->consultar($sql_ciudad);	
             while($row02=$bd->obtener_fila($query02,0)){						   
                   echo '<option value="'.$row02[0].'">'.$row02[1].'</option>';
             }?></select></td></tr>		

         
     </tr>	 
	 <tr> 
       <td height="8" colspan="2" align="center"><hr></td>
    </tr> 
  </table>
	 <br />
     <div align="center">
           <input type="submit" name="procesar" id="procesar" hidden="hidden">
    <input type="text" name="reporte" id="reporte" hidden="hidden">
                  
    <img class="imgLink" id="img_pdf" src="imagenes/pdf.gif" border="0"
    onclick="{$('#reporte').val('pdf');$('#procesar').click();}" width="25px" title="imprimir a pdf">

    <img class="imgLink" id="img_excel" src="imagenes/excel.gif" border="0"
    onclick="{$('#reporte').val('excel');$('#procesar').click();}" width="25px" title="imprimir a excel">						   
            <input name="reset" type="reset" value="Restablecer"   class="button1"
			                       onMouseOver="Fondos (this.id ,'A',  'button1Act', 'button1')" 
	                               onMouseOut="Fondos (this.id ,'D', 'button1Act', 'button1')"/>&nbsp;
			<input name="usuario" type="hidden"  value="<?php echo $usuario;?>"/>
		</div>
</form>	
<br />
<br />
<div align="center">  
</div>