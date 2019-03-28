var g = new GraficasD3();
var g2 = new GraficasD3(d3.schemePaired);
var f = new Date();
var fec_desde = f.getFullYear() + "-" + /*pad((f.getMonth() + 1), 2) +*/ "01-01";
var fec_hasta = f.getFullYear() + "-" + pad((f.getMonth() + 1), 2) + "-" + pad(f.getDate(), 2);

//Se geneara automaticamente al cargar el script
$(function () {
    iniciar();
});

function generar() {
    var usuario = $("#usuario").val();
    fec_desde = $('#fec_desde').val();
    fec_hasta = $('#fec_hasta').val();
    var error = 0,
        errorMessage = ' ';
    if (error == 0) {
        var parametros = {
            "fec_desde": fec_desde,
            "fec_hasta": fec_hasta,
            "usuario": usuario
        };
        $.ajax({
            data: parametros,
            url: 'packages/grafica/novedades/modelo/getGraficaSimple.php',
            type: 'post',
            success: function (response) {
                var resp = JSON.parse(response);
                if (resp.length > 0) {
                    $('.brs').show();
                    $('#sin_data').hide();
                    $('#grafica').show();
                    $('#division').show();
                    //if (resp.length > 5) g.crearGraficaBarra(resp, 450, 'grafica', 'nov1', false, true, 'top', 'col-xs-6', 'Novedades por Status');
                    //else 
                    g.crearGraficaTorta(resp, 450, 'grafica', 'nov1', true, true, 'right', 'col-xs-6', 'Novedades por Status');
                    /*g.crearGraficaLineaAgrupada(resp, 450, 'grafica', 'nov1', true, 'col-md-6', 'Novedades por Status');
                    g2.borrarGrafica('grafica', 'nov2', () => {
                        novStatusDet_inic(resp[0].codigo, resp[0].titulo);
                    });*/
                    resp.forEach(function (d, i) {
                        novStatusDet(d.codigo, d.titulo);
                    });
                } else {
                    $('.brs').hide();
                    $('#sin_data').show();
                    $('#grafica').hide();
                    $('#division').hide();
                    g2.borrarGrafica('grafica', 'nov2');
                    g.borrarGrafica('grafica', 'nov1');
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

function iniciar() {
    var error = 0;
    var errorMessage = ' ';
    var usuario = $("#usuario").val();

    if (error == 0) {
        var parametros = {
            "fec_desde": fec_desde,
            "fec_hasta": fec_hasta,
            "usuario": usuario
        };

        $.ajax({
            data: parametros,
            url: 'packages/grafica/novedades/views/graficaNovedades.php',
            type: 'POST',
            success: function (response) {
                $("#Cont_gNovedades").html(response);
                generar();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        }, () => {});

    } else {
        alert(errorMessage);
    }
}

function novStatusDet(status, titulo) {
    var usuario = $("#usuario").val();
    var error = 0;
    var errorMessage = ' ';
    if (error == 0) {
        var parametros = {
            "fec_desde": fec_desde,
            "fec_hasta": fec_hasta,
            "status": status
        };
        $.ajax({
            data: parametros,
            url: 'packages/grafica/novedades/modelo/getGraficaStatusDet.php',
            type: 'post',
            success: function (response) {
                var resp = JSON.parse(response);
                if (resp.length > 5) {
                    g2.addEventCrearGrafica(JSON.parse(response), status, 'grafica', 'nov1', 'grafica', 'nov2', 'barra', 450, false, 'top', 'col-xs-6', 'Status: ' + titulo, false);
                } else {
                    g2.addEventCrearGrafica(JSON.parse(response), status, 'grafica', 'nov1', 'grafica', 'nov2', 'torta', 450, true, 'top', 'col-xs-6', 'Status: ' + titulo, false, true);
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

function novStatusDet_inic(status, titulo) {
    var error = 0;
    var errorMessage = ' ';
    if (error == 0) {
        var parametros = {
            "fec_desde": fec_desde,
            "fec_hasta": fec_hasta,
            "status": status
        };
        $.ajax({
            data: parametros,
            url: 'packages/grafica/novedades/modelo/getGraficaStatusDet.php',
            type: 'post',
            success: function (response) {
                var resp = JSON.parse(response);
                if (resp.length > 5) {
                    g2.crearGraficaBarra(resp, 450, 'grafica', 'nov2', false, false, 'top', 'col-xs-6', 'Status: ' + titulo);
                } else
                    g2.crearGraficaTorta(resp, 450, 'grafica', 'nov2', true, true, 'top', 'col-xs-6', 'Status: ' + titulo);
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

function pad(n, length) {
    var n = n.toString();
    while (n.length < length)
        n = "0" + n;
    return n;
}