<link rel="stylesheet" type="text/css" href="latest/stylesheets/autocomplete.css" />
<script type="text/javascript" src="latest/scripts/autocomplete.js"></script>
<?php
$Nmenu   = 590;
$mod     =  $_GET['mod'];
$titulo  = " REPORTE DOCUMENTO HTML ";
$archivo = "reportes/rp_preing_html_det.php?Nmenu=$Nmenu&mod=$mod";
require_once('autentificacion/aut_verifica_menu.php');
require_once('sql/sql_report.php');
$bd = new DataBase();
?>
<div align="center" class="etiqueta_title"><?php echo $titulo;?> </div>
<div id="Contenedor01"></div>
<form name="form_reportes" id="form_reportes" action="<?php echo $archivo;?>"  method="post" target="_blank">
<hr /><table width="100%" class="etiqueta">
        <tr><td width="10%">Repote:</td>
		 <td width="14%" id="select10"><select name="reporte" id="reporte" style="width:120px;" required>
				                       <option value="">Seleccione...</option>
					<?php
		   			$query01 = $bd->consultar("SELECT men_reportes_html.codigo, men_reportes_html.descripcion
                                                 FROM men_reportes_html
                                                WHERE men_reportes_html.cod_modulo = '$mod'
                                                  AND men_reportes_html.`status` = 'T'
												ORDER BY 2 DESC");
		 		while($row01=$bd->obtener_fila($query01,0)){
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
			   }?></select></td>

     		 <td width="10%">Filtro <?php echo $leng['trab']?>.:</td>
		<td id="select01" width="14%">
			<select id="paciFiltro"  style="width:120px" onchange="EstadoFiltro(this.value)">
				<option value="cedula"><?php echo $leng['ci']?></option>
				<option value="trabajador"><?php echo $leng['trabajador']?></option>
                <option value="nombres">Nombre</option>
                <option value="apellidos">Apellido</option>
		</select></td>
	  <td width="10%"><?php echo $leng['trabajador']?>:</td>
      <td  width="14%"><input  id="stdName" type="text" size="22"  required />
	      <input type="hidden" name="trabajador" id="stdID" value="" required/></td>
  <td>&nbsp;<input type="hidden" name="Nmenu" id="Nmenu" value="<?php echo $Nmenu;?>" />
            <input type="hidden" name="mod" id="mod" value="<?php echo $mod;?>" />
            <input type="hidden" name="archivo" id="archivo" value="<?php echo $archivo;?>" />
            <input type="hidden" name="r_rol" id="r_rol" value="<?php echo $_SESSION['r_rol'];?>"/>
            <input type="hidden" name="r_cliente" id="r_cliente" value="<?php echo $_SESSION['r_cliente'];?>"/>
            <input type="hidden" name="usuario" id="usuario" value="<?php echo $_SESSION['usuario_cod'];?>"/></td>
          <td width="4%" id="cont_img"><span class="art-button-wrapper">
            <span class="art-button-l"> </span>
            <span class="art-button-r"> </span>
            <input type="submit" name="procesar" id="procesar" value="Procesar" class="readon art-button">
        </span></td>
      </tr>

</table><hr /><div id="listar">&nbsp;</div>
<div align="center"><br/>
        <span class="art-button-wrapper">
            <span class="art-button-l"> </span>
            <span class="art-button-r"> </span>
        <input type="button" name="salir" id="salir" value="Salir" onclick="Vinculo('inicio.php?area=formularios/index')"
               class="readon art-button">
        </span>&nbsp;
		
</div>
</form>
<script type="text/javascript">
	usuario   = $("#usuario").val();
	filtroValue = $("#paciFiltro").val();

    new Autocomplete("stdName", function() {
        this.setValue = function(id) {
            document.getElementById("stdID").value = id; // document.getElementsByName("stdID")[0].value = id;
        }
        if (this.isModified) this.setValue("");
        if (this.value.length < 1) return ;
          return "autocompletar/tb/ingreso.php?q="+this.text.value +"&filtro="+filtroValue+"&usuario="+usuario+""});
</script>
