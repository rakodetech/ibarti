<script language="javascript">
$("#cl_contratacion_form").on('submit', function(evt){
	 evt.preventDefault();
	 save_contratacion();
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
$titulo = "Modificar ".$leng['contratacion'];
	$bd = new DataBase();
	$sql = " SELECT * FROM clientes_contratacion
	          WHERE clientes_contratacion.codigo = '$codigo' ";

	$query = $bd->consultar($sql);
	$result=$bd->obtener_fila($query,0);

	$codigo       = $result["codigo"];
	$descripcion  = $result["descripcion"];
	$fec_inicio   = $result["fecha_inicio"];
	$fec_fin      = $result["fecha_fin"];
	$activo       = $result["status"];

	}else{
	$titulo = "Agregar ".$leng['contratacion'];
	$codigo       = '';
	$descripcion  = '';
	$fec_inicio   = '';
	$fec_fin      = '';
	$activo       = 'T';
	}
?>


<fieldset class="fieldset">
  <legend>Datos <?php echo $titulo;?></legend>
	<form id="cl_contratacion_form" name="cl_contratacion_form" method="post">
     <table width="90%" align="center">
    <tr>
      <td width="16%" class="etiqueta">C&oacute;digo:</td>
      <td width="34%"><input type="text" id="cont_codigo"  maxlength="11" size="15" value="<?php echo $codigo;?>" readonly  />
               Activo: <input id="cont_activo" name="cont_activo" type="checkbox"  <?php echo statusCheck("$activo");?> value="T" />
      </td>

      <td width="16%" class="etiqueta">descripcion: </td>
      <td width="34%"><input type="text" id="cont_descripcion" maxlength="60" size="30" required value="<?php echo $descripcion;?>"/>
      </td>
    </tr>

    <tr>
      <td class="etiqueta">Fecha Inicio:</td>
      <td><input type="date" id="cont_fec_inicio" value="<?php echo $fec_inicio;?>" required></td>
      <td class="etiqueta">Fecha Culminiacion:</td>
      <td><input type="date" id="cont_fec_fin" value="<?php echo $fec_fin;?>"></td>
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
		 <input type="button" id="volver" value="volver" onClick="Cons_contratacion_inicio()" class="readon art-button" />
		 </span>
	</div>
	 <input name="metodo" id="cont_metodo" type="hidden"  value="<?php echo $metodo;?>" />
	</form>

	 <div id="Cont_detalleCont"  class="tabla_sistema"></div>

  </fieldset>
