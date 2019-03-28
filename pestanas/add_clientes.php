
<link rel="stylesheet" href="css/modal.css" type="text/css" media="screen" />
<script language="JavaScript" type="text/javascript">
function ModalOpen(){
 $("#myModal").show();
}

function CloseModal(){
 	$("#myModal").hide();
}
</script>
<?php
$codigo   = $_GET['codigo'];
$metodo   = $_GET['metodo'];
$archivo  = $_GET['archivo'];
$archivo2 = "../inicio.php?area=pestanas/add_clientes&codigo=".$codigo."&metodo=".$metodo."&archivo=".$archivo."&Nmenu=".$_GET['Nmenu']."&mod=".$_GET['mod']."";
$inicio   = "inicio.php?area=formularios/Cons_clientes&Nmenu=".$_GET['Nmenu']."&mod=".$_GET['mod']."";

if(isset($_GET['pagina'])){
  $pag = $_GET['pagina'];
}else{
  $pag = 0;
}

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
         <span id="modal_title">Titulo Modal</span>
      </div>
      <div class="modal-body">
  			<div id="contenido_modal">Contenido</div>
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

	 </ul>
	  <div class="TabbedPanelsContentGroup">

	  	 <div class="TabbedPanelsContent"><?php include('formularios/add_clientes.php');?></div>
       <div class="TabbedPanelsContent"><?php include('formularios/add_clientes_ad.php');?></div>
  	   <div class="TabbedPanelsContent"><?php include('formularios/Cons_clientes_ubic.php');?></div>

	  </div>

 </div>

	<script language="JavaScript" type="text/javascript">
		var tp1 = new Spry.Widget.TabbedPanels("tp1", { defaultTab:<?php echo $pag;?>});
		var TabbedPanels = new Spry.Widget.TabbedPanels("TabbedPanels");
    </script>
