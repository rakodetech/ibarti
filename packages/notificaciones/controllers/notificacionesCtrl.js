var activa=false;
var sonido;
var animacion;
var activado=false;
var nov_notif = [];
var audio = new Audio('packages/notificaciones/sonidos/alarm2.mp3');
var boolean = false;
const colores = ['rgb(32, 163, 6,.7)','rgb(32, 163, 176,.7)','rgb(32, 163, 6,.7)','rgb(32, 163, 176,.7)','rgb(32, 163, 176,.7)','rgb(32, 163, 176,.7)'];
//////////////////////////////////////////////////////////////////////////////////////////////////////////



function mover(){

	animacion=setInterval(()=>{
		if (activado){
			
			$("#opcion").removeClass("animated wobble");
			activado=false;
		}else{
			
			$("#opcion").addClass("animated wobble");
			activado=true;
		}
	},1000);
}

function parar(){
	clearInterval(animacion);

	$("#opcion").removeClass("animated wobble");
}




function activarNotif(){

	var parametros = { };

	$.ajax({
		data:  parametros,
		url:   'packages/notificaciones/views/Get_intervalo_nov.php',
		type:  'post',
		success:  function (response) {
			var res = JSON.parse(response);
			var numero,restante,intervalo,index;
			intervalo = res[0] * 60;
			
			if (sessionStorage.getItem('condi')=='T'){
				obtener_cantidad_nov();
			}else{
				//console.log(sessionStorage.getItem('condi'));
				obtener_cantidad_nov();
				sessionStorage.setItem('condi',"T");
				//console.log(sessionStorage.getItem('condi'));
			}
			//continuar con storage
			timer = setInterval(()=>{

				numero = Number(sessionStorage['numero']);
				numero = numero + 1;
				
				sessionStorage.setItem('numero',numero);
				
				restante = intervalo - Number(sessionStorage['numero']);
				
				if (restante==0){
					clearInterval(sonido);
					parar();
					sessionStorage.setItem('numero',0);
					obtener_cantidad_nov_reciente();
					index = $('#noti').attr("data-count-notificacion");
					
					if((Number(index) > 0)){
						mover();
						activar_sonido();
						cargar_recientes();
					}
				}
				
			},1000);
			
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);}
		});


	//////////////////////////////////////
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////


function activar_sonido(){

	sonido = setInterval(()=>{
		audio.play();
	},2000);
}

function obtener_cantidad_nov_reciente() {
	var parametros = { }
	
	$.ajax({
		data:  parametros,
		url:   'packages/notificaciones/views/Get_nov_notif.php',
		type:  'post',
		success:  function (response) {

			nov_notif = JSON.parse(response);

			$('#noti').attr("data-count-notificacion",nov_notif.length);
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);}
		});

}


function cargar_recientes(){
	var parametros = { }

	$.ajax({
		data:  parametros,
		url:   'packages/notificaciones/views/Get_nov_reciente.php',
		type:  'post',
		success:  function (response) {
			var res= JSON.parse(response);
			//obtener_cantidad_nov_reciente();
		//	console.log('ejecu')

		//	console.log(response)
		if (res.length != 0){

			res.forEach((res)=>{
				mostrar_toast_notif(res['descripcion'], res['nombre'],res['fecha'],res['codigo'],res['stat'],res['observacion'],10000);
				if($('#cod_'+ res['codigo']).length != 0){
					$('#cod_'+ res['codigo']).remove();
				}
				crear_div('llenar',res['descripcion'], res['nombre'],res['fecha'],res['codigo'],res['cod_proc'],res['stat'],res['observacion'],res['cedula'],res['color']);

			});
		}

				//noti es el elemento de notificacion cargado al inicio del menu
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);}
			});

}


function cargar_novedades() {
	
	
	nov_notif.forEach((res)=>{
		//mostrar_toast_notif(res['descripcion'], res['nombre'],res['fecha'],res['codigo'],res['stat'],res['observacion'],0);
		crear_div('llenar',res['descripcion'], res['nombre'],res['fecha'],res['codigo'],res['cod_proc'],res['stat'],res['observacion'],res['cedula'],res['color']);
		
	});
	
}


/////////////////////////////////////
function transformar_rbg(e,t){
	var r,g,b,rgbh;
	r=e.slice(1,3);
	g=e.slice(3,5);
	b=e.slice(5);
	rgbh = `rgb(${parseInt(r,16)},${parseInt(g,16)},${parseInt(b,16)},${t})`;
	
	return rgbh
}


