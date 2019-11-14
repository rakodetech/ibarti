<?php
	$Nmenu = '454';
	require_once('autentificacion/aut_verifica_menu.php');
	require_once('sql/sql_report.php');
	$bd = new DataBase();
	$archivo = "vc_calculo_cl_importe_det";
	$titulo  = " Calculo De ".$leng['cliente']." Importe ";
	$vinculo = "../inicio.php?area=formularios/Cons_$archivo&Nmenu=$Nmenu&mod=".$_GET['mod']."";
	$men     = "Nmenu=$Nmenu&mod=".$_GET['mod']."";
    $metodo  = "modificar";
	$proced  = "p_vc_cliente_importe";
	$titulo  = " $titulo ";
?>
<script language="JavaScript" type="text/javascript">

function Add_filtroX(){  // CARGAR  ARCHIVO DE AJAX CON UN PARAMETRO //

	var cliente     = $( "#cliente").val();
	var cargo       = $( "#cargo").val();
	var turno       = $( "#turno").val();

	var fecha_desde = $( "#fecha_desde").val();
	var fecha_hasta = $( "#fecha_hasta").val();
	var Nmenu       = $( "#Nmenu").val();
	var mod         = $( "#mod").val();
	var archivo     = $( "#archivo").val();

	var error = 0;
    var errorMessage = ' ';

	 if( fechaValida(fecha_desde) !=  true || fechaValida(fecha_hasta) != true){
    var errorMessage = ' Campos De Fecha Incorrectas ';
	 var error = error+1;
	}

	if( cliente == ""){
    var errorMessage = ' El Campo Cliente Es Requerido ';
	var error      = error+1;
	}
    if(error == 0){
	var contenido = "listar";
	  var parametros = {
						"cliente" : cliente,
						"cargo": cargo,
						"turno": turno,
						"fecha_desde": fecha_desde,
						"fecha_hasta": fecha_hasta,

						"Nmenu" : Nmenu,
						"mod" : mod,
						"archivo": archivo
				};
				$.ajax({
						data:  parametros,
						url:   'ajax_rp/Add_vc_calculo_cl_importe.php',
						type:  'post',
						beforeSend: function () {
							 $("#img_actualizar").remove();
							 $("#listar").html("<img src='imagenes/loading.gif' /> Procesando, espere por favor...");
							},
						success:  function (response) {
								$("#listar").html(response);
								$("#cont_img").html("<img class='imgLink' id='img_actualizar' src='imagenes/actualizar.png' border='0'                               onclick='Add_filtroX()'>");
						},

					error: function (xhr, ajaxOptions, thrownError) {
       				alert(xhr.status);
        			alert(thrownError);}

				});

		}else{
			alert(errorMessage);
		}
}
</script>
<div align="center" class="etiqueta_title"><?php echo $titulo;?> </div>
<div id="Contenedor01"></div><form name="form_reportes" id="form_reportes" action="reportes/rp_<?php echo $archivo;?>.php"
                                   method="post" target="_blank">
<fieldset>
<legend>Filtros:</legend>
	<table width="100%">
	 <tr><td width="13%">Fecha Desde:</td>
		 <td width="20%" id="fecha01"><input type="text" name="fecha_desde" id="fecha_desde" style="width:100px"  required onclick="javascript:muestraCalendario('form_reportes', 'fecha_desde');">&nbsp;<img src="imagenes/icono-calendario.gif" onclick="javascript:muestraCalendario('form_reportes', 'fecha_desde');" border="0" width="17px"></td>
         <td width="13%">Fecha Hasta:</td>
		 <td width="20%" id="fecha02"><input type="text" name="fecha_hasta" id="fecha_hasta" style="width:100px" required onclick="javascript:muestraCalendario('form_reportes', 'fecha_hasta');">&nbsp;<img src="imagenes/icono-calendario.gif" onclick="javascript:muestraCalendario('form_reportes', 'fecha_hasta');" border="0" width="17px"></td>
		

		 	 <td>Turno: </td>
		<td><select name="turno" id="turno" style="width:150px;">
					    <option value="TODOS">TODOS</option>
					<?php
	   			$query01 = $bd->consultar($sql_turno);
		 		while($row01=$bd->obtener_fila($query01,0)){
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
			   }?></select></td>

              <td width="4%" id="cont_img"><img class="imgLink" src="imagenes/actualizar.png" border="0" onclick="Add_filtroX()"></td>
      </tr>
        <tr>
 			<td><?php echo $leng['cliente'];?>: </td>
			<td><select name="cliente" id="cliente" style="width:150px;" required>
					<?php
                echo $select_cl;
	   			$query01 = $bd->consultar($sql_cliente);
		 		while($row01=$bd->obtener_fila($query01,0)){
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
			   }?></select></td>
		 <td>Cargo: </td>
			<td><select name="cargo" id="cargo" style="width:150px;">
					<option value="TODOS">TODOS</option>
					<?php
	   			$query01 = $bd->consultar($sql_cargo);
		 		while($row01=$bd->obtener_fila($query01,0)){
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
			   }?></select></td>
		
        <td>&nbsp;
            <input type="hidden" name="codigo" id="codigo" value="<?php echo $codigo;?>" />
            <input type="hidden" name="Nmenu" id="Nmenu" value="<?php echo $Nmenu;?>" />
            <input type="hidden" name="mod" id="mod" value="<?php echo $mod;?>" />
             <input type="hidden" name="archivo" id="archivo" value="<?php echo $archivo;?>" />
            <input type="hidden" name="metodo" id="metodo" value="<?php echo $metodo;?>" />
            <input type="hidden" name="proced" id="proced" value="<?php echo $proced;?>" />
            <input type="hidden" name="usuario" id="usuario" value="<?php echo $usuario;?>" />
            <input type="hidden" name="href" id="href" value="<?php echo $vinculo;?>"/></td>
      </tr>
</table></fieldset>
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
