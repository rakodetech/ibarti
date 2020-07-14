var cliente = '';
var usuario = '';
var apertura = '';
var supervision = '';
var calendar = null;
var calendarSuperv = null;
var cerrar = true;
var eventActual = null;
var fecha_fin = null;
var actividades = [];
var metodo = "agregar";
var typeCalendar = "timeGridWeek";
var isafter = true;
$(function () {
	Cons_planificacion_inicio();
	cargar_proyectos();
});

function Habilitar_supervision() {
	$('#supervision_texto').css("display", "block");
	$('#supervision_cont').css("display", "block");
}
function Ocultar_apertura() {
	$('#apertura_texto').css("display", "none");
	$('#apertura_cont').css("display", "none");
}
function Habilitar_apertura() {
	$('#apertura_texto').css("display", "block");
	$('#apertura_cont').css("display", "block");
}

function Ocultar_all() {
	Ocultar_apertura();
	$("#cont_planif_det").html("");
}

function Cons_planificacion_inicio() {
	var error = 0;
	var errorMessage = ' ';
	if (error == 0) {
		var parametros = {};
		$.ajax({
			data: parametros,
			url: 'packages/planif/planif_supervisor/views/Cons_inicio.php',
			type: 'post',
			beforeSend: function () {
				$("#Cont_planificacion").html('<img src="imagenes/loading3.gif" border="null" class="imgLink" width="30px" height="30px">');
			},
			success: function (response) {
				$("#Cont_planificacion").html(response);
				setTimeout(function () {
					Ocultar_all();
				}, 500);
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
			}
		});
	} else {
		alert(errorMessage);
	}
}

function ac_apertura_planif(parametros, callback) {
	parametros.metodo = "modificar_apertura";
	$.ajax({
		data: parametros,
		url: 'packages/planif/planif_supervisor/modelo/planificacion_apertura.php',
		type: 'post',
		success: function (response) {
			var resp = JSON.parse(response);
			if (resp.error == false) {
				toastr.success("Guardado exitosamente!.");
				if (typeof (callback) == "function") {
					callback();
				}
			} else {
				toastr.error("Se ha detectado un error!.")
			}

		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
		}
	});
}

