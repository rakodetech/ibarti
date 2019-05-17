<?php 
$Nmenu   = 323; 
// $archivo = "Ubicacion_Cliente&id=".$id."&Nmenu=".$Nmenu."";
$tabla   ='foros_categoria'; 
require_once('autentificacion/aut_verifica_menu.php');

	$titulo  = ' CATEGORIA DE FOROS ';		
	$tab     = 'foros_categoria'; 
	$pestana = 'foros_categoria';
	$pag     = 0;

/*
	$limte = $cantidad; 
	
	$result01 = mysql_query("SELECT regiones.id, regiones.descripcion, regiones.campo01, regiones.campo02, 
	                                regiones.campo03, regiones.campo04, regiones.campo05, regiones.campo06,
                                    regiones.`status`
                      FROM regiones LIMIT $limte,1", $cnn);  
	$row01    = mysql_fetch_array($result01);	
*/

?> 
<form action="sc_maestros/sc_maestros2.php" method="post" name="maestros" id="maestros"> 
 <div align="center" class="etiqueta_title"> <?PHP echo $titulo;?> </div>
<div align="center"> <br />
					
                    <img src="imagenes/navigate_left2.ico" onclick="Lim_pag('INC')" class="imgLink"/>&nbsp;
                    <img src="imagenes/navigate_left.ico" onclick="Lim_pag('MEN')" class="imgLink" />&nbsp;
				    <img src="imagenes/navigate_right.ico" onclick="Lim_pag('MAS')" class="imgLink"/>&nbsp;
					<img src="imagenes/navigate_right2.ico" onclick="Lim_pag('FIN')" class="imgLink"/>&nbsp;

					<input type="button" id="agregar" class="img_agregar" onclick="Add_maestros()" value=""/>&nbsp;
                    <input type="submit" id="guardar" class="img_guardar" value=""/>&nbsp;
                    <input type="button" id="borrar" class="img_borrar" onclick="BorrarReg()" value=""/>&nbsp;
</div>
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