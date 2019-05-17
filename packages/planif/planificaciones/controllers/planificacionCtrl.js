var cliente  ='';
var usuario  = '';
var apertura = '';
var contratacion = '';

$(function() {
	Cons_planificacion_inicio();
});

function Ocultar_contratacion(){
	$('#contratacion_texto').css("display", "none");
	$('#contratacion_cont').css("display", "none");
}
function Habilitar_contratacion(){
	$('#contratacion_texto').css("display", "block");
	$('#contratacion_cont').css("display", "block");
}
function Ocultar_apertura(){
	$('#apertura_texto').css("display", "none");
	$('#apertura_cont').css("display", "none");
}
function Habilitar_apertura(){
	$('#apertura_texto').css("display", "block");
	$('#apertura_cont').css("display", "block");
}

function Habilitar_ubicacion(){
	$('#ubicacion_texto').css("display", "block");
	$('#ubicacion_cont').css("display", "block");
}
function Ocultar_ubicacion(){
	$('#ubicacion_texto').css("display", "none");
	$('#ubicacion_cont').css("display", "none");
}

function Ocultar_all(){
	Ocultar_contratacion();
	Ocultar_apertura();
	Ocultar_ubicacion();
	$("#cont_planif_det").html("");
}

function Cons_planificacion_inicio(){
	var error        = 0;
	var errorMessage = ' ';
	if(error == 0){
		var parametros = {  };
		$.ajax({
			data:  parametros,
			url:   'packages/planif/planificaciones/views/Cons_inicio.php',
			type:  'post',
			beforeSend: function(){
				$("#Cont_planificacion").html('<img src="imagenes/loading3.gif" border="null" class="imgLink" width="30px" height="30px">');
			},
			success:  function (response) {
				$("#Cont_planificacion").html(response);
				setTimeout(function(){
					Ocultar_all();
				}, 500);
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);}
			});
	}else{
		alert(errorMessage);
	}
}

function verificar_cl(cl){
	usuario = $("#usuario").val();

	if(cl =='') {
		Ocultar_all();
		var error = 1;
		var errorMessage = 'Debe Seleccionar Un Cliente';
		alert(errorMessage);
		cliente =cl;
	}else{
		// Actualizar contrato
		Ocultar_ubicacion();
		Ocultar_apertura();
		cliente =cl;
		var parametros = {"codigo": cliente};
		$.ajax({
			data:  parametros,
			url:   'packages/planif/planificaciones/modelo/verificar_cl.php',
			type:  'post',
			success:  function (response) {
				var resp = JSON.parse(response);

				if(resp[0]['contra'] == 0){
					Ocultar_all();
					B_contratacion();
				}else{
					planif_contratacion();
				}
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);}
			});
	}
}

function verificar_cont(cont){
	usuario = $("#usuario").val();

	if(cont =='') {
		Ocultar_ubicacion();
		Ocultar_apertura();
		contratacion =cont;
	}else{
		// Actualizar contrato
		contratacion =cont;
		var parametros = {"codigo": contratacion,"cliente":cliente};
		$.ajax({
			data:  parametros,
			url:   'packages/planif/planificaciones/modelo/verificar_cont.php',
			type:  'post',
			success:  function (response) {
				var resp = JSON.parse(response);

				if(resp[0]['apertura'] == 0) {
					//Ocultar_all();
					B_planif_apertura();

				}else{
					Habilitar_apertura();
					//Ocultar_contratacion();
					cl_apertura();
					cargar_ubic();
				}
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);}
			});
	}
}

function cl_apertura(){
	var parametros = {"codigo": contratacion,"cliente":cliente};
	$.ajax({
		data:  parametros,
		url:   'packages/planif/planificaciones/views/Add_planif_apertura.php',
		type:  'post',
		beforeSend: function(){
			$("#planf_apertura").html('<img src="imagenes/loading3.gif" border="null" class="imgLink" width="30px" height="30px">');
		},
		success:  function (response) {
			$("#planf_apertura").html(response);
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);}
		});
}


function planif_contratacion(){
	var parametros = {"cliente": cliente,"usuario": usuario};
	$.ajax({
		data:  parametros,
		url:   'packages/planif/planificaciones/views/Add_planif_contratacion.php',
		type:  'post',
		beforeSend: function(){
			$("#planf_contratacion").html('<img src="imagenes/loading3.gif" border="null" class="imgLink" width="30px" height="30px">');
		},
		success:  function (response){
			Habilitar_contratacion();
			$("#planf_contratacion").html(response);
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);}
		});
}

