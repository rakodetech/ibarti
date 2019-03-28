<?php 
$metodo = $_GET['metodo'];
$archivo = $_GET['archivo'];
$titulo = "PRODUCTOS";
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
		<li class="TabbedPanelsTab">PRODUCTOS</li>
    	<!-- <li class="TabbedPanelsTab">STOCK</li>  -->
      	<li class="TabbedPanelsTab">PRECIO</li>
   		<li class="TabbedPanelsTab">ADICIONALES</li>
	 </ul>				
	  <div class="TabbedPanelsContentGroup"> 
	  	 <div class="TabbedPanelsContent"><?php include('formularios/add_productos.php');?></div>
  	  	<!-- <div class="TabbedPanelsContent"><?php //include('formularios/add_productos_stock.php');?></div> -->
  	  	 <div class="TabbedPanelsContent"><?php include('formularios/add_productos_precio.php');?></div>         
  	  	 <div class="TabbedPanelsContent"><?php include('formularios/add_productos_ad.php');?></div>
	  </div>
 </div> 
</form>
	<script language="JavaScript" type="text/javascript">
		var tp1 = new Spry.Widget.TabbedPanels("tp1", { defaultTab:<?php echo $pag;?>});
		var TabbedPanels = new Spry.Widget.TabbedPanels("TabbedPanels");
    </script>
 