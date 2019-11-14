<script language="javascript">
  $("#add_turno_form").on('submit', function(evt){
    evt.preventDefault();
    save_turno();
  });

  $("#add_turno_form input, select").change(function (evt) { 
    evt.preventDefault();  
    $("#t_cambios").val('true');
    $('#salvar_turno').attr('disabled',false);
  }); 

  $("#bus_turno").on('submit', function(evt){
    evt.preventDefault();
    buscar_turno(true);
  });
</script>
<?php

require "../modelo/turno_modelo.php";
require "../../planif_modelo/modelo/planif_modelo.php";
require "../../../../".Leng;

$turno = new Turno;
$planif_modelo = new Planif_modelo;

$metodo  = $_POST['metodo'];

if($metodo == 'modificar')
{
	$codigo    = $_POST['codigo'];
	$titulo    = "Modificar ".$leng['turno'];
	$tur       =  $turno->editar("$codigo");

}else{
	$titulo    = "Agregar ".$leng['turno'];
	$tur       =  $turno->inicio();
}
$dia_habil   = $planif_modelo->get_dia_habil($tur['cod_dia_habil']);
$horario     = $planif_modelo->get_horario($tur['cod_horario']);
?>
<div id="add_turno">
  <form action="" method="post" name="add_turno" id="add_turno_form">
    <span class="etiqueta_title" id="title_turno"><?php echo $titulo;?></span>
    <span style="float: right;" align="center" >
      <img  style ="display: none;" border="null" width="25px" height="25px" src="imagenes/borrar.bmp" title="Borrar Registro" onclick="Borrar_turno()" id="borrar_turno" />
      <img style="display: none;" border="null" width="25px" height="25px" src="imagenes/nuevo.bmp" alt="Agregar" onclick="irAAgregarTurno()" title="Agregar Registro" id="agregar_turno" />
      <img border="null" width="25px" height="25px" src="imagenes/buscar.bmp" title="Buscar Registro" id="buscar_turno_title" onclick="irABuscarTurno()" />
    </span>
    <table width="90%" align="center">
     <tr>
        <td height="8" colspan="4" align="center"><hr></td>
      </tr>
     <tr>
      <td width="15%" class="etiqueta">C&oacute;digo:</td>
      <td width="35%"><input type="text" name="codigo" id="t_codigo" minlength="2" maxlength="11" required value="<?php echo $tur['codigo'];?>" />
       Activo: <input name="activo" id="t_activo" type="checkbox"  <?php echo statusCheck($tur['status']);?> value="T" />
     </td>
     <td width="15%" class="etiqueta">Abrev:</td>
     <td width="35%"><input type="text" name="abrev" id="t_abrev"minlength="2" maxlength="16" required value="<?php echo $tur['abrev'];?>" /></td>
   </tr>
   <tr>
    <td class="etiqueta">Nombre: </td>
    <td colspan="2"><input type="text" name="nombre" id="t_nombre" minlength="4" maxlength="60" required style="width:300px" value="<?php echo $tur['descripcion'];?>"/></td>
    <td></td>
  </tr>
  <tr>
   <td class="etiqueta">Días Hábiles:</td>
   <td><select name="d_habil" id="t_d_habil" style="width:220px;" required>
    <option value="<?php echo $tur['cod_dia_habil'];?>"><?php echo $tur['dia_habil'];?></option>
    <?php
    foreach ($dia_habil as  $datos)
    {
      echo '<option value="'.$datos[0].'">'.$datos[1].'</option>';
    }?></select><img class="imgLink" src="imagenes\ico_agregar.ico" alt="Agregar Día Hábil" title="Agregar Día Hábil"  onclick="B_d_habil()"  width="20px" height="20px">
  </td>
  <td class="etiqueta"><?php echo $leng['horario'];?>:</td>
  <td><select name="horario" id="t_horario" style="width:220px;" required>
   <option value="<?php echo $tur['cod_horario'];?>"><?php echo $tur['horario'];?></option>
   <?php
   foreach ($horario as  $datos)
   {
    echo '<option value="'.$datos[0].'">'.$datos[1].'</option>';
  }?></select><img class="imgLink" src="imagenes\ico_agregar.ico" alt="Agregar Horas" title="Agregar Horas"  onclick="B_hora()"  width="20px" height="20px">
