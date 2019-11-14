<script language="javascript">
$("#cl_contratacion_form").on('submit', function(evt){
	 evt.preventDefault();
	 save_contratacion();
});
	</script>
<?php

require "../modelo/contratacion_modelo.php";
require "../../../../".Leng;
$contratacion = new Contratacion;
$metodo = $_POST['metodo'];


if($metodo == 'modificar')
{
	$codigo   = $_POST['codigo'];
	$titulo   = "Modificar ".$leng['contratacion'];
	$cont     =  $contratacion->editar("$codigo");
}else{
	$titulo   = "Agregar ".$leng['contratacion'];
	$cont     =  $contratacion->inicio();
}
?>

<div align="center" class="etiqueta_title"><?php echo $titulo;?> </div> <hr />
	<form id="cl_contratacion_form" name="cl_contratacion_form" method="post">
     <table width="98%" align="center">
    <tr>
      <td width="14%" class="etiqueta">C&oacute;digo:</td>
      <td width="20%"><input type="text" id="cont_codigo" size="12" value="<?php echo $cont["codigo"];?>" readonly  />
               Activo: <input id="cont_status" type="checkbox"  <?php echo statusCheck($cont["status"]);?> value="T" />
      </td>
      <td width="13%" class="etiqueta">descripcion: </td>
      <td width="20%"><input type="text" id="cont_descripcion" maxlength="60" size="30" required value="<?php echo $cont["descripcion"];?>"/>
      </td>
			<td width="13%" class="etiqueta">Fecha Inicio:</td>
			<td width="20%"><input type="date" id="cont_fec_inicio" value="<?php echo $cont["fecha_inicio"];?>" required></td>
		</tr>

	 	<tr>
         <td height="8" colspan="6" align="center"><hr></td>
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
	</form><div id="Cont_detalleCont"  class="tabla_sistema listar" style="width: 90%;"></div>
