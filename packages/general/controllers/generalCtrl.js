function guardar_registro(){

var codigo = $('#codigo').val();
var descripcion = $('#descripcion').val();
var campo01 = $('#campo01').val();
var campo02 = $('#campo02').val();
var campo03 = $('#campo03').val();
var campo04 = $('#campo04').val();
var tabla 	= $('#tabla').val();
var usuario = $('#usuario').val();
var metodo  = $('#metodo').val();
var activo  = $('#activo').val();

var parametros = {

'codigo':codigo,
'descripcion':descripcion,
'campo01':campo01,
'campo02':campo02,
'campo03':campo03,
'campo04':campo04,
'tabla':tabla,
'usuario':usuario,
'metodo':metodo,
'activo':activo

}
	
	$.ajax({
		data:  parametros,
		url:   'packages/general/modelo/sc_maestros.php',
		type:  'post',
		success:  function (response) {
			
			Cons_upm_inicio();

		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);}
	});
}