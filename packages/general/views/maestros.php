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

<script language="javascript">
  $("#form_maestro").on('submit', function(evt){
    evt.preventDefault();
    guardar_registro();
  });
</script>

<div id="myModal" class="modal">
	<div class="modal-content">
		<div class="modal-header">
			<span class="close" onclick="CloseModal()" >&times;</span>
			<span id="modal_titulo"></span>
		</div>
		<div class="modal-body">
			<div>
				<br> 
				<span style="float: right; padding-left: 10px;" align="center" >
					<?php
					echo ' Filtro: <input  id="filtro" type="text" style="width:180px" onkeyup="buscar(this.value,\''.$tabla.'\',\''.$titulo.'\')" />';
					?>
				</span> 
				<br> 
				<br> 
				<br> 
				<table width="95%" align="modal_contenido" class="tabla_planif">
					<thead>
						<tr>
							<th>Codigo</th>
							<th>Descripcion</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody id="contenido_tabla">

					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<div id="Cont_maestro">
<div align="center" class="etiqueta_title"> 
	<?php echo $titulo.'  	   <span style="float: right;" align="center" >
	<img border="null" width="25px" height="25px" src="imagenes/buscar.bmp" title="Buscar Registro" id="buscar_producto_title" onclick="B_maestros(\''.$tabla.'\',\''.$titulo.'\')" />
</span>';?>

</div>
<form id="form_maestro">
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
</div>
</form>

<script type="text/javascript" src ="packages/general/controllers/generalCtrl.js"></script>
<script language="JavaScript" type="text/javascript">
	var tp1 = new Spry.Widget.TabbedPanels("tp1", { defaultTab:<?php echo $pag;?>});
		//var TabbedPanels = new Spry.Widget.TabbedPanels("TabbedPanels");

	</script>