<?php
$sql01 =	"SELECT clientes_ub_alcance.cod_producto, productos.descripcion producto, clientes_ub_alcance.cantidad
                   FROM clientes_ub_alcance, productos
                  WHERE clientes_ub_alcance.cod_producto = productos.item
				  AND clientes_ub_alcance.cod_cl_ubicacion = '$codigo'";
?>
<script language="javascript">
    function agregarProducto(auto, metodo) {
        var cod_producto = document.getElementById("stdID" + auto + "").value;
		var codigo = document.getElementById("codigo_ubic").value;
		var cantidad = document.getElementById("cantidad").value;
        var errorMessage = 'Debe Ingresar minimo 1 producto ';
        var campo01 = 0;
        if (!cod_producto) {
            campo01++;
		}
		if (cantidad == 0) {
            campo01++;
        }
        if (campo01 == 0) {
            //var href = "inicio.php?area=maestros/Cons_Servicio_Tipo";
            var valor = "scripts/sc_cl_ubic_validar_alcance.php";
            ajax = nuevoAjax();
            ajax.open("POST", valor, true);
            ajax.onreadystatechange = function () {
                if (ajax.readyState == 4) {
                    // document.getElementById("Cont_mensaje").innerHTML = ajax.responseText;
                    //window.location.href=""+href+"";
                    if (ajax.responseText == 0) {
                        ValidarSubmit(auto, metodo);
                    } else {
                        alert("Ya Existe este Registro (" + cod_producto + ")");
                    }
                }
            }
            ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            ajax.send("cod_producto=" + cod_producto + "&codigo=" + codigo + "");
        } else {
            alert(errorMessage);
        }
    }

	function ValidarSubmit(auto, metodo) {
		var cod_ubic = document.getElementById("codigo_ubic").value;
		var usuario = document.getElementById("usuario").value;
		var cod_producto = document.getElementById("stdID" + auto + "").value;
		var cantidad = document.getElementById("cantidad" + auto + "").value;

		var valor = "scripts/sc_cl_ubic_alcance.php";
		var proced = "p_cl_ubic_alcance";
		ajax = nuevoAjax();
		ajax.open("POST", valor, true);
		ajax.onreadystatechange = function() {
			if (ajax.readyState == 4) {
				document.getElementById("Cont_mensaje").innerHTML = ajax.responseText;
				if ((metodo == "agregar") || (metodo == "eliminar")) {
					ActualizarDet(cod_ubic);
				}else{
					toastr.success('Actualizado con exito.');
				}
				//window.location.href=""+href+"";
			}
		}
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		ajax.send("codigo=" + cod_ubic + "&cod_producto=" + cod_producto + "&cantidad=" + cantidad + "&usuario=" + usuario + "&href=''&metodo=" + metodo + "&proced=" + proced + "");
	}

	function Borrar(auto, metodo) {
		if (confirm("� Esta Seguro Eliminar Este Registro")) {
			var cod_ubic = document.getElementById("codigo_ubic").value;
            var cod_producto = document.getElementById("stdID" + auto + "").value;
			var cantidad = document.getElementById("cantidad" + auto + "").value;

			var ususario = "";

			var valor = "scripts/sc_cl_ubic_alcance.php";
			var proced = "p_cl_ubic_alcance";

			ajax = nuevoAjax();
			ajax.open("POST", valor, true);
			ajax.onreadystatechange = function() {
				if (ajax.readyState == 4) {
					document.getElementById("Cont_mensaje").innerHTML = ajax.responseText;
					ActualizarDet(cod_ubic);
					//window.location.href=""+href+"";
				}
			}
			ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			ajax.send("codigo=" + cod_ubic + "&cod_producto=" + cod_producto + "&cantidad=" + cantidad + "&usuario=" + usuario + "&href=''&metodo=" + metodo + "&proced=" + proced + "");
		} else {
			alert(errorMessage);
		}
	}

	function ActualizarDet(codigo) {
		var valor = "ajax/Add_cl_ubic_alcance.php";
		ajax = nuevoAjax();
		ajax.open("POST", valor, true);
		ajax.onreadystatechange = function() {
			if (ajax.readyState == 4) {
				toastr.success('Actualizado con exito.');
				document.getElementById("Contenedor03").innerHTML = ajax.responseText;
			}
		}
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		ajax.send("codigo=" + codigo + "");
	}
