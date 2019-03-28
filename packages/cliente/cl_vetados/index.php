<script type="text/javascript" src="packages/cliente/cl_vetados/controllers/vetadosCtrl.js"></script>
<link rel="stylesheet" href="css/modal.css" type="text/css" media="screen" />
<script type="text/javascript" src="funciones/modal.js"></script>
<?php
$Nmenu = '436';
if(isset($_SESSION['usuario_cod'])){
	require_once('autentificacion/aut_verifica_menu.php');
	$us = $_SESSION['usuario_cod'];
}else{
	$us = $_POST['usuario'];
}
?>
<div class="modal" id="add_vetado">
	<div class="modal-content">
		<div class="modal-header">
			<span class="close" onclick="$('#add_vetado').hide()" >&times;</span>
			<span id="modal_titulo_add_vetado"></span>
		</div>
		<div class="modal-body">
			<div id="modal_contenido_add_vetado"></div>
		</div>
	</div>
</div>

<div id="Cont_vetados"></div>
<input type="hidden" id="cont_cliente" value="<?php echo $_POST['codigo'];?>">
<input name="usuario" id="usuario" type="hidden" value="<?php echo $us;?>" />