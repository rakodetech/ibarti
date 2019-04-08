var grafica_1;
var datos_grafica1 = [];
var datos_grafica2 = [];
var datos;
var inicial = false;
$(function () {

    var fecha = new Date()
    var mes_actual = fecha.getMonth() + 1;
    var año_actual = fecha.getFullYear();
    var meses = ['ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE']
    for (i = (Math.round(año_actual / 2)); i < año_actual; i++) {

        $('#a_d').append(`<option value="${i + 1}" ${(i + 1) == (año_actual) ? 'selected="selected"' : ''}>${i + 1}</option>`);
        $('#a_h').append(`<option value="${i + 1}" ${(i + 1) == (año_actual) ? 'selected="selected"' : ''}>${i + 1}</option>`);
    }
    for (i = 0; i < 12; i++) {

        $('#m_d').append(`<option value="${i + 1}" ${(i + 1) == (mes_actual) ? 'selected="selected"' : ''} >${meses[i]}</option>`);
        $('#m_h').append(`<option value="${i + 1}" ${(i + 1) == (mes_actual) ? 'selected="selected"' : ''}>${meses[i]}</option>`);

    }


});


//#region funciones adicionales

function desplazar(id) {
    $('html,body').animate({
        scrollTop: $("#" + id).offset().top
    }, 1000);
}


