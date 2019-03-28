<script language="javascript">
$("#add_rotacion").on('submit', function(evt){
	 evt.preventDefault();
	 save_rotacion();
});

</script>

<?php
include_once('../../funciones/funciones.php');
require("../../autentificacion/aut_config.inc.php");
require "../../".class_bd;
require "../../".Leng;

$metodo = $_POST['metodo'];
$archivo = "horarios";
$proced  = 'p_turno';

if($metodo == 'modificar'){
  $titulo = "Modificar ".$leng['rotacion']." ";
	$codigo    = $_POST['codigo'];

	$sql = " SELECT rotacion.codigo, rotacion.abrev,
	                rotacion.descripcion rotacion, rotacion.`status`
	           FROM rotacion
            WHERE rotacion.codigo = '$codigo'
	       ORDER BY 2 ASC ";
	$query         = $bd->consultar($sql);
	$result        = $bd->obtener_fila($query,0);

	$abrev         = $result['abrev'];
	$nombre        = $result['rotacion'];
	$activo        = $result['status'];

	}else{
	  $titulo        = "Agregar ".$leng['rotacion']." ";
		$codigo        = '';
		$abrev         = '';
		$nombre        = '';
		$activo        = 'T';
}

?>
<form action="" method="post" name="add_rotacion" id="add_rotacion">
  <fieldset class="fieldset">
  <legend><?php echo $titulo;?> </legend>
     <table width="95%" align="center">
    <tr>
      <td width="15%" class="etiqueta">C&oacute;digo:</td>
      <td width="35%"><input type="text" name="codigo" id="r_codigo" readonly value="<?php echo $codigo;?>" />
               Activo: <input name="activo" id="activo" type="checkbox"  <?php echo statusCheck("$activo");?> value="T" />
      </td>
      <td width="15%" class="etiqueta">Abrev:</td>
      <td width="35%"><input type="text" name="abrev" id="r_abrev"minlength="2" maxlength="16" required value="<?php echo $abrev;?>" /></td>
	 </tr>
    <tr>
      <td class="etiqueta">Nombre: </td>
      <td colspan="2"><input type="text" name="nombre" id="r_nombre" minlength="4" maxlength="60" required style="width:300px" value="<?php echo $nombre;?>"/></td>

		</tr>
  </table>

<div align="center"><span class="art-button-wrapper">
                    <span class="art-button-l"> </span>
                    <span class="art-button-r"> </span>
                <input type="submit" name="salvar"  id="salvar" value="Guardar" class="readon art-button" />
                </span>&nbsp;
             <span class="art-button-wrapper">
                    <span class="art-button-l"> </span>
                    <span class="art-button-r"> </span>
                <input type="reset" id="limpiar" value="Restablecer" class="readon art-button" />
                </span>&nbsp;

             <span class="art-button-wrapper">
                    <span class="art-button-l"> </span>
                    <span class="art-button-r"> </span>
                <input type="button" id="volver" value="Volver" onClick="Cons_rotacion_inicio()" class="readon art-button" />
                </span>

  		    <input name="metodo" id="h_metodo" type="hidden"  value="<?php echo $metodo;?>" />
             </div>
						 <div id="Cont_detalleR"  class="tabla_sistema">
						 </div>
	</fieldset>

  </form>
