<?php
	$Nmenu = '566';
	if(isset($_SESSION['usuario_cod'])){
		require_once('autentificacion/aut_verifica_menu.php');
		$us = $_SESSION['usuario_cod'];
	}else{
		$us = $_POST['usuario'];
	}

require_once("packages/general/index.php");
?>


<input name="usuario" id="usuario" type="hidden"  value="<?php echo $_SESSION['usuario_cod'];?>" />
<script type="text/javascript">
	$(function() {
	Cons_maestro('', 'agregar','ficha_status_militar','CONSULTA GENERAL STATUS MILITAR');
});
</script>
