
$("#anular_form").on('submit', function (evt) {
    evt.preventDefault();
    anular();
});

$("#bus_stock_ubic_alcance").on('submit', function (evt) {
    evt.preventDefault();
    buscar_stock_ubic_alcance(true);
});

$(function () {
    //Cons_stock_ubic_alcance();
    Form_stock_ubic_alcance("", "agregar");
});

var lote = "19830906";
var cantidad = 0;
var costo = 0;
var neto = 0;
var producto_cod = "";
var stock_ubic_alcance_cod = "";
var producto_des = "";
var ubicacion_cod = "";
var ubicacion_des = "";
var Ped_detalle = [];
var reng_num = 0;
var index = 0;
var sub_total = 0;
var total = 0;

var stock_actual = 0;//Esta variable es para controlar que los stock_ubic_alcances de salida no sobrepasen el stock actual por ubicacion

var eans = [];
var reng_num = 0;
var index = 0;
var callbackAgregarRenglon;
function buscarMovimiento() {  // CARGAR  ARCHIVO DE AJAX CON UN PARAMETRO//
    //console.log('buscarMovimiento');
    var error = 0;
    var errorMessage = ' ';

    var fecha_desde = $("#fecha_desde").val();
    var fecha_hasta = $("#fecha_hasta").val();
    var tipo_mov = $("#tipo_mov").val();
    var proveedor = $("#proveedor").val();
    var referencia = $("#referencia").val();

    if ((fechaValida(fecha_desde) != true || fechaValida(fecha_hasta) != true) && (fecha_desde != "" || fecha_hasta != "")) {
        var errorMessage = ' Campos De Fecha Incorrectas ';
        var error = error + 1;
    }
    //console.log(fecha_desde,fecha_hasta);
    if (error == 0) {
        var parametros = { fecha_desde: fecha_desde, fecha_hasta: fecha_hasta, tipo_mov: tipo_mov, proveedor: proveedor, referencia: referencia };
        $.ajax({
            data: parametros,
            url: 'packages/inventario/stock_ubic_alcance/views/Buscar_movimiento.php',
            type: 'post',
            beforeSend: function () {
                $("#listar_stock_ubic_alcance").html('<img src="imagenes/loading3.gif" border="null" class="imgLink" width="30px" height="30px">');
            },
            success: function (response) {
                $("#listar_stock_ubic_alcance").html(response);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
    } else {
        toastr.error(errorMessage);
    }
}


function Cons_stock_ubic_alcance() {
    //console.log('Cons_stock_ubic_alcance');

    var parametros = {}
    $.ajax({
        data: parametros,
        url: 'packages/inventario/stock_ubic_alcance/views/Cons_inicio.php',
        type: 'post',
        success: function (response) {
            $("#Cont_stock_ubic_alcance").html(response);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });
}

function Form_stock_ubic_alcance(cod, metodo, cliente, tipo, anulado) {
    //console.log('Form_stock_ubic_alcance');
    var error = 0;
    var errorMessage = ' ';
    stock_ubic_alcance_cod = cod;
    if (error == 0) {
        var parametros = {
            codigo: cod,
            cliente: cliente,
            metodo: metodo,
            anulado: anulado
        };
        $.ajax({
            data: parametros,
            url: 'packages/inventario/stock_ubic_alcance/views/Add_form.php',
            type: 'post',
            success: function (response) {
                $("#Cont_stock_ubic_alcance").html(response);
                if (metodo == "modificar") {
                    //Si el metodo es modificar muestro los botones AGREGAR Y ELIMINAR
                    //$("#borrar_stock_ubic_alcance").removeClass("d-none"); 
                    $("#add_renglon_etiqueta").hide();
                    $("#add_renglon").hide();
                    if (typeof tipo != "undefined") {
                        Form_stock_ubic_alcance_det(cod, metodo, cliente, tipo, () => Reng_ped(cod));
                    }
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
    } else {
        alert(errorMessage);
    }
}

function Form_stock_ubic_alcance_det(cod, metodo, cliente, tipo, callback) {
    //console.log('Form_stock_ubic_alcance_det');
    var error = 0;
    var errorMessage = ' ';
    Ped_detalle = [];
    reng_num = 0;
    sub_total = 0;
    total = 0;
    if (error == 0) {
        var parametros = {
            codigo: cod,
            cliente: cliente,
            cod_tipo: tipo,//Codigo del tipo de stock_ubic_alcance
            metodo: metodo
        };
        $.ajax({
            data: parametros,
            url: 'packages/inventario/stock_ubic_alcance/views/Add_form_det.php',
            type: 'post',
            beforeSend: function () {
                $("#stock_ubic_alcance_det").html('<img src="imagenes/loading3.gif" border="null" class="imgLink" width="30px" height="30px">');
            },
            success: function (response) {
                $("#stock_ubic_alcance_det").html(response);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
    } else {
        alert(errorMessage);
    }

    if (typeof callback == "function") {
        callback();
    }
}

function save_stock_ubic_alcance() {
    //console.log('save_stock_ubic_alcance');
    if (confirm("Esta Seguro de que desea Guardar este movimiento?")) {
        var error = 0;
        var errorMessage = ' ';
        var proced = "p_stock_ubic_alcance";

        var codigo = $("#ped_codigo").val();
        var referencia = $("#ped_referencia").val();
        var tipo = $("#ped_tipo").val();
        var proveedor = $("#ped_proveedor").val();
        var fecha = $("#ped_fecha").val();
        var descripcion = $("#ped_descripcion").val();
        var total = $("#ped_total").val();
        var moneda = $("#ped_moneda").val();
        var metodo = $("#ped_metodo").val();
        var aplicar = $("#ped_aplicar").val();
        var ped_reng = JSON.stringify(Ped_detalle);
        var us = $("#usuario").val();
        if (reng_num == 0) {
            error = 1;
            errorMessage = "Debe de ingresar un articulo";
        }

        if (error == 0) {

            var parametros = {
                nro_stock_ubic_alcance: codigo,
                tipo: tipo,
                proveedor: proveedor,
                fecha: fecha,
                descripcion: descripcion,
                total: total,
                moneda: moneda,
                ped_reng: ped_reng,
                proced: proced,
                us: us,
                metodo: metodo,
                aplicar: aplicar,
                referencia: referencia
            };

            //console.log(parametros);
            $.ajax({
                data: parametros,
                url: 'packages/inventario/stock_ubic_alcance/modelo/stock_ubic_alcance.php',
                type: 'post',
                success: function (response) {
                    //console.log(response);
                    var resp = JSON.parse(response);
                    if (resp.error) {
                        alert(resp.mensaje);
                    } else {
                        if (metodo == "agregar") {
                            if (confirm("Actualización Exitosa!.. \n Desea AGREGAR un NUEVO REGISTRO?")) {
                                Form_stock_ubic_alcance("", "agregar");
                            } else {
                                Cons_stock_ubic_alcance();
                            }
                        } else if (metodo == "modificar") {
                            alert("Actualización Exitosa!..");
                        }
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });

        } else {
            alert(errorMessage);
        }
    }
}

function anular_stock_ubic_alcance() {
    //console.log('anular_stock_ubic_alcance');
    if (confirm("Estas seguro de que deseas ANULAR este stock_ubic_alcance?")) {

        ModalOpen();
        $("#modal_titulo").text("Confirmar Anulación");
    }
}

function anular() {
    //console.log('anular');
    $("#anulador").attr('disabled', true);
    var descripcion = $("#ped_descripcion_anular").val();
    if (descripcion != "") {
        if (confirm("Desea continuar esta Operación?")) {
            var error = 0;
            var errorMessage = ' ';
            var proced = "p_stock_ubic_alcance";

            var codigo = $("#ped_codigo").val();
            var referencia = $("#ped_referencia").val();
            var proveedor = $("#ped_proveedor").val();
            var cod_tipo = $("#ped_cod_tipo").val();
            var tipo = '9999';
            if (cod_tipo == 'DOT') {
                tipo = 'ANU_DOT';
            }
            var fecha = $("#ped_fecha").val();
            var total = $("#ped_total").val();
            var metodo = 'anular';
            var aplicar = "";
            if ($("#ped_aplicar").val() == "IN") {
                aplicar = 'OUT';
            } else if ($("#ped_aplicar").val() == "OUT") {
                aplicar = 'IN';
            }
            //console.log(Ped_detalle);
            var ped_reng = JSON.stringify(Ped_detalle);

            var us = $("#usuario").val();
            if (reng_num == 0) {
                error = 1;
                errorMessage = "Debe de ingresar un articulo";
            }


            if (error == 0) {

                if ($("#ped_aplicar").val() == "IN") {
                    Get_mayor_a_stock(codigo, () => {
                        var parametros = {
                            nro_stock_ubic_alcance: codigo,
                            tipo: tipo,
                            fecha: fecha,
                            descripcion: descripcion,
                            total: total,
                            ped_reng: ped_reng,
                            proced: proced,
                            us: us,
                            metodo: metodo,
                            aplicar: aplicar,
                            referencia: referencia,
                            proveedor: proveedor
                        };

                        $.ajax({
                            data: parametros,
                            url: 'packages/inventario/stock_ubic_alcance/modelo/stock_ubic_alcance.php',
                            type: 'post',
                            beforeSend: function () {
                                $("#anulador").attr("disabled", true);
                            },
                            success: function (response) {
                                //console.log(response);
                                var resp = JSON.parse(response);
                                if (resp.error) {
                                    alert(resp.mensaje);
                                } else {
                                    alert("Actualización Exitosa!..");
                                    CloseModal();
                                    Cons_stock_ubic_alcance()
                                }
                                $("#ped_descripcion_anular").val("");
                                $("#anulador").attr("disabled", false);
                            },
                            error: function (xhr, ajaxOptions, thrownError) {
                                alert(xhr.status);
                                alert(thrownError);
                                $("#anulador").attr("disabled", false);
                            }
                        });
                    });
                } else {
                    var parametros = {
                        nro_stock_ubic_alcance: codigo,
                        tipo: tipo,
                        fecha: fecha,
                        descripcion: descripcion,
                        total: total,
                        ped_reng: ped_reng,
                        proced: proced,
                        us: us,
                        metodo: metodo,
                        aplicar: aplicar,
                        referencia: referencia,
                        proveedor: proveedor
                    };

                    $.ajax({
                        data: parametros,
                        url: 'packages/inventario/stock_ubic_alcance/modelo/stock_ubic_alcance.php',
                        type: 'post',
                        beforeSend: function () {
                            $("#anulador").attr("disabled", true);
                        },
                        success: function (response) {
                            //console.log(response);
                            var resp = JSON.parse(response);
                            if (resp.error) {
                                alert(resp.mensaje);
                            } else {
                                alert("Actualización Exitosa!..");
                                CloseModal();
                                Cons_stock_ubic_alcance()
                            }
                            $("#ped_descripcion_anular").val("");
                            $("#anulador").attr("disabled", false);
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(xhr.status);
                            alert(thrownError);
                            $("#anulador").attr("disabled", false);
                        }
                    });
                }


            } else {
                alert(errorMessage);
                $("#anulador").attr('disabled', false);
            }
        }
    } else {
        alert("La descripcion es requerida");
    }
}
function Borrar_stock_ubic_alcance() {
    //console.log('Borrar_stock_ubic_alcance');
    if (confirm('Esta seguro que desea BORRAR este Registro?..')) {
        var proced = "p_stock_ubic_alcance";
        var codigo = $("#ped_codigo").val();
        var parametros = {
            codigo: codigo,

            proced: proced,
            us: us,
            metodo: "borrar"
        };
        $.ajax({
            data: parametros,
            url: 'packages/inventario/stock_ubic_alcance/modelo/stock_ubic_alcance.php',
            type: 'post',
            success: function (response) {
                var resp = JSON.parse(response);
                if (resp.error) {
                    alert(resp.mensaje);
                } else {
                    alert('Registro Eliminado con exito!..');
                    Cons_stock_ubic_alcance();
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
    }
}

function buscar_stock_ubic_alcance(isBuscar) {
    //console.log('buscar_stock_ubic_alcance');
    var data = $('#data_buscar_stock_ubic_alcance').val() || '';
    $.ajax({
        data: { 'data': data },
        url: 'packages/inventario/stock_ubic_alcance/views/Buscar_movimiento.php',
        type: 'post',
        beforeSend: function () {
            $('#buscarstock_ubic_alcance').attr('disabled', true);
        },
        success: function (response) {
            $("#listar_stock_ubic_alcance").html(response);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
            $('#buscarHorario').attr('disabled', false);
        }
    });
}
//Funcion para ir a la vista Agregar, cuanto se esta en Modificar X
function Agregarstock_ubic_alcance() {
    //console.log('Agregarstock_ubic_alcance');
    var msg = "Desea Agregar un NUEVO REGISTRO?.. ";
    if (confirm(msg)) Form_stock_ubic_alcance('', 'agregar');
}


function mostrar_costo_promedio(codigo, cod_ubicacion) {
    //console.log('mostrar_costo_promedio');
    $.ajax({
        data: { 'codigo': codigo, 'ubicacion': cod_ubicacion },
        url: 'packages/inventario/producto/views/Get_costo_prom.php',
        type: 'post',
        success: function (response) {
            var resp = JSON.parse(response);
            costo = resp[0];
            $("#ped_costo").val(resp[0]);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });
}

function cantidad_maxima(cod_producto, cod_ubicacion) {
    //console.log('cantidad_maxima');
    $.ajax({
        data: { 'producto': cod_producto, 'ubicacion': cod_ubicacion },
        url: 'packages/inventario/stock_ubic_alcance/views/Get_stock.php',
        type: 'post',
        success: function (response) {
            var resp = JSON.parse(response);
            stock_actual = resp[0];
            $("#ped_cantidad").attr('max', resp[0]);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });
}

function Selec_producto(codigo) {
    //console.log('Selec_producto');
    cantidad = 0;
    costo = 0;
    neto = 0;
    Limpiar_producto();
    if ((codigo != "") && (codigo != "undefined")) {
        producto_cod = codigo;
        producto_des = $("#ped_producto").val();
        $("#ped_cantidad").prop('disabled', false);
        if ($("#ped_aplicar").val() == 'IN') {
            get_ubicaciones(() => { }
                //get_ubicacion_default(codigo)
            );
            $("#ped_costo").prop('disabled', false);
        } else {
            get_ubicaciones_stock(codigo);
        }
    } else {
        alert("Debe seleccionar un producto");
    }
}

function Selec_tipo() {
    //console.log('Selec_tipo');
    cliente = $("#ped_cliente").val();
    codigo = $("#ped_tipo").val();
    if ((codigo != "") && (codigo != "undefined") && (cliente != "") && (cliente != "undefined")) {
        var metodo = $("#ped_metodo").val();
        Form_stock_ubic_alcance_det(stock_ubic_alcance_cod, metodo, cliente, codigo);
    }
}

function Selec_ubicacion(codigo) {
    //console.log('Selec_ubicacion');
    if ((codigo != "") && (codigo != "undefined")) {
        ubicacion_cod = codigo;
        if ($("#ped_aplicar").val() == 'OUT') {
            cantidad_maxima(producto_cod, codigo);
        }
        $("#ped_producto").attr("disabled", false);
        ubicacion_des = $("#ped_ubicacion option:selected").text();
    } else {
        $("#ped_producto").attr("disabled", true);
        alert("Debe seleccionar un ubicacion");
    }
}

function Limpiar_producto() {
    //console.log('Limpiar_producto');
    //cantidad = 0;
    //costo = 0;
    //neto = 0;
    $('#ped_cantidad').val(0);
    $('#ped_costo').val(0);
    $('#ped_neto').val(0);
    $("#add_renglon").prop('disabled', true);
    $("#ped_cantidad").prop('disabled', true);
    $("#ped_costo").prop('disabled', true);

}

function get_ubicaciones(cliente, callback) {
    //console.log('get_ubicaciones');
    $.ajax({
        data: { cliente },
        url: 'packages/inventario/stock_ubic_alcance/views/Add_ubicaciones.php',
        type: 'post',
        success: function (response) {
            $("#ped_ubicacion").html(response);
            if (typeof callback == "function") {
                callback();
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });
}

function get_ubicaciones_stock(codigo) {
    //console.log('get_ubicaciones_stock');
    $.ajax({
        data: { 'serial': codigo },
        url: 'packages/inventario/stock_ubic_alcance/views/Add_ubicaciones_stock.php',
        type: 'post',
        success: function (response) {
            $("#ped_ubicacion").html(response);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });
}


function Cal_prod_neto(evento, valor) {
    //console.log('Cal_prod_neto');
    if ((valor == "") && (valor == "undefined")) {
        alert("Ingrese un valor");
    } else {
        var valorX = parseFloat(valor);

        if (evento == "cantidad") {
            cantidad = valorX;
        }
        if (evento == "costo") {
            costo = valorX;
        }

        neto = parseFloat((cantidad * costo).toFixed(2));

        $('#ped_neto').val(neto);
        if (neto > 0) {
            $("#add_renglon").prop('disabled', false);
        } else {
            $("#add_renglon").prop('disabled', true);
        }

    }

}

function Agregar_renglon() {
    //console.log('Agregar_renglon');
    var error = 0;
    var errorMessage = ' ';
    cantidad = Number($("#ped_cantidad").val());
    if ($("#ped_aplicar").val() == 'OUT') {
        if (cantidad > stock_actual) {
            error = 1;
            errorMessage += "\n La cantidad maxima permitida, segun el stock actual de la ubicación es " + stock_actual;
        }
        /*
            var cant= cantidad;
            Ped_detalle.some((stock_ubic_alcance)=>{
                if(stock_ubic_alcance.cod_producto==producto_cod && stock_ubic_alcance.cod_ubicacion==ubicacion_cod){
                        //cant = Number(cant) + Number(stock_ubic_alcance.cantidad);
                        //if(cant>stock_actual){
                            error = 1;
                            errorMessage += "\n El detalle del stock_ubic_alcance sobrepasa la cantidad maxima permitida,para este producto en este ubicacion!:.";  
                            return true;
                        //}
                    }
                });
                */
    }

    Ped_detalle.some((stock_ubic_alcance) => {
        if (stock_ubic_alcance.cod_producto == producto_cod && stock_ubic_alcance.cod_ubicacion == ubicacion_cod) {
            error = 1;
            errorMessage += "\n El registro ya existe en el detalle del movimiento!:.";
            return true;
        }
    });

    if (ubicacion_cod == "") {
        error = 1;
        errorMessage += "\n Debe Seleccionar un ubicacion..";
    }
    if (cantidad < 1) {
        error = 1;
        errorMessage += "\n Cantidad invalida..";
    }

    if (error == 0) {
        getIfEAN(producto_cod, cantidad, false, () => {

            reng_num++;
            var Ped_detalleX = {
                reng_num: reng_num,
                cod_producto: producto_cod,
                producto: producto_des,
                lote: lote,
                cod_ubicacion: ubicacion_cod,
                ubicacion: ubicacion_des,
                cantidad: cantidad,
                eans: []
            };

            Ped_detalle.push(Ped_detalleX);
            var tr = ('<tr id="tr_' + reng_num + '"></tr>');
            var td01 = ('<td><input type="text" id="reng_num_' + reng_num + '" value="' + reng_num + '" readonly style="width:100px"></td>');
            var td02 = ('<td>' + producto_des + '</td>');
            var td03 = ('<td>' + ubicacion_des + '</td>');
            var td04 = ('<td><input type="text" id="cant_' + reng_num + '" value="' + cantidad + '" readonly style="width:100px"></td>');
            var td05 = ('<td><input type="text" id="costo_' + reng_num + '" value="' + costo + '" readonly style="width:100px"></td>');
            var td06 = ('<td><input type="text" id="neto_' + reng_num + '" value="' + neto + '" readonly style="width:150px"></td>');
            var td07 = ('<td><img class="imgLink" border="null" width="20px" height="20px" src="imagenes/actualizar.bmp" onclick="Modificar_renglon(' + reng_num + ')" title="Modificar Registro" />&nbsp;<img  class="imgLink" border="null" width="20px" height="20px" src="imagenes/borrar.bmp"onclick="Borrar_renglon(' + reng_num + ')" title="Borrar Registro"/> </td>');

            $('#listar_stock_ubic_alcance').append(tr);
            $('#tr_' + reng_num + '').append(td01);
            $('#tr_' + reng_num + '').append(td02);
            $('#tr_' + reng_num + '').append(td03);
            $('#tr_' + reng_num + '').append(td04);
            $('#tr_' + reng_num + '').append(td05);
            $('#tr_' + reng_num + '').append(td06);
            $('#tr_' + reng_num + '').append(td07);

            Limpiar_producto();
            $("#ped_producto").val("");
            $("#ped_ubicacion").val("");

        });
    } else {
        alert(errorMessage);
    }
}


function Modificar_renglon(codigo) {
    //console.log('Modificar_renglon');
    index = codigo - 1;
    $("#ped_producto").prop('disabled', true);
    $("#ped_filtro_producto").prop('disabled', true);
    $("#buscarProducto").hide();
    $("#ped_ubicacion").prop('disabled', true);
    $("#ped_cantidad").prop('disabled', false);

    if ($("#ped_aplicar").val() == 'IN') {
        $("#ped_costo").prop('disabled', false);
    }

    $("#add_renglon").prop('hidden', true);
    $("#canc_renglon").prop('hidden', false);
    $("#update_renglon").prop('hidden', false);

    $("#ped_cantidad").val(Ped_detalle[index]["cantidad"]);
    $("#ped_costo").val(Ped_detalle[index]["costo"]);
    $("#ped_neto").val(Ped_detalle[index]["neto"]);

    cantidad = Ped_detalle[index]["cantidad"];
    costo = Ped_detalle[index]["costo"];
    neto = Ped_detalle[index]["neto"];
    if ($("#ped_aplicar").val() == 'OUT') {
        cantidad_maxima(Ped_detalle[index]["cod_producto"], Ped_detalle[index]["cod_ubicacion"]);
    }
    var prod_option = '<option value="' + Ped_detalle[index]["cod_producto"] + '">' + Ped_detalle[index]["producto"] + '</option>';
    $("#ped_producto").html(prod_option);
    var prod_ubicacion = '<option value="' + Ped_detalle[index]["cod_ubicacion"] + '">' + Ped_detalle[index]["ubicacion"] + '</option>';
    $("#ped_ubicacion").html(prod_ubicacion);
    //$("#ped_ubicacion > option value=" + Ped_detalle[index]["cod_ubicacion"] + "]").attr("selected", true);

}

function Cancelar_renglon() {
    //console.log('Cancelar_renglon');
    $("#ped_producto").prop('disabled', false);
    $("#ped_ubicacion").prop('disabled', false);
    $("#ped_filtro_producto").prop('disabled', false);
    $("#buscarProducto").show();
    $("#add_renglon").prop('hidden', false);
    $("#canc_renglon").prop('hidden', true);
    $("#update_renglon").prop('hidden', true);
    Limpiar_producto();
    //var prod_option  = '<option value="">Seleccione...</option>';
    //$("#ped_producto").html(prod_option);
}

function Actualizar_renglon() {
    //console.log('Actualizar_renglon');
    error = 0;
    errorMessage = "";
    cantidad = Number($("#ped_cantidad").val());
    if ($("#ped_aplicar").val() == 'OUT') {
        if (cantidad > stock_actual) {
            error = 1;
            errorMessage += "\n La cantidad maxima permitida, segun el stock actual es " + stock_actual;
        }
    }
    if (error == 0) {
        //console.log(Ped_detalle[index]);
        getIfEAN(Ped_detalle[index]["cod_producto"], cantidad, true, () => {
            var idX = index + 1;
            Ped_detalle[index]["cantidad"] = cantidad;
            Ped_detalle[index]["eans"] = eans;

            $("#cant_" + idX + "").val(cantidad);
            $("#ped_ubicacion").prop('disabled', false);
            Limpiar_producto();

            Cancelar_renglon();
        });
    } else {
        alert(errorMessage);
    }
}

function Borrar_renglon(intemsV) {
    //console.log('Borrar_renglon');
    var datos = Ped_detalle;
    $("#listar_stock_ubic_alcance").html("");
    Ped_detalle = [];
    reng_num = 0;

    jQuery.each(datos, function (i) {
        if (datos[i]["reng_num"] != intemsV) {
            reng_num++;
            datos[i]["reng_num"] = reng_num;
            Ped_detalle.push(datos[i]);
            //console.log(datos[i]);
            var tr = ('<tr id="tr_' + reng_num + '">');
            var td01 = ('<td><input type="text" id="reng_num_' + reng_num + '" value="' + reng_num + '" readonly style="width:100px"></td>');
            var td02 = ('<td>' + datos[i]["producto"] + '</td>');
            var td03 = ('<td>' + datos[i]["ubicacion"] + '</td>');
            var td04 = ('<td><input type="text" id="cant_' + reng_num + '" value="' + datos[i]["cantidad"] + '" readonly style="width:100px"></td>');
            var td05 = ('<td><input type="text" id="costo_' + reng_num + '" value="' + datos[i]["costo"] + '" readonly style="width:100px"></td>');
            var td06 = ('<td><input type="text" id="neto_' + reng_num + '" value="' + datos[i]["neto"] + '" readonly style="width:150px"></td>');
            if (datos[i]["eans"].length > 0) {
                var td07 = ('<td><img class="imgLink" border="null" width="20px" height="20px" src="imagenes/actualizar.bmp" onclick="Modificar_renglon(' + reng_num + ')" title="Modificar Registro" />&nbsp;<img  class="imgLink" border="null" width="20px" height="20px" src="imagenes/borrar.bmp"onclick="Borrar_renglon(' + reng_num + ')" title="Borrar Registro"/> </td>');
            } else {
                var td07 = ('<td><span class="art-button-wrapper"><span class="art-button-l"> </span><span class="art-button-r"> </span><input type="button"  title="Ver Eans" onclick = verEans(' + reng_num + ') class="readon art-button"  value="EANS" /></span><img class="imgLink" border="null" width="20px" height="20px" src="imagenes/actualizar.bmp" onclick="Modificar_renglon(' + reng_num + ')" title="Modificar Registro" />&nbsp;<img  class="imgLink" border="null" width="20px" height="20px" src="imagenes/borrar.bmp"onclick="Borrar_renglon(' + reng_num + ')" title="Borrar Registro"/> </td>');
            }
            $('#listar_stock_ubic_alcance').append(tr);
            $('#tr_' + reng_num + '').append(td01);
            $('#tr_' + reng_num + '').append(td02);
            $('#tr_' + reng_num + '').append(td03);
            $('#tr_' + reng_num + '').append(td04);
            $('#tr_' + reng_num + '').append(td05);
            $('#tr_' + reng_num + '').append(td06);
            $('#tr_' + reng_num + '').append(td07);
        }
    });

}

function Reng_ped(codigo) {
    //console.log('Reng_ped');
    $.ajax({
        data: { 'codigo': codigo },
        url: 'packages/inventario/stock_ubic_alcance/views/Add_renglon.php',
        type: 'post',
        success: function (response) {
            var resp = JSON.parse(response);
            Ped_detalle = resp;
            reng_num = 0;
            jQuery.each(Ped_detalle, function (i) {
                //console.log(Ped_detalle[i]);
                getIfEAN(Ped_detalle[i]['cod_producto'], null, false, () => {
                    Reng_ped_ean(Ped_detalle[i]['cod_stock_ubic_alcance'], Ped_detalle[i]['reng_num'], i)
                });
                reng_num = Ped_detalle[i]["reng_num"];
                //reng_num++;
            });
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });

}

function Reng_ped_ean(stock_ubic_alcance, renglon, index_detalle) {
    //console.log('Reng_ped_ean');
    $.ajax({
        data: { 'stock_ubic_alcance': stock_ubic_alcance, 'renglon': renglon },
        url: 'packages/inventario/stock_ubic_alcance/views/Add_renglon_eans.php',
        type: 'post',
        success: function (response) {
            //console.log(response);
            var resp = JSON.parse(response);
            Ped_detalle[index_detalle]["eans"] = resp;
            //console.log(Ped_detalle);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });

}


function consultar_rp() {
    //console.log('consultar_rp');
    var fecha_desde = $("#fecha_desde").val();
    var fecha_hasta = $("#fecha_hasta").val();
    var ubicacion = $("#ubicacion").val();
    var producto = $("#producto").val();
    var tipo = $("#tipo").val();

    var error = 0;
    var errorMessage = ' ';
    if (fechaValida(fecha_desde) != true || fechaValida(fecha_hasta) != true) {
        var errorMessage = ' Campos De Fecha Incorrectas ';
        var error = error + 1;
    }

    if (error == 0) {
        var parametros = { "fecha_desde": fecha_desde, "fecha_hasta": fecha_hasta, "ubicacion": ubicacion, "producto": producto, "tipo": tipo };
        $.ajax({
            data: parametros,
            url: 'packages/inventario/stock_ubic_alcance/views/Add_inv_mov_inventario.php',
            type: 'post',
            success: function (response) {
                $("#listar").html(response);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
    } else {
        alert(errorMessage);
    }
}

function Add_productos(ubicacion) {
    //console.log('Add_productos');
    $.ajax({
        data: { "codigo": ubicacion },
        url: 'ajax/Add_stock_productos.php',
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

function cargarEANS(item, salida, ubicacion) {
    //console.log('cargarEANS');
    var reng_num_ean = 0;
    var salida = salida ? salida : null;
    var ubicacion = ubicacion ? ubicacion : null;
    console.log('SALIDA: ', salida, '  ubicacion:', ubicacion, ' ITEM: ', item);
    $.ajax({
        data: { 'codigo': item, 'salida': salida, 'ubicacion': ubicacion },
        url: 'packages/inventario/stock_ubic_alcance/views/Add_EANS.php',
        type: 'post',
        success: function (response) {
            //console.log(response);
            eans = [];
            $('#listar_eans').html('');
            var resp = JSON.parse(response);
            if (resp.length > 0) {
                jQuery.each(resp, function (i) {
                    reng_num_ean++;
                    var tr = ('<tr id="tr_ean_' + reng_num_ean + '"></tr>');
                    var td01 = ('<td><input type="text" id="reng_num_ean_' + reng_num_ean + '" value="' + resp[i].cod_ean + '" style="width:300px"></td>');
                    var td02 = ('<td><input name="activo" id="p_activo" type="checkbox" value="T" onclick="selectEAN(' + reng_num_ean + ',this.checked)"/> </td>');

                    $('#listar_eans').append(tr);
                    $('#tr_ean_' + reng_num_ean + '').append(td01);
                    $('#tr_ean_' + reng_num_ean + '').append(td02);
                    $("#prod_ean").val("");
                    $("#boton_guardar_eans").show();
                    $("#span_cant_ing").show();
                });
                eanModalOpen();
            } else {
                toastr.warning('Este producto no tiene EANS disponibles!.');
            }

        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });
}

function getIfEAN(item, cantidad, actualizar, callback) {
    var metodo = $("#ped_metodo").val();
    $.ajax({
        data: { "codigo": item },
        url: 'packages/inventario/stock_ubic_alcance/views/Get_if_EAN.php',
        type: 'post',
        success: function (response) {
            var resp = JSON.parse(response);
            console.log('METODO', metodo);
            if (resp[0] == 'T') {
                if (metodo == 'modificar') {
                    callback();
                } else {
                    if (actualizar) {
                        $("#boton_eans").attr("onclick", "actualizarEans()");
                    } else {
                        $("#boton_eans").attr("onclick", "guardarEans()");
                    }
                    //console.log($("#ped_aplicar").val());
                    if ($("#ped_aplicar").val() == "IN") {
                        cargarEANS(item, false);
                    } else {
                        cargarEANS(item, true, $("#ped_ubicacion").val());
                    }

                    $("#cant_ing").html(cantidad);
                }
            } else {
                //if(metodo != 'modificar'){
                callback();
                //}
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });
}

function guardarEans() {
    //console.log('guardarEans');
    console.log(cantidad, eans);
    if (cantidad == eans.length) {
        reng_num++;
        var Ped_detalleX = {
            reng_num: reng_num,
            cod_producto: producto_cod,
            producto: producto_des,
            cod_ubicacion: ubicacion_cod,
            ubicacion: ubicacion_des,
            cantidad: cantidad,
            eans: eans
        };

        Ped_detalle.push(Ped_detalleX);
        var tr = ('<tr id="tr_' + reng_num + '"></tr>');
        var td01 = ('<td><input type="text" id="reng_num_' + reng_num + '" value="' + reng_num + '" readonly style="width:100px"></td>');
        var td02 = ('<td>' + producto_des + '</td>');
        var td03 = ('<td>' + ubicacion_des + '</td>');
        var td04 = ('<td><input type="text" id="cant_' + reng_num + '" value="' + cantidad + '" readonly style="width:100px"></td>');
        var td05 = ('<td><span class="art-button-wrapper"><span class="art-button-l"> </span><span class="art-button-r"> </span><input type="button"  title="Ver Eans" onclick = verEans(' + reng_num + ') class="readon art-button"  value="EANS" /></span><img class="imgLink" border="null" width="20px" height="20px" src="imagenes/actualizar.bmp" onclick="Modificar_renglon(' + reng_num + ')" title="Modificar Registro" />&nbsp;<img  class="imgLink" border="null" width="20px" height="20px" src="imagenes/borrar.bmp"onclick="Borrar_renglon(' + reng_num + ')" title="Borrar Registro"/> </td>');

        $('#listar_stock_ubic_alcance').append(tr);
        $('#tr_' + reng_num + '').append(td01);
        $('#tr_' + reng_num + '').append(td02);
        $('#tr_' + reng_num + '').append(td03);
        $('#tr_' + reng_num + '').append(td04);
        $('#tr_' + reng_num + '').append(td05);

        Limpiar_producto();
        $("#ped_producto").val("");
        $("#ped_ubicacion").val("");
        eanCloseModal();

    } else {
        alert("Debe seleccionar la cantidad correspondinete de EANS (" + cantidad + ") ");
    }
}

function actualizarEans() {
    //console.log('actualizarEans');
    if (cantidad == eans.length) {
        var idX = index + 1;
        Ped_detalle[index]["cantidad"] = cantidad;
        Ped_detalle[index]["costo"] = costo;
        Ped_detalle[index]["neto"] = neto;
        Ped_detalle[index]["eans"] = eans;

        $("#cant_" + idX + "").val(cantidad);
        $("#costo_" + idX + "").val(costo);
        $("#neto_" + idX + "").val(neto);
        $("#ped_ubicacion").prop('disabled', false);
        Limpiar_producto();

        Cancelar_renglon();
        eanCloseModal();
    } else {
        alert("Debe seleccionar la cantidad correspondinete de EANS (" + cantidad + ") ");
    }
}

function eanModalOpen() {
    //console.log('eanModalOpen');
    $("#eanModal").show();
}

function eanCloseModal() {
    //console.log('eanCloseModal');
    $("#eanModal").hide();
}

function selectEAN(id, estado) {
    //console.log('selectEAN');
    var ean = $('#reng_num_ean_' + id).val();
    //console.log(id, ean, estado);
    if (estado) {
        var index = eans.indexOf(ean);
        if (index > -1) {
            eans[index] = ean;
        } else {
            eans.push(ean);
        }
    } else {
        var index = eans.indexOf(ean);
        eans.splice(index, 1);
    }
    //console.log(eans);
}

function verEans(index) {
    //console.log(Ped_detalle[index-1]['eans']);
    var reng_num_ean = 0;
    $('#listar_eans').html('');
    var resp = Ped_detalle[index - 1]['eans'];
    jQuery.each(resp, function (i) {
        reng_num_ean++;
        var tr = ('<tr id="tr_ean_' + reng_num_ean + '"></tr>');
        var td01 = ('<td><input type="text" id="reng_num_ean_' + reng_num_ean + '" value="' + resp[i] + '" style="width:300px"></td>');
        $('#listar_eans').append(tr);
        $('#tr_ean_' + reng_num_ean + '').append(td01);
        $("#prod_ean").val("");
        $("#boton_guardar_eans").hide();
        $("#span_cant_ing").hide();
    });
    eanModalOpen();
}

function Get_mayor_a_stock(cod_stock_ubic_alcance, callback) {
    $.ajax({
        data: { 'codigo': cod_stock_ubic_alcance },
        url: 'packages/inventario/stock_ubic_alcance/views/Get_if_mayor_stock_actual.php',
        type: 'post',
        success: function (response) {
            var resp = JSON.parse(response);
            if (resp.length > 0) {
                var productos = "";
                resp.forEach((d) => {
                    console.log(d);
                    productos += d.cod_producto + " - ";
                });
                toastr.error(productos, "Es imposible generar esta Operacion porque las cantidades en los siguientes productos superan la existencia actual.");
            } else {
                if (typeof callback === "function") callback();
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });
}