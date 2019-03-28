var GraficasD3 = (function () {
    
    function GraficasD3(colores) {
        this.margin = { top: 20, bottom: 25, left: 20, right: 25, front: 0, back: 0 };
        this.margin_torta = { top: 20, bottom: 25, left: 10, right: 0 };
        this.colores = colores || d3.schemeAccent;
        if (d3.select('#g-tooltip').node())
            this.tooltip = d3.select('#g-tooltip');
        else
            this.tooltip = d3.select("body").append("div").attr("class", "toolTip").property('id', 'g-tooltip');
    }

    GraficasD3.prototype.borrarGrafica = function (id_contenedor, id_grafica, callback) {
        if (d3.select('#' + id_contenedor).select('#' + id_grafica).node()) {
            d3.select('#' + id_contenedor).select('#' + id_grafica).remove();
            d3.select('#' + id_contenedor).select('#exportar-' + id_grafica).remove();
        }
        if (typeof (callback) == 'function') callback();
    };

    GraficasD3.prototype.crearGraficaTorta = function (data, height, id_contenedor, id_grafica, dona, _leyenda, posicion_leyenda, column_bootstrap, titulo, callback) {
        var _this = this;
        if (d3.select('#' + id_contenedor).select('#' + id_grafica).node())
            this.actualizarGrafica(data, id_contenedor, id_grafica, height, 'torta', titulo, '', _leyenda, posicion_leyenda, column_bootstrap, '', dona);
        else {
            // bar colors
            this.colors = d3.scaleOrdinal(this.colores);
            _leyenda = _leyenda || false;
            var pxMR = this.margin_torta.right;
            var pxML = this.margin_torta.left;
            var pxMT = this.margin_torta.top;
            var cant = d3.max(data, (d) => Number(d.valor.length));

            if (_leyenda) {
                var leylength = d3.max(data, function (d) { return Number(d.titulo.length); });
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

            var total_1 = 0;
            data.forEach(function (element) {
                total_1 += Number(element.valor);
            });
            var nodo_contenedor_grafica = d3.select('#' + id_contenedor).select('#' + id_grafica).node();
            var widthG = parseInt(window.getComputedStyle(nodo_contenedor_grafica).width);
            var width = widthG - pxML - pxMR;

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
            /*
              contenedor.append("button")
                  .style("text-anchor", "middle")
                  .property('id', 'exportar-' + id_grafica)
                  .attr('target', "_blank")
                  .html('Exportar').on('click', function () {
                      exportarGrafica('svg-torta-' + id_grafica);
                  });
                  */
            if (posicion_leyenda == 'top' && _leyenda) {
                var xm = pxML, ym = pxMT;
                var leyenda = svg.selectAll(".leyenda-torta")
                    .data(data)
                    .enter().append("g")
                    .attr("class", "leyenda-torta")
                    .attr("transform", function (d, i) {
                        if (i != 0) xm += pxMR;
                        if (xm > (widthG / 2)) { ym += 20; xm = pxML; };
                        if (ym >= pxMT) pxMT = ym + 15;
                        return "translate(" + xm + "," + ym + ")";
                    })
                    .style("font", "10px sans-serif")

                leyenda.append("circle")
                    .attr("class", "bar")
                    .attr("width", 18)
                    .attr("height", 18)
                    .attr("fill", function (d, i) { return _this.colors(i); })
                    .attr("cx", 0)
                    .attr("r", 7.5)
                    .property('id', function (d) {
                        return 'cod' + d.codigo;
                    })
                    .on("mousemove", function (d) {
                        self_1.tooltip
                            .style("left", d3.event.pageX - 50 + "px")
                            .style("top", d3.event.pageY - 70 + "px")
                            .style("display", "inline-block")
                            .html("<p>" + (d.titulo) + "<br>" + d.valor + " : " + ((d.valor * 100) / total_1).toFixed(2) + '% </p>');
                    })
                    .on("mouseout", function (d) { self_1.tooltip.style("display", "none"); })
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
                    .text(function (d) { return d.titulo + ' (' + d.valor + ')'; });
            } else {
                widthG = width;
            }

            var height_chart_1 = height - pxMT - this.margin_torta.bottom;
            var self_1 = this;

            var radio = (Math.min(widthG, height) / 2) - pxMT;


            // Area de la grafica "torta"
            var chart = svg.append('g')
                .property('id', 'chart-torta-' + id_grafica)
                .attr('class', 'shadow torta')
                .attr('transform', "translate(" + widthG / 2 + ", " + height / 2 + ")");

            svg.append('text')
                .property('id', 'total-torta-' + id_grafica)
                .attr('class', 'etiqueta total')
                .attr('transform', "translate(" + (widthG - (cant * 30)) / 2 + ", " + (height - (self_1.margin_torta.bottom / 2)) + ")")
                .text('Total: ' + total_1);

            if (dona == true) {
                var arcos = d3.arc()
                    .outerRadius(radio - 10)
                    .innerRadius(radio / 2)
                    .padAngle(0.01);
            }
            else {
                var arcos = d3.arc()
                    .outerRadius(radio - 10)
                    .innerRadius(0)
                    .padAngle(0.01);
            }
            var etiqueta_1 = d3.arc()
                .innerRadius(radio)
                .outerRadius(radio);
            var etiqueta2_1 = d3.arc()
                .outerRadius(radio - 40)
                .innerRadius(radio - 40);
            var torta = d3.pie()
                .sort(null)
                .value((d) => Number(d.valor));

            var slice = chart.append("g")
                .attr("class", "arc");

            var path = slice.selectAll(".arc").data(torta(data)).enter()
                .append("path")
                .attr("d", arcos)
                .style("fill", (d, i) => _this.colors(i))
                .property('id', (d, i) => 'cod' + d.data.codigo)
                .on("mousemove", (d) => {
                    self_1.tooltip
                        .style("left", d3.event.pageX - 50 + "px")
                        .style("top", d3.event.pageY - 120 + "px")
                        .style("display", "inline-block")
                        .html("<p>" + (d.data.titulo) + "<br>" + (d.data.valor) + "</p>" + ((d.value * 100) / total_1).toFixed(2) + '%');
                })
                .on("mouseout", (d) => self_1.tooltip.style("display", "none"));
            path.transition()
                .duration(750)
                .attrTween("d", (d) => {
                    var interpolate = d3.interpolate({ startAngle: 0, endAngle: 0 }, d);
                    return function (t) { return arcos(interpolate(t)); };
                });

            //Porcentaje de los arcos de la torta
            chart.selectAll(".arc")
                .selectAll(".porcentaje")
                .data(torta(data))
                .enter()
                .append("text")
                .attr('class', 'porcentaje etiqueta')
                .attr('id',(d)=>'cod'+d.codigo)
                .attr("transform", "translate(0,0)")
                .transition().delay(100).duration(700).ease(d3.easeBackOut)
                .attr("transform", (d, i) => {
                    if (i % 2) {
                        return "translate(" + etiqueta_1.centroid(d) + ")";
                    }
                    else {
                        return "translate(" + etiqueta2_1.centroid(d) + ")";
                    }
                })
                .attr("dy", ".35em")
                .text(function (d) { return ((d.value * 100) / total_1).toFixed(2) + '%'; })
                .attr('style', function () {
                    var size = 60 / torta(data).length;
                    if (size > 25) size = 25;
                    if (size < 10) size = 10;
                    return 'font-size  : ' + size + 'px;';
                });

            if (posicion_leyenda == 'right' && _leyenda) {
                var leyenda = svg.selectAll(".leyenda-torta")
                    .data(data)
                    .enter().append("g")
                    .attr("class", "leyenda-torta")
                    .attr("transform", function (d, i) { return "translate(0," + i * 20 + ")"; })
                    .style("font", "10px sans-serif");
                leyenda.append("circle")
                    .attr("class", "bar")
                    .attr("width", 18)
                    .attr("height", 18)
                    .attr("fill", function (d, i) { return _this.colors(i); })
                    .attr("cx", 0)
                    .attr("cy", 0)
                    .attr("r", 7.5)
                    .property('id', function (d) {
                        return 'cod' + d.codigo;
                    })
                    .on("mousemove", function (d) {
                        self_1.tooltip
                            .style("left", d3.event.pageX - 50 + "px")
                            .style("top", d3.event.pageY - 70 + "px")
                            .style("display", "inline-block")
                            .html("<p>" + (d.titulo) + "<br>" + d.valor + " : " + ((d.valor * 100) / total_1).toFixed(2) + '% </p>');
                    })
                    .on("mouseout", function (d) { self_1.tooltip.style("display", "none"); })
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
                    .text(function (d) { return d.titulo + ' (' + d.valor + ')'; });
            }
        }
        if (typeof callback == 'function') callback();
    };
    GraficasD3.prototype.actualizarGraficaTorta = function (datos, id_contenedor, id_grafica, titulo, _leyenda) {
        var _this = this;
        var nodo_contenedor_grafica = d3.select('#' + id_contenedor).select('#' + id_grafica).node();
        var div_grafica = d3.select('#' + id_contenedor).select('#' + id_grafica);
        var svg = div_grafica.select('#svg-torta-' + id_grafica);

        var pxMR = this.margin_torta.right;
        var pxML = this.margin_torta.left;
        var pxMT = this.margin_torta.top;
        var cant = d3.max(datos, (d) => Number(d.valor.length));

        if ((div_grafica.attr('leyenda') == 'true') || _leyenda) {
            var leylength = d3.max(datos, function (d) { return Number(d.titulo.length); });
            if (leylength > 25) pxMR = (leylength + (cant + 2)) * 8;
            else if (leylength > 20) pxMR = (leylength + (cant + 2)) * 10;
            else pxMR = (leylength + (cant + 2)) * 12;
        }

        var self = this;

        var widthChart = svg.attr('width') - pxML - pxMR;
        var widthG = parseInt(window.getComputedStyle(nodo_contenedor_grafica).width);

        var total = 0;
        datos.forEach(function (element) { total += Number(element.valor); });
        svg.selectAll(".leyenda-torta").remove();

        if (((div_grafica.attr('leyenda') == 'true') || _leyenda) && div_grafica.attr('posicion_leyenda') == 'top') {

            var xm = pxML, ym = pxMT;
            var leyenda = svg.selectAll(".leyenda-torta")
                .data(datos)
                .enter().append("g")
                .attr("class", "leyenda-torta")
                .attr("transform", function (d, i) {
                    if (i != 0) xm += pxMR;
                    if (xm > (widthG / 2)) { ym += 20; xm = pxML; };
                    if (ym >= pxMT) pxMT = ym + 15;
                    return "translate(" + xm + "," + ym + ")";
                })
                .style("font", "10px sans-serif")

            leyenda.append("circle")
                .attr("class", "bar")
                .attr("width", 18)
                .attr("height", 18)
                .attr("fill", function (d, i) { return _this.colors(i); })
                .attr("cx", 0)
                .attr("r", 7.5)
                .property('id', function (d) {
                    return 'cod' + d.codigo;
                })
                .on("mousemove", function (d) {
                    self.tooltip
                        .style("left", d3.event.pageX - 50 + "px")
                        .style("top", d3.event.pageY - 70 + "px")
                        .style("display", "inline-block")
                        .html("<p>" + (d.titulo) + "<br>" + d.valor + " : " + ((d.valor * 100) / total).toFixed(2) + '% </p>');
                })
                .on("mouseout", function (d) { self.tooltip.style("display", "none"); })
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
                .text(function (d) { return d.titulo + ' (' + d.valor + ')'; });
        }
        else {
            widthG = widthChart;
        }

        var heightChart = svg.attr('height') - pxMT - this.margin_torta.bottom;

        var chart = svg.select('#chart-torta-' + id_grafica)
            .attr('transform', "translate(" + widthG / 2 + ", " + svg.attr('height') / 2 + ")");
        chart.selectAll(".porcentaje").remove();
        chart.selectAll("path").remove();

        svg.select('#total-torta-' + id_grafica)
            .transition()
            .attr('transform', "translate(" + (widthG - (cant * 30)) / 2 + ", " + (svg.attr('height') - (self.margin_torta.bottom / 2)) + ")")
            .text('Total: ' + total);

        var radio = (Math.min(widthG, svg.attr('height')) / 2) - pxMT;

        if (titulo) d3.select("#titulo-torta-" + id_grafica).html(titulo + "<br>");

        if (div_grafica.attr('dona') == 'true') {
            var arcos = d3.arc()
                .outerRadius(radio - 10)
                .innerRadius(radio / 2)
                .padAngle(0.01);
        }
        else {
            var arcos = d3.arc()
                .outerRadius(radio - 10)
                .innerRadius(0)
                .padAngle(0.01);
        }
        var etiqueta = d3.arc()
            .innerRadius(radio)
            .outerRadius(radio);
        var etiqueta2 = d3.arc()
            .outerRadius(radio - 40)
            .innerRadius(radio - 40);
        var torta = d3.pie()
            .sort(null)
            .value((d) => Number(d.valor));

        var oldData = chart.select(".arc")
            .selectAll("path")
            .data().map((d) => d.data);

        if (oldData.length == 0) oldData = datos;

        var slice = chart.select(".arc")
            .selectAll("path")
            .data(torta(datos));

        slice.enter()
            .insert("path")
            .property('id', (d, i) => 'cod' + d.data.codigo)
            .style("fill", (d, i) => _this.colors(i))
            .on("mousemove", function (d) {
                self.tooltip
                    .style("left", d3.event.pageX - 50 + "px")
                    .style("top", d3.event.pageY - 120 + "px")
                    .style("display", "inline-block")
                    .html("<p>" + (d.data.titulo) + "<br>" + (d.data.valor) + "</p>" + ((d.value * 100) / total).toFixed(2) + '%');
            })
            .on("mouseout", function (d) { self.tooltip.style("display", "none"); })
            .each(function (d) {
                this._current = d;
            });

        slice = chart.select(".arc")
            .selectAll("path")
            .data(torta(datos));

        slice.transition()
            .duration(1000)
            .attrTween('d', function (d) {
                var interpolate = d3.interpolate({ startAngle: 0, endAngle: 0 }, d);
                return function (t) { return arcos(interpolate(t)); };
            });

        slice = chart.select(".arc")
            .selectAll("path")
            .data(torta(datos));

        slice.exit()
            .transition()
            .delay(500)
            .duration(0)
            .remove();

        chart.select(".arc")
            .selectAll(".porcentaje")
            .data(torta(datos))
            .enter()
            .append("text")
            .attr('class', 'porcentaje etiqueta')
            .attr("transform", function (d) { return "translate(0,0)"; })
            .attr("dy", ".35em")
            .text(function (d) { return ((d.data.valor * 100) / total).toFixed(2) + '%'; })
            .transition().duration(750)
            .attr("transform", function (d, i) {
                if (i % 2) {
                    return "translate(" + etiqueta.centroid(d) + ")";
                }
                else {
                    return "translate(" + etiqueta2.centroid(d) + ")";
                }
            })
            .attr('style', function () {
                var size = 60 / torta(datos).length;
                if (size > 25) size = 25;
                return 'font-size  : ' + size + 'px;';
            });

        if (((div_grafica.attr('leyenda') == 'true') || _leyenda) && div_grafica.attr('posicion_leyenda') == 'right') {
            var leyenda = svg.selectAll(".leyenda-torta")
                .data(datos)
                .enter().append("g")
                .attr("class", "leyenda-torta")
                .attr("transform", function (d, i) { return "translate(0," + i * 20 + ")"; })
                .style("font", "10px sans-serif");
            leyenda.append("circle")
                .attr("class", "bar")
                .attr("width", 18)
                .attr("height", 18)
                .attr("fill", function (d, i) { return _this.colors(i); })
                .attr("cx", 0)
                .attr("cy", 0)
                .attr("r", 7.5)
                .property('id', function (d, i) { return 'cod' + d.codigo; })
                .on("mousemove", function (d) {
                    self.tooltip
                        .style("left", d3.event.pageX - 50 + "px")
                        .style("top", d3.event.pageY - 70 + "px")
                        .style("display", "inline-block")
                        .html("<p>" + (d.titulo) + "<br>" + d.valor + " : " + ((d.valor * 100) / total).toFixed(2) + '%</p>');
                })
                .on("mouseout", function (d) { self.tooltip.style("display", "none"); })
                .transition()
                .ease(d3.easeBackOut)
                .duration(1000)
                .attr('cy', this.margin_torta.top)
                .attr("cx", widthChart + pxML);
            leyenda.append("text")
                .attr("class", "text-leyenda")
                .attr("dy", ".35em")
                .attr("text-anchor", "start")
                .attr("x", 0)
                .attr("y", 0)
                .transition()
                .ease(d3.easeBackOut)
                .duration(1000)
                .attr("x", widthChart + pxML + 17)
                .attr("y", this.margin_torta.top)
                .text(function (d) { return d.titulo + ' (' + d.valor + ')'; });

        }
    };
    GraficasD3.prototype.crearGraficaBarra = function (data, height, id_contenedor, id_grafica, _horizontal, _leyenda, posicion_leyenda, column_bootstrap, titulo, callback) {
        var _this = this;
        if (d3.select('#' + id_contenedor).select('#' + id_grafica).node()) {
            this.actualizarGrafica(data, id_contenedor, id_grafica, height, 'barra', titulo, _horizontal, _leyenda, posicion_leyenda, column_bootstrap);
        }
        else {
            // bar colors
            this.colors = d3.scaleOrdinal(this.colores);
            _leyenda = _leyenda || false;
            _horizontal = _horizontal || false;
            var pxMR = this.margin.right;
            var pxML = this.margin.left;
            var pxMB = this.margin.bottom;
            var pxMT = this.margin.top;

            var total_4 = 0;
            data.forEach(function (element) { total_4 += Number(element.valor); });
            var cant = d3.max(data, (d) => Number(d.valor.length));
            if (cant > 1) {
                if (_horizontal)
                    if (cant < 6) pxMB = (cant * 20) + this.margin.bottom;
                    else pxMB = (cant * 16) + this.margin.bottom;
                else pxML = cant * 15;
            }
            var leylength = d3.max(data, function (d) { return Number(d.titulo.length); });
            if (leylength > 1) {
                if (_horizontal) {
                    if (leylength > 25) pxML = (leylength * 8);
                    else if (leylength > 9) pxML = (leylength * 10);
                    else pxML = (leylength * 12);
                }
                else {
                    if (leylength > 25) {
                        pxML = (leylength * 2);
                        pxMB = (leylength * 7) + this.margin.bottom;
                    } else if (leylength > 9) pxMB = (leylength * 9) + this.margin.bottom;
                    else pxMB = (leylength * 11) + this.margin.bottom;
                }
                if (_leyenda && data.length > 1) {
                    if (leylength > 25) pxMR = (leylength + (cant + 2)) * 8;
                    else if (leylength > 20) pxMR = (leylength + (cant + 2)) * 10;
                    else pxMR = (leylength + (cant + 2)) * 12;
                }
            }

            column_bootstrap = column_bootstrap || 'col-md-12';
            var self_4 = this;
            var contenedor = d3.select('#' + id_contenedor)
                .append('div')
                .classed(column_bootstrap, true)
                .property('id', id_grafica)
                .attr('type', 'barra')
                .attr('leyenda', _leyenda)
                .attr('horizontal', _horizontal)
                .attr('posicion_leyenda', posicion_leyenda);

            var nodo_contenedor_grafica = d3.select('#' + id_contenedor).select('#' + id_grafica).node();
            var widthG = parseInt(window.getComputedStyle(nodo_contenedor_grafica).width)

            contenedor.append("label")
                .attr("transform", "translate(" + (width / 2) + " ," +
                    (this.margin.top / 2) + ")")
                .style("text-anchor", "middle")
                .property('id', 'titulo-barra-' + id_grafica)
                .attr('class', 'titulo')
                .html(titulo + "<br>");

            var svg = contenedor.append('svg')
                .property('id', 'svg-barra-' + id_grafica)
                .attr('width', parseInt(window.getComputedStyle(nodo_contenedor_grafica).width))
                .attr('height', height);

            if ((posicion_leyenda == 'top' && _leyenda) && data.length > 1) {
                var xm = this.margin.left, ym = pxMT;
                var leyenda = svg.selectAll(".leyenda-bar")
                    .data(data)
                    .enter().append("g")
                    .attr("class", "leyenda-bar")
                    .attr("transform", function (d, i) {
                        if (i != 0) xm += pxMR;
                        if (xm > (widthG / 2)) { ym += 20; xm = self_4.margin.left; };
                        if (ym > pxMT) pxMT = ym + 15;
                        return "translate(" + xm + "," + ym + ")";
                    })
                    .style("font", "10px sans-serif");

                leyenda.append("rect")
                    .attr("class", "bar")
                    .attr("width", 18)
                    .attr("height", 18)
                    .attr("fill", function (d, i) { return _this.colors(i); })
                    .attr("x", 0)
                    .property('id', function (d, i) { return 'cod' + d.codigo })
                    .on("mousemove", function (d) {
                        self_4.tooltip
                            .style("left", d3.event.pageX - 50 + "px")
                            .style("top", d3.event.pageY - 70 + "px")
                            .style("display", "inline-block")
                            .html("<p>" + (d.titulo) + "<br>" + d.valor + " : " + ((d.valor * 100) / total_4).toFixed(2) + '%</p>');
                    })
                    .on("mouseout", function (d) { self_4.tooltip.style("display", "none"); })
                    .transition()
                    .ease(d3.easeBackOut)
                    .duration(1000)
                    .attr("x", 10);

                leyenda.append("text")
                    .attr("class", "text-leyenda")
                    .attr("dy", ".35em")
                    .attr("text-anchor", "start")
                    .attr("x", 0)
                    .attr("y", 0)
                    .transition()
                    .ease(d3.easeBackOut)
                    .duration(1000)
                    .attr("x", 40)
                    .attr("y", 10)
                    .text(function (d) { return d.titulo + ' (' + d.valor + ')'; });

                pxMR = this.margin.right;
            }

            /*    
                    contenedor.append("button")
                .style("text-anchor", "middle")
                .property('id', 'exportar-' + id_grafica)
                .attr('target', "_blank")
                .html('Exportar').on('click', function () {
                    exportarGrafica('svg-barra-' + id_grafica);
                });
                */
            svg.append('text')
                .property('id', 'total-barra-' + id_grafica)
                .attr('class', 'etiqueta total')
                .attr('transform', "translate(" + (parseInt(window.getComputedStyle(nodo_contenedor_grafica).width) - (cant * 30)) / 2 + ", " + (height - (this.margin.bottom / 2)) + ")")
                .text('Total: ' + total_4);
            var width = widthG - pxML - pxMR;
            var height_chart_3 = height - (pxMT + 15) - pxMB;
            // crear escalas 
            if (_horizontal) {
                var yScale = d3.scaleBand().padding(0.1).rangeRound([height_chart_3, 0]).domain(data.map(function (d) { return d.titulo; }));
                var xScale = d3.scaleLinear().rangeRound([0, width]).domain([0, d3.max(data, function (d) { return Number(d.valor); })]);

                // eje x
                svg.append('g')
                    .attr('class', 'axis axis-x grid')
                    .attr('transform', "translate(" + pxML + ", " + ((pxMT + 15) + height_chart_3) + ")")
                    .call(d3.axisBottom(xScale)
                        .tickFormat(null)
                        .tickSize(-height_chart_3))
                    .selectAll("g")
                    .on("mousemove", function () {
                        d3.select(this).select("line").style("stroke-opacity", ".8");
                        d3.select(this).select("text").style("font-size", "20px");
                    })
                    .on("mouseout", function (d) {
                        d3.select(this).select("line").style("stroke-opacity", ".14");
                        d3.select(this).select("text").style("font-size", "11.5px");
                    })
                    .selectAll("text")
                    .style("text-anchor", "end")
                    .attr("dx", "-.8em")
                    .attr("dy", ".15em")
                    .attr("transform", "rotate(-65)");

                // Area de la grafica
                var chart = svg.append('g')
                    .property('id', 'chart-barra-' + id_grafica)
                    .attr('class', 'shadow')
                    .attr('class', 'bars')
                    .attr('transform', "translate(" + pxML + ", " + (pxMT + 15) + ")");

                var bar = chart.selectAll('.bar')
                    .data(data)
                    .enter()
                    .append('g')
                    .attr('class', 'bar')
                    .attr('opacity', .8)
                    .property('id', function (d, i) { return 'cod' + d.codigo })

                bar.append("rect")
                    .attr('x', function (d) { return xScale(0); })
                    .attr('y', function (d) { return yScale(d.titulo); })
                    .attr('class', 'natural')
                    .attr('width', 0)
                    .attr('height', yScale.bandwidth())
                    .attr('fill', function (d, i) { return _this.colors(i); })
                    .on("mousemove", function (d) {
                        self_4.tooltip
                            .style("left", d3.event.pageX - 50 + "px")
                            .style("top", d3.event.pageY - 120 + "px")
                            .style("display", "inline-block")
                            .html("<p>" + (d.titulo) + "<br>" + (d.valor) + "</p>" + ((d.valor * 100) / total_4).toFixed(2) + "%");
                    })
                    .on("mouseout", function (d) { self_4.tooltip.style("display", "none"); })
                    .transition()
                    .duration(800)
                    .attr('width', function (d) { return xScale(d.valor); });

                bar.append("rect")
                    .attr('x', function (d) { return xScale(0); })
                    .attr('y', function (d) { return yScale(d.titulo); })
                    .attr('height', yScale.bandwidth())
                    .attr('fill', function (d, i) { return _this.colors(i); })
                    .attr('width', yScale.bandwidth() / 2)
                    .attr('class', 'lateral')
                    .attr("transform", "translate (" + (- yScale.bandwidth() / 2) + "," + (- yScale.bandwidth() / 2) + ") skewY(" + 45 + ")")
                    .on("mousemove", function (d) {
                        self_4.tooltip
                            .style("left", d3.event.pageX - 50 + "px")
                            .style("top", d3.event.pageY - 120 + "px")
                            .style("display", "inline-block")
                            .html("<p>" + (d.titulo) + "<br>" + (d.valor) + "</p>" + ((d.valor * 100) / total_4).toFixed(2) + "%");
                    })
                    .on("mouseout", function (d) { self_4.tooltip.style("display", "none") });

                bar.append("rect")
                    .attr('x', function (d) { return -yScale(d.titulo); })
                    .attr('y', function (d) { return yScale(d.titulo); })
                    .attr('height', yScale.bandwidth() / 2)
                    .attr('fill', function (d, i) { return _this.colors(i); })
                    .attr('width', xScale(0))
                    .attr('class', 'top')
                    .attr("transform", function (d) {
                        return "translate (" + (- yScale.bandwidth() / 2) + ","
                            + (- yScale.bandwidth() / 2) + ") skewX(" + 45 + ")"
                    })
                    .on("mousemove", function (d) {
                        self_4.tooltip
                            .style("left", d3.event.pageX - 50 + "px")
                            .style("top", d3.event.pageY - 120 + "px")
                            .style("display", "inline-block")
                            .html("<p>" + (d.titulo) + "<br>" + (d.valor) + "</p>" + ((d.valor * 100) / total_4).toFixed(2) + "%");
                    })
                    .on("mouseout", function (d) { self_4.tooltip.style("display", "none"); })
                    .transition()
                    .duration(800)
                    .attr('width', function (d) { return xScale(d.valor); });

                // eje y

                svg.append('g')
                    .attr('class', 'axis axis-y')
                    .attr('transform', "translate(" + (pxML + (-yScale.bandwidth() / 4)) + "," + ((pxMT + 15) + (-yScale.bandwidth() / 3)) + ")")
                    .call(d3.axisLeft(yScale))
                    .selectAll("text")
                    .on("mousemove", function () {
                        d3.select(this).style("font-size", "13px");
                    })
                    .on("mouseout", function (d) {
                        d3.select(this).style("font-size", "11px");
                    });

                //agregar los porcentajes de cada barra
                chart.selectAll('.porcentaje')
                    .data(data)
                    .enter()
                    .append('text')
                    .attr('class', 'porcentaje etiqueta')
                    .attr('id',(d)=>'cod'+d.codigo)
                    .attr('x', function (d) { return 0; })
                    .attr('y', function (d) { return yScale(d.titulo) + yScale.bandwidth() / 2; })
                    .text(function (d) { return ((d.valor * 100) / total_4).toFixed(2) + '%'; })
                    .transition().duration(1000)
                    .attr('x', function (d, i) { return xScale(d.valor) / 2; })
                    .attr('style', function (d, i) {
                        var size = yScale.bandwidth() / 4;
                        return 'font-size  : ' + size + 'px;';
                    });
            }
            else {
                var xScale = d3.scaleBand().padding(0.1).rangeRound([0, width]).domain(data.map(function (d) { return d.titulo; }));
                var yScale = d3.scaleLinear().rangeRound([height_chart_3, 0]).domain([0, d3.max(data, function (d) { return Number(d.valor); })]);
                // eje y
                svg.append('g')
                    .attr('class', 'axis axis-y grid')
                    .attr('transform', "translate(" + pxML + "," + (pxMT + 15) + ")")
                    .property("id", "")
                    .call(d3.axisLeft(yScale)
                        .tickFormat(null)
                        .tickSize(-width))
                    .selectAll("g")
                    .on("mousemove", function () {
                        d3.select(this).select("line").style("stroke-opacity", ".8");
                        d3.select(this).select("text").style("font-size", "20px");
                    })
                    .on("mouseout", function (d) {
                        d3.select(this).select("line").style("stroke-opacity", ".14");
                        d3.select(this).select("text").style("font-size", "11.5px");
                    });

                // eje x
                svg.append('g')
                    .attr('class', 'axis axis-x')
                    .attr('transform', "translate(" + pxML + ", " + ((pxMT + 15) + height_chart_3) + ")")
                    .call(d3.axisBottom(xScale))
                    .selectAll("text")
                    .style("text-anchor", "end")
                    .attr("dx", "-.8em")
                    .attr("dy", ".15em")
                    .attr("transform", "rotate(-65)")
                    .on("mousemove", function () {
                        d3.select(this).style("font-size", "13px");
                    })
                    .on("mouseout", function (d) {
                        d3.select(this).style("font-size", "11px");
                    });

                // Area de la grafica
                var chart = svg.append('g')
                    .property('id', 'chart-barra-' + id_grafica)
                    .attr('class', 'shadow')
                    .attr('class', 'bars')
                    .attr('transform', "translate(" + pxML + ", " + (pxMT + 15) + ")");

                var bars = chart.selectAll('.bar')
                    .data(data)
                    .enter()
                    .append("g")
                    .attr('class', 'bar')
                    .attr('opacity', .8)
                    .property('id', function (d, i) { return 'cod' + d.codigo })

                bars.append("rect")
                    .attr('x', function (d) { return xScale(d.titulo); })
                    .attr('y', function (d) { return yScale(d.valor); })
                    .attr('width', xScale.bandwidth())
                    .attr('height', function (d) { return height_chart_3 - yScale(d.valor); })
                    .attr('fill', function (d, i) { return _this.colors(i); })
                    .attr('class', 'natural')
                    .on("mousemove", function (d) {
                        self_4.tooltip
                            .style("left", d3.event.pageX - 50 + "px")
                            .style("top", d3.event.pageY - 120 + "px")
                            .style("display", "inline-block")
                            .html("<p>" + (d.titulo) + "<br>" + (d.valor) + "</p>" + ((d.valor * 100) / total_4).toFixed(2) + "%");
                    })
                    .on("mouseout", function (d) { self_4.tooltip.style("display", "none"); });

                bars.append("rect")
                    .attr('x', function (d) { return xScale(d.titulo) + yScale(d.valor); })
                    .attr('y', function (d) { return yScale(d.valor); })
                    .attr('width', xScale.bandwidth())
                    .attr('height', function (d) { return 10; })
                    .attr('fill', function (d, i) { return _this.colors(i); })
                    .attr('class', 'top')
                    .attr("transform", function (d) {
                        return "translate (" + 10
                            + "," + (-10) + ") skewX(-" + 45 + ")";
                    })
                    .on("mousemove", function (d) {
                        self_4.tooltip
                            .style("left", d3.event.pageX - 50 + "px")
                            .style("top", d3.event.pageY - 120 + "px")
                            .style("display", "inline-block")
                            .html("<p>" + (d.titulo) + "<br>" + (d.valor) + "</p>" + ((d.valor * 100) / total_4).toFixed(2) + "%");
                    })
                    .on("mouseout", function (d) { self_4.tooltip.style("display", "none"); });


                bars.append("rect")
                    .attr('x', function (d) { return xScale(d.titulo); })
                    .attr('y', function (d) { return yScale(d.valor) + ((height_chart_3 - yScale(d.valor)) / 2); })
                    .attr('width', function (d) { return 10 })
                    .attr('height', function (d) { return height_chart_3 - yScale(d.valor); })
                    .attr('fill', function (d, i) { return _this.colors(i); })
                    .attr('class', 'lateral')
                    .attr("transform", function (d) {
                        return "translate (" + xScale.bandwidth() + "," + ((-(height_chart_3 - yScale(d.valor)) / 2) + (xScale(d.titulo))) + ") skewY(-" + 45 + ")";
                    })
                    .on("mousemove", function (d) {
                        self_4.tooltip
                            .style("left", d3.event.pageX - 50 + "px")
                            .style("top", d3.event.pageY - 120 + "px")
                            .style("display", "inline-block")
                            .html("<p>" + (d.titulo) + "<br>" + (d.valor) + "</p>" + ((d.valor * 100) / total_4).toFixed(2) + "%");
                    })
                    .on("mouseout", function (d) { self_4.tooltip.style("display", "none"); });


                //agregar los porcentajes de cada barra
                chart.selectAll('.porcentaje')
                    .data(data)
                    .enter()
                    .append('text')
                    .attr('class', 'porcentaje etiqueta')
                    .attr('id',(d)=>'cod'+d.codigo)
                    .attr('x', function (d) { return xScale(d.titulo) + (xScale.bandwidth() / 6); })
                    .attr('y', 0)
                    .text(function (d) { return ((d.valor * 100) / total_4).toFixed(2) + '%'; })
                    .transition().duration(1000)
                    .attr('y', function (d) { return yScale(d.valor) - 5; })
                    .attr('style', function (d, i) {
                        var size = xScale.bandwidth() / 5;
                        if (size > 30) size = 30;
                        return 'font-size  : ' + size + 'px;';
                    });
            }
            if ((_leyenda && posicion_leyenda == 'right') && data.length > 1) {

                var leyenda = svg.selectAll(".leyenda-bar")
                    .data(data)
                    .enter().append("g")
                    .attr("class", "leyenda-bar")
                    .attr("transform", function (d, i) { return "translate(0," + i * 20 + ")"; })
                    .style("font", "10px sans-serif");
                leyenda.append("rect")
                    .attr("class", "bar")
                    .attr("width", 18)
                    .attr("height", 18)
                    .attr("fill", function (d, i) { return _this.colors(i); })
                    .attr("x", 0)
                    .attr("y", 0)
                    .property('id', function (d, i) { return 'cod' + d.codigo })
                    .on("mousemove", function (d) {
                        self_4.tooltip
                            .style("left", d3.event.pageX - 50 + "px")
                            .style("top", d3.event.pageY - 70 + "px")
                            .style("display", "inline-block")
                            .html("<p>" + (d.titulo) + "<br>" + d.valor + " : " + ((d.valor * 100) / total_4).toFixed(2) + '%</p>');
                    })
                    .on("mouseout", function (d) { self_4.tooltip.style("display", "none"); })
                    .transition()
                    .ease(d3.easeBackOut)
                    .duration(1000)
                    .attr("y", pxMT)
                    .attr("x", width + pxML + 10);

                leyenda.append("text")
                    .attr("class", "text-leyenda")
                    .attr("dy", ".35em")
                    .attr("text-anchor", "start")
                    .attr("x", 0)
                    .attr("y", 0)
                    .transition()
                    .ease(d3.easeBackOut)
                    .duration(1000)
                    .attr("x", width + pxML + 40)
                    .attr("y", pxMT + 10)
                    .text(function (d) { return d.titulo + ' (' + d.valor + ')'; });
            }
        }
        if (typeof callback == 'function') callback();
    };
    GraficasD3.prototype.actualizarGraficaBarra = function (datos, id_contenedor, id_grafica, titulo, _leyenda) {
        var _this = this;
        var div_grafica = d3.select('#' + id_contenedor).select('#' + id_grafica);
        var pxMR = this.margin.right;
        var pxMB = this.margin.bottom;
        var pxML = this.margin.left;
        var pxMT = this.margin.top;
        this.colors = d3.scaleOrdinal(this.colores);

        var total = 0;
        datos.forEach(function (element) { total += Number(element.valor); });
        var cant = d3.max(datos, (d) => Number(d.valor.length));
        if (cant > 1) {
            if (div_grafica.attr('horizontal') == 'true')
                if (cant < 6) pxMB = (cant * 20) + this.margin.bottom;
                else pxMB = (cant * 16) + this.margin.bottom;
            else pxML = cant * 15;
        }
        var leylength = d3.max(datos, function (d) { return Number(d.titulo.length); });
        if (leylength > 1) {
            if (div_grafica.attr('horizontal') == 'true') {
                if (leylength > 25) pxML = (leylength * 8);
                else if (leylength > 9) pxML = (leylength * 10);
                else pxML = (leylength * 12);
            }
            else {
                if (leylength > 25) {
                    pxML = (leylength * 2);
                    pxMB = (leylength * 7) + this.margin.bottom;
                } else if (leylength > 9) pxMB = (leylength * 9) + this.margin.bottom;
                else pxMB = (leylength * 11) + this.margin.bottom;
            }
            if (_leyenda && datos.length > 1) {
                if (leylength > 25) pxMR = (leylength + (cant + 2)) * 8;
                else if (leylength > 20) pxMR = (leylength + (cant + 2)) * 10;
                else pxMR = (leylength + (cant + 2)) * 12;
            }
        }

        var nodo_contenedor_grafica = d3.select('#' + id_contenedor).select('#' + id_grafica).node();
        var svg = d3.select('#' + id_contenedor).select('#' + id_grafica).select('#svg-barra-' + id_grafica);
        var chart = svg.select('#chart-barra-' + id_grafica);
        var xAxis = svg.select('.axis-x');
        var yAxis = svg.select('.axis-y');
        var widthG = svg.attr('width');

        div_grafica.select('#total-barra-' + id_grafica).transition()
            .attr('transform', "translate(" + (parseInt(window.getComputedStyle(nodo_contenedor_grafica).width) - (cant * 30)) / 2 + ", " + (svg.attr('height') - (this.margin.bottom / 2)) + ")")
            .text("Total: " + total);

        if (titulo) d3.select("#titulo-barra-" + id_grafica).html(titulo + "<br>");

        svg.selectAll('.leyenda-bar').remove();

        if (((div_grafica.attr('leyenda') == 'true') || _leyenda) && (datos.length > 1) && (div_grafica.attr('posicion_leyenda') == 'top')) {
            var xm = this.margin.left, ym = pxMT;
            var leyenda = svg.selectAll(".leyenda-bar")
                .data(datos)
                .enter().append("g")
                .attr("class", "leyenda-bar")
                .attr("transform", function (d, i) {
                    if (i != 0) xm += pxMR;
                    if (xm > (widthG / 2)) { ym += 20; xm = _this.margin.left; };
                    if (ym > pxMT) pxMT = ym + 15;
                    return "translate(" + xm + "," + ym + ")";
                })
                .style("font", "10px sans-serif");
            leyenda.append("rect")
                .attr("class", "bar")
                .attr("width", 18)
                .attr("height", 18)
                .attr("fill", function (d, i) { return _this.colors(i); })
                .attr("x", 0)
                .property('id', function (d, i) { return 'cod' + d.codigo })
                .on("mousemove", function (d) {
                    self.tooltip
                        .style("left", d3.event.pageX - 50 + "px")
                        .style("top", d3.event.pageY - 70 + "px")
                        .style("display", "inline-block")
                        .html("<p>" + (d.titulo) + "<br>" + d.valor + " : " + ((d.valor * 100) / total).toFixed(2) + '%</p>');
                })
                .on("mouseout", function (d) { self.tooltip.style("display", "none"); })
                .transition()
                .ease(d3.easeBackOut)
                .duration(1000)
                .attr("x", 10);
            leyenda.append("text")
                .attr("class", "text-leyenda")
                .attr("dy", ".35em")
                .attr("text-anchor", "start")
                .attr("x", 0)
                .attr("y", 0)
                .transition()
                .ease(d3.easeBackOut)
                .duration(1000)
                .attr("x", 40)
                .attr("y", 10)
                .text(function (d) { return d.titulo + ' (' + d.valor + ')'; });

            pxMR = this.margin.right;
        }

        var heightChart = svg.attr('height') - (pxMT + 15) - pxMB;
        var widthChart = widthG - pxML - pxMR;
        var self = this;
        // actualizar escalas y ejes
        if (div_grafica.attr('horizontal') == 'true') {
            var yScale = d3.scaleBand().padding(0.1).rangeRound([heightChart, 0]).domain(datos.map(function (d) { return d.titulo; }));
            var xScale = d3.scaleLinear().rangeRound([0, widthChart]).domain([0, d3.max(datos, function (d) { return Number(d.valor); })]);

            xAxis.transition().duration(300)
                .attr('transform', "translate(" + pxML + ", " + (pxMT + heightChart) + ")")
                .call(d3.axisBottom(xScale)
                    .tickFormat(null)
                    .tickSize(-heightChart))
                .selectAll("text")
                .style("text-anchor", "end")
                .attr("dx", "-.8em")
                .attr("dy", ".15em")
                .attr("transform", "rotate(-65)");

            xAxis.selectAll("g")
                .on("mousemove", function () {
                    d3.select(this).select("line").style("stroke-opacity", ".8");
                    d3.select(this).select("text").style("font-size", "20px");
                })
                .on("mouseout", function (d) {
                    d3.select(this).select("line").style("stroke-opacity", ".14");
                    d3.select(this).select("text").style("font-size", "11.5px");
                });



            svg.select('.bars').transition().duration(200)
                .attr('transform', "translate(" + pxML + ", " + pxMT + ")");

            var update = chart.selectAll('.bar')
                .data(datos);
            // borrar barras y valores existentes sobrantes
            update.exit().remove();
            // actualizar barras existentes
            chart.selectAll('.bar').select("rect.natural")
                .attr('width', function (d) { return xScale(0); })
                .attr('height', yScale.bandwidth())
                .attr('y', function (d) { return yScale(d.titulo); })
                .attr('fill', function (d, i) { return self.colors(i); })
                .on("mousemove", function (d) {
                    self.tooltip
                        .style("left", d3.event.pageX - 50 + "px")
                        .style("top", d3.event.pageY - 120 + "px")
                        .style("display", "inline-block")
                        .html("<p>" + (d.titulo) + "<br>" + (d.valor) + "</p>" + ((d.valor * 100) / total).toFixed(2) + "%");
                })
                .on("mouseout", function (d) { self.tooltip.style("display", "none"); })
                .transition().duration(800)
                .attr('x', function (d) { return xScale(0); })
                .attr('width', function (d) { return xScale(d.valor); });

            chart.selectAll('.bar').select("rect.lateral")
                .attr('x', function (d) { return xScale(0); })
                .attr('y', function (d) { return yScale(d.titulo); })
                .attr('width', yScale.bandwidth() / 2)
                .attr('height', yScale.bandwidth())
                .attr('fill', function (d, i) { return self.colors(i); })
                .attr("transform", "translate (" + (- yScale.bandwidth() / 2) + "," + (- yScale.bandwidth() / 2) + ") skewY(" + 45 + ")")
                .on("mousemove", function (d) {
                    self.tooltip
                        .style("left", d3.event.pageX - 50 + "px")
                        .style("top", d3.event.pageY - 120 + "px")
                        .style("display", "inline-block")
                        .html("<p>" + (d.titulo) + "<br>" + (d.valor) + "</p>" + ((d.valor * 100) / total).toFixed(2) + "%");
                })
                .on("mouseout", function (d) { self.tooltip.style("display", "none"); });


            chart.selectAll('.bar').select("rect.top")
                .attr('width', 0)
                .attr('x', function (d) { return -yScale(d.titulo); })
                .attr('y', function (d) { return yScale(d.titulo); })
                .attr('fill', function (d, i) { return _this.colors(i); })
                .attr('height', yScale.bandwidth() / 2)
                .attr("transform", function (d) {
                    return "translate (" + (- yScale.bandwidth() / 2) + ","
                        + (- yScale.bandwidth() / 2) + ") skewX(" + 45 + ")"
                })
                .on("mousemove", function (d) {
                    self.tooltip
                        .style("left", d3.event.pageX - 50 + "px")
                        .style("top", d3.event.pageY - 120 + "px")
                        .style("display", "inline-block")
                        .html("<p>" + (d.titulo) + "<br>" + (d.valor) + "</p>" + ((d.valor * 100) / total).toFixed(2) + "%");
                })
                .on("mouseout", function (d) { self.tooltip.style("display", "none"); })
                .transition().duration(800)
                .attr('width', function (d) { return xScale(d.valor); });

            yAxis.transition().duration(300).attr('transform', "translate(" + (pxML + (-yScale.bandwidth() / 4)) + "," + (pxMT + (-yScale.bandwidth() / 3)) + ")")
                .call(d3.axisLeft(yScale))
            yAxis.selectAll("text")
                .on("mousemove", function () {
                    d3.select(this).style("font-size", "13px");
                })
                .on("mouseout", function (d) {
                    d3.select(this).style("font-size", "11px");
                });

            // agregar nuevas barras y valores de la leyenda

            var newbar = update
                .enter()
                .insert('g')
                .attr('class', 'bar')
                .property('id', function (d, i) { return 'cod' + d.codigo });


            newbar.append("rect")
                .attr('x', function (d) { return xScale(0); })
                .attr('y', function (d) { return yScale(d.titulo); })
                .attr('class', 'natural')
                .attr('width', 0)
                .attr('height', yScale.bandwidth())
                .attr('fill', function (d, i) { return _this.colors(i); })
                .on("mousemove", function (d) {
                    self.tooltip
                        .style("left", d3.event.pageX - 50 + "px")
                        .style("top", d3.event.pageY - 120 + "px")
                        .style("display", "inline-block")
                        .html("<p>" + (d.titulo) + "<br>" + (d.valor) + "</p>" + ((d.valor * 100) / total).toFixed(2) + "%");
                })
                .on("mouseout", function (d) { self.tooltip.style("display", "none"); })
                .transition()
                .duration(800)
                .attr('width', function (d) { return xScale(d.valor); });


            newbar.append("rect")
                .attr('x', function (d) { return xScale(0); })
                .attr('y', function (d) { return yScale(d.titulo); })
                .attr('height', yScale.bandwidth())
                .attr('fill', function (d, i) { return self.colors(i); })
                .attr('width', yScale.bandwidth() / 2)
                .attr('class', 'lateral')
                .attr("transform", "translate (" + (- yScale.bandwidth() / 2) + "," + (- yScale.bandwidth() / 2) + ") skewY(" + 45 + ")")
                .property('id', function (d, i) { return 'cod' + d.codigo })
                .on("mousemove", function (d) {
                    self.tooltip
                        .style("left", d3.event.pageX - 50 + "px")
                        .style("top", d3.event.pageY - 120 + "px")
                        .style("display", "inline-block")
                        .html("<p>" + (d.titulo) + "<br>" + (d.valor) + "</p>" + ((d.valor * 100) / total).toFixed(2) + "%");
                })
                .on("mouseout", function (d) { self.tooltip.style("display", "none") });

            newbar.append("rect")
                .attr('x', function (d) { return -yScale(d.titulo); })
                .attr('y', function (d) { return yScale(d.titulo); })
                .attr('height', yScale.bandwidth() / 2)
                .attr('fill', function (d, i) { return _this.colors(i); })
                .attr('width', xScale(0))
                .attr('class', 'top')
                .attr("transform", function (d) {
                    return "translate (" + (- yScale.bandwidth() / 2) + ","
                        + (- yScale.bandwidth() / 2) + ") skewX(" + 45 + ")"
                })
                .property('id', function (d, i) { return 'cod' + d.codigo })
                .on("mousemove", function (d) {
                    self.tooltip
                        .style("left", d3.event.pageX - 50 + "px")
                        .style("top", d3.event.pageY - 120 + "px")
                        .style("display", "inline-block")
                        .html("<p>" + (d.titulo) + "<br>" + (d.valor) + "</p>" + ((d.valor * 100) / total).toFixed(2) + "%");
                })
                .on("mouseout", function (d) { self.tooltip.style("display", "none"); })
                .transition()
                .duration(800)
                .attr('width', function (d) { return xScale(d.valor); });


            svg.selectAll('.porcentaje').remove();
            //agregar los porcentajes de cada barra
            chart.selectAll('.porcentaje')
                .data(datos)
                .enter()
                .append('text')
                .attr('class', 'porcentaje etiqueta')
                .attr('id',(d)=>'cod'+d.codigo)
                .attr('x', function (d) { return 0; })
                .attr('y', function (d) { return yScale(d.titulo) + yScale.bandwidth() / 2; })
                .text(function (d) { return ((d.valor * 100) / total).toFixed(2) + '%'; })
                .transition().duration(1000)
                .attr('x', function (d, i) { return xScale(d.valor) / 2; })
                .attr('style', function (d, i) {
                    var size = yScale.bandwidth() / 4;
                    return 'font-size  : ' + size + 'px;';
                });
        }
        else {
            var xScale = d3.scaleBand().padding(0.1).rangeRound([0, widthChart]).domain(datos.map(function (d) { return d.titulo; }));
            var yScale = d3.scaleLinear().rangeRound([heightChart, 0]).domain([0, d3.max(datos, function (d) { return Number(d.valor); })]);

            yAxis.transition().duration(300)
                .attr('transform', "translate(" + pxML + "," + (pxMT + 15) + ")")
                .call(d3.axisLeft(yScale)
                    .tickFormat(null)
                    .tickSize(-widthChart));

            yAxis.selectAll("g")
                .on("mousemove", function () {
                    d3.select(this).select("line").style("stroke-opacity", ".8");
                    d3.select(this).select("text").style("font-size", "20px");
                })
                .on("mouseout", function (d) {
                    d3.select(this).select("line").style("stroke-opacity", ".14");
                    d3.select(this).select("text").style("font-size", "11.5px");
                });

            svg.select('.bars').transition().duration(200)
                .attr('transform', "translate(" + pxML + "," + (pxMT + 15) + ")");

            xAxis.transition().duration(300)
                .attr('transform', "translate(" + pxML + ", " + ((pxMT + 15) + heightChart) + ")")
                .call(d3.axisBottom(xScale))
                .selectAll("text")
                .style("text-anchor", "end")
                .attr("dx", "-.8em")
                .attr("dy", ".15em")
                .attr("transform", "rotate(-65)");

            xAxis.selectAll("text")
                .on("mousemove", function () {
                    d3.select(this).style("font-size", "13px");
                })
                .on("mouseout", function (d) {
                    d3.select(this).style("font-size", "11px");
                });


            var update = chart.selectAll('.bar')
                .data(datos);
            // borrar barras y valores existentes sobrantes
            update.exit().remove();
            // actualizar barras existentes


            chart.selectAll('.bar').select("rect.natural")
                .attr('x', function (d) { return xScale(d.titulo); })
                .attr('y', function (d) { return yScale(d.valor); })
                .attr('width', xScale.bandwidth())
                .attr('height', function (d) { return heightChart - yScale(d.valor); })
                .attr('fill', function (d, i) { return _this.colors(i); })
                .on("mousemove", function (d) {
                    self.tooltip
                        .style("left", d3.event.pageX - 50 + "px")
                        .style("top", d3.event.pageY - 120 + "px")
                        .style("display", "inline-block")
                        .html("<p>" + (d.titulo) + "<br>" + (d.valor) + "</p>" + ((d.valor * 100) / total).toFixed(2) + "%");
                })
                .on("mouseout", function (d) { self.tooltip.style("display", "none"); })


            chart.selectAll('.bar').select("rect.top")
                .attr('x', function (d) { return xScale(d.titulo) + yScale(d.valor); })
                .attr('y', function (d) { return yScale(d.valor); })
                .attr('width', xScale.bandwidth())
                .attr('height', function (d) { return 10; })
                .attr('fill', function (d, i) { return _this.colors(i); })
                .attr('class', 'top')
                .attr("transform", function (d) {
                    return "translate (" + 10
                        + "," + (-10) + ") skewX(-" + 45 + ")";
                })
                .on("mousemove", function (d) {
                    self.tooltip
                        .style("left", d3.event.pageX - 50 + "px")
                        .style("top", d3.event.pageY - 120 + "px")
                        .style("display", "inline-block")
                        .html("<p>" + (d.titulo) + "<br>" + (d.valor) + "</p>" + ((d.valor * 100) / total).toFixed(2) + "%");
                })
                .on("mouseout", function (d) { self.tooltip.style("display", "none"); });

            chart.selectAll('.bar').select("rect.lateral")
                .attr('x', function (d) { return xScale(d.titulo); })
                .attr('y', function (d) { return yScale(d.valor) + ((heightChart - yScale(d.valor)) / 2); })
                .attr('width', function (d) { return 10 })
                .attr('height', function (d) { return heightChart - yScale(d.valor); })
                .attr('fill', function (d, i) { return _this.colors(i); })
                .attr("transform", function (d) { return "translate (" + xScale.bandwidth() + "," + ((-(heightChart - yScale(d.valor)) / 2) + (xScale(d.titulo))) + ") skewY(-" + 45 + ")"; })
                .on("mousemove", function (d) {
                    self.tooltip
                        .style("left", d3.event.pageX - 50 + "px")
                        .style("top", d3.event.pageY - 120 + "px")
                        .style("display", "inline-block")
                        .html("<p>" + (d.titulo) + "<br>" + (d.valor) + "</p>" + ((d.valor * 100) / total).toFixed(2) + "%");
                })
                .on("mouseout", function (d) { self.tooltip.style("display", "none"); });

            var newbar = update
                .enter()
                .insert('g')
                .attr('class', 'bar')
                .property('id', function (d, i) { return 'cod' + d.codigo });

            // agregar nuevas barras y valores de la leyenda
            newbar
                .append('rect')
                .attr('x', function (d) { return xScale(d.titulo); })
                .attr('width', xScale.bandwidth())
                .attr('y', function (d) { return yScale(d.valor); })
                .attr('height', function (d) { return heightChart - yScale(d.valor); })
                .attr('class', 'natural')
                .attr('fill', function (d, i) { return _this.colors(i); })
                .on("mousemove", function (d) {
                    self.tooltip
                        .style("left", d3.event.pageX - 50 + "px")
                        .style("top", d3.event.pageY - 120 + "px")
                        .style("display", "inline-block")
                        .html("<p>" + (d.titulo) + "<br>" + (d.valor) + "</p>" + ((d.valor * 100) / total).toFixed(2) + "%");
                })
                .on("mouseout", function (d) { self.tooltip.style("display", "none"); });


            newbar.append("rect")
                .attr('x', function (d) { return xScale(d.titulo) + yScale(d.valor); })
                .attr('y', function (d) { return yScale(d.valor); })
                .attr('width', xScale.bandwidth())
                .attr('height', function (d) { return 10; })
                .attr('fill', function (d, i) { return _this.colors(i); })
                .attr('class', 'top')
                .attr("transform", function (d) {
                    return "translate (" + 10
                        + "," + (-10) + ") skewX(-" + 45 + ")";
                })
                .on("mousemove", function (d) {
                    self.tooltip
                        .style("left", d3.event.pageX - 50 + "px")
                        .style("top", d3.event.pageY - 120 + "px")
                        .style("display", "inline-block")
                        .html("<p>" + (d.titulo) + "<br>" + (d.valor) + "</p>" + ((d.valor * 100) / total).toFixed(2) + "%");
                })
                .on("mouseout", function (d) { self.tooltip.style("display", "none"); });


            newbar.append("rect")
                .attr('x', function (d) { return xScale(d.titulo); })
                .attr('y', function (d) { return yScale(d.valor) + ((heightChart - yScale(d.valor)) / 2); })
                .attr('width', function (d) { return 10 })
                .attr('height', function (d) { return heightChart - yScale(d.valor); })
                .attr("transform", function (d) { return "translate (" + xScale.bandwidth() + "," + ((-(heightChart - yScale(d.valor)) / 2) + (xScale(d.titulo))) + ") skewY(-" + 45 + ")"; })
                .attr('fill', function (d, i) { return _this.colors(i); })
                .attr('class', 'lateral')
                .attr("transform", function (d) { return "translate (" + xScale.bandwidth() + "," + ((-(heightChart - yScale(d.valor)) / 2) + (xScale(d.titulo))) + ") skewY(-" + 45 + ")"; })
                .on("mousemove", function (d) {
                    self.tooltip
                        .style("left", d3.event.pageX - 50 + "px")
                        .style("top", d3.event.pageY - 120 + "px")
                        .style("display", "inline-block")
                        .html("<p>" + (d.titulo) + "<br>" + (d.valor) + "</p>" + ((d.valor * 100) / total).toFixed(2) + "%");
                })
                .on("mouseout", function (d) { self.tooltip.style("display", "none"); });


            svg.selectAll('.porcentaje').remove();
            //agregar los porcentajes de cada barra
            chart.selectAll('.porcentaje')
                .data(datos)
                .enter()
                .append('text')
                .attr('class', 'porcentaje etiqueta')
                .attr('id',(d)=>'cod'+d.codigo)
                .attr('x', function (d) { return xScale(d.titulo) + (xScale.bandwidth() / 6); })
                .attr('y', 0)
                .text(function (d) { return ((d.valor * 100) / total).toFixed(2) + '%'; })
                .attr('style', function (d, i) {
                    var size = xScale.bandwidth() / 5;
                    if (size > 30) size = 30;
                    return 'font-size  : ' + size + 'px;';
                })
                .transition().duration(1000)
                .attr('y', function (d) { return yScale(d.valor) - 5; });

        }

        if (((div_grafica.attr('leyenda') == 'true') || _leyenda) && (datos.length > 1) && (div_grafica.attr('posicion_leyenda') == 'right')) {
            var leyenda = svg.selectAll(".leyenda-bar")
                .data(datos)
                .enter().append("g")
                .attr("class", "leyenda-bar")
                .attr("transform", function (d, i) { return "translate(0," + i * 20 + ")"; })
                .style("font", "10px sans-serif");
            leyenda.append("rect")
                .attr("class", "bar")
                .attr("width", 18)
                .attr("height", 18)
                .attr("fill", function (d, i) { return _this.colors(i); })
                .attr("x", 0)
                .attr("y", 0)
                .property('id', function (d, i) { return 'cod' + d.codigo })
                .on("mousemove", function (d) {
                    self.tooltip
                        .style("left", d3.event.pageX - 50 + "px")
                        .style("top", d3.event.pageY - 70 + "px")
                        .style("display", "inline-block")
                        .html("<p>" + (d.titulo) + "<br>" + d.valor + " : " + ((d.valor * 100) / total).toFixed(2) + '%</p>');
                })
                .on("mouseout", function (d) { self.tooltip.style("display", "none"); })
                .transition()
                .ease(d3.easeBackOut)
                .duration(1000)
                .attr("y", this.margin.top)
                .attr("x", widthChart + pxML + 10);
            leyenda.append("text")
                .attr("class", "text-leyenda")
                .attr("dy", ".35em")
                .attr("text-anchor", "start")
                .attr("x", 0)
                .attr("y", 0)
                .transition()
                .ease(d3.easeBackOut)
                .duration(1000)
                .attr("x", widthChart + pxML + 40)
                .attr("y", this.margin.top + 10)
                .text(function (d) { return d.titulo + ' (' + d.valor + ')'; });
        }
    };
    GraficasD3.prototype.crearGraficaBarraAgrupada = function (data, height, id_contenedor, id_grafica, _horizontal, _leyenda, column_bootstrap, titulo, callback) {
        if (d3.select('#' + id_contenedor).select('#' + id_grafica).node()) {
            this.actualizarGrafica(data, id_contenedor, id_grafica, height, 'barra-agrupada', titulo, _horizontal, _leyenda, column_bootstrap);
        }
        else {
            var pxMR = this.margin.right;
            var pxMB = this.margin.bottom;
            var pxML = this.margin.left;
            // bar colors
            this.colors = d3.scaleOrdinal(this.colores);
            _leyenda = _leyenda || false;
            _horizontal = _horizontal || false;
            if (_leyenda && (data.length > 1)) pxMR = (d3.max(data, function (d) { return Number(d.titulo2.length); }) * 10) + 5;

            var cant = d3.max(data, (d) => Number(d.valor.length));
            if (cant > 1) {
                if (_horizontal)
                    if (cant < 6) pxMB = (cant * 20) + this.margin.bottom;
                    else pxMB = (cant * 16) + this.margin.bottom;
                else pxML = cant * 15;
            }
            var tituloLength = d3.max(data, function (d) { return Number(d.titulo.length); });
            var leylength = d3.max(data, function (d) { return Number(d.titulo2.length); });
            if (tituloLength > 1) {
                if (_horizontal) {
                    if (tituloLength > 25) pxML = (tituloLength * 8);
                    else if (tituloLength > 9) pxML = (tituloLength * 10);
                    else pxML = (tituloLength * 12);
                }
                else {
                    if (tituloLength > 25) {
                        pxMB = (tituloLength * 7) + this.margin.bottom;
                        pxML = (leylength * 2);
                    } else if (tituloLength > 9) pxMB = (tituloLength * 9) + this.margin.bottom;
                    else pxMB = (tituloLength * 11) + this.margin.bottom;
                }
            }

            if (leylength > 1 && _leyenda) {
                if (leylength > 25) pxMR = (leylength + (cant + 2)) * 8;
                else if (leylength > 20) pxMR = (leylength + (cant + 2)) * 10;
                else pxMR = (leylength + (cant + 2)) * 12;
            }

            if (!column_bootstrap)
                column_bootstrap = 'col-md-12';
            var self_3 = this;
            var contenedor = d3.select('#' + id_contenedor)
                .append('div').classed(column_bootstrap, true)
                .property('id', id_grafica)
                .attr('type', 'barra-agrupada')
                .attr('leyenda', _leyenda)
                .attr('horizontal', _horizontal);
            var total_3 = 0;
            data.forEach(function (element) {
                total_3 += Number(element.valor);
            });

            var nodo_contenedor_grafica = d3.select('#' + id_contenedor).select('#' + id_grafica).node();
            var width = parseInt(window.getComputedStyle(nodo_contenedor_grafica).width) - pxML - pxMR;

            contenedor.append("label")
                .attr("transform", "translate(" + (width / 2) + " ," +
                    (this.margin.top / 3) + ")")
                .style("text-anchor", "middle")
                .property('id', 'titulo-barra-agrupada-' + id_grafica)
                .attr('class', 'titulo')
                .html(titulo + "<br>");

            var svg = contenedor.append('svg')
                .property('id', 'svg-barra-agrupada-' + id_grafica)
                .attr('width', parseInt(window.getComputedStyle(nodo_contenedor_grafica).width))
                .attr('height', height);
            var height_chart_2 = height - this.margin.top - pxMB;

            var keys = d3.nest().key(function (d) { return d.titulo2; }).entries(data);
            svg.append('text')
                .property('id', 'total-barra-agrupada-' + id_grafica)
                .attr('class', 'etiqueta total')
                .attr('transform', "translate(" + (parseInt(window.getComputedStyle(nodo_contenedor_grafica).width) - (cant * 30)) / 2 + ", " + (height - (this.margin.bottom / 2)) + ")")
                .text('Total: ' + total_3);


            /*
                        contenedor.append("label")
                            .style("text-anchor", "middle")
                            .property('id', 'total-barra-agrupada-' + id_grafica)
                            .attr('class', 'total')
                            .html(total_3);
            
     
            contenedor.append("button")
                .style("text-anchor", "middle")
                .property('id', 'exportar-' + id_grafica)
                .attr('target', "_blank")
                .html('Exportar').on('click', function () {
                    exportarGrafica('svg-barra-agrupada' + id_grafica);
                });
                */
            if (_horizontal) {
                var yScale0_1 = d3.scaleBand().padding(0.05).rangeRound([0, height_chart_2]).domain(data.map(function (d) { return d.titulo; }));
                var yScale1_1 = d3.scaleBand().padding(0.05).domain(data.map(function (d) { return d.titulo2; })).rangeRound([0, yScale0_1.bandwidth()]);
                var xScale_2 = d3.scaleLinear().rangeRound([0, width]).domain([0, d3.max(data, function (d) { return Number(d.valor); })]);
                // eje y
                svg.append('g')
                    .attr('class', 'axis axis-y ')
                    .attr('transform', "translate(" + pxML + "," + this.margin.top + ")")
                    .call(d3.axisLeft(yScale0_1))
                    .selectAll("text")
                    .on("mousemove", function () {
                        d3.select(this).style("font-size", "13px");
                    })
                    .on("mouseout", function (d) {
                        d3.select(this).style("font-size", "11px");
                    });;
                // eje x
                svg.append('g')
                    .attr('class', 'axis axis-x grid')
                    .attr('transform', "translate(" + pxML + ", " + (this.margin.top + height_chart_2) + ")")
                    .call(d3.axisBottom(xScale_2)
                        .tickFormat(null)
                        .tickSize(-height_chart_2))
                    .selectAll("g")
                    .on("mousemove", function () {
                        d3.select(this).select("line").style("stroke-opacity", ".8");
                        d3.select(this).select("text").style("font-size", "20px");
                    })
                    .on("mouseout", function (d) {
                        d3.select(this).select("line").style("stroke-opacity", ".14");
                        d3.select(this).select("text").style("font-size", "11.5px");
                    })
                    .selectAll("text")
                    .style("text-anchor", "end")
                    .attr("dx", "-.8em")
                    .attr("dy", ".15em")
                    .attr("transform", "rotate(-65)");

                // Area de la grafica
                var chart = svg.append('g')
                    .property('id', 'chart-barra-agrupada-' + id_grafica)
                    .attr('class', 'shadow')
                    .attr('class', 'bars')
                    .attr('transform', "translate(" + pxML + ", " + this.margin.top + ")");

                var colores_barras = d3.scaleOrdinal().domain(data.map(function (d) { return d.titulo2; })).range(this.colors.range());
                chart.selectAll('.bar')
                    .data(data)
                    .enter().append("g")
                    .attr("transform", function (d) { return "translate(0," + yScale0_1(d.titulo) + ")"; })
                    .append('rect')
                    .attr('class', 'bar')
                    .attr('rx', 5)
                    .attr('ry', 5)
                    .attr('x', function (d) { return xScale_2(0); })
                    .attr('y', function (d) { return yScale1_1(d.titulo2); })
                    .attr('width', 0)
                    .attr('height', yScale1_1.bandwidth())
                    .attr('fill', function (d) { return colores_barras(d.titulo2); })
                    .property('id', function (d, i) { return 'cod' + d.codigo; })
                    .on("mousemove", function (d, i) {
                        self_3.tooltip
                            .style("left", d3.event.pageX - 50 + "px")
                            .style("top", d3.event.pageY - 70 + "px")
                            .style("display", "inline-block")
                            .html("<p>" + (d.titulo) + "<br>" + (d.titulo2) + ' : ' + (d.valor) + "</p>");
                    })
                    .on("mouseout", function (d) { self_3.tooltip.style("display", "none"); })
                    .transition()
                    .duration(800)
                    .attr('width', function (d) { return xScale_2(d.valor); });
                chart.selectAll('.porcentaje')
                    .data(data)
                    .enter()
                    .append('text')
                    .attr('class', 'porcentaje etiqueta')
                    .property('id', function (d, i) { return 'porcentaje'; })
                    .attr('x', 0)
                    .attr('y', function (d) { return yScale0_1(d.titulo) + yScale1_1(d.titulo2) + yScale1_1.bandwidth() / 2; })
                    .text(function (d) { return ((d.valor * 100) / total_3).toFixed(2) + '%'; })
                    .transition().duration(1000)
                    .attr('x', function (d) { return xScale_2(d.valor) / 2; })
                    .attr('style', function (d, i) {
                        var size = yScale1_1.bandwidth() / 4;
                        return 'font-size  : ' + size + 'px;';
                    });
            }
            else {
                // crear escalas
                var xScale0_1 = d3.scaleBand().padding(0.02).rangeRound([0, width]).domain(data.map(function (d) { return d.titulo; }));
                var xScale1_1 = d3.scaleBand().padding(0.05).domain(data.map(function (d) { return d.titulo2; })).rangeRound([0, xScale0_1.bandwidth()]);
                var yScale_2 = d3.scaleLinear().rangeRound([height_chart_2, 0]).domain([0, d3.max(data, function (d) { return Number(d.valor); })]);
                // eje y
                svg.append('g')
                    .attr('class', 'axis axis-y grid')
                    .attr('transform', "translate(" + pxML + "," + this.margin.top + ")")
                    .call(d3.axisLeft(yScale_2)
                        .tickFormat(null)
                        .tickSize(-width))
                    .selectAll("text")
                    .on("mousemove", function () {
                        d3.select(this).select("line").style("stroke-opacity", ".8");
                        d3.select(this).select("text").style("font-size", "20px");
                    })
                    .on("mouseout", function (d) {
                        d3.select(this).select("line").style("stroke-opacity", ".14");
                        d3.select(this).select("text").style("font-size", "11.5px");
                    });
                // eje x
                svg.append('g')
                    .attr('class', 'axis axis-x')
                    .attr('transform', "translate(" + pxML + ", " + (this.margin.top + height_chart_2) + ")")
                    .call(d3.axisBottom(xScale0_1))
                    .selectAll("text")
                    .style("text-anchor", "end")
                    .attr("dx", "-.8em")
                    .attr("dy", ".15em")
                    .attr("transform", "rotate(-65)")
                    .on("mousemove", function () {
                        d3.select(this).style("font-size", "13px");
                    })
                    .on("mouseout", function (d) {
                        d3.select(this).style("font-size", "11px");
                    });
                // Area de la grafica
                var chart = svg.append('g')
                    .property('id', 'chart-barra-agrupada-' + id_grafica)
                    .attr('class', 'shadow')
                    .attr('class', 'bars')
                    .attr('transform', "translate(" + pxML + ", " + this.margin.top + ")");
                var colores_barras = d3.scaleOrdinal().domain(data.map(function (d) { return d.titulo2; })).range(this.colors.range());


                chart.selectAll('.bar')
                    .data(data)
                    .enter().append("g")
                    .attr("transform", function (d) { return "translate(" + xScale0_1(d.titulo) + ",0)"; })
                    .append('rect')
                    .attr('class', 'bar')
                    .attr('rx', 5)
                    .attr('ry', 5)
                    .attr('x', function (d) { return xScale1_1(d.titulo2); })
                    .attr('y', function (d) { return yScale_2(0); })
                    .attr('width', xScale1_1.bandwidth())
                    .attr('height', 0)
                    .attr('fill', function (d, i) { return colores_barras(d.titulo2); })
                    .property('id', function (d, i) { return 'cod' + d.codigo })
                    .on("mousemove", function (d) {
                        self_3.tooltip
                            .style("left", d3.event.pageX - 50 + "px")
                            .style("top", d3.event.pageY - 70 + "px")
                            .style("display", "inline-block")
                            .html("<p>" + (d.titulo) + "<br>" + (d.titulo2) + ' : ' + (d.valor) + "</p>");
                    })
                    .on("mouseout", function (d) { self_3.tooltip.style("display", "none"); })
                    .transition()
                    .duration(800)
                    .attr('y', function (d) { return yScale_2(d.valor); })
                    .attr('height', function (d) { return height_chart_2 - yScale_2(d.valor); });

                chart.selectAll('.porcentaje')
                    .data(data)
                    .enter()
                    .append('text')
                    .attr('class', 'porcentaje etiqueta')
                    .attr('id',(d)=>'cod'+d.codigo)
                    .attr('x', function (d) { return xScale0_1(d.titulo) + xScale1_1(d.titulo2); })
                    .attr('y', 0)
                    .text(function (d) { return ((d.valor * 100) / total_3).toFixed(2) + '%'; })
                    .transition().duration(1000)
                    .attr('y', function (d) { return yScale_2(d.valor) - 5; })
                    .attr('style', function (d, i) {
                        var size = xScale1_1.bandwidth() / 5;
                        if (size > 30) size = 30;
                        return 'font-size  : ' + size + 'px;';
                    });
            }
            if (_leyenda && (data.length > 1)) {
                var leyenda = svg.selectAll(".leyenda-bar")
                    .data(keys)
                    .enter().append("g")
                    .attr("class", "leyenda-bar")
                    .attr("transform", function (d, i) { return "translate(0," + i * 20 + ")"; })
                    .style("font", "10px sans-serif");
                leyenda.append("rect")
                    .attr("class", "bar")
                    .attr("width", 18)
                    .attr("height", 18)
                    .attr("fill", function (d, i) { return colores_barras(d.key); })
                    .attr("x", 0)
                    .attr("y", 0)
                    .property('id', function (d, i) { return 'cod' + d.values[0].codigo })
                    .on("mousemove", function (d) {
                        var data = 0;
                        for (var index = 0; index < d.values.length; index++) {
                            data += Number(d.values[index].valor);
                        }
                        self_3.tooltip
                            .style("left", d3.event.pageX - 50 + "px")
                            .style("top", d3.event.pageY - 70 + "px")
                            .style("display", "inline-block")
                            .html("<p>" + (d.key) + "<br>" + data + " : " + ((data * 100) / total_3).toFixed(2) + '%</p>');
                    })
                    .on("mouseout", function (d) { self_3.tooltip.style("display", "none"); })
                    .transition()
                    .ease(d3.easeBackOut)
                    .duration(1000)
                    .attr("y", this.margin.top)
                    .attr("x", width + pxML + 10);

                leyenda.append("text")
                    .attr("class", "text-leyenda")
                    .attr("dy", ".35em")
                    .attr("text-anchor", "start")
                    .attr("x", 0)
                    .attr("y", 0)
                    .transition()
                    .ease(d3.easeBackOut)
                    .duration(1000)
                    .attr("x", width + pxML + 40)
                    .attr("y", this.margin.top + 10)
                    .text(function (d) {
                        var data = 0;
                        for (var index = 0; index < d.values.length; index++) {
                            data += Number(d.values[index].valor);
                        }
                        return d.key + ' (' + data + ')';
                    });
            }
        }
        if (typeof callback == 'function') callback();
    };
    GraficasD3.prototype.actualizarGraficaBarraAgrupada = function (datos, id_contenedor, id_grafica, titulo, _leyenda) {
        var div_grafica = d3.select('#' + id_contenedor).select('#' + id_grafica);
        var pxMR = this.margin.right;
        var pxMB = this.margin.bottom;
        var pxML = this.margin.left;

        if (((div_grafica.attr('leyenda') == 'true') || _leyenda) && (datos.length > 1)) pxMR = (d3.max(datos, function (d) { return Number(d.titulo2.length); }) * 10) + 5;

        var cant = d3.max(datos, (d) => Number(d.valor.length));
        if (cant > 1) {
            if (div_grafica.attr('horizontal') == 'true')
                if (cant < 6) pxMB = (cant * 20) + this.margin.bottom;
                else pxMB = (cant * 16) + this.margin.bottom;
            else pxML = cant * 15;
        }
        var tituloLength = d3.max(datos, function (d) { return Number(d.titulo.length); });
        var leylength = d3.max(datos, function (d) { return Number(d.titulo2.length); });
        if (tituloLength > 1) {
            if (div_grafica.attr('horizontal') == 'true') {
                if (tituloLength > 25) pxML = (tituloLength * 8);
                else if (tituloLength > 9) pxML = (tituloLength * 10);
                else pxML = (tituloLength * 12);
            }
            else {
                if (tituloLength > 25) {
                    pxMB = (tituloLength * 7) + this.margin.bottom;
                    pxML = (leylength * 2);
                } else if (tituloLength > 9) pxMB = (tituloLength * 9) + this.margin.bottom;
                else pxMB = (tituloLength * 11);
            }
        }

        if (leylength > 1 && _leyenda) {
            if (leylength > 25) pxMR = (leylength + (cant + 2)) * 8;
            else if (leylength > 20) pxMR = (leylength + (cant + 2)) * 10;
            else pxMR = (leylength + (cant + 2)) * 12;
        }

        var nodo_contenedor_grafica = d3.select('#' + id_contenedor).select('#' + id_grafica).node();
        var svg = d3.select('#' + id_contenedor).select('#' + id_grafica).select('#svg-barra-agrupada-' + id_grafica);
        var chart = svg.select('#chart-barra-agrupada-' + id_grafica);
        var xAxis = svg.select('.axis-x');
        var yAxis = svg.select('.axis-y');
        var heightChart = svg.attr('height') - this.margin.top - pxMB;
        var widthChart = svg.attr('width') - pxML - pxMR;
        var total = 0;
        datos.forEach(function (element) { total += Number(element.valor); });
        if (titulo) d3.select("#titulo-barra-agrupada-" + id_grafica).html(titulo + "<br>");


        var keys = d3.nest().key(function (d) { return d.titulo2; }).entries(datos);
        var self = this;
        var colores_barras = d3.scaleOrdinal().domain(datos.map(function (d) { return d.titulo2; })).range(this.colors.range());
        svg.selectAll('.leyenda-bar').remove();
        svg.selectAll('.porcentaje').remove();
        div_grafica.select('#total-barra-agrupada-' + id_grafica).transition()
            .attr('transform', "translate(" + parseInt(window.getComputedStyle(nodo_contenedor_grafica).width) / 2 + ", " + (svg.attr('height') - (this.margin.bottom / 2)) + ")")
            .text("Total: " + total);
        //xAxis.remove();
        if (div_grafica.attr('horizontal') == 'true') {
            var yScale0_2 = d3.scaleBand().padding(0.05).rangeRound([0, heightChart]).domain(datos.map(function (d) { return d.titulo; }));
            var yScale1_2 = d3.scaleBand().padding(0.05).domain(datos.map(function (d) { return d.titulo2; })).rangeRound([0, yScale0_2.bandwidth()]);
            var xScale_3 = d3.scaleLinear().rangeRound([0, widthChart]).domain([0, d3.max(datos, function (d) { return Number(d.valor); })]);

            // eje x
            xAxis.transition().duration(300)
                .attr('transform', "translate(" + pxML + ", " + (this.margin.top + heightChart) + ")")
                .call(d3.axisBottom(xScale_3)
                    .tickFormat(null)
                    .tickSize(-heightChart))
                .selectAll("text")
                .style("text-anchor", "end")
                .attr("dx", "-.8em")
                .attr("dy", ".15em")
                .attr("transform", "rotate(-65)");

            xAxis.selectAll("text")
                .on("mousemove", function () {
                    d3.select(this).style("font-size", "13px");
                })
                .on("mouseout", function (d) {
                    d3.select(this).style("font-size", "11px");
                });

            xAxis.selectAll("g")
                .on("mousemove", function () {
                    d3.select(this).select("line").style("stroke-opacity", ".8");
                    d3.select(this).select("text").style("font-size", "20px");
                })
                .on("mouseout", function (d) {
                    d3.select(this).select("line").style("stroke-opacity", ".14");
                    d3.select(this).select("text").style("font-size", "11.5px");
                })

            yAxis.transition().duration(300)
                .call(d3.axisLeft(yScale0_2));

            var update = chart.selectAll('.bar')
                .data(datos);
            // borrar barras y valores existentes sobrantes
            update.exit().remove();
            // actualizar barras existentes y leyenda
            chart.transition().duration(10).attr('transform', "translate(" + pxML + ", " + this.margin.top + ")");
            chart
                .selectAll("g")
                .data(datos)
                .transition()
                .attr("transform", function (d) { return "translate(0," + yScale0_2(d.titulo) + ")"; });
            chart.selectAll('.bar')
                .attr('width', function (d) { return xScale_3(0); })
                .property('id', function (d, i) { return 'cod' + d.codigo })
                .on("mousemove", function (d) {
                    self.tooltip
                        .style("left", d3.event.pageX - 50 + "px")
                        .style("top", d3.event.pageY - 70 + "px")
                        .style("display", "inline-block")
                        .html("<p>" + (d.titulo) + "<br>" + (d.titulo2) + ' : ' + (d.valor) + "</p>");
                })
                .on("mouseout", function (d) { self.tooltip.style("display", "none"); })
                .transition()
                .duration(800)
                .attr('y', function (d) { return yScale1_2(d.titulo2); })
                .attr('x', function (d) { return xScale_3(0); })
                .attr('width', function (d) { return xScale_3(d.valor); })
                .attr('height', yScale1_2.bandwidth())
                .attr('fill', function (d, i) { return colores_barras(d.titulo2); });
            // agregar nuevas barras y valores de la leyenda
            update
                .enter().append("g")
                .attr("transform", function (d) { return "translate(0," + yScale0_2(d.titulo) + ")"; })
                .append('rect')
                .attr('class', 'bar')
                .attr('x', function (d) { return xScale_3(0); })
                .attr('y', function (d) { return yScale1_2(d.titulo2); })
                .attr('width', xScale_3(0))
                .attr('height', yScale1_2.bandwidth())
                .attr('fill', function (d, i) { return colores_barras(d.titulo2); })
                .property('id', function (d, i) { return 'cod' + d.codigo })
                .on("mousemove", function (d) {
                    self.tooltip
                        .style("left", d3.event.pageX - 50 + "px")
                        .style("top", d3.event.pageY - 70 + "px")
                        .style("display", "inline-block")
                        .html("<p>" + (d.titulo) + "<br>" + (d.titulo2) + ' : ' + (d.valor) + "</p>");
                })
                .on("mouseout", function (d) { self.tooltip.style("display", "none"); })
                .transition()
                .duration(800)
                .attr('width', function (d) { return xScale_3(d.valor); });

            chart.selectAll('.porcentaje').remove();
            chart.selectAll('.porcentaje')
                .data(datos)
                .enter()
                .append('text')
                .attr('class', 'porcentaje etiqueta')
                .attr('id',(d)=>'cod'+d.codigo)
                .attr('x', 0)
                .attr('y', function (d) { return yScale0_2(d.titulo) + yScale1_2(d.titulo2) + yScale1_2.bandwidth() / 2; })
                .text(function (d) { return ((d.valor * 100) / total).toFixed(2) + '%'; })
                .transition().duration(1000)
                .attr('x', function (d) { return xScale_3(d.valor) / 2; })
                .attr('style', function (d, i) {
                    var size = yScale1_2.bandwidth() / 4;
                    return 'font-size  : ' + size + 'px;';
                });
        }
        else {
            // actualizar escalas y ejes
            var xScale0_2 = d3.scaleBand().padding(0.02).rangeRound([0, widthChart]).domain(datos.map(function (d) { return d.titulo; }));
            var xScale1_2 = d3.scaleBand().padding(0.05).domain(datos.map(function (d) { return d.titulo2; })).rangeRound([0, xScale0_2.bandwidth()]);
            var yScale_3 = d3.scaleLinear().rangeRound([heightChart, 0]).domain([0, d3.max(datos, function (d) { return Number(d.valor); })]);
            xAxis.transition().duration(200)
                .attr('transform', "translate(" + pxML + ", " + (this.margin.top + heightChart) + ")")
                .call(d3.axisBottom(xScale0_2))
                .selectAll("text")
                .style("text-anchor", "end")
                .attr("dx", "-.8em")
                .attr("dy", ".15em")
                .attr("transform", "rotate(-65)")

            xAxis.selectAll("text")
                .on("mousemove", function () {
                    d3.select(this).style("font-size", "13px");
                })
                .on("mouseout", function (d) {
                    d3.select(this).style("font-size", "11px");
                });

            yAxis.transition().duration(200)
                .attr('transform', "translate(" + pxML + "," + this.margin.top + ")")
                .call(d3.axisLeft(yScale_3)
                    .tickFormat(null)
                    .tickSize(-widthChart));

            yAxis.selectAll("g")
                .on("mousemove", function () {
                    d3.select(this).select("line").style("stroke-opacity", ".8");
                    d3.select(this).select("text").style("font-size", "20px");
                })
                .on("mouseout", function (d) {
                    d3.select(this).select("line").style("stroke-opacity", ".14");
                    d3.select(this).select("text").style("font-size", "11.5px");
                })

            svg.select('bars')
                .attr('transform', "translate(" + pxML + ", " + this.margin.top + ")");

            var update = chart.selectAll('.bar')
                .data(datos);
            // borrar barras y valores existentes sobrantes
            update.exit().remove();
            // actualizar barras existentes y leyenda
            chart
                .selectAll("g")
                .data(datos)
                .transition()
                .attr("transform", function (d) { return "translate(" + xScale0_2(d.titulo) + ",0)"; });
            chart.selectAll('.bar')
                .property('id', function (d, i) { return 'cod' + d.codigo })
                .on("mousemove", function (d) {
                    self.tooltip
                        .style("left", d3.event.pageX - 50 + "px")
                        .style("top", d3.event.pageY - 70 + "px")
                        .style("display", "inline-block")
                        .html("<p>" + (d.titulo) + "<br>" + (d.titulo2) + ' : ' + (d.valor) + "</p>");
                })
                .on("mouseout", function (d) { self.tooltip.style("display", "none"); })
                .transition()
                .duration(800)
                .attr('y', function (d) { return yScale_3(d.valor); })
                .attr('x', function (d) { return xScale1_2(d.titulo2); })
                .attr('width', xScale1_2.bandwidth())
                .attr('height', function (d) { return heightChart - yScale_3(d.valor); })
                .attr('fill', function (d, i) { return colores_barras(d.titulo2); });
            // agregar nuevas barras y valores de la leyenda
            update
                .enter().append("g")
                .attr("transform", function (d) { return "translate(" + xScale0_2(d.titulo) + ",0)"; })
                .append('rect')
                .attr('class', 'bar')
                .attr('x', function (d) { return xScale1_2(d.titulo2); })
                .attr('y', function (d) { return yScale_3(0); })
                .attr('width', xScale1_2.bandwidth())
                .attr('height', 0)
                .attr('fill', function (d, i) { return colores_barras(d.titulo2); })
                .property('id', function (d, i) { return 'cod' + d.codigo })
                .on("mousemove", function (d) {
                    self.tooltip
                        .style("left", d3.event.pageX - 50 + "px")
                        .style("top", d3.event.pageY - 70 + "px")
                        .style("display", "inline-block")
                        .html("<p>" + (d.titulo) + "<br>" + (d.titulo2) + ' : ' + (d.valor) + "</p>");
                })
                .on("mouseout", function (d) { self.tooltip.style("display", "none"); })
                .transition()
                .duration(800)
                .attr('y', function (d) { return yScale_3(d.valor); })
                .attr('height', function (d) { return heightChart - yScale_3(d.valor); });
            chart.selectAll('.porcentaje').remove();
            chart.selectAll('.porcentaje')
                .data(datos)
                .enter()
                .append('text')
                .attr('class', 'porcentaje etiqueta')
                .attr('id',(d)=>'cod'+d.codigo)
                .attr('x', function (d) { return xScale0_2(d.titulo) + xScale1_2(d.titulo2); })
                .attr('y', 0)
                .text(function (d) { return ((d.valor * 100) / total).toFixed(2) + '%'; })
                .transition().duration(1000)
                .attr('y', function (d) { return yScale_3(d.valor) - 5; })
                .attr('style', function (d, i) {
                    var size = xScale1_2.bandwidth() / 5;
                    if (size > 30) size = 30;
                    return 'font-size  : ' + size + 'px;'
                });
        }
        if (((div_grafica.attr('leyenda') == 'true') || _leyenda) && (datos.length > 1)) {

            var leyenda = svg.selectAll(".leyenda-bar")
                .data(keys)
                .enter().append("g")
                .attr("class", "leyenda-bar")
                .attr("transform", function (d, i) { return "translate(0," + i * 20 + ")"; })
                .style("font", "10px sans-serif");
            leyenda.append("rect")
                .attr("class", "bar")
                .attr("width", 18)
                .attr("height", 18)
                .attr("fill", function (d, i) { return colores_barras(d.key); })
                .attr("x", 0)
                .attr("y", 0)
                .property('id', function (d, i) { return 'cod' + d.values[0].codigo })
                .on("mousemove", function (d) {
                    var data = 0;
                    for (var index = 0; index < d.values.length; index++) {
                        data += Number(d.values[index].valor);
                    }
                    self.tooltip
                        .style("left", d3.event.pageX - 50 + "px")
                        .style("top", d3.event.pageY - 70 + "px")
                        .style("display", "inline-block")
                        .html("<p>" + (d.key) + "<br>" + data + " : " + ((data * 100) / total).toFixed(2) + '%</p>');
                })
                .on("mouseout", function (d) { self.tooltip.style("display", "none"); })
                .transition()
                .ease(d3.easeBackOut)
                .duration(1000)
                .attr("y", this.margin.top)
                .attr("x", widthChart + pxML + 10);
            leyenda.append("text")
                .attr("class", "text-leyenda")
                .attr("dy", ".35em")
                .attr("text-anchor", "start")
                .attr("x", 0)
                .attr("y", 0)
                .transition()
                .ease(d3.easeBackOut)
                .duration(1000)
                .attr("x", widthChart + pxML + 40)
                .attr("y", this.margin.top + 10)
                .text(function (d) {
                    var data = 0;
                    for (var index = 0; index < d.values.length; index++) {
                        data += Number(d.values[index].valor);
                    }
                    return d.key + ' (' + data + ')';
                });
        }
    }
    GraficasD3.prototype.crearGraficaLineaAgrupada = function (data, height, id_contenedor, id_grafica, _leyenda, column_bootstrap, titulo, callback) {
        var _this = this;
        if (d3.select('#' + id_contenedor).select('#' + id_grafica).node()) {
            this.actualizarGrafica(data, id_contenedor, id_grafica, height, 'lineas', titulo, '', _leyenda, column_bootstrap);
        }
        else {
            var pxMR = this.margin.right;
            var pxMB = this.margin.bottom;
            var pxML = this.margin.left;
            // bar colors.mar
            this.colors = d3.scaleOrdinal(this.colores);
            _leyenda = _leyenda || false;
            if (_leyenda && (data.length > 1)) pxMR = (d3.max(data, function (d) { return Number(d.titulo2.length); }) * 10) + 5;

            var cant = d3.max(data, (d) => Number(d.valor.length));
            if (cant > 1) {
                if (cant < 6) pxML = cant * 20;
                else pxML = cant * 10;
            }
            var tituloLength = d3.max(data, function (d) { return Number(d.titulo.length); });
            var leylength = d3.max(data, function (d) { return Number(d.titulo2.length); });
            if (tituloLength > 1) {
                if (tituloLength > 25) pxMB = (tituloLength * 7) + this.margin.bottom;
                else if (tituloLength > 9) pxMB = (tituloLength * 9) + this.margin.bottom;
                else pxMB = (tituloLength * 11) + this.margin.bottom;
            }

            if (leylength > 1 && _leyenda) {
                if (leylength > 25) pxMR = (leylength + (cant + 2)) * 8;
                else if (leylength > 20) pxMR = (leylength + (cant + 2)) * 10;
                else pxMR = (leylength + (cant + 2)) * 12;
            }

            if (!column_bootstrap)
                column_bootstrap = 'col-md-12';
            var self_2 = this;
            var contenedor = d3.select('#' + id_contenedor)
                .append('div').classed(column_bootstrap, true)
                .property('id', id_grafica)
                .attr('type', 'lineas')
                .attr('leyenda', _leyenda);

            var nodo_contenedor_grafica = d3.select('#' + id_contenedor).select('#' + id_grafica).node();
            var width = parseInt(window.getComputedStyle(nodo_contenedor_grafica).width) - pxML - pxMR;
            var datosLineas = d3.nest().key(function (d) { return d.titulo2; }).entries(data);
            var total_2 = 0;
            data.forEach(function (element) {
                total_2 += Number(element.valor);
            });

            contenedor.append("label")
                .attr("transform", "translate(" + (width / 2) + " ," +
                    (this.margin.top / 3) + ")")
                .style("text-anchor", "middle")
                .property('id', 'titulo-lineas-' + id_grafica)
                .attr('class', 'titulo')
                .html(titulo + "<br>");

            var svg = contenedor.append('svg')
                .property('id', 'svg-lineas-' + id_grafica)
                .attr('width', parseInt(window.getComputedStyle(nodo_contenedor_grafica).width))
                .attr('height', height);
            var height_chart = height - this.margin.top - pxMB;
            /*
                        contenedor.append("label")
                            .property('id', 'total-lineas-' + id_grafica)
                            .attr('class', 'total')
                            .html(total_2);
     
            contenedor.append("button")
                .style("text-anchor", "middle")
                .property('id', 'exportar-' + id_grafica)
                .attr('target', "_blank")
                .html('Exportar').on('click', function () {
                    exportarGrafica('svg-lineas-' + id_grafica);
                });
                */
            // crear escalas
            var xScale_1 = d3.scaleBand().padding(0.1).rangeRound([0, width]).domain(data.map(function (d) { return d.titulo; }));
            var yScale_1 = d3.scaleLinear().rangeRound([height_chart, 0]).domain([0, d3.max(data, function (d) { return Number(d.valor); })]);
            ;

            svg.append('g')
                .attr('class', 'axis axis-y grid')
                .attr('transform', "translate(" + pxML + "," + this.margin.top + ")")
                .call(d3.axisLeft(yScale_1)
                    .tickFormat(null)
                    .tickSize(-width))
                .selectAll("g")
                .on("mousemove", function () {
                    d3.select(this).select("line").style("stroke-opacity", ".8");
                    d3.select(this).select("text").style("font-size", "20px");
                })
                .on("mouseout", function (d) {
                    d3.select(this).select("line").style("stroke-opacity", ".14");
                    d3.select(this).select("text").style("font-size", "11.5px");
                });

            // eje x
            svg.append('g')
                .attr('class', 'axis axis-x grid')
                .attr('transform', "translate(" + pxML + ", " + (this.margin.top + height_chart) + ")")
                .call(d3.axisBottom(xScale_1)
                    .tickFormat(null)
                    .tickSize(-height_chart))
                .selectAll("text")
                .style("text-anchor", "end")
                .attr("dx", "-.8em")
                .attr("dy", ".15em")
                .attr("transform", "rotate(-65)")
                .on("mousemove", function () {
                    d3.select(this).style("font-size", "13px");
                })
                .on("mouseout", function (d) {
                    d3.select(this).style("font-size", "11px");
                });
            // Area de la grafica
            var chart = svg.append('g')
                .property('id', 'chart-lineas-' + id_grafica)
                .attr('class', 'shadow')
                .attr('class', 'bars')
                .attr('transform', "translate(" + pxML + ", " + this.margin.top + ")");

            svg.append('text')
                .property('id', 'total-lineas-' + id_grafica)
                .attr('class', 'etiqueta total')
                .attr('transform', "translate(" + (parseInt(window.getComputedStyle(nodo_contenedor_grafica).width) - (cant * 30)) / 2 + ", " + (height - (this.margin.bottom / 2)) + ")")
                .text('Total: ' + total_2);

            //Crear Lineas
            var lineas = d3.line()
                .x(function (d) { return xScale_1(d.titulo); })
                .y(function (d) { return yScale_1(d.valor); })
                .curve(d3.curveMonotoneX);
            for (var index = 0; index < datosLineas.length; index++) {
                chart.append("path")
                    .datum(datosLineas[index].values)
                    .attr("stroke", function (d) { return _this.colors(index); })
                    .attr("class", "linea")
                    .attr("d", lineas);
            }
            //Crear Lineas
            var colores_puntos_1 = d3.scaleOrdinal().domain(datosLineas.map(function (d) { return d.key; })).range(this.colors.range());
            chart.selectAll(".punto")
                .data(data)
                .enter().append("circle")
                .attr('fill', function (d, i) { return colores_puntos_1(d.titulo2); })
                .attr("class", "punto bar")
                .attr("cx", function (d) { return xScale_1(d.titulo); })
                .attr("cy", 0)
                .attr("r", 5)
                .property('id', function (d, i) { return 'cod' + d.codigo; })
                .on("mousemove", function (d) {
                    self_2.tooltip
                        .style("left", d3.event.pageX - 50 + "px")
                        .style("top", d3.event.pageY - 70 + "px")
                        .style("display", "inline-block")
                        .html("<p>" + d.titulo + "<br>" + d.titulo2 + "<br>" + d.valor + " : " + ((d.valor * 100) / total_2).toFixed(2) + '% </p>');
                })
                .on("mouseout", function (d) { self_2.tooltip.style("display", "none"); })
                .transition().duration(400)
                .attr('cy', function (d) { return yScale_1(d.valor); })
                .attr('style', function (d) { return 'font-size  : ' + ((self_2.width / data.length) / (data.length)) + 'px;'; });

            var keys = d3.nest().key(function (d) { return d.titulo2; }).entries(data);

            if (_leyenda && (data.length > 1)) {
                var leyenda = svg.selectAll(".leyenda-bar")
                    .data(keys)
                    .enter().append("g")
                    .attr("class", "leyenda-bar")
                    .attr("transform", function (d, i) { return "translate(0," + i * 20 + ")"; })
                    .style("font", "10px sans-serif");
                leyenda.append("rect")
                    .attr("class", "bar")
                    .attr("width", 18)
                    .attr("height", 18)
                    .attr("fill", function (d, i) { return colores_puntos_1(d.key); })
                    .attr("x", 0)
                    .attr("y", 0)
                    .property('id', function (d, i) { return 'cod' + d.values[0].codigo })
                    .on("mousemove", function (d) {
                        var data = 0;
                        for (var index = 0; index < d.values.length; index++) {
                            data += Number(d.values[index].valor);
                        }
                        self_2.tooltip
                            .style("left", d3.event.pageX - 50 + "px")
                            .style("top", d3.event.pageY - 70 + "px")
                            .style("display", "inline-block")
                            .html("<p>" + (d.key) + "<br>" + data + " : " + ((data * 100) / total_2).toFixed(2) + '%</p>');
                    })
                    .on("mouseout", function (d) { self_2.tooltip.style("display", "none"); })
                    .transition()
                    .ease(d3.easeBackOut)
                    .duration(1000)
                    .attr("y", this.margin.top)
                    .attr("x", width + pxML + 10);

                leyenda.append("text")
                    .attr("class", "text-leyenda")
                    .attr("dy", ".35em")
                    .attr("text-anchor", "start")
                    .attr("x", 0)
                    .attr("y", 0)
                    .transition()
                    .ease(d3.easeBackOut)
                    .duration(1000)
                    .attr("x", width + pxML + 40)
                    .attr("y", this.margin.top + 10)
                    .text(function (d) {
                        var data = 0;
                        for (var index = 0; index < d.values.length; index++) {
                            data += Number(d.values[index].valor);
                        }
                        return d.key + ' (' + data + ')';
                    });
            }
        }
        if (typeof callback == 'function') callback();
    }
    GraficasD3.prototype.actualizarGraficaLineaAgrupada = function (datos, id_contenedor, id_grafica, titulo, _leyenda) {
        var _this = this;
        var div_grafica = d3.select('#' + id_contenedor).select('#' + id_grafica);
        var pxMR = this.margin.right;
        var pxMB = this.margin.bottom;
        var pxML = this.margin.left;

        if (((div_grafica.attr('leyenda') == 'true') || _leyenda) && (datos.length > 1)) pxMR = (d3.max(datos, function (d) { return Number(d.titulo2.length); }) * 10) + 5;

        var cant = d3.max(datos, (d) => Number(d.valor.length));
        if (cant > 1) {
            if (div_grafica.attr('horizontal') == 'true')
                if (cant < 6) pxMB = (cant * 20) + this.margin.bottom;
                else pxMB = (cant * 16) + this.margin.bottom;
            else pxML = cant * 15;
        }
        var tituloLength = d3.max(datos, function (d) { return Number(d.titulo.length); });
        var leylength = d3.max(datos, function (d) { return Number(d.titulo2.length); });
        if (tituloLength > 1) {
            if (tituloLength > 25) pxMB = (tituloLength * 7) + this.margin.bottom;
            else if (tituloLength > 9) pxMB = (tituloLength * 9) + this.margin.bottom;
            else pxMB = (tituloLength * 11) + this.margin.bottom;
        }

        if (leylength > 1 && _leyenda) {
            if (leylength > 25) pxMR = (leylength + (cant + 2)) * 8;
            else if (leylength > 20) pxMR = (leylength + (cant + 2)) * 10;
            else pxMR = (leylength + (cant + 2)) * 12;
        }

        var nodo_contenedor_grafica = d3.select('#' + id_contenedor).select('#' + id_grafica).node();
        var svg = d3.select('#' + id_contenedor).select('#' + id_grafica).select('#svg-lineas-' + id_grafica);
        var chart = svg.select('#chart-lineas-' + id_grafica);
        var xAxis = svg.select('.axis-x');
        var yAxis = svg.select('.axis-y');
        var heightChart = svg.attr('height') - this.margin.top - pxMB;
        var widthChart = svg.attr('width') - pxML - pxMR;
        var total = 0;
        datos.forEach(function (element) {
            total += Number(element.valor);
        });

        if (titulo) d3.select("#titulo-lineas-" + id_grafica).html(titulo + "<br>Total: " + total);
        var datosLineas = d3.nest().key(function (d) { return d.titulo2; }).entries(datos);
        var self = this;
        div_grafica.select('#total-lineas-' + id_grafica).transition()
            .attr('transform', "translate(" + parseInt(window.getComputedStyle(nodo_contenedor_grafica).width) / 2 + ", " + (svg.attr('width') - (this.margin.bottom / 2)) + ")")
            .text("Total: " + total);
        var xScale = d3.scaleBand().padding(0.1).rangeRound([0, widthChart]).domain(datos.map(function (d) { return d.titulo; }));
        var yScale = d3.scaleLinear().rangeRound([heightChart, 0]).domain([0, d3.max(datos, function (d) { return Number(d.valor); })]);

        xAxis.transition().duration(200)
            .attr('transform', "translate(" + pxML + ", " + (this.margin.top + heightChart) + ")")
            .call(d3.axisBottom(xScale)
                .tickFormat(null)
                .tickSize(-heightChart))
            .selectAll("text")
            .style("text-anchor", "end")
            .attr("dx", "-.8em")
            .attr("dy", ".15em")
            .attr("transform", "rotate(-65)");

        xAxis.selectAll("text")
            .on("mousemove", function () {
                d3.select(this).style("font-size", "13px");
            })
            .on("mouseout", function (d) {
                d3.select(this).style("font-size", "11px");
            });

        yAxis.transition().duration(200)
            .attr('transform', "translate(" + pxML + "," + this.margin.top + ")")
            .call(d3.axisLeft(yScale)
                .tickFormat(null)
                .tickSize(-widthChart));

        yAxis.selectAll("g")
            .on("mousemove", function () {
                d3.select(this).select("line").style("stroke-opacity", ".8");
                d3.select(this).select("text").style("font-size", "20px");
            })
            .on("mouseout", function (d) {
                d3.select(this).select("line").style("stroke-opacity", ".14");
                d3.select(this).select("text").style("font-size", "11.5px");
            })

        chart.transition()
            .attr('transform', "translate(" + pxML + ", " + this.margin.top + ")");

        svg.selectAll('.leyenda-bar').remove();
        svg.selectAll('.porcentaje').remove();
        chart.selectAll('path').remove();
        chart.selectAll('.punto').remove();
        var lineas = d3.line()
            .x(function (d) { return xScale(d.titulo); })
            .y(function (d) { return yScale(d.valor); })
            .curve(d3.curveMonotoneX);
        for (var index = 0; index < datosLineas.length; index++) {
            chart.append("path")
                .datum(datosLineas[index].values)
                .attr("stroke", function (d) { return _this.colors(index); })
                .attr("class", "linea")
                .attr("d", lineas);
        }
        var colores_puntos = d3.scaleOrdinal().domain(datosLineas.map(function (d) { return d.key; })).range(this.colors.range());
        chart.selectAll(".punto")
            .data(datos)
            .enter().append("circle")
            .attr('fill', function (d, i) { return colores_puntos(d.titulo2); })
            .attr("class", "punto bar")
            .attr("cx", function (d) { return xScale(d.titulo); })
            .attr("cy", 0)
            .attr("r", 5)
            .property('id', function (d, i) { return 'cod' + d.codigo })
            .on("mousemove", function (d) {
                self.tooltip
                    .style("left", d3.event.pageX - 50 + "px")
                    .style("top", d3.event.pageY - 70 + "px")
                    .style("display", "inline-block")
                    .html("<p>" + d.titulo + "<br>" + d.titulo2 + "<br>" + d.valor + " : " + ((d.valor * 100) / total).toFixed(2) + '%</p>');
            })
            .on("mouseout", function (d) { self.tooltip.style("display", "none"); })
            .transition().duration(400)
            .attr('cy', function (d) { return yScale(d.valor); });
        if (((div_grafica.attr('leyenda') == 'true') || _leyenda) && (datos.length > 1)) {
            var leyenda = svg.selectAll(".leyenda-bar")
                .data(datosLineas)
                .enter().append("g")
                .attr("class", "leyenda-bar")
                .attr("transform", function (d, i) { return "translate(0," + i * 20 + ")"; })
                .style("font", "10px sans-serif");
            leyenda.append("rect")
                .attr("class", "bar")
                .attr("width", 18)
                .attr("height", 18)
                .attr("fill", function (d, i) { return colores_puntos(d.key); })
                .attr("x", 0)
                .attr("y", 0)
                .property('id', function (d, i) { return 'cod' + d.codigo })
                .on("mousemove", function (d) {
                    var data = 0;
                    for (var index = 0; index < d.values.length; index++) {
                        data += Number(d.values[index].valor);
                    }
                    self.tooltip
                        .style("left", d3.event.pageX - 50 + "px")
                        .style("top", d3.event.pageY - 70 + "px")
                        .style("display", "inline-block")
                        .html("<p>" + (d.key) + "<br>" + data + " : " + ((data * 100) / total).toFixed(2) + '%</p>');
                })
                .on("mouseout", function (d) { self.tooltip.style("display", "none"); })
                .transition()
                .ease(d3.easeBackOut)
                .duration(1000)
                .attr("y", this.margin.top)
                .attr("x", widthChart + pxML + 10);
            leyenda.append("text")
                .attr("class", "text-leyenda")
                .attr("dy", ".35em")
                .attr("text-anchor", "start")
                .attr("x", 0)
                .attr("y", 0)
                .transition()
                .ease(d3.easeBackOut)
                .duration(1000)
                .attr("x", widthChart + pxML + 40)
                .attr("y", this.margin.top + 10)
                .text(function (d) {
                    var data = 0;
                    for (var index = 0; index < d.values.length; index++) {
                        data += Number(d.values[index].valor);
                    }
                    return d.key + ' (' + data + ')';
                });
        }
    }
    GraficasD3.prototype.actualizarGrafica = function (datos, id_contenedor, id_grafica, height, tipo, titulo, horizontal, leyenda, posicion_leyenda, column_bootstrap, dona) {
        if (d3.select('#' + id_contenedor).select('#' + id_grafica).node()) {
            var div_grafica = d3.select('#' + id_contenedor).select('#' + id_grafica);
            if (div_grafica) {
                if (div_grafica.attr('type') != tipo) {
                    this.reiniciarGrafica(datos, id_contenedor, id_grafica, height, tipo, titulo, horizontal, leyenda, posicion_leyenda, column_bootstrap, dona);
                } else {
                    if (div_grafica.attr('type') == 'lineas')
                        this.actualizarGraficaLineaAgrupada(datos, id_contenedor, id_grafica, titulo, leyenda);
                    if (div_grafica.attr('type') == 'barra')
                        this.actualizarGraficaBarra(datos, id_contenedor, id_grafica, titulo, leyenda);
                    if (div_grafica.attr('type') == 'torta')
                        this.actualizarGraficaTorta(datos, id_contenedor, id_grafica, titulo, leyenda);
                    if (div_grafica.attr('type') == 'barra-agrupada')
                        this.actualizarGraficaBarraAgrupada(datos, id_contenedor, id_grafica, titulo, leyenda);
                }
            }
        }
    };
    GraficasD3.prototype.reiniciarGrafica = function (data, id_contenedor, id_grafica, height, tipo, titulo, _horizontal, _leyenda, posicion_leyenda, column_bootstrap, dona) {
        column_bootstrap = column_bootstrap || 'col-md-12';
        if (d3.select('#' + id_contenedor).select('#' + id_grafica).node()) {
            var div_grafica = d3.select('#' + id_contenedor).select('#' + id_grafica);
            if (div_grafica.attr('dona') == 'true')
                dona = true;
            this.borrarGrafica(id_contenedor, id_grafica, () => {
                if (tipo == 'barra-agrupada')
                    this.crearGraficaBarraAgrupada(data, height, id_contenedor, id_grafica, _horizontal, _leyenda, column_bootstrap, titulo);
                if (tipo == 'lineas')
                    this.crearGraficaLineaAgrupada(data, height, id_contenedor, id_grafica, _leyenda, column_bootstrap, titulo);
                if (tipo == 'barra')
                    this.crearGraficaBarra(data, height, id_contenedor, id_grafica, _horizontal, _leyenda, posicion_leyenda, column_bootstrap, titulo);
                if (tipo == 'torta') {
                    this.crearGraficaTorta(data, height, id_contenedor, id_grafica, dona, _leyenda, posicion_leyenda, column_bootstrap, titulo);
                }
            });
        } else {
            if (tipo == 'barra-agrupada')
                this.crearGraficaBarraAgrupada(data, height, id_contenedor, id_grafica, _horizontal, _leyenda, column_bootstrap, titulo);
            if (tipo == 'lineas')
                this.crearGraficaLineaAgrupada(data, height, id_contenedor, id_grafica, _leyenda, column_bootstrap, titulo);
            if (tipo == 'barra')
                this.crearGraficaBarra(data, height, id_contenedor, id_grafica, _horizontal, _leyenda, posicion_leyenda, column_bootstrap, titulo);
            if (tipo == 'torta') {
                this.crearGraficaTorta(data, height, id_contenedor, id_grafica, dona, _leyenda, posicion_leyenda, column_bootstrap, titulo);
            }
        }
    };
    GraficasD3.prototype.addEventCrearGrafica = function (datos, cod_validador, id_contenedor, id_grafica, id_new_contenedor, id_new_grafica, tipo, height_new_grafica, _leyenda_new_grafica, posicion_leyenda_new_grafica, _colum_bootstrap_new_grefica, titulo_new_grafica, horizonta_new_grafica, _dona_new_grafica) {
        var _this = this;
        cod_validador = 'cod' + cod_validador;
        if (d3.select('#' + id_contenedor).select('#' + id_grafica).node()) {
            var div_grafica = d3.select('#' + id_contenedor).select('#' + id_grafica);
            var type = div_grafica.attr('type');
            var svg = d3.select('#' + id_contenedor).select('#' + id_grafica).select('#svg-' + type + '-' + id_grafica);
            var chart = svg.select('#chart-' + type + '-' + id_grafica);
            if (type == 'torta') var ley = svg.selectAll('.leyenda-torta').select('#' + cod_validador);
            else var ley = svg.selectAll('.leyenda-bar').select('#' + cod_validador);
            ley.on("click", function () {
                if (d3.select('#' + id_new_contenedor).select('#' + id_new_grafica).node()) {
                    var type_new = d3.select('#' + id_new_contenedor).select('#' + id_new_grafica).attr('type')
                    if (type_new != tipo) {
                        return _this.reiniciarGrafica(datos, id_new_contenedor, id_new_grafica, height_new_grafica, tipo, titulo_new_grafica, horizonta_new_grafica, _leyenda_new_grafica, posicion_leyenda_new_grafica, _colum_bootstrap_new_grefica, _dona_new_grafica);
                    } else {
                        if (tipo == 'torta')
                            return _this.crearGraficaTorta(datos, height_new_grafica, id_new_contenedor, id_new_grafica, _dona_new_grafica, _leyenda_new_grafica, posicion_leyenda_new_grafica, _colum_bootstrap_new_grefica, titulo_new_grafica, _dona_new_grafica);
                        if (tipo == 'barra')
                            return _this.crearGraficaBarra(datos, height_new_grafica, id_new_contenedor, id_new_grafica, horizonta_new_grafica, _leyenda_new_grafica, posicion_leyenda_new_grafica, _colum_bootstrap_new_grefica, titulo_new_grafica);
                        if (tipo == 'lineas')
                            return _this.crearGraficaLineaAgrupada(datos, height_new_grafica, id_new_contenedor, id_new_grafica, _leyenda_new_grafica, _colum_bootstrap_new_grefica, titulo_new_grafica);
                        if (tipo == 'barra-agrupada')
                            return _this.crearGraficaBarraAgrupada(datos, height_new_grafica, id_new_contenedor, id_new_grafica, horizonta_new_grafica, _leyenda_new_grafica, _colum_bootstrap_new_grefica, titulo_new_grafica);
                    }
                } else {
                    if (tipo == 'torta')
                        return _this.crearGraficaTorta(datos, height_new_grafica, id_new_contenedor, id_new_grafica, _dona_new_grafica, _leyenda_new_grafica, posicion_leyenda_new_grafica, _colum_bootstrap_new_grefica, titulo_new_grafica, _dona_new_grafica);
                    if (tipo == 'barra')
                        return _this.crearGraficaBarra(datos, height_new_grafica, id_new_contenedor, id_new_grafica, horizonta_new_grafica, _leyenda_new_grafica, posicion_leyenda_new_grafica, _colum_bootstrap_new_grefica, titulo_new_grafica);
                    if (tipo == 'lineas')
                        return _this.crearGraficaLineaAgrupada(datos, height_new_grafica, id_new_contenedor, id_new_grafica, _leyenda_new_grafica, _colum_bootstrap_new_grefica, titulo_new_grafica);
                    if (tipo == 'barra-agrupada')
                        return _this.crearGraficaBarraAgrupada(datos, height_new_grafica, id_new_contenedor, id_new_grafica, horizonta_new_grafica, _leyenda_new_grafica, _colum_bootstrap_new_grefica, titulo_new_grafica);
                }
            });
            chart.selectAll('#' + cod_validador)
                .on("click", function () {
                    if (d3.select('#' + id_new_contenedor).select('#' + id_new_grafica).node()) {
                        var type_new = d3.select('#' + id_new_contenedor).select('#' + id_new_grafica).attr('type')
                        if (type_new && type_new != tipo) {
                            return _this.reiniciarGrafica(datos, id_new_contenedor, id_new_grafica, height_new_grafica, tipo, titulo_new_grafica, horizonta_new_grafica, _leyenda_new_grafica, posicion_leyenda_new_grafica, _colum_bootstrap_new_grefica, _dona_new_grafica);
                        } else {
                            if (tipo == 'torta')
                                return _this.crearGraficaTorta(datos, height_new_grafica, id_new_contenedor, id_new_grafica, _dona_new_grafica, _leyenda_new_grafica, posicion_leyenda_new_grafica, _colum_bootstrap_new_grefica, titulo_new_grafica, _dona_new_grafica);
                            if (tipo == 'barra')
                                return _this.crearGraficaBarra(datos, height_new_grafica, id_new_contenedor, id_new_grafica, horizonta_new_grafica, _leyenda_new_grafica, posicion_leyenda_new_grafica, _colum_bootstrap_new_grefica, titulo_new_grafica);
                            if (tipo == 'lineas')
                                return _this.crearGraficaLineaAgrupada(datos, height_new_grafica, id_new_contenedor, id_new_grafica, _leyenda_new_grafica, _colum_bootstrap_new_grefica, titulo_new_grafica);
                            if (tipo == 'barra-agrupada')
                                return _this.crearGraficaBarraAgrupada(datos, height_new_grafica, id_new_contenedor, id_new_grafica, horizonta_new_grafica, _leyenda_new_grafica, _colum_bootstrap_new_grefica, titulo_new_grafica);
                        }
                    } else {
                        if (tipo == 'torta')
                            return _this.crearGraficaTorta(datos, height_new_grafica, id_new_contenedor, id_new_grafica, _dona_new_grafica, _leyenda_new_grafica, posicion_leyenda_new_grafica, _colum_bootstrap_new_grefica, titulo_new_grafica, _dona_new_grafica);
                        if (tipo == 'barra')
                            return _this.crearGraficaBarra(datos, height_new_grafica, id_new_contenedor, id_new_grafica, horizonta_new_grafica, _leyenda_new_grafica, posicion_leyenda_new_grafica, _colum_bootstrap_new_grefica, titulo_new_grafica);
                        if (tipo == 'lineas')
                            return _this.crearGraficaLineaAgrupada(datos, height_new_grafica, id_new_contenedor, id_new_grafica, _leyenda_new_grafica, _colum_bootstrap_new_grefica, titulo_new_grafica);
                        if (tipo == 'barra-agrupada')
                            return _this.crearGraficaBarraAgrupada(datos, height_new_grafica, id_new_contenedor, id_new_grafica, horizonta_new_grafica, _leyenda_new_grafica, _colum_bootstrap_new_grefica, titulo_new_grafica);
                    }
                });
        }
    };
    function mergeWithFirstEqualZero(first, second) {

        var secondSet = d3.set();

        second.forEach(function (d) { secondSet.add(d.label); });

        var onlyFirst = first
            .filter(function (d) { return !secondSet.has(d.label) })
            .map(function (d) { return { label: d.label, value: 0 }; });

        var sortedMerge = d3.merge([second, onlyFirst])
            .sort(function (a, b) {
                return d3.ascending(a.label, b.label);
            });

        return sortedMerge;
    }
    /*
        function exportarGrafica(id) {
            var idSVG = d3.select('#' + id).node().id,
                svg = document.getElementById(idSVG);
    
            svg.toDataURL("image/png", {
                callback: function (d) {
                    window.open(d, '_blank');
                }
            })
        }
        */
    return GraficasD3;
}());