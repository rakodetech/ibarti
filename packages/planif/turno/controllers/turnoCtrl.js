$(function() {
	Cons_turno('', 'agregar');
});

function Cons_turno(cod, metodo){
	var usuario      = $("#usuario").val();
	var error        = 0;
	var errorMessage = ' ';
	if(error == 0){
		var parametros = { "codigo" : cod,
		"metodo": metodo,    "usuario": usuario   };
		$.ajax({
			data:  parametros,
			url:   'packages/planif/turno/views/Add_form.php',
			type:  'post',
			success:  function (response) {
				$("#Cont_turno").html(response);
				if(metodo == "modificar"){
					//Desabilito el campo codigo, para evitar errores de INSERT
					$("#t_codigo").attr('disabled',true);
					//Si el metodo es modificar muestro los botones AGREGAR Y ELIMINAR
					$('#borrar_turno').show();
					$('#agregar_turno').show();
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


function save_turno(){
	var error = 0;
	var errorMessage = ' ';
	var proced       = "p_turno";

	var codigo          = $("#t_codigo").val();
	var abrev           = $("#t_abrev").val();
	var nombre          = $("#t_nombre").val();
	var d_habil         = $("#t_d_habil").val();
	var horario         = $("#t_horario").val();
	var factor          = $('input:radio[name=t_factor]:checked').val();
	var trab_cubrir     = $("#t_trab_cubrir").val();

	var status       = Status($("#t_activo:checked").val());
	var usuario      = $("#usuario").val();
	var metodo       = $("#t_metodo").val();

	if(error == 0){
		var parametros = "X";
		var parametros = {"codigo": codigo, 	  			"status": status,
		"nombre": nombre,           "abrev" : abrev,
		"d_habil": d_habil,         "horario": horario ,
		"factor": factor ,          "trab_cubrir": trab_cubrir ,
		"proced": proced, 					"usuario": usuario,
		"metodo":metodo };
		$.ajax({
			data:  parametros,
			url:   'packages/planif/turno/modelo/turno.php',
			type:  'post',
			success:  function (response) {
				var resp = JSON.parse(response);
				if(resp.error){
					alert(resp.mensaje);
				}else{
					if(metodo == "agregar") {
						if(confirm("Actualización Exitosa!.. \n Desea AGREGAR un NUEVO REGISTRO?")){
							Cons_turno("", "agregar");
						}else{
							//Cambio el metodo a 'modificar'
							$("#t_metodo").val('modificar');
							//Cambio el titulo de Agregar X a Modificar X
							var string = $("#title_turno").text().split("Agregar").join("Modificar");  
							$("#title_turno").text(string);
							//Desabilito el campo Código hasta que el formulario sufra cambios
							$("#t_codigo").attr('disabled',true);	
							//Ya que el metodo es modificar muestro los botones AGREGAR Y ELIMINAR
							$('#borrar_turno').show();
							$('#agregar_turno').show();
						}
					}else if(metodo == "modificar"){
						alert("Actualización Exitosa!..");
					}
					//Cambio la propiedad type del boton de RESTABLECER de reset a button
					//para Evitar errores de historial y a su evento click le una funcion que cargue 
					//los datos de el registro que contenga el codigo actual y asi restablecer los valores
					$('#limpiar_turno').prop('type', 'button');
					$("#limpiar_turno").click(function(){ Cons_turno(codigo, 'modificar'); });
					//Paso a false el input que almacena el valor que indica si el formulario a sufrido cambios
					$("#t_cambios").val('false');
					//Desabilito el boton guardar hasta que el formulario sufra cambios
					$('#salvar_turno').attr('disabled',true);
					//Reinicio la tabla de busqueda para que se muestre con la modificacion, 
					//con el parametro en true para no cambiar de vista.
					buscar_turno(true);
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

function Borrar_turno(){
	if(confirm('Esta seguro que desea BORRAR este Registro?..')){
		var usuario = $("#usuario").val();
		var cod = $("#t_codigo").val();
		var parametros = {
			"codigo": cod, "tabla": "turno",
			"usuario": usuario
		};
		$.ajax({
			data: parametros,
			url: 'packages/general/controllers/sc_borrar.php',
			type: 'post',
			success: function (response) {
				var resp = JSON.parse(response);
				if (resp.error) {
					alert(resp.mensaje);
				} else {
					//Paso el parametro false para que cambie de vista buscar_turno(isBuscar)->if(!isBuscar){...
					buscar_turno(false);
					alert('Registro Eliminado con exito!..');

					//cambio la funcion del evento click del boton Volver para evitar errores de historial
					//volver_turno -> Cons_turno('', 'agregar'), para asi no mostrar los datos del registro antes
					//eliminado y mostrar la vista Agregar X
					$("#volver_turno").click(function(){ Cons_turno('', 'agregar'); });
				}
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
			}
		});
	}
}

// Modal
function B_d_habil(){
	ModalOpen();
	$("#modal_titulo").text("Consultar Día Hábil");
	$("#modal_contenido").html("");
	var usuario      = $("#usuario").val();
	var parametros = { "Nmenu" : 301, "usuario" : usuario};
	$.ajax({
		data:  parametros,
		url:   'packages/planif/dia_habil/index.php',
		type:  'post',
		success:  function (response) {
			$( "#modal_contenido" ).html( response);
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);}
		});
}

function B_hora(){
	ModalOpen();
	$("#modal_titulo").text("Consultar turno");
	$("#modal_contenido").html("");
	var usuario      = $("#usuario").val();
	var parametros = { "Nmenu" : 301, "usuario" : usuario};
	$.ajax({
		data:  parametros,
		url:   'packages/planif/horario/index.php',
		type:  'post',
		success:  function (response) {
			$( "#modal_contenido" ).html( response);
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);}
		});
}

function irABuscarTurno(){

	// Oculto la vista Agregar X y Muestro la vista Buscar X 
	$('#add_turno').hide();
	$('#buscar_turno').show();
}

////Funcion para ir a la vista Agregar, cuanto se esta en 
//Buscar X y previamente no se ha modificado ningún registro
function volverTurno(){
	// Oculto la vista Buscar X y Muestro la vista Agregar X 
	$('#add_turno').show();
	$('#buscar_turno').hide();
}


function buscar_turno(isBuscar) {
	var data = $('#data_buscar_turno').val() || '';
	var filtro = $('#filtro_buscar_turno').val() || '';
	$.ajax({
		data: {'data':data,'filtro':filtro},
		url: 'packages/planif/turno/views/Buscar_turnos.php',
		type: 'post',
		beforeSend: function(){
			//Deshabilito el submit del form Buscar X
			$('#buscarHTurno').attr('disabled',true);
			//Deshabilito el boton(img) de form Buscar X
			$('#buscarT').attr('disabled',true);
			//Cambio la imagen del boton Buscar X
			$('#buscarT').prop('src',"imagenes/loading3.gif");
		},
		success: function (response) {
			// Oculto la vista Agregar X y Muestro la vista Buscar X 
			//solo cuando estoy fuera de la vista Buscar X (lógico)
			if(!isBuscar){
				$('#add_turno').hide();
				$('#buscar_turno').show();
			}
			//Limpio el cuerpo de la tabla con los turnos y pinto el resultado de la busqueda
			$("#lista_turnos tbody tr").remove();
			$("#lista_turnos tbody").html(response);

			//habilito el boton(img) de form Buscar X
			$('#buscarTurno').attr('disabled',false);
			//Habilito el submit del form Buscar X
			$('#buscarT').attr('disabled',false);
			//Restablesco la imagen por defecto del boton buscar X
			$('#buscarT').prop('src',"imagenes/buscar.bmp");
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			$('#buscarHorario').attr('disabled',false);
			$('#buscarH').attr('disabled',false);
			$('#buscarH').prop('src',"imagenes/buscar.bmp");
		}
	});
}

//Funcion para ir a la vista Agregar, cuanto se esta en Modificar X
function irAAgregarTurno(){
	var msg = "Desea Agregar un NUEVO REGISTRO?.. ";
	//Obtengo el valor que define si el formulario a sufrido cambios, para definir el mensaje de confirmacion
	var cambiosSinGuardar =  $("#t_cambios").val();
	if(cambiosSinGuardar == "true") msg = 'Puede haber cambios sin guardar en el formulario, ¿Desea agregar un NUEVO Registro de todas formas?.';
	if(confirm(msg)) Cons_turno('', 'agregar');
}

