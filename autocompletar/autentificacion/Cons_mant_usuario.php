<?php 
$Nmenu = '002';
require_once('autentificacion/aut_verifica_menu.php');
$archivo = "control";
$metodo  = "modificar";
$mod     = $_GET['mod'];
$titulo  = "MANTENIMIENTO USUARIO ";

if(isset($_GET['pagina'])){
	$pag = $_GET['pagina'];	
	}else{
	$pag = 0;
}?> 
 <div align="center" class="etiqueta_title"> 
<?php echo $titulo;?>
 </div>
 <div class="TabbedPanels" id="tp1">	
	 <ul class="TabbedPanelsTabGroup">	 
		<li class="TabbedPanelsTab">CAMBIAR CLAVE</li>
		<li class="TabbedPanelsTab">NOMINA</li>
	 </ul>				
	  <div class="TabbedPanelsContentGroup">
         <div class="TabbedPanelsContent"><?php include("cont_us_clave.php");?></div>        
  	  	 <div class="TabbedPanelsContent"><?php include("cont_us_nomina.php");?></div>
	  </div>	 
 </div> 
<script language="JavaScript" type="text/javascript">
var tp1 = new Spry.Widget.TabbedPanels("tp1", { defaultTab:<?php echo $pag;?>});
var TabbedPanels = new Spry.Widget.TabbedPanels("TabbedPanels");
</script>