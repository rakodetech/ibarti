
<link rel="stylesheet" href="css/modal.css" type="text/css" media="screen" />
<script language="JavaScript" type="text/javascript">
function ModalOpen(){
 $("#myModal").show();
}

function CloseModal(){
 	$("#myModal").hide();
}


$("#add_cliente").on('submit', function(evt){
	 evt.preventDefault();
	 save_cliente();
});

$("#add_cliente_ad").on('submit', function(evt){
	 evt.preventDefault();
	 save_cliente();
});
</script>
<?php

include_once('../../../funciones/funciones.php');
require("../../../autentificacion/aut_config.inc.php");
require "../../../".class_bd;
require "../../../".Leng;

$codigo   = $_POST['codigo'];
$metodo   = $_POST['metodo'];
/*
if(isset($_GET['pagina'])){
  $pag = $_GET['pagina'];
}else{
  $pag = 0;
}
*/
  $pag = 0;
$cl = "";
if ($metodo != "agregar" ){
	$sql    = " SELECT nombre  FROM clientes WHERE codigo = '$codigo' ";
  $query = $bd->consultar($sql);
  $row00=$bd->obtener_fila($query,0);
  $cl = 	"".$leng['cliente']." : ".$row00[0]."(".$codigo.")";
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

  <div align="center" class="etiqueta_title">
  <?php echo $cl; ?>
  </div>
 <div align="center" class="etiqueta_title">
	 </div>
 <div class="TabbedPanels" id="tp1">
	 <ul class="TabbedPanelsTabGroup">
		<li class="TabbedPanelsTab"><?php echo $leng['cliente'];?></li>
    <li class="TabbedPanelsTab">Datos Adiccionales <?php echo $leng['cliente'];?></li>
    <li class="TabbedPanelsTab"><?php echo $leng['ubicacion'];?></li>
    <li class="TabbedPanelsTab"><?php echo $leng['contratacion'];?></li>
	 </ul>
	  <div class="TabbedPanelsContentGroup">
	  	 <div class="TabbedPanelsContent"><?php include('p_cliente.php');?></div>
       <div class="TabbedPanelsContent"><?php include('p_cliente_ad.php');?></div>
  	   <div class="TabbedPanelsContent"><?php include('../../cl_ubicacion/index.php');?></div>
       <div class="TabbedPanelsContent"><?php include('../../cl_contratacion/index.php');?></div>
	  </div>

 </div>
	<script language="JavaScript" type="text/javascript">
		var tp1 = new Spry.Widget.TabbedPanels("tp1", { defaultTab:<?php echo $pag;?>});
		var TabbedPanels = new Spry.Widget.TabbedPanels("TabbedPanels");
    </script>
