<link rel="stylesheet" type="text/css" href="latest/stylesheets/autocomplete.css" />
<script type="text/javascript" src="latest/scripts/autocomplete.js"></script>
<?php
$Nmenu   = 510;
$mod     =  $_GET['mod'];
$titulo  = " REPORTE USUARIOS ";
$archivo = "reportes/rp_mant_usuarios_det.php?Nmenu=$Nmenu&mod=$mod";
require_once('autentificacion/aut_verifica_menu.php');
require_once('sql/sql_report.php');
$bd = new DataBase();
?>
<div align="center" class="etiqueta_title"> <?php echo $titulo;?></div>
<br/>

<form name="form_reportes" id="form_reportes" action="<?php echo $archivo;?>" method="post" target="_blank">
  <table width="75%" border="0" align="center">
	<tr>
       <td height="8" colspan="2" align="center"><hr></td>
    </tr>

     <tr>
        <td class="etiqueta">Perfil:</td>
		<td><select name="perfil" style="width:250px;">
     		        <option value="TODOS"> TODOS</option>
		<?php $query02 = $bd->consultar($sql_perfil);
             while($row02=$bd->obtener_fila($query02,0)){
                   echo '<option value="'.$row02[0].'">'.$row02[1].'</option>';
             }?></select></td></tr>
    <tr>
        <td class="etiqueta">Status:</td>
		<td><select name="status" style="width:250px;">
     		        <option value="TODOS"> TODOS </option>
                    <option value="T"><?php echo statuscal('T');?></option>
                    <option value="F"><?php echo statuscal('F');?></option>
           </select></td></tr>
	<tr>
		<td class="etiqueta">Usuarios:</td>
		<td id="select01"><select id="paciFiltro" onchange="EstadoFiltro(this.value)" style="width:200px">
				<option value="TODOS"> TODOS</option>
			    <option value="cedula"> C&eacute;dula </option>
				<option value="nombre"> Nombre </option>
                <option value="apellido"> Apellido </option>
		</select><img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br />
       	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
    </tr>
	<tr>
      <td class="etiqueta"><?php echo $leng['trabajador']?>:</td>
      <td><input  id="stdName" type="text" style="width:300px" disabled="disabled" />
	        <span id="input01"><input type="hidden" name="trabajador" id="stdID" value=""/>
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
                  
    <img class="imgLink" id="img_pdf" src="imagenes/pdf.gif" border="0"
    onclick="{$('#reporte').val('pdf');$('#procesar').click();}" width="25px" title="imprimir a pdf">

    <img class="imgLink" id="img_excel" src="imagenes/excel.gif" border="0"
    onclick="{$('#reporte').val('excel');$('#procesar').click();}" width="25px" title="imprimir a excel">
             <span class="art-button-wrapper">
                    <span class="art-button-l"> </span>
                    <span class="art-button-r"> </span>
                <input type="reset" id="limpiar" value="Restablecer" class="readon art-button" />
                </span>
 			    <input name="usuario" type="hidden"  value="<?php echo $usuario;?>"/>
		</div></form>
<br />
<br />
<div align="center">
</div>
<script type="text/javascript">

	filtroId = document.getElementById("paciFiltro");
	filtroIndice = filtroId.selectedIndex;
	filtroValue  = filtroId.options[filtroIndice].value;

    new Autocomplete("stdName", function() {
        this.setValue = function(id) {
            document.getElementById("stdID").value = id; // document.getElementsByName("stdID")[0].value = id;
        }
        if (this.isModified) this.setValue("");
        if (this.value.length < 1) return ;
          return "autocompletar/tb/usuario.php?q="+this.text.value +"&filtro="+filtroValue+""});
</script>
