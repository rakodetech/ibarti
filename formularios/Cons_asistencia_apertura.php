<?php
$Nmenu = 407;
$titulo = " APERTURAR ASISTENCIA ";
$archivo = "asistencia_apertura";
$archivo2 = "../inicio.php?area=formularios/Cons_$archivo&Nmenu=".$_GET['Nmenu']."&mod=".$_GET['mod']."";
require_once('autentificacion/aut_verifica_menu.php');
$bd = new DataBase();
?>
<br>
<div align="center" class="etiqueta_title"> <?php echo $titulo;?> </div>
<div id="Contendor01" class="mensaje"></div>
<br/>
<form name="form01_apertura" id="form01_apertura" action="scripts/sc_asistencia_apertura.php" method="post">
    <table width="750px" border="0" align="center">
	<tr>
       <td height="8" colspan="2" align="center"><hr></td>
    </tr>
     <tr>
        <td class="etiqueta" width="25%"><?php echo $leng['contrato']?>:</td>
		<td  id="select01" width="75%"><select name="contracto" style="width:250px;" onchange="Add_ajax01(this.value,'ajax/apertura_asistencia.php','Contenedor_Fec')">
     				   <option value=""> Seleccione....</option>
          <?php  	$sql = " SELECT contractos.codigo, contractos.descripcion
                               FROM contractos
                              WHERE contractos.`status` = 'T' ORDER BY 2 ASC ";
		            $query = $bd->consultar($sql);
            		while($row02=$bd->obtener_fila($query,0)){
	 					echo '<option value="'.$row02[0].'">'.$row02[1].'</option>';
					}
		   ?>
	           </select><br />
       	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span>
		</td>
     </tr>
      <tr>
        <td id="Contenedor_Fec" colspan="2">
		</td>
      </tr>
	 <tr>
       <td height="8" colspan="2" align="center"><hr></td>
    </tr>
    </table>
	 <br />
<div align="center">  <span class="art-button-wrapper">
                    <span class="art-button-l"> </span>
                    <span class="art-button-r"> </span>
                <input type="submit" name="salvar"  id="salvar" value="Siguiente"  class="readon art-button" />
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
                 <input name="href" type="hidden" value="<?php echo $archivo2;?>"/>
</div>
</form>
<br />
<br />
<div align="center">
</div>
<script type="text/javascript">
 var select01 = new Spry.Widget.ValidationSelect("select01", {validateOn:["blur", "change"]});
</script>
