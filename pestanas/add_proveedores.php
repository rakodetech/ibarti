<?php 
$metodo = $_GET['metodo'];
$titulo = $_GET['titulo'];
$tabla   = $_GET['tb'];
$archivo = $_GET['archivo'];
$archivo2 = "../inicio.php?area=formularios/Cons_$archivo&Nmenu=".$_GET['Nmenu']."&mod=".$_GET['mod'].""; 

if(isset($_GET['pagina'])){
$pag = $_GET['pagina'];	
}else{
$pag = 0;
}
?> 
<form action="scripts/sc_<?php echo $archivo;?>.php" method="post" name="add" id="add">  
 <div align="center" class="etiqueta_title"> 
	 </div>
 <div class="TabbedPanels" id="tp1">	
	 <ul class="TabbedPanelsTabGroup">	 
		<li class="TabbedPanelsTab">PROVEEDORES</li>
		<li class="TabbedPanelsTab">ADICIONALES</li>
	 </ul>				
	  <div class="TabbedPanelsContentGroup"> 
	  	 <div class="TabbedPanelsContent"><?php include('formularios/add_proveedores.php');?></div>
  	  	 <div class="TabbedPanelsContent"><?php include('formularios/add_proveedores_ad.php');?></div>
	  </div>
 </div> 
</form>
	<script language="JavaScript" type="text/javascript">
		var tp1 = new Spry.Widget.TabbedPanels("tp1", { defaultTab:<?php echo $pag;?>});
		var TabbedPanels = new Spry.Widget.TabbedPanels("TabbedPanels");
    </script>
 