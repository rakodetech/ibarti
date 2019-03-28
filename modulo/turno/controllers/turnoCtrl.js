$(function() {
Cons_turno_inicio();
});

function Cons_turno_inicio(){
	var error        = 0;
	var errorMessage = ' ';
	  if(error == 0){
	    var parametros = {  };
      $.ajax({
          data:  parametros,
          url:   'modulo/turno/views/Cons_inicio.php',
          type:  'post',
          success:  function (response) {
          $("#Cont_turno").html(response);
          },
          error: function (xhr, ajaxOptions, thrownError) {
              alert(xhr.status);
              alert(thrownError);}
      });
	  }else{
	    alert(errorMessage);
	  }
}

function Cons_turno(cod, metodo){
	var usuario      = $("#usuario").val();
	var error        = 0;
	var errorMessage = ' ';
	  if(error == 0){
	    var parametros = { "codigo" : cod,
			                   "metodo": metodo,    "usuario": usuario   };
      $.ajax({
          data:  parametros,
          url:   'modulo/turno/views/Add_form.php',
          type:  'post',
          success:  function (response) {
          $("#Cont_turno").html(response);
          },
          error: function (xhr, ajaxOptions, thrownError) {
              alert(xhr.status);
              alert(thrownError);}
      });
	  }else{
	    alert(errorMessage);
	  }
}


function save_turno(){
	var error = 0;
	var errorMessage = ' ';
	var proced       = "p_turno";

	var codigo          = $("#t_codigo").val();
	var abrev           = $("#t_abrev").val();
	var nombre          = $("#t_nombre").val();
	var d_habil         = $("#t_d_habil").val();
	var horario         = $("#t_horario").val();
	var factor          = $('input:radio[name=t_factor]:checked').val();
	var trab_cubrir     = $("#t_trab_cubrir").val();

	var activo       = $("#activo").val();
	var usuario      = $("#usuario").val();
	var metodo       = $("#h_metodo").val();

	if(error == 0){
		var parametros = "X";
		var parametros = {"codigo": codigo, 	  			"activo": activo,
											"nombre": nombre,           "abrev" : abrev,
											"d_habil": d_habil,         "horario": horario ,
											"factor": factor ,          "trab_cubrir": trab_cubrir ,
											"proced": proced, 					"usuario": usuario,
											"metodo":metodo };
				$.ajax({
						data:  parametros,
						url:   'modulo/turno/modelo/turno.php',
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


		}else{
			alert(errorMessage);
		}
	}

	function Borrar_turno(cod){
		var usuario      = $("#usuario").val();
    var parametros = { "codigo" : cod,   "tabla" : "turno",
		                   "usuario": usuario   };
      $.ajax({
          data:  parametros,
          url:   'modulo/general/controllers/sc_borrar.php',
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
          url:   'modulo/dia_habil/index.php',
          type:  'post',
          success:  function (response) {
						$( "#modal_contenido" ).html( response);
          },
          error: function (xhr, ajaxOptions, thrownError) {
              alert(xhr.status);
              alert(thrownError);}
      });
	}

	function B_hora(){
		ModalOpen();
		$("#modal_titulo").text("Consultar turno");
		$("#modal_contenido").html("");
		var usuario      = $("#usuario").val();
		var parametros = { "Nmenu" : 301, "usuario" : usuario};
			$.ajax({
					data:  parametros,
					url:   'modulo/horario/index.php',
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
