<link rel="stylesheet" href="libs/control_fecha/fecha.css">

<?php
require "../model/dotacion_modelo.php";
$listado      = new dotaciones;
$status =  $listado->llenar_status_proceso('P');
$vista        = isset($_POST['view']) ? $_POST['view'] : '';
if ($vista == "clo") {
  $titulo = "Recepcion De Lotes Operaciones";
}

if ($vista == "vla") {
  $titulo = "Consulta De Lotes Almacen";
}

if ($vista == "vlo") {
  $titulo = "Consulta De Lotes Operaciones";
}

if ($vista == "cla") {
  $titulo = "Recepcion De Lotes Almacen";
}


?>
<div align="center" class="etiqueta_title"> <?php echo $titulo; ?></div>
<span style="float:left;margin-top:15px; width:80%">
  <form id="filtros" action="" onsubmit="event.preventDefault()">
    Fecha de Inicio: <input type="button" id="filtro_fecha" value="Buscar" onclick="crear_control(this.id,'f_d','f_h',()=>{crear_data('<?php echo $vista; ?>','filtros')})">
    Codigo: <input type="text" name="filtro_codigo" id="filtro_codigo">
    Status: <select name="filtro_status" id="filtro_status">
      <option value="">TODOS</option>
      <option value="01">INICIADO</option>
      <?php foreach ($status as $key => $value) {
        echo "<option value='" . $value['codigo'] . "'>" . $value['descripcion'] . "</option>";
      } ?>

    </select>
    <img src="imagenes/actualizar.png" title="actualizar" width="20px" height="20px" style="cursor:pointer;float:right;" onclick="crear_data('<?php echo $vista; ?>','filtros')">

    <input type="hidden" name="f_d" id="f_d">
    <input type="hidden" name="f_h" id="f_h">
    <input type="hidden" name="vista" id="vista" value="<?php echo $vista; ?>">
  </form>
</span>
<div id="tabla_info" class="tabla_sistema listar">

</div>

<script src="libs/control_fecha/fecha.js"></script>