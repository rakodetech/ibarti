<?php
	$Nmenu   = '535';
    $mod     =  $_GET['mod'];
	require_once('sql/sql_report.php');
	require_once('autentificacion/aut_verifica_menu.php');

	$bd = new DataBase();

$titulo  = " Reporte Planificacion ".$leng['trabajador']." DL";
$archivo = "reportes/rp_pl_trabajador_dl_det.php?Nmenu=$Nmenu&mod=$mod";
?>
<script language="JavaScript" type="text/javascript">
function Add_filtroX(){  // CARGAR  ARCHIVO DE AJAX CON UN PARAMETRO //

	var rol         = document.getElementById("rol").value;
	var region      = document.getElementById("region").value;
	var estado      = document.getElementById("estado").value;
	var ciudad      = document.getElementById("ciudad").value;
    var cargo       = document.getElementById("cargo").value;
    var contrato    = document.getElementById("contrato").value;
    var cliente     = document.getElementById("cliente").value;
    var ubicacion   = document.getElementById("ubicacion").value;

	var error = 0;
    var errorMessage = ' ';

	if(error == 0){
		var contenido = "listar";

		ajax=nuevoAjax();
			ajax.open("POST", "ajax_rp/Add_pl_trabajador_dl.php", true);
			ajax.onreadystatechange=function(){
				if (ajax.readyState==1){
		        document.getElementById(contenido).innerHTML =  '<img src="imagenes/loading.gif" />';
				ajax.responseText;
				}
				if (ajax.readyState==4){
		        document.getElementById(contenido).innerHTML = ajax.responseText;
				}
			}
			ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			ajax.send("rol="+rol+"&region="+region+"&estado="+estado+"&ciudad="+ciudad+"&cargo="+cargo+"&contrato="+contrato+"&cliente="+cliente+"&ubicacion="+ubicacion+"");

	}else{
		 	alert(errorMessage);
	}
}
</script>
<div align="center" class="etiqueta_title"><?php echo $titulo;?> </div>
<div id="Contenedor01"></div>
<form name="form_reportes" id="form_reportes" action="<?php echo $archivo;?>"  method="post" target="_blank">
<hr />
	<table width="100%" class="etiqueta">
		<tr><td width="10%"><?php echo $leng['rol']?>:</td>
		 <td width="14%" id="fecha01"><select name="rol" id="rol" style="width:120px;">
					<option value="TODOS">TODOS</option>
					<?php
	   			$query01 = $bd->consultar($sql_rol);
		 		while($row01=$bd->obtener_fila($query01,0)){
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
			   }?></select></td>
        <td width="10%"><?php echo $leng['region']?>: </td>
		 <td width="14%" id="fecha02"><select name="region" id="region" style="width:120px;">
					<option value="TODOS">TODOS</option>
					<?php

	   			$query01 = $bd->consultar($sql_region);
		 		while($row01=$bd->obtener_fila($query01,0)){
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
			   }?></select></td>

            <td width="10%"><?php echo $leng['contrato']?>: </td>
			<td width="14%"><select name="contrato" id="contrato" style="width:120px;" >
					<option value="TODOS">TODOS</option>
					<?php
	   			$query01 = $bd->consultar($sql_contracto);
		 		while($row01=$bd->obtener_fila($query01,0)){
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
			   }?></select></td>

        <td width="24%"></td>
      <td width="4%" id="cont_img"><img class="imgLink" src="imagenes/actualizar.png" border="0" onclick="Add_filtroX()"></td>
     </tr>
     <tr>
 	 <td><?php echo $leng['estado']?>: </td>
			<td><select name="estado" id="estado" style="width:120px;" >
					<option value="TODOS">TODOS</option>
					<?php
	   			$query01 = $bd->consultar($sql_estado);
		 		while($row01=$bd->obtener_fila($query01,0)){
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
			   }?></select></td>
 	 <td><?php echo $leng['ciudad']?>: </td>
			<td><select name="ciudad" id="ciudad" style="width:120px;">
					<option value="TODOS">TODOS</option>
					<?php
	   			$query01 = $bd->consultar($sql_ciudad);
		 		while($row01=$bd->obtener_fila($query01,0)){
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
			   }?></select></td>
			<td><?php echo $leng['cliente']?>:</td>
			<td><select name="cliente" id="cliente" style="width:120px;" onchange="Add_Cl_Ubic(this.value, 'contenido_ubic', 'T', '120')">
					    <option value="TODOS">TODOS</option>
					<?php
	   			$query01 = $bd->consultar($sql_cliente);
		 		while($row01=$bd->obtener_fila($query01,0)){
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
			   }?></select></td>
			<td><?php echo $leng['ubicacion']?>: </td>
			<td id="contenido_ubic"><select name="ubicacion" id="ubicacion" style="width:120px;" >
					                        <option value="TODOS">TODOS</option>
                                    </select></td>
           <td>&nbsp;</td>
      </tr>
        <tr>
			<td>cargo: </td>
			<td><select name="cargo" id="cargo" style="width:120px;">
				   	<option value="TODOS">TODOS</option>
					<?php
		   			$query01 = $bd->consultar($sql_cargo);
		 		while($row01=$bd->obtener_fila($query01,0)){
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
			 	}
			   ?></select></td>
            <td>&nbsp; </td>
			<td>&nbsp;</td>
			<td>&nbsp;
             <input type="hidden" name="Nmenu" id="Nmenu" value="<?php echo $Nmenu;?>" />
            <input type="hidden" name="mod" id="mod" value="<?php echo $mod;?>" />   </td>
      </tr>
</table>
<hr />
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
</form>