function cargar_ubic(){
	var parametros = {"codigo": contratacion, "cliente": cliente};
	$.ajax({
		data:  parametros,
		url:   'packages/planif/planificaciones/views/Add_planif_ap_ubic.php',
		type:  'post',
		beforeSend: function(){
			$("#planf_ubicacion").html('<img src="imagenes/loading3.gif" border="null" class="imgLink" width="30px" height="30px">');
		},
		success:  function (response) {
			Habilitar_ubicacion();
			$("#planf_ubicacion").html(response);
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
		}
	});
}

function cargar_planif(ap){
	ubic = $("#planf_ubicacion").val();
	if(ubic == '') {
		$("#cont_contratacion_det").html("");
		$("#cont_planif_det").html("");
	}else {
		apertura = ap;
		cargar_contratacion_det(ubic);
		cargar_planif_det(ubic);
	}
}

function replicar_rot(){
	if(confirm("Esta seguro(a) de que desea replicar las rotaciones anteriores?..")){
		ubic = $("#planf_ubicacion").val();
		var parametros = {"apertura": apertura, "contratacion": contratacion,"cliente":cliente, "ubicacion" : ubic, "usuario": usuario};
		$.ajax({
			data:  parametros,
			url:   'packages/planif/planificaciones/modelo/replicar_planif_rot.php',
			type:  'post',
			beforeSend: function(){
				$("#cont_planif_det").html('<img src="imagenes/loading3.gif" border="null" class="imgLink" width="30px" height="30px">');
			},
			success:  function (response) {
				cargar_planif_det(ubic);
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);}
			});
	}
}

function cargar_contratacion_det(ubic){
	var parametros = {"codigo": contratacion, "ubicacion":ubic,
	"usuario": usuario};
	$.ajax({
		data:  parametros,
		url:   'packages/planif/planificaciones/views/Add_contratacion_det.php',
		type:  'post',
		beforeSend: function(){
			$("#cont_contratacion_det").html('<img src="imagenes/loading3.gif" border="null" class="imgLink" width="30px" height="30px">');
		},
		success:  function (response) {
			$("#cont_contratacion_det").html(response);
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);}
		});
}

function Cargar_puesto(codigo, contenedor){
	var parametros = {"codigo" : codigo,   "usuario": usuario};
	$.ajax({
		data:  parametros,
		url:   'packages/cliente/cl_contratacion/views/select_puesto.php',
		type:  'post',
		success:  function (response) {
			$("#"+contenedor+"").html(response);
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);}
		});
}

// GENERAR PLANIFICACION
// TOMAR PLANTILLA Y GENERAR LA PLANIFICACION
function generar_planif(ubic){
	if((ubic != "") && (apertura != "")){
		var parametros = {"codigo": apertura, "ubicacion": ubic, "usuario": usuario};
		$.ajax({
			data:  parametros,
			url:   'packages/planif/planificaciones/modelo/generar_planif.php',
			type:  'post',
			success:  function (response) {
			//		$("#cont_planif_det").html(response);
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);}
		});
	}else{
		alert("Error en Data para aperturar");
	}
}

function cargar_planif_det(ubic){
	var parametros = {"codigo": apertura, "ubicacion" : ubic, "usuario": usuario};
	$.ajax({
		data:  parametros,
		url:   'packages/planif/planificaciones/views/Add_planif_det.php',
		type:  'post',
		beforeSend: function(){
			$("#cont_planif_det").html('<img src="imagenes/loading3.gif" border="null" class="imgLink" width="30px" height="30px">');
		},
		success:  function (response) {
			$("#cont_planif_det").html(response);
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);}
		});
}

