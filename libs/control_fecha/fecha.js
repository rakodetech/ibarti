////////UNICO DE CONTROL DE FECHA/////////////////////////////////////////////////////////////////
var meses = ['ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'];
var contenedor_fecha_desde;
var contenedor_fecha_hasta;
var resp;
var call;
/////////////////////////////////////////////////////////////////////77
var activa = false;
function crear_control(contenedor, cont_desde, cont_hasta, callback) {
    call = callback;
    resp = contenedor;
    if ($('#fecha_ingreso').length > 0) {

        if (activa) {
            $('#fecha_ingreso').hide();
            $('#fecha_ingreso').offset({ top: ($('#' + contenedor).offset().top + 5 + $('#' + contenedor).height()), left: ($('#' + contenedor).offset().left - ($('#fecha_ingreso').width() / 2)) });
        } else {

            $('#fecha_ingreso').show();
            $('#fecha_ingreso').offset({ top: ($('#' + contenedor).offset().top + 5 + $('#' + contenedor).height()), left: ($('#' + contenedor).offset().left - ($('#fecha_ingreso').width() / 2)) });

        }

    } else {
        contenedor_fecha_desde = cont_desde;
        contenedor_fecha_hasta = cont_hasta;

        var control_desde = $('#' + contenedor_fecha_desde).val();
        var control_hasta = $('#' + contenedor_fecha_hasta).val();
        control_desde = control_desde.split('-').reverse().join('/');
        control_hasta = control_hasta.split('-').reverse().join('/');
        if (control_desde == "" || control_hasta == "") {
            var dates = new Date()
            control_desde = `${String(dates.getDate()).length < 2 ? "0" : ""}${String(dates.getDate())}/${String(dates.getMonth() + 1).length < 2 ? "0" : ""}${dates.getMonth() + 1}/${dates.getFullYear()}`;
            control_hasta = `${String(dates.getDate()).length < 2 ? "0" : ""}${String(dates.getDate())}/${String(dates.getMonth() + 1).length < 2 ? "0" : ""}${dates.getMonth() + 1}/${dates.getFullYear()}`;
        }
        $('html').append(/*html*/ `
        <div id="fecha_ingreso" class="contenido">
           <nav class="header_fecha">
                <ul class="opciones">
                    <li value="fecha" id="control_fecha" onclick="crear_escenarios(this,'body_fecha')">FECHA</li>
                    
                    <li value="mes" id="control_mes" onclick="crear_escenarios(this,'body_fecha')">MES</li>
                    <li value="año" id="control_año" onclick="crear_escenarios(this,'body_fecha')">AÑO</li>
                    <li style="color:red;" onclick="cerrar_control()">CERRAR</li>
                </ul>
           </nav>
           <section id="body_fecha" class="body_fecha"></section>
           <footer id="fecha_muestra" class="pie_fecha">
           <b><label id="label_desde">${control_desde}</label></b>
           A
           <b><label id="label_hasta">${control_hasta}</label></b>
           </footer>
        </div>
           `);

        $('#control_fecha').click();

        $('#fecha_ingreso').offset({ top: ($('#' + contenedor).offset().top + 5 + $('#' + contenedor).height()), left: ($('#' + contenedor).offset().left - ($('#fecha_ingreso').width() / 2)) });
    }

    activa = !activa;

}
function destruir(s) {

    $('#' + s).remove();

}

function mostrar_fecha(id, val, tipo) {

    switch (tipo) {
        case "fecha":
            if (id == "fec_des") {
                $('#label_desde').text(val.split("-").reverse().join("/"));
            } else {
                $('#label_hasta').text(val.split("-").reverse().join("/"));
            }
            break;
        case "mes":
            var mes_desde = String($('#m_d').val()).length < 2 ? "0" + String($('#m_d').val()) : String($('#m_d').val());
            var anno_desde = $('#a_d').val();
            var mes_hasta = String($('#m_h').val()).length < 2 ? "0" + String($('#m_h').val()) : String($('#m_h').val());
            var anno_hasta = $('#a_h').val();

            var fecha_desde = `01/${mes_desde}/${anno_desde}`;
            var ultimo_hasta = new Date(anno_hasta, mes_hasta, 0);
            var fecha_hasta = `${String(ultimo_hasta.getDate()).length < 2 ? "0" + String(ultimo_hasta.getDate()) : String(ultimo_hasta.getDate())}/${mes_hasta}/${anno_hasta}`;
            $('#label_desde').text(fecha_desde)
            $('#label_hasta').text(fecha_hasta)
            break;
        case "año":
            var anno_desde = $('#a_d').val();
            var anno_hasta = $('#a_h').val();
            var fecha_desde = `01/01/${anno_desde}`;
            var fecha_hasta = `31/12/${anno_hasta}`;
            $('#label_desde').text(fecha_desde);
            $('#label_hasta').text(fecha_hasta);
            break;
    }


}

