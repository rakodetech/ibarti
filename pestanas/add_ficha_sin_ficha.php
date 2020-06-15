<?php 
$Nmenu = 423; 
require_once('autentificacion/aut_verifica_menu.php');

$codigo = $_GET['codigo'];
$metodo = $_GET['metodo'];
$mod    = $_GET['mod'];
$area   = $_GET['area'];
	
	if ($metodo == 'agregar' ){
	$sql    = " SELECT preingreso.nombres  FROM preingreso WHERE cedula = '$codigo' ";

	}else{
	$sql    = " SELECT v_ficha.nombres  FROM v_ficha WHERE v_ficha.cod_ficha = '$codigo' ";		
	}

	if($_SESSION['ficha_preingreso'] =="S"){
    $query = $bd->consultar($sql);
	$row00=$bd->obtener_fila($query,0);			
	$trab = 	" TRABAJADOR: ".$row00[0]." (".$codigo.")";
	}else{
	$trab = "";	
	}

if(isset($_GET['pagina'])){
$pag = $_GET['pagina'];	
}else{
$pag = 0;
}
?> 
	 <div align="center" class="etiqueta_title"> 
	 <?php echo $trab; ?>	 
	 </div>
     
    <div class="TabbedPanels" id="tp1">	
	 <ul class="TabbedPanelsTabGroup">	 
		<li class="TabbedPanelsTab">FICHA</li>
		<li class="TabbedPanelsTab">REFERENCIA DE UNIFORME</li>
		<li class="TabbedPanelsTab">CARGA FARMILIAR</li>		
		<li class="TabbedPanelsTab">RECEPCION DE DOCUMENTOS</li>
	 </ul>				
	  <div class="TabbedPanelsContentGroup"> 
         <div class="TabbedPanelsContent"><?php include('formularios/add_ficha_01.php');?></div>         
  	  	 <div class="TabbedPanelsContent"><?php include('formularios/add_ficha_02.php');?></div>
		 <div class="TabbedPanelsContent"><?php include('formularios/add_ficha2_03.php');?></div>
		 <div class="TabbedPanelsContent"><?php include('formularios/add_ficha2_04.php');?></div>
	  </div>
 </div> 
<script language="JavaScript" type="text/javascript">
var tp1 = new Spry.Widget.TabbedPanels("tp1", { defaultTab:<?php echo $pag;?>});
var TabbedPanels = new Spry.Widget.TabbedPanels("TabbedPanels");
</script>