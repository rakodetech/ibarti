<script language="javascript">
function Asistencia_Rol(codigo, archivo, contenido){  // CARGAR  ARCHIVO DE AJAX CON UN PARAMETRO//
	 if(codigo!=''){
		 var usuario = document.getElementById("usuario").value;
		ajax=nuevoAjax();
			ajax.open("POST", archivo, true);
			ajax.onreadystatechange=function()
			{
				if (ajax.readyState==4){
		        document.getElementById(contenido).innerHTML = ajax.responseText;
				}
			}
			ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			ajax.send("codigo="+codigo+"&usuario="+usuario+"");
	}else{
		 	alert("Debe de Seleccionar Un Campo ");
	}
}
</script>
<?php
$titulo  = " APERTURA ACTUALIZAR ";
$proced  = "p_nom_apertura_act";
$archivo = "nom_apertura_actualizacion";
$metodo  = "agregar";
$Nmenu   = 420;

require_once('autentificacion/aut_verifica_menu.php');
$vinculo = "../inicio.php?area=formularios/Cons_".$archivo."&Nmenu=$Nmenu&mod=".$_GET['mod']."";

$bd = new DataBase();

$sql_contractos = "SELECT cod_contracto, contractos.descripcion AS contrato
                     FROM asistencia_apertura, contractos
                    WHERE asistencia_apertura.`status` = 'T'
                      AND asistencia_apertura.cod_contracto = contractos.codigo
                 GROUP BY asistencia_apertura.cod_contracto
	             ORDER BY 2 ASC ";
?>
<br>
<div align="center" class="etiqueta_title"><?php echo $titulo;?></div>
<div id="Contendor01" class="mensaje"></div>
<br/>
<form name="form01" id="form01" action="scripts/sc_<?php echo $archivo;?>.php" method="post">
    <table width="750px" border="0" align="center">
	<tr>
       <td height="8" colspan="2" align="center"><hr></td>
    </tr>
    <tr>
        <td class="etiqueta" width="25%"><?php echo $leng['nomina']?>:</td>
		<td  id="select01" width="75%"><select name="co_cont" style="width:250px;"
                                               onchange="Asistencia_Rol(this.value, 'ajax/Add_apertura_actualizacion.php', 'select02')" >
     				   <option value=""> Seleccione..</option>
					<?php
				    $query = $bd->consultar($sql_contractos);
                     while($row02=$bd->obtener_fila($query,0)){
						   echo '<option value="'.$row02[0].'">'.$row02[1].'</option>';
					 }?>
	           </select><br />
       	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
     </tr>
    <tr>
        <td class="etiqueta"><?php echo $leng['rol']?>:</td>
		<td  id="select02"><select name="rol" style="width:250px;" >
     				   <option value=""> Seleccione..</option></select><br />
       	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span>
		</td>
     </tr>
	 <tr>
       <td height="8" colspan="2" align="center"><hr></td>
    </tr>
    </table>
	 <br />
     <div align="center">
             <span class="art-button-wrapper">
                    <span class="art-button-l"> </span>
                    <span class="art-button-r"> </span>
                <input type="submit" value="Siguiente" class="readon art-button" />
                </span>
                <span class="art-button-wrapper">
                    <span class="art-button-l"> </span>
                    <span class="art-button-r"> </span>
                <input type="reset" name="reset"  value="Restablecer" class="readon art-button" />
                </span>
      <input type="hidden" name="usuario" id="usuario" value="<?php echo $usuario;?>"/>
      <input type="hidden" name="metodo" id="metodo" value="<?php echo $metodo;?>"/>
      <input type="hidden" name="proced" id="proced" value="<?php echo $proced;?>"/>
      <input type="hidden" name="href" value="<?php echo $vinculo?>"/>
  </div>
</form>
<br />
<br />
<div align="center">
</div>
<script type="text/javascript">
var select01 = new Spry.Widget.ValidationSelect("select01", {validateOn:["blur", "change"]});
</script>
