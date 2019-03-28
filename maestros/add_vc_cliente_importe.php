<?php
$metodo = $_GET['metodo'];
$archivo = $_GET['archivo'];
$Nmenu = 360;
$mod   = $_GET['mod'];
$archivo2 = "../inicio.php?area=maestros/Cons_$archivo&Nmenu=".$Nmenu."&mod=".$mod."";
$titulo = " ".$leng['cliente']." Importe ";
$metodo  =$_GET['metodo'];
require_once('autentificacion/aut_verifica_menu.php');


$proced      = "p_vc_cliente_importe";
if($metodo == 'modificar'){
   $titulo      = "Modificar $titulo";
   $codigo      = $_GET['codigo'];
	$bd = new DataBase();

	$sql =   "SELECT clientes_importe.fecha,
	                 clientes_importe.cod_cliente,  clientes.nombre AS cliente,
                     clientes_importe.cod_ubicacion, clientes_ubicacion.descripcion AS ubicacion,
	                 clientes_importe.cod_cargo, cargos.descripcion AS cargo,
                     clientes_importe.cod_turno, turno.descripcion AS turno,
					 clientes_importe.importe, clientes_importe.observacion,
					 clientes_importe.fec_us_mod, clientes_importe.fec_us_ing
                FROM clientes_importe ,clientes ,  clientes_ubicacion,  cargos , turno
               WHERE clientes_importe.codigo =  '$codigo'
                 AND clientes_importe.cod_ubicacion = clientes_ubicacion.codigo
			     AND clientes_importe.cod_cliente = clientes.codigo
                 AND clientes_importe.cod_cargo = cargos.codigo
                 AND clientes_importe.cod_turno = turno.codigo
		    ORDER BY 2 DESC ";
	$query = $bd->consultar($sql);
	$result = $bd->obtener_fila($query,0);

    $fecha        = conversion($result['fecha']);
    $cod_cliente  = $result['cod_cliente'];
    $cliente      = $result['cliente'];
    $cod_ubicacion = $result['cod_ubicacion'];
    $ubicacion    = $result['ubicacion'];
    $cod_cargo    = $result['cod_cargo'];
    $cargo        = $result['cargo'];
    $cod_turno    = $result['cod_turno'];
    $turno        = $result['turno'];
	$importe      = $result['importe'];
    $observacion   = $result['observacion'];

	}else{
    $titulo       = "Agregar $titulo";
    $codigo       = '';
    $fecha        = '';
    $cod_cliente  = '';
    $cliente      = 'Seleccione...';
    $cod_ubicacion = '';
    $ubicacion    = 'Seleccione...';
    $cod_cargo    = '';
    $cargo        = 'Seleccione...';
	$cod_turno    = '';
    $turno        = 'Seleccione...';
	$importe      = '';

    $observacion   = '';
	$activo      = 'T';
	}?>

