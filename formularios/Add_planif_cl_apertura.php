<?php
$Nmenu = 4400;
require_once('autentificacion/aut_verifica_menu.php');
require_once('sql/sql_report_t.php');
$mod = $_GET['mod'];
$titulo = "Aperturar Planificacion de ".$leng['cliente']."";
$titulo2 = "Planificacion Actual Abierta de ".$leng['cliente']."";
$archivo = "planif_cl_apertura";
$metodo  =$_GET['metodo'];
$href = "../inicio.php?area=formularios/Cons_$archivo&Nmenu=$Nmenu&mod=$mod";
$proced      = "p_pl_cliente_apertura";

$sql   = " SELECT COUNT(a.codigo) cant, a.codigo, a.descripcion,
                  a.fecha_inicio, a.fecha_fin,
									DATE_FORMAT(DATE_ADD(a.fecha_inicio, INTERVAL 1 MONTH), '%Y-%m') periodo,  DATE_ADD(a.fecha_inicio, INTERVAL 1 MONTH) fecha_new,
                  a.cod_us_ing, CONCAT(men_usuarios.apellido, ' ', men_usuarios.nombre) us_ing,
                  a.fec_us_ing, StatusD(a.`status`) `status`
             FROM pl_cliente_apertura a LEFT JOIN men_usuarios  ON a.cod_us_ing = men_usuarios.codigo
            WHERE a.`status` = 'T' ";

	$query = $bd->consultar($sql);
	$row        = $bd->obtener_fila($query,0);
 if($row[0] == 1){

	$codigo     = $row['codigo'];
  $periodo    = $row['periodo'];
	$fec_new    = $row['fecha_new'];
	$fec_inicio = $row['fecha_inicio'];
	$fec_fin    = $row['fecha_fin'];
	$fec_us_ing = $row['fec_us_ing'];
	$us_ing     = $row['us_ing'];
	$status     = $row['status'];
	$read       = "readonly";

 }else{

  $codigo     = "";
  $periodo    = "";
	$fec_new    = "";
 	$fec_inicio = "";
 	$fec_fin    = "";
	$fec_us_ing = "";
	$us_ing     = "";
 	$status     = "";
	$read       = "";

 } ?>
<form action="scripts/sc_<?php echo $archivo;?>.php" method="post" name="add" id="add">
     <table width="100%" align="center">
       <tr>
		     <td height="23" colspan="4" class="etiqueta_title" align="center"><?php echo $titulo;?></td>
       </tr>
       <tr>
    	    <td height="8" colspan="4" align="center"><hr></td>
     	</tr>
     <tr>
      	<td class="etiqueta" width="15%">Periodo:</td>
      	<td width="35%"><input type="text" size="10" name="codigo" id="codigo" value="<?php echo $periodo;?>" readonly /></td>
        <td class="etiqueta" width="15%">Fecha Aperturar:</td>
        <td width="35%" id="fecha01"><input type="date" name="fecha" id="fecha_desdeX" style="width:120px" placeholder="Fecha Inicio"
					 value="<?php echo $fec_new;?>" <?php echo $read; ?> require /><br />

		             </td>
     </tr>
     <tr>
      	<td class="etiqueta">Replicar Mes:</td>
      	<td id="radio01">SI<input type = "radio" name="replicar"  value = "T" style="width:auto" /> NO <input
        type = "radio"  name="replicar" value = "F" style="width:auto" /><br /><span class="radioRequiredMsg">Debe seleccionar un Campo.</span></td>
        <td class="etiqueta">Replicar Excepcion:</td>
        <td id="radio02">SI<input type = "radio" name="excepcion"  value = "T" style="width:auto" /> NO <input
        type = "radio"  name="excepcion" value = "F" style="width:auto" /><br /><span class="radioRequiredMsg">Debe seleccionar un Campo.</span></td>
     </tr>

      <tr>
         <td height="8" colspan="4" align="center"><hr></td>
     </tr>

     <tr>
       <td height="23" colspan="4" class="etiqueta_title" align="center"><?php echo $titulo2;?></td>
     </tr>
     <tr>
        <td height="8" colspan="4" align="center"><hr></td>
    </tr>

    <tr>
       <td class="etiqueta">Periodo:</td>
       <td><?php echo $codigo;?></td>
       <td class="etiqueta">Status:</td>
       <td><?php echo $status;?></td>
    </tr>
    <tr>
       <td class="etiqueta">Fecha Inicio:</td>
       <td><?php echo $fec_inicio;?></td>
       <td class="etiqueta">Fecha Fin:</td>
       <td><?php echo $fec_fin;?></td>
    </tr>
    <tr>
       <td class="etiqueta">Fecha de Creacion:</td>
       <td><?php echo $fec_us_ing;?></td>
       <td class="etiqueta">Usuario Ingreso:</td>
       <td><?php echo $us_ing;?></td>
    </tr>

     <tr>
        <td height="8" colspan="4" align="center"><hr></td>
     </tr>
  </table>
<div align="center">
<span class="art-button-wrapper">
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
        <input type="button" id="volver" value="Volver" onClick="history.back(-1);" class="readon art-button" />
        </span>
		    <input name="metodo" type="hidden" value="<?php echo $metodo;?>" />
		   	<input name="proced" type="hidden" value="<?php echo $proced;?>" />
	      <input name="href" type="hidden" value="<?php echo $href;?>"/>
        <input type="hidden" name="usuario" id="usuario" value="<?php echo $_SESSION['usuario_cod'];?>"/>
</div>
</form>
<div id="Contendor01" class="mensaje"></div>

</body>
</html>
<script type="text/javascript">

var radio01 = new Spry.Widget.ValidationRadio("radio01", { validateOn:["change", "blur"]});
var radio02 = new Spry.Widget.ValidationRadio("radio02", { validateOn:["change", "blur"]});
/*
var fecha01 = new Spry.Widget.ValidationTextField("fecha01", "date", {hint:"DD/MM/AAAA",
    validateOn:["blur", "change"], useCharacterMasking:true});
*/

</script>
