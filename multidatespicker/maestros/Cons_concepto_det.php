<script language="javascript" type="text/javascript">
	function Actualizar01(){
		var codigo     = document.getElementById("codigo").value;  // REGION
		var rol   = document.getElementById("rol").value; // CONCEPTOS
        var categoria  = document.getElementById("categoria").value;
		var Contenedor = "Contenedor_Resp";
		var valor      = "ajax/concepto_det.php";

		if ((codigo != "")&&(rol != "")){
			ajax=nuevoAjax();
				ajax.open("POST", valor, true);
				ajax.onreadystatechange=function(){
					if (ajax.readyState==4){
					document.getElementById(Contenedor).innerHTML = ajax.responseText;
						//window.location.href=""+href+"";  	 // window.location.reload();
					}
				}
				ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				ajax.send("codigo="+codigo+"&rol="+rol+"&categoria="+categoria+"");
		}
	}

	function Actualizar03(campo_id){
		document.getElementById("metodo").value = campo_id;
		if (campo_id == "renglones"){
			alert(" Solo se Modificara el Concepto para EL Rol Actual");
		}else{
			alert(" Se Modificara el Concepto Para Todolos Roles");
		}
	}
</script>
<?php
$Nmenu = '304';
require_once('autentificacion/aut_verifica_menu.php');
$bd = new DataBase();
$codigo    = $_GET['codigo'];
$categoria = $_GET['categoria'];
//$archivo = "concepto_profit&Nmenu=".$Nmenu."&id=".$codigo."";
$archivo = "concepto_det&Nmenu=".$Nmenu."&codigo=".$codigo."";

	$sql = " SELECT conceptos.abrev, conceptos.descripcion FROM conceptos WHERE conceptos.codigo = '$codigo' ";
   $query = $bd->consultar($sql);
$row01=$bd->obtener_fila($query,0) ;

	$sql_rol  = " SELECT roles.codigo, roles.descripcion FROM roles
	               WHERE roles.`status` = 'T'
		            ORDER BY 2 ASC ";

	$sql_concepto = " SELECT conceptos.codigo, CONCAT(conceptos.descripcion,' -(', conceptos.abrev,')') descripcion  FROM conceptos
	                  WHERE conceptos.`status` = 'T'
				    ORDER BY conceptos.`status`, conceptos.descripcion ASC ";
?>
<form action="sc_maestros/Concepto.php" method="post" name="add" id="add">
  <fieldset class="fieldset">
  <legend>Filtro por <?php echo $leng['region']." Y ".$leng['concepto']?>:</legend>
     <table width="98%" align="center">
     <tr>
      <td class="etiqueta"><?php echo $leng['rol']?>:</td>
      	<td  id="select02"><select name="rol" id="rol" style="width:240px" onchange="Actualizar01()">
							<option value="">SELECCIONE...</option>
          <?php
		   $query02 = $bd->consultar($sql_rol);
			while($row02=$bd->obtener_fila($query02,0)){
		  ?>
          <option value="<?php echo $row02[0];?>"><?php echo $row02[1];?></option>
          <?php }?>
        </select><br />
        	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
      <td class="etiqueta"><?php echo $leng['concepto']?>:</td>
      <td id="select01"><select name="codigo" id="codigo" style="width:240px" onchange="Actualizar01()">
							<option value="<?php echo $codigo ?>"><?php echo ''.$codigo.' - '.$row01[1];?></option>
          <?php

		   $query02 = $bd->consultar($sql_concepto);
				  while($row02=$bd->obtener_fila($query02,0)){
		  ?>
          <option value="<?php echo $row02[0];?>"><?php echo $row02[0].' - '.$row02[1];?></option>
          <?php }?>
        </select><br /><span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
    </tr>
     <tr>
      <td class="etiqueta">Actualizacion Masivo De <?php echo $leng['rol']?>:</td>
      	<td  id="select03"><select name="masivo" id="masivo" style="width:150px" onchange="Actualizar03(this.value)">
							<option value="renglones">NO</option>
                            <option value="renglones_masivo">SI</option>
						</option>
        </select><br />
       	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>

      <td class="etiqueta">CATEGOR&Iacute;A:</td>
     <td id="select04"><select name="categoria" id="categoria" style="width:240px" onchange="Actualizar01( )">
		<?php /*<option value="<?php echo $codigo ?>"><?php echo ''.$codigo.' - '.utf8_decode($row01[1]);?></option> */ ?>
          <?php
		   if (isset($categoria) && ($categoria !='')){
			$sql = " SELECT concepto_categoria.codigo, concepto_categoria.descripcion FROM concepto_categoria
					  WHERE concepto_categoria.`status` = 'T' AND concepto_categoria.codigo = '$categoria' ";
		   $query02 = $bd->consultar($sql);
			    $row02=$bd->obtener_fila($query02,0);
		  echo '<option value="'.$row02[0].'">'.$row02[0].' - '.$row02[1].'</option>';
		   }
			$sql = " SELECT concepto_categoria.codigo,concepto_categoria.descripcion FROM concepto_categoria
		              WHERE concepto_categoria.`status` = 'T'
					  AND concepto_categoria.`detalle` = 'T'
					  AND concepto_categoria.codigo <> '$categoria' ORDER BY 2 ASC ";
		   $query02 = $bd->consultar($sql);

			while($row02=$bd->obtener_fila($query02,0)){
		  ?>
          <option value="<?php echo $row02[0];?>"><?php echo $row02[0].' - '.$row02[1];?></option>
          <?php }?>
        </select><br />
        	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>

    </tr>
	 <tr>
		<td height="8" colspan="4" align="center"><hr></td>
	 </tr>
   	 <tr>
		<td colspan="4" id="Contenedor_Resp" align="center"></td>
  </table>
  </fieldset>
  <div align="center">
  <span class="art-button-wrapper">
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
                <input type="button" id="volver" value="Volver"
                onClick="Vinculo('inicio.php?area=maestros/Cons_concepto&Nmenu=<?php echo $Nmenu;?>')" class="readon art-button" />
                </span>

		<input name="metodo" id="metodo" type="hidden"  value="renglones" />
        <input name="valor"  type="hidden"  value="" />
        <input name="semana"  type="hidden"  value="" />
        <input name="abrev"  type="hidden"  value="" />
        <input name="descripcion"  type="hidden"  value="" />
        <input name="asist_perfecta"  type="hidden"  value="" />
        <input name="proced"  type="hidden"  value="" />
        <input name="activo"  type="hidden"  value="" />
        <input name="usuario" type="hidden"  value="<?php echo $usuario;?>" />
        <input name="href" type="hidden" value="../inicio.php?area=maestros/Cons_<?php echo $archivo ?>"/>
  </div>
</form>
<script type="text/javascript">

	var select01 = new Spry.Widget.ValidationSelect("select01", {validateOn:["blur", "change"]});
	var select02 = new Spry.Widget.ValidationSelect("select02", {validateOn:["blur", "change"]});
	var select03 = new Spry.Widget.ValidationSelect("select03", {validateOn:["blur", "change"]});
	var select04 = new Spry.Widget.ValidationSelect("select04", {validateOn:["blur", "change"]});

	function spryValidarDec(ValorN){
	// alert(ValorN);
 		var ValorN = new Spry.Widget.ValidationTextField(ValorN, "currency", {format:"comma_dot",validateOn:["blur"], useCharacterMasking:true, isRequired:false});
	}
</script>
