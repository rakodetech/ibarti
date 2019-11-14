<script language="JavaScript" type="text/javascript">
	function Capta_huella_cl(valor){
		var links = "ajax/Add_capta_huella_ubic.php";
		ajax=nuevoAjax();
			ajax.open("POST", links, true);
			ajax.onreadystatechange=function() {
				if (ajax.readyState==4){
				  document.getElementById("capta_huella").innerHTML = ajax.responseText;
				}
			}
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        ajax.send("cod="+valor+"");
}
/*
	function CH_new_template(){
		var cedula     = document.getElementById("cedula").value;
		var links = "ajax/Add_capta_huella_new_template.php";
		$("#listarX").html("<img src='imagenes/loading.gif' /> Procesando, espere por favor...");
		ajax=nuevoAjax();
			ajax.open("POST", links, true);
			ajax.onreadystatechange=function() {
				if (ajax.readyState==4){
				//  document.getElementById("capta_huella").innerHTML = ajax.responseText;
				ActualizarDet(cedula);
				}
			}
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        ajax.send("cod=cod");
}

*/
function Borrar(metodo, valor ){
	if (confirm("¿ Esta Seguro Eliminar Este Registro")) {

	var cedula     = document.getElementById("cedula").value;
	var huella     = encodeURIComponent(document.getElementById("huella"+valor+"").value);

	var archivo    = "sc_maestros/sc_ficha_huella.php";
    var proced      = "p_ficha_huella";

		ajax=nuevoAjax();
			ajax.open("POST", archivo, true);
			ajax.onreadystatechange=function()
			{
				if (ajax.readyState==4){
				ActualizarDet(cedula);
				}
			}
			ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			ajax.send("cedula="+cedula+"&cedula_old=&huella="+huella+"&huella_old=&href=&usuario=&metodo="+metodo+"&proced="+proced+"");
		 }
	}


	function Capturar(){
	var cedula       =document.getElementById("cedula").value;
	var capta_huella =document.getElementById("capta_huella").value;
	var proced       ="p_ch_huella_add";
	var archivo      ="scripts/sc_ficha_06.php";

	var campo01 = 1;
    var errorMessage = 'Debe Seleccionar Todo Los Campos';
	$("#listarX").html("<img src='imagenes/loading.gif' /> Procesando, espere por favor...");

     if(capta_huella=='') {
	 var campo01 = campo01+1;
	}
		if(campo01 == 1){
			ajax=nuevoAjax();
				ajax.open("POST", archivo, true);
				ajax.onreadystatechange=function()
				{
					if (ajax.readyState==4){
						setTimeout("ActualizarDet("+cedula+")", 30000);
					}
				}
				ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				ajax.send("cedula="+cedula+"&capta_huella="+capta_huella+"&proced="+proced+"");
		}else{
			alert(errorMessage);
		}
	}

	function ActualizarDet(codigo){
		var archivo  = "ajax/Add_ficha_06.php";
		ajax=nuevoAjax();
			ajax.open("POST", archivo, true);
			ajax.onreadystatechange=function()
			{
				if (ajax.readyState==4){
				document.getElementById("listarX").innerHTML = ajax.responseText;

				}
			}
			ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			ajax.send("codigo="+codigo+"");

	}
</script>
<?php
// require_once('autentificacion/aut_verifica_menu.php');
$archivo = "pestanas/add_ficha&Nmenu=".$Nmenu."&codigo=".$codigo."&mod=$mod&pagina=4&metodo=modificar";
$proced      = "p_huella_add";

	$sql06 = " SELECT ficha_huella.cedula, ficha_huella.huella, ficha_huella.fec_us_ing
               FROM ficha_huella
              WHERE cedula = '$cedula'
           ORDER BY 3 DESC ";

	 ?>