</script>
<div align="center" class="etiqueta_title"> ALCANCE </div>
<hr />
<div id="Cont_mensaje" class="mensaje"></div>
<div>
     <table width="60%" border="0" align="center">
		<tr class="fondo01">
			<!-- <th width="20%" style="display:none" class="etiqueta">Codigo Ubicacion</th> -->
			<th width="60%" class="etiqueta"><?php echo $leng['producto'];?>
            <input type="hidden" name="producto" id="stdID" value=""/></th>
            <th width="20%" class="etiqueta">Cantidad</th>
			<th width="20%"><img src="imagenes/loading2.gif" alt="Agregar Registro" width="40" height="40" title="Agregar Registro" border="null" class="imgLink" /></th>
		</tr>
		<tr class="fondo02">
        <td>       
        <input type="text" id="codigo_producto" value="" placeholder="Ingrese Dato del <?php echo $leng['producto'];?>" required style="width:450px"/>
      </td>
      <td>
       <input type="number" id="cantidad" style="width:100px" value="1" min="1"  required placeholder="">
		</td>	
		<td><span class="art-button-wrapper">
					<span class="art-button-l"> </span>
					<span class="art-button-r"> </span>
					<input type="button" name="submit" id="submit" value="Agregar" class="readon art-button" onclick="agregarProducto('', 'agregar')" />
				</span></td>
		</tr>
		</table>
		<table id="Contenedor03" width="60%" border="0" align="center">
		<tr>
			<td colspan="3" class="etiqueta_title">Listado</td>
		</tr>
		<?php
		$query = $bd->consultar($sql01);
		$i = 0;
		$valor = 0;
		while ($datos = $bd->obtener_fila($query, 0)) {
			$i++;
			if ($valor == 0) {
				$fondo = 'fondo01';
				$valor = 1;
			} else {
				$fondo = 'fonddo02';
				$valor = 0;
			}
			$modificar = 	 "'" . $i . "', 'modificar'";
			$borrar    = 	 "'" . $i . "', 'eliminar' ";
			echo '<tr class="' . $fondo . '">
				  <td>     
                  <input type="text" id="codigo_producto'.$i.'" value="'.$datos['producto'].'" disabled  style="width:450px"/>
                  <input type="hidden" name="trabajador" id="stdID'.$i.'" value="'.$datos['cod_producto'].'"/>
                </td>
                <td>
                 <input type="number" id="cantidad'.$i.'" style="width:100px"  value="'.$datos['cantidad'].'" min="1">
			   </td><td align="center"><img src="imagenes/actualizar.bmp" alt="Actualizar" title="Actualizar Registro" border="null" width="20px" height="20px" class="imgLink" onclick="ValidarSubmit('.$modificar.')" />&nbsp;
		  <img src="imagenes/borrar.bmp" alt="Detalle" title="Borrar Registro" width="25" height="25" border="null"
			   onclick="Borrar(' . $borrar . ')" class="imgLink" />
		  </td>
	</tr>';
		} ?>
	</table>
</div>
<div align="center">
	<input name="metodo" type="hidden" value="<?php echo $metodo; ?>" />
	<input type="hidden" name="usuario" value="<?php echo $usuario; ?>" />

	<input type="hidden" id="cod_ubic_alcance" name="codigo" value="<?php echo $codigo; ?>" />
	<input type="hidden" id="i" value="<?php echo $i; ?>" />
</div>
<br />
<br />

<script language="JavaScript" type="text/javascript">
  new Autocomplete("codigo_producto", function() { 
    this.setValue = function(id) {
      $("#stdID").val(id);
    }
    if (this.value.length < 1) return ;
    return "autocompletar/tb/producto_base_serial.php?q="+this.text.value +"&filtro=codigo"});
  </script>