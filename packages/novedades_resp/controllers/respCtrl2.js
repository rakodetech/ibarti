var grafica;
var datos_grafica1 = [];
var datos_grafica2 = [];
var datos;

function obtener_data(){
    $('#cargando').show();
    $('#inicial').hide();
    $('#con_data').hide();
    $('#sin_data').hide();
    $('#contenedor').html('');
    
    $('#contenedor1').hide();
    
    $('#contenedor2').hide();
    $('#detalles').hide();
    var fecha_desde = $('#f_d').val();
    var fecha_hasta = $('#f_h').val();
    var parametros = {"f_d":fecha_desde,"f_h":fecha_hasta};
    
    $.ajax({
        data:parametros,
        url:   'packages/novedades_resp/views/get_num_perfil.php',
        type:  'post',
        success:  function (response) {

            var contenedor = [];
            
            datos= JSON.parse(response);
            
            var newa = d3.nest().key((d)=> d.fec_us_mod).sortKeys(d3.ascending).key((d) => d.codigo_perfil).sortKeys(d3.ascending).entries(datos);
            //console.log(newa)
            if(datos.length!=0){
                $('#inicial').show();
                $('#con_data').show();
                $('#cargando').hide();
                var num_fechas =  d3.nest().key((d) => d.fec_us_mod).sortKeys(d3.ascending).entries(datos);
                var fechaa= [];
                var dot = []
                num_fechas.forEach((fec)=>{
                    fechaa.push(fec.key)
                })
           // ////console.log(fechaa)
           var prueba  = d3.nest()
           .key((d) => d.codigo_perfil).key((d) => d.fec_us_mod).sortKeys(d3.ascending).entries(datos);

           var perfiles = [];
           prueba.forEach((perfil,a)=>{
            var fecha = "[";
               // perfil.include('2019-01-01');


               perfil.values.forEach((fechas,i)=>{
                contenedor.push(fechas.key,fechas.values.length);
                dot.push(fechas.values.length)
            });

                    ////console.log(JSON.stringify(dot))
                    dot=[]
                    fechaa.forEach((fec,i)=>{
                        var indice = contenedor.indexOf(fec);
                        
                        if(indice>=0){
                         //   ////console.log(contenedor[indice +1]);

                         if(i==0){
                            fecha+=`{"axis":"${fec}","value":${contenedor[indice +1]}}`;
                        }else{
                            fecha+=`,{"axis":"${fec}", "value":${contenedor[indice +1]}}`;
                        }
                    }else{
                            ///////console.log(perfil.key,fec,0);
                            if(i==0){
                                fecha+=`{"axis":"${fec}","value":0}`;
                            }else{
                                fecha+=`,{"axis":"${fec}","value":0}`;
                            }
                        }
                        
                    });

                    fecha+="]";


               //////console.log(fecha)
               perfiles.push(JSON.parse(fecha));
               contenedor = []
               
           });

        //////console.log(JSON.stringify(perfiles));
            /*
            prueba.forEach((a)=>{
                contenido = [];
                contenido.push(a.key);
                a.values.forEach((b)=>{
                    contenido.push(b.fec_us_mod);
                });
                contenedor.push(contenido)
            });*/

           // prueba[0].values.forEach((a)=>{

           // })

           $('#f_d').val(datos[0].desde);
           $('#f_h').val(datos[0].hasta);

           formatear_data(datos);

       }else{
        $('#inicial').show();
        $('#sin_data').show();
        $('#cargando').hide();
    }


           // probar_linea(contenedor);

       },
       error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.status);
        alert(thrownError);}
    });

}

