<script language="JavaScript" type="text/javascript">
  $("#bus_cliente").on('submit', function(evt){
    evt.preventDefault();
    buscar_cliente(true);
  })
</script>
<?php
require "../modelo/cliente_modelo.php";
require "../../../../".Leng;
$codigo   = $_POST['codigo'];
$metodo   = $_POST['metodo'];

$pag = 0;
$titulo = "";
$cliente = new Cliente;
$proced   = "p_clientes";
if($metodo == 'modificar')
{
  $codigo    = $_POST['codigo'];
  $cl_nombre =  $cliente->get_cl_nombre($codigo);
  $titulo    = "".$leng['cliente']." : ".  $cl_nombre[0]."(".$codigo.")";
  $cl        = $cliente->editar("$codigo");
  $readonly = "readonly";
  $vistas='';

}else{
	$cl   = $cliente->inicio();
  $readonly = "";
  $titulo    = "Agregar ".$leng['cliente'];
  $vistas='display:none;';
}
?>
<div id="myModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close" onclick="CloseModal()" >&times;</span>
      <span id="modal_title"></span>
    </div>
    <div class="modal-body">
     <div id="contenido_modal"></div>
   </div>
 </div>
</div>

<div id="add_cliente">
  <span class="etiqueta_title" id="title_cliente"><?php echo $titulo;?>
  </span>
    <span style="float: right;" align="center" >
      <img  style ="display: none;" border="null" width="25px" height="25px" src="imagenes/borrar.bmp" title="Borrar Registro" onclick="Borrar_cliente()" id="borrar_cliente" />
      <img style="display: none;" border="null" width="25px" height="25px" src="imagenes/nuevo.bmp" alt="Agregar" onclick="irAAgregarCliente()" title="Agregar Registro" id="agregar_cliente" />
      <img border="null" width="25px" height="25px" src="imagenes/buscar.bmp" title="Buscar Registro" id="buscar_cliente_title" onclick="irABuscarCliente()" />
    </span>
  <div class="TabbedPanels" id="tp1">
    <ul class="TabbedPanelsTabGroup">
      <li class="TabbedPanelsTab"><?php echo $leng['cliente'];?></li>
      <li class="TabbedPanelsTab" <?php echo'style="'.$vistas.'"'?> ><?php echo "Contactos ".$leng['cliente'];?></li>
      <li class="TabbedPanelsTab" <?php echo'style="'.$vistas.'"'?> >Datos Adiccionales <?php echo $leng['cliente'];?></li>
      <li class="TabbedPanelsTab" <?php echo'style="'.$vistas.'"'?> ><?php echo $leng['ubicacion'];?></li>
      <li class="TabbedPanelsTab" <?php echo'style="'.$vistas.'"'?> ><?php echo $leng['contratacion'];?></li>
      <li class="TabbedPanelsTab" <?php echo'style="'.$vistas.'"'?> >Vetados</li>
    </ul>

    <div class="TabbedPanelsContentGroup">
     <div class="TabbedPanelsContent"><?php include('p_cliente.php');?></div>
     <div class="TabbedPanelsContent"><?php include('p_cliente_contactos.php');?></div>
     <div class="TabbedPanelsContent"><?php include('p_cliente_ad.php');?></div>
     <div class="TabbedPanelsContent"><?php include('../../cl_ubicacion/index.php');?></div>
     <div class="TabbedPanelsContent"><?php include('../../cl_contratacion/index.php');?></div>
     <div class="TabbedPanelsContent"><?php include('../../cl_vetados/index.php');?></div>
   </div>
 </div>
</div>

<div id="buscar_cliente" style="display: none;">
  <form name="bus_cliente" id="bus_cliente" style="float: right;">
    <input type="text" name="codigo_buscar" id="data_buscar_cliente" maxlength="11" placeholder="Escribe aqui para filtrar.. "/>
    <select name="filtro_buscar_cliente" id="filtro_buscar_cliente" style="width:110px" required>
     <option value="codigo">Código</option>
     <option value="rif"><?php echo $leng["rif"];?></option>
     <option value="nombre">Nombre</option>
   </select>
   <input type="submit" name="buscarCliente" id="buscarCliente" hidden="">
   <span class="art-button-wrapper">
    <img border="null" width="25px" height="25px" src="imagenes/buscar.bmp" title="Buscar Registro" id="buscarC" onclick="buscar_cliente(true);" />
  </span>
</form>
<div class="tabla_sistema listar">
  <span class="etiqueta_title"> Consulta De <?php echo $leng['cliente'];?></span>
  <table width="100%" border="0" align="center" id="lista_clientes">
    <thead>
      <tr>
        <th width="12%">Codigo</th>
        <th width="12%"><?php echo $leng["rif"];?></th>
        <th width="32%">Nombre</th>
        <th width="22%"><?php echo $leng['region'];?></th>
        <th width="14%" >Activo</th>
      </tr>

    </thead>
    <tbody>
      <?php
      $matriz  =  $cliente->get();
      foreach ($matriz as  $datos) {
        echo '<tr onclick="Cons_cliente(\''.$datos[0].'\', \'modificar\')" title="Click para Modificar..">
        <td>'.$datos["codigo"].'</td>
        <td>'.$datos["rif"].'</td>
        <td>'.$datos["nombre"].'</td>
        <td>'.$datos["region"].'</td>
        <td>'.statuscal($datos["status"]).'</td>
        </tr>';
      }
      ?>
    </tbody>
  </table>
</div>
<div align="center">
 <span class="art-button-wrapper">
  <span class="art-button-l"> </span>
  <span class="art-button-r"> </span>
  <input type="button" id="volver_cliente" value="Volver" onclick="volverCliente()" class="readon art-button" />
</span>
</div>

</div>


<script language="JavaScript" type="text/javascript">
  var tp1 = new Spry.Widget.TabbedPanels("tp1", { defaultTab:<?php echo $pag;?>});
  
  if($('#c_metodo').val()=="modificar"){
    consultar_contactos();
  }


  //Comente esta linea porque genera un error que no entiendo
  //var TabbedPanels = new Spry.Widget.TabbedPanels("TabbedPanels");
</script>
