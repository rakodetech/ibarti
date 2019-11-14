
$(function() {
	Cons_puesto_inicio();
});

function Cons_puesto_inicio(){

		var cliente      = $("#c_codigo").val();
		var ubicacion   = $("#ub_codigo").val();
		var error        = 0;
		var errorMessage = ' ';
		  if(error == 0){
		    var parametros = { "cliente":  cliente, "ubicacion": ubicacion};
		      $.ajax({
		          data:  parametros,
		          url:   'packages/cliente/cl_ubic_puesto/views/Cons_inicio.php',
		          type:  'post',
		          success:  function (response) {
              $("#Cont_ubic_puesto").html(response);
		          },
		          error: function (xhr, ajaxOptions, thrownError) {
		              alert(xhr.status);
		              alert(thrownError);}
		            });
		  }else{
		    alert(errorMessage);
		  }
}

function Cons_puesto(cod, metodo){
		var error        = 0;
		var errorMessage = ' ';
		  if(error == 0){
		    var parametros = { "codigo" : cod, "metodo": metodo };
		      $.ajax({
		          data:  parametros,
		          url:   'packages/cliente/cl_ubic_puesto/views/Add_form.php',
		          type:  'post',
		          success:  function (response) {

              $("#Cont_ubic_puesto").html(response);
	//						iniciar_tab(0);
		          },
		          error: function (xhr, ajaxOptions, thrownError) {
		              alert(xhr.status);
		              alert(thrownError);}
		            });
		  }else{
		    alert(errorMessage);
		  }
}


function save_puesto(){
	var error = 0;
	var errorMessage = ' ';
	var cliente     = $("#c_codigo").val();
	var ubicacion   = $("#ub_codigo").val();
	var codigo      = $("#p_codigo").val();
	var status      = Status($("#p_status:checked").val());

	var nombre      = $("#p_nombre").val();
	var actividades = $("#p_actividades").val();
	var observ      = $("#p_observ").val();

	var proced     = "p_cl_ubic_puesto";
	var usuario     = $("#usuario").val();
	var metodo     = $("#p_metodo").val();

	if(error == 0){
		var parametros = {"codigo": codigo, 	  			"status": status,
											"cliente": cliente,         "ubicacion" :ubicacion,
											"nombre": nombre,           "actividades": actividades ,
											"observ":observ,
											"proced": proced, 					"usuario": usuario,
											"metodo":metodo
											};

							$.ajax({
									data:  parametros,
									url:   'packages/cliente/cl_ubic_puesto/modelo/puesto.php',
									type:  'post',
									success:  function (response) {
										 var content = JSON.parse(response);
											if(content.error){
											alert(content.mensaje);
											}else{
												Cons_puesto_inicio();
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


	function Borrar_puesto(cod){
		var usuario      = $("#usuario").val();
    var parametros = { "codigo" : cod,   "tabla" : "clientes_ub_puesto",
		                   "usuario": usuario   };
      $.ajax({
          data:  parametros,
          url:   'packages/general/controllers/sc_borrar.php',
          type:  'post',
          success:  function (response) {
					var resp = JSON.parse(response);
					 if(resp.error){
					 	alert(resp.mensaje);
					 }else{
					 	Cons_puesto_inicio();
					 }

          },
          error: function (xhr, ajaxOptions, thrownError) {
              alert(xhr.status);
              alert(thrownError);}
            });
	}
