var datos_consulta = [];
var datos_consulta_dotacion = [];
var datos_consulta_omitir = [];


function cons_inicio(vista, metodo, callback) {
    var url = "";
    switch (vista) {
        case 'vista_dotacion':
            url = "packages/dotacion_movimiento/views/vista_lote_dotacion.php";
            break;

        case 'vista_recepcion':
            url = "packages/dotacion_movimiento/views/vista_lote_dotacion.php";
            break;
        case 'clo':
            url = "packages/dotacion_movimiento/views/Buscar_dotacion.php";
            break;
        case 'cla':
            url = "packages/dotacion_movimiento/views/Buscar_dotacion.php";
            break;
        case 'vla':
            url = "packages/dotacion_movimiento/views/Buscar_dotacion.php";
            break;
        case 'vlo':
            url = "packages/dotacion_movimiento/views/Buscar_dotacion.php";
            break;
    }
    if (url != "") {
        $.ajax({
            data: { view: vista },
            url: url,
            type: 'post',
            success: function (response) {
                document.getElementById("contendor").innerHTML = response;
                if (typeof (callback) == "function") {
                    callback();
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
    }

}

function consultar_existente(codigo) {

    //var codigo = document.getElementById('cod').value;
    var metodo = document.getElementById('metodo').value;
    var vista = document.getElementById('vista').value;
    var usuario = document.getElementById('us').value;

    var parametros = {
        cod: codigo,
        us: usuario,
        vista: vista
    }
    $.ajax({
        data: parametros,
        url: 'packages/dotacion_movimiento/views/Get_listado_existente.php',
        type: 'post',
        success: function (response) {
            console.log(response);
            datos_consulta_dotacion = JSON.parse(response);
            datos_consulta_dotacion.forEach((res) => {
                datos_consulta_omitir.push(res.cod_dotacion);
            });

            filtrado('', 'out');
            //document.getElementById('consulta_contenido').innerHTML = response;

        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });
}

function llenar_consulta(codigo, vista, metodo) {
    metodo = (typeof metodo == "undefined") ? document.getElementById('metodo').value : metodo
    vista = (typeof vista == "undefined") ? document.getElementById('vista').value : vista

    var parametros = {
        cod: codigo,
        vista: vista,
        metodo: metodo
    }
    $.ajax({
        data: parametros,
        url: 'packages/dotacion_movimiento/views/vista_consulta.php',
        type: 'post',

        success: function (response) {
            ModalOpen();
            if (vista == "clo") {
                $("#modal_titulo").text("Confirmacion de Dotaciones en Lote por Operaciones");
            }
            if (vista == "cla") {
                $("#modal_titulo").text("Confirmacion de Dotaciones en Lote por Almacen");
            }
            if (vista == "vista_dotacion") {
                $("#modal_titulo").text("Consulta de Lote Almacen");
            }
            if (vista == "vista_recepcion") {
                $("#modal_titulo").text("Consulta de Lote Operaciones");
            }

            $("#modal_contenido").html(response);

            //cons_inicio();
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });
}

function accionar_consulta(id) {
    event.preventDefault();
    if (confirm("Esta seguro que quiere realizar la operacion")) {
        if (datos_consulta_omitir.length > 0) {
            var parametros = $("#" + id).serializeArray();
            parametros.push({ 'name': 'data', 'value': JSON.stringify(datos_consulta_omitir) });

            $.ajax({
                data: parametros,
                url: 'packages/dotacion_movimiento/model/asignacion_dotacion.php',
                type: 'post',

                success: function (response) {
                    console.log(response);
                    var resultado = JSON.parse(response);
                    if (resultado.confirmacion) {
                        alert("Guardado Correctamente");
                        llenar_consulta(resultado.codigo);
                    } else {
                        alert("No se Guardo Correctamente")
                    }
                    datos_consulta = [];
                    datos_consulta_dotacion = [];
                    datos_consulta_omitir = [];
                    document.getElementById("dotacion_out").getElementsByTagName("tbody")[0].innerHTML = "";
                    document.getElementById("dotacion_in").getElementsByTagName("tbody")[0].innerHTML = "";
                    document.getElementById('cod').value = '';
                    document.getElementById('metodo').value = "agregar";
                    document.getElementById('titulo_accion').innerText = "LISTADO DE DOTACIONES SIN PROCESAR";
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });
        }
    }

}

function consultar_listado(tipo) {
    var fecha_desde = document.getElementById('fec_d').value
    var fecha_hasta = document.getElementById('fec_h').value
    var parametros = {
        'omitir': datos_consulta_omitir,
        'fecha_d': fecha_desde,
        'fecha_h': fecha_hasta,
        'tipo': tipo
    };
    $.ajax({
        data: parametros,
        url: 'packages/dotacion_movimiento/views/Get_listado_dotacion.php',
        type: 'post',
        beforeSend: function () {
            document.getElementById('buscar_in').setAttribute('readonly', 'readonly');
            document.getElementById('buscar_out').setAttribute('readonly', 'readonly');
        },
        success: function (response) {

            document.getElementById('buscar_out').removeAttribute('readonly');
            document.getElementById('buscar_in').removeAttribute('readonly');
            datos_consulta = JSON.parse(response);
            filtrado('', 'in');
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });
}




function seleccionar(cod, tabla) {

    if (tabla == "in") {
        console.log(datos_consulta);
        datos_consulta_dotacion.push(datos_consulta.filter((valor, i) => {

            if (valor.cod_dotacion == cod) {
                datos_consulta.splice(i, 1);
                var remplace = document.getElementById("dot_" + cod).outerHTML.replace("'in'", "'out'").replace("90deg", '-90deg');
                document.getElementById("dot_" + cod).remove();
                document.getElementById("dotacion_out").getElementsByTagName("tbody")[0].innerHTML += remplace;
                datos_consulta_omitir.push(cod);
            }
            return valor.cod_dotacion == cod
        })[0]);

    }
    if (tabla == "out") {
        datos_consulta.push(datos_consulta_dotacion.filter((valor, i) => {
            if (valor.cod_dotacion == cod) {
                datos_consulta_dotacion.splice(i, 1);
                var remplace = document.getElementById("dot_" + cod).outerHTML.replace("'out'", "'in'").replace("-90deg", '90deg');;
                document.getElementById("dot_" + cod).remove();
                document.getElementById("dotacion_in").getElementsByTagName("tbody")[0].innerHTML += remplace;
                datos_consulta_omitir.splice(datos_consulta_omitir.indexOf(String(cod)), 1);
            }
            return valor.cod_dotacion == cod
        })[0]);

    }
}

function filtrado(texto, metodo) {

    if (metodo == 'in') {
        var filtro = document.getElementById("filtro_in").value;
        var response = "";
        if (filtro == "TODOS") {
            if (texto == "") {
                filtro = (texto == "" && filtro == "TODOS") ? 'cod_ficha' : filtro;
                var nuevo_array = datos_consulta.filter(dato => dato[filtro].toString().search(texto.toUpperCase()) >= 0);
                nuevo_array.forEach((res) => {
                    response +=/*html*/
                        `<tr id="dot_${res[1]}"><td>${res[1]}</td>
                <td>${res[0]}</td>
                <td>${res[2]}</td>
                <td>${res[3]}</td>
                <td><img src="imagenes/up.png" width="20" height="20" style="transform:rotate(90deg);" name="select[]" id="select[${res[1]}]"  onclick="seleccionar('${res[1]}','in')" /></td></tr>`
                });
            }
        } else {
            var nuevo_array = datos_consulta.filter(dato => dato[filtro].toString().search(texto.toUpperCase()) >= 0);
            nuevo_array.forEach((res) => {
                response +=/*html*/
                    `<tr id="dot_${res[1]}"><td >${res[1]}</td>
                <td>${res[0]}</td>
                <td>${res[2]}</td>
                <td>${res[3]}</td>
                <td><img src="imagenes/up.png" width="20" height="20" name="select[]" style="transform:rotate(90deg);" id="select[${res[1]}]"  onclick="seleccionar('${res[1]}','in')" value="${res[1]}"/></td></tr>`
            });
        }
        document.getElementById('dotacion_in').getElementsByTagName("tbody")[0].innerHTML = response;
    }
    if (metodo == "out") {

        var filtro = document.getElementById("filtro_out").value;
        var response = "";
        if (filtro == "TODOS") {
            if (texto == "") {
                filtro = (texto == "" && filtro == "TODOS") ? 'cod_ficha' : filtro;
                var nuevo_array = datos_consulta_dotacion.filter(dato => dato[filtro].toString().search(texto.toUpperCase()) >= 0);
                nuevo_array.forEach((res) => {
                    response +=/*html*/
                        `<tr id="dot_${res[1]}"><td>${res[1]}</td>
                <td>${res[0]}</td>
                <td>${res[2]}</td>
                <td>${res[3]}</td>
                <td><img src="imagenes/up.png" width="20" height="20" style="transform:rotate(-90deg);" name="select[]" id="select[${res[1]}]"  onclick="seleccionar('${res[1]}','out')" /></td></tr>`
                });
            }
        } else {
            var nuevo_array = datos_consulta_dotacion.filter(dato => dato[filtro].toString().search(texto.toUpperCase()) >= 0);
            nuevo_array.forEach((res) => {
                response +=/*html*/
                    `<tr id="dot_${res[1]}"><td >${res[1]}</td>
                <td>${res[0]}</td>
                <td>${res[2]}</td>
                <td>${res[3]}</td>
                <td><img src="imagenes/up.png" width="20" height="20" name="select[]" style="transform:rotate(-90deg);" id="select[${res[1]}]"  onclick="seleccionar('${res[1]}','out')" value="${res[1]}"/></td></tr>`
            });
        }
        document.getElementById('dotacion_out').getElementsByTagName("tbody")[0].innerHTML = response;
    }
}

function confirmar_consulta(codigo, metodo, vista) {

    var confirmacion = false;
    vista = (typeof vista == "undefined") ? document.getElementById('vista').value : vista
    var usuario = document.getElementById('us').value;
    var parametros = {
        cod: codigo,
        metodo: metodo,
        vista: vista,
        us: usuario
    }

    if (metodo == "modificar") {
        cons_inicio(vista, '', () => {
            document.getElementById('cod').value = codigo;
            document.getElementById('metodo').value = "modificar";
            document.getElementById('titulo_accion').innerText += " (MODIFICACION DE LOTE: NRO-" + codigo + ")";
            consultar_existente(codigo);
            CloseModal();
        });


    }

    if (metodo == "anular") {
        confirmacion = confirm("¿Esta seguro que desea anular?");
    } else {
        if (metodo == "confirmar") {
            confirmacion = confirm("Una vez impreso no se podra modificar, ¿Esta seguro que desea seguir?");
        }
    }

    if (confirmacion) {

        $.ajax({
            data: parametros,
            url: 'packages/dotacion_movimiento/model/asignacion_dotacion.php',
            type: 'post',

            success: function (response) {

                var resultado = JSON.parse(response);
                if (resultado.confirmacion) {
                    alert("Guardado Correctamente");
                    if (metodo == "confirmar") {
                        $("#reporte_dotacion").submit();
                    }
                    if (metodo == "agregar" || metodo == "modificar") {
                        document.getElementById("dotacion_out").getElementsByTagName("tbody")[0].innerHTML = "";
                        document.getElementById("dotacion_in").getElementsByTagName("tbody")[0].innerHTML = "";
                    }
                    CloseModal();
                } else {
                    alert("No se Guardo Correctamente");
                }


                datos_consulta = [];
                datos_consulta_dotacion = [];
                datos_consulta_omitir = [];
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
    }
}

function confirmacion_lote_operaciones(codigo, cod_dotacion, vista, elemento) {
    vista = (typeof vista == "undefined") ? document.getElementById('vista').value : vista
    if (elemento) {
        var metodo = 'agregar_confirmacion';
    } else {
        var metodo = "remover_confirmacion";
    }

    var usuario = document.getElementById('us').value;
    var parametros = {
        cod: codigo,
        cod_dotacion: cod_dotacion,
        metodo: metodo,
        vista: vista,
        us: usuario
    }
    $.ajax({
        data: parametros,
        url: 'packages/dotacion_movimiento/model/asignacion_dotacion.php',
        type: 'post',

        success: function (response) {
            var resultado = JSON.parse(response);
            if (resultado.confirmacion) {
                alert("Guardado Correctamente");
            } else {
                alert("No se Guardo Correctamente");
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });


}