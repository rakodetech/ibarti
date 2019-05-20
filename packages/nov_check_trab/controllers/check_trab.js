var inicio;
$(function () {
    inicio = $("#form_reportes").html();
});

function valores(tipo) {
    var clasif = $('#clasif').val();
    var parametros = { 'clasif': clasif, 'tipo': tipo };

    $.ajax({
        data: parametros,
        url: 'packages/nov_check_trab/views/crear_novedad_valor.php',
        type: 'post',
        success: function (response) {
            console.log(response)
            $("#contenedor").html(response);

        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });
}

function llenar_nov_tipo(clasificacion) {

    var parametros = { 'clasificacion': clasificacion, 'inicial': 'TODOS' };
    $.ajax({
        data: parametros,
        url: 'ajax/Add_novedades_tipo.php',
        type: 'post',
        success: function (response) {
            $('#tipo').html(response);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });
}
function agregar_registro(e, i) {
    e.preventDefault();


    var parametros = $("#" + i).serializeArray();
    $.ajax({
        data: parametros,
        url: 'packages/nov_check_trab/views/get_data.php',
        type: 'post',
        success: function (response) {

            toastr.success(`Desea Agregar un nuevo registro:<button type="button" onclick="{$('#reset').click(),toastr.clear();}">SI</button>|<button type="button" onclick="{toastr.clear(),Vinculo('inicio.php?area=formularios/index');}">NO</button>`,'',{
                positionClass:'toast-top-full-width',
                timeOut: 0,
                extendedTimeOut: 0
            });
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });




}