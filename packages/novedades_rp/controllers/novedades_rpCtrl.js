

var gama1=['#2dcc2a','#2accab','#cc782a','#c9cc2a'];
var g = new GraficasD3(gama1);
var g2 = new GraficasD3(d3.schemePaired);
var res_status;

function consultar(vista){
	
	llenar_estatus(vista);
	llenar_departamentos();
}

function llenar_estatus(vista){
	
	var parametros = { 'vista':vista};
		$.ajax({
		data:  parametros,
		url:   'packages/novedades_rp/views/Get_status.php',
		type:  'post',
		success:  function (response) {
			var data= JSON.parse(response);
			var select = d3.select("#form_reportes").select("#prueba").select("#at").select("#contenedor2").select("#status");
			data.forEach((res)=>{
						select.append("option").attr("value",res[0]).text(res[1]);		
			});

				//noti es el elemento de notificacion cargado al inicio del menu
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);}
			});
	}
	



function llenar_departamentos(){
	var parametros = { }
	
	$.ajax({
		data:  parametros,
		url:   'packages/novedades_rp/views/Get_departamentos.php',
		type:  'post',
		success:  function (response) {
			var data= JSON.parse(response);
			
			var select = d3.select("#form_reportes").select("#prueba").select("#et").select("#contenedor3").select("#departamentos");
			data.forEach((res)=>{
				select.append("option").attr("value",res[0]).text(res[1]);
			});

				//noti es el elemento de notificacion cargado al inicio del menu
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);}
			});

}


function mostrar_pendiente(nombre,departamento,cedula,cod_usuario,cod_perfil,usuario){
	
	var estatus =  $("#status").val();
	var acumulado=0;

	var parametros = {
		"perfil": cod_perfil,
		"usuario": cod_usuario,
		"estatus": estatus
	};

	

	$.ajax({
		data:  parametros,
		url:   'packages/novedades_rp/views/Get_cant_novedades_pendientes.php',
		type:  'post',
		success:  function (response) {
			
			datos = JSON.parse(response);
			
			res_status = d3.nest()
			.key((d) => d.cod_status).sortKeys(d3.ascending)
			.entries(datos);

			
			
			ModalOpen();
			$("#modal_titulo").text("Reporte de novedades pendientes");
			$("#modal_contenido").html('');
			/*$("#modal_contenido").html(`<br><div id='nombre' width= '80%' align='left' class="etiqueta">Nombre: ${nombre} <img src='http://localhost/ib_oesvica/imagenes/temp/9999.jpg' width="64px" align="right"> <br>
			Departamento: ${departamento}  </div>`);*/

			var contenido = d3.select('#modal_contenido');

			var div_nombre = contenido.append('div').attr('width','80%').attr('align','left');
			div_nombre.append('br');
			div_nombre.append('label').text("Nombre: ").attr('align','left').attr('class','etiqueta');
			div_nombre.append('label').text(nombre);
			div_nombre.append('img').attr('src','imagenes/fotos/'+ cedula +'.jpg').attr('align','right').attr("width","110px").attr("height","130px");

			var div_perfil = contenido.append('div').attr('width','80%').attr('align','left');
			div_perfil.append('label').text("Perfil: ").attr('align','left').attr('class','etiqueta');
			div_perfil.append('label').text(departamento);
			contenido.append('br');

			var new_listar = contenido.append('div').attr('id','contend').attr('align','left');
			var tabla = new_listar.append('table').attr('id','contenido').attr('border','1').attr("width","60%");
			var tbody = tabla.append('tbody');

			var head = tabla.append('thead').append('tr').attr('class','fondo00');
			head.append('th').attr('class','etiqueta').text("Pendientes").attr('width','30%');
			head.append('th').attr('class','etiqueta').text("Ingresado US").attr('width','30%').attr('title','Ingresados por el usuario');
			head.append('th').attr('class','etiqueta').text("Estatus").attr('width','30%');
			head.append('th').attr('class','etiqueta').text("Detalle").attr('width','40%');

			
			res_status.forEach((d)=>{
				acumulado+=d.values.length;
			});
			
			var tr =tbody.selectAll("tr").data(res_status).enter()
			.append("tr");

			tr.append("td").text((d,i)=>{
				var acumulados = 0;
				d.values.forEach((res)=>{
					if (res['usuario'] == usuario){
						acumulados++;
					}
				});
				var texto = (d.values.length - acumulados); 
				return texto;}).style("text-align","center");

			tr.append("td").text((d,i)=>{
				var acumuladoss = 0;
				d.values.forEach((res)=>{
					if (res['usuario'] == usuario){
						acumuladoss++;
					}
				});
				var texto = acumuladoss; 
				return texto;}).style("text-align","center");

			tr.append("td").text((d,i)=>d.values[0].stat).style("text-align","center");
			tr.append("td").style("text-align","center").append('img').attr('src','imagenes/detalle.bmp').attr("width","20px").attr('title','Ver detalle')
			.on('click',(d,i)=>{
				var detalle = d.values;
				var status = d.values[0].stat;
				
				tabla_detalle(detalle,status,acumulado);	
			});
			

			
			

			contenido.append('br');
			contenido.append('div').attr('id','detalles');
			

			
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);}
		});

	
}

