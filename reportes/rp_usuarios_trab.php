<link rel="stylesheet" type="text/css" href="latest/stylesheets/autocomplete.css" />
<script type="text/javascript" src="latest/scripts/autocomplete.js"></script>
<?php
mysql_select_db($bd_cnn, $cnn);
$id   = $_GET['id'];
$fecha = $_GET['fecha'];
$fecha = '27-11-2009';
//echo $usuario; //= $_SESSION['usuario_id'];
$Nmenu = 511;
$archivo = "Ubicacion_Cliente&id=".$id."&Nmenu=".$Nmenu."";
$tabla   = "clientes_ubicacion";
require_once('autentificacion/aut_verifica_menu.php');
	 //$row02   = mysql_fetch_array($query02);
?>
<br>
<div align="center" class="etiqueta_title"> Reporte Usuario Asignacion De <?php echo $leng['trabajadores']?> <BR /><BR /></div>
<div id="Contendor01" class="mensaje"></div>
<br/>
<form id="clientes" name="clientes" action="reportes/rp_usuarios_trab_det.php?Nmenu=<?php echo $Nmenu?>" method="post" target="_blank">
  <table width="750px" border="0" align="center">
	<tr>
       <td height="8" colspan="2" align="center"><hr></td>
    </tr>
     <tr>
        <td class="etiqueta">Usuarios:</td>
		<td  id="select06">			   <select name="usuario_id" style="width:300px;">
     				   <option value="TODOS"> TODOS</option>
				   <?php
                    $query02 = mysql_query("SELECT DISTINCT oesvica_oesvica.usuario_cliente.id_usuario,
                                                   CONCAT(oesvica_sistema.usuarios.apellido,' ',oesvica_sistema.usuarios.nombre) AS
                                                   usuario
                                              FROM oesvica_oesvica.usuario_cliente , oesvica_sistema.usuarios
                                             WHERE oesvica_oesvica.usuario_cliente.id_usuario = oesvica_sistema.usuarios.cedula
                                             ORDER BY 2 ASC ", $cnn);
                       while($row02=(mysql_fetch_array($query02))){

                     echo '<option value="'.$row02[0].'">'.$row02[1].' ('.$row02[0].')</option>';
                       }
                   ?>
	           </select><img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br />
       	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span>
		</td>
     </tr>
	<tr>
		<td class="etiqueta">Filtro <?php echo $leng['trabajador']?>.:</td>
		<td id="select01">
			<select id="paciFiltro" onchange="EstadoFiltro()" style="width:200px">
				<option value="TODOS"> TODOS</option>
				<option value="codigo"><?php echo $leng['ficha']?></option>
				<option value="cedula"><?php echo $leng['ci']?></option>
				<option value="nombre"> Nombre</option>
		</select><img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br />
       	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
    </tr>
	<tr>
      <td class="etiqueta"><?php echo $leng['trabajador']?>.:</td>
      <td>
		  <input  id="stdName" type="text" style="width:300px" disabled="disabled" />
	        <span id="input01"><input type="hidden" name="trabajador" id="stdID" value=""/>
            <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/> <br />
            <span class="textfieldRequiredMsg">Debe De Seleccionar Un Campo De la Lista.</span>
            <span class="textfieldInvalidFormatMsg">El Formato es Invalido</span> </span></td>
    </tr>
     <tr>
        <td class="etiqueta"><?php echo $leng['region']?>:</td>
		<td  id="select02"><select name="regiones" style="width:250px;">
          <option value="TODOS"> TODOS</option>
          <?php
					    $query03 = mysql_query("SELECT id, descripcion FROM regiones ORDER BY 2 ASC", $cnn);
					   while($row03=(mysql_fetch_array($query03))){
					   echo '<option value="'.$row03[0].'">'.$row03[1].'</option>';
					   }
					   ?>
        </select>
		  <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br />
   	  <span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
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
 var select01 = new Spry.Widget.ValidationSelect("select01", {validateOn:["blur", "change"]});
 var select02 = new Spry.Widget.ValidationSelect("select02", {validateOn:["blur", "change"]});
// var select03 = new Spry.Widget.ValidationSelect("select03", {validateOn:["blur", "change"]});
// var select04 = new Spry.Widget.ValidationSelect("select04", {validateOn:["blur", "change"]});
 var select05 = new Spry.Widget.ValidationSelect("select05", {validateOn:["blur", "change"]});
 var select06 = new Spry.Widget.ValidationSelect("select06", {validateOn:["blur", "change"]});

 	filtroId = document.getElementById("paciFiltro");
	filtroIndice = filtroId.selectedIndex;
	filtroValue  = filtroId.options[filtroIndice].value;

    new Autocomplete("stdName", function() {
        this.setValue = function(id) {
            document.getElementById("stdID").value = id; // document.getElementsByName("stdID")[0].value = id;
        }
        if (this.isModified) this.setValue("");
        if (this.value.length < 1) return ;
          return "autocompletar/tb/trabajador.php?q="+ this.text.value +"&filtro="+filtroValue+""});
</script>
