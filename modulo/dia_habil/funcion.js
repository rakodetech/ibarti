
$(function() {
	Cons_dia_habil_inicio();
});


function Cons_dia_habil_inicio(){

		var error        = 0;
		var errorMessage = ' ';
		  if(error == 0){
		    var parametros = {  };
		      $.ajax({
		          data:  parametros,
		          url:   'modulo/dia_habil/Cons_inicio.php',
		          type:  'post',
		          success:  function (response) {
              $("#Cont_dia_habil").html(response);
		          },
		          error: function (xhr, ajaxOptions, thrownError) {
		              alert(xhr.status);
		              alert(thrownError);}
		            });
		  }else{
		    alert(errorMessage);
		  }
}

function Cons_dia_habil(cod, metodo){
		var usuario      = $("#usuario").val();
		var error        = 0;
		var errorMessage = ' ';
		  if(error == 0){
		    var parametros = { "codigo" : cod,
				                   "metodo": metodo,    "usuario": usuario   };
		      $.ajax({
		          data:  parametros,
		          url:   'modulo/dia_habil/Add_form.php',
		          type:  'post',
		          success:  function (response) {
              $("#Cont_dia_habil").html(response);
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

	var codigo       = $("#dh_codigo").val();
	var descripcion  = $("#dh_descripcion").val();
	var tipo         = $("#dh_clasif").val();
	var activo       = $("#activo").val();
	var usuario      = $("#usuario").val();
	var metodo       = $("#h_metodo").val();
	if(error == 0){
			var parametros = {"codigo": codigo, 	  		"activo": activo,
											"descripcion": descripcion, "tipo" : tipo,
											"dias": dias,
											"proced": proced, 					"usuario": usuario,
											"metodo":metodo};

					$.ajax({
							data:  parametros,
							url:   'modulo/dia_habil/scripts.php',
							type:  'post',
							success:  function (response) {
								 var resp = JSON.parse(response);
								if(resp.error){
									alert(resp.mensaje);
								}else{
									Cons_dia_habil_inicio();

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

	function Borrar_dia_habil(cod){
		var usuario      = $("#usuario").val();
    var parametros = { "codigo" : cod,   "tabla" : "dias_habiles",
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
					 	Cons_horario_inicio();
					 }

          },
          error: function (xhr, ajaxOptions, thrownError) {
              alert(xhr.status);
              alert(thrownError);}
            });
	}


	function Add_dh_det(cod){
		var codigo       = $("#dh_codigo").val();
		var usuario      = $("#usuario").val();

		var parametros = { "codigo" : codigo,   "cod_dia_tipo" : cod,
											 "usuario": usuario   };
			$.ajax({
					data:  parametros,
					url:   'modulo/dia_habil/Add_dia.php',
					type:  'post',
					success:  function (response) {
						 $("#Cont_dh_det").html(response);
					},
				error: function (xhr, ajaxOptions, thrownError) {
						alert(xhr.status);
						alert(thrownError);}
			});
	}
