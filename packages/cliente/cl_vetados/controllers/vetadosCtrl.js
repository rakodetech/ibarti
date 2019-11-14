var usuario    = "";
var cliente    = "";

$(function() {
	Cons_vetados_inicio();
});

function Cons_vetados_inicio(){

	usuario      = $("#usuario").val();
	cliente      = $("#cont_cliente").val();

	var error        = 0;
	var errorMessage = ' ';
	if(error == 0){
		var parametros = { "cliente":  cliente};

		$.ajax({
			data:  parametros,
			url:   'packages/cliente/cl_vetados/views/Cons_inicio.php',
			type:  'post',
			success:  function (response) {
				$("#Cont_vetados").html(response);
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);}
			});

	}else{
		alert(errorMessage);
	}

}

function Cons_vetado(cod, ubic,metodo){
	var error        = 0;
	var errorMessage = ' ';
	if(error == 0){
		cliente      = $("#cont_cliente").val();
		var parametros = { "codigo" : cod, "metodo": metodo,"cliente":cliente,"ubicacion":ubic };
		$.ajax({
			data:  parametros,
			url:   'packages/cliente/cl_vetados/views/Add_form.php',
			type:  'post',
			success:  function (response) {
				$("#add_vetado").show();
				$("#modal_titulo_add_vetado").text("vetado");
				$("#modal_contenido_add_vetado").html(response);
				/*if(metodo == "modificar"){
					CargarDetalleCont(cod);
				}*/
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);}
			});
	}else{
		alert(errorMessage);
	}
}

function Add_vetado(cod,metodo){
	var error        = 0;
	var errorMessage = ' ';
	if(error == 0){
		var parametros = { "cliente" : cod, "metodo": metodo };
		$.ajax({
			data:  parametros,
			url:   'packages/cliente/cl_vetados/views/Add_vetado.php',
			type:  'post',
			success:  function (response) {
				$("#add_vetado").show();
				$("#modal_titulo_add_vetado").text("Agregar vetado");
				$("#modal_contenido_add_vetado").html(response);
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);}
			});
	}else{
		alert(errorMessage);
	}
}


function add_vetados(){
	var error = 0;
	var errorMessage = ' ';
	var codigo       = $("#vet_ficha").val();
	var comentario  = $("#comentario_add_vetado").val();
	var ubicacion = $("#vet_ubicacion").val();
	var proced     = "p_vetado";
	var metodo     = "agregar";
	var usuario     = $("#usuario").val();
	var cliente      = $("#cont_cliente").val();

	if(error == 0){
		var parametros = {"codigo": codigo,"cliente": cliente,"ubicacion": ubicacion,  
		"comentario" :comentario,"proced": proced,"usuario": usuario,"metodo":metodo
	};
	$.ajax({
		data:  parametros,
		url:   'packages/cliente/cl_vetados/modelo/vetado.php',
		type:  'post',
		success:  function (response) {
			var content = JSON.parse(response);
			if(content.error){
				alert(content.mensaje);
			}else{
				alert("Actualizacion Exitosa!..");
				Cons_vetados_inicio();
				$("#add_vetado").hide();
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

function getTrab(){
	var error = 0;
	var errorMessage = ' ';
	var ubicacion = $("#vet_ubicacion").val();
	var cliente      = $("#cont_cliente").val();
	if(error == 0){
		var parametros = {"cliente": cliente,"ubicacion": ubicacion};
	$.ajax({
		data:  parametros,
		url:   'packages/cliente/cl_vetados/views/Cons_vetados.php',
		type:  'post',
		success:  function (response) {
			$("#td_vet_ficha").html(response);
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);}
		});
}else{
	alert(errorMessage);
}
}

function update_vetado(cod_ficha,ubic){
	var error = 0;
	var errorMessage = ' ';
	var codigo       = cod_ficha;
	var comentario  = $("#comentario_vet").val();
	var cliente      = $("#cont_cliente").val();
	var ubicacion = ubic;
	var proced     = "p_vetado";
	var metodo     = "modificar";
	var usuario     = $("#usuario").val();

	if(error == 0){
		var parametros = {"codigo": codigo,"cliente": cliente,"ubicacion": ubicacion,  
		"comentario" :comentario,"proced": proced,"usuario": usuario,"metodo":metodo
	};
	$.ajax({
		data:  parametros,
		url:   'packages/cliente/cl_vetados/modelo/vetado.php',
		type:  'post',
		success:  function (response) {
			var content = JSON.parse(response);
			if(content.error){
				alert(content.mensaje);
			}else{
				alert("Actualizacion Exitosa!..");
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

function Borrar_vetado(cod_ficha,cod_ubicacion){
	if (confirm("¿ Esta Seguro De Borrar este Registro ?")) {
		var usuario = $("#usuario").val();
		var metodo = "borrar";
		var proced = "p_vetado";
		var cliente = $('#cont_cliente').val();
		var parametros = {"codigo": cod_ficha,"cliente": cliente,"ubicacion": cod_ubicacion,  
		"comentario":'Borrar',"proced": proced,"usuario": usuario,"metodo":metodo};
	$.ajax({
		data:  parametros,
		url:   'packages/cliente/cl_vetados/modelo/vetado.php',
		type:  'post',
		success:  function (response) {
			var content = JSON.parse(response);
			if(content.error){
				alert(content.mensaje);
			}else{
				alert("Actualizacion Exitosa!..");
				Cons_vetados_inicio();
				$("#add_vetado").hide();
			}
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);}
		});
}
}