<?php
$Nmenu   = 547;
$mod     =  $_GET['mod'];
$titulo  = " Reporte ".$leng['concepto']." Detalle ";
$archivo = "reportes/rp_nom_concepto_detalle_det.php?Nmenu=$Nmenu&mod=$mod";
require_once('autentificacion/aut_verifica_menu.php');
require_once('sql/sql_report.php');
$bd = new DataBase();

?>
<script language="JavaScript" type="text/javascript">

function Add_filtroX(){  // CARGAR  ARCHIVO DE AJAX CON UN PARAMETRO //
	var concepto      = document.getElementById("concepto").value;
    var categoria      = document.getElementById("categoria").value;
    var rol       = document.getElementById("rol").value;
    var status      = document.getElementById("status").value;

	var error = 0;
    var errorMessage = ' ';

     if(rol == '') {
	 var error = error+1;
	  errorMessage = errorMessage + ' \n Debe Seleccionar un Rol ';
	}


	if(error == 0){
		var contenido = "listar";
		ajax=nuevoAjax();
			ajax.open("POST", "ajax_rp/Add_nom_concepto_detalle.php", true);
			ajax.onreadystatechange=function(){
				 if (ajax.readyState==1 || ajax.readyState==2 || ajax.readyState==3){
				  document.getElementById(contenido).innerHTML = '<img src="imagenes/loading.gif" />';
				  document.getElementById("cont_img").innerHTML =
				  '<img src="imagenes/loading.gif" onclick="" class="imgLink" />';
				}
				if (ajax.readyState==4){
		     	  document.getElementById(contenido).innerHTML = ajax.responseText;
				   document.getElementById("cont_img").innerHTML =
				  '<img class="imgLink" src="imagenes/actualizar.png" border="0" onclick="Add_filtroX()">';
				}
			}
			ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			ajax.send("concepto="+concepto+"&categoria="+categoria+"&rol="+rol+"&status="+status+"");

	}else{
 		alert(errorMessage);
	}
}
</script>
<div align="center" class="etiqueta_title"><?php echo $titulo;?></div>
<div id="Contenedor01"></div>
<form name="form_reportes" id="form_reportes" action="<?php echo $archivo;?>"  method="post" target="_blank">
<hr /><table width="100%" class="etiqueta">
		<tr><td width="10%"><?php echo $leng['concepto']?>:</td>
		 <td width="14%"><select name="concepto" id="concepto" style="width:120px;">
     		        <option value="TODOS"> TODOS</option>
		<?php $query02 = $bd->consultar($sql_concepto);
             while($row02=$bd->obtener_fila($query02,0)){
                   echo '<option value="'.$row02[0].'">'.$row02[1].'</option>';
             }?></select></td>
        <td width="10%"><?php echo $leng['concepto']?> Categoria:</td>
		 <td width="14%"><select name="categoria" id="categoria" style="width:120px;">
					<option value="TODOS">TODOS</option>
					<?php
	   			$query01 = $bd->consultar($sql_concepto_categoria);
		 		while($row01=$bd->obtener_fila($query01,0)){
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
			   }?></select></td>

        <td width="10%"><?php echo $leng['rol']?>: </td>
		 <td width="14%" ><select name="rol" id="rol" style="width:120px;" required>
					<?php
					echo $select_rol;
		   			$query01 = $bd->consultar($sql_rol);
		 		while($row01=$bd->obtener_fila($query01,0)){
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
			   }?></select></td>

        <td width="10%">Status: </td>
			<td width="14%"><select name="status" id="status"  style="width:120px;">
     		        <option value="TODOS"> TODOS</option>
                    <option value="T"> ACTIVO </option>
                    <option value="F"> INACTIVO</option>
            </select></td>
      <td width="4%" id="cont_img"><img class="imgLink" src="imagenes/actualizar.png" border="0" onclick="Add_filtroX()"></td>
        </tr>
       
</table><hr />
<div id="listar">&nbsp;</div>
<div align="center"><br/>
        <span class="art-button-wrapper">
            <span class="art-button-l"> </span>
            <span class="art-button-r"> </span>
        <input type="button" name="salir" id="salir" value="Salir" onclick="Vinculo('inicio.php?area=formularios/index')"
               class="readon art-button">
        </span>&nbsp;
		

        <input type="submit" name="procesar" id="procesar" hidden="hidden">
    <input type="text" name="reporte" id="reporte" hidden="hidden">
                  
    <img class="imgLink" id="img_pdf" src="imagenes/pdf.gif" border="0"
    onclick="{$('#reporte').val('pdf');$('#procesar').click();}" width="25px" title="imprimir a pdf">

    <img class="imgLink" id="img_excel" src="imagenes/excel.gif" border="0"
    onclick="{$('#reporte').val('excel');$('#procesar').click();}" width="25px" title="imprimir a excel">
</div>