function cargar_planif_trab_det(cod, evento_det){
	if(evento_det == "NO"){
		var codigo   = $("#det_codigo"+cod+"").val();
	}else if (evento_det == "SI") {
		var codigo   = cod;
	}


	var error = 0;
	var errorMessage = '';

	if(codigo == ""){
		var error = 1;
		var errorMessage = 'Debe Ingresar Todos los Datos para ver su Detalle';
	}
	var parametros = {"apertura": apertura,       "codigo": codigo,
	"metodo": "agregar",       "usuario" : usuario
}
if(error == 0){
	$.ajax({
		data:  parametros,
		url:   'packages/planif/planificaciones/views/Cons_planif_trab_det.php',
		type:  'post',
		success:  function (response) {
			ModalOpen();
			$("#modal_titulo").text("Detalle De planificacion de Trabajador");
			$( "#modal_contenido" ).html( response);
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);}
		});
}else{
	alert(errorMessage);
}
}

function cargar_rotacion_posicion(rotacion, contenedor){
	var parametros = {"codigo": rotacion, "usuario": usuario};
	$.ajax({
		data:  parametros,
		url:   'packages/planif/planificaciones/views/Add_rotacion_posicion.php',
		type:  'post',
		beforeSend: function(){
			$("#"+contenedor+"").html('<img src="imagenes/loading3.gif" border="null" class="imgLink" width="30px" height="30px">');
		},
		success:  function (response) {
			$("#"+contenedor+"").html(response);
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);}
		});

}

function B_contratacion(){
	var error        = 0;
	var errorMessage = ' ';
	var parametros = {"codigo":cliente, "Nmenu" : 301, "usuario" : usuario};

	if(error == 0){
		$.ajax({
			data:  parametros,
			url:   'packages/cliente/cl_contratacion/index.php',
			type:  'post',
			success:  function (response) {
				ModalOpen();
				$("#modal_titulo").text("Contratacion");
				$( "#modal_contenido" ).html(response);
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);}
			});
	}else{
		alert(errorMessage);
	}
}

function B_planif_apertura(){
	var parametros = {"usuario" : usuario,"cliente": cliente,"contratacion":contratacion};
	$.ajax({
		data:  parametros,
		url:   'packages/planif/planificaciones/views/Add_planif_apertura_ing.php',
		type:  'post',
		success:  function (response) {
			ModalOpen();
			$("#modal_titulo").text("Ingresar Apertura");
			$( "#modal_contenido" ).html(response);
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);}
		});
}

function Cons_Apertura(){
	var parametros = {"cliente":cliente,"contratacion":contratacion};
	$.ajax({
		data:  parametros,
		url:   'packages/planif/planificaciones/views/Cons_planif_apertura.php',
		type:  'post',
		success:  function (response) {
			$("#modal_contenido").html(response);
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);}
		});
}

	// Planificacion de trabajo detalle por trabajador  Agregar Modificar Eliminar
	function Cerrar_ap_planif(cod, status){
		if(status == "T"){
			if (confirm("¿ Esta Seguro De Cerrar esta Planificación ("+cod+") ?")) {
				var parametros = {"codigo": cod,
				"metodo": "cerrar",        "usuario" : usuario
			}
			$.ajax({
				data:  parametros,
				url:   'packages/planif/planificaciones/modelo/planificacion_apertura.php',
				type:  'post',
				success:  function (response) {
					var resp = JSON.parse(response);
					if(resp.error){
						alert(resp.mensaje);
					}else{
								// Actualizo Datos De apertura
								Cons_Apertura();
								cl_apertura();
							}
						},
						error: function (xhr, ajaxOptions, thrownError) {
							alert(xhr.status);
							alert(thrownError);}
						});

		}
	}
}

function save_planif_apertura(){
	var fec_inicio   = $("#ap_fecha_inicio").val();
	var fec_fin      = $("#ap_fecha_fin").val();
	var parametros = {"codigo": '',"cliente" : cliente,"contratacion":contratacion,
	"fec_inicio":fec_inicio,    "fec_fin" : fec_fin,
	"metodo": "agregar",        "usuario" : usuario
}
$.ajax({
	data:  parametros,
	url:   'packages/planif/planificaciones/modelo/planificacion_apertura.php',
	type:  'post',
	beforeSend: function(){
		$("#planif_apertura_ing").html('<img src="imagenes/loading3.gif" border="null" class="imgLink" width="30px" height="30px">');
	},
	success:  function (response) {
		$("#planif_apertura_ing").html('<span class="art-button-wrapper" id="planif_apertura_ing"><span class="art-button-l"> </span><span class="art-button-r"> </span><input type="submit" name="salvar"  id="salvar" value="Guardar" class="readon art-button" /> </span')
		var resp = JSON.parse(response);
		if(resp.error){
			alert(resp.mensaje);
		}else{
						// actualiza la apertura
						Habilitar_apertura();
						cargar_ubic();
						cl_apertura();
						CloseModal();
						alert("Actualizacion Exitosa!..");
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status);
					alert(thrownError);}
				});
}


