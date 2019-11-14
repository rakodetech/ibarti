$(function() {
	Cons_perfil_inicio(()=>{
		mostrar_clasif();
	});
});

function Cons_perfil_inicio(callback) {
	var parametros = { }
	$.ajax({
		data:  parametros,
		url:   'packages/mant/novedades/perfiles/views/Cons_inicio.php',
		type:  'post',
		success:  function (response) {
			$("#Contenedor").html(response);
			if(typeof callback == 'function') callback();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);}
		});
}

function mostrar_clasif() {
	var parametros = { }
	$.ajax({
		data:  parametros,
		url:   'packages/mant/novedades/perfiles/views/Get_clasif.php',
		type:  'post',
		success:  function (response) {
			$("#clasif").html(response);
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);}
		});
}

function Cons_perfil_form(clasif,callback) {
	var parametros = { codigo: clasif }
	$.ajax({
		data:  parametros,
		url:   'packages/mant/novedades/perfiles/views/Add_form.php',
		type:  'post',
		success:  function (response) {
			$("#Contenedor_det").html(response);
			if(typeof callback == 'function') callback();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);}
		});
}

function actualizar(tipo,perfil){
	var proced = 'p_perfil_nov';
	var clasif = $("#nov_clasif").val();
	var usuario = $("#usuario").val();
	var status = 'F';
	if($('#'+tipo+perfil).is(':checked')){
		status = 'T';
	}
	var parametros = { tipo: tipo, perfil: perfil, clasif: clasif, 
		proced: proced, status: status, usuario: usuario };

		$.ajax({
			data:  parametros,
			url:   'packages/mant/novedades/perfiles/modelo/procesar.php',
			type:  'post',
			success:  function (response) {
				var resp = JSON.parse(response);
				if(resp.error){
					toastr.error(resp.mensaje);
				}else{
					toastr.success('Actualizacion Exitosa!..');
				}

			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);}
			});

	}