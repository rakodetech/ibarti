<script language="JavaScript" type="text/javascript">

$(function() {
cargarP_det();
});

function cargarP_det(){
	var codigo     = $("#cl_codigo").val();
	var parametros = {"codigo": codigo};
		$.ajax({
				data:  parametros,
				url:   'formularios/Cons_cl_ubic_puesto_det.php',
				type:  'post',
				success:  function (response) {
					$("#Contenedor_P01").html(response);
				},
			error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status);
					alert(thrownError);}
		});
}

function Cons_puesto(cod, metodo){
		var error        = 0;
		var errorMessage = ' ';
		  if(error == 0){
		    var parametros = { "codigo" : cod, "metodo": metodo };
		      $.ajax({
		          data:  parametros,
		          url:   'formularios/add_cl_ubic_puesto.php',
		          type:  'post',
		          success:  function (response) {

              $("#Contenedor_P01").html(response);
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
		var cliente     = $("#codigo").val();
		var ubicacion   = $("#cl_codigo").val();
		var codigo     = $("#p_codigo").val();
		var activo     = $("#p_activo").val();
	  var nombre     = $("#p_nombre").val();
		var actividades  = $("#p_actividades").val();
		var observ     = $("#p_observ").val();

		var proced     = "p_cl_ubic_puesto";
		var usuario     = $("#usuario").val();
		var metodo     = $("#p_metodo").val();

		if(error == 0){
			var parametros = {"codigo": codigo, 	  			"activo": activo,
			                  "cliente": cliente,         "ubicacion" :ubicacion,
                        "nombre": nombre,           "actividades": actividades ,
												"observ":observ,
												"proced": proced, 					"usuario": usuario,
												"metodo":metodo
												};

								$.ajax({
										data:  parametros,
										url:   'scripts/sc_cl_ubic_puesto.php',
										type:  'post',
										success:  function (response) {
											 var content = JSON.parse(response);
											 	if(content.error){
											 	alert(content.mensaje);
												}else{
													cargarP_det();
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

		function volverP(){
			cargarP_det();
		}

</script>
<div id="Contenedor_P01">
</div>
