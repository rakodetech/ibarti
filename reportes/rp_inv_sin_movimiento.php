<?php 
$Nmenu   = 573; 
$mod     =  $_GET['mod'];
$titulo  = " REPORTE MOVIMIENTO DE INVENTARIO ";
$archivo = "reportes/rp_inv_sin_movimiento_det.php?Nmenu=$Nmenu&mod=$mod";
require_once('autentificacion/aut_verifica_menu.php');
require_once('funciones/funciones.php');
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
        <td class="etiqueta">Linea:</td>
		<td><select name="linea" style="width:250px;">	 
     		        <option value="TODOS"> TODOS</option>
		<?php $query02 = $bd->consultar($sql_linea);	
             while($row02=$bd->obtener_fila($query02,0)){						   
                   echo '<option value="'.$row02[0].'">'.$row02[1].' '.$row02[2].'</option>';
             }?></select></td></tr>	               
     
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

             <span class="art-button-wrapper">
                    <span class="art-button-l"> </span>
                    <span class="art-button-r"> </span>
                <input type="reset" id="limpiar" value="Restablecer" class="readon art-button" />	
                </span>
 			    <input name="usuario" type="hidden"  value="<?php echo $usuario;?>"/>
		</div>
</form>	
<br />