function probar_linea(detalles){
    $("#contenedor").show();
    grafica = c3.generate({
        bindto: "#contenedor",
        data: {
            type: 'line',
            //type: 'donut',
            columns: detalles,
            
        },
        legend:{
            hide:true,
            position:'right'
        },
        tooltip: {
            show:false


        }
    });
}
function formatear_data2(cod,info,selec){
    datos_grafica2 =[]
    var nueva_Data = [];
    info.forEach((res1)=>{
      if(cod.replace('cod_','')==res1.codigo_perfil){
         nueva_Data.push(res1);
     }
 });
    datos_grafica2 = d3.nest()
    .key((d) => d[selec]).entries(nueva_Data);
    ////////console.log(add_data)
    
    return datos_grafica2;
}
function formatear_data(info){

    datos_grafica1=[];
    var nueva =  d3.nest()
    .key((d) => d.codigo_perfil).sortKeys(d3.ascending).key((d) => d.cod_clasif).sortKeys(d3.ascending).entries(info);
    //////console.log("data",nuevo);
    
    var suma_elemento = 0;
    var suma_clasif= 0;
    var suma_perfil= 0;


    var promedio= 0;
    
    var prom_perfil = [];
    var prom_clasif = [];

    var json_prom = [];


    nueva.forEach((res,j)=>{

        res.values.forEach((ras,i)=>{

            ras.values.forEach((ris)=>{
             suma_elemento+=Number(ris.dias_respuesta);
         });
            prom_clasif[i]= (suma_elemento/ras.values.length);
            suma_clasif+=suma_elemento/ras.values.length;
            
            suma_elemento =0 ;
        });
        suma_perfil=suma_clasif/res.values.length;
        prom_perfil[j]=prom_clasif;

        datos_grafica1.push([ `cod_${res.values[0].values[0].codigo_perfil}`,Math.round(suma_perfil)]);
        prom_clasif=[];
        suma_clasif = 0;
        
    });
    
    var datas = "{";
    datos_grafica1.forEach((res,i)=>{

        datas+= `"${res[0]}":"${nueva[i].values[0].values[0].perfil} (${res[1]} dias)"`;
        if(!(i==datos_grafica1.length - 1)){
            datas+=","
        }
    });
    datas+="}";
    
    crear_grafica(JSON.parse(datas));

    
}

function crear_grafica(name){
    //////console.log(name)
    $('#cargando').hide();
    $('#inicial').show();

    grafica = c3.generate({
        bindto: "#contenedor",
        data: {
            type: 'pie',
            //type: 'donut',
            columns: datos_grafica1,
            
            onclick: function(d){
                ////console.log(d.name)
                $('#p_clasif').html(`PROMEDIO POR CLASIFICACION (${d.name})`);
                $('#contenedor1').show();
                var facmento =[];
                var now  = [];
                var name = "{"; 
                var suma=0;
                var suma2=0;
                facmento =  formatear_data2(d.id,datos,'cod_clasif');
                ////console.log(facmento)
                facmento.forEach((res,i)=>{
                    res.values.forEach((res2)=>{
                        suma+=Number(res2.dias_respuesta);
                        //name+= `"${res[0]}":"${nuevo[i].values[0].values[0].perfil}"`;

                    });

                    now.push([`cod_${res.key}`,(Math.round(suma/res.values.length))]);
                    
                    name+=`"cod_${res.key}":"${res.values[0].descripcion_clasif}"`;

                    if(!(i==(facmento.length - 1))){
                        name+=","
                    }
                    suma=0;
                    
                });
                name+="}";
                
                crear_grafica2(now,JSON.parse(name));
            }/*,
            colors:{
            	tacos: '#265a88',
                paella: '#419641',
                ceviche: '#2aabd2',
                mangu: '#eb9316'
            },*/,
            colours:['#2a9bba','#2a4bba','#2abab2','#2aba87','#2aba52','#3fba2a','#ba2a2a','#ba6a2a','#2a63ba','#ba2a76','#2a9bba','#2a4bba','#2abab2','#2aba87','#2aba52','#3fba2a','#ba2a2a','#ba6a2a','#2a63ba','#ba2a76']
            ,
            names:name
        },
        bar:{
        	width: {
        		ratio: 1
        	}
        }
        ,
        legend:{
            hide:false,
            position:'right'
        }
        ,
        
        tooltip: {
            show:true,
            grouped:true,
            format: {
                title: function(x) {
                    return 'DIAS PROMEDIO POR PERFIL';
                },
                value:(d)=>{
                    return d+" dias";
                }
            }
        },
        axis: {
            rotated: false,
            y: {
                label: 'DIAS PROMEDIO'
            },
            x: {
                show: false,
                label: 'PERFILES'
            }
        },
        donut: {
            title: "La comida favorita"
        }
    })
    //crear_grafica2();
}

function pos(contenedor){
    $('#contenedor1').on('mousemove',(evt)=>{
        var dat = {
            x:evt.clientX,
            y:evt.clientY
        }
        var cont = d3.select('#contenedor1');
        var div = cont.append('div');
        var table = div.append('table');
        table.append('tr').append('td').text('hola');
        
    });
    
}


