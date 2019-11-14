<script type="text/javascript" src="modulo/dia_habil/controllers/dia_habilCtrl.js"></script>
<?php
	$Nmenu = '301';
	if(isset($_SESSION['usuario_cod'])){
		require_once('autentificacion/aut_verifica_menu.php');
		$us = $_SESSION['usuario_cod'];
	}else{
		$us = $_POST['usuario'];
	}
?>
<div id="Cont_dia_habil">
</div>
<input name="usuario" id="usuario" type="hidden" value="<?php echo $us;?>" />