function mod_apertura_planif() {
	var apertura_ap = $("#planf_apertura").val();
	var parametros = {
		cliente: cliente,
		apertura: apertura_ap
	};
	$.ajax({
		data: parametros,
		url: 'packages/planif/planif_supervisor/views/Add_planificacion_apertura.php',
		type: 'post',
		beforeSend: function () {
			$("#modal_contenido").html('');
			$('#myModal').show();
			$("#modal_titulo").html("CONSULTA DE APERTURA DE PLANIFICACION");
			$("#modal_contenido").html('<img src="imagenes/loading3.gif" border="null" class="imgLink" width="30px" height="30px"> Procesando...');
		},
		success: function (response) {
			$("#modal_contenido").html("");
			var resp = JSON.parse(response);
			var tabla = d3.select("#modal_contenido").append("div").style("overflow", "scroll").style("max-height", "500px").append("table").attr("class", "tabla_sistema").attr("width", "100%");
			var thead = tabla.append("thead").append("tr");
			var tbody = tabla.append("tbody");
			thead.append("th").text("Fecha").style("text-align", "center").style("border", "1px solid");
			thead.append("th").text("Cliente").style("text-align", "center").style("border", "1px solid");
			thead.append("th").text("Ubicacion").style("text-align", "center").style("border", "1px solid");
			thead.append("th").text("Turno").style("text-align", "center").style("border", "1px solid");
			thead.append("th").text("Cantidad").style("text-align", "center").style("border", "1px solid");

			var tr = tbody.selectAll('tr').data(resp).enter().append("tr").attr("id", (d) => "cod_" + d.codigo).attr('class', 'color').attr("title", (d) => "ULTIMA MODIFICACION: " + d.fecha_mod + " (" + d.nombres + ")");

			tr.append("td").text((d) => d.fecha).style("border", "1px solid").style("vertical-align", "middle").attr("width", "10%");
			tr.append("td").text((d) => d.cliente).style("border", "1px solid").style("vertical-align", "middle").attr("width", "16%");
			tr.append("td").text((d) => d.ubicacion).style("border", "1px solid").style("vertical-align", "middle").attr("width", "16%");
			tr.append("td").text((d) => d.turno).style("border", "1px solid").style("vertical-align", "middle").attr("width", "16%");
			var elementos_cantidad = tr.append("td").style("border", "1px solid").style("vertical-align", "middle").style("text-align", "left");
			elementos_cantidad.append("input").attr("id", (d) => `cant_${d.codigo}_${d.fecha}_${d.cod_cliente}_${d.cod_ubicacion}_${d.cod_turno}`).attr("type", "number").attr("min", "0").attr("value", (d) => d.cantidad).style("width", "60px").on("click", (d, e, f) => {
				if (Number(f[e].value) == Number(f[e].defaultValue)) {
					$(`#mod_${d.codigo}_${d.fecha}_${d.cod_cliente}_${d.cod_ubicacion}_${d.cod_turno}`).hide();
				} else {
					$(`#mod_${d.codigo}_${d.fecha}_${d.cod_cliente}_${d.cod_ubicacion}_${d.cod_turno}`).show();
				}
			}).on("keyup", (d, e, f) => {
				if (Number(f[e].value) == Number(f[e].defaultValue)) {
					$(`#mod_${d.codigo}_${d.fecha}_${d.cod_cliente}_${d.cod_ubicacion}_${d.cod_turno}`).hide();
				} else {
					$(`#mod_${d.codigo}_${d.fecha}_${d.cod_cliente}_${d.cod_ubicacion}_${d.cod_turno}`).show();
				}
			});
			elementos_cantidad.append("img").attr("id", (d) => `mod_${d.codigo}_${d.fecha}_${d.cod_cliente}_${d.cod_ubicacion}_${d.cod_turno}`).attr("src", "imagenes/ico_guadar.ico").style("width", "20px").style("margin-left", "10px").style("display", "none").attr("title", "modificar registro").on("click", (d) => {
				if (confirm("Esta seguro que desea modificar")) {
					var propiedades = {
						apertura: d.codigo,
						fecha: d.fecha,
						cliente: d.cod_cliente,
						ubicacion: d.cod_ubicacion,
						turno: d.cod_turno,
						cantidad: $(`#cant_${d.codigo}_${d.fecha}_${d.cod_cliente}_${d.cod_ubicacion}_${d.cod_turno}`).val(),
						usuario: $("#usuario").val()
					}
					ac_apertura_planif(propiedades, () => {
						$(`#mod_${d.codigo}_${d.fecha}_${d.cod_cliente}_${d.cod_ubicacion}_${d.cod_turno}`).hide();
						$(`#cant_${d.codigo}_${d.fecha}_${d.cod_cliente}_${d.cod_ubicacion}_${d.cod_turno}`)[0].defaultValue = propiedades.cantidad;
						cerrar = true;
					})
				}


			});
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
		}
	});
}

function validarIngreso(apertura, cliente, ubic, proyecto, actividades, fecha, hora_inicio, hora_fin, callback) {
	var error = 0;
	var errorMessage = ' ';
	if (error == 0) {
		var parametros = { apertura, cliente, ubic, proyecto, actividades, fecha, hora_inicio, hora_fin };
		$.ajax({
			data: parametros,
			url: 'packages/planif/planif_supervisor/views/validarIngreso.php',
			type: 'post',
			success: function (response) {
				var resp = JSON.parse(response);
				callback(resp);
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
			}
		});
	} else {
		alert(errorMessage);
	}
}

function validarFecha(fecha, cliente, apertura, callback) {
	var error = 0;
	var errorMessage = ' ';
	if (error == 0) {
		var parametros = { fecha, cliente, apertura };
		$.ajax({
			data: parametros,
			url: 'packages/planif/planif_supervisor/views/validarFecha.php',
			type: 'post',
			success: function (response) {
				var resp = JSON.parse(response);
				callback(resp);
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
			}
		});
	} else {
		alert(errorMessage);
	}
}

function cl_apertura() {
	var parametros = { "cliente": cliente };
	$.ajax({
		data: parametros,
		url: 'packages/planif/planif_supervisor/views/Add_planif_apertura.php',
		type: 'post',
		beforeSend: function () {
			$("#planf_apertura").html('<img src="imagenes/loading3.gif" border="null" class="imgLink" width="30px" height="30px">');
		},
		success: function (response) {
			$("#planf_apertura").html(response);
			Habilitar_apertura();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
		}
	});
}

