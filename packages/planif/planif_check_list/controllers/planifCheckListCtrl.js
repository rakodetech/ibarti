function Add_filtroX() { // CARGAR  ARCHIVO DE AJAX CON UN PARAMETRO //
    console.log('Add_filtroX');
    var rol = $("#rol").val();
    var region = $("#region").val();
    var estado = $("#estado").val();
    var cliente = $("#cliente").val();
    var ubicacion = $("#ubicacion").val();
    var proyecto = $("#proyecto").val();
    var actividad = $("#actividad").val();

    var trabajador = $("#stdID").val();
    var fecha_desde = $("#fecha_desde").val();
    var fecha_hasta = $("#fecha_hasta").val();
    var Nmenu = $("#Nmenu").val();
    var mod = $("#mod").val();
    var archivo = $("#archivo").val();

    var error = 0;
    var errorMessage = ' ';
    if (fechaValida(fecha_desde) != true || fechaValida(fecha_hasta) != true) {
        var errorMessage = ' Campos De Fecha Incorrectas ';
        var error = error + 1;
    }

    if (rol == '') {
        var error = error + 1;
        errorMessage = errorMessage + ' \n Debe Seleccionar un Rol ';
    }

    if (cliente == '') {
        var error = error + 1;
        errorMessage = errorMessage + ' \n Debe Seleccionar un Cliente ';
    }
    if (error == 0) {
        var parametros = {
            "rol": rol,
            "region": region,
            "estado": estado,
            "cliente": cliente,
            "ubicacion": ubicacion,
            "trabajador": trabajador,
            "fecha_desde": fecha_desde,
            "fecha_hasta": fecha_hasta,
            "proyecto": proyecto,
            "actividad": actividad,
            "Nmenu": Nmenu,
            "mod": mod,
            "archivo": archivo
        };
        $.ajax({
            data: parametros,
            url: 'ajax_rp/Add_pl_participantes_check_list.php',
            type: 'post',
            beforeSend: function() {
                $("#img_actualizar").remove();
                $("#lista").html("<img src='imagenes/loading.gif' /> Procesando, espere por favor...");
            },
            success: function(response) {
                $("#lista").html(response);
                $("#cont_img").html("<img class='imgLink' id='img_actualizar' src='imagenes/actualizar.png' border='0'  onclick='Add_filtroX()'>");
            },

            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
    } else {
        alert(errorMessage);
    }
}

function openModalCheckList(codigo) {
    var usuario = $("#usuario").val();
    
    $("#myModalCheckList").show();
    var parametros = {
       codigo,
       usuario
    };
    $.ajax({
        data: parametros,
        url: 'packages/planif/planif_check_list/views/Add_check_list.php',
        type: 'post',
        beforeSend: function() {
            $("#modal_check_list_contenido").html("<img src='imagenes/loading.gif' /> Procesando, espere por favor...");
        },
        success: function(response) {
            $("#modal_check_list_contenido").html(response);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });
}

function cerrarModalCheckList(refresh) {
    $("#myModalCheckList").hide();
    if(refresh==true){
        Add_filtroX();
    }
}

function cargar_actividades(proyecto) {
    var parametros = {
        "codigo": proyecto
    };
    $.ajax({
        data: parametros,
        url: 'ajax/Add_actividades_participantes.php',
        type: 'post',
        success: function(response) {
            $("#actividad").html(response);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });
}


function guardarCheckList() {
    var parametros = {
    };
    var dataForm = $("#add_check_list").serializeArray();

    var elems = $( "[name^='check_list[]']" );

    for (let index = 0; index < dataForm.length; index++) {
        const element = dataForm[index];
        if(element.name != 'check_list[]'){
            parametros[element.name] = element.value;
        }
    }

    var check_list = [];
    for (let index = 0; index < elems.length; index++) {
        const element = elems[index];
        check_list.push(element.value);
    }

    parametros["check_list[]"] = check_list;
    
    $.ajax({
        data: parametros,
        url: 'packages/planif/planif_check_list/modelo/sc_novedades_check_list.php',
        type: 'post',
        success: function(response) {
           var resp = JSON.parse(response);
           if (resp.error == true){
            toastr.error(resp.mensaje);
           }else{
            toastr.success("Evaluación guardada con exito!");
            cerrarModalCheckList(true);
           }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });
}


function Add_ajax01(codigo, archivo, contenido) { // CARGAR  ARCHIVO DE AJAX CON UN PARAMETRO//
    if (codigo != '') {
        var parametros = {
            codigo,
            archivo,
            contenido
        };
        $.ajax({
            data: parametros,
            url: archivo,
            type: 'post',
            success: function(response) {
                $("#" + contenido).html(response);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
    }
}