$(function() {
	Cons_zona_inicio();

});

function Cons_zona_inicio(){

		var error        = 0;
		var errorMessage = ' ';
		  if(error == 0){
		    var parametros = { };
		      $.ajax({
		          data:  parametros,
		          url:   'packages_mant/zona/views/Cons_inicio.php',
		          type:  'post',
		          success:  function (response) {
              $("#Cont_zona").html(response);
		          },
		          error: function (xhr, ajaxOptions, thrownError) {
		              alert(xhr.status);
		              alert(thrownError);}
		            });
		  }else{
		    alert(errorMessage);
		  }
}

function Cons_zona(cod, metodo){
		var error        = 0;
		var errorMessage = ' ';
		  if(error == 0){
		    var parametros = { "codigo" : cod, "metodo": metodo };
		      $.ajax({
		          data:  parametros,
		          url:   'packages_mant/zona/views/Add_form.php',
		          type:  'post',
		          success:  function (response) {
              $("#Cont_zona").html(response);
								if(metodo == "modificar"){
									CargarDetalleCont(cod);
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


function save_zona(){

	var error = 0;
	var errorMessage = ' ';
	var codigo       = $("#z_codigo").val();
	var activo       = $("#z_activo").val();
	var descripcion  = $("#z_descripcion").val();
	var campo01      = $("#z_campo01").val();
	var campo02      = $("#z_campo02").val();
	var campo03      = $("#z_campo03").val();
	var campo04      = $("#z_campo04").val();

	var usuario      = $("#usuario").val();
	var metodo       = $("#z_metodo").val();


	if(error == 0){
		var parametros = {"codigo": codigo, 	  			  "activo": activo,
											"descripcion" :descripcion,
											"campo01": campo01,           "campo02": campo02,
											"campo03": campo03,           "campo04": campo04,
											"usuario": usuario,  				  "metodo":metodo,
											"tabla" : "zonas"
											};
						$.ajax({
								data:  parametros,
								url:   'packages_mant/general/modelo/sc_maestros.php',
								type:  'post',
								success:  function (response) {
									 var content = JSON.parse(response);
										if(content.error){
										alert(content.mensaje);
										}else{
											Cons_zona_inicio();
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


	function Borrar_zona(cod){
		var usuario      = $("#usuario").val();
    var parametros = { "codigo" : cod,   "tabla" : "zonas",
		                   "usuario": usuario   };
      $.ajax({
          data:  parametros,
          url:   'packages_mant/general/controllers/sc_borrar.php',
          type:  'post',
          success:  function (response) {
					var resp = JSON.parse(response);
					 if(resp.error){
					 	alert(resp.mensaje);
					 }else{
					 	Cons_zona_inicio();
					 }

          },
          error: function (xhr, ajaxOptions, thrownError) {
              alert(xhr.status);
              alert(thrownError);}
            });
	}
