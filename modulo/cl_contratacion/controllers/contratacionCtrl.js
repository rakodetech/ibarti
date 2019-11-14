$(function() {
	Cons_contratacion_inicio();

});

function Cons_contratacion_inicio(){

		var cliente      = $("#c_codigo").val();

		var error        = 0;
		var errorMessage = ' ';
		  if(error == 0){
		    var parametros = { "cliente":  cliente};
		      $.ajax({
		          data:  parametros,
		          url:   'modulo/cl_contratacion/views/Cons_inicio.php',
		          type:  'post',
		          success:  function (response) {
              $("#Cont_contratacion").html(response);
		          },
		          error: function (xhr, ajaxOptions, thrownError) {
		              alert(xhr.status);
		              alert(thrownError);}
		            });
		  }else{
		    alert(errorMessage);
		  }
}

function Cons_contratacion(cod, metodo){
		var error        = 0;
		var errorMessage = ' ';
		  if(error == 0){
		    var parametros = { "codigo" : cod, "metodo": metodo };
		      $.ajax({
		          data:  parametros,
		          url:   'modulo/cl_contratacion/views/Add_form.php',
		          type:  'post',
		          success:  function (response) {
              $("#Cont_contratacion").html(response);
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


function save_contratacion(){
	var error = 0;
	var errorMessage = ' ';
	var cliente      = $("#c_codigo").val();
	var codigo       = $("#cont_codigo").val();
	var activo       = $("#cont_activo").val();
	var descripcion  = $("#cont_descripcion").val();
	var fecha_inicio = $("#cont_fec_inicio").val();
	var fecha_fin    = $("#cont_fec_fin").val();

	var proced     = "p_cl_contratacion";
	var usuario     = $("#usuario").val();
	var metodo     = $("#cont_metodo").val();

	if(error == 0){
		var parametros = {"codigo": codigo, 	  			  "activo": activo,
											"cliente": cliente,           "descripcion" :descripcion,
											"fecha_inicio": fecha_inicio, "fecha_fin": fecha_fin ,
											"proced": proced, 					  "usuario": usuario,
											"metodo":metodo
											};

							$.ajax({
									data:  parametros,
									url:   'modulo/cl_contratacion/modelo/contratacion.php',
									type:  'post',
									success:  function (response) {
										 var content = JSON.parse(response);
											if(content.error){
											alert(content.mensaje);
											}else{
												Cons_contratacion_inicio();
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


	function save_contratacion_det(id, metodo){

		var error = 0;
		var errorMessage = ' ';
		var codigo       = id;
		var contratacion = $("#cont_codigo").val();
		var ubicacion    = $("#cont_ubicacion"+id+"").val();
		var puesto       = $("#cont_puesto"+id+"").val();
		var turno        = $("#cont_turno"+id+"").val();
		var cargo        = $("#cont_cargo"+id+"").val();
		var cantidad     = $("#cont_cantidad"+id+"").val();

		var proced       = "p_cl_contratacion_det";
		var usuario      = $("#usuario").val();

		if(error == 0){

			var parametros = {"codigo": codigo, 	  			  "contratacion": contratacion,
												"ubicacion": ubicacion,       "puesto" :puesto,
												"turno": turno,               "cargo": cargo ,
												 "cantidad": cantidad ,
												"proced": proced, 					  "usuario": usuario,
												"metodo":metodo
												};

								$.ajax({
										data:  parametros,
										url:   'modulo/cl_contratacion/modelo/contratacion_det.php',
										type:  'post',
										success:  function (response) {
											 var content = JSON.parse(response);
												if(content.error){
												alert(content.mensaje);
												}else{
													Cons_contratacion_inicio();
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


	function Borrar_contratacion(cod){
		var usuario      = $("#usuario").val();
    var parametros = { "codigo" : cod,   "tabla" : "clientes_contratacion",
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
					 	Cons_contratacion_inicio();
					 }

          },
          error: function (xhr, ajaxOptions, thrownError) {
              alert(xhr.status);
              alert(thrownError);}
            });
	}

		function CargarDetalleCont(cod_cont){

				var cliente      = $("#c_codigo").val();
				var usuario    = $("#usuario").val();
				var parametros = {"contratacion" : cod_cont,    "cliente" : cliente,
				                  "usuario": usuario};

				$.ajax({
						data:  parametros,
						url:   'modulo/cl_contratacion/views/Add_form_contratacion_det.php',
						type:  'post',
						success:  function (response) {
							 $("#Cont_detalleCont").html(response);
						},
						error: function (xhr, ajaxOptions, thrownError) {
								alert(xhr.status);
								alert(thrownError);}
				});
		}
		function Cargar_puesto(codigo, contenedor, name, tamano, evento){
			var usuario    = $("#usuario").val();

				var parametros = {"codigo" : codigo,    "name"  : name,
				                  "tamano" : tamano,    "evento":evento,
													"usuario": usuario};
				$.ajax({
						data:  parametros,
						url:   'modulo/select/views/cl_puesto.php',
						type:  'post',
						success:  function (response) {
							 $("#"+contenedor+"").html(response);
						},
						error: function (xhr, ajaxOptions, thrownError) {
								alert(xhr.status);
								alert(thrownError);}
				});
		}
