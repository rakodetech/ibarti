<?php 
$metodo = $_POST['metodo'];
$titulo = $_POST['titulo'];
$tabla   = $_POST['tb'];
$codigo  = $_POST['codigo'];
session_start();
$usuario  =$_SESSION['usuario_cod'];
define("SPECIALCONSTANT", true);
require  "../../../autentificacion/aut_config.inc.php";
require_once "../../../".Funcion;
require_once  "../../../".class_bdI;


if(isset($_GET['pagina'])){
$pag = $_GET['pagina'];	
}else{
$pag = 0;
}
?> 


 <div align="center" class="etiqueta_title"> 
	 </div>
 <div class="TabbedPanels" id="tp1">	
	 <ul class="TabbedPanelsTabGroup">	 
		<li class="TabbedPanelsTab"><?php echo $titulo;?></li>
		<li class="TabbedPanelsTab">ADICIONALES</li>
	 </ul>				
	  <div class="TabbedPanelsContentGroup"> 
	  	 <div class="TabbedPanelsContent"><?php include('./Add_maestros.php');?></div>
  	  	 <div class="TabbedPanelsContent"><?php include('./Add_adicionales.php');?></div>
	  </div>
 </div> 


<script type="text/javascript" src ="packages/general/controllers/generalCtrl.js"></script>
	<script language="JavaScript" type="text/javascript">
		var tp1 = new Spry.Widget.TabbedPanels("tp1", { defaultTab:<?php echo $pag;?>});
		var TabbedPanels = new Spry.Widget.TabbedPanels("TabbedPanels");

    </script>