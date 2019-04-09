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

function save_producto(){

    var error = 0;
    var errorMessage    = ' ';
    var proced          = "p_productos";

    var codigo          = $("#p_codigo").val();
    var linea           = $("#p_linea").val();
    var sub_linea       = $("#p_sub_linea").val();
    var color           = $("#p_color").val();
    var prod_tipo       = $("#p_prod_tipo").val();
    var unidad          = $("#p_unidad").val();
    var proveedor       = $("#p_proveedor").val();
    var iva             = $("#p_iva").val();
    var descripcion     = $("#p_descripcion").val();
    var procedencia     = $("#p_procedencia").val();
    /*var cost_actual     = $("#cos_actual").val();
    var cost_promedio   = $("#cos_promedio").val();
    var cost_ultimo     = $("#cos_ultimo").val();*/
    var stock_actual    = $("#stock_actual").val();
    var stock_comp      = $("#stock_comp").val();
    var stock_llegar    = $("#stock_llegar").val();
    var punto_pedido    = $("#punto_pedido").val();
    var stock_maximo    = $("#stock_maximo").val();
    var stock_minimo    = $("#stock_minimo").val();
    var prec_vta1       = $("#prec_vta1").val();
    var prec_vta2       = $("#prec_vta2").val();
    var prec_vta3       = $("#prec_vta3").val();
    var prec_vta4       = $("#prec_vta4").val();
    var prec_vta5       = $("#prec_vta5").val();
    var garantia        = $("#garantia").val();
    var talla           = $("#talla").val();
    var peso            = $("#peso").val();
    var piecubico       = $("#piecubico").val();
    var venc            = $('input:radio[name=venc]:checked').val();
    var fec_venc        = $("#fec_venc").val();
    var campo01         = $("#campo01").val();
    var campo02         = $("#campo02").val();
    var campo03         = $("#campo03").val();
    var campo04         = $("#campo04").val();

    var activo          = Status($("#p_activo:checked").val());
    var usuario         = $("#usuario").val();
    var metodo          = $("#p_metodo").val();

    if(error == 0){
        var parametros = {"codigo": codigo, "activo": activo, "linea": linea,         
        "sub_linea" : sub_linea, "color": color,         "prod_tipo": prod_tipo ,
        "unidad": unidad , "proveedor": proveedor , "iva": iva , "descripcion": descripcion ,
        "procedencia": procedencia, "cos_actual":"100", "cos_promedio":"100","cos_ultimo":"100",
        "stock_actual":stock_actual,"stock_comp":stock_comp,"stock_llegar":stock_llegar,
        "punto_pedido":punto_pedido,"stock_maximo": stock_maximo,"stock_minimo": stock_minimo,
        "prec_vta1":prec_vta1, "prec_vta2":prec_vta2,"prec_vta3":prec_vta3, "prec_vta4":prec_vta4,
        "prec_vta5":prec_vta5,"garantia": garantia, "talla":talla, "peso": peso,"piecubico":piecubico,
        "venc": venc, "fec_venc":fec_venc,
        "campo01":campo01,"campo02":campo02,"campo03":campo03,"campo04":campo04,
        "proced": proced, "usuario": usuario, "metodo":metodo };

        $.ajax({
            data:  parametros,
            url:   'packages/inventario/producto/modelo/producto.php',
            type:  'post',
            success:  function (response) {
                var resp = JSON.parse(response);
                if(resp.error){
                    alert(resp.mensaje);
                }else{
                    if(metodo == "agregar") {
                        if(confirm("Actualización Exitosa!.. \n Desea AGREGAR un NUEVO REGISTRO?")){
                            Cons_producto("", "agregar");
                        }else{
                            Cons_producto(codigo, "modificar");
                        }
                    }else if(metodo == "modificar"){
                        alert("Actualización Exitosa!..");
                    }
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