function crear_grafica2(data,nombres){
    $('html,body').animate({
        scrollTop: $("#p_clasif").offset().top
    }, 1000);
    //////console.log(data);
    grafica = c3.generate({
        bindto: "#contenedor1",
        data: {
            type: 'donut',
            //type: 'donut',
            columns: data,
            onclick: function(d){
                $('#p_nov').html(`PROMEDIO POR NOVEDAD (${d.name})`);

                $('#contenedor2').show();
                var suma = 0;
                var nuevos = [];
                var old_data = [];
                var name = "{";
                //////console.log(datos_grafica2)
                //var facmento =  formatear_data2(d.id,dat,'cod_clasif');
                datos_grafica2.forEach((a)=>{
                    if(a.key==d.id.replace('cod_','')){
                        old_data.push(a.values)
                        var nuevo2 = d3.nest()
                        
                        .key((d) => d['cod_nov']).entries(a.values);
                        
                        nuevo2.forEach((res,i)=>{

                            res.values.forEach((res2)=>{
                                suma+=Number(res2.dias_respuesta);
                            });
                            nuevos.push([`cod_${res.key}`,Math.round(suma/res.values.length)])
                            suma = 0;
                    //now.push([`cod_${res.key}`,(Math.round(suma/res.values.length))]);
                    
                    name+=`"cod_${res.key}":"${res.values[0].novedad.trim()}"`;
                    if(!(i==(nuevo2.length - 1))){
                        name+=","
                    }
                    
                    
                });
                        
                        name+="}";
                        
                    }
                });
                
                

                crear_grafica3(nuevos,JSON.parse(name),old_data)
            },
            onmouseover:function(evt){
               // //////console.log($('#'+evt.id));
             //  pos(evt.id)
         }
         
         ,
         names:nombres
     }
     ,
     legend:{
        hide:false,
        position:'right'
    }
    ,
    bar:{
       width: {
          ratio: 1
      }
  },
  tooltip: {
    show:true,
    
    format: {
        title: function(x) {
            return 'DIAS PROMEDIO POR CLASIFICACION';
        },
        value:(d)=>{
            return d+" dias";
        }
    }
},
zoom:{
    rescale:true
},
axis: {
    rotated: false,
    y: {
        label: 'DIAS PROMEDIO'
    },
    x: {
        show: true,
        label: 'PERFILES'
    }
},
pie:{
    format:{
        value:(d)=>{
            return d;
        }
    }
},
donut: {
    labels:{

    }
}
})
    
}


function crear_detalle(data){
    ////console.log($("#art-main").offset().top)
    $('#detalles').show();
    $('html,body').animate({
        scrollTop: $("#p_proc").offset().top
    }, 1000);
    
    $('#detalles').html('');
    var contenedor = d3.select('#detalles');
    var tabla = contenedor.append('table').attr('width','100%').attr('border','1').style('font-size','12px');
    var head = tabla.append('thead').append('tr').attr('align','center').attr('class','fondo00');
    head.append('td').text('Codigo').attr('width','10%').style("text-align","center");
    head.append('td').text('Descripcion').attr('width','30%').style("text-align","center");
    head.append('td').text('Fecha Inicial').attr('width','15%').style("text-align","center");
    head.append('td').text('Fecha Final').attr('width','15%').style("text-align","center");
    head.append('td').text('Dias Respuesta').attr('width','30%').style("text-align","center");
    var tbody = tabla.append('tbody');
    var tr =tbody.selectAll("tr").data(data).enter()
    .append("tr").attr('class',(d,i)=>{
        if(i%2==0){
            return "fondo01";
        }else{
            return "fondo02";
        }
    })
    tr.append("td").text((d,i)=>d.codigo_proceso).style("text-align","center");
    tr.append("td").text((d,i)=>d.problematica.trim()).style("text-align","center");
    tr.append("td").text((d,i)=>d.fec_us_ing).style("text-align","center");
    tr.append("td").text((d,i)=>d.fec_us_mod).style("text-align","center");
    tr.append("td").text((d,i)=>{return d.dias_respuesta+" dias"}).style("text-align","center");
}

function crear_grafica3(dat,name,old_data){

    $('html,body').animate({
        scrollTop: $("#p_nov").offset().top
    }, 1000);
    grafica = c3.generate({
        bindto: "#contenedor2",
        data: {
            type: 'pie',
            //type: 'donut',
            columns: dat,
            
            names:name,
            onclick:function(d){
                $('#p_proc').html(`LISTADO DE DIAS POR PROCESO (${d.name})`)
                var tabla = [];
                old_data[0].forEach((a)=>{
                    if(a.cod_nov == d.id.replace('cod_','')){
                        tabla.push(a)
                    }
                });
                crear_detalle(tabla)
            }
        },
        legend:{
            hide:false,
            position:'right'
        },
        tooltip: {
            show:true,

            format: {
                title: function(x) {
                    return 'DIAS PROMEDIO POR NOVEDAD';
                },
                value:(d)=>{
                    return d+" dias";
                }
            }
        }
    });
}