<form action="sc_maestros/sc_<?php echo $archivo;?>.php" method="post" name="add" id="add" enctype="multipart/form-data">

     <table width="80%" align="center">
         <tr valign="top">
		     <td height="23" colspan="2" class="etiqueta_title" align="center"><?php echo $titulo;?></td>
         </tr>
         <tr>
    	       <td height="8" colspan="2" align="center"><hr></td>
     	</tr>
	 <tr>
      <td class="etiqueta">Fecha:</td>
    <td id="fecha01">
          	<input type="text" name="fecha" value="<?php echo $fecha;?>" size="12" /><br />
            <span class="textfieldRequiredMsg">La Fecha Es Requerida.</span>
            <span class="textfieldInvalidFormatMsg">El Formato Es Invalido</span>
      </td>
    </tr>
    <tr>
      <td class="etiqueta"><?php echo $leng['cliente']?>:</td>
      	<td id="select01"><select name="cliente" id="cliente" style="width:250px;"
                                  onchange="Add_ajax01(this.value, 'ajax/Add_cl_ubicacion.php', 'select02')">
					<option value="<?php echo $cod_cliente;?>"><?php echo $cliente;?></option>
					<?php
				$sql01 = "SELECT clientes.codigo, clientes.nombre FROM clientes
				           WHERE clientes.`status` = 'T'
						     AND clientes.codigo <> '$cod_cliente'
						ORDER BY 2 ASC";
	   			$query01 = $bd->consultar($sql01);
		 		while($row01=$bd->obtener_fila($query01,0)){
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
			   }?></select><br /><span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
    </tr>
    <tr>
      <td class="etiqueta"><?php echo $leng['ubicacion']?>:</td>
      	<td id="select02"><select name="ubicacion" style="width:250px" >
                                  <option value="<?php echo $cod_ubicacion;?>"><?php echo $ubicacion;?></option>
          <?php
			    	$sql   = "SELECT clientes_ubicacion.id, clientes_ubicacion.descripcion
                                           FROM clientes_ubicacion
						                  WHERE clientes_ubicacion.co_cli = '$cliente'
						                    AND clientes_ubicacion.`status` = 'T'
						                  ORDER BY 2 ASC";
		            $query = $bd->consultar($sql);
            		while($row02 = $bd->obtener_fila($query,0)){
		  ?>
          <option value="<?php echo $row02[0];?>"><?php echo $row02[1];?></option>
          <?php }?>
        </select><br /><span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
    </tr>
    <tr>
      <td class="etiqueta">Cargo:</td>
      	<td id="select03"><select name="cargo" id="cargo" style="width:250px;">
					<option value="<?php echo $cod_cargo;?>"><?php echo $cargo;?></option>
					<?php
				$sql01 = "SELECT cargos.codigo, cargos.descripcion FROM cargos
				               WHERE cargos.`status` = 'T'
							     AND cargos.codigo <> '$cod_cargo' ORDER BY 2 ASC";
	   			$query01 = $bd->consultar($sql01);
		 		while($row01=$bd->obtener_fila($query01,0)){
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
			   }?></select><br /><span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
    </tr>
    <tr>
      <td class="etiqueta">Turno:</td>
      	<td id="select04"><select name="turno" id="turno" style="width:250px;">
				   	<option value="<?php echo $cod_turno;?>"><?php echo $turno;?></option>
					<?php
					$sql01 = "SELECT turno.codigo, turno.descripcion FROM turno
				               WHERE turno.`status` = 'T'
						         AND turno.codigo <> '$cod_turno' ORDER BY 2 ASC";
	   			$query01 = $bd->consultar($sql01);
		 		while($row01=$bd->obtener_fila($query01,0)){
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
				   }?></select><br /><span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
    </tr>
    <tr>
      <td class="etiqueta">Importe:</td>
      <td id="input01"><input type="text" name="importe"  style="width:100px" value="<?php echo $importe;?>" /><br />
  	      <span class="textareaRequiredMsg">El Campo es Requerido.</span>
           <span class="textfieldInvalidFormatMsg">El Formato Es Invalido</span></td>
    </tr>
    <tr>
      <td class="etiqueta">Observacion:</td>
      <td id="textarea01"><textarea  name="observacion" cols="50" rows="3"><?php echo $observacion;?></textarea>
        <span id="Counterror_mess1" class="texto">&nbsp;</span> <br />
        <span class="textareaRequiredMsg">El Campo es Requerido.</span>
        <span class="textareaMinCharsMsg">Debe Escribir mas de 10 caracteres.</span>
        <span class="textareaMaxCharsMsg">El maximo de caracteres permitidos es 255.</span></td>
    </tr>
         <tr>
            <td height="8" colspan="2" align="center"><hr></td>
         </tr>
  </table>
  <div align="center"><span class="art-button-wrapper">
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
            <input name="usuario" type="hidden" value="<?php echo $usuario;?>" />
	        <input name="href" type="hidden" value="<?php echo $archivo2;?>"/>
            <input name="codigo" type="hidden" value="<?php echo $codigo;?>"/>
   </div>
</form>
</body>
</html>
<script type="text/javascript">
var fecha01 = new Spry.Widget.ValidationTextField("fecha01", "date", {format:"dd-mm-yyyy", hint:"DD-MM-AAAA",
    validateOn:["blur", "change"], useCharacterMasking:true});

var select01 = new Spry.Widget.ValidationSelect("select01", {validateOn:["blur", "change"]});
//var select02 = new Spry.Widget.ValidationSelect("select02", {validateOn:["blur", "change"]});
var select03 = new Spry.Widget.ValidationSelect("select03", {validateOn:["blur", "change"]});
var select04 = new Spry.Widget.ValidationSelect("select04", {validateOn:["blur", "change"]});

var input01  = new Spry.Widget.ValidationTextField("input01", "currency", {format:"comma_dot", validateOn:["blur", "change"], useCharacterMasking:true });

var textarea01 = new Spry.Widget.ValidationTextarea("textarea01", {maxChars:255, validateOn:["blur", "change"],
 counterType:"chars_count", counterId:"Counterror_mess1", useCharacterMasking:false , isRequired:false});
 </script>
