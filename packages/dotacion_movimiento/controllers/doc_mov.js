var datos_consulta = [];
var datos_consulta_dotacion = [];
var datos_consulta_omitir = [];
var descripcion = "";
//////////socate vistas
function cons_inicio(vista, metodo, callback) {

    var parametros = [];

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
            parametros = $("#filtros").serializeArray();
            url = "packages/dotacion_movimiento/views/Buscar_dotacion.php";
            break;
        case 'vlo':
            url = "packages/dotacion_movimiento/views/Buscar_dotacion.php";
            break;
        case 'rds':
            url = "packages/dotacion_movimiento/dotacion_reportes/vista_reporte_status.php";
            callback = () => {
                //crear_reporte();
            }
            break;
    }

    parametros.push({ name: 'view', value: vista });
    if (url != "") {
        $.ajax({
            data: parametros,
            url: url,
            type: 'post',
            success: function (response) {
                ////console.log(response)
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
////////////// funcionalidad emicion

function consultar_existente(codigo) {


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

            datos_consulta_dotacion = JSON.parse(response);
            datos_consulta_dotacion.forEach((res) => {
                datos_consulta_omitir.push(res.cod_dotacion);
            });

            filtrado('', 'out');
            descripcion = datos_consulta_dotacion[0].obs;
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


        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });
}

function accionar_consulta(id, texto) {

    event.preventDefault();
    if (confirm("Esta seguro que quiere realizar la operacion")) {
        if (datos_consulta_omitir.length > 0) {
            var parametros = $("#" + id).serializeArray();
            parametros.push({ 'name': 'data', 'value': JSON.stringify(datos_consulta_omitir) });
            parametros.push({ 'name': 'obs', 'value': texto });

            $.ajax({
                data: parametros,
                url: 'packages/dotacion_movimiento/model/asignacion_dotacion.php',
                type: 'post',

                success: function (response) {
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
        ////console.log(datos_consulta);
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
        } else {
            if (metodo == "imprimir") {
                confirmacion = false;
                $("#reporte_dotacion").submit();
            }
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

function modal_descripcion(id) {
    event.preventDefault();
    ModalOpen();
    $("#modal_titulo").text("Agregar Descripcion");
    $("#modal_contenido").html(`
        <table width="60%" align="center">
        <tr><td style="text-align:center" class="texto"><textarea id="area_text"  cols="60">${descripcion}</textarea></td></tr>
        <tr><td style="text-align:center"><input type="button" value="Confirmar" onclick="accionar_consulta('${id}',$('#area_text').val())"></td></tr>
        </table>
        `);




}

function confirmacion_lote_operaciones(codigo, cod_dotacion, vista, elemento, tipo) {
    var elementos = document.getElementById("seleccion").getElementsByTagName("tbody")[0].getElementsByTagName("input");
    var metodo = "";

    vista = (typeof vista == "undefined") ? document.getElementById('vista').value : vista
    if (tipo == "normal") {
        if (elemento) {
            metodo = 'agregar_confirmacion';
        } else {
            metodo = "remover_confirmacion";
        }
    }
    if (tipo == "masiva") {
        if (elemento) {
            metodo = 'agregar_masiva';
        } else {
            metodo = "remover_masiva";
        }
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
                cons_inicio(vista);

                if (tipo == "masiva") {
                    for (let index = 0; index < elementos.length; index++) {
                        elementos[index].checked = elemento;
                    }
                }

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





///////////////////reporte dotacion_status
var procesos;
var estado;
function tabla_dotacion_procesada(callback) {
    var fec_d = $("#f_d").val();
    var fec_h = $("#f_h").val();
    var parametros = { fecha_desde: fec_d, fecha_hasta: fec_h }
    // var dat;
    $.ajax({
        data: parametros,
        url: 'packages/dotacion_movimiento/views/Get_dotaciones_procesadas.php',
        type: 'post',
        beforeSend: function () {

            $("#tabla_detalle").html(`<tr><td style="text-align:center;"><img src="imagenes/loading.gif"></img></td></tr><tr><td style="text-align:center;">PORFAVOR ESPERE...</td></tr>`)
        },
        success: function (response) {
            procesos = JSON.parse(response);
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

function crear_tabla(tipo, status, info) {
    status = (typeof (status) == "undefined") ? estado : status;
    info = (typeof (info) == "undefined") ? procesos : info;
    var listado_proceso = d3.nest().key((d) => d.cod_dotacion).entries(info);
    var tabla = [{}];
    //console.log(info, listado_proceso)
    listado_proceso.forEach((res, i) => {
        var objeto = {};
        res.values.forEach((dato) => {
            var fecha = dato.fecha.split(" ");

            objeto[dato.cod_status] = { fecha: fecha[0], hora: fecha[1] };
        });
        tabla[0][res.key] = objeto;
    });
    var resp = "";
    resp += `<thead style="display:none;"><tr class="fondo00"><td width="10%"  style="text-align:center;vertical-align:middle;">Dotacion</td><td width="10%" style="text-align:center;vertical-align:middle;" >Ficha</td>`;
    var indices = [];
    var por = (status.length > 0) ? 80 / status.length : 0;
    status.forEach((res, i) => {
        indices.push(res.codigo)
        resp += `<td width="${por}%"  style="text-align:center;vertical-align:middle;">${res.descripcion}</td>`;

    });
    resp += `</tr></thead>
    `;
    var resp2 = resp.replace('style="display:none;"','');
    $("#tabla_cabeza").html(resp2.trim());
    resp+=`
    <tbody style="overflow:scroll;

            overflow-y:scroll !IMPORTANT;
            overflow-x:hidden;">
    `;
    var i = 0;
    
    for (const llave in tabla[0]) {

        resp += `<tr class="${(i % 2 == 0) ? 'fondo01' : 'fondo02'}"><td style=" ;text-align:center;"  >${llave}</td>`;

        resp += `<td style="text-align:center;" >${listado_proceso[i].values[0].cod_ficha}</td>`;
        var anterior = [];
        var nuevo = [];
        indices.forEach((res, j) => {

            var dato = (typeof (tabla[0][llave][res]) != "undefined") ? tabla[0][llave][res].fecha : '';

            if (tipo == "dias") {

                if (j == 0) {
                    anterior[0] = moment((dato != "") ? (dato) : '');
                    //anterior[1] = moment((dato2 != "") ? (dato2) : '');
                    //////console.log(anterior[1])
                }

                nuevo[0] = moment((dato != "") ? (dato) : '');
                //nuevo[1] = moment((dato2 != "") ? (dato2) : '');

                var diferencia = nuevo[0].diff(anterior[0], 'days');
                anterior[0] = nuevo[0];
                //anterior[1] = nuevo[1];

                resp += `<td style="text-align:center;">${isNaN(diferencia) ? "NaN" : diferencia}</td>`;
            }
            if (tipo == "horas") {
                if (j == 0) {
                    anterior = moment((dato != "") ? (dato) : '');
                }

                nuevo = moment((dato != "") ? (dato) : '');
                var diferencia = nuevo.diff(anterior, 'days');
                anterior = nuevo;
            }

            if (tipo == "fecha") {
                resp += `<td style="text-align:center;" >${(dato != "") ? dato : '-'}</td>`;
            }
        });
        resp += `</tr>`;
        i++;
    }
    resp+="</tbody>";
    $("#tabla_detalle").html(resp.trim());

}

function crear_reporte() {
    var parametros = {}
    $.ajax({
        data: parametros,
        url: 'packages/dotacion_movimiento/views/Get_status_proceso.php',
        type: 'post',

        success: function (response) {
            estado = JSON.parse(response);
            tabla_dotacion_procesada(() => {
                crear_tabla($("#select_mostrar").val(), estado, procesos);
            });
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });
}

function reporte(archivo, id) {
    var html = document.getElementById(id).innerHTML;

    html = html.replace("dias", '');
    var formulario = `
    <form name="form_reportes" id="form_reportes" action="packages/dotacion_movimiento/views/dotacion_status.php"  method="post" target="_blank">
        <input type="hidden" name="archivo_r" value="${archivo}">
        <input type="hidden" id="report" name="reporte">
        <button type="submit" hidden="hidden">
    </form>
    `;

    $("body").append(formulario);
    $('#report').val($('#' + id).html());
    $("#form_reportes").submit();
    $("#form_reportes").remove();

}


/////////////////////////////

function crear_data(vista, filtros) {
    var parametros = $("#" + filtros).serializeArray();
    parametros.push({ name: 'view', value: vista });
    $.ajax({
        data: parametros,
        type: 'post',
        url: 'packages/dotacion_movimiento/vista_data/Get_data_procesos.php',
        success: function (response) {
            var new_Data = JSON.parse(response);
            llenar_tabla(vista, new_Data);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    })
}

function llenar_tabla(vista, info, codigo) {
    var agregar;
    var cabecera;
    switch (vista) {
        case 'clo':
            agregar = "<th width='6%' align='center'></th>";
            
            break;
        case 'vla':
            agregar = '<th width="6%" align="center"><img src="imagenes/nuevo.bmp" alt="Agregar" onclick="cons_inicio(\'vista_dotacion\', \'agregar\')" title="Agregar Registro" width="30px" height="30px" border="null"/></th>';
            
            break;
        case 'vlo':
            agregar = '<th width="6%" align="center"><img src="imagenes/nuevo.bmp" alt="Agregar" onclick="cons_inicio(\'vista_recepcion\', \'agregar\')" title="Agregar Registro" width="30px" height="30px" border="null"/></th>';
            
            break;
        case 'cla':
            agregar = "<th width='6%' align='center'></th>";
            
            break;

    }
    var html = /*html*/`<table width="100%" border="0" align="center">
      <tr>
        <th width="12%">Código</th>
        <th width="12%">Fecha</th>
        <th width="22%">Descripción</th>
        <th width="10%">Usuario Mod</th>
        <th width="22%">Status</th>
        <th width="14%">Anulado</th>
        ${agregar}
    </tr>
    `;
    info.forEach((res) => {
        switch (vista) {
            case 'clo':
                cabecera = '<tr title="Seleccione para ver detalles" onclick="llenar_consulta(\'' + res["codigo"] + '\',\'' + vista + '\', \'\')">';
                break;
            case 'vla':
                cabecera = '<tr title="Seleccione para ver detalles" onclick="llenar_consulta(\'' + res["codigo"] + '\',\'vista_dotacion\', \'\')">';
                break;
            case 'vlo':
                cabecera = '<tr title="Seleccione para ver detalles" onclick="llenar_consulta(\'' + res["codigo"] + '\',\'vista_recepcion\', \'\')">';
                break;
            case 'cla':
                cabecera = '<tr title="Seleccione para ver detalles" onclick="llenar_consulta(\'' + res["codigo"] + '\',\'' + vista + '\', \'\')">';
                break;

        }
        html +=/*html*/`
        ${cabecera}<td>${res['codigo']}</td><td>${res['fecha']}</td><td  style="max-width: 200px; overflow: hidden;
        text-overflow: ellipsis; white-space: nowrap;">${res['descripcion']}</td><td>${res['nombre']}</td><td>${res['estatus']}</td><td>${res['anulado']}</td><td></td></tr>
        `;

    });
    html+="</table>";
    $("#tabla_info").html(html);
}
//////////////////////////