"use strict";

class Grafica {
    constructor(colores) {
        //contenedor
        this.ctx = null;
        //datos basicos de grafica
        this.datos = [];
        this.labels = [];
        this.codigos = [];
        //configuracion torta
        this.torta = null;
        this.configTorta = {};
        //configuracion barra
        this.barra = null;
        this.configBarra = {};
        if (colores) {
            this.chartColors = colores;
        } else {
            this.chartColors = [
                'rgb(255, 99, 132)', 'rgb(255, 159, 64)', 'rgb(255, 205, 86)',
                'rgb(75, 192, 192)', 'rgb(54, 162, 235)', 'rgb(153, 102, 255)', 'rgb(201, 203, 207)'
            ];
        }
    }
    /**
     *
     *
     * @param {*} id_contenedor
     * @param {*} data
     * @memberof Grafica
     */

    Torta(id_contenedor, data, titulo, dona) {


        var dat = this.reset_data(data);
        var dataseta = [];
        dat.forEach((dataset, i) => {
            dataseta.push({
                data: dataset.datos,
                backgroundColor: this.chartColors
            });
        });

        this.datos = [];
        this.labels = [];
        this.codigos = [];

        data.forEach((d) => {
            this.datos.push(Number(d.valor));
            this.labels.push(d.titulo);
            this.codigos.push(d.codigo);
        });

        if (data.length > 0) {
            this.configTorta = {
                type: dona ? "doughnut" : "pie",
                data: {
                    datasets: dataseta,
                    labels: dat[0].labels
                },
                options: {
                    responsive: true,
                    title: {
                        display: true,
                        text: titulo
                    },
                    tooltips: {
                        callbacks: {
                            label: function (tooltipItem, data) {

                                var label = data.labels[tooltipItem.index] || '';
                                var total = 0;
                                data.datasets[tooltipItem.datasetIndex].data.forEach((d) => {
                                    total += d
                                });

                                if (label) {
                                    label += ': ' + data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index] + ' : \n';
                                }
                                label += parseFloat((data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index] * 100) / total).toFixed(2);
                                label += ' %';
                                return label;
                            }
                        }
                    },
                    angleLines: {
                        display: true
                    }

                }
            };

            this.ctx = document.getElementById(id_contenedor).getContext('2d');
            this.torta = new Chart(this.ctx, this.configTorta);
            this.torta.codigos = this.codigos;
            this.torta.datos_g = dat;
        }
        console.log(this.torta)
        return this.torta;
    }

    actualizarTorta(obj, data, titulo, dona) {
        this.datos = [];
        this.labels = [];
        this.codigos = [];

        data.forEach((d) => {
            this.datos.push(Number(d.valor));
            this.labels.push(d.titulo);
            this.codigos.push(d.codigo);
        });

        obj.data.datasets.forEach((dataset) => {
            dataset.data.pop();
        });


        obj.data.labels.pop();
        obj.data.datasets[0].data = this.datos;
        obj.data.labels = this.labels;
        obj.options.title.text = titulo;
        obj.update();
        obj.codigos = this.codigos;
        return obj;
    }
    Barra(id_contenedor, data, titulo, dona) {
        this.datos = [];
        this.labels = [];
        this.codigos = [];

        data.forEach((d) => {
            this.datos.push(Number(d.valor));
            this.labels.push(d.titulo);
            this.codigos.push(d.codigo);
        });

        if (data.length > 0) {
            this.configBarra = {
                type: 'bar',
                data: {
                    datasets: [{
                        data: this.datos,
                        backgroundColor: this.chartColors,
                    }],
                    labels: this.labels
                },
                options: {
                    responsive: true,
                    title: {
                        display: true,
                        text: titulo
                    },
                    tooltips: {
                        callbacks: {
                            label: function (tooltipItem, data) {

                                var label = data.labels[tooltipItem.index] || '';
                                var total = 0;
                                data.datasets[tooltipItem.datasetIndex].data.forEach((d) => {
                                    total += d
                                });

                                if (label) {
                                    label += ': ' + data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index] + ' : \n';
                                }
                                label += parseFloat((data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index] * 100) / total).toFixed(2);
                                label += ' %';
                                return label;
                            }
                        }
                    },
                    angleLines: {
                        display: true
                    }

                }

            };

            this.ctx = document.getElementById(id_contenedor).getContext('2d');
            this.barra = new Chart(this.ctx, this.configBarra);
            this.barra.codigos = this.codigos;
        }
        return this.barra;
    }


    reset_data(data) {
        var array_codigos = [];
        var array_labels = [];
        var array_valores = [];

        function filtrado(array) {
            var new_array = "{"
            var i = 0;
            for (const prop in array) {
                if (i == 0) {
                    new_array += `"${prop}":"${array[prop].trim()}"`;
                    i++;
                } else {
                    new_array += `,"${prop}":"${array[prop].trim()}"`;
                }
            }

            new_array += "}";
            return JSON.parse(new_array);
        }

        if (typeof data[0].agrupaciones === "undefined") {
            data.forEach((res) => {
                array_codigos.push(res.codigo);
                array_labels.push(res.titulo);
                array_valores.push(Number(res.valor));
            });
            var datasets = [{ "datos": array_valores, "labels": array_labels, "codigos": array_codigos }];
        } else {


            var agrupacion = data[0].agrupaciones.trim();

            var datasets = []
            data.forEach((res, i) => {
                console.log(res)
                if (i == data.length - 1) {
                    if (agrupacion == res.agrupaciones.trim()) {
                        var ev_fil = filtrado(res)
                        array_codigos.push(ev_fil.codigo);
                        array_labels.push(ev_fil.titulo);
                        array_valores.push(Number(ev_fil.valor));
                        datasets.push({ "agrupacion": agrupacion, "datos": array_valores, "labels": array_labels, "codigos": array_codigos });
                    } else {
                        datasets.push({ "agrupacion": agrupacion, "datos": array_valores, "labels": array_labels, "codigos": array_codigos });
                        /////////////7
                        array_codigos = []
                        array_labels = []
                        array_valores = []
                        ////////////////7
                        var ev_fil = filtrado(res);
                        array_codigos.push(ev_fil.codigo);
                        array_labels.push(ev_fil.titulo);
                        array_valores.push(Number(ev_fil.valor));
                        /////////
                        /////////////
                        agrupacion = res.agrupaciones.trim();
                        datasets.push({ "agrupacion": agrupacion, "datos": array_valores, "labels": array_labels, "codigos": array_codigos });
                    }
                } else {
                    if (i == 0) {
                        agrupacion == res.agrupaciones.trim();
                        var ev_fil = filtrado(res);
                        array_codigos.push(ev_fil.codigo);
                        array_labels.push(ev_fil.titulo);
                        array_valores.push(Number(ev_fil.valor));
                    } else {
                        if (agrupacion == res.agrupaciones.trim()) {
                            var ev_fil = filtrado(res);
                            array_codigos.push(ev_fil.codigo);
                            array_labels.push(ev_fil.titulo);
                            array_valores.push(Number(ev_fil.valor));
                        } else {
                            datasets.push({ "agrupacion": agrupacion, "datos": array_valores, "labels": array_labels, "codigos": array_codigos });
                            array_codigos = [];
                            array_labels = [];
                            array_valores = [];
                            var ev_fil = filtrado(res);
                            array_codigos.push(ev_fil.codigo);
                            array_labels.push(ev_fil.titulo);
                            array_valores.push(Number(ev_fil.valor));
                            agrupacion = res.agrupaciones.trim();
                        }
                    }

                }

            });
        }
        return datasets;

    }
}


