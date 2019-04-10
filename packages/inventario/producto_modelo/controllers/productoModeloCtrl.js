$(function() {
	Cons_producto_modelo('', 'agregar');
});

function Cons_producto_modelo(cod, metodo){
	var error        = 0;
	var errorMessage = ' ';
	if(error == 0){
		var parametros = { "codigo" : cod, "metodo": metodo};
		$.ajax({
			data:  parametros,
			url:   'packages/inventario/producto_modelo/views/Add_form.php',
			type:  'post',
			success:  function (response) {
				$("#Cont_producto_modelo").html(response);
				$('#p_metodo').val(metodo);
				if(metodo == "modificar"){
					$("#p_codigo").attr('disabled',true);
					$('#borrar_producto_modelo').show();
					$('#agregar_producto_modelo').show();
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

function save_producto_modelo(){

	var error = 0;
	var errorMessage 	= ' ';
	var proced       	= "p_producto_modelo";

	var codigo          = $("#p_codigo").val();
	var linea           = $("#p_linea").val();
	var sub_linea       = $("#p_sub_linea").val();
	var prod_tipo       = $("#p_prod_tipo").val();
	var unidad     		= $("#p_unidad").val();
	var proveedor     	= $("#p_proveedor").val();
	var iva     		= $("#p_iva").val();
	var descripcion     = $("#p_descripcion").val();
	var procedencia     = $("#p_procedencia").val();

	var activo       	= Status($("#p_activo:checked").val());
	var usuario      	= $("#usuario").val();
	var metodo       	= $("#p_metodo").val();

	if(error == 0){
		var parametros = {"codigo": codigo, "activo": activo, "linea": linea,         
		"sub_linea" : sub_linea, "color": color,         "prod_tipo": prod_tipo ,
		"unidad": unidad , "proveedor": proveedor , "iva": iva , "descripcion": descripcion ,
		"procedencia": procedencia, "proced": proced, "usuario": usuario, "metodo":metodo };

		$.ajax({
			data:  parametros,
			url:   'packages/inventario/producto_modelo/modelo/producto_modelo.php',
			type:  'post',
			success:  function (response) {
				var resp = JSON.parse(response);
				if(resp.error){
					alert(resp.mensaje);
				}else{
					if(metodo == "agregar") {
						if(confirm("Actualización Exitosa!.. \n Desea AGREGAR un NUEVO REGISTRO?")){
							Cons_producto_modelo("", "agregar");
						}else{
							Cons_producto_modelo(codigo, "modificar");
						}
					}else if(metodo == "modificar"){
						alert("Actualización Exitosa!..");
					}
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

function get_sub_lineas(linea){
	var parametros = {
		"codigo": linea
	};
	$.ajax({
		data: parametros,
		url: 'packages/inventario/producto/views/Add_sub_linea.php',
		type: 'post',
		success: function (response) {
			$("#sub_linea").html(response);
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
		}
	});
}

function Borrar_producto(){
	if(confirm('Esta seguro que desea BORRAR este Registro?..')){
		var usuario = $("#usuario").val();
		var cod = $("#p_codigo").val();
		var parametros = {
			"codigo": cod, "tabla": "productos",
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
					alert('Registro Eliminado con exito!..');
					Cons_producto_modelo('', 'agregar');
				}
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
			}
		});
	}
}

function B_productos(){
	var parametros = {};
	$.ajax({
		data:  parametros,
		url:   'packages/inventario/producto_modelo/views/Cons_productos.php',
		type:  'post',
		success:  function (response) {
			$("#add_producto_modelo").hide();
			$("#buscar_producto_modelo").show();
			$("#lista_productos_modelo").html(response);
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);}
		});
}
//Funcion para ir a la vista Agregar, cuanto se esta en Modificar X
function irAAgregarProductoModelo(){
	var msg = "Desea Agregar un NUEVO REGISTRO?.. ";
	if(confirm(msg)) Cons_producto_modelo('', 'agregar');
}

function volver(){
	$("#buscar_producto_modelo").hide();
	$("#add_producto_modelo").show();
}

function get_propiedades(sub_linea){
	var parametros = {
		"codigo": sub_linea
	};
	$.ajax({
		data: parametros,
		url: 'packages/inventario/producto/views/Add_modelo.php',
		type: 'post',
		success: function (response) {
			$("#modelo").html(response);
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
		}
	});
}