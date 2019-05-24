
function valores(codigo, tipo) {
    var clasif = $('#clasif').val();
    var parametros = { 'clasif': clasif, 'tipo': tipo, 'codigo': codigo };
    //console.log(parametros)
    $.ajax({
        data: parametros,
        url: 'packages/nov_check_trab/views/crear_novedad_valor.php',
        type: 'post',
        success: function (response) {
            //console.log(response)
            $("#contenedor").html(response);

        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });
}

function llenar_nov_tipo(clasificacion) {
    
    var parametros = { 'clasificacion': clasificacion, 'inicial': '' };
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
    var error=0;
    var cedula = '';
    for (const key in parametros) {
        if(parametros[key].name == 'codigo_trabajador'){
            cedula = parametros[key].value;
        }
        var indice = parametros[key].name;
        var valor = parametros[key].value;
        if((indice=="codigo_supervisor" && valor=="") || (indice=="codigo_trabajador" && valor=="")){
            error++;
        }
    }

    if(error<=0){
        if(confirm("Esta seguro que desea guardar la evaluacion")){
            $.ajax({
                data: parametros,
                url: 'packages/nov_check_trab/views/set_check_trab.php',
                type: 'post',
                beforeSend: function(){
                    $("#salvar").attr("disabled",true);
                },
                success: function (response) {
                    $("#salvar").attr("disabled",false);
                    window.location.href = "inicio.php?area=pestanas/Add_ingreso&Nmenu=439&mod=013&archivo=ingreso&codigo="+cedula+"&metodo=modificar";
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });
        }
       
    }else{
        toastr.error(`Tiene que seleccionar un trabajador y un supervisor`, 'ERROR');
    }

}
function Volver(){
    if(confirm("¿Estas seguro de que deseas Cancelar la Evaluación?")){
        window.history.back()
    }
}