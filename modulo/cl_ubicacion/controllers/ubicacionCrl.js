
$(function() {

	Cons_ubicacion_inicio();
});


function Cons_ubicacion_inicio(){

		var cliente      = $("#c_codigo").val();

		var error        = 0;
		var errorMessage = ' ';
		  if(error == 0){
		    var parametros = { "cliente":  cliente};
		      $.ajax({
		          data:  parametros,
		          url:   'modulo/cl_ubicacion/views/Cons_inicio.php',
		          type:  'post',
		          success:  function (response) {
              $("#Cont_ubicacion").html(response);
		          },
		          error: function (xhr, ajaxOptions, thrownError) {
		              alert(xhr.status);
		              alert(thrownError);}
		            });
		  }else{
		    alert(errorMessage);
		  }
}

function Cons_ubic(cod, metodo){
	ModalOpen();
		$("#modal_title").text(" Agregar <?php echo $leng['ubicacion'];?>");

		var usuario      = $("#usuario").val();
		var cliente      = $("#c_codigo").val();

		var error        = 0;
		var errorMessage = ' ';
		  if(error == 0){
		    var parametros = { "codigo" : cod,      "cliente": cliente,
				                   "metodo": metodo,    "usuario": usuario   };
		      $.ajax({
		          data:  parametros,
		          url:   'modulo/cl_ubicacion/views/Add_form.php',
		          type:  'post',
		          success:  function (response) {

              $("#contenido_modal").html(response);
							iniciar_tab(0);

		          },
		          error: function (xhr, ajaxOptions, thrownError) {
		              alert(xhr.status);
		              alert(thrownError);}
		            });
		  }else{
		    alert(errorMessage);
		  }

}


function save_ubic(){


	var error = 0;
	var errorMessage = ' ';
	var cliente     = $("#c_codigo").val();

	var codigo     = $("#ub_codigo").val();
	var activo     = $("#ub_activo").val();
	var nombre     = $("#ub_nombre").val();
	var region     = $("#ub_region").val();
	var zona       = $("#ub_zona").val();
	var estado     = $("#ub_estado").val();
	var ciudad     = $("#ub_ciudad").val();
	var calendario = $("#ub_calendario").val();
	var contacto   = $("#ub_contacto").val();
	var cargo      = $("#ub_cargo").val();
	var telefono   = $("#ub_telefono").val();
	var email      = $("#ub_email").val();
	var direccion  = $("#ub_direccion").val();
	var observ     = $("#ub_observ").val();
	var campo01    = $("#ub_campo01").val();
	var campo02    = $("#ub_campo02").val();
	var campo03    = $("#ub_campo03").val();
	var campo04    = $("#ub_campo04").val();

	var proced     = "p_clientes_ubic";

	var usuario     = $("#usuario").val();
	var metodo     = $("#ub_metodo").val();

	if(error == 0){
		var parametros = "X";
		var parametros = {"codigo": codigo, 	  			"activo": activo,
											"nombre": nombre,           "region" : region,
											"estado": estado,           "ciudad": ciudad ,
											"calendario":calendario ,   "zona":zona ,
											"contacto": contacto ,
											"cargo": cargo,             "telefono": telefono ,
											"email": email,             "direccion": direccion ,
											"observ":observ,
											"proced": proced, 					"usuario": usuario,
											"metodo":metodo,            "cliente": cliente,
											"campo01":campo01,          "campo02":campo02 ,
											"campo03":campo03, 					"campo04":campo04
											};

							$.ajax({
									data:  parametros,
									url:   'modulo/cl_ubicacion/modelo/ubicacion.php',
									type:  'post',
									success:  function (response) {
										CloseModal();
									},
								error: function (xhr, ajaxOptions, thrownError) {
										alert(xhr.status);
										alert(thrownError);}
							});


		}else{
			alert(errorMessage);
		}
	}

/*
function Cons_ubic(cod, metodo){
	ModalOpen();
		$("#modal_title").text(" Agregar <?php echo $leng['ubicacion'];?>");

		var usuario      = $("#usuario").val();
		var cliente      = $("#codigo").val();

		var error        = 0;
		var errorMessage = ' ';
		  if(error == 0){
		    var parametros = { "codigo" : cod,      "cliente": cliente,
				                   "metodo": metodo,    "usuario": usuario   };
		      $.ajax({
		          data:  parametros,
		          url:   'pestanas/add_clientes_ubic.php',
		          type:  'post',
		          success:  function (response) {

              $("#contenido_modal").html(response);
							iniciar_tab(0);

		          },
		          error: function (xhr, ajaxOptions, thrownError) {
		              alert(xhr.status);
		              alert(thrownError);}
		            });
		  }else{
		    alert(errorMessage);
		  }

}

*/