function verificar_cl(cl, modal) {
	usuario = $("#usuario").val();

	if (cl == '') {
		Ocultar_all();
		var error = 1;
		var errorMessage = 'Debe Seleccionar Un Cliente';
		alert(errorMessage);
		cliente = cl;
	} else {
		Ocultar_apertura();
		cliente = cl;
		var parametros = { "codigo": cliente };
		$.ajax({
			data: parametros,
			url: 'packages/planif/planif_supervisor/modelo/verificar_cl.php',
			type: 'post',
			success: function (response) {
				var resp = JSON.parse(response);
				if (resp[0]['contra'] == 0) {
					if (!modal) {
						Ocultar_all();
						B_supervision();
					}
				} else {
					cl_apertura();
				}
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
			}
		});
	}
}

function cargar_proyectos() {
	//var parametros = { "cliente": cliente };
	$.ajax({
		url: 'packages/planif/planif_supervisor/views/Add_proyectos.php',
		type: 'get',
		success: function (response) {
			$("#planf_proyectoRP").html(response);
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
		}
	});
}

function cargar_actividades(proyecto, callback) {
	if (proyecto) {
		var parametros = { "proyecto": proyecto };
		$.ajax({
			data: parametros,
			url: 'packages/planif/planif_supervisor/views/Add_actividades.php',
			type: 'post',
			success: function (response) {
				$("#planf_actividadRP").html(response);
				updateFecFin(eventActual);
				if (typeof callback == "function") {
					callback();
				}
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
			}
		});
	}
}

function cargar_planif_superv(ap) {
	cliente = $("#planf_cliente").val();
	if (cliente == '') {
		$("#cont_supervision_det").html("");
		$("#cont_planif_det").html("");
		if (calendar) {
			calendar.destroy();
		}
	} else {
		if (ap != '') {
			apertura = ap;
			cargar_supervision_det(cliente);
			cargar_planif_superv_det(apertura);
		}
	}
}

function cargar_supervision_det(cliente) {
	var parametros = {
		"cliente": cliente,
		"usuario": usuario
	};
	$.ajax({
		data: parametros,
		url: 'packages/planif/planif_supervisor/views/Add_supervision_det.php',
		type: 'post',
		beforeSend: function () {
			$("#cont_supervision_det").html('<img src="imagenes/loading3.gif" border="null" class="imgLink" width="30px" height="30px">');
		},
		success: function (response) {
			$("#cont_supervision_det").html(response);
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
		}
	});
}

function trab_sin_planificar() {
	var cliente = $("#planf_cliente").val();
	if (cliente && apertura) {
		var parametros = {
			"cliente": cliente, 'apertura': apertura
		};
		$.ajax({
			data: parametros,
			url: 'packages/planif/planif_supervisor/views/Add_trab_sin_planif.php',
			type: 'post',
			success: function (response) {
				ModalOpen();
				$("#modal_titulo").text("Trabajadores sin Planificacion");
				$("#modal_contenido").html(response);
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
			}
		});
	} else {
		toastr.warning('Debe seleccionar el cliente y la apertura.')
	}
}

function cantidad_trab_sin_planificar(cliente, apertura) {
	var parametros = {
		"cliente": cliente,
		'apertura': apertura
	};
	$.ajax({
		data: parametros,
		url: 'packages/planif/planif_supervisor/views/Add_cant_trab_sin_planif.php',
		type: 'post',
		success: function (response) {
			var resp = JSON.parse(response);
			$("#cantidad_sin_planif").text(resp.cantidad);
			//cargar_calendario();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
		}
	});
}

