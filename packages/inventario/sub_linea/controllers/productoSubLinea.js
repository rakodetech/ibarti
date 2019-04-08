$(function() {
	Form_prod_modelo("", "agregar");
    //Form_prod_modelo(1, "modificar");

});

function Form_prod_modelo(cod, metodo) {
    CloseModal();
    var error = 0;
    var errorMessage = ' ';
    
    if (error == 0) {
        var parametros = {
            codigo: cod,
            metodo: metodo
        };
        $.ajax({
            data: parametros,
            url: 'packages/inventario/sub_linea/views/Add_form.php',
            type: 'post',
            beforeSend: function(){
                $("#Cont_prod_sub_linea").html('<img src="imagenes/loading3.gif" border="null" class="imgLink" width="30px" height="30px">');
            },
            success: function(response) {
                $("#Cont_prod_sub_linea").html(response);
                $('#metodo').val(metodo);
                if(metodo == "modificar"){
                    $("#codigo").attr('disabled',true);
                    $('#borrar_modelo').show();
                    $('#agregar_modelo').show();
                }
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

function save(){

    var error = 0;
    var errorMessage    = ' ';

    var codigo          = $("#codigo").val();
    var linea       = $("#linea").val();
    var descripcion     = $("#descripcion").val();

    var activo          = Status($("#activo:checked").val());
    var color          = Status($("#color:checked").val());
    var talla          = Status($("#talla:checked").val());
    var peso          = Status($("#peso:checked").val());
    var piecubico          = Status($("#piecubico:checked").val());

    var usuario         = $("#usuario").val();
    var metodo          = $("#metodo").val();
    var proced          = "p_prod_sub_lineas";


    if(error == 0){

       var parametros = {"codigo": codigo,"linea": linea,"descripcion": descripcion, "activo": activo,
       "color": color,"peso": peso,"talla": talla,"piecubico": piecubico,'proced':proced,'metodo':metodo,'usuario':usuario};
       $.ajax({
        data:  parametros,
        url:   'packages/inventario/sub_linea/modelo/prod_sub_linea.php',
        type:  'post',
        success:  function (response) {
            console.log(response);
            resp = JSON.parse(response);
            if(resp.error){
                toastr.error(resp.mensaje);
            }else{
                toastr.success("Actualización Exitosa!..");
                if(metodo == "agregar") {
                    if(confirm("Desea AGREGAR un NUEVO REGISTRO?.")){
                        Form_prod_modelo("", "agregar");
                    }else{
                        Form_prod_modelo(codigo, "modificar");
                    }
                }
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            toastr.error(xhr.status+" "+thrownError);}
        });
   }else{
    toastr.warning(errorMessage);
}
}

function B_modelos(){
  ModalOpen();
  $.ajax({
    data: {"data": null},
    url:   'packages/inventario/sub_linea/views/Cons_sub_lineas.php',
    type:  'POST',
    beforeSend: function(){
        $("#contenido_tabla").html('<img src="imagenes/loading3.gif" border="null" class="imgLink" width="30px" height="30px">');
    },
    success:  function (response) {
        $("#filtro").val("");
        $("#modal_titulo").text("Buscar Producto Modelo");
        $("#contenido_tabla" ).html(response);
    },
    error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.status);
        alert(thrownError);}
    });
}

function buscar(data){
    var parametros = {"data": data};
    $.ajax({
        data: parametros,
        url:   'packages/inventario/sub_linea/views/Cons_sub_lineas.php',
        type:  'POST',
        beforeSend: function(){
            $("#contenido_tabla").html('<img src="imagenes/loading3.gif" border="null" class="imgLink" width="30px" height="30px">');
        },
        success:  function (response) {
            $("#contenido_tabla" ).html(response);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);}
        });
}

function borrarModelo(){
    if(confirm('Esta seguro que desea BORRAR este Registro?..')){
        var usuario = $("#usuario").val();
        var cod = $("#codigo").val();
        var parametros = {
            "codigo": cod, "tabla": "prod_modelo",
            "usuario": usuario
        };
        $.ajax({
            data: parametros,
            url: 'packages/general/controllers/sc_borrar.php',
            type: 'post',
            success: function (response) {
                var resp = JSON.parse(response);
                if (resp.error) {
                    toastr.error(resp.mensaje);
                } else {
                    toastr.success('Registro Eliminado con exito!..');
                    Form_prod_modelo('', 'agregar');
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                toastr.warning(xhr.status+"  "+thrownError);
            }
        });
    }
}
//Funcion para ir a la vista Agregar, cuanto se esta en Modificar X
function irAAgregarModelo(){
    var msg = "Desea Agregar un NUEVO REGISTRO?.. ";
    if(confirm(msg)) Form_prod_modelo("", "agregar");
}

function get_sub_lineas(linea){
    var parametros = {
        "codigo": linea
    };
    $.ajax({
        data: parametros,
        url: 'packages/inventario/producto/views/Add_sub_linea.php',
        type: 'post',
        success: function (response) {
            $("#sub_linea").html(response);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });
}