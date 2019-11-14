<?php
$Nmenu   = '533';
$mod     =  $_GET['mod'];
require_once('autentificacion/aut_verifica_menu.php');
require_once('sql/sql_report.php');

if(isset($_SESSION['usuario_cod'])){
	require_once('autentificacion/aut_verifica_menu.php');
	$us = $_SESSION['usuario_cod'];
}else{
	$us = $_POST['usuario'];
}
$bd = new DataBase();
$archivo = "reportes/rp_pl_cliente_ubicacion_det.php?Nmenu=$Nmenu&mod=$mod";
$titulo  = " Planficacion De ".$leng['cliente']." ".$leng['ubicacion']."";
$titulo      = "REPORTE $titulo";
?>
<script type="text/javascript" src="libs/planificacionRP.js"></script>
<script language="JavaScript" type="text/javascript">

function Add_filtroX(){  // CARGAR  ARCHIVO DE AJAX CON UN PARAMETRO //

	var fecha_desde = document.getElementById("fecha_desde").value;
	var fecha_hasta = document.getElementById("fecha_hasta").value;
	var cliente     = document.getElementById("cliente").value;
	var ubicacion   = document.getElementById("ubicacion").value;
	var turno       = document.getElementById("turno").value;
	var cargo       = document.getElementById("cargo").value;
	var usuario       = document.getElementById("usuario").value;

	var error = 0;
	var errorMessage = ' ';
	if( fechaValida(fecha_desde) !=  true || fechaValida(fecha_hasta) != true){
		var errorMessage = ' Campos De Fecha Incorrectas ';
		var error = error+1;
	}

	if(error == 0){
		contenido='listar';
		var parametros = {"fecha_desde":fecha_desde,
		"fecha_hasta" : fecha_hasta,"cliente":cliente,"ubicacion":ubicacion,"turno":turno,"cargo":cargo,"usuario":usuario};

		$.ajax({
			data:  parametros,
			url:   'ajax_rp/Add_planif_servicio_contrato.php',
			type:  'post',
			beforeSend: function(){
				$("#"+contenido).html('<img src="imagenes/loading.gif" />');
			},
			success:  function (response) {
				$("#"+contenido).html(response);
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
<div id="Contenedor01"></div>
<form name="form_reportes" id="form_reportes" action="<?php echo $archivo;?>"  method="post" target="_blank">
	<hr />
	<table width="100%" class="etiqueta">
		<tr><td width="10%">Fecha Desde:</td>
			<td width="14%" id="fecha01"><input type="text" name="fecha_desde" id="fecha_desde" style="width:85px" required onclick="javascript:muestraCalendario('form_reportes', 'fecha_desde');">&nbsp;<img src="imagenes/icono-calendario.gif" onclick="javascript:muestraCalendario('form_reportes', 'fecha_desde');" border="0" width="17px"></td>
			<td width="10%">Fecha Hasta:</td>
			<td width="14%" id="fecha02"><input type="text" name="fecha_hasta" id="fecha_hasta" style="width:85px" required onclick="javascript:muestraCalendario('form_reportes', 'fecha_hasta');">&nbsp;<img src="imagenes/icono-calendario.gif" onclick="javascript:muestraCalendario('form_reportes', 'fecha_hasta');" border="0" width="17px"></td>
			<td width="10%">Cargo: </td>
			<td width="14%"><select name="cargo" id="cargo" style="width:120px;">
				<option value="TODOS">TODOS</option>
				<?php
				$query01 = $bd->consultar($sql_cargo);
				while($row01=$bd->obtener_fila($query01,0)){
					echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
				}?></select></td>

				<td>Turno: </td>
				<td><select name="turno" id="turno" style="width:120px;">
					<option value="TODOS">TODOS</option>
					<?php
					$query01 = $bd->consultar($sql_turno);
					while($row01=$bd->obtener_fila($query01,0)){
						echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
					}
					?></select></td>
					<td width="4%" id="cont_img"><img class="imgLink" src="imagenes/actualizar.png" border="0" onclick="Add_filtroX()"></td>
				</tr>
				<tr>
					<td><?php echo $leng['cliente']?>:</td>
					<td><select name="cliente" id="cliente" style="width:120px;" onchange="Add_Cl_Ubic(this.value, 'contenido_ubic', 'T', '120')" required>

						<?php
						echo $select_cl;
						$query01 = $bd->consultar($sql_cliente);
						while($row01=$bd->obtener_fila($query01,0)){
							echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
						}?></select></td>
						<td><?php echo $leng['ubicacion']?>: </td>
						<td id="contenido_ubic"><select name="ubicacion" id="ubicacion" style="width:120px;" required>
							<option value="TODOS">TODOS</option>
						</select></td>


						<td>&nbsp;
							<input type="hidden" name="Nmenu" id="Nmenu" value="<?php echo $Nmenu;?>" />
							<input type="hidden" name="mod" id="mod" value="<?php echo $mod;?>" />   
							<input type="hidden" name="usuario" id="usuario" value="<?php echo $us;?>" />
							<input type="hidden" name="body_reporte" id="body_reporte" value="" /></td>
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