function mostrar_general(nombre,departamento,cedula,cod_usuario,cod_perfil,cantidad,usuario){
	
	var estatus =  $("#status").val();
	var acumulado=0;
	var error = 0;
	var fecha_desde = $('#fecha_desde').val();
	var fecha_hasta = $('#fecha_hasta').val();
	var parametros = {
		"perfil": cod_perfil,
		"usuario": cod_usuario,
		"estatus": estatus,
		"fecha_desde" : fecha_desde,
		"fecha_hasta" : fecha_hasta
	};

	  if( fechaValida(fecha_desde) !=  true || fechaValida(fecha_hasta) != true){
      var errorMessage = ' Campos De Fecha Incorrectas ';
      var error = error+1;
    }

	if(error == 0){


		$.ajax({
			data:  parametros,
			url:   'packages/novedades_rp/views/Get_cant_novedades_general.php',
			type:  'post',
			success:  function (response) {
				
				datos = JSON.parse(response);
				
				res_status = d3.nest()
				.key((d) => d.cod_status).sortKeys(d3.ascending)
				.entries(datos);

				
				
				ModalOpen();
				$("#modal_titulo").text("Reporte de novedades generales");
				$("#modal_contenido").html('');
				/*$("#modal_contenido").html(`<br><div id='nombre' width= '80%' align='left' class="etiqueta">Nombre: ${nombre} <img src='http://localhost/ib_oesvica/imagenes/temp/9999.jpg' width="64px" align="right"> <br>
				Departamento: ${departamento}  </div>`);*/

				var contenido = d3.select('#modal_contenido');

				var div_nombre = contenido.append('div').attr('width','80%').attr('align','left');
				div_nombre.append('br');
				div_nombre.append('label').text("Nombre: ").attr('align','left').attr('class','etiqueta');
				div_nombre.append('label').text(nombre);
				div_nombre.append('img').attr('src','imagenes/fotos/'+ cedula +'.jpg').attr('align','right').attr("width","110px").attr("height","130px");

				var div_perfil = contenido.append('div').attr('width','80%').attr('align','left');
				div_perfil.append('label').text("Perfil: ").attr('align','left').attr('class','etiqueta');
				div_perfil.append('label').text(departamento);
				contenido.append('br');

				var new_listar = contenido.append('div').attr('id','contend').attr('align','left');
				var tabla = new_listar.append('table').attr('id','contenido').attr('border','1').attr("width","60%");
				var tbody = tabla.append('tbody');

				var head = tabla.append('thead').append('tr').attr('class','fondo00');
				head.append('th').attr('class','etiqueta').text("Pendientes").attr('width','30%');
				head.append('th').attr('class','etiqueta').text("Ingresado US").attr('width','30%').attr('title','Ingresados por el usuario');
				head.append('th').attr('class','etiqueta').text("Estatus").attr('width','30%');
				head.append('th').attr('class','etiqueta').text("Detalle").attr('width','40%');

				
				res_status.forEach((d)=>{
					acumulado+=d.values.length;
				});
				
				var tr =tbody.selectAll("tr").data(res_status).enter()
				.append("tr");

				tr.append("td").text((d,i)=>{
					var acumulados = 0;
					d.values.forEach((res)=>{
						if (res['usuario'] == usuario){
							acumulados++;
						}
					});
					var texto = (d.values.length - acumulados); 
					return texto;}).style("text-align","center");

				tr.append("td").text((d,i)=>{
					var acumuladoss = 0;
					d.values.forEach((res)=>{
						if (res['usuario'] == usuario){
							acumuladoss++;
						}
					});
					var texto = acumuladoss; 
					return texto;}).style("text-align","center");

				tr.append("td").text((d,i)=>d.values[0].stat).style("text-align","center");
				tr.append("td").style("text-align","center").append('img').attr('src','imagenes/detalle.bmp').attr("width","20px").attr('title','Ver detalle')
				.on('click',(d,i)=>{
					var detalle = d.values;
					var status = d.values[0].stat;
					
					tabla_detalle(detalle,status,acumulado);	
				});
			

			
			

			contenido.append('br');
			contenido.append('div').attr('id','detalles').attr('class','col-md-6');
			

			
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);}
		});

	}else{
		toastr.error(errorMessage,'ERROR');
	}

}

