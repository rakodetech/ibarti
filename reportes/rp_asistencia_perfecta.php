<link rel="stylesheet" type="text/css" href="latest/stylesheets/autocomplete.css" />
<script type="text/javascript" src="latest/scripts/autocomplete.js"></script>
<?php
mysql_select_db($bd_cnn, $cnn);
$id   = $_GET['id'];

//echo $usuario; //= $_SESSION['usuario_id'];
$Nmenu = 515;
$archivo = "Ubicacion_Cliente&id=".$id."&Nmenu=".$Nmenu."";
$tabla   = "clientes_ubicacion";
require_once('autentificacion/aut_verifica_menu.php');
?>
<br>
<div align="center" class="etiqueta_title">Reporte Asistencia Prfecta <BR /><BR /></div>
<div id="Contendor01" class="mensaje"></div>
<br/>
<form id="reportes" name="reportes" action="reportes/rp_asistencia_perfecta_det.php?Nmenu=<?php echo $Nmenu?>" method="post" target="_blank">
  <table width="750px" border="0" align="center">
	<tr>
       <td height="8" colspan="2" align="center"><hr></td>
    </tr>
    <tr>
      <td class="etiqueta" width="30%">Fecha Desde:</td>
      <td id="date01" width="70%"><input type="text" name="fecha_desde" maxlength="120" style="width:100px" value="<?php echo $date?>"/>
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br>
        <span class="textfieldRequiredMsg">El Campo Es Requerido.</span>
		<span class="textfieldInvalidFormatMsg">Fromato Invalido.</span>		</td>
    </tr>
    <tr>
      <td class="etiqueta">Fecha Hasta:</td>
      <td id="date02"><input type="text" name="fecha_hasta" maxlength="120" style="width:100px" value="<?php echo $date?>"/>
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br>
        <span class="textfieldRequiredMsg">El Campo Es Requerido.</span>
	  <span class="textfieldInvalidFormatMsg">Fromato Invalido.</span>	  </td>
  </tr>

    <tr>
        <td class="etiqueta"><?php echo $leng['region']?>:</td>
		<td  id="select01"><select name="regiones" style="width:250px;">
          <option value="TODOS"> TODOS</option>
          <?php
					    $query03 = mysql_query("SELECT id, descripcion FROM regiones ORDER BY 2 ASC ", $cnn);
					   while($row03=(mysql_fetch_array($query03))){
					   echo '<option value="'.$row03[0].'">'.$row03[1].'</option>';
					   }
					   ?>
        </select>
		  <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br />
   	  <span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
    </tr>

    <tr>
        <td class="etiqueta"><?php echo $leng['contrato']?>:</td>
		<td  id="select02"><select name="contracto" style="width:250px;">
          <option value="TODOS"> TODOS</option>
          <?php
 			    $query03 = mysql_query(" SELECT nomina.co_cont,  nomina.des_cont
                                           FROM nomina WHERE nomina.tip_cont =  '2' ORDER BY 2 ASC  ", $cnn);
					   while($row03=(mysql_fetch_array($query03))){
					   echo '<option value="'.$row03[0].'">'.$row03[1].'</option>';
					   }
					   ?>
        </select>
		  <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br />
   	  <span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
    </tr>
	 <tr>
      <td class="etiqueta">Cantiadad o Rango:</td>
      <td id="integer01"><input type="text" name="rango" maxlength="3" style="width:100px" />
        <img src="imagenes/ok.gif" alt="Valido" class="validMsg" border="0"/> <br />
        <span class="textfieldRequiredMsg">El Campo es Requerido.</span>
        <span class="textfieldMinCharsMsg">Debe Escribir 20 caracteres.</span></td>
	 </tr>

    <tr>
        <td class="etiqueta">Tipo Reporte:</td>
		<td  id="select10">
			   <select name="reporte" style="width:200px;">
					   <option value="pdf">PDF</option>
			   		   <option value="excel">Excel</option>
	           </select><img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br />
       	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
     </tr>
	 <tr>
       <td height="8" colspan="2" align="center"><hr></td>
    </tr>
  </table>
	 <br />
     <div align="center">
            <input name="submit" type="submit" value="Siguiente"  class="button1"
			                       onMouseOver="Fondos (this.id ,'A',  'button1Act', 'button1')"
	                               onMouseOut="Fondos (this.id ,'D', 'button1Act', 'button1')"/>	 &nbsp;
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

var date01 = new Spry.Widget.ValidationTextField("date01", "date", {format:"dd-mm-yyyy", hint:"dd-mm-yyyy", validateOn:["blur", "change"], useCharacterMasking:true, isRequired:false});
var date02 = new Spry.Widget.ValidationTextField("date02", "date", {format:"dd-mm-yyyy", hint:"dd-mm-yyyy", validateOn:["blur", "change"], useCharacterMasking:true, isRequired:false});

var select01 = new Spry.Widget.ValidationSelect("select01", {validateOn:["blur", "change"]});
var select02 = new Spry.Widget.ValidationSelect("select02", {validateOn:["blur", "change"]});


var integer01 = new Spry.Widget.ValidationTextField("integer01", "integer", {validateOn:["blur", "change"], useCharacterMasking:false});

var select10 = new Spry.Widget.ValidationSelect("select10", {validateOn:["blur", "change"]});


</script>
