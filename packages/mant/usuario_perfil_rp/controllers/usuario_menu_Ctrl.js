$(function() {
	Cons_upm_inicio(()=>{
		get_perfiles();
		cargarModulos('TODOS');
		cargarSeccion('TODOS');
	});
});

function Cons_upm_inicio(callback) {
	var parametros = { }
	
	$.ajax({
		data:  parametros,
		url:   'packages/mant/usuario_perfil_rp/views/Cons_inicio.php',
		type:  'post',
		success:  function (response) {
			$("#Contenedor").html(response);
			callback();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);}
		});
}

function get_perfiles(){
	var parametros = { }
	
	$.ajax({
		data:  parametros,
		url:   'packages/mant/usuario_perfil_rp/views/Get_perfiles.php',
		type:  'post',
		success:  function (response) {
			$("#perfiles").html(response);
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);}
		});

}

function cargarModulos(perfil){

	var parametros = { 'perfil': perfil }
	
	$.ajax({
		data:  parametros,
		url:   'packages/mant/usuario_perfil_rp/views/Get_modulos.php',
		type:  'post',
		success:  function (response) {
			$("#modulos").html(response);
				//noti es el elemento de notificacion cargado al inicio del menu
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);}
			});

}

function cargarSeccion(modulo){
	var perfil = $('#perfil').val();
	var parametros = { 'perfil': perfil, 'modulo': modulo }
	
	$.ajax({

		data:  parametros,
		url:   'packages/mant/usuario_perfil_rp/views/Get_seccion.php',
		type:  'post',
		
		success:  function (response) {

			$("#seccion").html(response);
				//noti es el elemento de notificacion cargado al inicio del menu
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);}
			});

}



function cargarclasif(){

	var parametros = {}
	
	$.ajax({
		data:  parametros,
		url:   'packages/mant/usuario_perfil_rp/views/Get_clasif_nov.php',
		type:  'post',
		success:  function (response) {
			
			$("#tipo").html(response);
				//noti es el elemento de notificacion cargado al inicio del menu
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);}
			});

}

function llenar_perfil_menu(){
	var perfil = $('#perfil').val();
	var modulo = $('#modulo').val();
	var seccion = $('#seccione').val();
	var parametros = {'perfil' : perfil, 'modulo': modulo, 'seccion':seccion};
	$.ajax({
		data:  parametros,
		url:   'packages/mant/usuario_perfil_rp/views/Get_usuario_menu.php',
		type:  'post',
		beforeSend: function () {
			$("#cargar").html("<img src='imagenes/loading.gif' /> Procesando, espere por favor...");
			
		},
		success:  function (response) {
			$("#cargar").html("");
			
			var data= JSON.parse(response);
			//var num_modulo = 0;
			if(data.length > 0){
				var perfil = d3.nest()
				.key((d) => d.perfil).sortKeys(d3.ascending).key((d)=>d.modulo).sortKeys(d3.ascending).key((d)=>d.seccion).sortKeys(d3.ascending)
				.entries(data);

				ModalOpen();
				$("#modal_titulo").text("RELACION PERFIL VS MENU");
				$("#modal_contenido").html('');
				var div = d3.select('#modal_contenido').append('div');

				perfil.forEach((modulo,j)=>{
					div.append('img').attr('src','imagenes/excel.gif').attr('width','25px').attr('title',`imprimir ${modulo.key} a excel` ).on('click',()=>llenar_reporte(perfil[i].values[0].values[0].values[0].codigo));

					var tablas = div.append('table').attr('class','tabla_planif').attr('id',perfil[j].values[0].values[0].values[0].codigo);
					var theads = tablas.append('thead');
					var tbody = tablas.append('tbody');
					var trh = theads.append('tr');

					trh.append('th').text(modulo.key).attr('colspan','3');
					trh.append('th').text('Consultar').attr("width","5%");
					trh.append('th').text('Agregar').attr("width","5%");
					trh.append('th').text('Modificar').attr("width","5%");
					trh.append('th').text('Eliminar').attr("width","5%");		

					modulo.values.forEach((seccion,g)=>{

						seccion.values.forEach((menu,h)=>{

							menu.values.forEach((datos,i)=>{

								var trb = tbody.append('tr');

								if(i == 0 && h == 0){
									trb.append('td').text(datos.modulo).attr('rowspan',()=>{
										var r = 0;
										seccion.values.forEach((d)=>{
											r += d.values.length;
										})
										return r;
									});

								}
								if( i==0){
									trb.append('td').text(datos.seccion).attr('rowspan', menu.values.length);	
								}

								trb.append('td').text(datos.menu);

								trb.append('td').text(datos.consultar);	
								trb.append('td').text(datos.agregar);
								trb.append('td').text(datos.modificar);
								trb.append('td').text(datos.eliminar);			
							})
						})

					});

					
				}

				);
			}else{
				alert('Sin Resultados!..');
			}
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);}

		});
}

