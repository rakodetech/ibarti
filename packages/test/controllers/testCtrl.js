$(function () {
	Cons_existencia();
});

function Cons_existencia() {
	var parametros = { }
	$.ajax({
		data:  parametros,
		url:   'packages/test/views/Cons_inicio.php',
		type:  'post',
		success:  function (response) {
			$("#Cont_test").html(response);
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);}
		});
} 

function Cons_test(cod, metodo) {
	var usuario = $("#usuario").val();
	var error = 0;
	var errorMessage = ' ';
	if (error == 0) {
		var parametros = {
			"id": cod,
			"metodo": metodo, "usuario": usuario
		};
		$.ajax({
			data: parametros,
			url: 'packages/test/views/Add_form.php',
			type: 'post',
			success: function (response) {
				$("#Cont_test").html(response);
				if(metodo == "modificar"){
					//Desabilito el campo codigo, para evitar errores de INSERT
					$("#t_id").attr('disabled',true);
					//Si el metodo es modificar muestro los botones AGREGAR Y ELIMINAR
					$('#borrar_test').show();
					$('#agregar_test').show();
				}
			}
			,
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
			}
		});
	} else {
		alert(errorMessage);
	}
}

function save_test() {
	var error = 0;
	var errorMessage = ' ';
	var proced = "p_test";

	var id = $("#t_cid").val();
	var descripcion = $("#t_descripcion").val();
	var estado;
	if( $('#activo').is(':checked') ) {
    	estado = 'T';
	}else{
		estado = 'F';
	}
	var usuario = $("#usuario").val();
	var metodo = $("#t_metodo").val();

	if (error == 0) {
		var parametros = "X";
		var parametros = {
			"id": id, "descripcion": descripcion,
			"estado": estado,
			"proced": proced, "usuario": usuario,
			"metodo": metodo
		};

		$.ajax({
			data: parametros,
			url: 'packages/test/modelo/test.php',
			type: 'post',
			success: function (response) {
				var resp = JSON.parse(response);
				if (resp.error) {
					alert(resp.mensaje);
				} else {
					if(metodo == "agregar") {
						if(confirm("Actualización Exitosa!.. \n Desea AGREGAR un NUEVO REGISTRO?")){
							Cons_test("", "agregar");
						}else{
							$("#t_metodo").val('modificar');
							var string = $("#title_test").text().split("Agregar").join("Modificar");
							$("#title_test").text(string);
						}
					}else if(metodo == "modificar"){
						alert("Actualización Exitosa!..");
					}
				}
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