/*
function save_cliente(){

	var error = 0;
	var errorMessage = ' ';
	var proced     = "p_clientes";

	var codigo       = $("#c_codigo").val();
	var abrev        = $("#c_abrev").val();
	var juridico     = $("#c_juridico").val();
	var rif          = $("#c_rif").val();
	var nit          = $("#c_nit").val();
	var contrib      = $("#c_contrib").val();
	var nombre       = $("#c_nombre").val();
	var telefono     = $("#c_telefono").val();
	var fax          = $("#c_fax").val();
	var cl_tipo      = $("#c_cl_tipo").val();
	var region       = $("#c_region").val();
	var vendedor     = $("#c_vendedor").val();
	var email        = $("#c_email").val();
	var website      = $("#c_website").val();
	var contacto     = $("#c_contacto").val();
	var direccion    = $("#c_direccion").val();
	var observ       = $("#c_observ").val();

	var limite_cred  = $("#c_limite_cred").val();
	var plazo_pago   = $("#c_plazo_pago").val();
	var desc_p_pago  = $("#c_desc_p_pago").val();
	var desc_global  = $("#c_desc_global").val();
	var dir_entrega  = $("#c_dir_entrega").val();


  var campo01      = $("#c_campo01").val();
  var campo02      = $("#c_campo02").val();
  var campo03      = $("#c_campo03").val();
  var campo04      = $("#c_campo04").val();

	var lunes        = $("#c_lunes").val();
	var martes       = $("#c_martes").val();
	var miercoles    = $("#c_miercoles").val();
	var jueves       = $("#c_jueves").val();
	var viernes      = $("#c_viernes").val();
	var sabado       = $("#c_sabado").val();
	var domingo      = $("#c_domingo").val();

	var activo       = $("#c_activo").val();
	var usuario      = $("#usuario").val();
	var metodo       = $("#c_metodo").val();


	if(error == 0){

var parametros = {"codigo": codigo, 	  		 "activo": activo,
									"rif": rif,                "nit" :nit,
									"juridico":juridico,       "contrib": contrib,
                  "abrev": abrev,            "nombre": nombre,
									"telefono": telefono,      "fax": fax ,
									"cl_tipo": cl_tipo ,       "region": region ,
									"vendedor": vendedor,      "email": email,
									"website": website,        "contacto": contacto ,
									"direccion": direccion,    "observ": observ ,
									"limite_cred": limite_cred, "plazo_pago": plazo_pago ,
									"desc_p_pago": desc_p_pago, "desc_global": desc_global ,
									"dir_entrega": dir_entrega,
									"lunes": lunes,             "martes": martes,
									"miercoles": miercoles,     "jueves": jueves,
									"viernes": viernes,         "sabado":sabado,
									"domingo":domingo,
									"campo01": campo01,          "campo02": campo02 ,
									"campo03": campo03,          "campo04": campo04 ,
									"proced": proced, 					 "usuario": usuario,
									"metodo":metodo
								 };



							$.ajax({
									data:  parametros,
									url:   'modulo/cliente/modelo/cliente.php',
									type:  'post',
									success:  function (response) {
										 var resp = JSON.parse(response);
										if(resp.error){
											alert(resp.mensaje);
										}else{
											Cons_cliente_inicio();
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

	function Borrar_cliente(cod){
		var usuario      = $("#usuario").val();
    var parametros = { "codigo" : cod,   "tabla" : "cliente",
		                   "usuario": usuario   };
      $.ajax({
          data:  parametros,
          url:   'modulo/general/controllers/c_borrar.php',
          type:  'post',
          success:  function (response) {
					var resp = JSON.parse(response);
					 if(resp.error){
					 	alert(resp.mensaje);
					 }else{
					 	Cons_cliente_inicio();
					 }

          },
          error: function (xhr, ajaxOptions, thrownError) {
              alert(xhr.status);
              alert(thrownError);}
            });
	}

	*/
