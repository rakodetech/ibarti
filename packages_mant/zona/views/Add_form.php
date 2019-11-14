<script language="javascript">
$("#zona_form").on('submit', function(evt){
	 evt.preventDefault();
	 save_zona();
});
	</script>
<?php

define("SPECIALCONSTANT", true);
include_once('../../../funciones/funciones.php');
require "../../../autentificacion/aut_config.inc.php";
require_once "../../../".class_bdI;
require "../../../".Leng;

	$proced      = "p_clientes_ubic";
  $codigo      = $_POST['codigo'];
	$metodo      = $_POST['metodo'];
if($metodo == 'modificar'){
$titulo = "Modificar ".$leng['zona'];
	$bd = new DataBase();
	$sql = " SELECT zonas.*, CONCAT(men_usuarios.apellido,' ' ,men_usuarios.nombre) us_mod
	           FROM zonas LEFT JOIN men_usuarios ON zonas.cod_us_mod = men_usuarios.codigo
              AND zonas.codigo = '$codigo'";

	$query = $bd->consultar($sql);
	$result=$bd->obtener_fila($query,0);

	$codigo       = $result["codigo"];
	$descripcion  = $result["descripcion"];
	$campo01      = $result["campo01"];
	$campo02      = $result["campo02"];
	$campo03      = $result["campo03"];
	$campo04      = $result["campo04"];
	$activo       = $result["status"];

	}else{
	$titulo = "Agregar ".$leng['zona'];
	$codigo       = '';
	$descripcion  = '';
	$campo01      = '';
	$campo02      = '';
	$campo03      = '';
	$campo04      = '';
	$activo       = 'T';
	}
?>

<form id="zona_form" name="zona_form" method="post">
<fieldset class="fieldset">
  <legend>Datos <?php echo $titulo;?></legend>
     <table width="90%" align="center">
    <tr>
      <td width="16%" class="etiqueta">C&oacute;digo:</td>
      <td width="34%"><input type="text" id="z_codigo"  maxlength="11" size="15" value="<?php echo $codigo;?>" required  />
               Activo: <input id="z_activo" name="z_activo" type="checkbox"  <?php echo statusCheck("$activo");?> value="T" />
      </td>

      <td width="16%" class="etiqueta">descripcion: </td>
      <td width="34%"><input type="text" id="z_descripcion" maxlength="60" size="30" required value="<?php echo $descripcion;?>"/>
      </td>
    </tr>

    <tr>
      <td class="etiqueta">Campo Adiccional 01:</td>
      <td><input type="text" id="z_campo01" value="<?php echo $campo01;?>" maxlength="60"></td>
			<td class="etiqueta">Campo Adiccional 02:</td>
      <td><input type="text" id="z_campo02" value="<?php echo $campo02;?>" maxlength="60"></td>
    </tr>
		<tr>
			<td class="etiqueta">Campo Adiccional 03:</td>
			<td><input type="text" id="z_campo03" value="<?php echo $campo03;?>" maxlength="60"></td>
			<td class="etiqueta">Campo Adiccional 04:</td>
			<td><input type="text" id="z_campo04" value="<?php echo $campo04;?>" maxlength="60"></td>
		</tr>
	 <tr>
       <td height="8" colspan="4" align="center"><hr></td>
    </tr>
  </table>
	<div align="center"><br/>
		 <span class="art-button-wrapper">
		 			 <span class="art-button-l"> </span>
		 			 <span class="art-button-r"> </span>
		 			<input type="submit" name="salvar"  id="salvar" value="Guardar" class="readon art-button" />
		 	 </span>&nbsp;

		<span class="art-button-wrapper">
				 <span class="art-button-l"> </span>
				 <span class="art-button-r"> </span>
		 <input type="button" id="volver" value="volver" onClick="Cons_zona_inicio()" class="readon art-button" />
		 </span>
	</div>
	 <input name="metodo" id="z_metodo" type="hidden"  value="<?php echo $metodo;?>" />

	   </fieldset>
</form>
