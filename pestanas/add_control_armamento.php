<?php
$metodo = $_GET['metodo'];
$titulo = $_GET['titulo'];
$archivo = $_GET['archivo'];
$Nmenu = $_GET['Nmenu'];
$mod   = $_GET['mod'];
$archivo2 = "../inicio.php?area=formularios/Cons_$archivo&Nmenu=".$Nmenu."&mod=".$mod.""; 

if(isset($_GET['pagina'])){
$pag = $_GET['pagina'];	
}else{
$pag = 0;
}?> 
<form action="scripts/sc_<?php echo $archivo;?>.php" method="post" name="add" id="add" enctype="multipart/form-data">  
 <div align="center" class="etiqueta_title"> 
	 </div>
 <div class="TabbedPanels" id="tp1">	
	 <ul class="TabbedPanelsTabGroup">	 
		<li class="TabbedPanelsTab"><?php echo $titulo;?></li>
		<li class="TabbedPanelsTab">ADICIONALES</li>
	 </ul>				
	  <div class="TabbedPanelsContentGroup"> 
	  	 <div class="TabbedPanelsContent"><?php include('formularios/add_control_armamento.php');?></div>
  	  	 <div class="TabbedPanelsContent"><?php include('formularios/add_adicionales_ad.php');?></div>
	  </div>
 </div> 
</form>
	<script language="JavaScript" type="text/javascript">
		var tp1 = new Spry.Widget.TabbedPanels("tp1", { defaultTab:<?php echo $pag;?>});
		var TabbedPanels = new Spry.Widget.TabbedPanels("TabbedPanels");
    </script>
