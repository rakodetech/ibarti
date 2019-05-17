<?php
$Nmenu = '401';
require_once('autentificacion/aut_verifica_menu.php');
$titulo = " CONTROL DE SISTEMA ";
	$bd = new DataBase();

$archivo = "actualizar_datos";
$archivo2 = "../inicio.php?area=formularios/Cons_$archivo&Nmenu=$Nmenu&mod=".$_GET['mod']."";

$proced = "p_control";
$metodo = "modificar";
$titulo = "MODIFICAR $titulo";

$sql = " SELECT control.fec_cliente, control.fec_ficha, control.fec_region, control.fec_concepto,
                control.fec_cargo
		   FROM control";

   $query = $bd->consultar($sql);
?>
<br>
<div align="center" class="etiqueta_title"> FECHA DE LA ULTIMA ACTUALIZACION </div>
<hr />
<br/>
	<table width="98%" border="0" align="center">
		<tr class="fondo00">
			<th class="etiqueta"><?php echo $leng['cliente'];?></th>
			<th class="etiqueta"><?php echo $leng['ficha'];?></th>
			<th class="etiqueta"><?php echo $leng['region'];?></th>
			<th class="etiqueta"><?php echo $leng['concepto']?></th>
            <th class="etiqueta">Cargos</th>
		</tr>
    <?php
	$valor = 0;
while ($datos=$bd->obtener_fila($query,0)){
			if ($valor == 0){
		$fondo = 'fondo01';
		$valor = 1;
	}else{
		 $fondo = 'fondo02';
		 $valor = 0;
	}
  	   $confir = "'".$datos[0]."'";
        echo '<tr class="'.$fondo.'">
                  <td>'.$datos["fec_cliente"].'</td>
                  <td>'.$datos["fec_ficha"].'</td>
				  <td>'.$datos["fec_region"].'</td>
				  <td>'.$datos["fec_concepto"].'</td>
				  <td>'.$datos["fec_cargo"].'</td>';
        }
    ?>
	</table>
<br/>
<br />
<div align="center">
</div>
<br>
<div align="center" class="etiqueta_title">NUEVA ACTUALIZACION</div>
<hr />
<div id="Contendor01" class="mensaje"></div>
<fieldset>
	<legend>Subir Archivos</legend>
	<br />
	<form action="scripts/sc_actualizar_datos.php" method="post" name="form1" enctype="multipart/form-data">
   <table width="70%" align="center">
      <tr>
        <td class="etiqueta" width="30%">Tabla para Actualizar:</td>
 		<td  id="select01" width="70%">
		<select name="archivo"  style="width:300px;">
          <option value=""> Seleccione...</option>
          <?php  	$sql = " SELECT codigo, descripcion, archivo FROM actualizar WHERE status = 'T'
                              ORDER BY 2 ASC ";
		            $query = $bd->consultar($sql);
            		while($datos=$bd->obtener_fila($query,0)){
		  ?>
          <option value="<?php echo $datos[0];?>"><?php echo $datos[2].' ('.utf8_decode($datos[1]).')';?></option>
          <?php }?>
       </select>
 		  <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br />
       	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
      </tr>
	  <tr>
		  <td class="etiqueta" >Archivo:</td>
		  <td id="input01"><input type="file" name="file" size="35"><br />
			<img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br>
			<span class="textfieldRequiredMsg">Debe De Selecionar Un Archivo.</span>
			<span class="textfieldMinCharsMsg">Debe Escribir m�nimo 2 Caracteres.</span></td>
    </tr>
</table>
<div><input type="hidden" name="usuario" value="<?php echo $usuario;?>" />
     <input type="hidden" name="href" value="<?php echo $archivo2;?>" /></div>
<div align="center"><span class="art-button-wrapper">
                    <span class="art-button-l"> </span>
                    <span class="art-button-r"> </span>
                <input type="submit" name="salvar"  id="salvar" value="Procesar" class="readon art-button" />
                </span></div>
</form>
</fieldset>
<script type="text/javascript">
var input01  = new Spry.Widget.ValidationTextField("input01", "none", {minChars:2, validateOn:["blur", "change"]});
var select01 = new Spry.Widget.ValidationSelect("select01", {validateOn:["blur", "change"]});
</script>
