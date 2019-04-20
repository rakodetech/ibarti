$(function() {
    Cons_dotacion('');
});

function Cons_dotacion(cod){
    var error        = 0;
    var errorMessage = ' ';
    if(error == 0){
        var parametros = { "codigo" : cod};
        $.ajax({
            data:  parametros,
            url:   'packages/ficha_dotacion/views/Add_form.php',
            type:  'post',
            success:  function (response) {
                $("#Cont_ficha_dotacion").html(response);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);}
            });
    }else{
        alert(errorMessage);
    }
}

function agregar_producto(cod){
    var error        = 0;
    var errorMessage = ' ';
    if(error == 0){
        var parametros = { "codigo" : cod};
        $.ajax({
            data:  parametros,
            url:   'packages/ficha_dotacion/views/Add_form.php',
            type:  'post',
            success:  function (response) {
                $("#Cont_ficha_dotacion").html(response);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);}
            });
    }else{
        alert(errorMessage);
    }
}


function get_sub_lineas(linea){
    var parametros = {
        "codigo": linea
    };
    $.ajax({
        data: parametros,
        url: 'packages/ficha_dotacion/views/Add_sub_linea.php',
        type: 'post',
        success: function (response) {
            $("#sub_lineas").html(response);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });
}

function get_productos(sub_linea){
    var linea = $("#dot_linea").val();
    var parametros = {
        "linea": linea,
        "sub_linea": sub_linea
    };
    $.ajax({
        data: parametros,
        url: 'packages/ficha_dotacion/views/Add_producto.php',
        type: 'post',
        success: function (response) {
            $("#productos").html(response);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });
}