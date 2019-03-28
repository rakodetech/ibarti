
var color = ['#2a9bba','#2a4bba','#2abab2','#2aba87','#2aba52','#3fba2a','#ba2a2a','#ba6a2a','#2a63ba','#ba2a76','#2a9bba','#2a4bba','#2abab2','#2aba87','#2aba52','#3fba2a','#ba2a2a','#ba6a2a','#2a63ba','#ba2a76'];
var g = new GraficasD3(color);
var g2 = new GraficasD3(d3.schemePaired);
var datos;
    
function llenar_data(){
    var parametros = {};
    $.ajax({
		data:  parametros,
		url:   'packages/novedades_resp/views/get_num_perfil.php',
        type:  'post',
        success:  function (response) {
            $('#cargando').remove();
             datos = JSON.parse(response);
             $('#inicial').show();
             llenar_novedades_promedio()
             
             
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);}
        });

}
function llenar_novedades_promedio(){
    
            
            
            var nuevo =  d3.nest()
            .key((d) => d.codigo_perfil).sortKeys(d3.ascending).key((d) => d.cod_clasif).sortKeys(d3.ascending).entries(datos);
            ////console.log("data",nuevo);
            
            var suma_elemento = 0;
            var suma_clasif= 0;
            var suma_perfil= 0;


            var promedio= 0;
            
            var prom_perfil = [];
            var prom_clasif = [];

            var json_prom = [];

            
            nuevo.forEach((res,j)=>{

                res.values.forEach((ras,i)=>{
                    
                    ras.values.forEach((ris)=>{
                       suma_elemento+=Number(ris.dias_respuesta);
                    });
                    prom_clasif[i]= (suma_elemento/ras.values.length);
                    //suma_clasif+=suma_elemento/ras.values.length;
                    
                    suma_elemento =0 ;
                });
                suma_perfil=suma_clasif/res.values.length;
                prom_perfil[j]=prom_clasif;
                prom_clasif=[];
                //suma_clasif = 0;
                
            });
            
            
            nuevo.forEach((res,i)=>{
                prom_perfil[i].forEach((d)=>{
                    suma_perfil+=d;
                });

                ////console.log(res.key,res.values[0]);
                //console.log(res.values[0].values[0].perfil)
                promedio = Math.round(suma_perfil/prom_perfil[i].length);
                suma_perfil=0;

                json_prom.push({"titulo":res.values[0].values[0].perfil,"valor":promedio,"codigo":res.values[0].values[0].codigo_perfil});
                
                suma=0;
                promedio = 0;
            });

            //console.log(json_prom)
            cambiar()
            
            g.crearGraficaBarra(json_prom,900,'contenedor','grafica',false,false,'top','col-md-6','',true,()=>{

                json_prom.forEach((res)=>{
                    
                cod_validador = 'cod' + res.codigo;
                if (d3.select('#' + 'contenedor').select('#' + 'grafica').node()) {
                    var div_grafica = d3.select('#' + 'contenedor').select('#' + 'grafica');
                    var type = div_grafica.attr('type');
                    var svg = d3.select('#' + 'contenedor').select('#' + 'grafica').select('#svg-' + type + '-' + 'grafica');
                    var chart = svg.select('#chart-' + type + '-' + 'grafica');
                    if (type == 'torta') var ley = svg.selectAll('.leyenda-torta').select('#' + cod_validador);
                    else var ley = svg.selectAll('.leyenda-bar').select('#' + cod_validador);
                    ////console.log(cod_validador)
                    ley.on("click",(d)=> {
                        var nueva_data = obtener_fracmento(d,datos,'cod_clasif');
                        llenar_novedades_promedio1(nueva_data)
                       
                    });
                    chart.selectAll('#' + cod_validador)
                    .on("click",(d)=> {
                        
                        var nueva_data = obtener_fracmento(d,datos,'cod_clasif');
                        llenar_novedades_promedio1(nueva_data)
                    });
                }
                });
                
            });
            

            
            ////console.log(json_prom);

       
       // llenar_novedades_promedio1();
       $('#svg-barra-grafica').attr('height','490px');
}

function obtener_fracmento(fracmento,data,filtro){
    var nueva_Data = [];
    data.forEach((res1)=>{
		if(fracmento.codigo==res1.codigo_perfil){
			nueva_Data.push(res1);
		}
    });
    var add_data = d3.nest()
    .key((d) => d[filtro]).entries(nueva_Data);
    return add_data;
}

function llenar_novedades_promedio1(nuevo){
   //console.log(nuevo)
            
         
            ////console.log("data",nuevo);

            var suma= 0;
            var promedio= 0;
            var json_prom = [];
            nuevo.forEach((res,i)=>{
                ////console.log(res,i)
                res.values.forEach((dato)=>{
                    suma+=Number(dato.dias_respuesta);
                });
                promedio = Math.round( suma / res.values.length);

                json_prom.push({"titulo":res.values[0].descripcion_clasif,"valor":promedio,"codigo":res.values[0].cod_clasif});
                
                suma=0;
                promedio = 0;
            });
            
           g.crearGraficaTorta(json_prom,500,'contenedor1','grafica',true,false,'top','col-md-6','',()=>{

            json_prom.forEach((res)=>{
                
            cod_validador = 'cod' + res.codigo;
            if (d3.select('#' + 'contenedor1').select('#' + 'grafica').node()) {
                var div_grafica = d3.select('#' + 'contenedor1').select('#' + 'grafica');
                var type = div_grafica.attr('type');
                var svg = d3.select('#' + 'contenedor1').select('#' + 'grafica').select('#svg-' + type + '-' + 'grafica');
                var chart = svg.select('#chart-' + type + '-' + 'grafica');
                if (type == 'torta') var ley = svg.selectAll('.leyenda-torta').select('#' + cod_validador);
                else var ley = svg.selectAll('.leyenda-bar').select('#' + cod_validador);
               // //console.log(cod_validador)
                ley.on("click",(d)=> {
                    //var nueva_data = obtener_fracmento(d,datos,'cod_clasif');
                    console.log(d.data)
                   
                });
                chart.selectAll('#' + cod_validador)
                .on("click",(d)=> {
                    console.log(d.data)
                });
            }
            });
            
        });
            ////console.log(json_prom);
            
       
}

function transformar_rbg(e,t){
	
	var r,g,b,rgbh;
	r=e.slice(1,3);
	g=e.slice(3,5);
	b=e.slice(5);
	rgbh = `rgb(${parseInt(r,16)},${parseInt(g,16)},${parseInt(b,16)})`;
    transformar_hexa(rgbh)
    
}

function transformar_hexa(e){
    var pedazo;
    var temporal='#' ;;
    pedazo = e.replace('rgb(','').replace(')','').split(',');
    
    pedazo.forEach((d,i)=>{
        temporal = temporal + parseInt(d, 10).toString(16);
    })

//console.log(temporal)
    
}

function cambiar(){
    $('#asas').remove();
    $('#asa').remove();
    
}
