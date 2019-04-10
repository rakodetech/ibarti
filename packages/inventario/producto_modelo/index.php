<link rel="stylesheet" type="text/css" href="latest/stylesheets/autocomplete.css" />
<link rel="stylesheet" href="css/modal_planif.css" type="text/css" media="screen" />
<script type="text/javascript" src="packages/inventario/producto_modelo/controllers/productoModeloCtrl.js"></script>
<?php
	$Nmenu = '704';
	if(isset($_SESSION['usuario_cod'])){
		require_once('autentificacion/aut_verifica_menu.php');
		$us = $_SESSION['usuario_cod'];
	}else{
		$us = $_POST['usuario'];
	}
?>
<div id="myModal" class="modal">
  <div class="modal-content">
    <div class="modal-header">
      <span class="close" onclick="CloseModal()" >&times;</span>
      <span id="modal_titulo"></span>
    </div>
    <div class="modal-body">
		<div id="modal_contenido"></div>
    </div>
    </div>
</div>

<div id="Cont_producto_modelo"></div>
<input name="usuario" id="usuario" type="hidden"  value="<?php echo $_SESSION['usuario_cod'];?>" />

<script type="text/javascript" src="latest/scripts/autocomplete.js"></script>
<script type="text/javascript" src="funciones/modal.js"></script>