function llenar_reporte(id){
	$('#reporte').val($('#'+id).html());
	$('#report').submit();
}
function llenar_perfil_novedad(){

	var perfil  = $('#departamentos').val();
	var clasif = $('#clasifi').val();
	
	var checklist = $('#checklist').val();
	var parametros = {'departamentos' : perfil, 'checklist':checklist, 'clasif':clasif};

	$.ajax({
		data:  parametros,
		url:   'packages/mant/usuario_perfil_rp/views/Get_usuario_novedad.php',
		type:  'post',

		beforeSend: function () {
			$("#cargar").html("<img src='imagenes/loading.gif' /> Procesando, espere por favor...");
			
		},
		success:  function (response) {
			$("#cargar").html("");
			var data= JSON.parse(response);

			//var num_modulo = 0;
			var cantidad_modulo;
			var cantidad_seccion = [];
			var perfil = d3.nest()
			.key((d) => d.perfil).sortKeys(d3.ascending).key((d)=>d.modulo).sortKeys(d3.ascending).key((d)=>d.seccion).sortKeys(d3.ascending)
			.entries(data);
			ModalOpen();
			$("#modal_titulo").text("RELACION PERFIL VS NOVEDADES");
			$("#modal_contenido").html('');
			var div = d3.select('#modal_contenido').append('div');
			
			

			perfil.forEach((modulo,i)=>{

				div.append('img').attr('src','imagenes/excel.gif').attr('width','25px').attr('title',`imprimir ${modulo.key} a excel` ).on('click',()=>llenar_reporte(perfil[i].values[0].values[0].values[0].codigo));
				var tablas = div.append('table').attr('class','tabla_planif').attr('id',perfil[i].values[0].values[0].values[0].codigo);
				var theads = tablas.append('thead');
				var tbody = tablas.append('tbody');
				var trh = theads.append('tr');
				var trh2 = theads.append('tr');

				trh.append('th').text(modulo.key).attr('colspan','5');	
				trh2.append('th').text("Clasificacion");
				trh2.append('th').text("Ingreso");
				trh2.append('th').text("Respuesta");
				trh2.append('th').text("Tipo");
				trh2.append('th').text("Novedad");

				var color1 = "#46dd33";
				var color2 = "#a8ff9e";

				modulo.values.forEach((seccion,g)=>{

					seccion.values.forEach((menu,h)=>{

						menu.values.forEach((datos,k)=>{

							var trb = tbody.append('tr');
							
								if(k == 0 && h == 0){
								var r = 0;
								trb.append('td').text(datos.modulo).attr('rowspan',()=>{
									r = 0;
									seccion.values.forEach((d)=>{
										r += d.values.length;
									})
									return r;
								});
								
								trb.append('td').text(perfil[i].values[g].values[0].values[0].ingreso).attr('rowspan',()=>{
									r = 0;
									seccion.values.forEach((d)=>{
										r += d.values.length;
									})
									return r;
								});
								trb.append('td').text(perfil[i].values[g].values[0].values[0].respuesta).attr('rowspan',()=>{
									r = 0;
									seccion.values.forEach((d)=>{
										r += d.values.length;
									})
									return r;
								});


							}
							if( k==0){
								trb.append('td').text(datos.seccion).attr('rowspan', menu.values.length);	
							}
							
							trb.append('td').text(datos.menu);
							
							
							
						})
					})
				});
				
			});
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);}

		});	
}
