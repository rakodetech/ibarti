<?php
	$Nmenu   = '572';
    $mod     =  $_GET['mod'];
	require_once('autentificacion/aut_verifica_menu.php');
	require_once('sql/sql_report.php');
	$bd = new DataBase();
	$archivo = "reportes/rp_inv_control_movimiento_det.php?Nmenu=$Nmenu&mod=$mod";
	$titulo  = " REPORTE MOVIMIENTO DE INVENTARIO ";
?>
<script language="JavaScript" type="text/javascript">

function Add_filtroX(){  // CARGAR  ARCHIVO DE AJAX CON UN PARAMETRO //

	var fecha_desde = document.getElementById("fecha_desde").value;
	var fecha_hasta = document.getElementById("fecha_hasta").value;
	var tipo_mov    = document.getElementById("tipo_mov").value;
	var producto    = document.getElementById("producto").value;
	var linea       = document.getElementById("linea").value;
    var sub_linea   = document.getElementById("sub_linea").value;
    var cliente     = document.getElementById("cliente").value;
    var ubicacion   = document.getElementById("ubicacion").value;
 //   var anulado     = document.getElementById("anulado").value;

	var error = 0;
    var errorMessage = ' ';
	 if( fechaValida(fecha_desde) !=  true || fechaValida(fecha_hasta) != true){
    var errorMessage = ' Campos De Fecha Incorrectas ';
	 var error = error+1;
	}
     if(cliente == '') {
	 var error = error+1;
	  errorMessage = errorMessage + ' \n Debe Seleccionar un cliente ';
	}

	if(error == 0){
		var contenido = "listar";

		ajax=nuevoAjax();
			ajax.open("POST", "ajax_rp/Add_inv_control_movimiento.php", true);
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
			ajax.send("linea="+linea+"&sub_linea="+sub_linea+"&producto="+producto+"&tipo_mov="+tipo_mov+"&cliente="+cliente+"&ubicacion="+ubicacion+"&fecha_desde="+fecha_desde+"&fecha_hasta="+fecha_hasta+"");

	}else{
		 	alert(errorMessage);
	}
}
</script>
<div align="center" class="etiqueta_title"><?php echo $titulo;?> </div>
<div id="Contenedor01"></div>
<form name="form_reportes" id="form_reportes" action="<?php echo $archivo;?>"  method="post" target="_blank">
<hr /><table width="100%" class="etiqueta">
		<tr><td width="10%">Fecha Desde:</td>
		 <td width="14%" id="fecha01"><input type="text" name="fecha_desde" id="fecha_desde" size="9" required  onclick="javascript:muestraCalendario('form_reportes', 'fecha_desde');">&nbsp;<img src="imagenes/icono-calendario.gif" onclick="javascript:muestraCalendario('form_reportes', 'fecha_desde');" border="0" width="17px"></td>
        <td width="10%">Fecha Hasta:</td>
		<td width="14%" id="fecha02"><input type="text" name="fecha_hasta" id="fecha_hasta" size="9"  required onclick="javascript:muestraCalendario('form_reportes', 'fecha_hasta');">&nbsp;<img src="imagenes/icono-calendario.gif" onclick="javascript:muestraCalendario('form_reportes', 'fecha_hasta');" border="0" width="17px"></td>
		<td width="10%">Tipo Mov.: </td>
		<td width="14%"><select name="tipo_mov" id="tipo_mov" style="width:120px;">
					            <option value="TODOS">TODOS</option>
					<?php
	   			$query01 = $bd->consultar($sql_tipo_mov);
		 		while($row01=$bd->obtener_fila($query01,0)){
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
			   }?></select></td>
        <td>Producto: </td>
			<td><select name="producto" id="producto" style="width:120px;">
				   	<option value="TODOS">TODOS</option>
					<?php
	   			$query01 = $bd->consultar($sql_producto);
		 		while($row01=$bd->obtener_fila($query01,0)){
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
			 	}
			   ?></select></td>
      <td width="4%" id="cont_img"><img class="imgLink" src="imagenes/actualizar.png" border="0" onclick="Add_filtroX()"></td>
        </tr>
        <tr>
            <td>Linea: </td>
			<td><select name="linea" id="linea" style="width:120px;"
                       onchange="Add_Sub_Linea(this.value, 'contenido_sub_linea', 'T', '120')">
					<option value="TODOS">TODOS</option>
					<?php
	   			$query01 = $bd->consultar($sql_linea);
		 		while($row01=$bd->obtener_fila($query01,0)){
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
			   }?></select></td>
            <td>Sub Linea:</td>
			<td id="contenido_sub_linea"><select name="sub_linea" id="sub_linea" style="width:120px;" >
					<option value="TODOS">TODOS</option>
					<?php
	   			$query01 = $bd->consultar($sql_sub_lineas);
		 		while($row01=$bd->obtener_fila($query01,0)){
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
			   }?></select></td>
             <td><?php echo $leng['cliente']?>: </td>
			<td><select name="cliente" id="cliente" style="width:120px;" required>
					<?php
					echo $select_cl;
	   			$query01 = $bd->consultar($sql_cliente);
		 		while($row01=$bd->obtener_fila($query01,0)){
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
			   }?></select></td>
            <td><?php echo $leng['ubicacion']?>:</td>
			<td><select name="ubicacion" id="ubicacion" style="width:120px;">
					<option value="TODOS">TODOS</option>
					<?php
	   			$query01 = $bd->consultar($sql_ubicacion);
		 		while($row01=$bd->obtener_fila($query01,0)){
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
			   }?></select></td>

			<td>&nbsp;</td>
      </tr>
        <tr>
		 

            <td>Anulado:</td>
			<td><select name="anulado" id="anulado" style="width:120px;">
					<option value="TODOS">TODOS</option>
       				<option value="T">SI</option>
                    <option value="F">NO</option>

</select></td>
			<td>&nbsp;
             <input type="hidden" name="Nmenu" id="Nmenu" value="<?php echo $Nmenu;?>" />
            <input type="hidden" name="mod" id="mod" value="<?php echo $mod;?>" />   </td>
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
</form>