function tabla_detalle(codigo,status){
	
	$('#detalles').html("");
	
	//bien 
	var selecionado = d3.select('#detalles').attr('align','left');
	selecionado.append('div').attr('align','left').append('label').text("DETALLE DE NOVEDADES EN STATUS " + status);
	selecionado.append('br');

	var div = selecionado.append('div').attr('id','objeto').attr('align','left').attr('class','listar');
	var tabla = div.append('table').attr('border','1').style('font-size','10px').attr('width','100%');
	var tbody = tabla.append('tbody');

	var head = tabla.append('thead').append('tr').attr('class','fondo00');
	head.append('th').attr('class','etiqueta').text("Codigo").attr('width','15%');
	head.append('th').attr('class','etiqueta').text("Fecha").attr('width','15%');
	head.append('th').attr('class','etiqueta').text("Descripcion").attr('width','30%');
	head.append('th').attr('class','etiqueta').text("Usuario Ingresado").attr('width','40%');


	//console.log(codigo)
	var tr =tbody.selectAll("tr").data(codigo).enter()
		.append("tr").attr('class',(d,i)=>{
				if(i%2==0){
					return "fondo01";
				}else{
					return "fondo02";
				}
			}).attr('title',(d)=>d.observacion).on('click',(d)=>{
				window.open("inicio.php?area=formularios/Add_novedades2&Nmenu=444&mod=006&codigo=" + d.codigo + "&metodo=modificar",'_blank');
			});
	tr.append("td").text((d,i)=>d.codigo).style("text-align","center");
	tr.append("td").text((d,i)=>d.fecha).style("text-align","center");
	tr.append("td").text((d,i)=>d.descripcion).style("text-align","center");
	tr.append("td").text((d,i)=>d.nombre).style("text-align","center");
	selecionado.append('br');
}



