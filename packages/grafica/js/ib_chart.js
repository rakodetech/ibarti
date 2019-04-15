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
    Torta(id_contenedor, data, titulo,dona) {
        this.datos = [];
        this.labels = [];
        this.codigos = [];

        data.forEach((d) => {
            this.datos.push(Number(d.valor));
            this.labels.push(d.titulo);
            this.codigos.push(d.codigo);
        });
        console.log(dona)
        if (data.length > 0) {
            this.configTorta = {
                type: dona?'doughnut':'doughnut',
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
            this.torta = new Chart(this.ctx, this.configTorta);
            this.torta.codigos = this.codigos;
        }
        return this.torta;
    }

    actualizarTorta(obj, data, titulo,dona) {
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
        ;
        obj.data.labels.pop();
        obj.data.datasets[0].data = this.datos;
        obj.data.labels = this.labels;
        obj.options.title.text = titulo;
        obj.update();
        obj.codigos = this.codigos;
        return obj;
    }

    Barra(id_contenedor,data,titulo){
        this.datos = [];
        this.labels = [];
        this.codigos = [];

        data.forEach((d) => {
            this.datos.push(Number(d.valor));
            this.labels.push(d.titulo);
            this.codigos.push(d.codigo);
        });
    }
}