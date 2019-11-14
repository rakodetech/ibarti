<link rel="stylesheet" href="css/modal_planif.css" type="text/css" media="screen" />

<?php
$Nmenu = '341';
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

<div id="Contenedor"></div>
<input name="usuario" id="usuario" type="hidden" value="<?php echo $us;?>" />
<script type="text/javascript" src="funciones/modal.js"></script>
<script type="text/javascript" src="packages/mant/novedades/perfiles/controllers/perfilesCtrl.js"></script>