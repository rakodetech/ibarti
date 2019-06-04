var arreglo_v;
function valores(codigo, tipo) {
    var clasif = $('#clasif').val();
    var parametros = { 'clasif': clasif, 'tipo': tipo, 'codigo': codigo };
    //console.log(parametros)
    $.ajax({
        data: parametros,
        url: 'packages/nov_check_trab/views/crear_novedad_valor.php',
        type: 'post',
        success: function (response) {
            var menus = JSON.parse(response);
            arreglo_v = JSON.parse(menus.datos);
            $("#contenedor").html(menus.htmla);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });
}

function seleccionado(novedad, posicion, valor) {
    $('#mod').hide();
    $("#cod_" + novedad).val(valor);
    arreglo_v[novedad].forEach((res)=>{
        res.check="";
    });
    $("#contenedor_" + novedad+" p").text(arreglo_v[novedad][posicion].descripcion);
    arreglo_v[novedad][posicion].check = valor;

    if($("#mod_"+novedad).length<=0){
        $("#contenedor_" + novedad).append(/*html*/`
        <img id="mod_${novedad}" src="imagenes/consultar01.png" width="20px" onclick='func(this)' height="20px" style="border:1px solid;cursor:pointer;" title="MODIFICAR"></img>
    `)
    }
    
    
}

function func(el) {
    
    var id = el.id.replace('contenedor_', '').replace('mod_','');

    if (event.type == "click") {
        if ($("#cod_" + id).val() != "") {
            var pos = $('#' + el.id).offset();
            $('#mod').show();
            $('#mod').offset({
                top: (pos.top - parseInt($('#mod').css('height').replace('px', ''))),
                left: (pos.left + parseInt($('#' + el.id).css('width').replace('px', '')))
            });
            $('#titulo_mod').html(arreglo_v[id][0].nov);
            $("#opciones_mod tbody").html('');
            arreglo_v[id].forEach((res, i) => {
                
                var check = false;
                
                if(!(typeof res.check == "undefined")){
                    if(res.check!=""){
                        check = true;
                    }
                }
                $("#opciones_mod tbody").append(/*html*/`
                <tr>
                    <td width="80%">${res.descripcion}</td>
                    <td width="20%"><input type="radio" onclick="seleccionado('${id}','${i}',this.value)" ${check ? 'checked="checked"':''} name="${id}" value="${res.codigo}"></td>
                </tr>
            `);
            });
            
        }
    }else{
        if ($('#cod_' + id).val() == "") {

            var pos = $('#' + el.id).offset();
            $('#mod').show();
            $('#mod').offset({
                top: (pos.top - parseInt($('#mod').css('height').replace('px', ''))),
                left: (pos.left + parseInt($('#' + el.id).css('width').replace('px', '')))
            });
            $('#titulo_mod').html(arreglo_v[id][0].nov);
            $("#opciones_mod tbody").html('');
            arreglo_v[id].forEach((res, i) => {
                var check = false;
                
                if(!(typeof res.check == "undefined")){
                    if(res.check!=""){
                        check = true;
                    }
                }
                $("#opciones_mod tbody").append(/*html*/`
                <tr>
                    <td width="80%">${res.descripcion}</td>
                    <td width="20%"><input type="radio" onclick="seleccionado('${id}','${i}',this.value)" ${check ? 'checked' : ''} name="${id}" value="${res.codigo}"></td>
                </tr>
            `)
            });
        }
    }

    

}


function llenar_nov_tipo(clasificacion) {

    var parametros = { 'clasificacion': clasificacion, 'inicial': '' };
    $.ajax({
        data: parametros,
        url: 'ajax/Add_novedades_tipo.php',
        type: 'post',
        success: function (response) {
            $('#tipo').html(response);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });
}
function agregar_registro(e, i) {
    e.preventDefault();
    var parametros = $("#" + i).serializeArray();
    var error = 0;
    var mensajes = [];
    for (const key in parametros) {
        var indice = parametros[key].name;
        var valor = parametros[key].value;
        if(indice.indexOf("valores")==0){
            if(valor==""){
                error++;
            }
        }
        if ((indice == "codigo_supervisor" && valor == "") || (indice == "codigo_trabajador" && valor == "")) {
            error++;
        }
        
    }
    
    if (error <= 0) {
        if (confirm("Esta seguro que desea guardar la evaluacion")) {
            $.ajax({
                data: parametros,
                url: 'packages/nov_check_trab/views/set_check_trab.php',
                type: 'post',
                success: function (response) {
                    window.history.back();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });
        }

    } else {
        toastr.error(`Tiene que seleccionar todo`, 'ERROR');
    }





}