</td>
</tr>
<tr>
  <td class="etiqueta">Factor:</td>
  <td class="texto">Aumentar (+)<input type = "radio" name="t_factor" value ="aum" required
    style="width:auto" <?php echo CheckX($tur['factor'], 'aum');?> />
    Dismininuir (-)<input type = "radio" name="t_factor" required
    value = "dis" style="width:auto" <?php echo CheckX($tur['factor'], 'dis');?> />
  </td>

  <td class="etiqueta"><?php echo $leng['trabajador']?> Necesario Para Cubrir:</td>
  <td><input type="text" name="trab_cubrir" id="t_trab_cubrir" maxlength="6" style="width:120px" value="<?php echo $tur['trab_cubrir'];?>" />
  </td>
</tr>

<tr>
 <td height="8" colspan="4" align="center"><hr></td>
</tr>
</table>

<div align="center"><span class="art-button-wrapper">
  <span class="art-button-l"> </span>
  <span class="art-button-r"> </span>
  <input type="submit" name="salvar"  id="salvar_turno" value="Guardar" class="readon art-button" />
</span>&nbsp;
<span class="art-button-wrapper">
  <span class="art-button-l"> </span>
  <span class="art-button-r"> </span>
  <input type="reset" id="limpiar_turno" value="Restablecer" class="readon art-button" />
</span>&nbsp;
<input name="metodo" id="t_metodo" type="hidden"  value="<?php echo $metodo;?>" />
<input name="cambios" id="t_cambios" type="hidden"  value="false"/>
</div>
</form>
</div>

<div id="buscar_turno" style="display: none;">
  <form name="bus_turno" id="bus_turno" style="float: right;">
    <input type="text" name="codigo_buscar" id="data_buscar_turno" maxlength="11" placeholder="Escribe aqui para filtrar.. "/>
    <select name="filtro_buscar_turno" id="filtro_buscar_turno" style="width:110px" required>
     <option value="codigo">Código</option>
     <option value="abrev">Abrev</option>
     <option value="descripcion">Nombre</option>
   </select>
   <input type="submit" name="buscarTurno" id="buscarTurno" hidden="">
   <span class="art-button-wrapper">
    <img border="null" width="25px" height="25px" src="imagenes/buscar.bmp" title="Buscar Registro" id="buscarT" onclick="buscar_horario(true);" />
  </span>
</form>
<div class="tabla_sistema listar">
  <span class="etiqueta_title"> Consulta De <?php echo $leng['turno'];?></span>
  <table width="100%" border="0" align="center" id="lista_turnos">
    <thead>
      <tr>
        <th width="10%">Codigo</th>
        <th width="15%">Abrev</th>
        <th width="25%">Nombre</th>
        <th width="45%">Status</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $matriz  =  $turno->get();

      foreach ($matriz as  $datos) {
        echo '<tr onclick="Cons_turno(\''.$datos["codigo"].'\', \'modificar\')" title="Click para Modificar..">
        <td>'.$datos["codigo"].'</td>
        <td>'.$datos["abrev"].'</td>
        <td>'.longitud($datos["descripcion"]).'</td>
        <td>'.statuscal($datos["status"]).'</td>
        </tr>';
      }
      ?>
    </tbody>
  </table>
</div>
<div align="center">
 <span class="art-button-wrapper">
  <span class="art-button-l"> </span>
  <span class="art-button-r"> </span>
  <input type="button" id="volver_turno" value="Volver" onclick="volverTurno()" class="readon art-button" />
</span>
</div>
</div>