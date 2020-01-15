<?php 

require "../modelo/general_modelo.php";
session_start();
$metodo = $_POST['metodo'];
$titulo = $_POST['titulo'];
$tabla   = $_POST['tb'];
$codigo  = $_POST['codigo'];
$us = $_SESSION['usuario_cod'];
if(isset($_GET['pagina'])){
	$pag = $_GET['pagina'];	
}else{
	$pag = 0;
}
if($metodo == 'modificar'){
  $disabled = "disabled=\"disabled\"";
	$codigo = $_POST['codigo'];

$modelo = new General;
$result  =  $modelo->get_maestro($tabla,$codigo);
	  	   
	$codigo      = $result['codigo'];
	$codigo_onblur = "";
	$descripcion = $result['descripcion'];
	$campo01     = $result['campo01'];
	$campo02     = $result['campo02'];
	$campo03     = $result['campo03'];
	$campo04     = $result['campo04'];
	$status      = $result['status'];
	}else{
$disabled = "";
	$codigo      = '';	
	$codigo_onblur = "Add_ajax_maestros(this.value, 'ajax/validar_maestros.php', 'Contenedor', '$tabla')";
	$descripcion = '';
	$campo01     = '';
	$campo02     = '';
	$campo03     = '';
	$campo04     = '';
	$status      = 'T';
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
					echo ' Filtro: <input  id="filtro" type="text" style="width:180px" onkeyup="buscar(this.value)" />';
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
		<?php echo $titulo; ?>

	</div>
	<form id="form_maestro">
		<span style="float: right;" align="center" >
			<img  style ="display: none;" border="null" width="25px" height="25px" src="imagenes/borrar.bmp" title="Borrar Registro" onclick="borrarMaestro()" id="borrar_maestro" />
			<img style="display: none;" border="null" width="25px" height="25px" src="imagenes/nuevo.bmp" alt="Agregar" onclick="irAAgregarMaestro()" title="Agregar Registro" id="agregar_maestro" />
			<span style="float: right;" align="center" >
			<img border="null" width="25px" height="25px" src="imagenes/buscar.bmp" title="Buscar Registro" id="buscar_producto_title" onclick="B_maestros()" />
			<input type="hidden" id="tabla" value="<?php echo $tabla;?>">
			<input type="hidden" id="usuario" value="<?php echo $us;?>">
			</span>'
		</span>
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