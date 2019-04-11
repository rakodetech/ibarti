/*var g = new GraficasD3();
var g2 = new GraficasD3(d3.schemePaired);*/
var g = new Grafica();
var f = new Date();
var fec_desde = f.getFullYear() + "-" + /*pad((f.getMonth() + 1), 2) +*/ "01-01";
var fec_hasta = f.getFullYear() + "-" + pad((f.getMonth() + 1), 2) + "-" + pad(f.getDate(), 2);
var chartColors = ['rgb(255, 99, 132)', 'rgb(255, 159, 64)', 'rgb(255, 205, 86)', 'rgb(75, 192, 192)',
    'rgb(54, 162, 235)', 'rgb(153, 102, 255)', 'rgb(201, 203, 207)'
];
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

                    g.Torta('chart-area', resp,'Novetades por Status');
                    /*
                                        var canvas = document.getElementById('chart-area');

                                        canvas.onclick = function (evt) {
                                            var activePoints = myPie.getElementsAtEvent(evt);
                                            var firstPoint = activePoints[0];
                                            var cod = codigos[firstPoint._index];
                                            var label = myPie.data.labels[firstPoint._index];
                                            var value = myPie.data.datasets[firstPoint._datasetIndex].data[firstPoint._index];

                                            var parametros = {
                                                "fec_desde": fec_desde,
                                                "fec_hasta": fec_hasta,
                                                "status": cod
                                            };
                                            $.ajax({
                                                data: parametros,
                                                url: 'packages/grafica/novedades/modelo/getGraficaStatusDet.php',
                                                type: 'post',
                                                success: function (response) {
                                                    var resp = JSON.parse(response);
                                                    var datos = [];
                                                    var labels = [];
                                                    var codigos = [];

                                                    resp.forEach(function (d) {
                                                        datos.push(Number(d.valor));
                                                        labels.push(d.titulo);
                                                        codigos.push(d.codigo);
                                                    });

                                                    if (window.myPie2) {
                                                        myPie2.data.datasets.forEach((dataset) => {
                                                            dataset.data.pop();
                                                        });
                                                        myPie2.data.labels.pop();
                                                        myPie2.data.datasets[0].data = datos;
                                                        myPie2.data.labels = labels;
                                                        myPie2.options.title.text = label;
                                                        myPie2.update();

                                                    } else {
                                                        var config = {
                                                            type: 'doughnut',
                                                            data: {
                                                                datasets: [{
                                                                    data: datos,
                                                                    backgroundColor: chartColors,
                                                                }],
                                                                labels: labels
                                                            },
                                                            options: {
                                                                responsive: true,
                                                                title: {
                                                                    display: true,
                                                                    text: label
                                                                }
                                                            }
                                                        };

                                                        var ctx = document.getElementById('chart-area2').getContext('2d');
                                                        window.myPie2 = new Chart(ctx, config);
                                                    }

                                                },
                                                error: function (xhr, ajaxOptions, thrownError) {
                                                    alert(xhr.status);
                                                    alert(thrownError);
                                                }
                                            });

                                        };*/
                    // Build the chart
                    /*Highcharts.chart('grafica', {
                        chart: {
                            plotBackgroundColor: null,
                            plotBorderWidth: null,
                            plotShadow: false,
                            type: 'pie'
                        },
                        title: {
                            text: 'Novedades por Status'
                        },
                        tooltip: {
                            pointFormat: '<b>{point.percentage:.1f}%</b>'
                        },
                        plotOptions: {
                            pie: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                dataLabels: {
                                    enabled: false
                                },
                                showInLegend: true,
                                events: {
                                    click: function (event) {
                                        var error = 0;
                                        var errorMessage = ' ';
                                        if (error == 0) {
                                            var parametros = {
                                                "fec_desde": fec_desde,
                                                "fec_hasta": fec_hasta,
                                                "status": event.point.codigo
                                            };
                                            $.ajax({
                                                data: parametros,
                                                url: 'packages/grafica/novedades/modelo/getGraficaStatusDet.php',
                                                type: 'post',
                                                success: function (response) {
                                                    var resp = JSON.parse(response);  
                                                    var respFormat2 = [];

                                                    resp.forEach(function(d){
                                                        respFormat2.push({name: d.titulo, y: Number(d.valor), codigo: d.codigo});
                                                    });
                                                    Highcharts.chart('grafica2', {
                                                        chart: {
                                                            plotBackgroundColor: null,
                                                            plotBorderWidth: null,
                                                            plotShadow: false,
                                                            type: 'pie'
                                                        },
                                                        title: {
                                                            text: event.point.name
                                                        },
                                                        tooltip: {
                                                            pointFormat: '<b>{point.percentage:.1f}%</b>'
                                                        },
                                                        plotOptions: {
                                                            pie: {
                                                                allowPointSelect: true,
                                                                cursor: 'pointer',
                                                                dataLabels: {
                                                                    enabled: false
                                                                },
                                                                showInLegend: true
                                                            }

                                                        },
                                                        series: [{
                                                            name: 'Brands',
                                                            colorByPoint: true,
                                                            data: respFormat2
                                                        }]
                                                    });
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
                            }

                        },
                        series: [{
                            name: 'Brands',
                            colorByPoint: true,
                            data: respFormat
                        }]
                    });*/
                    /*
                    //if (resp.length > 5) g.crearGraficaBarra(resp, 450, 'grafica', 'nov1', false, true, 'top', 'col-xs-6', 'Novedades por Status');
                    //else 
                    g.crearGraficaTorta(resp, 450, 'grafica', 'nov1', true, true, 'right', 'col-xs-6', 'Novedades por Status');
                    //g.crearGraficaLineaAgrupada(resp, 450, 'grafica', 'nov1', true, 'col-md-6', 'Novedades por Status');
                    //g2.borrarGrafica('grafica', 'nov2', () => {
                    //   novStatusDet_inic(resp[0].codigo, resp[0].titulo);
                    //});
                    resp.forEach(function (d, i) {
                        novStatusDet(d.codigo, d.titulo);
                    });*/
                } else {
                    $('.brs').hide();
                    $('#sin_data').show();
                    $('#grafica').hide();
                    $('#division').hide();
                    //g2.borrarGrafica('grafica', 'nov2');
                    //g.borrarGrafica('grafica', 'nov1');
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