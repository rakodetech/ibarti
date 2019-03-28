<?php
$Nmenu = 439;
require_once('autentificacion/aut_verifica_menu.php');

$metodo = $_GET['metodo'];
$archivo = $_GET['archivo'];
$Nmenu = $_GET['Nmenu'];
$mod   = $_GET['mod'];
$titulo = "PREINGRESO TRABAJADOR";
$archivo2 = "../inicio.php?area=formularios/Cons_$archivo&Nmenu=$Nmenu&mod=$mod";

if(isset($_GET['pagina'])){
$pag = $_GET['pagina'];
}else{
$pag = 0;
}
?>
 <form action="scripts/sc_<?php echo $archivo;?>.php" method="post" name="add" id="add" enctype="multipart/form-data">
 <div align="center" class="etiqueta_title">
	 </div>
 <div class="TabbedPanels" id="tp1">
	 <ul class="TabbedPanelsTabGroup">
		<li class="TabbedPanelsTab"><?php echo $titulo;?></li>
		<li class="TabbedPanelsTab">CHEQUEOS</li>
        <li class="TabbedPanelsTab">REFERENCIAS</li>
        <li class="TabbedPanelsTab">REFERENCIA DE UNIFORME</li>
		<li class="TabbedPanelsTab">ADICIONALES</li>
        <?php if(($_GET["metodo"]) <> "agregar"){ ?>
        <li class="TabbedPanelsTab">CARGAR FOTOS</li>
        <?php } ?>
	 </ul>
	  <div class="TabbedPanelsContentGroup">

	  	 <div class="TabbedPanelsContent"><?php include('formularios/add_ingreso.php');?></div>
	  	 <div class="TabbedPanelsContent"><?php include('formularios/add_ing_chequeo.php');?></div>
  	  	 <div class="TabbedPanelsContent"><?php include('formularios/add_ing_referencia.php');?></div>
  	  	 <div class="TabbedPanelsContent"><?php include('formularios/add_ing_dotacion.php');?></div>
 	     <div class="TabbedPanelsContent"><?php include('formularios/add_adicionales_ad.php');?></div>
         <?php if(($_GET["metodo"]) <> "agregar"){ ?>
         <div class="TabbedPanelsContent"><?php include('formularios/add_adicionales_trab.php');?></div>
        <?php } ?>
	  </div>

 </div>
  </form>
 <form id="pdf" name="pdf" action="" method="post" target="_blank">
      <input type="hidden" name="codigo" value="<?php echo $_GET["codigo"]?>">
 </form>

	<script language="JavaScript" type="text/javascript">
		var tp1 = new Spry.Widget.TabbedPanels("tp1", { defaultTab:<?php echo $pag;?>});
		var TabbedPanels = new Spry.Widget.TabbedPanels("TabbedPanels");
    </script>
