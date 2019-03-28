<?php 
$Nmenu   = 309; 
// $archivo = "Ubicacion_Cliente&id=".$id."&Nmenu=".$Nmenu."";
$tabla   ='clientes_ubicacion'; 
require_once('autentificacion/aut_verifica_menu.php');

	$titulo = ' REGIONES ';		
	$codigo  = $_GET['codigo'];
	$tab = 'regiones'; 
	$pestana = 'Regiones';
	$pag = 0;
	/*
	$id = $_GET['id'];
	$tab = $_GET['tb']; 
	$pagina = $_GET['pagina'];
	if (is_numeric($pagina)){
	$pag = $pagina;	
	}else{
	$pag = 0;
	}
*/
?> 
<form action="sc_maestros/sc_maestros2.php" method="post" name="maestros" id="maestros"> 
 <div align="center" class="etiqueta_title"> <?PHP echo $titulo;?> </div>
<div align="center">
					<!--
                    <img src="imagenes/navigate_left2.png" class="imgLink"/>&nbsp;
                    <img src="imagenes/navigate_left.png" class="imgLink"/>&nbsp;
				    <img src="imagenes/navigate_right.png" class="imgLink"/>&nbsp;
					<img src="imagenes/navigate_right2.png" class="imgLink"/>&nbsp;
-->
					<input type="button" id="guardar" class="img_agregar" onclick="Add_maestros()" value=""/>&nbsp;
                    <input type="submit" id="guardar" class="img_guardar" value=""/>&nbsp;
                    <input type="button" id="guardar" class="img_borrar" onclick="BorrarReg()" value=""/>&nbsp;
					<!--
					<img src="imagenes/nuevo.bmp" class="imgLink" onclick="Add_maestros( )"  />&nbsp;
                    <img src="imagenes/borrar.bmp" class="imgLink"  />&nbsp;
					<img src="imagenes/buscar.bmp" class="imgLink" onclick="Buscar()" />--> </div>
 <div class="TabbedPanels" id="tp1">	
	 <ul class="TabbedPanelsTabGroup">	 
		<li class="TabbedPanelsTab">GENERAL</li>		
		<li class="TabbedPanelsTab">BUSCAR O LISTAR</li>
        <li class="TabbedPanelsTab">ADICIONAL</li>
	 </ul>				
	  <div class="TabbedPanelsContentGroup"> 
	  	 <div class="TabbedPanelsContent"><?php include('maestros/maestros.php');?></div>  	  	 
		 <div class="TabbedPanelsContent"><?php include('maestros/maestros_bus.php');?></div>
         <div class="TabbedPanelsContent"><?php include('maestros/maestros_ad.php');?></div>
	  </div>
 </div> 
<div id="Contenedor01"></div>
 </form>
<script language="JavaScript" type="text/javascript">
var tp1 = new Spry.Widget.TabbedPanels("tp1", { defaultTab:<?php echo $pag;?>});
var TabbedPanels = new Spry.Widget.TabbedPanels("TabbedPanels");
</script>