function B_planif_trab(){
	var ubic       = $("#planf_ubicacion").val();
	var client       = $("#planf_cliente").val();
	var parametros = {"codigo":apertura,  "ubicacion" : ubic,"cliente": client,
	"usuario" : usuario};
	$.ajax({
		data:  parametros,
		url:   'packages/planif/planificaciones/views/Add_planif_trab.php',
		type:  'post',
		success:  function (response) {
			ModalOpen();
			$("#modal_titulo").text("Agregar Trabajador");
			$( "#modal_contenido").html( response);
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);}
		});
}
function B_planif_rotacion(){
	alert("rotacion");
}



function save_planif_det(cod){
	var error        = 0;
	var errorMessage = '';
	var codigo       = $("#det_codigo"+cod+"").val();
	var ubic         = $("#planf_ubicacion").val();
	var ficha        = $("#det_ficha"+cod+"").val();
	var puesto_trab  = $("#det_puesto_trab"+cod+"").val();
	var rotacion     = $("#det_rotacion"+cod+"").val();
	var posicion     = $("#det_posicion"+cod+"").val();
	var fecha_inicio = $("#det_fec_inicio"+cod+"").val();
	var fecha_fin    = $("#det_fec_fin"+cod+"").val();
	var metodo       = $("#det_metodo"+cod+"").val();

	if(puesto_trab == ""){
		error = 1;
		errorMessage = "Puesto de trabajo" +puesto_trab;
	}
	if(rotacion == ""){
		error = 1;
		errorMessage = "Rotacion";
	}
	if(posicion == ""){
		error = 1;
		errorMessage = "Posicion";
	}
	if(fecha_inicio == ""){
		error = 1;
		errorMessage = "fecha_inicio";
	}
	if(fecha_fin == ""){
		error = 1;
		errorMessage = "fecha_ fin";
	}

	if(error == 0){
		var parametros = {"apertura": apertura,       "codigo": codigo,
		"ficha" : ficha,
		"cliente": cliente,         "ubicacion": ubic,
		"puesto_trab":puesto_trab,  "rotacion" : rotacion,
		"posicion":posicion,        "fecha_inicio":fecha_inicio,
		"fecha_fin": fecha_fin,
		"metodo": metodo,           "usuario" : usuario
	}
	$.ajax({
		data:  parametros,
		url:   'packages/planif/planificaciones/modelo/planificacion.php',
		type:  'post',
		success:  function (response) {
			cargar_planif_det(ubic);
			var resp = JSON.parse(response);
			if(resp.error){
				alert(resp.mensaje);
			}else{
				alert('Actualizacion Exitosa...');
			}
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);}
		});
}
}
// Planificacion de trabajo detalle por trabajador  Agregar Modificar Eliminar
function save_planif_trab_det(cod, metodo){
	if (confirm("�Esta Seguro De Actualizar Este Registro")) {
		var fecha        = $("#pl_trab_fecha").val();
		var planif_cl_trab = $("#planif_cl_trab").val();
		var cliente      = $("#pl_trab_cliente"+cod+"").val();
		var ubic         = $("#pl_trab_ubicacion"+cod+"").val();
		var puesto_trab  = $("#pl_trab_puesto_trab"+cod+"").val();
		var ficha        = $("#pl_trab_ficha"+cod+"").val();
		var turno        = $("#pl_trab_turno"+cod+"").val();

		var parametros = {"apertura": apertura,       "codigo": cod,
		"fecha": fecha,             "planif_cl_trab" : planif_cl_trab,
		"cliente": cliente,         "ubicacion" : ubic,
		"puesto_trab": puesto_trab, "ficha": ficha,
		"turno": turno,
		"metodo": metodo,        "usuario" : usuario
	}
	$.ajax({
		data:  parametros,
		url:   'packages/planif/planificaciones/modelo/planificacion_trab_det.php',
		type:  'post',
		success:  function (response) {

			var resp = JSON.parse(response);
			if(resp.error){
				alert(resp.mensaje);
			}else{
				cargar_planif_trab_det(planif_cl_trab, 'SI');
				alert('Actualizacion Exitosa!..')
			}
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);}
		});
}
}


