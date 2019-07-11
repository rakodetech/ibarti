<?php
//session_start();
$vista = (isset($_GET['view'])) ? $_GET['view'] : '';
$metodo = (isset($_GET['metodo'])) ? $_GET['metodo'] : 'agregar';
$usuario = $_SESSION['usuario_cod'];

?>
<link rel="stylesheet" href="css/modal_planif.css" type="text/css" media="screen" />
<script src="packages/dotacion_movimiento/controllers/doc_mov.js"></script>
<script type="text/javascript" src="funciones/modal.js"></script>

<div id="myModal" class="modal">
  <div class="modal-content">
    <div class="modal-header">
      <span class="close" onclick="CloseModal()">&times;</span>
      <span id="modal_titulo"></span>
    </div>
    <div class="modal-body">
      <div id="modal_contenido"></div>
    </div>
  </div>
</div>
<div id="contendor">

  <?php

  ?>

</div>
<div>
<input type="button" value="consultar" onclick="tabla_status_dotacion()">
  <input type="hidden" name="us" id="us" value="<?php echo $usuario; ?>">
  <input type="hidden" name="us" id="view" value="<?php echo $vista; ?>"></div>
<script>
  var vista = document.getElementById("view").value;
  cons_inicio(vista, '');
</script>