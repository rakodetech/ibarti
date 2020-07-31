<link rel="stylesheet" type="text/css" href="latest/stylesheets/autocomplete.css" />
<script type="text/javascript" src="latest/scripts/autocomplete.js"></script>
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
$titulo  = " CALENDARIO DE PLANIFICACION DE SUPERVISORES ";

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
			<td class="etiqueta">Filtro Trab.:</td>	
		<td id="select01">
			<select id="paciFiltro" onchange="EstadoFiltro(this.value)" style="width:120px">
				<option value="TODOS"> TODOS</option>
				<option value="codigo"> C&oacute;digo </option>
				<option value="cedula"> C&eacute;dula </option>
				<option value="trabajador"> Trabajador </option>
                <option value="nombres"> Nombre </option>
                <option value="apellidos"> Apellido </option>                
		</select></td>
          <td class="etiqueta">Trabajador:</td> 
      <td colspan="4" ><input  id="stdName" type="text" style="width:220px" disabled="disabled" />
	      <input type="hidden" name="trabajador" id="stdID" value=""/>
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
function Add_filtroX() {
		var errorMessage = '';
		var error = 0;
		var cliente = $("#cliente").val();
		var ubicacion = $("#ubicacion").val();
		var fecha_desde = $("#fecha_desde").val();
		var fecha_hasta = $("#fecha_hasta").val();
		var ficha  = $( "#stdID").val(); 

		if (fechaValida(fecha_desde) != true || fechaValida(fecha_hasta) != true) {
			var errorMessage = ' Campos De Fecha Incorrectas ';
			var error = error + 1;
		}

		if(error < 1){
			var parametros = { "cliente": cliente, "ubicacion": ubicacion, "fecha_desde": fecha_desde, "fecha_hasta": fecha_hasta, "ficha": ficha };
			if (calendar) {
				calendar.destroy();
			}
			$.ajax({
				data: parametros,
				url: 'packages/planif/planif_supervisor/views/Add_planif_det.php',
				type: 'post',
				beforeSend: function () {
					$("#calendar").html('<img src="imagenes/loading3.gif" border="null" class="imgLink" width="30px" height="30px">');
				},
				success: function (response) {
					$("#calendar").html("");
					var resp = JSON.parse(response);
					var fechas = resp["fechas"];
					var calendarEl = document.getElementById('calendar');
					calendar = new FullCalendar.Calendar(calendarEl, {
						initialView: "listMonth",
						headerToolbar: { center: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth' },
						views: {
							listMonth: {
								editable: false,
								eventContent: function (arg) {
									var result = "<label>En proceso</label>";
									if (arg.event.id) {
										result = "<div>(" + arg.event.extendedProps.codigo + ") " + moment(arg.event.start).format("HH: mm") + " - " + moment(arg.event.end).format("HH: mm") + '<br>';
										result += "<label>" + arg.event.title + "</label><br>";
										result += arg.event.extendedProps.cliente +" - " + arg.event.extendedProps.ubicacion + "<br>";
										var codigo_proyecto = arg.event.extendedProps.actividades[0].cod_proyecto;
										var index = 1;
										arg.event.extendedProps.actividades.forEach((act, i) => {
											if ((i != 0) && (act.cod_proyecto != codigo_proyecto)) {
												index = 1;
												codigo_proyecto = act.cod_proyecto;
												result += "<label>" + act.proyecto + " (" + act.abrev_proyecto + ")</label><br>";
											} else if (i == 0) {
												result += "<label>" + act.proyecto + " (" + act.abrev_proyecto + ")</label><br>";
											}
											result += "<span>" + index + ": " + act.actividad + "  (" + moment(act.fecha_inicio_act).format('HH:mm:ss') + " - " + moment(act.fecha_fin_act).format('HH:mm:ss') + ") </span><br>";
											index++;
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
									var result = "<label>En proceso</label>";
									if (arg.event.id) {
										result = "<div>(" + arg.event.extendedProps.codigo + ") " + moment(arg.event.start).format("HH: mm") + " - " + moment(arg.event.end).format("HH: mm") + ' - ';
										result += "<label>" + arg.event.title + "</label> <br>";
										result += arg.event.extendedProps.cliente +" - " +  arg.event.extendedProps.ubicacion + " <br> ";
										var codigo_proyecto = arg.event.extendedProps.actividades[0].cod_proyecto;
										var index = 1;
										arg.event.extendedProps.actividades.forEach((act, i) => {
											if ((i != 0) && (act.cod_proyecto != codigo_proyecto)) {
												index = 1;
												codigo_proyecto = act.cod_proyecto;
												result += "<label>" + act.proyecto + " (" + act.abrev_proyecto + ")</label><br>";
											} else if (i == 0) {
												result += "<label>" + act.proyecto + " (" + act.abrev_proyecto + ")</label><br>";
											}
											result += "<span>" + index + ": " + act.actividad + "</span><br>";
											index++;
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
										result += "<label>" + arg.event.title + "</label><br>";
										result += arg.event.extendedProps.cliente +" - " +arg.event.extendedProps.ubicacion + "<br>";
										var codigo_proyecto = arg.event.extendedProps.actividades[0].cod_proyecto;
										var index = 1;
										arg.event.extendedProps.actividades.forEach((act, i) => {
											if ((i != 0) && (act.cod_proyecto != codigo_proyecto)) {
												index = 1;
												codigo_proyecto = act.cod_proyecto;
												result += "<label>" + act.proyecto + " (" + act.abrev_proyecto + ")</label><br>";
											} else if (i == 0) {
												result += "<label>" + act.proyecto + " (" + act.abrev_proyecto + ")</label><br>";
											}
											result += "<span>" + index + ": " + act.actividad + "</span><br>";
											index++;
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
										result = "<div>(" + arg.event.extendedProps.codigo + ") " + arg.event.extendedProps.cliente +" - " + arg.event.extendedProps.ubicacion + " ";
										result += "<label>" + arg.event.title + "</label>"
									}
									result += "</div>";
									return {
										html: result
									}
								},
							},
						},
						initialDate: fechas.fecha_inicio,
						navLinks: true,
						dayMaxEvents: true,
						locale: 'es',
						validRange: {
							start: fechas.fecha_inicio,
							end: moment(fechas.fecha_fin).add(1, 'days').format('YYYY-MM-DD')
						},
						allDaySlot: false,
						slotEventOverlap: true,
						selectMirror: true,
						nowIndicator: true,
						height: 'auto',

						dayMaxEvents: true,
						dayHeaderFormat: { weekday: 'short' },
					});
					res_eventos = d3.nest()
						.key((d) => d.codigo)
						.entries(resp["data"]);
					res_eventos.forEach(d => {
						calendar.addEvent({
							id: d.key,
							title: d.values[0].trabajador + " ("+d.values[0].cod_ficha+")",
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
		}else{
			toastr.info(errorMessage);
		}
	}
		

		function rp_planif_serv_rp(tipo,id_tabla){
			$('#body_planif').val($('#'+id_tabla).html());
			$("#reporte_serv").val(tipo);
			$("#add_planif_serv_modal").submit();
		}

	filtroValue = $("#paciFiltro").val();

    new Autocomplete("stdName", function() { 
        this.setValue = function(id) {
            document.getElementById("stdID").value = id; // document.getElementsByName("stdID")[0].value = id;
        }
        if (this.isModified) this.setValue("");
        if (this.value.length < 1) return ;
          return "autocompletar/tb/trabajador.php?q="+this.text.value +"&filtro="+filtroValue+""});

    </script>
