
$(function() {
Cons_rotacion_inicio();
});

function Cons_rotacion_inicio(){
	var error        = 0;
	var errorMessage = ' ';
	  if(error == 0){
	    var parametros = {  };
      $.ajax({
          data:  parametros,
          url:   'modulo/rotacion_turno/Cons_inicio.php',
          type:  'post',
          success:  function (response) {
          $("#Cont_rotacion").html(response);
          },
          error: function (xhr, ajaxOptions, thrownError) {
              alert(xhr.status);
              alert(thrownError);}
      });
	  }else{
	    alert(errorMessage);
	  }
}

function Cons_rotacion(cod, metodo){
	var usuario      = $("#usuario").val();
	var error        = 0;
	var errorMessage = ' ';
	  if(error == 0){
	    var parametros = { "codigo" : cod,
			                   "metodo": metodo,    "usuario": usuario   };
      $.ajax({
          data:  parametros,
          url:   'modulo/rotacion_turno/Add_form.php',
          type:  'post',
          success:  function (response) {
          $("#Cont_rotacion").html(response);
						if(metodo == "modificar"){
							CargarDetalle(cod);
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





function save_rotacion(){
	var error = 0;
	var errorMessage = ' ';
	var proced       = "p_rotacion";

	var codigo          = $("#r_codigo").val();
	var abrev           = $("#r_abrev").val();
	var nombre          = $("#r_nombre").val();

	var activo       = $("#activo").val();
	var usuario      = $("#usuario").val();
	var metodo       = $("#h_metodo").val();

	if(error == 0){
		var parametros = "X";
		var parametros = {"codigo": codigo, 	  			"activo": activo,
											"nombre": nombre,           "abrev" : abrev,
											"proced": proced, 					"usuario": usuario,
											"metodo":metodo };
				$.ajax({
						data:  parametros,
						url:   'modulo/rotacion_turno/scripts.php',
						type:  'post',
						success:  function (response) {
							 var resp = JSON.parse(response);
							if(resp.error){
								alert(resp.mensaje);
							}else{
								Cons_rotacion_inicio();
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




	function CargarDetalle(cod){

			var usuario    = $("#usuario").val();
			var parametros = {"codigo" : cod,    "usuario": usuario};

			$.ajax({
					data:  parametros,
					url:   'modulo/rotacion_turno/Add_form_det.php',
					type:  'post',
					success:  function (response) {
						 $("#Cont_detalleR").html(response);


					},
					error: function (xhr, ajaxOptions, thrownError) {
							alert(xhr.status);
							alert(thrownError);}
			});
	}

	function Mostrar_Detalle(cod, cont_id){
		if(cod !=""){
			var usuario    = $("#usuario").val();
			var parametros = {"codigo" : cod,    "usuario": usuario};

			$.ajax({
					data:  parametros,
					url:   'modulo/rotacion_turno/turno_det.php',
					type:  'post',
					success:  function (response) {
					var resp = JSON.parse(response);
					 if(resp.error){
						alert(resp.mensaje);
					 }else{

						 $("#mostrar_detalle").html(response);
					 }

					},
					error: function (xhr, ajaxOptions, thrownError) {
							alert(xhr.status);
							alert(thrownError);}
			});

		}
	}


	function save_det(cod, metodo){

// concatenar el codigo para los otros valores
		var error = 0;
		var errorMessage = ' ';
		var proced       = "p_rotacion_det";
		var rotacion     = $("#r_codigo").val();
		var turno        = $("#r_turno"+cod+"").val();
		var usuario      = $("#usuario").val();

		if(error == 0){

			var parametros = {"codigo": cod, 	  		"rotacion": rotacion,
	                      "turno": turno,
												"proced": proced, 			"usuario": usuario,
												"metodo":metodo };
					$.ajax({
							data:  parametros,
							url:   'modulo/rotacion_turno/scripts_det.php',
							type:  'post',
							success:  function (response) {
								 var resp = JSON.parse(response);
								if(resp.error){
									alert(resp.mensaje);
								}else{
									CargarDetalle(rotacion);
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



	function Borrar_rotacion(cod){
		var usuario      = $("#usuario").val();
    var parametros = { "codigo" : cod,   "tabla" : "rotacion",
		                   "usuario": usuario   };
      $.ajax({
          data:  parametros,
          url:   'modulo/general/sc_borrar.php',
          type:  'post',
          success:  function (response) {
					var resp = JSON.parse(response);
					 if(resp.error){
					 	alert(resp.mensaje);
					 }else{
					 	Cons_turno_inicio();
					 }

          },
          error: function (xhr, ajaxOptions, thrownError) {
              alert(xhr.status);
              alert(thrownError);}
      });
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
          url:   'formularios/Cons_dia_habil.php',
          type:  'post',
          success:  function (response) {
						$( "#modal_contenido" ).html( response);
          },
          error: function (xhr, ajaxOptions, thrownError) {
              alert(xhr.status);
              alert(thrownError);}
      });
	}

	function B_horario(){
		ModalOpen();
		$("#modal_titulo").text("Consultar Horario");
		$("#modal_contenido").html("");
		var usuario      = $("#usuario").val();
		var parametros = { "Nmenu" : 301, "usuario" : usuario};
			$.ajax({
					data:  parametros,
					url:   'formularios/Cons_horarios.php',
					type:  'post',
					success:  function (response) {
						$( "#modal_contenido" ).html( response);
					},
					error: function (xhr, ajaxOptions, thrownError) {
							alert(xhr.status);
							alert(thrownError);}
			});
	}

	function ModalOpen(){
	 $("#myModal").show();
	}

	function CloseModal(){
	 	$("#myModal").hide();
	}
