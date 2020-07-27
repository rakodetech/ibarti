<script type="text/javascript" src="funciones/modal.js"></script>
<link href='libs/fullcalendar/lib/main.css' rel='stylesheet' />
<script src='libs/fullcalendar/lib/main.js'></script>
<script src='libs/fullcalendar/lib/locales/es.js'></script>
<?php 
$Nmenu   = '5304'; 
$mod     =  $_GET['mod'];
require_once('autentificacion/aut_verifica_menu.php');
require_once('sql/sql_report.php');
$bd = new DataBase(); 
$archivo = "reportes/rp_pl_trab_vs_contratacion_superv_det.php?Nmenu=$Nmenu&mod=$mod.php";	
$titulo  = " PLANIFICACION VS CONTRATACION DE SUPERVISORES ";

$titulo      = "REPORTE $titulo";
?>	

<div align="center" class="etiqueta_title"><?php echo $titulo;?> </div> 
<form name="form_reportes" id="form_reportes_planif" action="<?php echo $archivo;?>"  method="post" target="_blank">
	<hr />
	<table width="100%" align="center">
		<tr>
			<td width="10%" class="etiqueta">Fecha Desde:</td>
			<td width="14%" id="fecha01"><input type="text" name="fecha_desde" id="fecha_desde" style="width:85px" required onclick="javascript:muestraCalendario('form_reportes', 'fecha_desde');">&nbsp;<img src="imagenes/icono-calendario.gif" onclick="javascript:muestraCalendario('form_reportes', 'fecha_desde');" border="0" width="17px"></td>
			<td width="10%"  class="etiqueta">Fecha Hasta:</td>
			<td width="14%" id="fecha02"><input type="text" name="fecha_hasta" id="fecha_hasta" style="width:85px" required onclick="javascript:muestraCalendario('form_reportes', 'fecha_hasta');">&nbsp;<img src="imagenes/icono-calendario.gif" onclick="javascript:muestraCalendario('form_reportes', 'fecha_hasta');" border="0" width="17px"></td>
			<td  class="etiqueta"><?php echo $leng['cliente']?>:</td>
			<td><select name="cliente" id="cliente" style="width:120px;" onchange="Add_Cl_Ubic(this.value, 'contenido_ubic', 'T', '120')" required>

				<?php
				echo $select_cl;
				$query01 = $bd->consultar($sql_cliente);
				while($row01=$bd->obtener_fila($query01,0)){
					echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
				}?></select></td>
				<td  class="etiqueta"><?php echo $leng['ubicacion']?>: </td>
				<td id="contenido_ubic"><select name="ubicacion" id="ubicacion" style="width:120px;" required>
					<option value="TODOS">TODOS</option>
				</select></td>
                <td><img class="imgLink" src="imagenes/actualizar.png" alt="Ver Planificacion" title="Ver Planificacion" onclick="Add_filtroX()"></td>
			</tr>
			<tr>
				<td height="8" colspan="8" align="center"><hr></td>
			</tr>
		</table>
        <div id="calendar"></div>
		<div align="center"><br/>
			<span class="art-button-wrapper">
				<span class="art-button-l"> </span>
				<span class="art-button-r"> </span>
				<input type="button" name="salir" id="salir" value="Salir" onclick="Vinculo('inicio.php?area=formularios/index')" 
				class="readon art-button">
			</span>
			<input hidden="hidden" type="submit"> 
		</div>
	</form>
	<script type="text/javascript">
