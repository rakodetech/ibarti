<?php
$Nmenu   = 411;

$proced   = "p_nom_apertura";
require_once('autentificacion/aut_verifica_menu.php');
$archivo = "nom_apertura";
$archivo2 = "formularios/Cons_$archivo&Nmenu=$Nmenu&mod=".$_GET['mod']."";

$tabla   = "control";
$titulo = " Apertura Y Cierre De ".$leng['nomina']." ";
		$sql = "SELECT contractos.codigo, contractos.descripcion,
				 	   contractos.fec_inicio,contractos.fec_ultimo
				  FROM contractos
				 WHERE contractos.`status` = 'T'";
			      $query = $bd->consultar($sql);
?>
<div align="center" class="etiqueta_title"><?php echo $titulo;?> </div>
<hr />
	<br />
	<form action="scripts/sc_<?php echo $archivo;?>.php" method="post" name="form1" enctype="multipart/form-data">
   <table width="70%" align="center">
      <tr>
        <td class="etiqueta" width="25%"><?php echo $leng['nomina']?>:</td>
 		<td  id="select01" width="75%">
		<select name="codigo" style="width:250px;" onchange="Add_ajax01(this.value, 'ajax/nomina.php','Contenedor01')">
          <option value="">Seleccione...</option>
  		<?php
  		  while($row04=$bd->obtener_fila($query,0)){ ?>
          <option value="<?php echo $row04[0];?>"><?php echo $row04[1];?></option>
          <?php }?>
        </select><br />
       	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
      </tr>

	<tr>
	<td colspan="2" align="center">

	</td>
	</tr>
</table>
<div id="Contenedor01" class="mensaje"></div>
  <div align="center">
			<input type="hidden"  name="usuario" value="<?php echo $usuario;?>" />
            <input type="hidden"  name="archivo" value="nomina" />
            <input type="hidden"  name="proced" value="<?php echo $proced;?>" />
            <input type="hidden"  name="href" value="../inicio.php?area=<?php echo $archivo2;?>" />
   </div>
</form>
<script type="text/javascript">
var select01 = new Spry.Widget.ValidationSelect("select01", {validateOn:["blur", "change"]});
</script>
