<link rel="stylesheet" type="text/css" href="latest/stylesheets/autocomplete.css" />
<script type="text/javascript" src="latest/scripts/autocomplete.js"></script>
<?php
$Nmenu   = 529;
$mod     =  $_GET['mod'];
$titulo  = " Reporte Referencia De ".$leng['trabajador']."";
$archivo = "reportes/rp_fic_referencia_det.php?Nmenu=$Nmenu&mod=$mod";
require_once('autentificacion/aut_verifica_menu.php');
require_once('sql/sql_report.php');
$bd = new DataBase();
?>
<script language="JavaScript" type="text/javascript">
function Add_filtroX(){  // CARGAR  ARCHIVO DE AJAX CON UN PARAMETRO //


	var estado      = $( "#estado").val();
	var ciudad      = $( "#ciudad").val();
	var cargo       = $( "#cargo").val();
	var status      = $( "#status").val();
	var trabajador  = $( "#stdID").val();

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

	if(error == 0){

		var parametros = {
			"estado" : estado,
			"ciudad" : ciudad,
			"cargo" : cargo,
			"status":status,
			"trabajador":trabajador,

			"fecha_desde" : fecha_desde,
			"fecha_hasta" : fecha_hasta,
			"Nmenu" : Nmenu,
			"mod" : mod,
			"archivo": archivo
		};
		$.ajax({
			data:  parametros,
			url:   'ajax_rp/Add_fic_referencia.php',
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
<div align="center" class="etiqueta_title"><?php echo $titulo;?></div>
<div id="Contenedor01"></div>
<form name="form_reportes" id="form_reportes" action="<?php echo $archivo;?>"  method="post" target="_blank">
	<hr /><table width="100%" class="etiqueta">
		<tr><td width="10%">Fecha Desde:</td>
			<td width="14%" id="fecha01"><input type="text" name="fecha_desde" id="fecha_desde" size="9" required onclick="javascript:muestraCalendario('form_reportes', 'fecha_desde');">&nbsp;<img src="imagenes/icono-calendario.gif" onclick="javascript:muestraCalendario('form_reportes', 'fecha_desde');" border="0" width="17px"></td>
			<td width="10%">Fecha Hasta:</td>
			<td width="14%" id="fecha02"><input type="text" name="fecha_hasta" id="fecha_hasta" size="9" required onclick="javascript:muestraCalendario('form_reportes', 'fecha_hasta');">&nbsp;<img src="imagenes/icono-calendario.gif" onclick="javascript:muestraCalendario('form_reportes', 'fecha_hasta');" border="0" width="17px"></td>

			<td width="15%">Cargo: </td>
			<td width="14%"><select name="cargo" id="cargo" style="width:120px;">
				<option value="TODOS">TODOS</option>
				<?php
				$query01 = $bd->consultar($sql_cargo);
				while($row01=$bd->obtener_fila($query01,0)){
					echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
				}?></select></td>

				<td>Status: </td>
						<td><select name="status" id="status" style="width:120px;">
							<option value="TODOS">TODOS</option>
							<?php
							$query01 = $bd->consultar($sql_preing_status);
							while($row01=$bd->obtener_fila($query01,0)){
								echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
							}?></select></td>
				<td width="4%" id="cont_img"><img class="imgLink" src="imagenes/actualizar.png" border="0" onclick="Add_filtroX()"></td>
			</tr>
			<tr>
				<td width="10%"><?php echo $leng['estado']?>:</td>
				<td width="14%"><select name="estado" id="estado" style="width:120px;">
					<option value="TODOS">TODOS</option>
					<?php $query01 = $bd->consultar($sql_estado);
					while($row01=$bd->obtener_fila($query01,0)){
						echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
					}?></select></td>
					<td width="10%"><?php echo $leng['ciudad']?>:</td>
					<td width="14%"><select name="ciudad" id="ciudad" style="width:120px;">
						<option value="TODOS">TODOS</option>
						<?php
						$query01 = $bd->consultar($sql_ciudad);
						while($row01=$bd->obtener_fila($query01,0)){
							echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
						}?></select></td>
						
						<td >Filtro <?php echo $leng['trab']?>.:</td>
							<td id="select01">
								<select id="paciFiltro" onchange="EstadoFiltro(this.value)" style="width:120px">
									<option value="TODOS"> TODOS</option>
									<option value="cedula"> <?php echo $leng['ci']?> </option>
									<option value="trabajador"><?php echo $leng['trabajador']?></option>
									<option value="nombres"> Nombre </option>
									<option value="apellidos"> Apellido </option>
								</select></td>
								<td><?php echo $leng['trabajador']?>:</td>
								<td colspan="3"><input  id="stdName" type="text" style="width:200px" disabled="disabled" />
									<input type="hidden" name="trabajador" id="stdID" value=""/></td>
									<td>&nbsp; <input type="hidden" name="Nmenu" id="Nmenu" value="<?php echo $Nmenu;?>" />
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
							<script type="text/javascript">
								filtroId = document.getElementById("paciFiltro");
								filtroIndice = filtroId.selectedIndex;
								filtroValue  = filtroId.options[filtroIndice].value;

								new Autocomplete("stdName", function() {
									this.setValue = function(id) {
            document.getElementById("stdID").value = id; // document.getElementsByName("stdID")[0].value = id;
        }
        if (this.isModified) this.setValue("");
        if (this.value.length < 1) return ;
        return "autocompletar/tb/ingreso.php?q="+this.text.value +"&filtro="+filtroValue+""});
    </script>
