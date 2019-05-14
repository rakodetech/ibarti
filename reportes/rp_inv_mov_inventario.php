<?php
$Nmenu   = '577';
$mod     =  $_GET['mod'];
require_once('autentificacion/aut_verifica_menu.php');
require_once('sql/sql_report.php');
$bd = new DataBase();
$archivo = "reportes/rp_inv_mov_inventario_det.php?Nmenu=$Nmenu&mod=$mod";
$titulo  = " MOVIMIENTO DE INVENTARIO ";
?>
<script language="JavaScript" type="text/javascript">

  function Add_productos(almacen){
    $.ajax({
      data: {"codigo": almacen},
      url: 'ajax/Add_stock_productos.php',
      type: 'post',
      success: function(response) {
       $("#productos").html(response);
     },
     error: function(xhr, ajaxOptions, thrownError) {
      alert(xhr.status);
      alert(thrownError);
    }
  });
  }

  function Add_filtroX() {
    var fecha_desde = $("#fecha_desde").val();//'01-12-2018';
    var fecha_hasta = $("#fecha_hasta").val();//'31-12-2018';
    var almacen     = $("#almacen").val();
    var producto    = $("#producto").val();
    var tipo    = $("#tipo").val();

    var error = 0;
    var errorMessage = ' ';
    if( fechaValida(fecha_desde) !=  true || fechaValida(fecha_hasta) != true){
      var errorMessage = ' Campos De Fecha Incorrectas ';
      var error = error+1;
    }

    if(error == 0){
      var parametros = {"fecha_desde":fecha_desde, "fecha_hasta":fecha_hasta, "almacen": almacen, "producto":producto, "tipo": tipo};
      $.ajax({
        data: parametros,
        url: 'ajax_rp/Add_inv_mov_inventario.php',
        type: 'post',
        success: function(response) {
        $(".listar").html(response);
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status);
        alert(thrownError);
      }
    });
    }else{
      alert(errorMessage);
    }
  }
</script>
<div align="center" class="etiqueta_title"><?php echo $titulo;?> </div>
<div id="Contenedor01"></div>
<form name="form_reportes" id="form_reportes" action="<?php echo $archivo;?>"  method="post" target="_blank">
  <hr /><table width="100%" class="etiqueta">
    <tr><td width="10%">Fecha Desde:</td>
     <td width="14%" id="fecha01"><input type="text" name="fecha_desde" id="fecha_desde" size="9" required onclick="javascript:muestraCalendario('form_reportes', 'fecha_desde');">&nbsp;<img src="imagenes/icono-calendario.gif" onclick="javascript:muestraCalendario('form_reportes', 'fecha_desde');" border="0" width="17px"></td>
     <td width="10%">Fecha Hasta:</td>
     <td width="14%" id="fecha02"><input type="text" name="fecha_hasta" id="fecha_hasta" size="9"  required onclick="javascript:muestraCalendario('form_reportes', 'fecha_hasta');">&nbsp;<img src="imagenes/icono-calendario.gif" onclick="javascript:muestraCalendario('form_reportes', 'fecha_hasta');" border="0" width="17px"></td>
     <td width="10%">Almacen: </td>
     <td width="14%">
      <select name="almacen" id="almacen" style="width:120px;" onchange="Add_productos(this.value)" required>
        <option value="TODOS">TODOS</option>
        <?php
        $query01 = $bd->consultar($sql_almacen);
        while($row01=$bd->obtener_fila($query01,0)){
         echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
       }?></select></td>
       <td>Producto: </td>
       <td id="productos"><select name="producto" id="producto" style="width:120px;" onchange="Add_filtroX()">
        <option value="TODOS">TODOS</option>
      </select>
    </td>
    <td width="4%" id="cont_img"><img class="imgLink" src="imagenes/actualizar.png" border="0" onclick="Add_filtroX()">
     <input type="hidden" name="Nmenu" id="Nmenu" value="<?php echo $Nmenu;?>" />
     <input type="hidden" name="mod" id="mod" value="<?php echo $mod;?>" />
     <input type="hidden" name="usuario" id="usuario" value="<?php echo $_SESSION['usuario_cod'];?>"/> 
   </td>
 </tr> 
 <tr>
  <td width="10%">Tipo:</td>
  <td width="14%">
    <select name="tipo" id="tipo" style="width:120px;" required>
      <option value="TODOS">TODOS</option>
      <?php
      $query01 = $bd->consultar($sql_tipo_mov);
      while($row01=$bd->obtener_fila($query01,0)){
       echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
     }?></select>
   </td>
 </tr>
</table><hr />
<div class="listar">
  <!--<table width="100%" border="0" align="center">
    <thead>
      <tr class="fondo00">
        <th width="10%" class="etiqueta">Fecha</th>
        <th width="15%" class="etiqueta">Ajuste</th>
        <th width="20%" class="etiqueta">Almacen</th>
        <th width="25%" class="etiqueta"><?php //echo $leng['producto']?></th>
        <th width="10%" class="etiqueta">Costo</th>
        <th width="10%" class="etiqueta">Importe Acumulado</th>
        <th width="10%" class="etiqueta">Costo Promedio</th>
      </tr>
    </thead>
    <tbody>

    </tbody>
  </table>-->
</div>
<div align="center"><br/>
  <span class="art-button-wrapper">
    <span class="art-button-l"> </span>
    <span class="art-button-r"> </span>
    <input type="button" name="salir" id="salir" value="Salir" onclick="Vinculo('inicio.php?area=formularios/index')"
    class="readon art-button">
  </span>&nbsp;


  <input type="submit" name="procesar" id="procesar" hidden="hidden">
  <input type="text" name="reporte" id="reporte" hidden="hidden">

  <img class="imgLink" id="img_pdf" src="imagenes/pdf.gif" border="0"
  onclick="{$('#reporte').val('pdf');$('#procesar').click();}" width="25px" title="imprimir a pdf">

  <img class="imgLink" id="img_excel" src="imagenes/excel.gif" border="0"
  onclick="{$('#reporte').val('excel');$('#procesar').click();}" width="25px" title="imprimir a excel">
</div>
</form>