function cargar_planif_superv_det(apertura) {
	if (calendar) {
		calendarSuperv.destroy();
		calendar.destroy();
	}
	var parametros = { "codigo": apertura, "cliente": cliente, "usuario": usuario };
	$.ajax({
		data: parametros,
		url: 'packages/planif/planif_supervisor/views/Add_planif_det.php',
		type: 'post',
		beforeSend: function () {
			$("#cont_planif_det").html('<img src="imagenes/loading3.gif" border="null" class="imgLink" width="30px" height="30px">');
		},
		success: function (response) {
			var resp = JSON.parse(response);
			$("#cont_planif_det").html(resp["html"]);
			var fechas = resp["fechas"];
			cantidad_trab_sin_planificar(cliente, apertura);
			var containerEx = document.getElementById('external-events-list');
			calendarSuperv = new FullCalendar.Draggable(containerEx, {
				itemSelector: '.fc-event',
				eventData: function (eventEl) {
					return {
						title: eventEl.innerText.trim(),
						extendedProps: {
							codigo: "",
							cod_ficha: eventEl.getAttribute('cod_ficha'),
							cedula: eventEl.getAttribute('cedula')
						},
						allDay: false,
						stick: true
					}
				},
				create: false,
				droppable: false
			});

			var calendarEl = document.getElementById('calendar');
			calendar = new FullCalendar.Calendar(calendarEl, {
				initialView: typeCalendar,
				headerToolbar: { center: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth' },
				views: {
					listMonth: {
						editable: false,
						eventContent: function (arg) {
							var result = "<label>En proceso<?label>";
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
						eventContent: function (arg) {
							var result = "<label>En proceso<?label>";
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
							var result = "<label>En proceso<?label>";
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
					timeGridWeek: {
						showNonCurrentDates: false,
						editable: false,
						selectable: true,
						eventContent: function (arg) {
							var result = "<label>En proceso<?label>";
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
					if (!isafter) {
						eventActual.remove();
					}
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
				slotDuration: '00:30:00',
				dateClick: function (info) {
					//calendar.formatIso(info.date)
				},
				eventClick: function (arg) {
					eventActual = arg.event;
					metodo = "modificar";
					var hoy = new Date();
					var isafter = moment(arg.dateStr).isSameOrAfter(moment(hoy).format("YYYY-MM-DD"));
					if (isafter) {
						$("#guardarActividad").show();
					} else {
						$("#guardarActividad").hide();
					}
					editarActividad(eventActual);
					/* 		
						if (confirm('Are you sure you want to delete this event?')) {
							arg.event.remove()
						} 
					*/
				},
				selectMirror: true,
				select: function (arg) {
					//("arg.start ", arg.start);
				},
				nowIndicator: true,
				height: 'auto',
				drop: function (arg) {
					var hoy = new Date();
					eventActual = arg.event;
					isafter = moment(arg.dateStr).isSameOrAfter(moment(hoy).format("YYYY-MM-DD"));
					if (isafter) {
						validarFecha(moment(arg.date).format("YYYY-MM-DD"), cliente, apertura, (fechas) => {
							if (fechas.length > 0) {
								$("#planf_ubicacionRP").html("");
								$("#planf_ubicacionRP").append('<option value="">Seleccione</option>');
								var hora_entrada = fechas[0].hora_entrada;
								var hora_salida = fechas[0].hora_salida;
								$("#planf_horaRP").prop("min", hora_entrada);
								$("#planf_hora_finRP").prop("min", hora_entrada);
								$("#planf_hora_finRP").prop("max", hora_salida);
								fechas.forEach((f) => {
									if (f.hora_entrada < hora_entrada) {
										var hora_entrada = f.hora_entrada;
										$("#planf_horaRP").prop("min", hora_entrada);
										$("#planf_hora_finRP").prop("min", hora_entrada);
									}
									if (f.hora_salida > hora_salida) {
										var hora_salida = fechas[0].hora_salida;
										$("#planf_hora_finRP").prop("max", hora_salida);
									}
									$("#planf_ubicacionRP").append('<option value=' + f.cod_ubicacion + '>' + f.ubicacion + '</option>');
								});
								metodo = "agregar";
								modalActividad();
							} else {
								toastr.error("Esta fecha no aplica!.");
								eventActual.remove();
							}
						});
						$("#guardarActividad").show();
					} else {
						toastr.info("No es posible planificar actividades sobre fechas pasadas.");
					}
				},
				dayMaxEvents: true,
				dayHeaderFormat: { weekday: 'short' },
				/* 				events: [
									{
										title: "sdads",
										start: "2020-06-26",
										end: "2020-06-26",
										allDay: true
									}
								] */
				//weekends: false,
				//dayHeaders: false

				//contentHeight: 600,

				/* 				businessHours: {
									// days of week. an array of zero-based day of week integers (0=Sunday)
									daysOfWeek: [1, 2, 3, 4], // Monday - Thursday
				
									startTime: '10:00', // a start time (10am in this example)
									endTime: '18:00', // an end time (6pm in this example)
								},
								resources: [
									{
										id: 'a',
										title: 'Resource A',
										businessHours: {
											startTime: '10:00',
											endTime: '18:00'
										}
									},
									{
										id: 'b',
										title: 'Resource B',
										businessHours: {
											startTime: '11:00',
											endTime: '17:00',
											daysOfWeek: [1, 3, 5] // Mon,Wed,Fri
										}
									}
								], */
			});
			res_eventos = d3.nest()
				.key((d) => d.codigo)
				.entries(resp["data"]);
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
						cod_ubicacion: d.values[0].cod_ubicacion
					},
				});
			});
			/* 			
				calendar.getEvents().forEach(evt => {
					(evt, calendar.getEventById(evt.extendedProps.codigo));
				}); 
			*/
			calendar.render();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
		}
	});
}

function cargar_planif_superv_trab_det(cod, evento_det) {
	if (evento_det == "NO") {
		var codigo = $("#det_codigo" + cod + "").val();
	} else if (evento_det == "SI") {
		var codigo = cod;
	}


	var error = 0;
	var errorMessage = '';

	if (codigo == "") {
		var error = 1;
		var errorMessage = 'Debe Ingresar Todos los Datos para ver su Detalle';
	}
	var parametros = {
		"apertura": apertura, "codigo": codigo,
		"metodo": "agregar", "usuario": usuario
	}
	if (error == 0) {
		$.ajax({
			data: parametros,
			url: 'packages/planif/planif_supervisor/views/Cons_planif_trab_det.php',
			type: 'post',
			success: function (response) {
				ModalOpen();
				$("#modal_titulo").text("Detalle De planificacion de Trabajador");
				$("#modal_contenido").html(response);
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
			}
		});
	} else {
		alert(errorMessage);
	}
}

function B_supervision() {
	var error = 0;
	var errorMessage = ' ';
	var parametros = { "codigo": cliente, "usuario": usuario };

	if (error == 0) {
		$.ajax({
			data: parametros,
			url: 'packages/cliente/cl_supervision/index.php',
			type: 'post',
			success: function (response) {
				ModalOpen();
				$("#modal_titulo").text("Supervision");
				$("#modal_contenido").html(response);
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
			}
		});
	} else {
		alert(errorMessage);
	}
}

function B_planif_apertura() {
	var parametros = { "usuario": usuario, "cliente": cliente, "supervision": supervision };
	$.ajax({
		data: parametros,
		url: 'packages/planif/planif_supervisor/views/Add_planif_apertura_ing.php',
		type: 'post',
		success: function (response) {
			ModalOpen();
			$("#modal_titulo").text("Ingresar Apertura");
			$("#modal_contenido").html(response);
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
		}
	});
}

function cerrarModal() {
	$("#myModal").hide();
	var cliente = $("#planf_cliente").val();
	if (cliente) {
		verificar_cl(cliente, true);
	}
}

function Cons_Apertura() {
	var parametros = { "cliente": cliente, "supervision": supervision };
	$.ajax({
		data: parametros,
		url: 'packages/planif/planif_supervisor/views/Cons_planif_apertura.php',
		type: 'post',
		success: function (response) {
			$("#modal_contenido").html(response);
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
		}
	});
}

// Planificacion de trabajo detalle por trabajador  Agregar Modificar Eliminar
function Cerrar_ap_planif(cod, status) {
	if (status == "T") {
		if (confirm("¿ Esta Seguro De Cerrar esta Planificación (" + cod + ") ?")) {
			var parametros = {
				"codigo": cod,
				"metodo": "cerrar", "usuario": usuario
			}
			$.ajax({
				data: parametros,
				url: 'packages/planif/planif_supervisor/modelo/planificacion_apertura.php',
				type: 'post',
				success: function (response) {
					var resp = JSON.parse(response);
					if (resp.error) {
						alert(resp.mensaje);
					} else {
						// Actualizo Datos De apertura
						Cons_Apertura();
						cl_apertura();
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status);
					alert(thrownError);
				}
			});

		}
	}
}


function B_planif_trab() {
	var ubic = $("#planf_ubicacion").val();
	var client = $("#planf_cliente").val();
	var parametros = {
		"codigo": apertura, "ubicacion": ubic, "cliente": client,
		"usuario": usuario
	};
	$.ajax({
		data: parametros,
		url: 'packages/planif/planif_supervisor/views/Add_planif_trab.php',
		type: 'post',
		success: function (response) {
			ModalOpen();
			$("#modal_titulo").text("Agregar Trabajador");
			$("#modal_contenido").html(response);
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
		}
	});
}

// Planificacion de trabajo detalle por trabajador  Agregar Modificar Eliminar
function saveActividad() {
	props = eventActual.extendedProps;
	var ubic = $("#planf_ubicacionRP").val();
	var proyecto = $("#planf_proyectoRP").val();
	if (!ubic) {
		error++;
		errorMessage += "La ubicación es obligatoria";
	}
	if (!proyecto) {
		error++;
		errorMessage += "El proyecto es obligatorio";
	}
	var hora_inicio = $("#planf_horaRP").val();
	var hora_fin = $("#planf_hora_finRP").val();
	var fechaQuery = moment(eventActual.start).format("YYYY-MM-DD");
	var fecha_inicio = fechaQuery + " " + hora_inicio;
	var fecha_fin = fechaQuery + " " + hora_fin;
	var error = 0;
	var errorMessage = ' ';

	if (!fecha_inicio) {
		error++;
		errorMessage += "La fecha inicial es obligatoria";
	}
	if (error == 0) {
		if (metodo == "agregar") {
			validarIngreso(apertura, cliente, ubic, proyecto, actividades, fechaQuery, hora_inicio, hora_fin, (valid) => {
				if (valid.length > 0) {
					var parametros = {
						"codigo": props.codigo, "fecha_inicio": fecha_inicio, "fecha_fin": fecha_fin,
						"cliente": cliente, "ubicacion": ubic, "ficha": props.cod_ficha, 'apertura': apertura,
						"proyecto": proyecto, "actividades": actividades, "metodo": metodo, "usuario": usuario
					}
					$.ajax({
						data: parametros,
						url: 'packages/planif/planif_supervisor/modelo/actividad_det.php',
						type: 'post',
						success: function (response) {
							var resp = JSON.parse(response);
							if (resp.error) {
								toastr.error(resp.mensaje);
							} else {
								toastr.success('Actualizacion Exitosa!..');
								$('#modalRP').hide();
								typeCalendar = calendar.view.type;
								cargar_planif_superv_det(apertura);
							}
						},
						error: function (xhr, ajaxOptions, thrownError) {
							alert(xhr.status);
							alert(thrownError);
						}
					});
				} else {
					toastr.error('Rango de horas no válido');
				}
			});
		} else {
			var parametros = {
				"codigo": props.codigo, "fecha_inicio": fecha_inicio, "fecha_fin": fecha_fin,
				"cliente": cliente, "ubicacion": ubic, "ficha": props.cod_ficha, 'apertura': apertura,
				"proyecto": proyecto, "actividades": actividades, "metodo": metodo, "usuario": usuario
			};
			$.ajax({
				data: parametros,
				url: 'packages/planif/planif_supervisor/modelo/actividad_det.php',
				type: 'post',
				success: function (response) {
					var resp = JSON.parse(response);
					if (resp.error) {
						toastr.error(resp.mensaje);
					} else {
						eventActual.setStart(fecha_inicio);
						eventActual.setEnd(fecha_fin);
						toastr.success('Actualizacion Exitosa!..');
						$('#modalRP').hide();
						typeCalendar = calendar.view.type;
						cargar_planif_superv_det(apertura);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status);
					alert(thrownError);
				}
			});
		}
	} else {
		toastr.warning(errorMessage);
	}
}

function mostrar_icono_apertura(valor) {
	if (valor != '') {
		$('#mod_ap_planif').show();

	} else {
		$('#mod_ap_planif').hide();
	}
}

function cancelarActividad() {
	if (!$("#planf_ubicacionRP").attr("disabled")) {
		eventActual.remove();
	}
	$('#modalRP').hide();
}

function modalActividad() {
	cargar_proyectos();
	$("#planf_ubicacionRP").attr("disabled", false);
	$("#planf_proyectoRP").attr("disabled", false);
	$("#planf_fechaRP").html(moment(eventActual.start).format('YYYY-MM-DD'));
	$("#cedulaRP").html(eventActual.extendedProps.cedula);
	$("#planf_actividadRP").html("");
	$("#planf_horaRP").val(moment(eventActual.start).format("HH:mm:00"));
	$("#planf_hora_finRP").val("");
	$("#fotoRP").attr("src", "imagenes/fotos/" + eventActual.extendedProps.cedula + ".jpg");
	$('#modalRP').show();
}

function editarActividad(event) {
	validarFecha(moment(event.start).format("YYYY-MM-DD"), cliente, apertura, (fechas) => {
		if (fechas.length > 0) {
			$("#planf_ubicacionRP").attr("disabled", true).html("");
			$("#planf_ubicacionRP").append('<option value="">Seleccione</option>');
			var hora_entrada = fechas[0].hora_entrada;
			var hora_salida = fechas[0].hora_salida;
			$("#planf_horaRP").prop("min", hora_entrada);
			$("#planf_hora_finRP").prop("min", hora_entrada);
			$("#planf_hora_finRP").prop("max", hora_salida);
			fechas.forEach((f) => {
				if (f.hora_entrada < hora_entrada) {
					var hora_entrada = f.hora_entrada;
					$("#planf_horaRP").prop("min", hora_entrada);
					$("#planf_hora_finRP").prop("min", hora_entrada);
				}
				if (f.hora_salida > hora_salida) {
					var hora_salida = fechas[0].hora_salida;
					$("#planf_hora_finRP").prop("max", hora_salida);
				}
				$("#planf_ubicacionRP").append('<option value=' + f.cod_ubicacion + '>' + f.ubicacion + '</option>');
			});
			$("#planf_proyectoRP").attr("disabled", true).val(event.extendedProps.cod_proyecto);
			$("#planf_fechaRP").html(moment(event.start).format('YYYY-MM-DD'));
			$("#planf_ubicacionRP").val(event.extendedProps.cod_ubicacion);
			$("#planf_horaRP").val(moment(event.start).format("HH:mm:00"));
			$("#cedulaRP").html(event.extendedProps.cedula);
			cargar_actividades(event.extendedProps.cod_proyecto, () => {
				$('#modalRP').show();
				event.extendedProps.actividades.forEach(act => {
					$("#actividad" + act.cod_actividad).prop("checked", true);
				});
				updateFecFin(event);
			});
		}
	});
}

function updateFecFin(event) {
	if (event) {
		evt = event;
	} else {
		evt = eventActual;
	}
	var minutos = 0;
	var hora_inicio = $("#planf_horaRP").val();
	actividades = $('[name="actividades[]"]:checked').map(function () {
		minutos += Number($("#actividad" + this.value).attr("minutos"));
		return this.value;
	}).get();
	if (hora_inicio) {
		var fec_start = moment(evt.start);
		fec_start = fec_start.format('YYYY-MM-DD') + " " + hora_inicio;
		fec_start = moment(fec_start);
		fecha_inicio = fec_start.format('YYYY-MM-DD HH:mm:ss');
		fecha_fin = fec_start.add(minutos / 60, "hours",).format('YYYY-MM-DD HH:mm:ss');
		hora_fin = fec_start.format('HH:mm:00');
		$("#planf_hora_finRP").val(hora_fin);
	}
}


function save_planif_apertura() {
	var fec_inicio = $("#ap_fecha_inicio").val();
	var fec_fin = $("#ap_fecha_fin").val();
	var parametros = {
		"codigo": '', "cliente": cliente,
		"fec_inicio": fec_inicio, "fec_fin": fec_fin,
		"metodo": "agregar", "usuario": usuario
	}
	$.ajax({
		data: parametros,
		url: 'packages/planif/planif_supervisor/modelo/planificacion_apertura.php',
		type: 'post',
		beforeSend: function () {
			$("#planif_apertura_ing").html('<img src="imagenes/loading3.gif" border="null" class="imgLink" width="30px" height="30px">');
		},
		success: function (response) {
			$("#planif_apertura_ing").html('<span class="art-button-wrapper" id="planif_apertura_ing"><span class="art-button-l"> </span><span class="art-button-r"> </span><input type="submit" name="salvar"  id="salvar" value="Guardar" class="readon art-button" /> </span')
			var resp = JSON.parse(response);
			if (resp.error) {
				alert(resp.mensaje);
			} else {
				// actualiza la apertura
				Habilitar_apertura();
				cl_apertura();
				CloseModal();
				toastr.success("Actualizacion Exitosa!..");
			}
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
		}
	});
}