//////////////////////////////////////////////////////7777
function llenar_tb_novedades_pendientes(){
	
	var departamentos = $("#departamentos").val();
	var estatus =  $("#status").val();
	var error = 0;
    var errorMessage = ' ';
	if(error == 0){
		var parametros = {"departamentos":departamentos , "estatus":estatus};

	$.ajax({
		data:  parametros,
		url:   'packages/novedades_rp/views/Get_tb_novedades_pendientes.php',
		type:  'post',
		beforeSend: function () {
			$("#listar").html("<img src='imagenes/loading.gif' /> Procesando, espere por favor...");
			
			},
		success:  function (response) {
			
			$("#listar").html("");
			var data= JSON.parse(response);
			//console.log(data);
			var nuevo =  d3.nest()
			.key((d) => d.codigo_usuario).entries(data);
			/*
			console.log(nuevo);
			nuevo.forEach((res)=>{
				console.log(res.values[0].descripcion);
			});
			*/
			var tabla = d3.select('#listar').append('table').attr('width','100%').attr('class','tabla_sistema');
			var tbody = tabla.append('tbody');

			var head = tabla.append('thead').append('tr').attr('class','fondo00');

			head.append('th').attr('class','etiqueta').text("Nombre");
			head.append('th').attr('class','etiqueta').text("Apellido");
			head.append('th').attr('class','etiqueta').text("Perfil");
			head.append('th').attr('class','etiqueta').text("Cantidad de novedades");
				


			var tr =tbody.selectAll("tr").data(nuevo).enter()
			.append("tr").attr('class',(d,i)=>{
				if(i%2==0){
					return "fondo01";
				}else{
					return "fondo02";
				}
			}).on("click",(d)=>{

				llenar_grafica_novedades_pendientes((d.values[0].nombre+ " " + d.values[0].apellido),d.values[0].descripcion,d.values[0].cedula,d.values[0].codigo,d.values[0].cod_perfil,d.values.length,d.values[0].usuario);
				//mostrar_pendiente((d.nombre+ " " + d.apellido),d.descripcion,d.cedula,d.codigo,d.cod_perfil,d.cantidad,d.usuario);

			});
			tr.append("td").text((d,i)=>d.values[0].nombre);
			tr.append("td").text((d,i)=>d.values[0].apellido);
			tr.append("td").text((d,i)=>d.values[0].descripcion);
			tr.append("td").text((d,i)=>d.values.length);
			
			
				
				//noti es el elemento de notificacion cargado al inicio del menu
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);}
			});
	}else{
		 toastr.error(errorMessage,'ERROR');
	}

	
	
	

}
//////////////////////////////////////////////7
function llenar_grafica_novedades_pendientes(nombre,departamento,cedula,cod_usuario,cod_perfil,usuario){
	var estatus =  $("#status").val();
	var acumulado=0;

	var parametros = {
		"perfil": cod_perfil,
		"usuario": cod_usuario,
		"estatus": estatus
	};
	$.ajax({
		data:  parametros,
		url:   'packages/novedades_rp/views/Get_cant_novedades_pendientes.php',
		type:  'post',
		success:  function (response) {
			var contador=0;
			var codigo_actual='';
			
			
			datos = JSON.parse(response);
			var new_response = [];
			var nuevo =  d3.nest()
			.key((d) => d.cod_status).sortKeys(d3.ascending).entries(datos);
			

			nuevo.forEach((d)=>{
				//console.log(d.key);
				new_response.push({0:d.values[0].stat,1:d.values.length,2:d.key,"titulo":d.values[0].stat,"valor":String(d.values.length),"codigo":d.key})
			})

			/*
			datos.forEach((res,i)=>{
				
				if(i==0){
					codigo_actual=res.cod_status;
					titulo_actual=res.stat;
					contador=0;
				//	console.log('primero');
				}
				
				
				if(res.cod_status!=codigo_actual ){
					new_response.push({0:titulo_actual,1:contador,2:codigo_actual,"titulo":titulo_actual,"valor":String(contador),"codigo":codigo_actual});
				//	console.log(new_response)
					codigo_actual=res.cod_status;
					titulo_actual=res.stat;
					contador=0;
					
				}else{
					contador++;
				}
				
				if(i==datos.length-1){
					contador++;
					new_response.push({0:titulo_actual,1:contador,2:codigo_actual,"titulo":titulo_actual,"valor":String(contador),"codigo":codigo_actual});
					//console.log('ultimo');
				}

				
				
			})
			
		*/
			ModalOpen();
			$("#modal_titulo").text("Reporte de novedades pendientes");
			$("#modal_contenido").html('');
			
			var contenido = d3.select('#modal_contenido');
			var div_nombre = contenido.append('div').attr('width','80%').attr('align','left');
				div_nombre.append('br');
				div_nombre.append('label').text("Nombre: ").attr('align','left').attr('class','etiqueta');
				div_nombre.append('label').text(nombre);
				

				var div_perfil = contenido.append('div').attr('width','80%').attr('align','left');
				div_perfil.append('label').text("Perfil: ").attr('align','left').attr('class','etiqueta');
				div_perfil.append('label').text(departamento);
				
			var contenedora = contenido.append('div').attr('id','contenedora1')
			
			//var jsonn = JSON.parse(new_response)
			
			//g.crearGraficaTorta(datos, 300, 'contenedora1', 'contenedora2', true, false, 'top', 'col-xs-12', 'REPORTE DE NOVEDADES');
			contenido.append('br');
			contenido.append('div').attr('id','detalles').attr('class','col-md-6');
			if(!(datos.length>=150)){
				g.crearGraficaTorta(new_response,300,'contenedora1','grafica',true,true,'top','col-md-6','',()=>{

					new_response.forEach((res)=>{
						
					cod_validador = 'cod' + res.codigo;
					if (d3.select('#' + 'contenedora1').select('#' + 'grafica').node()) {
						var div_grafica = d3.select('#' + 'contenedora1').select('#' + 'grafica');
						var type = div_grafica.attr('type');
						var svg = d3.select('#' + 'contenedora1').select('#' + 'grafica').select('#svg-' + type + '-' + 'grafica');
						var chart = svg.select('#chart-' + type + '-' + 'grafica');
						if (type == 'torta') var ley = svg.selectAll('.leyenda-torta').select('#' + cod_validador);
						else var ley = svg.selectAll('.leyenda-bar').select('#' + cod_validador);
						
						ley.on("click",()=> {
							enlace_tabla_detalle(res,datos);
							
						});
						chart.selectAll('#' + cod_validador)
						.on("click",()=> {
							enlace_tabla_detalle(res,datos);
						});
					}
					});
					
				});
				
			}else{
				g.crearGraficaBarra(new_response,300,'contenedora1','grafica',false,false,'top','col-md-6','',()=>{

					new_response.forEach((res)=>{
						
					cod_validador = 'cod' + res.codigo;
					if (d3.select('#' + 'contenedora1').select('#' + 'grafica').node()) {
						var div_grafica = d3.select('#' + 'contenedora1').select('#' + 'grafica');
						var type = div_grafica.attr('type');
						
						var svg = d3.select('#' + 'contenedora1').select('#' + 'grafica').select('#svg-' + type + '-' + 'grafica');
						var chart = svg.select('#chart-' + type + '-' + 'grafica');
						if (type == 'torta') var ley = svg.selectAll('.leyenda-torta').select('#' + cod_validador);
						else var ley = svg.selectAll('.leyenda-bar').select('#' + cod_validador);
						
						ley.on("click",()=> {
							enlace_tabla_detalle(res,datos);
							
						});
						chart.selectAll('#' + cod_validador)
						.on("click",()=> {
							enlace_tabla_detalle(res,datos);
						});
					}
					});
					
				});
			}
	},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);}
		});

}