<form action="scripts/sc_ficha_05.php" method="post" name="add" id="add">
  <fieldset class="fieldset">
  <legend>Agregar Huella Del Trabajador </legend>
     <table width="80%" align="center">
   <tr>
      <td class="etiqueta">Cliente:</td>
      	<td id="select01"><select name="cliente_ch" id="cliente_ch" style="width:250px" onchange="Capta_huella_cl(this.value)">
							<option value="">Seleccione...</option>
          <?php  	$sql = " SELECT DISTINCT clientes.codigo, clientes.nombre
		                       FROM clientes, clientes_ubicacion, clientes_ub_ch
                              WHERE clientes.`status` = 'T'
                                AND clientes.codigo = clientes_ubicacion.cod_cliente
                                AND clientes_ubicacion.codigo = clientes_ub_ch.cod_cl_ubicacion
                           ORDER BY 2 ASC ";
	            	$query = $bd->consultar($sql);
		           // $query = $bd->consultar($sql_cliente_ch);

            		while($datos=$bd->obtener_fila($query,0)){
		  ?>
          <option value="<?php echo $datos[0];?>"><?php echo $datos[1];?></option>
          <?php }?>
        </select><img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br />
        	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
	</tr>

   <tr>
      <td class="etiqueta">Capta Huella:</td>
      	<td id="select02"><select name="capta_huella" id="capta_huella" style="width:250px">
						   <option value="">Seleccione...</option>
                          </select>
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br />
        	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
	</tr>

         <tr>
            <td height="8" colspan="2" align="center"><hr></td>
         </tr>
  </table>
<div align="center"><span class="art-button-wrapper">
                    <span class="art-button-l"> </span>
                    <span class="art-button-r"> </span>
                <input type="button" name="salvar"  id="salvar" value="Enviar" onclick="Capturar()" class="readon art-button" />
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
            <input name="metodo" type="hidden"  value="<?php echo $metodo;?>" />
            <input name="pestana" type="hidden"  value="huella" />
            <input name="proced" id="proced" type="hidden"  value="<?php echo $proced;?>" />
		    <input name="codigo" type="hidden"  value="<?php echo $codigo;?>" />
            <input type="hidden" name="usuario" id="usuario" value="<?php echo $usuario;?>"/>
	        <input name="href" type="hidden" value="../inicio.php?area=<?php echo $archivo ?>"/>
</div>
  </fieldset>

  <fieldset class="fieldset">
  <legend>Huella Del Trabajador </legend>
  <div id="listarX"><table width="80%" border="0" align="center"><tr class="fondo01">
			<th width="25%" class="etiqueta">Fecha </th>
   			<th width="60%" class="etiqueta">Huella</th>
		    <th width="15%"><span class="art-button-wrapper">
                    <span class="art-button-l"> </span>
                    <span class="art-button-r"> </span>
                    <input type="button" name="verificar" id="verificar" value="Verificar Huella"
                    onClick="ActualizarDet('<?php echo $cedula;?>')" class="readon art-button" /></span></th></tr>

    <?php
        $query = $bd->consultar($sql06);
        $i     = 0;
        $valor = 0;
  		while($datos=$bd->obtener_fila($query,0)){
		$i++;
			if ($valor == 0){
				$fondo = 'fondo01';
				$valor = 1;
			}else{
				 $fondo = 'fonddo02';
				 $valor = 0;
			}

			$borrar = 	 "'".$datos[0]."'";
			$modificar = 	 "'modificar', '".$i."'";
			$borrar    = 	 "'eliminar', '".$i."'";
        echo '<tr class="'.$fondo.'">
                  <td>'.$datos['fec_us_ing'].'</td>
                  <td><input type="text" id="huella'.$i.'" style="width:350px" maxlength="64"
				       value="'.$datos['huella'].'"/><input type="hidden" id="huella_old'.$i.'" maxlength="64" value="'.$datos['huella'].'"/>
		  </td><td align="center"><img src="imagenes/borrar.bmp" alt="Detalle" title="Borrar Registro" width="20px" height="20px" border="null"
			   onclick="Borrar('.$borrar.')" class="imgLink" /></td>
	</tr>';
        }?>
	</table>
  </div>
  </fieldset>
  <input type="hidden" id="cedula" value="<?php echo $cedula;?>" />
 </form>
