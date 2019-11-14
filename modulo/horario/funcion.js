
$(function() {

	Cons_horario_inicio();
});


function Cons_horario_inicio(){

		var error        = 0;
		var errorMessage = ' ';
		  if(error == 0){
		    var parametros = {  };
		      $.ajax({
		          data:  parametros,
		          url:   'modulo/horario/Cons_inicio.php',
		          type:  'post',
		          success:  function (response) {
              $("#Cont_horario").html(response);
		          },
		          error: function (xhr, ajaxOptions, thrownError) {
		              alert(xhr.status);
		              alert(thrownError);}
		            });
		  }else{
		    alert(errorMessage);
		  }
}

function Cons_horario(cod, metodo){
		var usuario      = $("#usuario").val();
		var error        = 0;
		var errorMessage = ' ';
		  if(error == 0){
		    var parametros = { "codigo" : cod,
				                   "metodo": metodo,    "usuario": usuario   };
		      $.ajax({
		          data:  parametros,
		          url:   'modulo/horario/Add_form.php',
		          type:  'post',
		          success:  function (response) {
              $("#Cont_horario").html(response);
		          },
		          error: function (xhr, ajaxOptions, thrownError) {
		              alert(xhr.status);
		              alert(thrownError);}
		            });
		  }else{
		    alert(errorMessage);
		  }
}


function save_horario(){
	var error = 0;
	var errorMessage = ' ';
	var proced     = "p_horarios";

	var codigo          = $("#h_codigo").val();
	var nombre          = $("#h_nombre").val();
	var concepto        = $("#h_concepto").val();
	var h_entrada       = $("#h_entrada").val();
	var h_salida        = $("#h_salida").val();
	var inicio_m_entrada     = $("#inicio_m_entrada").val();
	var fin_m_entrada   = $("#fin_m_entrada").val();
	var inicio_m_salida = $("#inicio_m_salida").val();
	var fin_m_salida    = $("#fin_m_salida").val();
	var dia_trabajo     = $("#dia_trabajo").val();
	var minutos_trabajo = $("#minutos_trabajo").val();

	var activo       = $("#activo").val();
	var usuario      = $("#usuario").val();
	var metodo       = $("#h_metodo").val();

	if(error == 0){
		var parametros = "X";
		var parametros = {"codigo": codigo, 	  			"activo": activo,
											"nombre": nombre,           "concepto" : concepto,
											"h_entrada": h_entrada,     "h_salida": h_salida ,
											"inicio_m_entrada": inicio_m_entrada , "fin_m_entrada": fin_m_entrada ,
											"inicio_m_salida": inicio_m_salida, "fin_m_salida": fin_m_salida ,
											"dia_trabajo": dia_trabajo, "minutos_trabajo": minutos_trabajo ,
											"proced": proced, 					"usuario": usuario,
											"metodo":metodo
											};

							$.ajax({
									data:  parametros,
									url:   'modulo/horario/scripts.php',
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


		}else{
			alert(errorMessage);
		}
	}

	function Borrar_horario(cod){
		var usuario      = $("#usuario").val();
    var parametros = { "codigo" : cod,   "tabla" : "horarios",
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
