<script type="text/javascript" src="modulo/hora/controllers/horaCtrl.js"></script>
<?php
	$Nmenu = '301';
	if(isset($_SESSION['usuario_cod'])){
		require_once('autentificacion/aut_verifica_menu.php');
		$us = $_SESSION['usuario_cod'];
	}else{
		$us = $_POST['usuario'];
	}
?>
<div id="Cont_hora"></div>
<input name="usuario" id="usuario" type="hidden" value="<?php echo $us;?>" />