var calendar = null;
		function Add_filtroX(){
			var errorMessage = '';

			var cliente = $("#cliente").val();
			var ubicacion = $("#ubicacion").val();
			var fecha_desde = $("#fecha_desde").val();
			var fecha_hasta = $("#fecha_hasta").val();

			
			if( fechaValida(fecha_desde) !=  true || fechaValida(fecha_hasta) != true){
				var errorMessage = ' Campos De Fecha Incorrectas ';
				var error      = error+1;
			}else{
				var fecha1 = moment(fecha_desde,"DD-MM-YYYY");
				var fecha2 = moment(fecha_hasta,"DD-MM-YYYY");

				if(fecha2.diff(fecha1, 'days')>31){
					var errorMessage = ' El rango de fechas no puede ser mayor a 31 dias ';
					var error      = error+1;
				}
			}

			if(cliente == 'TODOS'){
				var errorMessage = errorMessage + '\n  Debe Seleccionar un Cliente ';
				var error = error+1;
			}

			if(ubicacion == 'TODOS'){
				var errorMessage = errorMessage + '\n  Debe Seleccionar una Ubicacion ';
				var error = error+1;
			}

			var parametros = {"cliente":cliente,"ubicacion" : ubicacion,"fecha_desde":fecha_desde,"fecha_hasta":fecha_hasta};
	if (calendar) {
		calendar.destroy();
    }
    
	$.ajax({
		data: parametros,
		url: 'packages/planif/planif_supervisor/views/Add_planif_det.php',
		type: 'post',
		beforeSend: function () {
			$("#cont_planif_det").html('<img src="imagenes/loading3.gif" border="null" class="imgLink" width="30px" height="30px">');
		},
		success: function (response) {
			var fechas = JSON.parse(response);
			var calendarEl = document.getElementById('calendar');
			calendar = new FullCalendar.Calendar(calendarEl, {
				initialView: 'dayGridMonth',
				headerToolbar: { center: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth' },
				views: {
					listMonth: {
						editable: false,
						eventContent: function (arg) {
							var result = "<label>En proceso<label>";
							if (arg.event.id) {
								result = "<div>(" + arg.event.extendedProps.codigo + ") " + moment(arg.event.start).format("HH: mm") + " - " + moment(arg.event.end).format("HH: mm") + '<br>';
								result += arg.event.title + "<br>";
								result += arg.event.extendedProps.ubicacion + "<br>";
								result += arg.event.extendedProps.proyecto + " (" + arg.event.extendedProps.abrev_proyecto + ")<br>";
								arg.event.extendedProps.actividades.forEach((act, i) => {
									result += "<span>" + (i + 1) + ": " + act.actividad + "</span><br>";
								});
							}
							result += "</div>";
							return {
								html: result
							}
						},
					},
					timeGridDay: {
						editable: false,
						slotDuration: '00:05:00',
						eventContent: function (arg) {
							var result = "<label>En proceso<label>";
							if (arg.event.id) {
								result = "<div>(" + arg.event.extendedProps.codigo + ") " + moment(arg.event.start).format("HH: mm") + " - " + moment(arg.event.end).format("HH: mm") + ' - ';
								result += arg.event.title + " ";
								result += arg.event.extendedProps.ubicacion + " - ";
								result += arg.event.extendedProps.proyecto + " (" + arg.event.extendedProps.abrev_proyecto + ") <br> ";
								arg.event.extendedProps.actividades.forEach((act, i) => {
									if (i == 0) {
										result += "<span> " + (i + 1) + ": " + act.actividad + "</span>";
									} else {
										result += ", <span> " + (i + 1) + ": " + act.actividad + "</span> ";
									}
								});
							}
							result += "</div>";
							return {
								html: result
							}
						},
					},
					dayGridMonth: { // name of view
						titleFormat: { year: 'numeric', month: '2-digit', day: '2-digit' },
						showNonCurrentDates: false,
						editable: false,
						selectable: true,
						eventContent: function (arg) {
							var result = "<label>En proceso</label>";
							if (arg.event.id) {
								result = "<div class='fc-event-main'>(" + arg.event.extendedProps.codigo + ") " + moment(arg.event.start).format("HH: mm") + " - " + moment(arg.event.end).format("HH: mm") + '<br>';
								result += arg.event.title + "<br>";
								result += arg.event.extendedProps.ubicacion + "<br>";
								result += arg.event.extendedProps.proyecto + " (" + arg.event.extendedProps.abrev_proyecto + ")<br>";
								arg.event.extendedProps.actividades.forEach((act, i) => {
									result += "<span>" + (i + 1) + ": " + act.actividad + "</span><br>";
								});
							}
							result += "</div>";
							return {
								html: result
							}
						},
					},
					timeGridWeek: {
						showNonCurrentDates: false,
						editable: false,
						selectable: true,
						eventContent: function (arg) {
							var result = "<label>En proceso</label>";
							if (arg.event.id) {
								result = "<div>(" + arg.event.extendedProps.codigo + ") " + moment(arg.event.start).format("HH: mm") + " - " + moment(arg.event.end).format("HH: mm") + " ";
								result += arg.event.title + " (" + arg.event.extendedProps.abrev_proyecto + ")";
							}
							result += "</div>";
							return {
								html: result
							}
						},
					},
				},
				eventDidMount: function (info) {
					eventActual = info.event;
				},
				initialDate: fechas.fecha_inicio,
				navLinks: true,
				dayMaxEvents: true,
				locale: 'es',
				validRange: {
					start: fechas.fecha_inicio,
					end: fechas.fecha_fin
				},
				allDaySlot: false,
				slotEventOverlap: true,
				dateClick: function (info) {
					//calendar.formatIso(info.date)
				},
				eventClick: function (arg) {
					eventActual = arg.event;
				},
				selectMirror: true,
				select: function (arg) {
					//("arg.start ", arg.start);
				},
				nowIndicator: true,
				height: 'auto',
				dayMaxEvents: true,
				dayHeaderFormat: { weekday: 'short' },
			});
			var res_eventos = d3.nest()
                .key((d) => d.cod_ubicacion)
                .key((d) => d.fecha_inicio_format)
                .entries(fechas);
            console.log(res_eventos);
			res_eventos.forEach(d => {
				calendar.addEvent({
					id: d.key,
					title: d.values[0].trabajador,
					start: d.values[0].fecha_inicio,
					end: d.values[0].fecha_fin,
					extendedProps: {
						codigo: d.key,
						cod_ficha: d.values[0].cod_ficha,
						cedula: d.values[0].cedula,
						trabajador: d.values[0].trabajador,
						proyecto: d.values[0].proyecto,
						cod_proyecto: d.values[0].cod_proyecto,
						abrev_proyecto: d.values[0].abrev_proyecto,
						actividades: d.values,
						cod_cliente: d.values[0].cod_cliente,
						cliente: d.values[0].cliente,
						ubicacion: d.values[0].ubicacion,
						cod_ubicacion: d.values[0].cod_ubicacion,
						completado: (d.values[0].completado === 'T')
					},
				});
			});

			calendar.render();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
		}
	});
}
		

		function rp_planif_serv_rp(tipo,id_tabla){
			$('#body_planif').val($('#'+id_tabla).html());
			$("#reporte_serv").val(tipo);
			$("#add_planif_serv_modal").submit();
		}
    </script>
