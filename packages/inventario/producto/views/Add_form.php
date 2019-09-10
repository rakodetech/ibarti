<script language="javascript">
  $("#add").on('submit', function(evt){
    evt.preventDefault();
    save_producto();
  });
</script>
<?php
require "../modelo/producto_modelo.php";
require "../../../../".Leng;
$codigo   = $_POST['codigo'];
$metodo   = $_POST['metodo'];

$pag = 0;
$producto = new Producto;
$proced   = "p_productos";
if($metodo == 'MODIFICAR' || ($metodo == "AGREGAR" && $codigo != ""))
{
  $titulo    = $metodo." PRODUCTO (".$codigo.")";
  $prod        = $producto->editar($codigo);
}else{
  $prod   = $producto->inicio();
  $titulo    = $metodo." PRODUCTO";
}
$activo = $prod['status'];
$ean = $prod['ean'];
?>

<div id="add_producto">
  <form method="post" name="add" id="add">  
    <span class="etiqueta_title" id="title_producto"><?php echo $titulo;?></span>
    <span style="float: right;" align="center" >
      <img  style ="display: none;" border="null" width="25px" height="25px" src="imagenes/borrar.bmp" title="Borrar Registro" onclick="Borrar_producto()" id="borrar_producto" />
      <img style="display: none;" border="null" width="25px" height="25px" src="imagenes/nuevo.bmp" alt="Agregar" onclick="irAAgregarProducto()" title="Agregar Registro" id="agregar_producto" />
      <img border="null" width="25px" height="25px" src="imagenes/buscar.bmp" title="Buscar Registro" id="buscar_producto_title" onclick="B_productos()" />
    </span>
    <div class="TabbedPanels" id="tp1">  
     <ul class="TabbedPanelsTabGroup">   
      <li class="TabbedPanelsTab">PRODUCTO</li>
      <li class="TabbedPanelsTab">STOCK</li>
      <li class="TabbedPanelsTab">PRECIO</li>
      <li class="TabbedPanelsTab">ADICIONALES</li>
      <li class="TabbedPanelsTab" id="tab_ean" style="display: none;">EAN</li>
    </ul>        
    <div class="TabbedPanelsContentGroup"> 
     <div class="TabbedPanelsContent"><?php include('add_productos.php');?></div>
     <div class="TabbedPanelsContent"><?php include('add_productos_stock.php');?></div>
     <div class="TabbedPanelsContent"><?php include('add_productos_precio.php');?></div>         
     <div class="TabbedPanelsContent"><?php include('add_productos_ad.php');?></div>
     <div class="TabbedPanelsContent"><?php include('add_productos_EAN.php');?></div>
   </div>
 </div> 
 <input type="hidden" name="metodo" id="p_metodo">
</form>
</div>
<div id="buscar_producto" style="display: none;">
  <span class="etiqueta_title" id="title_producto">CONSULTA PRODUCTOS</span>
  <fieldset>
    <legend>Filtros:</legend>
    <table width="100%">
      <tr><td width="12%">Linea: </td>
        <td width="18%">
          <select name="linea" id="linea" onchange="Add_Sub_Linea(this.value, 'contenido_sub_linea', 'T', '120')" style="width:120px">
            <option value="TODOS">TODOS</option> 
            <?php  
            $lineas  =  $producto->get_lineas();
            foreach ($lineas as  $datos) {
              echo '<option value="'.$datos[0].'">'.$datos[1].'</option>';
            }
            ?>          
          </select>
        </td>
        <td width="12%">Sub Linea: </td>
        <td width="18%" id="contenido_sub_linea"><select name="sub_linea" id="sub_linea" style="width:120px;">
          <option value="TODOS">TODOS</option></select></td>
          <td width="12%">Producto Tipo: </td>
          <td width="18%"><select  name="prod_tipo" id="prod_tipo" style="width:120px;">
            <option value="TODOS">TODOS</option> 
            <?php  
            $tipos  =  $producto->get_tipos();
            foreach ($tipos as  $datos) {
              echo '<option value="'.$datos[0].'">'.$datos[1].'</option>';
            }
            ?></select></td>                              
            <td width="10%" id="cont_img"><img class="imgLink" id="img_actualizar" src="imagenes/actualizar.png" border="0" onclick=" buscar()"/></td>
          </tr>
          <tr>
            <td>Ult. Movimiento: </td>
            <td ><select name="tipo_mov" id="tipo_mov" style="width:120px;">
              <option value="TODOS">TODOS</option> 
              <?php 
              $tipos_mov  =  $producto->get_tipo_mov();
              foreach ($tipos_mov as  $datos) {
                echo '<option value="'.$datos[0].'">'.$datos[1].'</option>';
              }?></select></td>


              <td>Filtro Producto.:</td>  
              <td id="select01">
                <select id="paciFiltro" onchange="EstadoFiltro(this.value)" style="width:120px">
                  <option value="TODOS"> TODOS</option>
                  <option value="codigo">codigo</option>
                  <option value="serial">Serial</option>
                  <option value="descripcion">Descripcion</option>
                </select></td>
                <td>Producto:</td> 

                <td colspan="4"><input  id="stdName" type="text" style="width:180px" disabled="disabled" />
                  <input type="hidden" name="trabajador" id="stdID" value=""/></td> 
                </tr> 
              </table>
            </fieldset>
            <div>
              <table class="tabla_hover" width="100%" border="0" align="center">
                <thead>
                  <tr class="fondo00">
                    <th width="10%" class="etiqueta">Codigo</th>
                    <th width="10%" class="etiqueta">Serial</th>
                    <th width="26%" class="etiqueta">Producto</th>
                    <th width="16%" class="etiqueta">Linea</th>
                    <th width="16%" class="etiqueta">Sub Linea</th>
                    <th width="16%" class="etiqueta">Ult. Movimiento</th>
                    <th width="10%" class="etiqueta">Status</th>
                  </tr>
                </thead>
                <tbody id="lista_productos">
                </tbody>
              </table>   
            </br>
          </div>
          <div align="center">
            <span class="art-button-wrapper">
              <span class="art-button-l"> </span>
              <span class="art-button-r"> </span>
              <input type="button" id="volver" value="Volver" class="readon art-button" onclick="volver()" /> 
            </span>   
          </div>
        </div>
        <script language="JavaScript" type="text/javascript">
          var tp1 = new Spry.Widget.TabbedPanels("tp1", { defaultTab:<?php echo $pag;?>});
          filtroId = document.getElementById("paciFiltro");
          filtroIndice = filtroId.selectedIndex;
          filtroValue  = filtroId.options[filtroIndice].value; 

          new Autocomplete("stdName", function() { 
            this.setValue = function(id) {
            document.getElementById("stdID").value = id; // document.getElementsByName("stdID")[0].value = id;
          }
          if (this.isModified) this.setValue("");
          if (this.value.length < 1) return ;
          return "autocompletar/tb/producto.php?q="+this.text.value +"&filtro="+filtroValue+""});

          new Autocomplete("p_codigo", function() { 
            this.setValue = function(id) {
              document.getElementById("stdID").value = id; // document.getElementsByName("stdID")[0].value = id;
              Cons_producto(id,'AGREGAR');
          }
          if (this.value.length < 1) return ;
          return "autocompletar/tb/producto_base.php?q="+this.text.value +"&filtro=codigo"});
        </script>
