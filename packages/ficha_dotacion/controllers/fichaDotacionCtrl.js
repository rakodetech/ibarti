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
                cargar_dotacion();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);}
            });
    }else{
        alert(errorMessage);
    }
}

function cargar_dotacion(){
  var error        = 0;
  var errorMessage = ' ';
  var ficha = $("#cod_ficha").val();

  if(error == 0){
    var parametros = { "codigo" : ficha};
    $.ajax({
        data:  parametros,
        url:   'packages/ficha_dotacion/views/Add_dotacion.php',
        type:  'post',
        success:  function (response) {
            $("#ficha_dotacion_det").html(response);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);}
        });
}else{
    alert(errorMessage);
}
}

function agregar_renglon(){
    var error        = 0;
    var errorMessage = ' ';
    var producto = $("#dot_producto").val();
    var cantidad = $("#dot_cantidad").val();
    var usuario         = $("#usuario").val();
    var ficha = $("#cod_ficha").val();
    if(producto == ""){
        error = 1;
        errorMessage = "Debe Seleccionar un Producto";
    }
    if(error == 0){
    var parametros = { "metodo": "agregar","codigo":ficha,"serial" : producto, 
    "cantidad":cantidad, "proced":"p_ficha_dotacion", "usuario":usuario};
    $.ajax({
        data:  parametros,
        url:   'packages/ficha_dotacion/modelo/ficha_dotacion.php',
        type:  'post',
        success:  function (response) {
            var resp = JSON.parse(response);
            if(resp.error){
               toastr.error(resp.mensaje);
           }else{
            toastr.success("Actualización Exitosa!..");
            cargar_dotacion();
        }

    },
    error: function (xhr, ajaxOptions, thrownError) {
        toastr.error(xhr.status);
        toastr.error(thrownError);}
    });
}else{
    toastr.warning(errorMessage);
}
}

function eliminar_renglon(cod){
 if(confirm("Esta seguro de borrar este REGISTRO?")){
    var error        = 0;
    var errorMessage = ' ';
    var usuario         = $("#usuario").val();
    var ficha = $("#cod_ficha").val();
    if(error == 0){

        var parametros = { "metodo": "eliminar","codigo":ficha,"serial" : cod, 
        "cantidad":"", "proced":"p_ficha_dotacion", "usuario":usuario};
        $.ajax({
            data:  parametros,
            url:   'packages/ficha_dotacion/modelo/ficha_dotacion.php',
            type:  'post',
            success:  function (response) {
                var resp = JSON.parse(response);
                if(resp.error){
                   toastr.error(resp.mensaje);
               }else{
                toastr.success("Actualización Exitosa!..");
                cargar_dotacion();
            }

        },
        error: function (xhr, ajaxOptions, thrownError) {
            toastr.error(xhr.status);
            toastr.error(thrownError);}
        });
    }else{
        toastr.error(errorMessage);
    }
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
    console.log(linea,sub_linea);
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

function Modificar_renglon(serial,ficha,indice){
    var error        = 0;
    var errorMessage = ' ';
    var cantidad = $("#cant_"+indice).val();
    var usuario         = $("#usuario").val();
    if(error == 0){
    var parametros = { "metodo": "modificar","codigo":ficha,"serial" : serial, 
    "cantidad":cantidad, "proced":"p_ficha_dotacion", "usuario":usuario};
    $.ajax({
        data:  parametros,
        url:   'packages/ficha_dotacion/modelo/ficha_dotacion.php',
        type:  'post',
        success:  function (response) {
            var resp = JSON.parse(response);
            if(resp.error){
               toastr.error(resp.mensaje);
           }else{
            toastr.success("Actualización Exitosa!..");
            cargar_dotacion();
        }

    },
    error: function (xhr, ajaxOptions, thrownError) {
        toastr.error(xhr.status);
        toastr.error(thrownError);}
    });
}else{
    toastr.error(errorMessage);
}
}