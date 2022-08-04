$(function () {
	Cons_perfil_inicio(() => {
		mostrar_perfiles();
	});
});

function Cons_perfil_inicio(callback) {
	var parametros = {}
	$.ajax({
		data: parametros,
		url: 'packages/mant/perfil_cargos/views/Cons_inicio.php',
		type: 'post',
		success: function (response) {
			$("#Contenedor").html(response);
			if (typeof callback == 'function') callback();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
		}
	});
}

function mostrar_perfiles() {
	var parametros = {}
	$.ajax({
		data: parametros,
		url: 'packages/mant/perfil_cargos/views/Get_perfiles.php',
		type: 'post',
		success: function (response) {
			$("#perfiles").html(response);
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
		}
	});
}

function Cons_perfil_form(clasif, callback) {
	var parametros = { codigo: clasif }
	$.ajax({
		data: parametros,
		url: 'packages/mant/perfil_cargos/views/Add_form.php',
		type: 'post',
		success: function (response) {
			$("#Contenedor_det").html(response);
			if (typeof callback == 'function') callback();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
		}
	});
}

function actualizar(cargo) {
	var perfil = $("#perfil").val();
	var usuario = $("#usuario").val();
	var status = 'F';
	if ($('#' + cargo).is(':checked')) {
		status = 'T';
	}
	var parametros = {
		cargo: cargo, perfil: perfil, estatus: status, usuario: usuario
	};

	$.ajax({
		data: parametros,
		url: 'packages/mant/perfil_cargos/modelo/procesar.php',
		type: 'post',
		success: function (response) {
			var resp = JSON.parse(response);
			if (resp.error) {
				toastr.error(resp.mensaje);
			} else {
				toastr.success('Actualizacion Exitosa!..');
			}

		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
		}
	});

}