function Calendario(cod){
	var codigo   = $("#det_codigo"+cod+"").val();
	var error = 0;
	var errorMessage = '';
	if(codigo == ""){
		var error = 1;
		var errorMessage = 'Debe Ingresar Todos los Datos para mostrar Calendario';
	}
	if(error == 0){
		var parametros = {"apertura": apertura,       "codigo": codigo,
		"usuario" : usuario
	}
	$.ajax({
		data:  parametros,
		url:   'packages/planif/planificaciones/views/Add_calendario.php',
		type:  'post',
		success:  function (response) {
			ModalOpen();
			$("#modal_titulo").text("Calendario");
			$( "#modal_contenido" ).html( response);
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);}
		});
}else {
	alert(errorMessage);
}
}
// REPORTE PDF O EXCEL
function rp_planif_trab(cod, reporte){
	var codigo   = $("#det_codigo"+cod+"").val();
	var ficha    = $("#det_ficha"+cod+"").val();

	if(codigo == ""){
		var error = 1;
		var errorMessage = 'Debe Ingresar Todos los Datos para cargar el reporte';
		alert(errorMessage);
	}else{
		$("#cod_apertura").val(apertura);
		$("#cod_ficha").val(ficha);
		$("#reporte").val(reporte);
		$("#add_planif_det").submit();
	}
}

function Borrar_trab_det(cod){
	var ficha        = $("#det_ficha"+cod+"").val();
	var apertura = $("#planf_apertura").val();
	var cliente      = $("#planf_cliente").val();
	var planif_ub = $("#planf_ubicacion").val();
	var usuario = $("#usuario").val();
	if (confirm("�Esta Seguro De Borrar el Registro("+ficha+") de esta Planificación?")) {
		var parametros = {"ficha": ficha,"cliente": cliente,"ubicacion":planif_ub,
		"apertura":apertura, "usuario" : usuario};
		$.ajax({
			data:  parametros,
			url:   'packages/planif/planificaciones/modelo/delete_planif_trab_det.php',
			type:  'post',
			success:  function (response) {
				var resp = response;
				if(resp.error){
					alert(resp.mensaje);
				}else{
					cargar_planif(apertura);
				}
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);}
			});
	}
}

function B_reporte(detalle){
	var errorMessage = '';
	var ubicacion = $("#planf_ubicacion").val();

	if(ubicacion == 'TODOS' || ubicacion == '' || apertura== ''){
		errorMessage = 'Necesita completar los campos para generar el reporte!..';
	}
	var parametros = {"cliente":cliente,"ubicacion":ubicacion,"apertura" : apertura,
	"contratacion":contratacion,"usuario":usuario};
	if(errorMessage == ''){
		$.ajax({
			data:  parametros,
			url:   'ajax/Add_planif_servicio_min.php',
			type:  'post',
			beforeSend: function(){
				$("#modal_contenidoRP").html('');
				$('#modalRP').show();
				$("#RP").html('<img src="imagenes/loading3.gif" border="null" class="imgLink" width="30px" height="30px"> Procesando...');
				$("#cod_contratacion_serv").val($("#planif_contratacion").val());
			},
			success:  function (response) {
				var resp = JSON.parse(response);
				if(typeof resp['servicio'] == 'undefined'){
					$("#RP" ).html('Sin Resultados!..');
				}else{
					if(detalle == 'T'){
						rp_planif_trab_serv_detalle(resp,'modal_contenidoRP',()=>$('#body_planif').val($('#t_reporte').html()));
					}else if(detalle == 'F'){
						rp_planif_trab_serv(resp,'modal_contenidoRP',()=>$('#body_planif').val($('#t_reporte').html()));
					}
					$("#RP" ).html('');
				}
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);}
			});
	}else{
		alert(errorMessage);
	}
}

function rp_planif_serv_rp(tipo,id_tabla){
	$('#body_planif').val($('#'+id_tabla).html());
	$("#reporte_serv").val(tipo);
	$("#add_planif_serv_modal").submit();
}