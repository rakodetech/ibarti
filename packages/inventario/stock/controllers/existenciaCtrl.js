$(function () {
	Cons_existencia();
});

function Cons_existencia() {
	var parametros = { }
	$.ajax({
		data:  parametros,
		url:   'packages/inventario/stock/views/Cons_inicio.php',
		type:  'post',
		success:  function (response) {
			$("#Cont_existencia").html(response);
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);}
		});
} 


function Actualizar_sub_linea(linea){
	var parametros = { "linea": linea };
	$.ajax({
		data:  parametros,
		url:   'packages/inventario/stock/views/Add_sub_linea.php',
		type:  'post',
		success:  function (response) {
			$("#sub_lineas").html(response);
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);}
		});
}

function Actualizar_productos(sub_linea){
	var parametros = { "sub_linea": sub_linea }
	$.ajax({
		data:  parametros,
		url:   'packages/inventario/stock/views/Add_productos.php',
		type:  'post',
		success:  function (response) {
			$("#productos").html(response);
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);}
		});
}

function Actualizar_almacenes(producto){
	var parametros = { "producto": producto }
	$.ajax({
		data:  parametros,
		url:   'packages/inventario/stock/views/Add_almacenes.php',
		type:  'post',
		success:  function (response) {
			$("#almacenes").html(response);
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);}
		});
}

function buscar_existencia(){
	var producto_cod = $("#prod_producto").val();
	var almacen_cod = $("#prod_almacen").val();
	var linea_cod = $("#prod_linea").val();
	var sub_linea_cod = $("#prod_sub_linea").val();
	var parametros = { "producto": producto_cod,"almacen": almacen_cod,"linea": linea_cod,
	"sub_linea": sub_linea_cod }
	$.ajax({
		data:  parametros,
		url:   'packages/inventario/stock/views/Buscar_existencia.php',
		type:  'post',
		beforeSend: function(){
			$("#listar_stock").html('<img src="imagenes/loading3.gif" border="null" class="imgLink" width="30px" height="30px">');
		},
		success:  function (response) {
			$("#listar_stock").html(response);
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);}
		});
}

function Generar_reporte(valor){  // CARGAR  ARCHIVO DE AJAX CON UN PARAMETRO //
	$( "#generar_tipo").val(valor);
	$( "#reporte_submit" ).trigger( "click" );
}
