"use strict";

class GraficasD3 {
    constructor(colores) {
        this.margin = {
            top: 20,
            bottom: 25,
            left: 20,
            right: 25,
            front: 0,
            back: 0
        };
        this.margin_torta = {
            top: 20,
            bottom: 25,
            left: 10,
            right: 0
        };
        this.colores = colores || d3.schemeAccent;
        if (d3.select('#g-tooltip').node())
            this.tooltip = d3.select('#g-tooltip');
        else
            this.tooltip = d3.select("body").append("div").attr("class", "toolTip").property('id', 'g-tooltip');
    }

    crearGraficaTorta(data, height, id_contenedor, id_grafica, dona, _leyenda, posicion_leyenda, column_bootstrap, titulo, callback) {

        if (d3.select('#' + id_contenedor).select('#' + id_grafica).node())
            this.actualizarGrafica(data, id_contenedor, id_grafica, height, 'torta', titulo, '', _leyenda, posicion_leyenda, column_bootstrap, '', dona);
        else {
            // bar colors
            let colors = d3.scaleOrdinal(this.colores);
            _leyenda = _leyenda || false;
            let pxMR = this.margin_torta.right;
            let pxML = this.margin_torta.left;
            let pxMT = this.margin_torta.top;
            let cant = d3.max(data, (d) => Number(d.valor.length));

            if (_leyenda) {
                var leylength = d3.max(data, function (d) {
                    return Number(d.titulo.length);
                });
                if (leylength > 25) pxMR = (leylength + (cant + 2)) * 8;
                else if (leylength > 20) pxMR = (leylength + (cant + 2)) * 10;
                else pxMR = (leylength + (cant + 2)) * 12;
            }

            if (!column_bootstrap) column_bootstrap = 'col-md-12';
            var contenedor = d3.select('#' + id_contenedor)
                .append('div').classed(column_bootstrap, true)
                .property('id', id_grafica)
                .attr('type', 'torta')
                .attr('dona', dona)
                .attr('leyenda', _leyenda)
                .attr('posicion_leyenda', posicion_leyenda);

            let total = 0;
            data.forEach(function (element) {
                total += Number(element.valor);
            });
            let nodo_contenedor_grafica = d3.select('#' + id_contenedor).select('#' + id_grafica).node();
            let widthG = parseInt(window.getComputedStyle(nodo_contenedor_grafica).width);
            let width = widthG - pxML - pxMR;

            contenedor.append("label")
                .attr("transform", "translate(" + (width / 2) + " ," +
                    (pxMT / 2) + ")")
                .attr('class', 'titulo')
                .property('id', 'titulo-torta-' + id_grafica)
                .html(titulo + "<br>");

            var svg = contenedor.append('svg')
                .property('id', 'svg-torta-' + id_grafica)
                .attr('width', parseInt(window.getComputedStyle(nodo_contenedor_grafica).width))
                .attr('height', height);

            if (posicion_leyenda == 'top' && _leyenda) {
                let xm = pxML,
                    ym = pxMT;
                let leyenda = svg.selectAll(".leyenda-torta")
                    .data(data)
                    .enter().append("g")
                    .attr("class", "leyenda-torta")
                    .attr("transform", function (d, i) {
                        if (i != 0) xm += pxMR;
                        if (xm > (widthG / 2)) {
                            ym += 20;
                            xm = pxML;
                        };
                        if (ym >= pxMT) pxMT = ym + 15;
                        return "translate(" + xm + "," + ym + ")";
                    })
                    .style("font", "10px sans-serif")

                leyenda.append("circle")
                    .attr("class", "bar")
                    .attr("width", 18)
                    .attr("height", 18)
                    .attr("fill", function (d, i) {
                        return colors(i);
                    })
                    .attr("cx", 0)
                    .attr("r", 7.5)
                    .property('id', function (d) {
                        return 'cod' + d.codigo;
                    })
                    .on("mousemove", function (d) {
                        this.tooltip
                            .style("left", d3.event.pageX - 50 + "px")
                            .style("top", d3.event.pageY - 70 + "px")
                            .style("display", "inline-block")
                            .html("<p>" + (d.titulo) + "<br>" + d.valor + " : " + ((d.valor * 100) / total_1).toFixed(2) + '% </p>');
                    })
                    .on("mouseout", function (d) {
                        this.tooltip.style("display", "none");
                    })
                    .transition()
                    .ease(d3.easeBackOut)
                    .duration(1000)
                    .attr("cx", 10);

                leyenda.append("text")
                    .attr("class", "text-leyenda")
                    .attr("dy", ".35em")
                    .attr("text-anchor", "start")
                    .attr("x", 0)
                    .transition()
                    .ease(d3.easeBackOut)
                    .duration(1000)
                    .attr("x", 30)
                    .text(function (d) {
                        return d.titulo + ' (' + d.valor + ')';
                    });
            } else {
                widthG = width;
            }

            let radio = (Math.min(widthG, height) / 2) - pxMT;


            // Area de la grafica "torta"
            let chart = svg.append('g')
                .property('id', 'chart-torta-' + id_grafica)
                .attr('class', 'shadow torta')
                .attr('transform', "translate(" + widthG / 2 + ", " + height / 2 + ")");

            svg.append('text')
                .property('id', 'total-torta-' + id_grafica)
                .attr('class', 'etiqueta total')
                .attr('transform', "translate(" + (widthG - (cant * 30)) / 2 + ", " + (height - (this.margin_torta.bottom / 2)) + ")")
                .text('Total: ' + total);

            if (dona == true) {
                var arcos = d3.arc()
                    .outerRadius(radio - 10)
                    .innerRadius(radio / 2)
                    .padAngle(0.01);
            } else {
                var arcos = d3.arc()
                    .outerRadius(radio - 10)
                    .innerRadius(0)
                    .padAngle(0.01);
            }

            let etiqueta = d3.arc()
                .innerRadius(radio)
                .outerRadius(radio);
            let etiqueta2 = d3.arc()
                .outerRadius(radio - 40)
                .innerRadius(radio - 40);
            var torta = d3.pie()
                .sort(null)
                .value((d) => Number(d.valor));

            let slice = chart.append("g")
                .attr("class", "arc");

            let path = slice.selectAll(".arc").data(torta(data)).enter()
                .append("path")
                .attr("d", arcos)
                .style("fill", (d, i) => colors(i))
                .property('id', (d, i) => 'cod' + d.data.codigo)
                .on("mousemove", (d) => this.tooltip
                        .style("left", d3.event.pageX - 50 + "px")
                        .style("top", d3.event.pageY - 120 + "px")
                        .style("display", "inline-block")
                        .html("<p>" + (d.data.titulo) + "<br>" + (d.data.valor) + "</p>" + ((d.value * 100) / total).toFixed(2) + '%')
                )
                .on("mouseout", (d) => this.tooltip.style("display", "none"));
            path.transition()
                .duration(750)
                .attrTween("d", (d) => {
                    let interpolate = d3.interpolate({
                        startAngle: 0,
                        endAngle: 0
                    }, d);
                    return function (t) {
                        return arcos(interpolate(t));
                    };
                });

            //Porcentaje de los arcos de la torta
            chart.selectAll(".arc")
                .selectAll(".porcentaje")
                .data(torta(data))
                .enter()
                .append("text")
                .attr('class', 'porcentaje etiqueta')
                .attr('id', (d) => 'cod' + d.codigo)
                .attr("transform", "translate(0,0)")
                .transition().delay(100).duration(700).ease(d3.easeBackOut)
                .attr("transform", (d, i) => {
                    if (i % 2) {
                        return "translate(" + etiqueta.centroid(d) + ")";
                    } else {
                        return "translate(" + etiqueta2.centroid(d) + ")";
                    }
                })
                .attr("dy", ".35em")
                .text(function (d) {
                    return ((d.value * 100) / total).toFixed(2) + '%';
                })
                .attr('style', function () {
                    var size = 60 / torta(data).length;
                    if (size > 25) size = 25;
                    if (size < 10) size = 10;
                    return 'font-size  : ' + size + 'px;';
                });

            if (posicion_leyenda == 'right' && _leyenda) {
                let leyenda = svg.selectAll(".leyenda-torta")
                    .data(data)
                    .enter().append("g")
                    .attr("class", "leyenda-torta")
                    .attr("transform", function (d, i) {
                        return "translate(0," + i * 20 + ")";
                    })
                    .style("font", "10px sans-serif");
                leyenda.append("circle")
                    .attr("class", "bar")
                    .attr("width", 18)
                    .attr("height", 18)
                    .attr("fill", function (d, i) {
                        return colors(i);
                    })
                    .attr("cx", 0)
                    .attr("cy", 0)
                    .attr("r", 7.5)
                    .property('id', function (d) {
                        return 'cod' + d.codigo;
                    })
                    .on("mousemove",  (d) =>
                        this.tooltip
                            .style("left", d3.event.pageX - 50 + "px")
                            .style("top", d3.event.pageY - 70 + "px")
                            .style("display", "inline-block")
                            .html("<p>" + (d.titulo) + "<br>" + d.valor + " : " + ((d.valor * 100) / total).toFixed(2) + '% </p>')
                    )
                    .on("mouseout", (d) =>
                        this.tooltip.style("display", "none")
                    )
                    .transition()
                    .ease(d3.easeBackOut)
                    .duration(1000)
                    .attr('cy', this.margin_torta.top)
                    .attr("cx", width + pxML);
                leyenda.append("text")
                    .attr("class", "text-leyenda")
                    .attr("dy", ".35em")
                    .attr("text-anchor", "start")
                    .attr("x", 0)
                    .attr("y", 0)
                    .transition()
                    .ease(d3.easeBackOut)
                    .duration(1000)
                    .attr("x", width + pxML + 17)
                    .attr("y", this.margin_torta.top)
                    .text(function (d) {
                        return d.titulo + ' (' + d.valor + ')';
                    });
            }
        }
        if (typeof callback == 'function') callback();
    };
}