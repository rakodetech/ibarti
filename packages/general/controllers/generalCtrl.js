var tabla,titulo = "";

function Cons_maestro(cod, metodo,tb,tit){
	var error        = 0;
	var errorMessage = ' ';
	tabla=tb;
	titulo=tit;
	if(error == 0){
		CloseModal();
		var parametros = { "codigo" : cod, "metodo": metodo, "titulo": titulo, "tb": tabla};
		$.ajax({
			data:  parametros,
			url:   'packages/general/views/maestros.php',
			type:  'post',
			success:  function (response) {
				$("#Cont_maestro").html(response);
				if(metodo == "modificar"){
					$('#borrar_maestro').show();
					$('#agregar_maestro').show();
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

function guardar_registro(){

	var codigo = $('#codigo').val();
	var descripcion = $('#descripcion').val();
	var campo01 = $('#campo01').val();
	var campo02 = $('#campo02').val();
	var campo03 = $('#campo03').val();
	var campo04 = $('#campo04').val();
	var usuario = $('#usuario').val();
	var activo  = $('#activo').val();
	var metodo = $("#maestro_metodo").val();
	var parametros = {

		'codigo':codigo,
		'descripcion':descripcion,
		'campo01':campo01,
		'campo02':campo02,
		'campo03':campo03,
		'campo04':campo04,
		'tabla':tabla,
		'usuario':usuario,
		'activo':activo,
		'metodo':metodo

	}
	
	$.ajax({
		data:  parametros,
		url:   'packages/general/modelo/sc_maestros.php',
		type:  'post',
		success:  function (response) {
			var resp = JSON.parse(response);
			if(resp.error){
				toastr.error(resp.mensaje);
			}else{
				toastr.success("Actualizacion Exitosa!..");
				if(metodo=="modificar"){
					Cons_maestro(codigo,metodo,tabla,titulo);
				}else{
					Cons_maestro("","agregar",tabla,titulo);
				}
			}
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);}
		});
}

function B_maestros(){
	ModalOpen();
	$.ajax({
		data: {"tb": tabla,"data": null,"titulo": titulo,"tabla": tabla},
		url:   'packages/general/views/Cons_maestros.php',
		type:  'POST',
		beforeSend: function(){
			$("#contenido_tabla").html('<img src="imagenes/loading3.gif" border="null" class="imgLink" width="30px" height="30px">');
		},
		success:  function (response) {
			$("#filtro").val("");
			$("#modal_titulo").text("Buscar "+titulo);
			$("#contenido_tabla" ).html(response);
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);}
		});
}

function buscar(data){
	var parametros = {"tb": tabla,"data": data,"titulo": titulo};
	$.ajax({
		data: parametros,
		url:   'packages/general/views/Cons_maestros.php',
		type:  'POST',
		beforeSend: function(){
			$("#contenido_tabla").html('<img src="imagenes/loading3.gif" border="null" class="imgLink" width="30px" height="30px">');
		},
		success:  function (response) {
			$("#contenido_tabla" ).html(response);
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);}
		});
}


function borrarMaestro(){
	if(confirm('Esta seguro que desea BORRAR este Registro?..')){
		var usuario = $("#usuario").val();
		var cod = $("#codigo").val();
		var parametros = {
			"codigo": cod, "tabla": tabla,
			"usuario": usuario
		};
		$.ajax({
			data: parametros,
			url: 'packages/general/controllers/sc_borrar.php',
			type: 'post',
			success: function (response) {
				var resp = JSON.parse(response);
				if (resp.error) {
					toastr.error(resp.mensaje);
				} else {
					toastr.success('Registro Eliminado con exito!..');
					Cons_maestro("", 'agregar',tabla,titulo);
				}
			},
			error: function (xhr, ajaxOptions, thrownError) {
				toastr.warning(xhr.status+"  "+thrownError);
			}
		});
	}
}
//Funcion para ir a la vista Agregar, cuanto se esta en Modificar X
function irAAgregarMaestro(){
	var msg = "Desea Agregar un NUEVO REGISTRO?.. ";
	if(confirm(msg)) Cons_maestro("", "agregar",tabla,titulo);
}