function llenar_grafica_novedades_generales(nombre,departamento,cedula,cod_usuario,cod_perfil,usuario){
	var estatus =  $("#status").val();
	var acumulado=0;
	var error = 0;
	var fecha_desde = $('#fecha_desde').val();
	var fecha_hasta = $('#fecha_hasta').val();
	var parametros = {
		"perfil": cod_perfil,
		"usuario": cod_usuario,
		"estatus": estatus,
		"fecha_desde" : fecha_desde,
		"fecha_hasta" : fecha_hasta
	};
	$.ajax({
		data:  parametros,
		url:   'packages/novedades_rp/views/Get_cant_novedades_general.php',
		type:  'post',
		success:  function (response) {
			var contador=0;
			var codigo_actual='';
			
			datos = JSON.parse(response);
			var new_response = [];
			var nuevo =  d3.nest()
			.key((d) => d.cod_status).sortKeys(d3.ascending).entries(datos);
			

			nuevo.forEach((d)=>{
				//console.log(d.key);
				new_response.push({0:d.values[0].stat,1:d.values.length,2:d.key,"titulo":d.values[0].stat,"valor":String(d.values.length),"codigo":d.key})
			})
			
			
		
			ModalOpen();
			$("#modal_titulo").text("Reporte de novedades Generales");
			$("#modal_contenido").html('');
			
			var contenido = d3.select('#modal_contenido');
			var div_nombre = contenido.append('div').attr('width','80%').attr('align','left');
				div_nombre.append('br');
				div_nombre.append('label').text("Nombre: ").attr('align','left').attr('class','etiqueta');
				div_nombre.append('label').text(nombre);
				var div_perfil = contenido.append('div').attr('width','80%').attr('align','left');
				div_perfil.append('label').text("Perfil: ").attr('align','left').attr('class','etiqueta');
				div_perfil.append('label').text(departamento);
				
				
			var contenedora = contenido.append('div').attr('id','contenedora1')
			contenido.append('br');
			contenido.append('div').attr('id','detalles').attr('class','col-md-6');
			//var jsonn = JSON.parse(new_response)
			
			//g.crearGraficaTorta(datos, 300, 'contenedora1', 'contenedora2', true, false, 'top', 'col-xs-12', 'REPORTE DE NOVEDADES');
			if(!(datos.length>=150)){
				g.crearGraficaTorta(new_response,300,'contenedora1','grafica',true,true,'top','col-md-6','',()=>{

					new_response.forEach((res)=>{
						
					cod_validador = 'cod' + res.codigo;
					if (d3.select('#' + 'contenedora1').select('#' + 'grafica').node()) {
						var div_grafica = d3.select('#' + 'contenedora1').select('#' + 'grafica');
						var type = div_grafica.attr('type');
						var svg = d3.select('#' + 'contenedora1').select('#' + 'grafica').select('#svg-' + type + '-' + 'grafica');
						var chart = svg.select('#chart-' + type + '-' + 'grafica');
						if (type == 'torta') var ley = svg.selectAll('.leyenda-torta').select('#' + cod_validador);
						else var ley = svg.selectAll('.leyenda-bar').select('#' + cod_validador);
						
						ley.on("click",()=> {
							enlace_tabla_detalle(res,datos);
							
						});
						chart.selectAll('#' + cod_validador)
						.on("click",()=> {
							enlace_tabla_detalle(res,datos);
						});
					}
					});
					
				});
			}else{
				g.crearGraficaBarra(new_response,300,'contenedora1','grafica',false,false,'top','col-md-6','',()=>{

					new_response.forEach((res)=>{
						
					cod_validador = 'cod' + res.codigo;
					if (d3.select('#' + 'contenedora1').select('#' + 'grafica').node()) {
						var div_grafica = d3.select('#' + 'contenedora1').select('#' + 'grafica');
						var type = div_grafica.attr('type');
						
						var svg = d3.select('#' + 'contenedora1').select('#' + 'grafica').select('#svg-' + type + '-' + 'grafica');
						var chart = svg.select('#chart-' + type + '-' + 'grafica');
						if (type == 'torta') var ley = svg.selectAll('.leyenda-torta').select('#' + cod_validador);
						else var ley = svg.selectAll('.leyenda-bar').select('#' + cod_validador);
						
						ley.on("click",()=> {
							enlace_tabla_detalle(res,datos);
							
						});
						chart.selectAll('#' + cod_validador)
						.on("click",()=> {
							enlace_tabla_detalle(res,datos);
						});
					}
					});
					
				});
			}
			//contenido.append('div').attr('id','detalles');
			
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);}
		});

}