//#region Obtencion de datos
function obtener_data() {
    $('#cargando').show();
    $('#inicial').hide();
    $('#con_data').hide();
    $('#sin_data').hide();
    $('#contenedor').html('');

    $('#contenedor1').hide();

    $('#contenedor2').hide();
    $('#detalles').hide();
    if (inicial) {
        var fecha_desde = `${$('#a_d').val()}-${$('#m_d').val()}-01`;
        var fecha_hasta = `${$('#a_h').val()}-${$('#m_h').val()}-31`;
    } else {
        var fecha_desde = "";
        var fecha_hasta = "";

    }
    inicial = true;
    var parametros = { "f_d": fecha_desde, "f_h": fecha_hasta };

    $.ajax({
        data: parametros,
        url: 'packages/novedades_resp/views/get_num_perfil.php',
        type: 'post',
        success: function (response) {

            datos = JSON.parse(response);
            if (datos.length != 0) {
                $('#inicial').show();
                $('#con_data').show();
                $('#cargando').hide();

                var fecha_d = datos[0].desde.split('-')
                $('#a_d').val(Number(fecha_d[0]))
                $('#m_d').val(Number(fecha_d[1]))
                var fecha_h = datos[0].hasta.split("-")
                $('#a_h').val(Number(fecha_h[0]))
                $('#m_h').val(Number(fecha_h[1]))

                formatear_data(datos);


            } else {
                $('#inicial').show();
                $('#sin_data').show();
                $('#cargando').hide();
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });

}

//#region Formateo de datos
//formateo Grafica Perfil
function formatear_data(info) {

    datos_grafica1 = [];
    var nueva = d3.nest()
        .key((d) => d.codigo_perfil).sortKeys(d3.ascending).key((d) => d.cod_clasif).sortKeys(d3.ascending).entries(info);


    var suma_elemento = 0;
    var suma_clasif = 0;
    var suma_perfil = 0;
    var prom_perfil = [];
    var prom_clasif = [];
    var json_prom = [];
    var json_name = [];
    ///Arreglo con las agrupaciones perfil y exceso
    var grup = [];
    ///Arreglo con dias promedios generales de todos los perfiles
    var dias_pro = [];

    var num_novedades = d3.nest().key((d) => d.codigo_perfil).sortKeys(d3.ascending).key((d) => d.cod_nov).sortKeys(d3.ascending).entries(datos);

    //obtencion de arreglo de dias ideales por perfil
    num_novedades.forEach((res, i) => {
        var suma = 0;
        res.values.forEach((novedad) => {

            suma += Number(novedad.values[0].dias_vencimiento);
        })

        dias_pro.push(Math.round(suma / res.values.length));

    });
    // obtener nombres de los codigos por perfil
    // llenar grupos entre dias promedio y exceso por perfil
    // llenar data de dias promedio(sin exceso)
    nueva.forEach((res, j) => {
        json_name.push(res.values[0].values[0].perfil.trim());
        res.values.forEach((ras, i) => {

            ras.values.forEach((ris) => {
                suma_elemento += Number(ris.dias_respuesta);
            });
            prom_clasif[i] = (suma_elemento / ras.values.length);
            suma_clasif += suma_elemento / ras.values.length;

            suma_elemento = 0;
        });
        suma_perfil = suma_clasif / res.values.length;
        prom_perfil[j] = prom_clasif;
        json_prom.push(Math.round(suma_perfil));


        if (dias_pro[j] < Math.round(suma_perfil)) {
            datos_grafica1.push([`cod_${res.values[0].values[0].codigo_perfil}`, (dias_pro[j])]);

            grup.push([`cod_${res.values[0].values[0].codigo_perfil}_vec`, `cod_${res.values[0].values[0].codigo_perfil}`]);

        } else {
            datos_grafica1.push([`cod_${res.values[0].values[0].codigo_perfil}`, (Math.round(suma_perfil))]);
        }
        prom_clasif = [];
        suma_clasif = 0;

    });
    // llenar json de nombres para cada codigo de perfil
    var nombres = "{";

    datos_grafica1.forEach((res, i) => {

        nombres += `"${res[0]}":"${nueva[i].values[0].values[0].perfil} (${json_prom[i]} DIAS PROMEDIO)",`;
        nombres += `"${res[0]}_vec":"${nueva[i].values[0].values[0].perfil} EXCESO"`;

        if (!(i == datos_grafica1.length - 1)) {
            nombres += ","
        }
    });
    nombres += "}";
    //llenar data de dias promedios(solo excesos)
    nueva.forEach((res, i) => {
        if ((dias_pro[i] <= json_prom[i]) && (json_prom[i] > 0)) {
            datos_grafica1.push([`cod_${res.values[0].values[0].codigo_perfil}_vec`, ((json_prom[i] - dias_pro[i]) > 0 ? (json_prom[i] - dias_pro[i]) * (-1) : (json_prom[i] - dias_pro[i]))]);
        }

    });
    //creacion de la grafica
    crear_grafica(datos_grafica1, JSON.parse(nombres), grup);

}

//Formateo de Gradica 2
function formatear_data2(cod, info, selec) {
    datos_grafica2 = []
    var nueva_Data = [];

    info.forEach((res1) => {
        if (cod.replace('cod_', '') == res1.codigo_perfil) {
            nueva_Data.push(res1);

        }
    });

    datos_grafica2 = d3.nest()
        .key((d) => d[selec]).entries(nueva_Data);

    return datos_grafica2;
}

//#region Creacion de grafica
//grafica 1
function crear_grafica(data, name, agrupaciones) {

    var invisible = [];
    agrupaciones.forEach((res) => {
        invisible.push(res[0]);
    })
    $('#cargando').hide();
    $('#inicial').show();
    grafica_1 = c3.generate({
        bindto: "#contenedor",
        data: {

            type: 'bar',

            groups: agrupaciones
            ,
            labels: {
                format: function (v, id, i, j) {

                    if (!(typeof id === 'undefined')) {

                        var exceso = id.split('_vec');
                        if (exceso.length > 1) {
                            return v * (-1);
                        } else {
                            return `${v}   //${name[id].trim()}`
                        }

                    }

                },
            }
            ,
            columns: data,

            onclick: function (d) {
                $('#p_clasif').html(`PROMEDIO POR CLASIFICACION (${String(d.name).replace(' EXCESO', '')})`);
                $('#contenedor1').show();

                var facmento = [];
                var now = [];
                var name = "{";
                var suma = 0;
                var prom_clasif_i = [];
                var agrup = [];
                facmento = formatear_data2(String(d.id).replace('_vec', ''), datos, 'cod_clasif');

                facmento.forEach((res, i) => {

                    //////Estado experimental
                    var nov_clasif = d3.nest().key((d) => d.cod_nov).entries(res.values)
                    var prom_clasif = 0;
                    var suma_clasif = 0;

                    nov_clasif.forEach((ras) => {
                        suma_clasif += Number(ras.values[0].dias_vencimiento)
                    })
                    prom_clasif = Math.round(suma_clasif / nov_clasif.length);
                    prom_clasif_i.push(prom_clasif)
                    //////////////////////////////

                    res.values.forEach((res2) => {
                        suma += Number(res2.dias_respuesta);
                    });

                    if (prom_clasif < (Math.round(suma / res.values.length))) {
                        now.push([`cod_${res.key}`, (Math.round(prom_clasif))]);
                        now.push([`cod_${res.key}_vec`, ((Math.round(suma / res.values.length) - Math.round(prom_clasif)) >= 0) ? (Math.round(suma / res.values.length) - Math.round(prom_clasif)) * (-1) : (Math.round(suma / res.values.length) - Math.round(prom_clasif))]);
                        name += `"cod_${res.key}":"${res.values[0].descripcion_clasif} (${(Math.round(suma / res.values.length))} DIAS PROMEDIO)",`;
                        name += `"cod_${res.key}_vec":"${(res.values[0].descripcion_clasif)} EXCESO"`;
                        agrup.push(['cod_' + res.key, 'cod_' + res.key + "_vec"]);
                    } else {
                        now.push([`cod_${res.key}`, (Math.round(suma / res.values.length))]);
                        name += `"cod_${res.key}":"${res.values[0].descripcion_clasif} (${(Math.round(suma / res.values.length))} DIAS PROMEDIO)"`;
                    }




                    if (!(i == (facmento.length - 1))) {
                        name += ","
                    }
                    suma = 0;

                });

                name += "}";

                crear_grafica2(now, JSON.parse(name), agrup);
            },
            color: function (color, d) {
                if (!(typeof d.id === 'undefined')) {

                    var exceso = d.id.split('_vec');
                    if (exceso.length > 1) {
                        return '#FF0000';
                    } else {
                        return '#2E9AFE';
                    }

                } else {
                    return '#2E9AFE';
                }
            },
            names: name
        },
        grid: {
            y: {
                lines: [{ value: 0, class: 'grid800' }]
            }
        }
        ,

        bar: {
            zerobased: false,
            width: {
                ratio: 1
            }
        }
        ,
        legend: {
            hide: true,
            position: 'right',

        },

        tooltip: {
            show: true,
            grouped: false,
            format: {
                title: function (x) {
                    return 'DIAS PROMEDIO POR PERFIL';
                },
                value: (d) => {
                    return String(d).replace('-', '') + " dias";
                }
            }
        },
        axis: {
            rotated: true,
            y: {
                label: 'DIAS PROMEDIO',
                padding: {
                    top: 900,
                    bottom: 300
                },
            },
            x: {
                padding: {
                    top: 0,

                },
                show: false,
                label: 'PERFILES'
            }
        }
    });
}
//grafica 2 EXPERIMENTAL
function crear_grafica2(data, nombres, agrupaciones) {
    
    desplazar('p_clasif');
    grafica_1 = c3.generate({
        bindto: "#contenedor1",
        data: {

            type: 'bar',
            groups: agrupaciones,
            columns: data,
            onclick: function (d) {
                $('#p_nov').html(`PROMEDIO POR CLASIFICACION (${String(d.name).replace(' EXCESO', '')})`);

                $('#contenedor2').show();
                var suma = 0;
                var nuevos = [];
                var old_data = [];
                var name = "{";
                var grup = [];
                datos_grafica2.forEach((a) => {


                    if (a.key == d.id.replace('cod_', '').replace('_vec', '')) {
                        old_data.push(a.values)


                        var nuevo2 = d3.nest()

                            .key((d) => d['cod_nov']).entries(a.values);

                        var sum = 0;
                        var dias_ideal = 0;


                        nuevo2.forEach((res, i) => {


                            res.values.forEach((res2) => {
                                suma += Number(res2.dias_respuesta);
                            });

                            if (Number(res.values[0].dias_vencimiento) < Math.round(suma / res.values.length) && Math.round(suma / res.values.length) > 0) {
                                nuevos.push([`cod_${res.key}`, Number(res.values[0].dias_vencimiento)])
                                name += `"cod_${res.key}":"${res.values[0].novedad.trim()} (${Math.round(suma / res.values.length)} DIAS PROMEDIO)",`;

                                nuevos.push([`cod_${res.key}_vec`, ((Math.round(suma / res.values.length) - Number(res.values[0].dias_vencimiento)) > 0) ? (Math.round(suma / res.values.length) - Number(res.values[0].dias_vencimiento)) * (-1) : (Math.round(suma / res.values.length) - Number(res.values[0].dias_vencimiento))])
                                name += `"cod_${res.key}_vec":"${res.values[0].novedad.trim()} EXCESO"`;

                                grup.push(["cod_" + res.key, "cod_" + res.key + "_vec"]);
                            } else {
                                nuevos.push([`cod_${res.key}`, Math.round(suma / res.values.length)])
                                name += `"cod_${res.key}":"${res.values[0].novedad.trim()} "`;
                            }

                            suma = 0;



                            if (!(i == (nuevo2.length - 1))) {
                                name += ","
                            }
                        });
                        console.log(sum / nuevo2.length)
                        name += "}";
                    }
                });
                // console.log(nuevos, JSON.parse(name), old_data)
                crear_grafica3(nuevos, JSON.parse(name), old_data, grup)
            },
            color: function (color, d) {
                if (!(typeof d.id === 'undefined')) {

                    var exceso = d.id.split('_vec');
                    if (exceso.length > 1) {
                        return '#FF0000';
                    } else {
                        return '#2E9AFE';
                    }

                } else {
                    return '#2E9AFE';
                }
            }

            ,
            names: nombres,
            labels: {
                format: function (v, id, i, j) {

                    if (!(typeof id === 'undefined')) {

                        var exceso = id.split('_vec');
                        if (exceso.length > 1) {
                            return v * (-1);
                        } else {
                            return `${v}   //${nombres[id].trim()}`
                        }

                    }

                },
            }
        },
        grid: {
            y: {
                lines: [{ value: 0, class: 'grid800' }]
            }
        }

        ,
        bar: {
            format: function (a) {
                return a
            },
            width: {
                ratio: 1
            }
        }, legend: {
            hide: true,
            position: 'right',

        },
        tooltip: {
            show: true,
            grouped: false,
            format: {
                title: function (x) {
                    return 'DIAS PROMEDIO POR CLASIFICACION';
                },
                value: (d) => {
                    return String(d).replace('-', '') + " dias";
                }
            }
        },

        axis: {
            rotated: true,
            y: {
                label: 'DIAS PROMEDIO',
                padding: {
                    top: 900,
                    bottom: 300
                },
            },
            x: {
                padding: {
                    top: 0,

                },
                show: false,
                label: 'PERFILES'
            }
        }

    })

}
//Grafica 3
function crear_grafica3(dat, name, old_data, agrupaciones) {
    desplazar('p_nov');
    grafica = c3.generate({
        bindto: "#contenedor2",
        data: {
            type: 'bar',
            columns: dat,

            names: name,
            color: function (color, d) {
                if (!(typeof d.id === 'undefined')) {

                    var exceso = d.id.split('_vec');
                    if (exceso.length > 1) {
                        return '#FF0000';
                    } else {
                        return '#2E9AFE';
                    }

                } else {
                    return '#2E9AFE';
                }
            }

            ,
            labels: {
                format: function (v, id, i, j) {

                    if (!(typeof id === 'undefined')) {

                        var exceso = id.split('_vec');
                        if (exceso.length > 1) {
                            return v * (-1);
                        } else {
                            return `${v}   //${name[id].trim()}`
                        }

                    }

                },
            },
            groups: agrupaciones,
            onclick: function (d) {
                $('#p_proc').html(`LISTADO DE DIAS POR PROCESO (${String(d.name).replace(' EXCESO', '')})`)
                var tabla = [];
                old_data[0].forEach((a) => {

                    if (a.cod_nov == d.id.replace('cod_', '').replace('_vec', '')) {
                        tabla.push(a)
                    }
                });
                crear_detalle(tabla)
            }
        }, grid: {
            y: {
                lines: [{ value: 0, class: 'grid800' }]
            }

        }
        , legend: {
            hide: true,
            position: 'right',

        }, axis: {
            rotated: true,
            y: {
                label: 'DIAS PROMEDIO',
                padding: {
                    top: 900,
                    bottom: 300
                },
            },
            x: {
                padding: {
                    top: 0,

                },
                show: false,
                label: 'PERFILES'
            }
        },

        tooltip: {
            show: true,
            grouped: false,
            format: {
                title: function (x) {
                    return 'DIAS PROMEDIO POR NOVEDAD';
                },
                value: (d) => {
                    return String(d).replace('-', '') + " dias";
                }
            }
        }
    });
}


//#region Tabla de Detalles
function crear_detalle(data) {
    $('#detalles').show();
    $('html,body').animate({
        scrollTop: $("#p_proc").offset().top
    }, 1000);

    $('#detalles').html('');
    var contenedor = d3.select('#detalles');
    var tabla = contenedor.append('table').attr('id', 'lista').attr('width', '100%').attr('border', '1').style('font-size', '12px');
    var head = tabla.append('thead').append('tr').attr('align', 'center').attr('class', 'fondo00');
    head.append('td').text('Codigo').attr('width', '10%').style("text-align", "center");
    head.append('td').text('Descripcion').attr('width', '50%').style("text-align", "left");
    head.append('td').text('Fecha Inicial').attr('width', '10%').style("text-align", "center");
    head.append('td').text('Fecha Final').attr('width', '10%').style("text-align", "center");
    head.append('td').text('Dias Respuesta').attr('width', '10%').style("text-align", "center");
    var tbody = tabla.append('tbody');
    var tr = tbody.selectAll("tr").data(data).enter()
        .append("tr").attr('class', (d, i) => {
            if (i % 2 == 0) {
                return "fondo01";
            } else {
                return "fondo02";
            }
        }).attr('border', '1');
    tr.append("td").text((d, i) => d.codigo_proceso).style("text-align", "center");
    tr.append("td").text((d, i) => d.problematica.trim()).style("text-align", "center");
    tr.append("td").text((d, i) => d.fec_us_ing).style("text-align", "center");
    tr.append("td").text((d, i) => d.fec_us_mod).style("text-align", "center");
    tr.append("td").text((d, i) => { return d.dias_respuesta + " dias" }).style("text-align", "center");
}


////////UNICO DE CONTROL DE FECHA/////////////////////////////////////////////////////////////////

function crear_control(contenedor) {

    if ($('#fecha_ingreso').length > 0) {
        
        destruir('fecha_ingreso');

    } else {
        $('html').append(/*html*/ `
           <div id="fecha_ingreso" class="contenedor"style="">
            <div id="box" class="contenido">
                <table class="agrupadas">
                <tr>
                    <td class="texto">AÑOS  </td>
                    <td class="texto">MESES </td>
                    <td class="texto">SEMANAS</td>
                    <td class="texto">FECHA</td>
                </tr>
                </table>
                <div class="base">
                    <ul>
                        <li>hola</li>
                    </ul>
                </div>
                <table class="agrupadas" style="border-bottom: none;">
                    <tr>
                        <td id="colaps"></td>
                    </tr>
                </table>
                </div>
           </div>`);

        $('#fecha_ingreso').offset({ top: ($('#' + contenedor).offset().top + 5 + $('#' + contenedor).height()), left: ($('#' + contenedor).offset().left - ($('#fecha_ingreso').width() / 2)) });
    }



}
function destruir(s) {

    $('#' + s).remove();

}

///////////////////////////////////////////////////////////////////////////