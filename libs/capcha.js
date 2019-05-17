var us   = ''; usuario
var l    = '';  login 
var t    = '';

    $("#captcha").text(code); donde se carga la captcha
    $("#log_cap").val('') // capcha ingresada por el usuario


Ver_log() // funcion de verificar datos de login



var us   = '';
var l    = '';
var t    = '';

var code = '';

$(function() {
	var parametros = {};
	$.ajax({
		data:  parametros,
		url:   'packages/sistema/inicio/views/Cons_inicio.php',
		type:  'post',
		success:  function (response) {
			$("#Cont_inicio").html(response);
			captcha();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);}
		});
});

function captcha(){
	var alpha = new Array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
	var alpha02 = new Array('i','p');
	var i;
		for (i=0;i<6;i++){
			var a = alpha02[Math.floor(Math.random() * alpha02.length)];
			var b = alpha[Math.floor(Math.random() * alpha.length)];
			var c = alpha[Math.floor(Math.random() * alpha.length)];
			var d = alpha[Math.floor(Math.random() * alpha.length)];
			var e = alpha[Math.floor(Math.random() * alpha.length)];
		}
	//  var code = a + ' ' + b + ' ' + c + ' ' + d + ' ' + e;
	code = a + ' ' + b + ' ' + c + ' ' + d ;
	$("#captcha").text(code);
	$("#log_cap").val('');
}

function removeSpaces(valorX){
	return valorX.split(' ').join('');
}

function Ver_log(){
	l        = $("#log_us").val();
	var p    = $("#log_p").val();
	var cap  = $("#log_cap").val();
	var error = 0;
	var errorMessage = "";

	if(l.length <4){
		var error = 1;
		var errorMessage = "Debe Ingresar un login Valido";
	}

	if((p.length <2) && (error == 0)){
		var error = 1;
		var errorMessage = "Debe Ingresar una Contraseña";
	}

	if((removeSpaces(code) != cap ) && (error == 0)){
		var error = 1;
		var errorMessage = "Captcha Invalidad";
		 captcha();
	}

	if (error == 0) {

	var parametros = {l:l,p:p,metodo:"verificar_us",proced:"p_api_usuario"}
		$.ajax({
				data:  parametros,
				url:   'packages/sistema/inicio/modelo/login.php',
				type:  'post',
				success:  function (response) {
					var resp = JSON.parse(response);
					if((resp.error == "TRUE") && (resp.error== "VENC")) {
						captcha();
						$("#log_us").val('');
						$("#log_p").val('');
						r = confirm("Contraseña Vencida, ¿Desea Actualizar Contraseña?");
				    if (r == true) {

							$('#Modal_lg').modal("show");
							$("#modal_titulo").text("Actualizar Contraseña");
								 var parametros = {l:l};
							$.ajax({
									data:  parametros,
									url:   'packages/sistema/inicio/views/Act_password.php',
									type:  'post',
									success:  function (response) {
										$("#cont_modal").html(response);
									},
								error: function (xhr, ajaxOptions, thrownError) {
										alert(xhr.status);
										alert(thrownError);}
							});
				    }

					}else if (resp.error== "TRUE") {
						alert(resp.mensaje);
						captcha();
						$("#log_us").val('');
					  $("#log_p").val('');



					}else {
						t = resp.tok;
						cargar_menu();
						inicio();
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

function inicio(){
	var parametros = {}
			$.ajax({
				data:  parametros,
				url:   'packages/sistema/inicio/index.php',
				type:  'post',
				success:  function (response) {
					$("#Cont_inicio").html(response);
				},
			error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status);
					alert(thrownError);}
		});
}


function cargar_menu(){
	var parametros = {l:l,t:t,metodo:"verificar_us" }
			$.ajax({
				data:  parametros,
				url:   'packages/sistema/inicio/views/menu.php',
				type:  'post',
				success:  function (response) {
					$("#listar_menu").html(response);
					Config_sistema();
				},
			error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status);
					alert(thrownError);}
		});
}


function Men_modulo(cod, tok){
	var parametros = {mod:cod,l:l,t:tok}

	$.ajax({
		data:  parametros,
		url:   'packages/sistema/inicio/views/menu_modulo_perfil.php',
		type:  'post',
		success:  function (response) {
			$("#cont_sub_menu").html(response);
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);}
		});
//	Menu_det(cod, perfil);
}


function Cargar_link(link){
	var link2 = link+".php";
//	alert(link2);
//	var link2 = "packages/sistema/usuario/index.php";
//	alert(link2);
	var parametros = {usuario:us,t:t}
		$.ajax({
			data:  parametros,
			url:   link2,
			type:  'post',
			success:  function (response) {
				$("#Cont_inicio").html(response);
			},
		error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);}
	});
}

function Config_sistema(){
	var parametros = {l:l,t:t}
		$.ajax({
				data:  parametros,
				url:   'packages/sistema/inicio/views/config.php',
				type:  'post',
				success:  function (response) {
					var resp = JSON.parse(response);
					us   = resp.codigo;
					$('#sis_cl_n').text(resp.cl);
					$('#sis_us').text(resp.us);
					$('#sis_us').text(resp.us);
					$('#sis_salir').val(resp.url);
					$('#sis_us_img').prop('hidden',false);
					$('#sis_cl').prop('hidden',false);
					$('#sis_salir').prop('hidden',false);

				},
			error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status);
					alert(thrownError);}
		});
}

function Salir(valor){
	window.location.href = ""+valor+"";
}