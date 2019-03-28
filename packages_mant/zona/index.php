<script type="text/javascript" src="packages_mant/zona/controllers/zonaCtrl.js"></script>
<?php
	$Nmenu = '348';
	if(isset($_SESSION['usuario_cod'])){
		require_once('autentificacion/aut_verifica_menu.php');
		$us = $_SESSION['usuario_cod'];
	}else{
		$us = $_POST['usuario'];
	}
?>
<div id="Cont_zona">
</div>
<input name="usuario" id="usuario" type="hidden" value="<?php echo $us;?>" />
