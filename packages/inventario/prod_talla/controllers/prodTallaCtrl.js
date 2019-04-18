$(function() {
	Cons_talla('', 'agregar');
});

function Cons_talla(cod, metodo){
	var error        = 0;
	var errorMessage = ' ';
	if(error == 0){
		var parametros = { "codigo" : cod, "metodo": metodo, "titulo": "TALLA", "tb": "tallas"};
		$.ajax({
			data:  parametros,
			url:   'packages/general/views/maestros.php',
			type:  'post',
			success:  function (response) {
				$("#Cont_talla").html(response);
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);}
			});
	}else{
		alert(errorMessage);
	}
}