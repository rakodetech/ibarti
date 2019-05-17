<link rel="stylesheet" type="text/css" href="latest/stylesheets/autocomplete.css" />
<script type="text/javascript" src="latest/scripts/autocomplete.js"></script>
<?php
mysql_select_db($bd_cnn, $cnn);
$id   = $_GET['id'];
//echo $usuario; //= $_SESSION['usuario_id'];
$Nmenu   = 544;
$archivo = "Ubicacion_Cliente&id=".$id."&Nmenu=".$Nmenu."";
require_once('autentificacion/aut_verifica_menu.php');
?>
<br>
<div align="center" class="etiqueta_title"> REPORTE DOTACION UNIFORMES <BR /><BR /></div>
<div id="Contendor01" class="mensaje"></div>
<br/>
<form id="reportes" name="reportes" action="reportes/rp_ficha_uniformes_dot_det.php?Nmenu=<?php echo $Nmenu?>" method="post" target="_blank">
  <table width="750px" border="0" align="center">
	<tr>
       <td height="8" colspan="2" align="center"><hr></td>
    </tr>
    <tr>
      <td class="etiqueta" width="30%">Fecha Dotacion:</td>
      <td id="date01" width="70%"><input type="text" name="fecha_desde" maxlength="120" style="width:100px" value="<?php echo $date?>"/>
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br>
        <span class="textfieldRequiredMsg">El Campo Es Requerido.</span>
		<span class="textfieldInvalidFormatMsg">Fromato Invalido.</span></td>
    </tr>
    <tr>
      <td class="etiqueta">Talla De Pantal&oacute;n:</td>
       <td id="select01"><select name="t_pantalon" style="width:250px">
							<option value="">Seleccione...</option>
          <?php  $query05 = mysql_query("SELECT productos.codigo, productos.descripcion
										   FROM productos
										  WHERE productos.cod_prod_clasif = '002'
											AND productos.`status` = 1  ORDER BY 2 ASC",$cnn);
						  while($row05=mysql_fetch_array($query05)){
		  ?>
          <option value="<?php echo $row05[0];?>"><?php echo utf8_decode($row05[1]);?></option>
          <?php }?>
        </select>
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br />
        	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
	 </tr>
	 <tr>
      <td class="etiqueta">Cantiadad de Pantalon:</td>
      <td id="integer01"><input type="text" name="c_pantalon" maxlength="2" style="width:100px" />
        <img src="imagenes/ok.gif" alt="Valido" class="validMsg" border="0"/> <br />
        <span class="textfieldRequiredMsg">El Campo es Requerido.</span>
        <span class="textfieldMinCharsMsg">Debe Escribir 20 caracteres.</span></td>
	 </tr>
    <tr>
      <td class="etiqueta">Talla Camisa:</td>
       <td id="select02"><select name="t_camisa" style="width:250px">
							<option value="">Seleccione...</option>
          <?php  $query05 = mysql_query("SELECT productos.codigo, productos.descripcion
											FROM productos
										   WHERE productos.cod_prod_clasif = '001'
											 AND productos.`status` = 1  ORDER BY 2 ASC",$cnn);
						  while($row05=mysql_fetch_array($query05)){
		  ?>
          <option value="<?php echo $row05[0];?>"><?php echo utf8_decode($row05[1]);?></option>
          <?php }?>
        </select>
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br />
        	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
	 </tr>

	 <tr>
      <td class="etiqueta">Cantiadad Camisa:</td>
      <td id="integer02"><input type="text" name="c_camisa" maxlength="2" style="width:100px" />
        <img src="imagenes/ok.gif" alt="Valido" class="validMsg" border="0"/> <br />
        <span class="textfieldRequiredMsg">El Campo es Requerido.</span>
        <span class="textfieldMinCharsMsg">Debe Escribir 20 caracteres.</span></td>
	 </tr>
    <tr>
      <td class="etiqueta">N&uacute;mero De Zapato:</td>
       <td id="select03"><select name="n_zapato" style="width:250px">
							<option value="">Seleccione...</option>
          <?php  $query05 = mysql_query("SELECT productos.codigo, productos.descripcion
											FROM productos
										   WHERE productos.cod_prod_clasif = '003'
											 AND productos.`status` = 1  ORDER BY 2 ASC",$cnn);
						  while($row05=mysql_fetch_array($query05)){
		  ?>
          <option value="<?php echo $row05[0];?>"><?php echo utf8_decode($row05[1]);?></option>
          <?php }?>
        </select>
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br />
        	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
	 </tr>
	 <tr>
      <td class="etiqueta">Cantidad De Zapatos:</td>
      <td id="integer03"><input type="text" name="c_zapato" maxlength="2" style="width:100px" />
        <img src="imagenes/ok.gif" alt="Valido" class="validMsg" border="0"/> <br />
        <span class="textfieldRequiredMsg">El Campo es Requerido.</span>
        <span class="textfieldMinCharsMsg">Debe Escribir 20 caracteres.</span></td>
	 </tr>
	<tr>
		<td class="etiqueta">Filtro <?php echo $leng['trabajador']?>:</td>
		<td id="select04">
			<select id="paciFiltro" onchange="EstadoFiltro()" style="width:200px">
				<option value="TODOS"> TODOS</option>
				<option value="codigo"> <?php echo $leng['ci']?> </option>
				<option value="ficha"> <?php echo $leng['ficha']?></option>
				<option value="nombre"> Nombre</option>
		</select><img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br />
       	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
    </tr>
	<tr>
      <td class="etiqueta"><?php echo $leng['trabajador']?>:</td>
      <td>
		  <input  id="stdName" type="text" style="width:300px" disabled="disabled" />
	        <span id="input01"><input type="hidden" name="trabajador" id="stdID" value="TODOS"/>
            <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/> <br />
            <span class="textfieldRequiredMsg">Debe De Seleccionar Un Campo De la Lista.</span>
            <span class="textfieldInvalidFormatMsg">El Formato es Invalido</span> </span></td>
    </tr>
    
	 <tr>
       <td height="8" colspan="2" align="center"><hr></td>
    </tr>
  </table>
	 <br />
     <div align="center">
            <input type="submit" name="procesar" id="procesar" hidden="hidden">
                            <input type="text" name="reporte" id="reporte" hidden="hidden">
<img class="imgLink" id="img_excel" src="imagenes/excel.gif" border="0"
                            onclick="{$('#reporte').val('excel');$('#procesar').click();}" width="25px" title="imprimir a excel">
            <input name="reset" type="reset" value="Restablecer"   class="button1"
			                       onMouseOver="Fondos (this.id ,'A',  'button1Act', 'button1')"
	                               onMouseOut="Fondos (this.id ,'D', 'button1Act', 'button1')"/>	&nbsp;
			                         <input name="archivo" type="hidden"  value="agregar" />
			<input name="id" type="hidden"  value="<?php echo $id;?>"/>
			<input name="usuario" type="hidden"  value="<?php echo $usuario;?>"/>
			<input name="perfil" type="hidden"  value="<?php echo $perfil;?>"/>

  </div>
</form>
<br />
<br />
<div align="center">
</div>
<script type="text/javascript">

var date01 = new Spry.Widget.ValidationTextField("date01", "date", {format:"dd-mm-yyyy", hint:"dd-mm-yyyy", validateOn:["blur", "change"], useCharacterMasking:true});

var integer01 = new Spry.Widget.ValidationTextField("integer01", "integer", {validateOn:["blur", "change"], useCharacterMasking:false});
var integer02 = new Spry.Widget.ValidationTextField("integer02", "integer", {validateOn:["blur", "change"], useCharacterMasking:false});
var integer03 = new Spry.Widget.ValidationTextField("integer03", "integer", {validateOn:["blur", "change"], useCharacterMasking:false});

var select01 = new Spry.Widget.ValidationSelect("select01", {validateOn:["blur", "change"]});
var select02 = new Spry.Widget.ValidationSelect("select02", {validateOn:["blur", "change"]});
var select03 = new Spry.Widget.ValidationSelect("select03", {validateOn:["blur", "change"]});
var select04 = new Spry.Widget.ValidationSelect("select04", {validateOn:["blur", "change"]});

var select10 = new Spry.Widget.ValidationSelect("select10", {validateOn:["blur", "change"]});

	filtroId = document.getElementById("paciFiltro");
	filtroIndice = filtroId.selectedIndex;
	filtroValue  = filtroId.options[filtroIndice].value;

    new Autocomplete("stdName", function() {
        this.setValue = function(id) {
            document.getElementById("stdID").value = id; // document.getElementsByName("stdID")[0].value = id;
        }
        if (this.isModified) this.setValue("");
        if (this.value.length < 1) return ;
          return "autocompletar/tb/ficha.php?q="+ this.text.value +"&filtro="+filtroValue+""});
</script>
