


<!--<link rel="stylesheet" type="text/css" href="packages/grafica/css/grafica.css">-->

<link rel="stylesheet" href="packages/novedades_resp/libs/c3.css">


<form name="form_reportes" id="form_reportes" action="<?php echo $archivo;?>"  method="post" target="_blank">

<!--<img style="float:left;" class="imgLink" id="asas" src="imagenes/actualizar.png" border="1" onclick="llenar_novedades_promedio()">
<img style="float:right;" class="imgLink" id="asa" src="imagenes/actualizar.png" border="1" onclick="transformar_rbg('#83d825')">-->


    
    <div id="cargando">Cargando..<img src="imagenes/carga.gif" width="20px"alt=""></div>
    
    <div id="inicial" style="display:none;text-aling:left;" >
    <div id="sin_data" style="display:none;text-aling:center;font-size:20px">SIN DATA</div>
    <p style="float:right"><input type="hidden"  id="f_d" ><input type="hidden" id="f_h"><input type="button" id="gestor_fecha" value="Desde:|Hasta:" onclick="crear_control(this.id,'f_d','f_h',()=>obtener_data())"></p>
    
    <div id="con_data" style="display:none;">
    <div><p aling="center" style="font-size:14px"><b>CONTROL DE DIAS PROMEDIO</b></p></div>
    <p aling="center" style="float:left;" id="p_perfil"><b>PROMEDIO POR PERFIL</b></p><br><br>
    <div id="contenedor" style="width: 100%;
    height: 512px;
    border:1px solid;
    
    
    text-align: center;" ></div><br>
    <p style="float:left;" id="p_clasif" class="dom"><b>PROMEDIO POR CLASIFICACION</b></p><br><br>
    <div id="contenedor1" style="width: 100%;
    height: 512px;
    border:1px solid;
    display:none;
    
    text-align: center;"><p aling="center" style=""></div><br>
    
        <p aling="center" style="float:left;" id="p_nov"><b>PROMEDIO POR NOVEDAD</b></p><br><br>
      <div id="contenedor2" style="width: 100%;
    height: 512px;
    display:none;
    border:1px solid;
    
    text-align: center;"></div><br>
    <p aling="center" style="float:left;" id="p_proc"><b>LISTADO DE DIAS POR PROCESO</b></p><br><br>
    <div id="detalles" class="lista" style="display:none;max-height:300px;
overflow-y:scroll;"></div>
    </div>
    </div>
   
    
    
     <input type="hidden" name="Nmenu" id="Nmenu" value="<?php echo $Nmenu;?>" />
     <input type="hidden" name="mod" id="mod" value="<?php echo $mod;?>" />
     <input type="hidden" name="usuario" id="usuario" value="<?php echo $_SESSION['usuario_cod'];?>"/> 
  

</form>

<!--<script type="text/javascript" src="packages/grafica/js/ib-graficas.js"></script>-->

<script src="packages/novedades_resp/libs/c3.js"></script>

<script src="packages/novedades_resp/controllers/respCtrl2.js"></script>



<script>
    obtener_data();
</script>