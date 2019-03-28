
$(function() {
	Cons_dia_habil('', 'agregar');
});

function Cons_dia_habil(cod, metodo){
	var usuario      = $("#usuario").val();
	var error        = 0;
	var errorMessage = ' ';
	if(error == 0){
		var parametros = { "codigo" : cod,
		"metodo": metodo,    "usuario": usuario };
		$.ajax({
			data:  parametros,
			url:   'packages/planif/dia_habil/views/Add_form.php',
			type:  'post',
			success:  function (response) {
				$("#Cont_dia_habil").html(response);
				if(metodo == "modificar"){
				//Si el metodo es modificar muestro los botones AGREGAR Y ELIMINAR
				$('#borrar_dia_habil').show();
				$('#agregar_dia_habil').show();

				var tipo = $("#dh_clasif").val();
				Add_dh_det(tipo);
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

function save_dia_habil(){

	var error = 0;
	var errorMessage = ' ';
	var proced     = "p_dia_habil";
	var dias = new Array();

	$("input[name='DIAS[]']:checked").each(function() {
		dias.push($(this).val());
	});
	if(dias.length > 0){
		var codigo       = $("#dh_codigo").val();
		var descripcion  = $("#dh_descripcion").val();
		var tipo         = $("#dh_clasif").val();
		var status       = Status($("#dh_status:checked").val());
		var usuario      = $("#usuario").val();
		var metodo       = $("#dh_metodo").val();
		if(error == 0){
			var parametros = {"codigo": codigo, 	  		  "status": status,
			"descripcion": descripcion, "tipo" : tipo,
			"dias": dias,
			"proced": proced, 					"usuario": usuario,
			"metodo":metodo};

			$.ajax({
				data:  parametros,
				url:   'packages/planif/dia_habil/modelo/dia_habil.php',
				type:  'post',
				success:  function (response) {
					var resp = JSON.parse(response);
					if(resp.error){
						alert(resp.mensaje);
					}else{
						alert("Actualización Exitosa!..");
						if(metodo == "agregar") Cons_dia_habil("", "agregar");
					//Cambio la propiedad type del boton de RESTABLECER de reset a button
					//para Evitar errores de historial y a su evento click le una funcion que cargue 
					//los datos de el registro que contenga el codigo actual y asi restablecer los valores
					$('#limpiar_dia_habil').prop('type', 'button');
					$("#limpiar_dia_habil").click(function(){ Cons_dia_habil(codigo, 'modificar'); });
					//Paso a false el input que almacena el valor que indica si el formulario a sufrido cambios
					$("#dh_cambios").val('false');
					//Desabilito el boton guardar hasta que el formulario sufra cambios
					$('#salvar_dia_habil').attr('disabled',true);
					//Reinicio la tabla de busqueda para que se muestre con la modificacion, 
					//con el parametro en true para no cambiar de vista.
					buscar_dia_habil(true);

				}
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);}
			});
		}else{
			alert(errorMessage);
		}

	}else{
		alert("Por favor ingrese los DIAS a APERTURAR antes de GUARDAR..");
	}
}

function Borrar_dia_habil(){
	if(confirm('Esta seguro que desea BORRAR este Registro?..')){
		var usuario = $("#usuario").val();
		var cod = $("#dh_codigo").val();
		var parametros = {
			"codigo": cod, "tabla": "dias_habiles",
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
									//Paso el parametro false para que cambie de vista buscar_dia_habil(isBuscar)->if(!isBuscar){...
										buscar_dia_habil(false);
										alert('Registro Eliminado con exito!..');

					//cambio la funcion del evento click del boton Volver para evitar errores de historial
					//volver__dia_habil -> Cons_dia_habil('', 'agregar'), para asi no mostrar los datos del registro antes
					//eliminado y mostrar la vista Agregar X
					$("#volver_dia_habil").click(function(){ Cons_dia_habil('', 'agregar'); });
				}
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
			}
		});
	}

}


function Add_dh_det(cod){
	var codigo       = $("#dh_codigo").val();
	var usuario      = $("#usuario").val();

	var parametros = { "codigo" : codigo,   "cod_dia_tipo" : cod,
	"usuario": usuario   };
	$.ajax({
		data:  parametros,
		url:   'packages/planif/dia_habil/views/Add_dia.php',
		type:  'post',
		success:  function (response) {
			$("#Cont_dh_det").html(response);
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);}
		});
}

function buscar_dia_habil(isBuscar) {
	var data = $('#data_buscar_dia_habil').val() || '';
	var filtro = $('#filtro_buscar_dia_habil').val() || '';
	$.ajax({
		data: {'data':data,'filtro':filtro},
		url: 'packages/planif/dia_habil/views/Buscar_dia_habil.php',
		type: 'post',

		beforeSend: function(){
		//Deshabilito el submit del form Buscar X
		$('#buscarDiaHabil').attr('disabled',true);
		//Deshabilito el boton(img) de form Buscar X
		$('#buscarDH').attr('disabled',true);
		//Cambio la imagen del boton Buscar X
		$('#buscarDH').prop('src',"imagenes/loading3.gif");
	},
	success: function (response) {
				// Oculto la vista Agregar X y Muestro la vista Buscar X 
				//solo cuando estoy fuera de la vista Buscar X (lógico)
				if(!isBuscar){
					$('#add_dia_habil').hide();
					$('#buscar_dia_habil').show();
				}
				//Limpio el cuerpo de la tabla con los dia_habil y pinto el resultado de la busqueda
				$("#lista_dia_habil tbody tr").remove();
				$("#lista_dia_habil tbody").html(response);
					//habilito el boton(img) de form Buscar X
					$('#buscarDiaHabil').attr('disabled',false);
		//Habilito el submit del form Buscar X
		$('#buscarDH').attr('disabled',false);
		//Restablesco la imagen por defecto del boton buscar X
		$('#buscarDH').prop('src',"imagenes/buscar.bmp");
	},
	error: function (xhr, ajaxOptions, thrownError) {
		alert(xhr.status);
		alert(thrownError);
		
		$('#buscarDiaHabil').attr('disabled',false);
		$('#buscarDH').attr('disabled',false);
		$('#buscarDH').prop('src',"imagenes/buscar.bmp");
	}
});
}

	//Funcion para ir a la vista Agregar, cuanto se esta en Modificar X
	function irAAgregarDia_habil(){
		var msg = "Desea Agregar un NUEVO REGISTRO?.. ";
//Obtengo el valor que define si el formulario a sufrido cambios, para definir el mensaje de confirmacion
var cambiosSinGuardar =  $("#dh_cambios").val();
if(cambiosSinGuardar == "true") msg = 'Puede haber cambios sin guardar en el formulario, ¿Desea agregar un NUEVO Registro de todas formas?.';
if(confirm(msg)) Cons_dia_habil('', 'agregar');
}

////Funcion para ir a la vista Agregar, cuanto se esta en 
//Buscar X y previamente no se ha modificado ningún registro
function volverDiaHabil(){
// Oculto la vista Buscar X y Muestro la vista Agregar X 
$('#add_dia_habil').show();
$('#buscar_dia_habil').hide();
}

function irABuscarDia_habil(){
// Oculto la vista Agregar X y Muestro la vista Buscar X 
$('#add_dia_habil').hide();
$('#buscar_dia_habil').show();
}