function crear_escenarios(base, contenedor) {
    $('#control_fecha').removeClass('seleccionado');
    $('#control_mes').removeClass('seleccionado');
    $('#control_año').removeClass('seleccionado');
    $('#control_semana').removeClass('seleccionado');
    $('#' + base.id).addClass('seleccionado');
    var opcion = base.textContent.toLowerCase();
    $('#' + contenedor).html("")
    var fecha_desde = String($('#label_desde').text()).split('/').reverse().join('-');
    var fecha_hasta = String($('#label_hasta').text()).split('/').reverse().join('-');

    switch (opcion) {
        case "fecha":
            $('#' + contenedor).append(/*html*/`
                <section>
                    <section>
                        Fecha Desde:<br><br>
                        Fecha Hasta:
                    </section>
                    <section>
                        <input type="date" id="fec_des" onchange="mostrar_fecha(this.id,this.value,'fecha')" value="${fecha_desde}"></input><br><br>
                        <input type="date" id="fec_hes" onchange="mostrar_fecha(this.id,this.value,'fecha')" value="${fecha_hasta}"></input>
                    </section>
                    <section>
                    <button type="button" id="control_fecha" class="btn btn-large waves" onclick="asignacion_fecha(this.id)">Aceptar</button>
                    </section>
                </section>
            `);
            break;
        case "mes":
            var control_desde = $('#label_desde').text().split('/');
            var control_hasta = $('#label_hasta').text().split('/');

            var input_mes_desde = "";
            var input_mes_hasta = "";
            var input_anno_desde = "";
            var input_anno_hasta = "";
            for (i = Number(control_desde[2]) - 100; i < Number(control_desde[2]) + 100; i++) {
                input_anno_desde += `<option value="${i + 1}" ${(i + 1) == (Number(control_desde[2])) ? 'selected="selected"' : ''}>${i + 1}</option>`;
                input_anno_hasta += `<option value="${i + 1}" ${(i + 1) == (Number(control_hasta[2])) ? 'selected="selected"' : ''}>${i + 1}</option>`;
            }
            for (i = 0; i < 12; i++) {
                input_mes_desde += `<option value="${i + 1}" ${(i + 1) == (Number(control_desde[1])) ? 'selected="selected"' : ''} >${meses[i]}</option>`;
                input_mes_hasta += `<option value="${i + 1}" ${(i + 1) == (Number(control_hasta[1])) ? 'selected="selected"' : ''} >${meses[i]}</option>`;

            }

            $('#' + contenedor).append(/*html*/`
                <section>
                    <section>
                        Mes Desde:<br><br>
                        Mes Hasta:
                    </section>
                    <section>
                        <select name="" id="m_d" onchange="mostrar_fecha(this.id,this.value,'mes')">${input_mes_desde}</select> <select name="" id="a_d" onchange="mostrar_fecha(this.id,this.value,'mes')">${input_anno_desde}</select> <br><br>
                        <select name="" id="m_h" onchange="mostrar_fecha(this.id,this.value,'mes')">${input_mes_hasta}</select> <select name="" id="a_h" onchange="mostrar_fecha(this.id,this.value,'mes')">${input_anno_hasta}</select>
                    </section>
                    <section>
                        <button type="button" class="btn btn-large waves" id="control_mes" onclick="asignacion_fecha(this.id)">Aceptar</button>
                    </section>
                </section>
            `);
            control_desde[0] = "01";
            var ultimo_hasta = new Date(control_hasta[2], control_hasta[1], 0);
            control_hasta[0] = String(ultimo_hasta.getDate()).length < 2 ? "0" + String(ultimo_hasta.getDate()) : String(ultimo_hasta.getDate())
            $('#label_desde').text(control_desde.join('/'));
            $('#label_hasta').text(control_hasta.join('/'));
            break;
        case "semana":
            $('#' + contenedor).append(/*html*/`
                <section>
                    <section>
                        Semana Desde:<br><br>
                        Semana Hasta:
                    </section>
                    <section>
                        <input type="date" id="fec_des"></input><br><br>
                        <input type="date" id="fec_hes"></input>
                    </section>
                    <section>
                        <button type="button" class="btn btn-large waves" id="semana" onclick="asignacion_fecha(this.id)">Aceptar</button>
                    </section>
                </section>
            `);
            break;
        case "año":
            var control_desde = $('#label_desde').text().split('/');
            var control_hasta = $('#label_hasta').text().split('/');
            var annos_desde = "";
            var annos_hasta = "";
            for (i = Number(control_desde[2]) - 100; i < Number(control_desde[2]) + 100; i++) {
                annos_desde += `<option value="${i + 1}" ${(i + 1) == (Number(control_desde[2])) ? 'selected="selected"' : ''}>${i + 1}</option>`;
                annos_hasta += `<option value="${i + 1}" ${(i + 1) == (Number(control_hasta[2])) ? 'selected="selected"' : ''}>${i + 1}</option>`;
            }
            $('#' + contenedor).append(/*html*/`
                <section>
                    <section>
                        Año Desde:<br><br>
                        Año Hasta:
                    </section>
                    <section>
                        <select id="a_d" onchange="mostrar_fecha(this.id,this.value,'año')">${annos_desde}</select><br><br>
                        <select id="a_h" onchange="mostrar_fecha(this.id,this.value,'año')">${annos_hasta}</select>
                    </section>
                    <section>
                        <button type="button" class="btn btn-large waves" id="control_año" onclick="asignacion_fecha(this.id)">Aceptar</button>
                    </section>
                </section>
            `);
            break;
    }


}

function cerrar_control() {
    activa = !activa;
    $('#fecha_ingreso').hide();
}

function asignacion_fecha() {
    var f_d = $('#label_desde').text();
    var f_h = $('#label_hasta').text();

    $('#' + contenedor_fecha_desde).val(f_d.split('/').reverse().join('-'))
    $('#' + contenedor_fecha_hasta).val(f_h.split('/').reverse().join('-'))
    $('#' + resp).val(`Desde: ${f_d} | Hasta: ${f_h}`)
    activa = !activa;
    $('#fecha_ingreso').hide();
    if (typeof call == 'function') {
        call();
    }
    /*
    
        var primerDia = new Date(2018, 2, 1);
    
        var ultimoDia = new Date(2018, 2, 0);
        console.log(Number(fecha_desde.split('/')[2]))
    
    
        console.log("El primer día es: " + primerDia.getDate());
    
        console.log("El ultimo día es: " + ultimoDia.getDate());*/
}
///////////////////////////////////////////////////////////////////////////