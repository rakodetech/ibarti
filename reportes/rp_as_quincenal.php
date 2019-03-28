<link rel="stylesheet" type="text/css" href="latest/stylesheets/autocomplete.css" />
<script type="text/javascript" src="latest/scripts/autocomplete.js"></script>
<?php
mysql_select_db($bd_cnn, $cnn);
$id   = $_GET['id'];
//echo $usuario; //= $_SESSION['usuario_id'];
$Nmenu = 509;
$archivo = "Ubicacion_Cliente&id=".$id."&Nmenu=".$Nmenu."";
$tabla   = "clientes_ubicacion";
require_once('autentificacion/aut_verifica_menu.php');
?>
<br>
<div align="center" class="etiqueta_title"> Reporte <?php echo $leng['nomina']?> <BR />
</div>
<div id="Contendor01" class="mensaje"></div>
<br/>
<form id="clientes" name="clientes" action="reportes/rp_as_quincenal_det.php?Nmenu=<?php echo $Nmenu?>" method="post" target="_blank">
  <table width="750px" border="0" align="center">
	<tr>
       <td height="8" colspan="2" align="center"><hr></td>
    </tr>

    <tr>
      <td class="etiqueta" width="30%">Fecha Desde:</td>
      <td id="date01" width="70%"><input type="text" name="fecha_desde" maxlength="120" style="width:100px" value="<?php echo $date?>"/>
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br>
        <span class="textfieldRequiredMsg">El Campo Es Requerido.</span>
		<span class="textfieldInvalidFormatMsg">Fromato Invalido.</span></td>
    </tr>


    <tr>
        <td class="etiqueta"><?php echo $leng['nomina']?>:</td>
		<td  id="select01">
			   <select name="tipo_nom" style="width:300px;">
     				   <option value=""> Seleccione...</option>
					   <?php
					    $query02 = mysql_query("SELECT nomina.co_cont, nomina.des_cont
												  FROM nomina WHERE nomina.tip_cont <> '4'", $cnn);
						   while($row02=(mysql_fetch_array($query02))){
						   echo '<option value="'.$row02[0].'">'.$row02[1].'</option>';
						   }
					   ?>
	           </select><img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br />
       	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span>
		</td>
    </tr>
    <tr>
        <td class="etiqueta">Usuarios:</td>
		<td  id="select02">
			   <select name="usuario_id" style="width:300px;">
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
		<td class="etiqueta">Filtro <?php echo $leng['trabajador']?>:</td>
		<td id="select11">
			<select id="paciFiltro" onchange="EstadoFiltro()" style="width:200px">
				<option value="TODOS"> TODOS</option>
				<option value="codigo"><?php echo $leng['ficha']?></option>
				<option value="cedula"><?php echo $leng['ci']?></option>
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
        <td class="etiqueta">Tipo Reporte:</td>
		<td  id="select03">
			   <select name="reporte" style="width:250px;">
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
var date01 = new Spry.Widget.ValidationTextField("date01", "date", {format:"dd-mm-yyyy", hint:"dd-mm-yyyy", validateOn:["blur", "change"], useCharacterMasking:true});
/*
var date02 = new Spry.Widget.ValidationTextField("date02", "date", {format:"dd-mm-yyyy", hint:"dd-mm-yyyy", validateOn:["blur", "change"], useCharacterMasking:true});*/
var select01 = new Spry.Widget.ValidationSelect("select01", {validateOn:["blur", "change"]});
var select02 = new Spry.Widget.ValidationSelect("select02", {validateOn:["blur", "change"]});
var select03 = new Spry.Widget.ValidationSelect("select03", {validateOn:["blur", "change"]});
var select11 = new Spry.Widget.ValidationSelect("select11", {validateOn:["blur", "change"]});

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
