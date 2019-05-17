<link rel="stylesheet" href="css/modal.css" type="text/css" media="screen" />
<script type="text/javascript" src="modulo/rotacion_turno/controllers/rotacionCtrl.js"></script>

<?php
	$Nmenu = '3001';
	require_once('autentificacion/aut_verifica_menu.php');
?>

<div id="myModal" class="modal">
  <div class="modal-content">
    <div class="modal-header">
      <span class="close" onclick="CloseModal()" >&times;</span>
      <span id="modal_titulo">Titulo</span>
    </div>
    <div class="modal-body">
			<div id="modal_contenido">Contenido</div>
    </div>
    </div>
</div>
<div id="Cont_rotacion">
</div>
<input name="usuario" id="usuario" type="hidden"  value="<?php echo $_SESSION['usuario_cod'];?>" />