function enlace_tabla_detalle(data,dato){
	var nuevo =[];
	

	dato.forEach((res1)=>{
		if(data.codigo==res1.cod_status){
			nuevo.push(res1)
		}
	});
	tabla_detalle(nuevo,data.titulo);
}

function posicion(){
	//console.log($(".toast_container").offset());
	var posicion = ($("#noti").offset())
	$(".toast_container").offset({top:posicion.top + 30,left:posicion.left})
	//console.log(posicion)
	
}

function llenar_tb_novedades_general(){
	var fecha_desde = $('#fecha_desde').val();
	var fecha_hasta = $('#fecha_hasta').val();
	var departamentos = $("#departamentos").val();
	var estatus =  $("#status").val();
	var error = 0;
    var errorMessage = '';
	
	


   if( fechaValida(fecha_desde) !=  true || fechaValida(fecha_hasta) != true){
      var errorMessage = ' Campos De Fecha Incorrectas ';
      var error = error+1;
    }
	


	if(error == 0){
		var parametros = {"departamentos":departamentos , "estatus":estatus , "fecha_desde":fecha_desde , "fecha_hasta":fecha_hasta };

	$.ajax({
		data:  parametros,
		url:   'packages/novedades_rp/views/Get_tb_novedades_general.php',
		type:  'post',
		beforeSend: function () {
			$("#listar").html("<img src='imagenes/loading.gif' /> Procesando, espere por favor...");
			
			},
		success:  function (response) {
			
			$("#listar").html("");
			var data= JSON.parse(response);
			//console.log(data);
			var nuevo =  d3.nest()
			.key((d) => d.codigo_usuario).entries(data);

			var tabla = d3.select('#listar').append('table').attr('width','100%').attr('class','tabla_sistema');
			var tbody = tabla.append('tbody');

			var head = tabla.append('thead').append('tr').attr('class','fondo00');

			head.append('th').attr('class','etiqueta').text("Nombre");
			head.append('th').attr('class','etiqueta').text("Apellido");
			head.append('th').attr('class','etiqueta').text("Perfil");
			head.append('th').attr('class','etiqueta').text("Cantidad de novedades");
	

			var tr =tbody.selectAll("tr").data(nuevo).enter()
			.append("tr").attr('class',(d,i)=>{
				if(i%2==0){
					return "fondo01";
				}else{
					return "fondo02";
				}
			}).on("click",(d)=>{

				//mostrar_general((d.nombre+ " " + d.apellido),d.descripcion,d.cedula,d.codigo,d.cod_perfil,d.cantidad,d.usuario);
						llenar_grafica_novedades_generales((d.values[0].nombre+ " " + d.values[0].apellido),d.values[0].descripcion,d.values[0].cedula,d.values[0].codigo,d.values[0].cod_perfil,d.values.length,d.values[0].usuario);
				//mostrar_pendiente((d.nombre+ " " + d.apellido),d.descripcion,d.cedula,d.codigo,d.cod_perfil,d.cantidad,d.usuario);

			});
			tr.append("td").text((d,i)=>d.values[0].nombre);
			tr.append("td").text((d,i)=>d.values[0].apellido);
			tr.append("td").text((d,i)=>d.values[0].descripcion);
			tr.append("td").text((d,i)=>d.values.length);
			
			
				
				//noti es el elemento de notificacion cargado al inicio del menu
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);}
			});
	}else{
		 alert(errorMessage);
	}

	
	
	

}
/////////////////////////////////////////////////////////////////////////////////////////////77