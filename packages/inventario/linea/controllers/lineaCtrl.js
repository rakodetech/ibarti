$(function() {
	Cons_linea('', 'agregar');
});

function Cons_linea(cod, metodo){
	var error        = 0;
	var errorMessage = ' ';
	if(error == 0){
		var parametros = { "codigo" : cod, "metodo": metodo};
		$.ajax({
			data:  parametros,
			url:   'packages/inventario_ant/linea/views/Add_form.php',
			type:  'post',
			success:  function (response) {
				$("#Cont_linea").html(response);
				$('#l_metodo').val(metodo);
				if(metodo == "modificar"){
					$("#l_linea").attr('disabled',true);
					$('#borrar_linea').show();
					$('#agregar_linea').show();
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

function save_linea(){

	var error = 0;
	var errorMessage 	= ' ';
	var proced       	= "";

	var activo       	= Status($("#l_activo:checked").val());
	var usuario      	= $("#usuario").val();
	var metodo       	= $("#l_metodo").val();

	if(error == 0){
		var parametros = {"codigo": codigo, "activo": activo,
		"proced": proced, "usuario": usuario, "metodo":metodo };

		$.ajax({
			data:  parametros,
			url:   'packages/inventario_ant/linea/modelo/linea.php',
			type:  'post',
			success:  function (response) {
				var resp = JSON.parse(response);
				if(resp.error){
					alert(resp.mensaje);
				}else{
					if(metodo == "agregar") {
						if(confirm("Actualización Exitosa!.. \n Desea AGREGAR un NUEVO REGISTRO?")){
							Cons_linea("", "agregar");
						}else{
							Cons_linea(codigo, "modificar");
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
