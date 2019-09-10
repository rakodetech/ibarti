	<table width="80%" align="center">
   <tr valign="top">                    
     <td height="23" colspan="2" class="etiqueta_title" align="center">CONTROL DE NOTIFICACIONES</td>
   </tr>
   <tr><td height="8" colspan="2" align="center"><hr></td></tr>			 
   <tr>  
     <td class="etiqueta" width="40%">Dias proyeccion de novedades: </td>
     <td width="60%"><input type="number" required="required" min="1" max="180" name="dias_nov" value="<?php echo $dias_nov_notif ;?>"></td>
   </tr>
   <tr>  
     <td class="etiqueta" width="40%">Intervalo de novedades a actualizar: </td>
     <td width="60%"><input type="number" required="required" min="1" name="min_nov" value="<?php echo $min_nov_notif ;?>"></td>
   </tr>   
   <tr><td height="4" colspan="2" align="center"><hr></td></tr>			  
   <tr valign="top">                    
     <td height="23" colspan="2" class="etiqueta" align="center">Control de Novedades:</td>
   </tr>
   <tr><td height="4" colspan="2" align="center"><hr></td></tr>			  
   <tr>      

   </table>
   <?php
   $i   = 0; 


   $sql="SELECT count(nov_status.codigo) cantidad
   FROM nov_status";
   $query = $bd->consultar($sql);
   $max_dias=$bd->obtener_fila($query);

   $sql = " SELECT nov_status.codigo, nov_status.control_notif_orden AS cod_nov , nov_status.descripcion, nov_status.control_notificaciones, nov_status.color_notificaciones,nov_status.control_notificaciones_res
   FROM nov_status
   ";
   $query = $bd->consultar($sql);

   ?>
   <table width="60%" align="center">
    <tr>
      <td class="etiqueta">Descripcion de notificacion</td>
      <td class="etiqueta">Check Pendientes</td>
      <td class="etiqueta">Check Respuesta</td>
      <td class="etiqueta">Orden de Prioridad</td>
      <td class="etiqueta">Color de notificacion</td>
    </tr>
    <tr><td height="8" colspan="5" align="center"><hr></td></tr>        

    <?php
    
    while($row03=$bd->obtener_fila($query,0)){
//	extract($row03);

     echo '<tr id="cod_'.$row03[0].'">
     <td class="etiqueta">'.$row03[2].'</td>					
     <td><input id ="pend_'.$row03[0].'" name="notificaciones[]" type="checkbox" value="'.$row03[0].'" 
     style="width:auto" '.CheckX(''.$row03[3].'', 'T').' onclick="crear_color(this.value,this.id,`'.$row03[4].'`)" /></td>

     <td><input id ="res_'.$row03[0].'" name="notificaciones_resp[]" onclick="validar_check(this.value,this.id)" type="checkbox" value="'.$row03[0].'" 
     style="width:auto" '.CheckX(''.$row03[5].'', 'T').' /></td>
     <td><input type="number"  required="required" name="'.$row03[0].'" style="width:100px" min="1" max="'.$max_dias['cantidad'].'" value="'.$row03[1].'"></td>
     
     ';
     
     if($row03[3]!='F'){
      echo '<td id="color_'.$row03[0].'"><input name = "colores[]"  type="color" value="'.$row03[4].'"></td>';
    }
   }	
  

   echo '</tr></table>';	
   
   mysql_free_result($query);?>
   <table width="80%" align="center"><tr><td height="8" colspan="2" align="center"><hr></td></tr></table>
   <div align="center"><span class="art-button-wrapper">
    <span class="art-button-l"> </span>
    <span class="art-button-r"> </span>
    <input type="submit" name="salvar"  id="salvar" value="Guardar" class="readon art-button" />	
  </span>&nbsp;
  <span class="art-button-wrapper">
    <span class="art-button-l"> </span>
    <span class="art-button-r"> </span>
    <input type="reset" id="limpiar" value="Restablecer" class="readon art-button" />	
  </span>&nbsp;
  <span class="art-button-wrapper">
    <span class="art-button-l"> </span>
    <span class="art-button-r"> </span>
    <input type="button" id="volver" value="Volver" onClick="history.back(-1);" class="readon art-button" />	
  </span>           
</div> 

<script>
function crear_color(codigo,cod,color){
  
  if ($('#'+cod).is(':checked') ) {
    $('#cod_'+codigo).append('<td id="color_'+ codigo +'"><input name = "colores[]"  type="color" value="'+color+'" ></td>')
  }else{
    $('#color_'+codigo).remove();
  }

  validar_check(codigo,cod)
} 

function validar_check(codigo,cod){
  var index = cod.replace("_"+codigo,"");
  var index2 = "";
  if(index=="pend"){
    index2=cod.replace(index,'res');
  }else{
    index2=cod.replace(index,'pend');
    $('#color_'+codigo).remove();

  }
  $('#'+index2).prop('checked',false);
}
</script>