function crear_div(id_contenedor,descripcion,nombre,fecha,codigo,cod_proc,status,observacion,cedula,color){
	var color_nuevo = transformar_rbg(color,'.8');
	$('#'+id_contenedor).append(`
		<li id='cod_${codigo}'class='caja' style="background:${color_nuevo};display:block;" >

		<table width = '100%' onclick="window.location.href='inicio.php?area=formularios/Add_novedades2&Nmenu=444&mod=006&codigo=${codigo}&metodo=modificar'">
		<tr>
		<td rowspan='3' width='10%'>
		<img id='${codigo}' class='foto_notif' src="imagenes/fotos/${cedula}.jpg" onerror="$('#${codigo}').attr('src','imagenes/foto.jpg')"></img>
		</td>
		<td class='titulo_notif'>${descripcion}</td>


		<td class='fecha_notif'><img src='imagenes/icono-calendario.gif' style='width:15px;'></img><b>${fecha}<b></td>
		</tr>
		<tr >
		<td class='descripcion_notif' colspan='2'>
		${observacion}
		</td>
		</tr>
		<tr>
		<td class='nombre_notif'>Att:"${nombre}"</td>
		<td class='notificacion_notif'>(${status})</td>
		</tr>
		</table>

		</li>
		`);
	
	

}
/////////////////////////////////////////
function obtener_cantidad_nov() {
	var parametros = { }
	
	$.ajax({
		data:  parametros,
		url:   'packages/notificaciones/views/Get_nov_notif.php',
		type:  'post',
		success:  function (response) {

			nov_notif = JSON.parse(response);
			
			

			$('#noti').attr("data-count-notificacion",nov_notif.length);

			$('#noti').on("click",()=>{
				

				if(nov_notif.length != 0){

					if (activa){
					/*
					nov_notif.forEach((res,i)=>{
						if(i<(nov_notif.length - 1)){
							$('#cod_'+ res['cod_proc']).removeClass('animated fadeInLeft');
							$('#cod_'+ res['cod_proc']).addClass('animated fadeOutLeft');
						}else{
							$('#cod_'+ res['cod_proc']).removeClass('animated fadeInLeft');
							$('#cod_'+ res['cod_proc']).addClass('animated fadeOutLeft');
							
						}
					});*/


					$('#llenar').removeClass('animated fadeInLeft');
					$('#llenar').addClass('animated fadeOutLeft');
					$(".toast_container").fadeOut(400);
					$(".triangulo").fadeOut(400);
					activa=false;
					toastr.clear();
					

				}else{
					
					
					activa=true;
					$("#opcion").stop();
					//
					parar();
					clearInterval(sonido);
					
					var cant=$('#llenar').children();
					if(!(cant.length>0)){
						var posicion = ($("#noti").offset())
						$(".toast_container").offset({top:posicion.top + 37,left:posicion.left - 30});
						$(".triangulo").offset({top:posicion.top + 25,left:posicion.left + 7});
						cargar_novedades();
					}
					
					$(".toast_container").fadeIn(400);
					$(".triangulo").fadeIn(400);
					//nov_notif.forEach((res,i)=>{
						$('#llenar').removeClass('animated fadeOutLeft');
						$('#llenar').addClass('animated fadeInLeft');
					//});
				}


			}

			

		})
			;
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);}
		});

}

function notificaciones(titulo,cuerpo){
	var configuracion = {
		positionClass: "toast-bottom-rigth",
		"positionClass": "",
		"closeButton": true ,
		timeOut: 0
	}
	toastr.error(cuerpo,titulo,configuracion);
}


function mostrar_toast_notif(descripcion,fecha,nombre,codigo,status,observacion,para){

	var msg =  `${observacion} // ${fecha} (${status})`; 
	var titulo = `${descripcion} ${nombre}` ;

	var opciones ={
		positionClass: "toast-bottom-left",
		timeOut: para,
		"closeButton": true ,
		"preventDuplicates": false
		,
		extendedTimeOut: "0",
		onclick: ()=> {
			window.location.href="inicio.php?area=formularios/Add_novedades2&Nmenu=444&mod=006&codigo=" + codigo + "&metodo=modificar";
			toastr.clear();
		} 	
	};
	toastr.success(msg,titulo,opciones);
	
}



